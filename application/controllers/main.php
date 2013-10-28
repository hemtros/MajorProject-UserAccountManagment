<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct()
	{

		parent::__construct();
		$this->load->model('mainmodel');

	}

	//helper function
	private function error($msg)
	{
		$message["error"] = $msg; 
		echo json_encode($message);
	}

	private function success($msg)
	{
		$message["success"] = $msg; 
		echo json_encode($message);
	}
	
	//actions
	public function index()
	{
		$this->load->view('welcome_message');
	}
	public function registration()
	{
		header('Content-type:application/json');

		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$phone = $this->input->post('phone');
			if ($username && $password && $phone)
			{
				//now we perform the database operation and report success or failure in json
				
				// we here check the rows affected, if it is -1 we have a db record if not new account is created
				if ($this->mainmodel->registration($username,$password,$phone) !== -1)
				{
					$this->success("New Account Created.");
				}
				else
				{
					$this->error("Database problem");
				}

			}
			else
			{
				$this->error("Something went wrong.");
			}

		}
		else {
			$this->error("Only accepts POST requests");
		}
		//$this->load->view('welcome_message');
	}
	public function validate()
	{
		header('Content-type:application/json');
		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$username = $this->input->post('username');
			$validation_code = $this->input->post('validation_code');
			
			$true_validation_code = substr(md5($username), 0,5);
			if ($username && $validation_code)
			{
				if ($true_validation_code === $validation_code)
				{
					if ($this->mainmodel->validate($username) !== -1)
					{
						$this->success("Congratulation. Your account has been validated.");
					}
					else
					{
						$this->error("Sorry The code you supplied is not working. Please try again.");
					}

				}
				else
				{
					$this->error("Validation code Incorrect");		
				}
			}
			else
			{
				$this->error("Something went wrong.");
			}

		}
		else 
		{
			$this->error("Only accepts POST requests");
		}
	}
	public function monitored_keyword()
	{
		header('Content-type:application/json');
		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			
			if ($username && $password)
			{
				$data = $this->mainmodel->monitored_keyword($username,$password);
				if ( !empty($data))
				{
					
					echo json_encode($data[0]);
				}
				else
				{
					$this->error("There was a error.");
				}
			}
			else
			{
				$this->error("Something went wrong.");
			}

		}
		else {
			$this->error("Only accepts post requests");
		}
	}
	public function set_monitored_keyword()
	{
		header('Content-type:application/json');
		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$new_keyword = $this->input->post('new_keyword');
			
			if ($username && $password && $new_keyword)
			{
				
				if ($this->mainmodel->set_monitored_keyword($username,$password,$new_keyword) !== -1)
				{
					$this->success("Keyword {$new_keyword} started to monitor");
				}
				else
				{
					$this->error("New keyword could not be added.");
				}
			}
			else
			{
				$this->error("Something went wrong.");
			}

		}
		else {
			$this->error("Only accepts post requests");
		}
	}

	
}

