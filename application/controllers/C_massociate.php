<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class C_massociate extends CI_Controller {
	function __construct(){
        parent::__construct();
        /*$this->output->cache(60);*/
		$this->load->library('session');
		$this->load->helper('url');	
        $this->load->model('massociate_m','',TRUE);
        if($this->session->userdata('userdata')[0]->AccessLevel != '12'){
                $this->session->sess_destroy();
                redirect('');
        }
        //Date/Time Zone Variable
        date_default_timezone_set('Asia/Kolkata');
    }
	public function index(){
        $rsdate =isset($_POST['sdate'])?$_POST['sdate']:date("Y-m-d");
        $redate = date('Y-m-d H:i',strtotime('+23 hour +59 minutes',strtotime($rsdate)));
        $Dashboard_Data['ProjectList']= $this->massociate_m->fetch_projectlist();
        for($i=0;$i<sizeof($Dashboard_Data['ProjectList']);$i++){
            if($i==0){
                $facility_id = $Dashboard_Data['ProjectList'][$i]['ProjectID'];
            }
            else{
                $facility_id = $facility_id."','".$Dashboard_Data['ProjectList'][$i]['ProjectID'];
            }
        }
        for($i=0;$i<sizeof($Dashboard_Data['ProjectList']);$i++){
			$Dashboard_Data['recon'][$i] = $this->massociate_m->fetch_dashboard_data($Dashboard_Data['ProjectList'][$i]['ProjectID'],$rsdate,$redate);
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
           $Dashboard_Data['mtd'][$i] = $this->massociate_m->fetch_dashboard_data($Dashboard_Data['ProjectList'][$i]['ProjectID'],$sdate,$uedate);
        }
        $this->load->view('Topbar_view');
		$this->load->view('MAS/Sidebar_view');
		$this->load->view('MAS/Home_view',$Dashboard_Data);
		$this->load->view('Footer_view');
	}
    //Report and Facility List
	public function Report_Facility(){	
        $data['TeamLead_List'] = $this->massociate_m->fetch_teamleadlist();
		$data['Associate_List'] = $this->massociate_m->fetch_teamlist();
    	$this->load->view('Topbar_view');
		$this->load->view('MAS/Sidebar_view');
		$this->load->view('MAS/Report_Facility_view',$data);
		$this->load->view('Footer_view');
	}
    // Missing EOB Resolved Listing Page
    public function Missing_EOB_Resolved(){	
        $team = array($this->massociate_m->fetch_teamlist());
        for($i=0;$i<sizeof($team[0]);$i++){
            if($i==0){
                $teams = $team[0][$i]['AssociateID'];
            }
            else{
                $teams = $teams."','".$team[0][$i]['AssociateID']; 
            }
        }
        $Missing_EOB_Resolved_Data['team'] = $team;
        $Missing_EOB_Resolved_Data['missingeobresolveddata'] = $this->massociate_m->fetch_missing_eob_resolved($teams);
        $this->load->view('Topbar_view');
		$this->load->view('MAS/Sidebar_view');
		$this->load->view('MAS/Missing_EOB_Resolved_view',$Missing_EOB_Resolved_Data);
		$this->load->view('Footer_view');
	}
    // Missing EOB Archive Listing Page
    public function Missing_EOB_Archive(){	
        $team = array($this->massociate_m->fetch_teamlist());
        for($i=0;$i<sizeof($team[0]);$i++){
            if($i==0){
                $teams = $team[0][$i]['AssociateID'];
            }
            else{
                $teams = $teams."','".$team[0][$i]['AssociateID']; 
            }
        }
        $Missing_EOB_Archive_Data['missingeobarchivedata'] = $this->massociate_m->fetch_missing_eob_archive($teams);
        $this->load->view('Topbar_view');
		$this->load->view('MAS/Sidebar_view');
		$this->load->view('MAS/Missing_EOB_Archive_view',$Missing_EOB_Archive_Data);
		$this->load->view('Footer_view');
	}
    // Author: Anand Srivastava Date: 15-Mar-2019
    public function missingworking($missingid,$pageid){
        $missingid = base64_decode($missingid);
        $pageid = base64_decode($pageid);
        $data['status'] = array('0' => $pageid);
        $data['missingid'] =  array('0' =>  $missingid);
        $data['missingworkingdata'] = $this->massociate_m->missingworking($missingid);
        $data['get_stat'] = $this->massociate_m->fetch_Status();
        $data['Team_list']= $this->massociate_m->fetch_teamlist();
        $this->load->view('Topbar_view');
        $this->load->view('MAS/Sidebar_view');
        $this->load->view('MAS/Missing_Working_view',$data);
        $this->load->view('Footer_view');
    }
    // Author: Anand Srivastava Date: 15-Mar-2019
    public function getActions(){
        $status = $_POST['statusId'];
        $data['actions']=$this->massociate_m->getActions($status);
        echo json_encode($data);
    }
    // Author: Anand Srivastava Date: 15-Mar-2019
    public function getMetrics(){
        $metrics = $_POST['metricId'];
        $data['metrics']=$this->massociate_m->getMetrics($metrics);
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
        $this->massociate_m->saveMissing($missingid,$comment,$note,$status,$action,$metric,$assignedID);
        header('Location: ../'.$pageid);
    }
    // function to update the assigned associateid in the missing table 
    function updateworkassignstatus($missingid,$assignedid,$pageid){
        $this->massociate_m->updateworkassignstatus($missingid,$assignedid);
        if(strcmp($pageid, "Missing_EOB_Pending")==0){
            $this->massociate_m->updateworkassigns($missingid,$assignedid);
        }
        header('Location: ../../../'.$pageid);
    }
    // Author: Anand Srivastava Date: 31-Jan-2019
    public function Work_Queue(){	
        $My_Queue_Data['myqueuedata'] = $this->massociate_m->fetch_my_queue();
        $this->load->view('Topbar_view');
		$this->load->view('MAS/Sidebar_view');
		$this->load->view('MAS/My_Queue_view',$My_Queue_Data);
		$this->load->view('Footer_view');
	}
    // Author: Anand Srivastava Date: 15-Mar-2019
    public function Production_Report(){	
        $first_date_find = strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . ", first day of this month");
        $first_date = date("Y-m-d",$first_date_find);
        $sdate = isset($_POST['sdate'])?$_POST['sdate']:$first_date;
        $edate = isset($_POST['edate'])?$_POST['edate']:date("Y-m-d");
        $uedate = date('Y-m-d H:i',strtotime('+23 hour +59 minutes',strtotime($edate)));
        $data['TeamList'] = $this->massociate_m->fetch_associateList();
        for($i=0;$i<sizeof($data['TeamList']);$i++){
            $data['production_summary'][$i] = $this->massociate_m->production_summary($sdate,$uedate,$data['TeamList'][$i]['AssociateID']);
        }
        $this->load->view('Topbar_view');
		$this->load->view('MAS/Sidebar_view');
        $this->load->view('MAS/Production_Summary_view',$data);
		$this->load->view('Footer_view');
	}
    
}
?>