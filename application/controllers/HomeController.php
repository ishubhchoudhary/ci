<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
        $this->load->model('common_model');
	}

	public function index()
	{
		$this->load->view('header');
		$this->load->view('login');
		$this->load->view('footer');
	}

	public function login()
	{
		$this->load->view('header');
		$this->load->view('login');
		$this->load->view('footer');
	}

    function login_submit() {
		 $this->form_validation->set_rules('username', 'Username', 'trim|required');
		 $this->form_validation->set_rules('password', 'Password', 'trim|required');
		 if ($this->form_validation->run() == FALSE) {
			 $this->session->set_flashdata('error_message', 'Please Fill the Form Correctly!');
			 redirect($_SERVER['HTTP_REFERER']);
		 }
		 $username = $this->input->post('username');
		 $password = $this->input->post('password');
		 // $data = array('user' => $username, 'pass' => hashcode($password));
		 $data = array('user' => $username, 'pass' => $password);
		 $result = $this->user_model->login_check($data);
 
		 if (count(array_filter($result))) {
			 if($result['0']->status=='1')
			 {
			
 
				 $this->session->set_userdata('user_id', $result['0']->customer_id);
				 $this->session->set_userdata('user_email', $result['0']->email);
				 $this->session->set_userdata('user_fullname', $result['0']->firstname.' '.$result['0']->lastname);
				 $this->session->set_userdata('user_active', $result['0']->status);
				 //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
				 $this->common_model->userLog($result['0']->customer_id);
				if ($this->input->post('remember')) {
					$hour = time()+3600*24*30;
					setcookie('username', $username, $hour);
					setcookie('password', $password, $hour);
					$cookie = array('name' => 'username', 'value' => $password, 'expire' => '86500',);
					$cookie1 = array('name' => 'password', 'value' => $username, 'expire' => '86500',);
					$this->input->set_cookie($cookie);
					$this->input->set_cookie($cookie1);
	
				} else {
					set_cookie("username",'',time()-3600*24*30);
					set_cookie("password",'',time()-3600*24*30);
				}
			 
		   redirect(base_url());
	   	}else {
			$this->session->set_flashdata('error_message', 'Please Verify Your Email!');
			redirect($_SERVER['HTTP_REFERER']);
		}
 
		 } else {
			 $this->session->set_flashdata('error_message', 'Username or Password is Incorrect!');
			 redirect($_SERVER['HTTP_REFERER']);
		 }
	 }

	public function signup()
	{
		$this->load->view('header');
		$this->load->view('register');
		$this->load->view('footer');
	}

	public function signup_submit()
	{
		
		$this->form_validation->set_rules('name', 'name', 'trim|required');
		$this->form_validation->set_rules('email', 'email', 'trim|required|is_unique[users.email]valid_email');
		$this->form_validation->set_rules('password', 'password', 'trim|required');
		$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|required|matches[password]');
		
		if ($this->form_validation->run() == FALSE) {
			$form_errors =  array(
				'name' => form_error('name'),
				'email' => form_error('email'),
				'password' => form_error('password'),
				'confirm_password' => form_error('confirm_password')
			);

			echo json_encode([
                'status' => false,
                'errors' => $form_errors
            ]);

		}else{

			$data = array(
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'password' => $this->input->post('password'),
			);

			$user_id = $this->common_model->insertData('users', $data);
			if ($user_id) {

				$this->session->set_flashdata('success', 'Thank you for Registering with us!');

				echo json_encode([
					'status' => true,
					'errors' => []
				]);

			}


		}

	}

	
}