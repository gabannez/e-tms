<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {
	var $table = 'users';
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function login($username, $password)
	{
		$this->db->select("$this->table.id, $this->table.username, $this->table.realname, $this->table.level");
		$this->db->from($this->table);
		$this->db->where('username', $username);
		$this->db->where('password', md5($password));
		$this->db->limit(1);
		
		$query = $this->db->get();
		if($query->num_rows() == 1)
		{
			return $query->result();
		} else {
			return false;
		}
	}
}

?>