<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
	var $table = 'users';
	var $column = array('username', 'description', 'realname', 'ic', 'name', 
						'appellation', 'email', 'contactNo');
	var $order = array('id' => 'desc'); // default order
	
	public function __construct()
	{
		parent::__construct();
	}
	
	private function _get_datatables_query()
	{
		$this->db->select("$this->table.id, $this->table.username, $this->table.password, $this->table.level, level.description, position.appellation,
						   department.name, $this->table.realname, $this->table.ic, $this->table.department, $this->table.position, $this->table.email, 
						   $this->table.contactNo, $this->table.DT_CREATED, $this->table.DT_UPDATED, $this->table.CREATED_BY, $this->table.UPDATED_BY");
		$this->db->from($this->table);
		$this->db->join("level", "level.id = $this->table.level");
		$this->db->join("position", "position.id = $this->table.position");
		$this->db->join("department", "department.id = $this->table.department");
		
		$i = 0;
		
		foreach ($this->column as $item) // loop column
		{
			if($_POST['search']['value']) //if datatables send POST for search
			{
				if($i === 0) //first loop
				{
					$this->db->group_start(); //open bracket. query Where with OR
					$this->db->like($item, $_POST['search']['value']);
				}
				else 
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}
				
				if(count($this->column) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$column[$i] = $item;
			$i++;
		}
		
		if(isset($_POST['order'])) //order processing
		{
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
	
	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
			return $query->result();
	}
	
	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
	
	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id', $id);
		$query = $this->db->get();
		
		return $query->row();
	}
	
	public function get_all()
	{
		$this->db->from($this->table);
		$query = $this->db->get();
		
		return $query->result();
	}
	
	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
	
	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}
	
	public function delete_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}
}
?>