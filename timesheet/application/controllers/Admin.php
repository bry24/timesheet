<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$udata = $this->session->userdata('UserSession');
		if($udata){
			redirect(base_url().'admin/employees');
		}
		else{
			redirect(base_url());
		}
	}
	public function addUser()
	{
		if($_SERVER['REQUEST_METHOD']=='POST')
		{$username = $this->input->post('username');
			$this->form_validation->set_rules('username','User Name','required');
			$this->form_validation->set_rules('password','Password','required');
			$this->form_validation->set_rules('usertype','User Type','required');

			if($this->form_validation->run()==TRUE)
			{
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$usertype = $this->input->post('usertype');

				if (!$this->validatePassword($password)) {
					return false;
				}

				$data = array(
					'user_name'=>$username,
					'user_password'=>sha1($password),
					'user_type'=>$usertype
				);
				$this->load->model('UserModel');
				$this->UserModel->insertuser($data);
				$this->session->set_flashdata('success','Successfully User Created');
				redirect(base_url('admin/users'));
			}
		}
	}
	public function updateUser()
	{
		if($_SERVER['REQUEST_METHOD']=='POST')
		{$username = $this->input->post('username');
			$this->form_validation->set_rules('username','User Name','required');
			$this->form_validation->set_rules('usertype','User Type','required');

			if($this->form_validation->run()==TRUE)
			{
				$id = $this->input->post('id');
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$usertype = $this->input->post('usertype');

				$data = array(
					'id'=>$id,
					'user_name'=>$username,
					'user_password'=>sha1($password),
					'user_type'=>$usertype,
					'datetime_upd'=>date('Y-m-d H:i:s')
				);
				$this->load->model('UserModel');
				$this->UserModel->updateuser($data);
				// $this->session->set_flashdata('success','Successfully User Updated');
				redirect(base_url('admin/users'));
			}
		}
	}
	function validatePassword($password) {
		$hasLower = preg_match('/[a-z]/', $password);
		$hasUpper = preg_match('/[A-Z]/', $password);
		$hasNumber = preg_match('/\d/', $password);
		$hasSpecial = preg_match('/[^a-zA-Z\d]/', $password);
		$hasLength = strlen($password) >= 10;
	  
		if ($hasLower && $hasUpper && $hasNumber && $hasSpecial && $hasLength) {
		  return true;
		} else {
		  return false;
		}
	  }
	public function loginUser()
	{
		
		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			$this->form_validation->set_rules('username','User Name','required');
			$this->form_validation->set_rules('password','Password','required');

			if($this->form_validation->run()==TRUE)
			{
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$password = sha1($password);

				$this->load->model('UserModel');
				$status = $this->UserModel->loginuser($password,$username);
				if($status!=false)
				{
					$id = $status->id;
					$user_name = $status->user_name;
					$user_type = $status->user_type;

					$session_data = array(
						'id'=>$id,
						'user_name'=>$user_name,
						'user_type' => $user_type,
					);

					$this->session->set_userdata('UserSession',$session_data);

					redirect(base_url('admin/dashboard'));
				}
				else
				{
					$this->session->set_flashdata('error','Email or Password is Wrong');
					redirect(base_url('admin'));
				}

			}
			else
			{
				$this->session->set_flashdata('error','Fill all the required fields');
				redirect(base_url('admin'));
			}
		}
	}
	function dashboard()
	{
		$this->load->view('dashboard');
	}
	function users()
	{
		$udata = $this->session->userdata('UserSession');
		if($udata && $udata['user_type']!=1){
			redirect(base_url());
		}
		$this->load->view('users');
	}
	public function deleteUser()
	{
		$this->load->model('UserModel');
		if($_GET)
		{
			$ids = $this->input->get('multiDelete');
			$data = array(
				'id'=>$this->input->post('user_ids')
			);
			$this->UserModel->deleteUser($data, 1);
		}
		if($_SERVER['REQUEST_METHOD']=='POST' && !$_GET)
		{
			$id = $this->input->post('id');
			$data = array(
				'id'=>$id
			);
			$this->UserModel->deleteUser($data);
		}
		redirect(base_url('admin/users'));
	}
	function fetchUsers()
	{
		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			$this->load->model('UserModel');
			$status = $this->UserModel->getUsers();
			echo json_encode($status);
		}
	}
	function fetchSingleUser()
	{
		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			$this->load->model('UserModel');
			$status = $this->UserModel->getUsers();
			echo json_encode($status);exit;
		}
	}

	function employees()
	{
		$udata = $this->session->userdata('UserSession');
		if($udata['user_type']==2){
			redirect(base_url('admin/timerecords'));
		}
		$this->load->view('employees');
	}
	public function addEmployee()
	{
		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			$this->form_validation->set_rules('first_name','First Name','required');
			$this->form_validation->set_rules('last_name','Last Name','required');

			if($this->form_validation->run()==TRUE)
			{
				$first_name = $this->input->post('first_name');
				$last_name = $this->input->post('last_name');
				$udata = $this->session->userdata('UserSession');
				$created_by = $udata['id'];

				$data = array(
					'first_name'=>$first_name,
					'last_name'=>$last_name,
					'created_by'=>$created_by
				);
				$this->load->model('EmployeeModel');
				$this->EmployeeModel->insertEmployee($data);
				$this->session->set_flashdata('success','Successfully Employee Created');
				redirect(base_url('admin/employees'));
			}
		}
	}
	public function updateEmployee()
	{
		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			$this->form_validation->set_rules('first_name','First Name','required');
			$this->form_validation->set_rules('last_name','Last Name','required');

			if($this->form_validation->run()==TRUE)
			{
				$id = $this->input->post('id');
				$first_name = $this->input->post('first_name');
				$last_name = $this->input->post('last_name');

				$data = array(
					'id'=>$id,
					'first_name'=>$first_name,
					'last_name'=>$last_name,
					'datetime_upd'=>date('Y-m-d H:i:s')
				);
				$this->load->model('EmployeeModel');
				$this->EmployeeModel->updateEmployee($data);
				redirect(base_url('admin/employees'));
			}
		}
	}
	
	public function deleteEmployee()
	{
		$this->load->model('EmployeeModel');
		if($_GET)
		{
			$ids = $this->input->get('multiDelete');
			$data = array(
				'id'=>$this->input->post('employee_ids')
			);
			$this->EmployeeModel->deleteEmployee($data, 1);
		}
		if($_SERVER['REQUEST_METHOD']=='POST' && !$_GET)
		{
			$id = $this->input->post('id');
			$data = array(
				'id'=>$id
			);
			$this->EmployeeModel->deleteEmployee($data);
		}
		redirect(base_url('admin/employees'));
	}
	
	function fetchEmployees()
	{
		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			$this->load->model('EmployeeModel');
			$status = $this->EmployeeModel->getEmployees();
			echo json_encode($status);
		}
	}
	function fetchSingleEmployee()
	{
		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			$this->load->model('EmployeeModel');
			$status = $this->EmployeeModel->getEmployees();
			echo json_encode($status);exit;
		}
	}
	function fetchEmployeeTimeRecord()
	{
		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			$this->load->model('EmployeeModel');
			$status = $this->EmployeeModel->getEmployeeTimeRecord();
			echo json_encode($status);exit;
		}
	}
	function qrURL(){
		$url = $_GET['url'];;
		// define file transfer
		header('Content-Description: File Transfer');
		// define content type as PNG image
		header("Content-type: image/png");
		// define unique file name and tell that it is an attachment
		header("Content-disposition: attachment; filename= qrcode_".time().".png");

		// read and file
		readfile($url);
	  }
	  function employeeTimeOut()
	  {
		  if($_SERVER['REQUEST_METHOD']=='POST')
		  {
			  $this->load->model('EmployeeModel');
			  $status = $this->EmployeeModel->setEmployeeTimeOut();
			  echo json_encode($status);exit;
		  }
	  }
	  function employeeTimeIn()
	  {
		  if($_SERVER['REQUEST_METHOD']=='POST')
		  {
			  $this->load->model('EmployeeModel');
			  $status = $this->EmployeeModel->setEmployeeTimeIn();
			  echo json_encode($status);exit;
		  }
	  }
	  function employeeTimeRecord()
	  {
		  if($_SERVER['REQUEST_METHOD']=='POST')
		  {
			  $this->load->model('EmployeeModel');
			  $status = $this->EmployeeModel->setEmployeeTimeRecord();
			  echo json_encode($status);exit;
		  }
	  }
	  
	function timerecords()
	{
		$this->load->view('timerecords');
	}
	
	function fetchTimeRecords()
	{
		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			$this->load->model('TimerecordModel');
			$status = $this->TimerecordModel->getTimerecords();
			echo json_encode($status);
		}
	}
	
	function logbook()
	{
		$this->load->view('logbook');
	}
	function logout()
	{
		session_destroy();
		redirect(base_url());
	}
}
