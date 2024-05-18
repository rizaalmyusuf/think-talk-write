<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CRUD_global extends CI_Model {
  public function __construct() {
      $this->load->database();
  }

  public function read($table,$arr,$readMore=0,$getMySQLiResultObject=0){
    $query = $this->db->get_where($table, $arr);
    if($readMore==1){
      if ($getMySQLiResultObject==1) {
        return $query;
      }else{
        return $query->result();
      }
    }elseif ($readMore==0) {
      return $query->row();
    }
  }

  public function create($table,$data){
    $this->db->insert($table,$data);
  }

  public function update($table,$data,$id,$col='id'){
    $this->db->where($col, $id);
    $this->db->update($table, $data);
  }

  public function delete($table,$id,$col='id'){
    $this->db->delete($table, array($col => $id));
  }

  public function getLastID(){
    $id = $this->db->insert_id();
    return $id;
  }

  public function queryRunning($q,$getMore=1,$getMySQLiResultObject=0){
    $query=$this->db->query($q);
    if ($getMore==1) {
      if ($getMySQLiResultObject==1) {
        return $query;
      }else{
        return $query->result();
      }
    }else{
      return $query->row();
    }
  }
}
?>
