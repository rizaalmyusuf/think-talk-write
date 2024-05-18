<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends CI_Controller {
	public function __construct(){
		parent :: __construct();
		if (!isset($_SESSION['logged_in'])){
			redirect ('login');
		}
		$this->load->model("m_log");
	}

	public function index(){
		$argumen['data'] = $this->m_log->getLogByUserID($_SESSION['uid']);
		$this->load->view('v_log', $argumen);
	}

	public function add(){
		$this->load->view("v_log_add");
	}

	public function addProcess(){
		$argumen = array(
			'id' => uniqid(),
			'tgl'	=> $this->input->post('tgl'),
			'aktivitas' => $this->input->post('log'),
			'output' => $this->input->post('o'),
			'user_id' => $_SESSION['uid']
		);
		$this->m_log->insert($argumen);
		redirect('log');
	}

	public function update($id){
		if ($this->m_log->getLogByID($id) !== Null) {
		  	$argumen['data'] = $this->m_log->getLogByID($id);
       	$this->load->view('v_log_update', $argumen);
		} else {
			redirect('log');
		}
	}

	public function updateProcess($id){
		$data = array(
			'tgl'	=> $this->input->post('tgl'),
			'aktivitas' => $this->input->post('log'),
			'output' => $this->input->post('o'),
			'user_id' => $_SESSION['uid']
		);
		$this->m_log->update($id,$data);
		redirect('log');
	}

	public function delete($id){
		if (!$this->m_log->delete($id)) {
			$this->session->set_flashdata('err','Record tidak bisa dihapus!');
		}
		redirect('log');
	}
}
