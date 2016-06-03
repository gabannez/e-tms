<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['name'] = $session_data['realname'];
			$data['level'] = $session_data['level'];
			$data['title'] = 'Dashboard';
			$data['title2'] = '';
			
			$this->load->view('templates/admin_header');
			$this->load->view('templates/admin_panel', $data);
			$this->load->view('templates/admin_footer');
		} else {
			redirect('login', 'refresh');
		}
	}
}

?>