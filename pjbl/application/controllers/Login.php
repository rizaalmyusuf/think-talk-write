<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct() {
			parent:: __construct();
			$this->load->model('CRUD_global');
	}

	public function index(){
		if ($this->session->userdata('logged_in') == true){
			if($_SESSION['rl']=='administrator'){
				redirect('admin');
			}elseif ($_SESSION['rl']=='t') {
				redirect('t');
			}elseif ($_SESSION['rl']=='sg') {
				redirect('sg');
			}else {
				$this->session->set_flashdata('err','Unknow role, please try again!');
				redirect('login/logout');
			}
		} else {
			$this->load->view('v_login');
		}
	}

	public function cek(){
		$un = $this->input->post('username');
		$pwdAdmin = md5('PjBLAdministrator'.md5($this->input->post('password')));
		$pwdT = md5('PjBLTeacher'.md5($this->input->post('password')));
		$pwdSG = md5('PjBLStudentGroup'.md5($this->input->post('password')));
		$dataAdmin = $this->CRUD_global->read('admin', array('username' => $un));
		$dataT = $this->CRUD_global->read('teachers', array('username' => $un));
		$dataSG = $this->CRUD_global->read('student_groups', array('username' => $un));
		$data="";

		if($dataAdmin){
			$data=$dataAdmin;
			$userdata = array(
        'id'	=> $data->id,
        'un' 	=> $data->username,
				'pwd'	=> $data->password,
				'fn'	=> $data->fullname,
				'rl'	=> 'administrator',
        'logged_in' => TRUE
			);
		}elseif ($dataT) {
			$data=$dataT;
			$userdata = array(
        'id'	=> $data->id,
        'un' 	=> $data->username,
				'pwd'	=> $data->password,
				'fn'	=> $data->fullname,
				'rl'	=> 't',
        'logged_in' => TRUE
			);
		}	elseif ($dataSG) {
			$data=$dataSG;
			$userdata = array(
        'id'	=> $data->id,
        'un' 	=> $data->username,
				'pwd'	=> $data->password,
				'fn'	=> $data->fullname,
				'm'		=> $data->member,
				'pid'	=> $data->project_id,
				'pw'	=> $data->pretest_work,
				'rl'	=> 'sg',
        'logged_in' => TRUE
			);
		}

		if($data){
			if ($un==$data->username && ($pwdAdmin==$data->password || $pwdT==$data->password || $pwdSG==$data->password)) {
				$this->session->set_userdata($userdata);
			} elseif ($un==$data->username && ($pwdAdmin==$data->password || $pwdT!=$data->password || $pwdSG!=$data->password)) {
				$this->session->set_flashdata('err','Username and password didn\'t match, please try again!');
			}
		} else {
			$this->session->set_flashdata('err','Unknow user, please try again!');
		}
		redirect('login');
	}

	public function logout(){
		session_destroy();
		redirect('login');
	}
}
