<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		
		$this->form_validation->set_rules('username', 'username', 'trim|required');
		$this->form_validation->set_rules('password', 'password', 'trim|required|callback_check_database');
		
		if($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header');
			$this->load->view('login_view');
			$this->load->view('templates/footer');	
		}
		else {
			$session_data = $this->session->userdata('logged_in');
			if($session_data['level'] == '1') {
				redirect(base_url('index.php/admin'), 'refresh');
			} else {
				redirect(base_url('index.php/user_event/user'), 'refresh');
			}
		}
		
		if($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			if($session_data['level'] == '1') {
				redirect(base_url('index.php/admin'), 'refresh');

			} else {
				redirect(base_url('index.php/user_event/user'), 'refresh');
			}
		}
	}
	
	public function check_database($password)
	{
		$this->load->model('Login_model', 'ulogin');

		$username = $this->input->post('username');
		$result = $this->ulogin->login($username, $password);
		if($result) {
			$sess_array = array();
			foreach($result as $row)
			{
				$sess_array = array('id' => $row->id, 'username' => $row->username, 'realname' => $row->realname, 'level' => $row->level);
				$this->session->set_userdata('logged_in', $sess_array);
			}
			return true;
		} else {
			$this->form_validation->set_message('check_database', 'Invalid username or password');
			return false;
		}
	}
}

?>