<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('email');
		$this->load->library('session');
		
		$user = $this->session->userdata('email');
		$pass = $this->session->userdata('password');
		$pass = $this->session->userdata('hak_akses');
		
		if(empty($user) && empty($pass) && empty($hak_akses))
		{
			redirect('Login');
		}
	}

	public function index()
	{
		

		//Gmail SMTP port (TLS): 587
		//Gmail SMTP port (SSL): 465
		
		/*
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'smtp.gmail.com', //ssl://smtp.googlemail.com
			'smtp_port' => 465, // 465 587
			'smtp_user' => 'baskaraayoga@gmail.com',
			'smtp_pass' => '16562233',
			'mailtype' => 'html',
			'charset' => 'iso-8859-1'
		);
		$this->load->library('email', $config);
		*/
		
		$this->email->set_newline("\r\n");
		
		//set to, from, message, etc.

		$this->email->from('baskaraayoga@gmail.com', 'Yoga Baskara');
		$this->email->to('baskaraayoga@gmail.com');

		$this->email->subject('Email Test');
		$this->email->message('Testing email class..');

		$this->email->send();

		echo $this->email->print_debugger();

		

		/*
		  $config = array();
                $config['useragent']           	= "CodeIgniter";
                $config['mailpath']            	= "/usr/sbin/sendmail"; // or "/usr/sbin/sendmail"
                $config['protocol']            	= "smtp";
                $config['smtp_host']           	= "ssl://smtp.googlemail.com";
                $config['smtp_port']           	= "465";
                $config['smtp_user'] 			= 'baskaraayoga@gmail.com';  //change it
    			$config['smtp_pass'] 			= '16562233'; //change it
                $config['mailtype'] 			= 'html';
                $config['charset']  			= 'utf-8';
                $config['newline']  			= "\r\n";
                $config['wordwrap'] 			= TRUE;

                $this->load->library('email');

                $this->email->initialize($config);

                $this->email->from('baskaraayoga@gmail.com', 'admin');
                $this->email->to('baskaraayoga@gmail.com');
                //$this->email->cc('xxx@gmail.com'); 
                //$this->email->bcc($this->input->post('email')); 
                $this->email->subject('Registration Verification: Continuous Imapression');
                $msg = "Thanks for signing up!
            Your account has been created, 
            you can login with your credentials after you have activated your account by pressing the url below.
            Please click this link to activate your account";

            $this->email->message($msg);   
            $this->email->send();
            //$this->email->message($this->load->view('email/'.$type.'-html', $data, TRUE));
		*/
	}
}
