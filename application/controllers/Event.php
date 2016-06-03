<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Event_model', 'event');
		$this->load->model('Event_type_model', 'event_type');
	}
	
	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$data['records'] = $this->event_type->get_all();
			
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['name'] = $session_data['realname'];
			$data['level'] = $session_data['level'];
			$data['title'] = 'Event Management';
			$data['title2'] = 'Event';
			
			$this->load->view('templates/admin_header');
			$this->load->view('templates/admin_panel',$data);
			$this->load->view('admin/admin_event_view');
			$this->load->view('templates/admin_footer');
		} else {
			redirect('login', 'refresh');
		}
	}
	
	public function ajax_list()
	{
		$list = $this->event->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $event) {
			$no++;
			$row = array();
			$row[] = $event->appellation;
			$row[] = $event->event_name;
			$row[] = $event->location;
			$row[] = $event->date_start;
			$row[] = $event->date_end;
			$row[] = $event->time_start;
			$row[] = $event->time_end;
			$row[] = $event->remarks;
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_event('."'".$event->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
					<a class="btn btn-sm btn-danger" href="javascript:void()" title="Delete" onclick="delete_event('."'".$event->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			
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
		$data = $this->event->get_by_id($id);
		$data->date_start = ($data->date_start == '0000-00-00') ? '' : $data->date_start;
		$data->data_end = ($data->date_end == '0000-00-00') ? '' : $data->date_end;
		$data->time_start = ($data->time_start == '0000-00-00') ? '' : $data->time_start;
		$data->time_end = ($data->time_end == '0000-00-00') ? '' : $data->time_end;
		echo json_encode($data);
	}
	
	public function ajax_add()
	{
		$session_data = $this->session->userdata('logged_in');
		$username = $session_data['username'];
		
		$data = array(
				'id_event_type' => $this->input->post('eventTypeId'),
				'event_name' => $this->input->post('eventName'),
				'location' => $this->input->post('location'),
				'date_start' => $this->input->post('dateStart'),
				'date_end' => $this->input->post('dateEnd'),
				'time_start' => $this->input->post('timeStart'),
				'time_end' => $this->input->post('timeEnd'),
				'remarks' => $this->input->post('remarks'),
				'DT_CREATED' => date('Y-m-d H:m:s'),
				'CREATED_BY' => $username,
			);
		$insert = $this->event->save($data);
		echo json_encode(array("status" => TRUE));
	}
	
	public function ajax_update()
	{
		$session_data = $this->session->userdata('logged_in');
		$username = $session_data['username'];
		
		$data = array(
				'id_event_type' => $this->input->post('eventTypeId'),
				'event_name' => $this->input->post('eventName'),
				'location' => $this->input->post('location'),
				'date_start' => $this->input->post('dateStart'),
				'date_end' => $this->input->post('dateEnd'),
				'time_start' => $this->input->post('timeStart'),
				'time_end' => $this->input->post('timeEnd'),
				'remarks' => $this->input->post('remarks'),
				'DT_UPDATED' => date('Y-m-d H:m:s'),
				'UPDATED_BY' => $username,
			);
		$this->event->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}
	
	public function ajax_delete($id)
	{
		$this->event->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
}

?>