<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model', 'user');
		$this->load->model('Level_model', 'level');
		$this->load->model('Position_model', 'position');
		$this->load->model('Department_model', 'department');
	}
	
	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$data['role'] = $this->level->get_all();
			$data['position'] = $this->position->get_all();
			$data['department'] = $this->department->get_all();
			
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['name'] = $session_data['realname'];
			$data['level'] = $session_data['level'];
			$data['title'] = 'User Management';
			$data['title2'] = 'User';
			
			$this->load->view('templates/admin_header');
			$this->load->view('templates/admin_panel',$data);
			$this->load->view('admin/admin_user_view');
			$this->load->view('templates/admin_footer');
		} else {
			redirect('login', 'refresh');
		}
	}
	
	public function ajax_list()
	{
		$list = $this->user->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $user) {
			$no++;
			$row = array();
			$row[] = $user->username;
			$row[] = $user->description;
			$row[] = $user->realname;
			$row[] = $user->ic;
			$row[] = $user->name;
			$row[] = $user->appellation;
			$row[] = $user->email;
			$row[] = $user->contactNo;
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_user('."'".$user->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
					<a class="btn btn-sm btn-danger" href="javascript:void()" title="Delete" onclick="delete_user('."'".$user->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			
			$data[] = $row;
		}
		
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->user->count_all(),
						"recordsFiltered" => $this->user->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	public function ajax_edit($id)
	{
		$data = $this->user->get_by_id($id);
		echo json_encode($data);
	}
	
	public function ajax_add()
	{
		$session_data = $this->session->userdata('logged_in');
		$username = $session_data['username'];
		
		$data = array(
				'username' => $this->input->post('username'),
				'password' => md5($this->input->post('password')),
				'level' => $this->input->post('level'),
				'realname' => $this->input->post('realname'),
				'ic' => $this->input->post('ic'),
				'department' => $this->input->post('department'),
				'position' => $this->input->post('position'),
				'email' => $this->input->post('email'),
				'contactNo' => $this->input->post('contactNo'),
				'DT_CREATED' => date('Y-m-d H:m:s'),
				'CREATED_BY' => $username,
			);
		$insert = $this->user->save($data);
		echo json_encode(array("status" => TRUE));
	}
	
	public function ajax_update()
	{
		$session_data = $this->session->userdata('logged_in');
		$username = $session_data['username'];
		
		$data = array(
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password'),
				'level' => $this->input->post('level'),
				'realname' => $this->input->post('realname'),
				'ic' => $this->input->post('ic'),
				'department' => $this->input->post('department'),
				'position' => $this->input->post('position'),
				'email' => $this->input->post('email'),
				'contactNo' => $this->input->post('contactNo'),
				'DT_UPDATED' => date('Y-m-d H:m:s'),
				'UPDATED_BY' => $username,
			);
		$this->user->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}
	
	public function ajax_delete($id)
	{
		$this->user->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
}

?>