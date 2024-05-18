<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct() {
			parent:: __construct();
			$this->load->model('CRUD_global');
	}

	public function index(){
		if ($this->session->userdata("logged_in") == true){
			if($_SESSION['rl']=='administrator'){
				$data['dataUserT'] = $this->CRUD_global->queryRunning("SELECT * FROM teachers");
				$this->load->view('admin/va_users',$data);
			}elseif ($_SESSION['rl']=='t') {
				$this->session->set_flashdata('err','You are not an administrator.');
				redirect('t');
			}elseif ($_SESSION['rl']=='sg') {
				$this->session->set_flashdata('err','You are not an administrator.');
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

	public function createTeacherConfirm(){
		$this->sessionTimedOut();
		$data = array(
			'username' => $this->input->post('un'),
			'password' => md5('PjBLTeacher'.md5($this->input->post('pwd'))),
			'fullname' => $this->input->post('fn')
		);

		if ($this->CRUD_global->read('teachers',array('username' => $this->input->post('un')))) {
			$this->session->set_flashdata('err','Username already taken.');
			redirect("admin");
		}else{
			$this->CRUD_global->create('teachers',$data);
			$this->session->set_flashdata('succ','Teacher has been created.');
			redirect("admin");
		}
	}

	public function editTeacherConfirm($UserId){
		$this->sessionTimedOut();
		if ($this->input->post('unOld')==$this->input->post('un')) {
			$unNew=$this->input->post('unOld');
		}else{
			$unNew=$this->input->post('un');
			$cekUN=$this->CRUD_global->read('teachers',array('username' => $this->input->post('un')));
			if ($cekUN) {
				$this->session->set_flashdata('err','Username already taken.');
				redirect("admin");
			}
		}
		if($this->input->post('pwd')!=NULL){
			$pwd=md5('PjBLTeacher'.md5($this->input->post('pwd')));
		}else{
			$pwd=md5($this->input->post('oldPwd'));
		}
		$data = array(
			'username' => $unNew,
			'password' => $pwd,
			'fullname' => $this->input->post('fn')
		);
		$this->CRUD_global->update('teachers',$data,$UserId);
		$this->session->set_flashdata('succ','Teacher has been edited.');
		redirect("admin");
	}

	public function deleteTeacherConfirm($DeleteId){
		$this->sessionTimedOut();
		$this->CRUD_global->delete('teachers',$DeleteId);
		$this->session->set_flashdata('succ','Teacher has been deleted.');
		redirect("admin");
	}

	public function profile($username,$act=""){
		$this->sessionTimedOut();
		if($act==""){
			$data['account']=$this->CRUD_global->read('admin',array('username' => $this->session->userdata('un')));
			$this->load->view('v_profile',$data);
		}else{
			if($act=="all"){
				if ($username==$this->input->post('un')) {
					$unNew=$username;
				}else{
					$unNew=$this->input->post('un');
					$cekUN=$this->CRUD_global->read('admin',array('username' => $this->input->post('un')));
					if ($cekUN) {
						$this->session->set_flashdata('err','Username already taken.');
						redirect("t");
					}
				}

				$data = array('username' => $unNew, 'fullname' => $this->input->post('fn'));
				$this->CRUD_global->update('admin',$data,$_SESSION['id']);
				$this->session->set_userdata(array('un' => $unNew, 'fn' => $this->input->post('fn')));
				$this->session->set_flashdata('succ','Profile has been edited.');
				redirect("t/profile/$unNew");
			}elseif ($act=="pwd") {
				$oldPwd = md5('PjBLAdministrator'.md5($this->input->post('oldPwd')));
				if($_SESSION['pwd']!=$oldPwd){
					$this->session->set_flashdata('err','Password is incorrect.');
				}else{
					$newPwd = md5('PjBLAdministrator'.md5($this->input->post('newPwd')));
					$this->CRUD_global->update('admin',array('password' => $newPwd),$username,'username');
					$this->session->set_userdata('pwd',$newPwd);
					$this->session->set_flashdata('succ','Password has been reset.');
				}
				redirect("admin/profile/$username");
			}
		}
	}
}
