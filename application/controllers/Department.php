<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Department_model', 'department');
	}
	
	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['name'] = $session_data['realname'];
			$data['level'] = $session_data['level'];
			$data['title'] = 'Department Management';
			$data['title2'] = 'Department';
			
			$this->load->view('templates/admin_header');
			$this->load->view('templates/admin_panel',$data);
			$this->load->view('admin/admin_department_view');
			$this->load->view('templates/admin_footer');
		}  else {
			redirect('login', 'refresh');
		}
	}
	
	public function ajax_list()
	{
		$list = $this->department->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $department) {
			$no++;
			$row = array();
			$row[] = $department->name;
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_department('."'".$department->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
					<a class="btn btn-sm btn-danger" href="javascript:void()" title="Delete" onclick="delete_department('."'".$department->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			
			$data[] = $row;
		}
		
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->department->count_all(),
						"recordsFiltered" => $this->department->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	public function ajax_edit($id)
	{
		$data = $this->department->get_by_id($id);
		echo json_encode($data);
	}
	
	public function ajax_add()
	{
		$session_data = $this->session->userdata('logged_in');
		$username = $session_data['username'];
		
		$data = array(
				'name' => $this->input->post('name'),
				'DT_CREATED' => date('Y-m-d H:m:s'),
				'CREATED_BY' => $username,

			);
		$insert = $this->department->save($data);
		echo json_encode(array("status" => TRUE));
	}
	
	public function ajax_update()
	{
		$session_data = $this->session->userdata('logged_in');
		$username = $session_data['username'];
		
		$data = array(
				'name' => $this->input->post('name'),
				'DT_UPDATED' => date('Y-m-d H:m:s'),
				'UPDATED_BY' => $username,

			);
		$this->department->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}
	
	public function ajax_delete($id)
	{
		$this->department->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
}

?>