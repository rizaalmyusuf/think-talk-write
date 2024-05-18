<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_log extends CI_Model {
  public function __construct() {
      $this->load->database();
  }

  public function getLogByUserID($uid) {
      $query = $this->db->query("SELECT * FROM log WHERE user_id=$uid");
      return $query->result();
  }

  public function getLogByID($id){
      $query = $this->db->query("SELECT * FROM log WHERE id='$id'");
      return $query->row();
  }

  public function insert($data){
    $result  = $this->db->insert("log",$data);
    return $result;
  }

  public function update($id, $data) {
    $this->db->where('id', $id);
    $result = $this->db->update('log', $data);
    return $result;
  }

  public function delete($id) {
    $db_debug = $this->db->db_debug;
    $this->db->db_debug = FALSE;

    $this->db->where('id', $id);
    $this->db->delete('log');
    $db_error = $this->db->error();
    $this->db->db_debug = $db_debug;

    if ($db_error['code']==0) {
      $result = TRUE;
    } else {
      $result = FALSE;
    }
    return $result;
  }
}
