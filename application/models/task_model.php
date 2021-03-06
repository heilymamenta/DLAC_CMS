<?php

//Task Model

class Task_model extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function select_mytask($uid) {
    $query = $this->db->query("SELECT * FROM task WHERE assignedTo = $uid AND CURDATE() <= `dateDue`");
    return $query->result();
  }

  function select_mycasetask($cid, $uid) {
    $query = $this->db->query("SELECT * FROM tasks WHERE assignedTo = $uid AND caseID = $cid");
    return $query->result();
  }

  function select_theirtask($uid) {
    $query = $this->db->query("SELECT * FROM tasks WHERE assignedBy = $uid");
    return $query->result();
  }

  function select_theircasetask($cid, $uid) {
    $query = $this->db->query("SELECT * FROM tasks WHERE assignedBy = $uid AND caseID = $cid");
    return $query->result();
  }

  function insert_task($data) {
    $this->db->insert('task', $data);
  }

  function update_task($tid, $changes) {
    $this->db->where('taskID', $tid);
    $this->db->update('task', $changes);
  }

  function delete_task($tid) {
    
  }

  function select_task_auto($cid, $auto) {
    $query = $this->db->query("SELECT * FROM `task` WHERE caseID = $cid AND auto = $auto");
    return $query->row();
  }

}

?>