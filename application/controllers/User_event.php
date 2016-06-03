<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class User_event extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_event_model', 'user_event');
		$this->load->model('User_model', 'user');
		$this->load->model('Event_model', 'event');
		$this->load->model('Position_model', 'position');
		$this->load->model('Department_model', 'department');
	}
	
	public function index()
	{
		if($this->session->userdata('logged_in')) 
		{
			$data['user'] = $this->user->get_all();
			$data['event'] = $this->event->get_all();
			
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['name'] = $session_data['realname'];
			$data['level'] = $session_data['level'];
			$data['title'] = 'Attended Event Management';
			$data['title2'] = 'Attended';
			
			$this->load->view('templates/admin_header');
			$this->load->view('templates/admin_panel',$data);
			$this->load->view('admin/admin_event_attended_view');
			$this->load->view('templates/admin_footer');
		} else {
			redirect('login', 'refresh');
		}
	}
	
	public function user()
	{
		if($this->session->userdata('logged_in')) 
		{
			$session_data = $this->session->userdata('logged_in');
			$id = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['name'] = $session_data['realname'];
			$data['level'] = $session_data['level'];
			
			$userId = $this->user->get_by_id($id);
			$deptId = $userId->department;
			$postId = $userId->position;
			
			$data['user'] = $this->user->get_by_id($id);
			$data['position'] = $this->position->get_by_id($postId);
			$data['department'] = $this->department->get_by_id($deptId);
			$data['event'] = $this->event->get_all();
			$data['count'] = $this->user_event->count_by_id($id);
			
			$this->load->view('templates/header');
			$this->load->view('templates/navbar', $data);
			$this->load->view('templates/panel_event_attended');
			$this->load->view('user_event_attended_view');
			$this->load->view('templates/footer');
		} else {
			redirect('login', 'refresh');
		}
	}
	
	public function event()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$id = $session_data['id'];
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['name'] = $session_data['realname'];
			$data['level'] = $session_data['level'];
			
			$data['user'] = $this->user->get_by_id($id);
			$data['event'] = $this->event->get_by_id($id);
			$data['count'] = $this->user_event->count_by_id($id);
			
			$this->load->view('templates/header');
			$this->load->view('templates/navbar',$data);
			$this->load->view('templates/panel_event');
			$this->load->view('user_event_view');
			$this->load->view('templates/footer');
		} else {
			redirect('login', 'refresh');
		}
	}
	
	public function ajax_list()
	{
		$list = $this->user_event->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $user_event) {
			$no++;
			$row = array();
			$row[] = $user_event->realname;
			$row[] = $user_event->event_name;
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_user_event('."'".$user_event->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
					<a class="btn btn-sm btn-danger" href="javascript:void()" title="Delete" onclick="delete_user_event('."'".$user_event->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			
			$data[] = $row;
		}
		
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->user_event->count_all(),
						"recordsFiltered" => $this->user_event->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	public function ajax_list_user_event()
	{
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
		$list = $this->user_event->get_datatables_userevent($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $user_event) {
			$no++;
			$row = array();
			$row[] = $user_event->event_name;
			$row[] = $user_event->location;
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Cancel" onclick="delete_user_event('."'".$user_event->id."'".')"><i class="glyphicon glyphicon-remove"></i> Cancel</a>';
			
			$data[] = $row;
		}
		
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->user_event->count_all(),
						"recordsFiltered" => $this->user_event->count_filtered_userevent($id),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	public function ajax_list_event()
	{
		$list = $this->event->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $user_event) {
			$no++;
			$row = array();
			$row[] = $user_event->appellation;
			$row[] = $user_event->event_name;
			$row[] = $user_event->location;
			$row[] = $user_event->date_start;
			$row[] = $user_event->date_end;
			$row[] = $user_event->time_start;
			$row[] = $user_event->time_end;
			$row[] = $user_event->remarks;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Apply" onclick="apply_event('."'".$user_event->id."'".')"><i class="glyphicon glyphicon-ok"></i> Apply</a>';

			$data[] = $row;
		}
		
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->event->count_all(),
						"recordsFiltered" => $this->event->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	public function ajax_edit($id)
	{
		$data = $this->user_event->get_by_id($id);
		echo json_encode($data);
	}
	
	public function ajax_edit_event($id)
	{
		$data = $this->event->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$session_data = $this->session->userdata('logged_in');
		$username = $session_data['username'];
		
		$data = array(
				'id_user' => $this->input->post('id_user'),
				'id_event' => $this->input->post('id_event'),
				'DT_CREATED' => date('Y-m-d H:m:s'),
				'CREATED_BY' => $username,
			);
		$insert = $this->user_event->save($data);
		echo json_encode(array("status" => TRUE));
	}
	
	public function ajax_update()
	{
		$session_data = $this->session->userdata('logged_in');
		$username = $session_data['username'];
		
		$data = array(
				'id_user' => $this->input->post('id_user'),
				'id_event' => $this->input->post('id_event'),
				'DT_UPDATED' => date('Y-m-d H:m:s'),
				'UPDATED_BY' => $username,
			);
		$this->user_event->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}
	
	public function ajax_delete($id)
	{
		$this->user_event->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
}

?>