<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class C_mteamlead extends CI_Controller {
	function __construct(){
        parent::__construct();
       /* $this->output->cache(60);*/
		$this->load->library('session');
		$this->load->helper('url');	
        $this->load->model('mteamlead_m','',TRUE);
        if($this->session->userdata('userdata')[0]->AccessLevel != '14'){
                $this->session->sess_destroy();
                redirect('');
        }
        //Date/Time Zone Variable
        date_default_timezone_set('Asia/Kolkata');
    }
	public function index(){
        $rsdate =isset($_POST['sdate'])?$_POST['sdate']:date("Y-m-d");
        $redate = date('Y-m-d H:i',strtotime('+23 hour +59 minutes',strtotime($rsdate)));
        $Dashboard_Data['ProjectList']= $this->mteamlead_m->fetch_projectlist();
        $Dashboard_Data['Associate_List'] = $this->mteamlead_m->fetch_associatelist();
        for($i=0;$i<sizeof($Dashboard_Data['Associate_List']);$i++){
            if($i==0){
                $teams = $Dashboard_Data['Associate_List'][$i]['AssociateID'];
            }
            else{
                $teams = $teams."','".$Dashboard_Data['Associate_List'][$i]['AssociateID'];
            }
        }
        for($i=0;$i<sizeof($Dashboard_Data['ProjectList']);$i++){
			$Dashboard_Data['recon'][$i] = $this->mteamlead_m->fetch_dashboard_data($Dashboard_Data['ProjectList'][$i]['ProjectID'],$rsdate,$redate,$teams);
		}
        $first_date_find = strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . ", first day of this month");
        $first_date = date("Y-m-d",$first_date_find);
        if( (null !== $this->input->post('mtdsdate')) && (null !==$this->input->post('mtdsdate')) ){
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
        else{
            $sdate=$first_date;
            $edate=date("Y-m-d");
        }
        $uedate = date('Y-m-d H:i',strtotime('+23 hour +59 minutes',strtotime($edate)));
        for($i=0;$i<sizeof($Dashboard_Data['ProjectList']);$i++){
           $Dashboard_Data['mtd'][$i] = $this->mteamlead_m->fetch_dashboard_data($Dashboard_Data['ProjectList'][$i]['ProjectID'],$sdate,$uedate,$teams);
        }
        $this->load->view('Topbar_view');
		$this->load->view('MTL/Sidebar_view');
		$this->load->view('MTL/Home_view',$Dashboard_Data);
		$this->load->view('Footer_view');
	}
    //Report and Facility List
	public function Report_Facility(){	
        
		$data['Associate_List'] = $this->mteamlead_m->fetch_teamlist();
    	$this->load->view('Topbar_view');
		$this->load->view('MTL/Sidebar_view');
		$this->load->view('MTL/Report_Facility_view',$data);
		$this->load->view('Footer_view');
	}
        // Author: Jagdish Pandre Date: 15-Mar-2019
	public function addAssociate(){
		if (isset($_POST['associate_id_add']) &&
			isset($_POST['associate_fname_add']) && 
			isset($_POST['associate_sname_add']) && 
			isset($_POST['associate_initial_add']) && 
			isset($_POST['access_level_add'])){
    		$associate_id_add = $_POST['associate_id_add'];
    		$associate_fname_add = $_POST['associate_fname_add'];
    		$associate_sname_add = $_POST['associate_sname_add'];
    		$associate_name_add = $associate_fname_add." ".$associate_sname_add;
    		$associate_initial_add = $_POST['associate_initial_add'];
    		$access_level_add = $_POST['access_level_add'];	
            if($this->mteamlead_m->checkassociate($associate_id_add)){
               $this->mteamlead_m->addassociate($associate_id_add,$associate_name_add,$associate_initial_add,$access_level_add);
                $this->session->set_flashdata('entry',false); 
            }
            else{
                 $this->session->set_flashdata('entry',true); 
            }
    		header('Location: ../C_mteamlead/Report_Facility');
    	}
    }
    // Author: Jagdish Pandre Date: 15-Mar-2019
    public function editassociate(){
		if (isset($_POST['associate_id_edit_0']) &&
			isset($_POST['associate_fname_edit']) && 
			isset($_POST['associate_sname_edit']) && 
			isset($_POST['associate_initial_edit']) && 
			isset($_POST['access_level_edit']) && 
			isset($_POST['team_lead_associate_edit'])){
	    		$associate_id_edit = $_POST['associate_id_edit_0'];
	    		$associate_fname_edit = $_POST['associate_fname_edit'];
	    		$associate_sname_edit = $_POST['associate_sname_edit'];
	    		$associate_name_edit = $associate_fname_edit." ".$associate_sname_edit;
	    		$associate_initial_edit = $_POST['associate_initial_edit'];
	    		$access_level_edit = $_POST['access_level_edit'];
	    		$team_lead_edit = $_POST['team_lead_associate_edit'];
	    		$this->mteamlead_m->editassociate($associate_id_edit,$associate_name_edit,$associate_initial_edit,$access_level_edit,$team_lead_edit);
    		}
    	$this->Report_Facility();
    }
    // Author: Jagdish Pandre Date: 15-Mar-2019
    public function updateAssociateStatus($AssociateID,$activeStatus){
		$active = $this->mteamlead_m->updateAssociateStatus($AssociateID,$activeStatus);
        if($active == 0){
            $this->mteamlead_m->migrationresearch($AssociateID);
        }
		$this->Report_Facility();
    }
     # Missing EOB Pending Listing Page
    public function Missing_EOB_Pending(){  
        $team = array($this->mteamlead_m->fetch_associatelist());
        for($i=0;$i<sizeof($team[0]);$i++){
            if($i==0){
                $teams = $team[0][$i]['AssociateID'];
            }
            else{
                $teams = $teams."','".$team[0][$i]['AssociateID']; 
            }
        }
        $Missing_EOB_Pending_Data['team'] = $team;
        $Missing_EOB_Pending_Data['missingeobpendingdata'] = $this->mteamlead_m->fetch_missing_eob_pending($teams);
        $this->load->view('Topbar_view');
        $this->load->view('MTL/Sidebar_view');
        $this->load->view('MTL/Missing_EOB_Pending_view',$Missing_EOB_Pending_Data);
        $this->load->view('Footer_view');
    }
    // Missing EOB Assigned Listing Page
    public function Missing_EOB_Assigned(){ 
        $team = array($this->mteamlead_m->fetch_associatelist());
        for($i=0;$i<sizeof($team[0]);$i++){
            if($i==0){
                $teams = $team[0][$i]['AssociateID'];
            }
            else{
                $teams = $teams."','".$team[0][$i]['AssociateID']; 
            }
        }
        $Missing_EOB_Assigned_Data['team'] = $team;
        $Missing_EOB_Assigned_Data['missingeobassigneddata'] = $this->mteamlead_m->fetch_missing_eob_assigned($teams);
        $this->load->view('Topbar_view');
        $this->load->view('MTL/Sidebar_view');
        $this->load->view('MTL/Missing_EOB_Assigned_view',$Missing_EOB_Assigned_Data);
        $this->load->view('Footer_view');
    }
    // Missing EOB Assigned Listing Page
    public function Missing_EOB_Issues(){ 
        $team = array($this->mteamlead_m->fetch_associatelist());
        for($i=0;$i<sizeof($team[0]);$i++){
            if($i==0){
                $teams = $team[0][$i]['AssociateID'];
            }
            else{
                $teams = $teams."','".$team[0][$i]['AssociateID']; 
            }
        }
        $Missing_EOB_Issues_Data['team'] = $team;
        $Missing_EOB_Issues_Data['missingeobissuesdata'] = $this->mteamlead_m->fetch_missing_eob_issues($teams);
        $this->load->view('Topbar_view');
        $this->load->view('MTL/Sidebar_view');
        $this->load->view('MTL/Missing_EOB_Issues_view',$Missing_EOB_Issues_Data);
        $this->load->view('Footer_view');
    }
    // Missing EOB Resolved Listing Page
    public function Missing_EOB_Resolved(){	
        $team = array($this->mteamlead_m->fetch_associatelist());
        for($i=0;$i<sizeof($team[0]);$i++){
            if($i==0){
                $teams = $team[0][$i]['AssociateID'];
            }
            else{
                $teams = $teams."','".$team[0][$i]['AssociateID']; 
            }
        }
        $Missing_EOB_Resolved_Data['team'] = $team;
        $Missing_EOB_Resolved_Data['missingeobresolveddata'] = $this->mteamlead_m->fetch_missing_eob_resolved($teams);
        $this->load->view('Topbar_view');
		$this->load->view('MTL/Sidebar_view');
		$this->load->view('MTL/Missing_EOB_Resolved_view',$Missing_EOB_Resolved_Data);
		$this->load->view('Footer_view');
	}
    // Missing EOB Archive Listing Page
    public function Missing_EOB_Archive(){	
        $team = array($this->mteamlead_m->fetch_associatelist());
        for($i=0;$i<sizeof($team[0]);$i++){
            if($i==0){
                $teams = $team[0][$i]['AssociateID'];
            }
            else{
                $teams = $teams."','".$team[0][$i]['AssociateID']; 
            }
        }
        $Missing_EOB_Archive_Data['missingeobarchivedata'] = $this->mteamlead_m->fetch_missing_eob_archive($teams);
        $this->load->view('Topbar_view');
		$this->load->view('MTL/Sidebar_view');
		$this->load->view('MTL/Missing_EOB_Archive_view',$Missing_EOB_Archive_Data);
		$this->load->view('Footer_view');
	}
    // Author: Anand Srivastava Date: 15-Mar-2019
    public function missingworking($missingid,$pageid){
        $missingid = base64_decode($missingid);
        $pageid = base64_decode($pageid);
        $data['status'] = array('0' => $pageid);
        $data['missingid'] =  array('0' =>  $missingid);
        $data['missingworkingdata'] = $this->mteamlead_m->missingworking($missingid);
        $data['get_stat'] = $this->mteamlead_m->fetch_Status();
        $data['Team_list']= $this->mteamlead_m->fetch_associatelist();
        $this->load->view('Topbar_view');
        $this->load->view('MTL/Sidebar_view');
        $this->load->view('MTL/Missing_Working_view',$data);
        $this->load->view('Footer_view');
    }
    // Author: Anand Srivastava Date: 15-Mar-2019
    public function getActions(){
        $status = $_POST['statusId'];
        $data['actions']=$this->mteamlead_m->getActions($status);
        echo json_encode($data);
    }
    // Author: Anand Srivastava Date: 15-Mar-2019
    public function getMetrics(){
        $metrics = $_POST['metricId'];
        $data['metrics']=$this->mteamlead_m->getMetrics($metrics);
        echo json_encode($data);
    }
    // Author: Anand Srivastava Date: 15-Mar-2019
    public function saveMissing($pageid) {
        $missingid = $this->input->post('missingid');
        $note = $this->input->post('note');
        $comment = $this->input->post('comment');
        $status = $this->input->post('status');
        $action = $this->input->post('action');
        $metric = $this->input->post('metric');
        $assignedID = $this->input->post('assign');
        $this->mteamlead_m->saveMissing($missingid,$comment,$note,$status,$action,$metric,$assignedID);
        header('Location: ../'.$pageid);
    }
    // function to update the assigned associateid in the missing table 
    function updateworkassignstatus($missingid,$assignedid,$pageid){
        $this->mteamlead_m->updateworkassignstatus($missingid,$assignedid);
        if(strcmp($pageid, "Missing_EOB_Pending")==0){
            $this->mteamlead_m->updateworkassigns($missingid,$assignedid);
        }
        header('Location: ../../../'.$pageid);
    }
    // Author: Anand Srivastava Date: 31-Jan-2019
    public function Work_Queue(){	
        $My_Queue_Data['myqueuedata'] = $this->mteamlead_m->fetch_my_queue();
        $this->load->view('Topbar_view');
		$this->load->view('MTL/Sidebar_view');
		$this->load->view('MTL/My_Queue_view',$My_Queue_Data);
		$this->load->view('Footer_view');
	}
    // Author: Anand Srivastava Date: 15-Mar-2019
    public function Production_Report(){	
        $first_date_find = strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . ", first day of this month");
        $first_date = date("Y-m-d",$first_date_find);
        $sdate = isset($_POST['sdate'])?$_POST['sdate']:$first_date;
        $edate = isset($_POST['edate'])?$_POST['edate']:date("Y-m-d");
        $uedate = date('Y-m-d H:i',strtotime('+23 hour +59 minutes',strtotime($edate)));
        $data['TeamList'] = $this->mteamlead_m->fetch_associateList();
        for($i=0;$i<sizeof($data['TeamList']);$i++){
            $data['production_summary'][$i] = $this->mteamlead_m->production_summary($sdate,$uedate,$data['TeamList'][$i]['AssociateID']);
        }
        $this->load->view('Topbar_view');
		$this->load->view('MTL/Sidebar_view');
        $this->load->view('MTL/Production_Summary_view',$data);
		$this->load->view('Footer_view');
	}
    
}
?>