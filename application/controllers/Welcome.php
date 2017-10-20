<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	function __construct()
	{
		parent::__construct();		
		$this->load->helper(array('form', 'url'));		
		$this->load->library(array('form_validation'));			
		$this->load->config('eidara_auth', TRUE);	
	}
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
		$data['keywords']	= 'Eidara, Matadata, Infrastructure, Infrastruktur, Rekayasa, Innovation, Data Driven, Nawacita, Indonesia, Timur, Sustainable Development, Drone, UAV, Pemetaan, Mapping, Land Grabbing, Project Management, Manajemen Proyek, Antardisiplin, Interdisciplinary, Science Technology Society, Science Technology Policy, RTRWK, Rencana Tata Ruang Wilayah Kota, Urban Planning, Rural Planning, Multidiscipline, Multidisiplin, COP 21, PT Eidara matadata presisi, matadata, Eidara, Eidara matadata presisi';
		$this->load->view('header',$data);
		$this->load->view('welcome_message');
		$this->load->view('footer');
	}
	
	public function send_notification_email()
	{				
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('msg', 'Message', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');					
		$this->form_validation->set_rules('subject', 'Subject', 'trim|required');					
		
		$status = 0; $pesan = array();
		if ($this->form_validation->run()) {				
		
			$this->load->library('email');
			
			##email to ticket sender					
			$name					 = $this->input->post('name');
			$sender					 = $this->input->post('email');
			$msg				 	 = $this->input->post('msg');
			$subject			 	 = $this->input->post('subject');
			
			$email_name				 = 'contact_us-html';
			$reply_to				 = 'justin.the@encona.co.id';
			$email_to				 = array('justin.the@encona.co.id'); 
			/* $reply_to				 = 'asep.jamaludin@encona.co.id';
			$email_to				 = 'ksatria_alit@yahoo.com'; */
			$no_reply				 = 'noreply@eidaramata.com';			
			
			$email_data['sender']	 = $sender;	
			$email_data['name']	 	 = $name;	
			$email_data['message']	 = $msg;	
			
			$this->email->from($sender, $sender);		
			$this->email->reply_to($reply_to);
			$this->email->to($email_to);
			/*if($attach){
				$this->email->attach($attach);
			}*/	
			$this->email->subject($subject);
			$this->email->message($this->load->view('email/'.$email_name, $email_data, TRUE));
			$this->email->send();
			
			$pesan = array('status' => 0,'msg' => $this->email->print_debugger());													
		}else{
			$pesan = array('status' => 1,'msg' => validation_errors());				
		}
		echo json_encode($pesan);			
	}
}
