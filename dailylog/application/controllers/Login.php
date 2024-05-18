<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct() {
			parent:: __construct();
			$this->load->model('M_user');
	}

	public function index(){
		$logged_in = $this->session->userdata("logged_in");
		if ($logged_in == true){
			redirect ('log');
		} else {
			$this->load->view('v_login');
		}
	}

	public function cek(){
		$un= $this->input->post('username');
		$pwd= md5($this->input->post('password'));
		$data = $this->M_user->getData($un);
		print_r($data);

		if ($un==$data->username && $pwd==$data->password) {
			$userdata = array(
        'uid'	=> $data->id,
        'un' 	=> $data->username,
				'pwd'	=> $data->password,
				'nip' => $data->nip,
				'nl'	=> $data->nama_lengkap,
        'logged_in' => TRUE
			);
			$this->session->set_userdata($userdata);
		} else {
			$this->session->set_flashdata('err','User tidak dikenal, KDL!');
		}
		redirect('login');
	}

	public function logout(){
		$data_item = array('uid','un','pwd','nip','nl','logged_in');
		$this->session->unset_userdata($data_item);
		redirect('login');
	}
}
