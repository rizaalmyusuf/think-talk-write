<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model {
  public function __construct() {
      $this->load->database();
  }

  function getData($un) {
      $query = $this->db->query("SELECT * FROM users WHERE username ='$un'");
      return $query->row();
  }
}
