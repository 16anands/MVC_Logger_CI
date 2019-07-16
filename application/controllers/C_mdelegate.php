<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class C_mdelegate extends CI_Controller {
	function __construct(){
        parent::__construct();
        /*$this->output->cache(60);*/
		$this->load->library('session');
		$this->load->helper('url');	
        $this->load->model('mdelegate_m','',TRUE);
        if($this->session->userdata('userdata')[0]->AccessLevel != '13'){
                $this->session->sess_destroy();
                redirect('');
        }
        //Date/Time Zone Variable
        date_default_timezone_set('Asia/Kolkata');
    }
	public function index(){
        $rsdate =isset($_POST['sdate'])?$_POST['sdate']:date("Y-m-d");
        $redate = date('Y-m-d H:i',strtotime('+23 hour +59 minutes',strtotime($rsdate)));
        $Dashboard_Data['ProjectList']= $this->mdelegate_m->fetch_projectlist();
        $Dashboard_Data['Associate_List'] = $this->mdelegate_m->fetch_teamlist();
        for($i=0;$i<sizeof($Dashboard_Data['Associate_List']);$i++){
            if($i==0){
                $teams = $Dashboard_Data['Associate_List'][$i]['AssociateID'];
            }
            else{
                $teams = $teams."','".$Dashboard_Data['Associate_List'][$i]['AssociateID'];
            }
        }
        for($i=0;$i<sizeof($Dashboard_Data['ProjectList']);$i++){
			$Dashboard_Data['recon'][$i] = $this->mdelegate_m->fetch_dashboard_data($Dashboard_Data['ProjectList'][$i]['ProjectID'],$rsdate,$redate,$teams);
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
           $Dashboard_Data['mtd'][$i] = $this->mdelegate_m->fetch_dashboard_data($Dashboard_Data['ProjectList'][$i]['ProjectID'],$sdate,$uedate,$teams);
        }
        $this->load->view('Topbar_view');
		$this->load->view('MDL/Sidebar_view');
		$this->load->view('MDL/Home_view',$Dashboard_Data);
		$this->load->view('Footer_view');
	}
    //Report and Facility List
	public function Report_Facility(){	
        $data['TeamLead_List'] = $this->mdelegate_m->fetch_teamleadlist();
		$data['Associate_List'] = $this->mdelegate_m->fetch_teamlist();
    	$this->load->view('Topbar_view');
		$this->load->view('MDL/Sidebar_view');
		$this->load->view('MDL/Report_Facility_view',$data);
		$this->load->view('Footer_view');
	}
     # Missing EOB Pending Listing Page
    public function Missing_EOB_Pending(){  
        $team = array($this->mdelegate_m->fetch_teamlist());
        for($i=0;$i<sizeof($team[0]);$i++){
            if($i==0){
                $teams = $team[0][$i]['AssociateID'];
            }
            else{
                $teams = $teams."','".$team[0][$i]['AssociateID']; 
            }
        }
        $Missing_EOB_Pending_Data['team'] = $team;
        $Missing_EOB_Pending_Data['missingeobpendingdata'] = $this->mdelegate_m->fetch_missing_eob_pending($teams);
        $this->load->view('Topbar_view');
        $this->load->view('MDL/Sidebar_view');
        $this->load->view('MDL/Missing_EOB_Pending_view',$Missing_EOB_Pending_Data);
        $this->load->view('Footer_view');
    }
    // Missing EOB Assigned Listing Page
    public function Missing_EOB_Assigned(){ 
        $team = array($this->mdelegate_m->fetch_teamlist());
        for($i=0;$i<sizeof($team[0]);$i++){
            if($i==0){
                $teams = $team[0][$i]['AssociateID'];
            }
            else{
                $teams = $teams."','".$team[0][$i]['AssociateID']; 
            }
        }
        $Missing_EOB_Assigned_Data['team'] = $team;
        $Missing_EOB_Assigned_Data['missingeobassigneddata'] = $this->mdelegate_m->fetch_missing_eob_assigned($teams);
        $this->load->view('Topbar_view');
        $this->load->view('MDL/Sidebar_view');
        $this->load->view('MDL/Missing_EOB_Assigned_view',$Missing_EOB_Assigned_Data);
        $this->load->view('Footer_view');
    }
    // Missing EOB Assigned Listing Page
    public function Missing_EOB_Issues(){ 
        $team = array($this->mdelegate_m->fetch_teamlist());
        for($i=0;$i<sizeof($team[0]);$i++){
            if($i==0){
                $teams = $team[0][$i]['AssociateID'];
            }
            else{
                $teams = $teams."','".$team[0][$i]['AssociateID']; 
            }
        }
        $Missing_EOB_Issues_Data['team'] = $team;
        $Missing_EOB_Issues_Data['missingeobissuesdata'] = $this->mdelegate_m->fetch_missing_eob_issues($teams);
        $this->load->view('Topbar_view');
        $this->load->view('MDL/Sidebar_view');
        $this->load->view('MDL/Missing_EOB_Issues_view',$Missing_EOB_Issues_Data);
        $this->load->view('Footer_view');
    }
    // Missing EOB Resolved Listing Page
    public function Missing_EOB_Resolved(){	
        $team = array($this->mdelegate_m->fetch_teamlist());
        for($i=0;$i<sizeof($team[0]);$i++){
            if($i==0){
                $teams = $team[0][$i]['AssociateID'];
            }
            else{
                $teams = $teams."','".$team[0][$i]['AssociateID']; 
            }
        }
        $Missing_EOB_Resolved_Data['team'] = $team;
        $Missing_EOB_Resolved_Data['missingeobresolveddata'] = $this->mdelegate_m->fetch_missing_eob_resolved($teams);
        $this->load->view('Topbar_view');
		$this->load->view('MDL/Sidebar_view');
		$this->load->view('MDL/Missing_EOB_Resolved_view',$Missing_EOB_Resolved_Data);
		$this->load->view('Footer_view');
	}
    // Missing EOB Archive Listing Page
    public function Missing_EOB_Archive(){	
        $team = array($this->mdelegate_m->fetch_teamlist());
        for($i=0;$i<sizeof($team[0]);$i++){
            if($i==0){
                $teams = $team[0][$i]['AssociateID'];
            }
            else{
                $teams = $teams."','".$team[0][$i]['AssociateID']; 
            }
        }
        $Missing_EOB_Archive_Data['missingeobarchivedata'] = $this->mdelegate_m->fetch_missing_eob_archive($teams);
        $this->load->view('Topbar_view');
		$this->load->view('MDL/Sidebar_view');
		$this->load->view('MDL/Missing_EOB_Archive_view',$Missing_EOB_Archive_Data);
		$this->load->view('Footer_view');
	}
    // Author: Anand Srivastava Date: 15-Mar-2019
    public function missingworking($missingid,$pageid){
        $missingid = base64_decode($missingid);
        $pageid = base64_decode($pageid);
        $data['status'] = array('0' => $pageid);
        $data['missingid'] =  array('0' =>  $missingid);
        $data['missingworkingdata'] = $this->mdelegate_m->missingworking($missingid);
        $data['get_stat'] = $this->mdelegate_m->fetch_Status();
        $data['Team_list']= $this->mdelegate_m->fetch_teamlist();
        $this->load->view('Topbar_view');
        $this->load->view('MDL/Sidebar_view');
        $this->load->view('MDL/Missing_Working_view',$data);
        $this->load->view('Footer_view');
    }
    // Author: Anand Srivastava Date: 15-Mar-2019
    public function getActions(){
        $status = $_POST['statusId'];
        $data['actions']=$this->mdelegate_m->getActions($status);
        echo json_encode($data);
    }
    // Author: Anand Srivastava Date: 15-Mar-2019
    public function getMetrics(){
        $metrics = $_POST['metricId'];
        $data['metrics']=$this->mdelegate_m->getMetrics($metrics);
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
        $this->mdelegate_m->saveMissing($missingid,$comment,$note,$status,$action,$metric,$assignedID);
        header('Location: ../'.$pageid);
    }
    // function to update the assigned associateid in the missing table 
    function updateworkassignstatus($missingid,$assignedid,$pageid){
        $this->mdelegate_m->updateworkassignstatus($missingid,$assignedid);
        if(strcmp($pageid, "Missing_EOB_Pending")==0){
            $this->mdelegate_m->updateworkassigns($missingid,$assignedid);
        }
        header('Location: ../../../'.$pageid);
    }
    // Author: Anand Srivastava Date: 31-Jan-2019
    public function Work_Queue(){	
        $My_Queue_Data['myqueuedata'] = $this->mdelegate_m->fetch_my_queue();
        $this->load->view('Topbar_view');
		$this->load->view('MDL/Sidebar_view');
		$this->load->view('MDL/My_Queue_view',$My_Queue_Data);
		$this->load->view('Footer_view');
	}
    // Author: Anand Srivastava Date: 15-Mar-2019
    public function Production_Report(){	
        $first_date_find = strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . ", first day of this month");
        $first_date = date("Y-m-d",$first_date_find);
        $sdate = isset($_POST['sdate'])?$_POST['sdate']:$first_date;
        $edate = isset($_POST['edate'])?$_POST['edate']:date("Y-m-d");
        $uedate = date('Y-m-d H:i',strtotime('+23 hour +59 minutes',strtotime($edate)));
        $data['TeamList'] = $this->mdelegate_m->fetch_associateList();
        for($i=0;$i<sizeof($data['TeamList']);$i++){
            $data['production_summary'][$i] = $this->mdelegate_m->production_summary($sdate,$uedate,$data['TeamList'][$i]['AssociateID']);
        }
        $this->load->view('Topbar_view');
		$this->load->view('MDL/Sidebar_view');
        $this->load->view('MDL/Production_Summary_view',$data);
		$this->load->view('Footer_view');
	}
    
}
?>