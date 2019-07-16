<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
class C_manager extends CI_Controller {
	function __construct(){
		parent::__construct();
       /* $this->output->cache(60);*/
		$this->load->library('session');
		$this->load->helper('url');	
        $this->load->model('manager_m','',TRUE);
        if($this->session->userdata('userdata')[0]->AccessLevel != '6'){
            $this->session->sess_destroy();
            redirect('');
        }
        //Date/Time Zone Variable
        date_default_timezone_set('Asia/Kolkata');
    }
	public function index(){	
        $first_date_find = strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . ", first day of this month");
        $first_date = date("Y-m-d",$first_date_find);
        $edate=date("Y-m-d");
        $uedate = date('Y-m-d H:i',strtotime('+23 hour +59 minutes',strtotime($edate)));
        $Dashboard_Data['ProjectList']= $this->manager_m->fetch_projectlist_r();
        for($i=0;$i<sizeof($Dashboard_Data['ProjectList']);$i++){
            if($i==0){
                $facility_id = $Dashboard_Data['ProjectList'][$i]['ProjectID'];
            }
            else{
                $facility_id = $facility_id."','".$Dashboard_Data['ProjectList'][$i]['ProjectID'];
            }
        }
        if(isset($_POST['Facility_Id'])){
            $facility_id = $_POST['Facility_Id'];
        }
        $Dashboard_Data['influx'] = $this->manager_m->fetch_dashboard_data($facility_id,$first_date,$uedate);
         //Date/Time Zone Variable
        $rsdate =isset($_POST['sdate'])?$_POST['sdate']:date("Y-m-d");
        $redate = date('Y-m-d H:i',strtotime('+23 hour +59 minutes',strtotime($rsdate)));
		//Getting Reconcillition data of Clients
		for($i=0;$i<sizeof($Dashboard_Data['ProjectList']);$i++){
			$Dashboard_Data['RECON'][$i] = $this->manager_m->newReconcilliation($Dashboard_Data['ProjectList'][$i]['ProjectID'],$rsdate,$redate);
			$Dashboard_Data['CategoryList'][$i] = $this->manager_m->fetch_categorylist($Dashboard_Data['ProjectList'][$i]['ProjectID'],$rsdate,$redate);
		}
		$buffer = array();
 		for ($i=0; $i <sizeof($Dashboard_Data['CategoryList']) ; $i++) { 
             for ($j=0; $j < sizeof($Dashboard_Data['CategoryList'][$i]); $j++) { 
               array_push($buffer,$this->manager_m->newReconcillitionCat($Dashboard_Data['ProjectList'][$i]['ProjectID'],$Dashboard_Data['CategoryList'][$i][$j]['CategoryID'],$rsdate,$redate));
             }
        }
        $Dashboard_Data['RECONCAT']=$buffer;
         //First Date of Previous Month  
        $pmfd = date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1));
        //Last Date of Previous Month
        $pmld = date("Y-m-d", mktime(0, 0, 0, date("m"), 0));
        //Previous Month Today's Date
        $pcdate = strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "-1 months");
        $pmcdate = date("Y-m-d",$pcdate);
        $first_date_find = strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . ", first day of this month");
        $first_date = date("Y-m-d",$first_date_find);
        if( (null !== $this->input->post('mtdsdate')) && (null !==$this->input->post('mtdsdate')) ) 
        {
            $sdate = $this->input->post('mtdsdate');
            $edate = $this->input->post('mtdedate');
            if($sdate == date("Y-m")) { //If selected month is the current month then get first day and current day of current month
                $sdate = $first_date;
                $edate = date("Y-m-d");  
            }
            elseif($sdate < date("Y-m")){ //If selected month is not current month then get first day and last day of selected month 
                $sdate = date("Y-m-01", strtotime($sdate));
                $edate = date("Y-m-t", strtotime($sdate));
            }
        }
        else
        {
            $sdate=$first_date;
            $edate=date("Y-m-d");
        }
        $uedate = date('Y-m-d H:i',strtotime('+23 hour +59 minutes',strtotime($edate)));
        for($i=0;$i<sizeof($Dashboard_Data['ProjectList']);$i++){
            $Dashboard_Data['MTD'][$i] = $this->manager_m->mtd_half_fetch($Dashboard_Data['ProjectList'][$i]['ProjectID'],$pmfd,$pmld,$pmcdate,$sdate,$edate,$uedate);
        }
		$this->load->view('MNP/Topbar_view');
		$this->load->view('MNP/Sidebar_view');
		$this->load->view('MNP/Home_view',$Dashboard_Data);
		$this->load->view('Footer_view');
	}
	//Report and Facility List
	public function Report_Facility(){	
		$data['Cl_Names']=$this->manager_m->fetch_projectlist();
        $data['As_Names']=$this->manager_m->fetch_associatelist();
		$this->load->view('MNP/Topbar_view');
		$this->load->view('MNP/Sidebar_view');
		$this->load->view('MNP/Report_Facility_view',$data);
		$this->load->view('Footer_view');
	}
    // Author: Jagdish Pandre Date: 15-Mar-2019
	public function addlead(){
		if (isset($_POST['associate_id_add']) &&
			isset($_POST['associate_fname_add']) && 
			isset($_POST['associate_sname_add'])){
    		$associate_id_add = $_POST['associate_id_add'];
    		$associate_fname_add = $_POST['associate_fname_add'];
    		$associate_sname_add = $_POST['associate_sname_add'];
    		$associate_name_add = $associate_fname_add." ".$associate_sname_add;
            $access_level_add = 4;	
            
            if($this->manager_m->checkassociate($associate_id_add)){
                $this->manager_m->addassociate($associate_id_add,$associate_name_add,$access_level_add);
                $this->session->set_flashdata('entry',false); 
            }
            else{
                 $this->session->set_flashdata('entry',true); 
            }
    		header('Location: ../C_manager/Report_Facility');
    	}
    }
}
?>