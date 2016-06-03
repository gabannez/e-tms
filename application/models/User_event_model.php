<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class User_event_model extends CI_Model {
	var $table = 'user_event';
	var $column = array('realname', 'event_name', 'location', 'date_start', 'date_end', 'time_start', 'time_end');
	var $order = array('id' => 'desc'); // default order
	
	public function __construct()
	{
		parent::__construct();
	}
	
	private function _get_datatables_query()
	{
		$this->db->select("$this->table.id, $this->table.id_user, $this->table.id_event, users.realname, event.event_name, event.location,
						   $this->table.DT_CREATED, $this->table.DT_UPDATED,
						   $this->table.CREATED_BY, $this->table.UPDATED_BY");
		$this->db->from($this->table);
		$this->db->join("users", "users.id = $this->table.id_user");
		$this->db->join("event", "event.id = $this->table.id_event");
		
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
	
	private function _get_datatables_userevent_query($id)
	{
		$this->db->select("$this->table.id, $this->table.id_user, $this->table.id_event, users.realname, event.event_name, event.location,
						   $this->table.DT_CREATED, $this->table.DT_UPDATED,
						   $this->table.CREATED_BY, $this->table.UPDATED_BY");
		$this->db->from($this->table);
		$this->db->join("users", "users.id = $this->table.id_user");
		$this->db->join("event", "event.id = $this->table.id_event");
		$this->db->where(array('users.id' => $id));
		
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
	
	private function _get_datatables_event_query()
	{
		$this->db->select("$this->table.id, $this->table.id_user, $this->table.id_event, users.realname, event.event_name, event.location,
						   event.date_start, event.date_end, event.time_start, event.time_end,
						   $this->table.DT_CREATED, $this->table.DT_UPDATED,
						   $this->table.CREATED_BY, $this->table.UPDATED_BY");
		$this->db->from($this->table);
		$this->db->join("users", "users.id = $this->table.id_user");
		$this->db->join("event", "event.id = $this->table.id_event");
		
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
	
	function get_datatables_event()
	{
		$this->_get_datatables_event_query();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
			return $query->result();
	}
	
	function get_datatables_userevent($id)
	{
		$this->_get_datatables_userevent_query($id);
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
	
	function count_filtered_userevent($id)
	{
		$this->_get_datatables_userevent_query($id);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
	
	public function count_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id_user', $id);
		$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id', $id);
		$query = $this->db->get();
		
		return $query->row();
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