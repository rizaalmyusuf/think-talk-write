<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sg extends CI_Controller {
	public function __construct() {
			parent:: __construct();
			$this->load->model('CRUD_global');
	}

	public function index(){
		if ($this->session->userdata("logged_in") == true){
			if ($_SESSION['rl']=='administrator') {
				$this->session->set_flashdata('err','You are not a student.');
				redirect('admin');
			}elseif ($_SESSION['rl']=='t') {
				$this->session->set_flashdata('err','You are not a student.');
				redirect('t');
			}elseif ($_SESSION['rl']=='sg') {
				$data['proj'] = $this->CRUD_global->read('projects', array('id' => $_SESSION['pid']));
				$q="SELECT * FROM (phases LEFT JOIN answers ON answers.phase_id=phases.id AND student_id=".$_SESSION['id'].") WHERE project_id=".$_SESSION['pid'];
				$tempMorePhase = $this->CRUD_global->queryRunning($q,1,1);
				if($tempMorePhase->num_rows()!=0){
					$data['morePhase'] = $this->phaseSorting($tempMorePhase);
				}else{
					$data['morePhase'] = $this->CRUD_global->read('phases',array('project_id' => $_SESSION['pid']),1);
				}
				foreach ($data['morePhase'] as $key) {
					if ($key->prev_phase!=NULL) {
						$q="SELECT passed FROM answers WHERE phase_id=$key->prev_phase AND student_id=".$_SESSION['id'];
						$dataPrevPhase=$this->CRUD_global->queryRunning($q,0);
						if ($dataPrevPhase) {
							$key->prev_phase=array('passed' => $dataPrevPhase->passed);
						}else{
							$key->prev_phase=array('passed' => 0);
						}
					}
					if ($key->next_phase!=NULL) {
						$q="SELECT passed FROM answers WHERE phase_id=$key->next_phase AND student_id=".$_SESSION['id'];
						$dataNextPhase=$this->CRUD_global->queryRunning($q,0);
						if ($dataNextPhase) {
							$key->next_phase=array('passed' => $dataNextPhase->passed);
						}else {
							$key->next_phase=array('passed' => 0);
						}
					}
				}
				$this->load->view('sg/vsg_projects',$data);
			}else {
				$this->session->set_flashdata('err','Unknow role, please try again!');
				redirect('login/logout');
			}
		} else {
			$this->session->set_flashdata('err','Login first!');
			redirect('login');
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

	public function upload($ProjName,$PhaseId=0,$PhaseName=""){
		$this->sessionTimedOut();
		$this->completeCheck($_SESSION['pid']);
		if(strtotime(date('Y-m-d\TH:i:s'))>strtotime($this->input->post('dl'))){
			$this->session->set_flashdata('err','You late.');
			redirect('sg');
		}
		if($PhaseId==0){
			$config['upload_path']='./uploads/sg/pretest/';
			$config['file_name']=$_SESSION['un'].'Pretest'.$ProjName.'_'.$_FILES['uf']['name'];
		}else{
			$config['upload_path']='./uploads/sg/phase/';
			$config['file_name']=$_SESSION['un'].'_'.$ProjName.$PhaseName.'_'.$_FILES['uf']['name'];
		}
		$config['allowed_types']        = 'pdf|zip|docx|doc|jpg|jpeg';
		$config['overwrite']						= TRUE;
		$config['max_size']             = 2048;

		$this->load->library('upload', $config);
		//Array ( [file_name] => pretest_PromNet.docx [file_type] => application/vnd.openxmlformats-officedocument.wordprocessingml.document [file_path] => /opt/lampp/htdocs/pjbl/uploads/ [full_path] => /opt/lampp/htdocs/pjbl/uploads/pretest_PromNet.docx [raw_name] => pretest_PromNet [orig_name] => pretest_PromNet.docx [client_name] => PjBLManual.docx [file_ext] => .docx [file_size] => 10.86 [is_image] => [image_width] => [image_height] => [image_type] => [image_size_str] => )

		if (!$this->upload->do_upload('uf')){
			$this->session->set_flashdata('err',$this->upload->display_errors());
			redirect('sg');
		} else {
			if ($PhaseId==0) {
				$data = array('pretest_work' => $this->upload->data('file_name'));
				$this->CRUD_global->update('student_groups',$data,$_SESSION['id']);
				$this->session->set_userdata('pw',$this->upload->data('file_name'));
				$this->session->set_flashdata('succ','Pretest has been submitted.');
			}elseif ($this->input->post('oldFile') && $this->input->post('idA')) {
				$data = array('fileA'=>$this->upload->data('file_name'));
				$this->CRUD_global->update('answers',$data,$this->input->post('idA'),'idA');

			}else{
				$data = array('student_id'=>$_SESSION['id'],'phase_id'=>$PhaseId,'fileA'=>$this->upload->data('file_name'));
				$this->CRUD_global->create('answers',$data);
				$this->session->set_flashdata('succ','Phase task has been submitted.');
			}
			$this->session->set_flashdata('succ','File has been uploaded.');
			redirect("sg");
		}
	}

	public function profile($username,$act=""){
		$this->sessionTimedOut();
		if($act==""){
			$data['account']=$this->CRUD_global->read('student_groups',array('username' => $this->session->userdata('un')));
			$this->load->view('v_profile',$data);
		}else{
			if($act=="all"){
				if ($username==$this->input->post('un')) {
					$unNew=$username;
				}else{
					$unNew=$this->input->post('un');
					$cekUN=$this->CRUD_global->read('student_groups',array('username' => $this->input->post('un')));
					if ($cekUN) {
						$this->session->set_flashdata('err','Username already taken.');
						redirect("sg");
					}
				}

				$data = array('username' => $unNew, 'fullname' => $this->input->post('fn'), 'member' => $this->input->post('member'));
				$this->CRUD_global->update('student_groups',$data,$_SESSION['id']);
				$this->session->set_userdata(array('un' => $unNew, 'fn' => $this->input->post('fn'), 'm' => $this->input->post('member')));
				$this->session->set_flashdata('succ','Profile has been edited.');
				redirect("sg/profile/$unNew");
			}elseif ($act=="pwd") {
				$oldPwd = md5('PjBLStudentGroup'.md5($this->input->post('oldPwd')));
				if($_SESSION['pwd']!=$oldPwd){
					$this->session->set_flashdata('err','Password is incorrect.');
				}else{
					$newPwd = md5('PjBLStudentGroup'.md5($this->input->post('newPwd')));
					$this->CRUD_global->update('student_groups',array('password' => $newPwd),$username,'username');
					$this->session->set_userdata('pwd',$newPwd);
					$this->session->set_flashdata('succ','Password has been reset.');
				}
				redirect("sg/profile/$username");
			}
		}
	}
}
