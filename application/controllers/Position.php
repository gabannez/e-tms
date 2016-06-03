<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Position extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Position_model', 'position');
	}
	
	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['name'] = $session_data['realname'];
			$data['level'] = $session_data['level'];
			$data['title'] = 'Position Management';
			$data['title2'] = 'Position';
			
			$this->load->view('templates/admin_header');
			$this->load->view('templates/admin_panel',$data);
			$this->load->view('admin/admin_position_view');
			$this->load->view('templates/admin_footer');
		}  else {
			redirect('login', 'refresh');
		}
	}
	
	public function ajax_list()
	{
		$list = $this->position->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $position) {
			$no++;
			$row = array();
			$row[] = $position->appellation;
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_position('."'".$position->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
					<a class="btn btn-sm btn-danger" href="javascript:void()" title="Delete" onclick="delete_position('."'".$position->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			
			$data[] = $row;
		}
		
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->position->count_all(),
						"recordsFiltered" => $this->position->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	public function ajax_edit($id)
	{
		$data = $this->position->get_by_id($id);
		echo json_encode($data);
	}
	
	public function ajax_add()
	{
		$session_data = $this->session->userdata('logged_in');
		$username = $session_data['username'];
		
		$data = array(
				'appellation' => $this->input->post('appellation'),
				'DT_CREATED' => date('Y-m-d H:m:s'),
				'CREATED_BY' => $username,

			);
		$insert = $this->position->save($data);
		echo json_encode(array("status" => TRUE));
	}
	
	public function ajax_update()
	{
		$session_data = $this->session->userdata('logged_in');
		$username = $session_data['username'];
		
		$data = array(
				'appellation' => $this->input->post('appellation'),
				'DT_UPDATED' => date('Y-m-d H:m:s'),
				'UPDATED_BY' => $username,

			);
		$this->position->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}
	
	public function ajax_delete($id)
	{
		$this->position->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
}

?>