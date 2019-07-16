<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
class C_login extends CI_Controller {
    //Login Page Default Controller Contructor
	function __construct(){
		parent::__construct();
       /* $this->output->cache(60);*/
		$this->load->library('session');
		$this->load->helper('url');	
        $this->load->model('Login_m');
         //Date/Time Zone Variable
        date_default_timezone_set('Asia/Kolkata');
    }
    //Login Page Index Function
	public function index(){	
       $this->load->view('login_view');
	}
    //Login Page Update Log Function
	private function updatelog($action,$associate){	
        $log_time  = date("Y-M-d H:i:s T").PHP_EOL;
        $log_url = "Server: http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].PHP_EOL;
        $log_body = "Attempt: ".$action.PHP_EOL."User: ".$associate.PHP_EOL;
        $log_foot = "-------------------------".PHP_EOL;
        $log = $log_time.$log_url.$log_body.$log_foot;
        file_put_contents('application/logs/login_log_'.date('d-M-Y').'.log', $log, FILE_APPEND);
        return;
	}
	//Login Page Sign In Function
    // Author: Anand Srivastava Date: 05-Feb-2019
	public function signin(){
        //Login Page Sign In Variable
        $AID = $_POST['associateId'] ;
        $APW = $_POST['password'] ;	
        //Login Page Sign In Model Call
		$authorized['userdata'] = $this->login_m->ldapauthorization($AID,$APW);
        //Login Page Sign In Response & Session Variable Set
        if(isset($authorized['userdata'][0]->AccessLevel)){
            $this->session->set_userdata($authorized);
            //Write action to txt log
            $this->updatelog("Login",$this->session->userdata('userdata')[0]->AssociateID);
            switch ($authorized['userdata'][0]->AccessLevel) {
                case "14":
                    //Login Page Sign In Missing Lead Module
                    redirect('C_mteamlead'); 
                    break;
                case "13":
                    //Login Page Sign In Missing Delegate Module
                    redirect('C_mdelegate'); 
                    break;
                case "12":
                    //Login Page Sign In Missing Associate Module
                    redirect('C_massociate'); 
                    break;
                case "6":
                    //Login Page Sign In Manager Module
                    redirect('C_manager'); 
                    break;
                case "4":
                    //Login Page Sign In Lead Module
                    redirect('C_teamlead'); 
                    break;
                case "3":
                    //Login Page Sign In Delegate Module
                    redirect('C_delegate'); 
                    break;
                case "2":
                    //Login Page Sign In Associate Module
                    redirect('C_associate'); 
                    break;
            }
        }
        else{
            //Write action to txt log
            $this->updatelog("Failure",$AID);
            //Login Page Sign In Response & Session Variable Failure
            $this->session->set_flashdata('error',true); 
            $this->index();
        }
	}
    //Login Page Sign Out Function
	public function logout(){
       //Write action to txt log
        $this->updatelog("Logout",$this->session->userdata('userdata')[0]->AssociateID);
        $this->session->sess_destroy();
        /*$this->db->cache_delete_all();*/
        redirect('');
	}
}