<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	//helper function
	private function error($msg)
	{
		$message["error"] = $msg; 
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
				echo "Working";
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
					echo "success";
					// now we update the database and make this user a valid user

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
		else {
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
				//here we connect to the database and fetch the monitored keyword, else we return an error
				echo "Working";
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
				// we update the db with the new monitored keyword
				echo "Working";
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

