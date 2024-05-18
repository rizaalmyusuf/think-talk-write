<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class T extends CI_Controller {
	public function __construct() {
			parent:: __construct();
			$this->load->model('CRUD_global');
	}

	public function index(){
		if ($this->session->userdata("logged_in") == true){
			if ($_SESSION['rl']=='administrator') {
				$this->session->set_flashdata('err','You are not a teacher.');
				redirect('admin');
			}elseif ($_SESSION['rl']=='t') {
				$data['dataProj'] = $this->CRUD_global->read('projects', array('teacher_id' => $_SESSION['id']),1);
				$this->load->view('t/vt_projects',$data);
			}elseif ($_SESSION['rl']=='sg') {
				$this->session->set_flashdata('err','You are not a teacher.');
				redirect('sg');
			}else {
				$this->session->set_flashdata('err','Unknow role, please try again!');
				redirect('login/logout');
			}
		} else {
			$this->sessionTimedOut();
		}
	}

	public function sessionTimedOut(){
		if ($this->session->userdata("logged_in") == false){
			$this->session->set_flashdata('err','Login first!');
			redirect('login');
		}
	}

	public function phaseSorting($temp){
		$rc=$temp->num_rows();
		$temp=$temp->result();
		$no=0;
		foreach ($temp as $key) {
			if($key->prev_phase==NULL){
				$FirstPhaseId=$key->id;
			}
		}
		foreach ($temp as $key) {
			if($key->id==$FirstPhaseId){
				$data[$no]=$key;
				$nextPhase=$key->next_phase;
				$no++;
			}
		}
		for ($i=0; $i<$rc; $i++) {
			foreach ($temp as $key) {
				if($nextPhase==$key->id){
					$data[$no]=$key;
					$nextPhase=$key->next_phase;
					$no++;
				}
			}
		}
		return $data;
	}

	public function completeCheck($ProjId){
		$check=$this->CRUD_global->queryRunning("SELECT completed FROM projects WHERE completed=1 AND id=$ProjId",0);
		if($check){
			$this->session->set_flashdata('err','This project has been completed, so you can\'t change anything in this project except delete this project.');
			redirect("t/detail/$ProjId");
		}
	}

	public function detail($id,$PhaseId=0){
		$this->sessionTimedOut();
		$data['proj'] = $this->CRUD_global->read('projects',array('id' => $id));
		$tempMorePhase = $this->CRUD_global->read('phases',array('project_id' => $id),1,1);
		if($tempMorePhase->num_rows()!=0){
			$data['morePhase'] = $this->phaseSorting($tempMorePhase);
		}else{
			$data['morePhase'] = $this->CRUD_global->read('phases',array('project_id' => $id),1);
		}
		if ($PhaseId!=0) {
			$q="SELECT answers.*,student_groups.id,student_groups.fullname,student_groups.member FROM student_groups INNER JOIN answers ON student_id=student_groups.id AND phase_id=$PhaseId";
			$data['moreGroup'] = $this->CRUD_global->queryRunning($q);
			$data['phase'] = $this->CRUD_global->read('phases',array('id' => $PhaseId));
			$this->load->view('t/vt_phase_detail',$data);
		}else{
			$data['moreGroup'] = $this->CRUD_global->read('student_groups',array('project_id' => $id),1);
			$this->load->view('t/vt_project_detail',$data);
		}
	}

	public function createProjConfirm(){
		$this->sessionTimedOut();
		$config['upload_path']          = './uploads/t/pretest/';
		$config['allowed_types']        = 'pdf|zip|doc|docx';
		$config['overwrite']						= TRUE;
		$config['file_name']						= 'Pretest'.$this->input->post('proj_name').'_'.$_FILES['pre']['name'];
		$config['max_size']             = 2048;

		$this->load->library('upload', $config);
		//Array ( [file_name] => pretest_PromNet.docx [file_type] => application/vnd.openxmlformats-officedocument.wordprocessingml.document [file_path] => /opt/lampp/htdocs/pjbl/uploads/ [full_path] => /opt/lampp/htdocs/pjbl/uploads/pretest_PromNet.docx [raw_name] => pretest_PromNet [orig_name] => pretest_PromNet.docx [client_name] => PjBLManual.docx [file_ext] => .docx [file_size] => 10.86 [is_image] => [image_width] => [image_height] => [image_type] => [image_size_str] => )

		if (!$this->upload->do_upload('pre')){
			$this->session->set_flashdata('err',$this->upload->display_errors());
			redirect('t');
		} else {
			$data = array(
				'name' => $this->input->post('proj_name'),
				'desc' => $this->input->post('desc'),
				'deadline' => $this->input->post('dl'),
				'pretest' => $this->upload->data('file_name'),
				'teacher_id' => $_SESSION['id']
			);
			$this->CRUD_global->create('projects',$data);
			$lastId = $this->CRUD_global->getLastID();
			$this->session->set_flashdata('warn','Dont forget to make student group and add phase for next step.');
			redirect("t/detail/$lastId");
		}
	}

	public function updateProjConfirm($id,$complete=0){
		$this->sessionTimedOut();
		$this->completeCheck($id);
		if($complete!=0){
			$this->CRUD_global->update('projects',array('completed' => 1),$id);
			$this->session->set_flashdata('succ','Project has been edited.');
			redirect("t/detail/$id");
		}else{
			if ($_FILES['pre']['name']) {
				$config['upload_path']          = './uploads/t/pretest/';
				$config['allowed_types']        = 'pdf|zip|doc|docx';
				$config['overwrite']						= TRUE;
				$config['max_size']             = 2048;
				$config['file_name']						= 'Pretest'.$this->input->post('proj_name').'_'.$_FILES['pre']['name'];

				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('pre')){
					$this->session->set_flashdata('err',$this->upload->display_errors());
					redirect("t/detail/$id");
				} else {
					$file=$this->upload->data('file_name');
				}
			}else{
				$file = $this->input->post('oldPre');
			}
			$data = array(
				'name' => $this->input->post('proj_name'),
				'desc' => $this->input->post('desc'),
				'deadline' => $this->input->post('dl'),
				'pretest' => $file,
				'teacher_id' => $_SESSION['id']
			);
			$this->CRUD_global->update('projects',$data,$id);
			$this->session->set_flashdata('succ','Project has been edited.');
			redirect("t/detail/$id");
		}
	}

	public function makeGroupConfirm($ProjId){
		$this->sessionTimedOut();
		$this->completeCheck($ProjId);
		$data = array(
			'username' => $this->input->post('un'),
			'password' => md5('PjBLStudentGroup'.md5($this->input->post('pw'))),
			'fullname' => $this->input->post('gn'),
			'member' => $this->input->post('m'),
			'project_id' => $ProjId
		);

		if ($this->CRUD_global->read('student_groups',array('username' => $this->input->post('un')))) {
			$this->session->set_flashdata('err','Username already taken.');
			redirect("t/detail/$ProjId");
		}else{
			$this->CRUD_global->create('student_groups',$data);
			$this->session->set_flashdata('succ','Student group has been created.');
			redirect("t/detail/$ProjId");
		}
	}

	public function editGroupConfirm($ProjId,$id){
		$this->sessionTimedOut();
		$this->completeCheck($ProjId);
		if ($this->input->post('unOld')==$this->input->post('un')) {
			$unNew=$this->input->post('unOld');
		}else{
			$unNew=$this->input->post('un');
			$cekUN=$this->CRUD_global->read('student_groups',array('username' => $this->input->post('un')));
			if ($cekUN) {
				$this->session->set_flashdata('err','Username already taken.');
				redirect("t/detail/$ProjId");
			}
		}
		if($this->input->post('pwd')!=NULL){
			$pwd=md5('PjBLStudentGroup'.md5($this->input->post('pwd')));
		}else{
			$pwd=md5($this->input->post('oldPwd'));
		}
		$data = array(
			'username' => $unNew,
			'password' => $pwd,
			'fullname' => $this->input->post('gn'),
			'member' => $this->input->post('m'),
		);
		$this->CRUD_global->update('student_groups',$data,$id);
		$this->session->set_flashdata('succ','Student group has been edited.');
		redirect("t/detail/$ProjId");
	}

	public function addPhaseConfirm($ProjId){
		$this->sessionTimedOut();
		$this->completeCheck($ProjId);
		$ProjName=$this->input->post('projName');
		$t = $this->CRUD_global->read('projects',array('id' => $ProjId));
		$config['upload_path']          = './uploads/t/phase/';
		$config['allowed_types']        = 'pdf|zip|doc|docx|ppt|pptx';
		$config['overwrite']						= TRUE;
		$config['file_name']						= 'MateriProjek'.$ProjName.$this->input->post('pn').'_'.$_FILES['file']['name'];
		$config['max_size']             = 2048;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file')){
			$this->session->set_flashdata('err',$this->upload->display_errors());
			redirect("t/detail/$ProjId");
		} else {
			$PrevId=NULL;
			$NextId=NULL;
			$data = array(
				'name' => $this->input->post('pn'),
				'desc' => $this->input->post('desc'),
				'deadline' => $this->input->post('dl'),
				'file' => $this->upload->data('file_name'),
				'project_id' => $ProjId,
				'prev_phase' => $PrevId,
				'next_phase' => $NextId,
			);
			$this->CRUD_global->create('phases',$data);
			$lastId=$this->CRUD_global->getLastID();
			//$checkPhaseRows=$this->CRUD_global->read('phases',array('project_id' => $ProjId),1,1);
			if(isset($_POST['aa'])){
				if($this->input->post('aa')=="NULL"){// add phase to the first
					$PrevId=NULL;
					$oldFirstRecord = $this->CRUD_global->queryRunning("SELECT * FROM phases WHERE project_id=$ProjId AND prev_phase IS NULL AND id!=$lastId",0);
					$NextId=$oldFirstRecord->id;
					$this->CRUD_global->update('phases',array('prev_phase'=>$lastId),$NextId);
				}else{// add phase to middle or last
					$PrevId=$this->input->post('aa');
					$prevRecord=$this->CRUD_global->queryRunning("SELECT id,prev_phase,next_phase FROM phases WHERE id=".$PrevId,0);
					$this->CRUD_global->update('phases',array('next_phase' => $lastId),$PrevId);
					if($prevRecord->next_phase!=NULL){// add to middle
						$this->CRUD_global->update('phases',array('prev_phase' => $lastId),$prevRecord->next_phase);
						$NextId=$prevRecord->next_phase;
					}
				}
				$this->CRUD_global->update('phases',array('prev_phase' => $PrevId, 'next_phase' => $NextId),$lastId);
			}
			$this->session->set_flashdata('succ','Phase has been added.');
			redirect("t/detail/$ProjId");
		}
	}

	public function updatePhaseConfirm($ProjId,$ProjName,$PhaseId){
		$this->sessionTimedOut();
		$this->completeCheck($ProjId);
		if ($_FILES['file']['name']) {
			$config['upload_path']          = './uploads/t/phase/';
			$config['allowed_types']        = 'pdf|zip|doc|docx|ppt|pptx';
			$config['overwrite']						= TRUE;
			$config['max_size']             = 2048;
			$config['file_name']						= 'MateriProjek'.$ProjName.$this->input->post('pn').'_'.$_FILES['file']['name'];

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('file')){
				$this->session->set_flashdata('err',$this->upload->display_errors());
				redirect("t/detail/$ProjId/$PhaseId");
			} else {
				$file=$this->upload->data('file_name');
			}
		}else{
			$file = $this->input->post('oldFile');
		}

		$newPrevId=$this->input->post('oldPrevPhase');
		$newNextId=$this->input->post('oldNextPhase');
		$tempMorePhase = $this->CRUD_global->read('phases',array('project_id' => $ProjId),1,1);
		$sortedPhase = $this->phaseSorting($tempMorePhase);
		if ($this->input->post('oldPrevPhase')==NULL) {// first phase move
			if ($this->input->post('mp')!="NULL") {// move phase to the middle or the last
				$newPrevRecord=$this->CRUD_global->queryRunning("SELECT id,prev_phase,next_phase FROM phases WHERE id=".$this->input->post('mp'),0);
				$newPrevId=$newPrevRecord->id;
				$newNextId=$newPrevRecord->next_phase;
				$this->CRUD_global->update('phases',array('next_phase' => $PhaseId),$this->input->post('mp'));
				$this->CRUD_global->update('phases',array('prev_phase' => $PhaseId),$newPrevRecord->next_phase);
				$this->CRUD_global->update('phases',array('prev_phase' => NULL),$this->input->post('oldNextPhase'));
			}
		}elseif ($this->input->post('oldNextPhase')==NULL) {// last phase move
			if ($this->input->post('mp')=="NULL") {// move phase to the first
				$newPrevId=NULL;
				foreach ($sortedPhase as $key) {
					if ($key->prev_phase==NULL) {
						$newNextId=$key->id;
						$this->CRUD_global->update('phases',array('prev_phase'=>$PhaseId),$key->id);
					}
				}
				$this->CRUD_global->update('phases',array('next_phase' => NULL),$this->input->post('oldPrevPhase'));
			}else{//move phase to the middle
				$newPrevId=$this->input->post('mp');
				$newPrevRecord=$this->CRUD_global->queryRunning("SELECT id,prev_phase,next_phase FROM phases WHERE id=".$newPrevId,0);
				$newNextId=$newPrevRecord->next_phase;
				$this->CRUD_global->update('phases',array('next_phase' => $PhaseId),$newPrevId);
				$this->CRUD_global->update('phases',array('prev_phase' => $PhaseId),$newNextId);
				$this->CRUD_global->update('phases',array('next_phase' => NULL),$this->input->post('oldPrevPhase'));
			}
		}else{// middle phase move
			if ($this->input->post('mp')=="NULL") {// move to the first
				$newPrevId=NULL;
				foreach ($sortedPhase as $key) {
					if ($key->prev_phase==NULL) {
						$newNextId=$key->id;
						$this->CRUD_global->update('phases',array('prev_phase'=>$PhaseId),$key->id);
					}
				}
				$this->CRUD_global->update('phases',array('next_phase' => $this->input->post('oldNextPhase')),$this->input->post('oldPrevPhase'));
				$this->CRUD_global->update('phases',array('prev_phase' => $this->input->post('oldPrevPhase')),$this->input->post('oldNextPhase'));
			}else{// move to the other middle or last
				$newPrevId=$this->input->post('mp');
				$newPrevRecord=$this->CRUD_global->queryRunning("SELECT id,prev_phase,next_phase FROM phases WHERE id=".$newPrevId,0);
				$newNextId=$newPrevRecord->next_phase;
				$this->CRUD_global->update('phases',array('next_phase' => $this->input->post('oldNextPhase')),$this->input->post('oldPrevPhase'));
				$this->CRUD_global->update('phases',array('prev_phase' => $this->input->post('oldPrevPhase')),$this->input->post('oldNextPhase'));
				$this->CRUD_global->update('phases',array('next_phase' => $PhaseId),$newPrevId);
				if ($newNextId!=NULL) {//move to middle
					$this->CRUD_global->update('phases',array('prev_phase' => $PhaseId),$newNextId);
				}else{
				}
			}
		}

		$data = array(
			'name' => $this->input->post('pn'),
			'desc' => $this->input->post('desc'),
			'deadline' => $this->input->post('dl'),
			'file' => $file,
			'project_id' => $ProjId,
			'prev_phase' => $newPrevId,
			'next_phase' => $newNextId
		);
		$this->CRUD_global->update('phases',$data,$PhaseId);
		$this->session->set_flashdata('succ','Phase has been updated.');
		redirect("t/detail/$ProjId/$PhaseId");
	}

	public function confirmGroupWork($id=0){
		$this->sessionTimedOut();
		$this->completeCheck($this->input->post('ProjId'));
		if ($id==0) {
			$this->session->set_flashdata('err','The students not sent they work in this phase');
			redirect('t/detail/'.$this->input->post('ProjId').'/'.$this->input->post('PhaseId'));
		}
		$data = array(
			'passed' => $this->input->post('pass'),
			'point' => $this->input->post('point'),
			'comment' => $this->input->post('comment')
		);
		$this->CRUD_global->update('answers',$data,$id,'idA');
		$this->session->set_flashdata('succ','Student work has been updated.');
		redirect('t/detail/'.$this->input->post('ProjId').'/'.$this->input->post('PhaseId'));
	}

	public function deleteConfirm($tbl,$ProjId,$DeleteId=0){
		$this->sessionTimedOut();
		if($DeleteId==0){$this->CRUD_global->delete($tbl,$ProjId);redirect('t');}
		else{
			$this->completeCheck($ProjId);
			if($tbl=="phases"){
				$tempPhase=$this->CRUD_global->read('phases',array('id' => $DeleteId));
				if ($tempPhase->prev_phase!=NULL && $tempPhase->next_phase!=NULL) {
					$this->CRUD_global->update('phases',array('next_phase' => $tempPhase->next_phase),$tempPhase->prev_phase);
					$this->CRUD_global->update('phases',array('prev_phase' => $tempPhase->prev_phase),$tempPhase->next_phase);
				}else{
					if($tempPhase->prev_phase==NULL && $tempPhase->next_phase!=NULL){
						$this->CRUD_global->update('phases',array('prev_phase' => NULL),$tempPhase->next_phase);
					}elseif ($tempPhase->next_phase==NULL && $tempPhase->prev_phase!=NULL) {
						$this->CRUD_global->update('phases',array('next_phase' => NULL),$tempPhase->prev_phase);
					}
				}
				$this->session->set_flashdata('succ','Phase has been deleted.');
			}
			$this->CRUD_global->delete($tbl,$DeleteId);
			redirect("t/detail/$ProjId");
		}
	}

	public function profile($username,$act=""){
		$this->sessionTimedOut();
		if($act==""){
			$data['account']=$this->CRUD_global->read('teachers',array('username' => $this->session->userdata('un')));
			$this->load->view('v_profile',$data);
		}else{
			if($act=="all"){
				if ($username==$this->input->post('un')) {
					$unNew=$username;
				}else{
					$unNew=$this->input->post('un');
					$cekUN=$this->CRUD_global->read('teachers',array('username' => $this->input->post('un')));
					if ($cekUN) {
						$this->session->set_flashdata('err','Username already taken.');
						redirect("t");
					}
				}

				$data = array('username' => $unNew, 'fullname' => $this->input->post('fn'));
				$this->CRUD_global->update('teachers',$data,$_SESSION['id']);
				$this->session->set_userdata(array('un' => $unNew, 'fn' => $this->input->post('fn')));
				$this->session->set_flashdata('succ','Profile has been edited.');
				redirect("t/profile/$unNew");
			}elseif ($act=="pwd") {
				$oldPwd = md5('PjBLTeacher'.md5($this->input->post('oldPwd')));
				if($_SESSION['pwd']!=$oldPwd){
					$this->session->set_flashdata('err','Password is incorrect.');
				}else{
					$newPwd = md5('PjBLTeacher'.md5($this->input->post('newPwd')));
					$this->CRUD_global->update('teachers',array('password' => $newPwd),$username,'username');
					$this->session->set_userdata('pwd',$newPwd);
					$this->session->set_flashdata('succ','Password has been reset.');
				}
				redirect("t/profile/$username");
			}
		}
	}
}
