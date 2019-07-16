<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class C_teamlead extends CI_Controller {
	function __construct(){
        parent::__construct();
       /* $this->output->cache(60);*/
		$this->load->library('session');
		$this->load->helper('url');	
        $this->load->model('teamlead_m','',TRUE);
        if($this->session->userdata('userdata')[0]->AccessLevel != '4'){
                $this->session->sess_destroy();
                redirect('');
        }
        //Date/Time Zone Variable
        date_default_timezone_set('Asia/Kolkata');
    }
	public function index(){
        //      DASHBOARD START
        $first_date_find = strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . ", first day of this month");
        $first_date = date("Y-m-d",$first_date_find);
        $edate=date("Y-m-d");
        $uedate = date('Y-m-d H:i',strtotime('+23 hour +59 minutes',strtotime($edate)));
        $Dashboard_Data['ProjectList']= $this->teamlead_m->fetch_projectlist();        
        if(!$Dashboard_Data['ProjectList']==''){
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
        }
        else{
            $facility_id = 0;
        }
        $Dashboard_Data['influx'] = $this->teamlead_m->fetch_dashboard_data($facility_id,$first_date,$uedate);
        //      DASHBOARD END
        //      RECON START
        $rsdate =isset($_POST['sdate'])?$_POST['sdate']:date("Y-m-d");
        $redate = date('Y-m-d H:i',strtotime('+23 hour +59 minutes',strtotime($rsdate)));
        //Getting Reconcillition data of Clients
        if(!$Dashboard_Data['ProjectList']==''){
            for($i=0;$i<sizeof($Dashboard_Data['ProjectList']);$i++){
                $Dashboard_Data['RECON'][$i] = $this->teamlead_m->newReconcilliation($Dashboard_Data['ProjectList'][$i]['ProjectID'],$rsdate,$redate);
                $Dashboard_Data['CategoryList'][$i] = $this->teamlead_m->fetch_categorylist($Dashboard_Data['ProjectList'][$i]['ProjectID'],$rsdate,$redate);
            }
            $buffer = array();
            for ($i=0; $i <sizeof($Dashboard_Data['CategoryList']) ; $i++) { 
                if(!$Dashboard_Data['CategoryList'][$i]==''){ 
                 for ($j=0; $j < sizeof($Dashboard_Data['CategoryList'][$i]); $j++) { 
                   array_push($buffer,$this->teamlead_m->newReconcillitionCat($Dashboard_Data['ProjectList'][$i]['ProjectID'],$Dashboard_Data['CategoryList'][$i][$j]['CategoryID'],$rsdate,$redate));
                 }
                }
            }
           // print_r($Dashboard_Data); exit;
            $Dashboard_Data['RECONCAT']=$buffer;
            //      RECON END
            //      MTD START
            //First Date of Previous Month  
            $pmfd = date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1));
            //Last Date of Previous Month
            $pmld = date("Y-m-d", mktime(0, 0, 0, date("m"), 0));
            //Previous Month Today's Date
            $pcdate = strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "-1 months");
            $pmcdate = date("Y-m-d",$pcdate);
            //Current Month Dates
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
                $Dashboard_Data['MTD'][$i] = $this->teamlead_m->mtd_half_fetch($Dashboard_Data['ProjectList'][$i]['ProjectID'],$pmfd,$pmld,$pmcdate,$sdate,$edate,$uedate);
            }
            //      MTD END
        }
        $this->load->view('Topbar_view');
		$this->load->view('TLP/Sidebar_view');
		$this->load->view('TLP/Home_view',$Dashboard_Data);
		$this->load->view('Footer_view');
	}
    // Author: Anand Srivastava Date: 15-Mar-2019
    public function Production_Report(){	
        $first_date_find = strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . ", first day of this month");
        $first_date = date("Y-m-d",$first_date_find);
        $sdate = isset($_POST['sdate'])?$_POST['sdate']:$first_date;
        $edate = isset($_POST['edate'])?$_POST['edate']:date("Y-m-d");
        $uedate = date('Y-m-d H:i',strtotime('+23 hour +59 minutes',strtotime($edate)));
        $data['TeamList'] = $this->teamlead_m->fetch_associateList_all();
        $data['Cl_Names']=$this->teamlead_m->fetch_projectlist();
        for($i=0;$i<sizeof($data['TeamList']);$i++){
            $data['production_summary'][$i] = $this->teamlead_m->production_summary($sdate,$uedate,$data['TeamList'][$i]['AssociateID']);
           
        }
        $this->load->view('Topbar_view');
		$this->load->view('TLP/Sidebar_view');
        $this->load->view('TLP/Report/Production_Summary_TL_view',$data);
		$this->load->view('Footer_view');
	}
    // Author: Anand Srivastava Date: 15-Mar-2019
    public function Complete_Queue($WorkID){
        //Missing Queuing Details
        $cpdipage = isset($_POST['cpdipage']) ? $_POST['cpdipage'] : 0;
        $website = isset($_POST['website']) ? $_POST['website'] : 0;
        $available = isset($_POST['available']) ? $_POST['available'] : 0;
        $mcomment = isset($_POST['mcomment']) ? $_POST['mcomment'] : 0;
        $checknum = isset($_POST['checknum']) ? $_POST['checknum'] : 0;
        $camt = isset($_POST['camt']) ? $_POST['camt'] : array(0,0,0);
        $sdate = isset($_POST['sdate']) ? $_POST['sdate'] : 0;
        //Query Queuing Details
        $amtinq = isset($_POST['amtinq']) ? $_POST['amtinq'] : array(0,0,0);
        $querycom = isset($_POST['querycom']) ? $_POST['querycom'] : 0;
        //Other Payment Details 
        $baddebt = isset($_POST['baddebt']) ? $_POST['baddebt'] : 0;
        $incentive = isset($_POST['incentive']) ? $_POST['incentive'] : 0;
        $interest = isset($_POST['interest']) ? $_POST['interest'] : 0;
        $noncern = isset($_POST['noncern']) ? $_POST['noncern'] : 0;
        $overpayrec = isset($_POST['overpayrec']) ? $_POST['overpayrec'] : 0;
        $forbal = isset($_POST['forbal']) ? $_POST['forbal'] : 0;
        $hospital = isset($_POST['hospital']) ? $_POST['hospital'] : 0;
        $cap = isset($_POST['capitation']) ? $_POST['capitation'] : 0;
        $spm = isset($_POST['SPM']) ? $_POST['SPM'] : 0;
        $pmonpos = isset($_POST['pmonpos']) ? $_POST['pmonpos'] : 0;
        //Other Payment Total
        (float)$totalotherpayment = (float)$baddebt+(float)$incentive+(float)$interest+(float)$noncern+(float)$overpayrec+(float)$forbal+(float)$hospital+(float)$cap+(float)$spm+(float)$pmonpos;
        //CPM Batch and Splits
        $batchnum = isset($_POST['batchnum']) ? $_POST['batchnum'] : array(0);
        $cpa = isset($_POST['cpa']) ? $_POST['cpa'] : array(0,0,0);
        $note = isset($_POST['note']) ? $_POST['note'] : 0;
        //Pending Amount
        $Amount = $this->teamlead_m->fetch_workid_data_amount($WorkID);
        (float)$pendingamount = (float)$Amount[0]['Amount']- ((float)array_sum($amtinq)+(float)array_sum($camt)+(float)array_sum($cpa)+$totalotherpayment);
        //CPM Batch Wise Update
        for($i=0;$i<sizeof($batchnum);$i++){
            if($i==0){
                $this->teamlead_m->update_workid_data_complete($WorkID,$batchnum[$i],$cpa[$i],$note);
                $TAT = $this->teamlead_m->fetch_workid_data_tat($batchnum[$i],$cpa[$i]);
                if($TAT[0]['TAT']<24){
                    $TATVAL = "<24 Hrs";
                }
                else if($TAT>=24 && $TAT<36){
                    $TATVAL = "24-36 Hrs";
                }
                else if($TAT>=36 && $TAT<48){
                    $TATVAL = "26-48 Hrs";
                }
                else{
                    $TATVAL = ">48 Hrs";
                }
                $this->teamlead_m->update_workid_data_tat($batchnum[$i],$cpa[$i],$TATVAL);
                //Adding Other Payment (if Any)
                if($totalotherpayment!=0){
                    $this->teamlead_m->add_other_payment($batchnum[$i],$baddebt,$incentive,$interest,$noncern,$overpayrec,$forbal,$hospital,$cap,$spm,$pmonpos);
                }
            }
            else{
                $WorkID_Split=$this->teamlead_m->fetch_workid_data_split($WorkID);
                $this->teamlead_m->update_workid_data_split($batchnum[$i],$cpa[$i],$note,$WorkID_Split);
            }
        }
        if(array_sum($amtinq)>0){
            for($i=0;$i<sizeof($amtinq);$i++){
                $WorkID_Query=$this->teamlead_m->fetch_workid_data_query($WorkID);
                $this->teamlead_m->add_query($amtinq[$i],$querycom[$i],$WorkID_Query);      
            }
        }
        if(array_sum($camt)>0){
            for($i=0;$i<sizeof($camt);$i++){
                $MissingTL_ID=$this->teamlead_m->fetch_missingtl_data();
                $WorkID_Query=$this->teamlead_m->fetch_workid_data_query($WorkID);
                $this->teamlead_m->add_missing($cpdipage[$i],$website[$i],$available[$i],$mcomment[$i],$checknum[$i],$camt[$i],$sdate[$i],$MissingTL_ID,$WorkID_Query);      
            }
        }
        if($pendingamount>0){
            $WorkID_Split=$this->teamlead_m->fetch_workid_data_pending($WorkID);
            $this->teamlead_m->update_workid_data_pending($WorkID_Split,$pendingamount);             
        }
        header('Location: ../Work_Queue');
    }
    // Author: Anand Srivastava Date: 15-Mar-2019
    public function Hold_Queue($WorkID){
        $this->teamlead_m->update_workid_data_hold($WorkID);
        $this->Work_Queue();
    }
    // Author: Anand Srivastava Date: 15-Mar-2019
    public function Begin_Work($WorkID){
        $Count = $this->teamlead_m->fetch_my_queue_count();
        $WorkID = base64_decode($WorkID);
        if($Count[0]['Count']==1){
            $WorkID_Status=$this->teamlead_m->fetch_workid_status($WorkID);
            if($WorkID_Status[0]['status']==2){
                $this->teamlead_m->update_workid_data_start($WorkID);
                $WorkID_Data['work']=$this->teamlead_m->fetch_workid_data($WorkID);
                $this->load->view('Topbar_view');
                $this->load->view('TLP/Sidebar_view');
                $this->load->view('TLP/Working_TL_view',$WorkID_Data);
                $this->load->view('Footer_view');
            }
            else{
                $this->session->set_flashdata('alert',true); 
                header('Location: ../Work_Queue');
            }
        }
        else{
            $this->teamlead_m->update_workid_data_start($WorkID);
            $WorkID_Data['work']=$this->teamlead_m->fetch_workid_data($WorkID);
            $this->load->view('Topbar_view');
            $this->load->view('TLP/Sidebar_view');
            $this->load->view('TLP/Working_TL_view',$WorkID_Data);
            $this->load->view('Footer_view');
        }
    }
    // Author: Anand Srivastava Date: 15-Mar-2019
    public function Delete_Log($WorkID,$PageID){
		$this->teamlead_m->delete_log($WorkID);
        header('Location: ../../'.$PageID);
    }
    // Author: Anand Srivastava Date: 31-Jan-2019
    public function Allot_Hold_Log(){
        $Allot_Hold_Log_Data['Cl_Names']= $this->teamlead_m->fetch_projectlist();
        $Allot_Hold_Log_Data['Team_list']= $this->teamlead_m->fetch_teamlist();
       if(!$Allot_Hold_Log_Data['Cl_Names']==''){
            for($i=0;$i<sizeof($Allot_Hold_Log_Data['Cl_Names']);$i++){
                if($i==0){
                    $facility_id = $Allot_Hold_Log_Data['Cl_Names'][$i]['ProjectID'];
                }
                else{
                    $facility_id = $facility_id."','".$Allot_Hold_Log_Data['Cl_Names'][$i]['ProjectID'];
                }
            }
            if(isset($_POST['Facility_Id'])){
                $facility_id = $_POST['Facility_Id'];
            }
        }
        else{
            $facility_id = 0;
        }
        $Allot_Hold_Log_Data['allotdata']=$this->teamlead_m->fetch_hold_log($facility_id);
        $Allot_Hold_Log_Data['team'] =  array($this->teamlead_m->fetch_associateList());
        $this->load->view('Topbar_view');
		$this->load->view('TLP/Sidebar_view');
		$this->load->view('TLP/Allot/Allot_Hold_TL_view',$Allot_Hold_Log_Data);
		$this->load->view('Footer_view');
	}
    // Author: Anand Srivastava Date: 31-Jan-2019
    public function Allot_Pending_Log(){
        $Allot_Pending_Log_Data['Cl_Names']= $this->teamlead_m->fetch_projectlist();
        $Allot_Pending_Log_Data['Team_list']= $this->teamlead_m->fetch_teamlist();
       if(!$Allot_Pending_Log_Data['Cl_Names']==''){
            for($i=0;$i<sizeof($Allot_Pending_Log_Data['Cl_Names']);$i++){
                if($i==0){
                    $facility_id = $Allot_Pending_Log_Data['Cl_Names'][$i]['ProjectID'];
                }
                else{
                    $facility_id = $facility_id."','".$Allot_Pending_Log_Data['Cl_Names'][$i]['ProjectID'];
                }
            }
            if(isset($_POST['Facility_Id'])){
                $facility_id = $_POST['Facility_Id'];
            }
        }
        else{
            $facility_id = 0;
        }
        $Allot_Pending_Log_Data['allotdata']=$this->teamlead_m->fetch_pending_log($facility_id);
        $Allot_Pending_Log_Data['team'] = array($this->teamlead_m->fetch_associateList());
        $this->load->view('Topbar_view');
		$this->load->view('TLP/Sidebar_view');
		$this->load->view('TLP/Allot/Allot_Pending_TL_view',$Allot_Pending_Log_Data);
		$this->load->view('Footer_view');
	}
    // Author: Jagdish Pandre Date: 12-Feb-2019
    public function Allot_Assigned_Log(){
        $Allot_Assigned_Log_Data['Cl_Names']= $this->teamlead_m->fetch_projectlist();
        $Allot_Assigned_Log_Data['Team_list']= $this->teamlead_m->fetch_teamlist();
       if(!$Allot_Assigned_Log_Data['Cl_Names']==''){
            for($i=0;$i<sizeof($Allot_Assigned_Log_Data['Cl_Names']);$i++){
                if($i==0){
                    $facility_id = $Allot_Assigned_Log_Data['Cl_Names'][$i]['ProjectID'];
                }
                else{
                    $facility_id = $facility_id."','".$Allot_Assigned_Log_Data['Cl_Names'][$i]['ProjectID'];
                }
            }
            if(isset($_POST['Facility_Id'])){
                $facility_id = $_POST['Facility_Id'];
            }
        }
        else{
            $facility_id = 0;
        }
        $allotdata = $this->teamlead_m->fetch_assigned_log($facility_id);
        $Team_list = $this->teamlead_m->fetch_teamlist();
        for($i=0; $i <sizeof($allotdata) ; $i++) { 
            $list = $Team_list;
            for($j=0; $j <sizeof($list); $j++) { 
                if($list[$j]['AssociateID'] == $allotdata[$i]['AssignedID']){
                   array_splice($list, $j, 1);
               }
            }
            array_unshift($list,  array('AssociateID' => $allotdata[$i]['AssignedID'],'AssociateName' => $allotdata[$i]['AssociateName']));
            $allotdata[$i]['teamlist'] = $list;
        }
        $Allot_Assigned_Log_Data['allotdata'] = $allotdata;
        $Allot_Assigned_Log_Data['team'] = array($this->teamlead_m->fetch_associateList());
        $this->load->view('Topbar_view');
        $this->load->view('TLP/Sidebar_view');
        $this->load->view('TLP/Allot/Allot_Assigned_TL_view',$Allot_Assigned_Log_Data);
        $this->load->view('Footer_view');
    }
    // Author: Anand Srivastava Date: 31-Jan-2019
    public function Allot_Archive_Log(){
        $Allot_Archive_Log_Data['Cl_Names']= $this->teamlead_m->fetch_projectlist();
        $Allot_Archive_Log_Data['Team_list']= $this->teamlead_m->fetch_associateList();
        if(!$Allot_Archive_Log_Data['Cl_Names']==''){
            for($i=0;$i<sizeof($Allot_Archive_Log_Data['Cl_Names']);$i++){
                if($i==0){
                    $facility_id = $Allot_Archive_Log_Data['Cl_Names'][$i]['ProjectID'];
                }
                else{
                    $facility_id = $facility_id."','".$Allot_Archive_Log_Data['Cl_Names'][$i]['ProjectID'];
                }
            }
            if(isset($_POST['Facility_Id'])){
                $facility_id = $_POST['Facility_Id'];
            }
        }
        else{
            $facility_id = 0;
        }
        $Allot_Archive_Log_Data['allotdata']=$this->teamlead_m->fetch_completed_log($facility_id);
        $this->load->view('Topbar_view');
		$this->load->view('TLP/Sidebar_view');
		$this->load->view('TLP/Allot/Allot_Archive_TL_view',$Allot_Archive_Log_Data);
		$this->load->view('Footer_view');
	}
    // Author: Anand Srivastava Date: 31-Jan-2019
    public function Allot_Log(){
        $Allot_Log_Data['Cl_Names']= $this->teamlead_m->fetch_projectlist();
        $Allot_Log_Data['Team_list']= $this->teamlead_m->fetch_associateList();
        if(!$Allot_Log_Data['Cl_Names']==''){
            for($i=0;$i<sizeof($Allot_Log_Data['Cl_Names']);$i++){
                if($i==0){
                    $facility_id = $Allot_Log_Data['Cl_Names'][$i]['ProjectID'];
                }
                else{
                    $facility_id = $facility_id."','".$Allot_Log_Data['Cl_Names'][$i]['ProjectID'];
                }
            }
            if(isset($_POST['Facility_Id'])){
                $facility_id = $_POST['Facility_Id'];
            }
        }
        else{
            $facility_id = 0;
        }
        $Allot_Log_Data['allotdata'] = $this->teamlead_m->fetch_unassigned_log($facility_id);
        $Allot_Log_Data['team'] = array($this->teamlead_m->fetch_teamlist());
        $this->load->view('Topbar_view');
		$this->load->view('TLP/Sidebar_view');
		$this->load->view('TLP/Allot/Allot_TL_view',$Allot_Log_Data);
		$this->load->view('Footer_view');
	}
    // Author: Anand Srivastava Date: 31-Jan-2019
    public function Upload_Log($pageid){
		if (isset($_POST['Facility_Id']) ){
    		$facility_id = $_POST['Facility_Id'];
            $this->teamlead_m->take_import_log($facility_id);
            $this->session->set_flashdata('success',true); 
            header('Location: ../'.$pageid);
    	}
	}
    // Author: Anand Srivastava Date: 31-Jan-2019
    public function Upload_CPM($pageid){
        $this->teamlead_m->take_import_cpm();
        $Numeration_Value = $this->teamlead_m->calculate_numertions();
        $Numeration_Size = sizeof($Numeration_Value);
        if(!empty($Numeration_Value)){
            for ($x = 0; $x < $Numeration_Size; $x++) {
                $this->teamlead_m->update_numertions_value($Numeration_Value);
            }
        }
        $this->session->set_flashdata('success',true); 
        header('Location: ../'.$pageid);
	}
    // Author: Anand Srivastava Date: 31-Jan-2019
    public function Work_Queue(){
        $edate =isset($_POST['edate'])?$_POST['edate']:date("Y-m-d");
        $uedate = date('Y-m-d H:i',strtotime('+23 hour +59 minutes',strtotime($edate)));
        $My_Queue_Data['myqueuedata'] = $this->teamlead_m->fetch_my_queue();
        $My_Queue_Data['PM1'] = $this->teamlead_m->fetch_assigned_summary();
        $My_Queue_Data['PM2'] = $this->teamlead_m->fetch_daily_completed_summary($edate,$uedate);
        $My_Queue_Data['PM3'] = $this->teamlead_m->fetch_daily_cpm_summary($edate,$uedate);
        $this->load->view('Topbar_view');
		$this->load->view('TLP/Sidebar_view');
		$this->load->view('TLP/My_Queue_TL_view',$My_Queue_Data);
		$this->load->view('Footer_view');
	}
    // Missing Working Starts
    // Author: Anand Srivastava Date: 15-Mar-2019
    public function missingworking($missingid,$pageid){
        $missingid = base64_decode($missingid);
        $pageid = base64_decode($pageid);
        $data['status'] = array('0' => $pageid);
        $data['missingid'] =  array('0' =>  $missingid);
        $data['missingworkingdata'] = $this->teamlead_m->missingworking($missingid);
        $data['get_stat'] = $this->teamlead_m->fetch_Status();
        $data['Team_list']= $this->teamlead_m->fetch_teamlist();
        $this->load->view('Topbar_view');
        $this->load->view('TLP/Sidebar_view');
        $this->load->view('TLP/Missing_EOB/Missing_Working_TL_view',$data);
        $this->load->view('Footer_view');
    }
    // Author: Anand Srivastava Date: 15-Mar-2019
    public function getActions(){
        $status = $_POST['statusId'];
        $data['actions']=$this->teamlead_m->getActions($status);
        echo json_encode($data);
    }
    // Author: Anand Srivastava Date: 15-Mar-2019
    public function getMetrics(){
        $metrics = $_POST['metricId'];
        $data['metrics']=$this->teamlead_m->getMetrics($metrics);
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
        $this->teamlead_m->saveMissing($missingid,$comment,$note,$status,$action,$metric);
        header('Location: ../'.$pageid);
    }
    # Missing EOB Pending Listing Page
    public function Missing_EOB_Pending(){  
        $team = array($this->teamlead_m->fetch_associateList());
        for($i=0;$i<sizeof($team[0]);$i++){
            if($i==0){
                $teams = $team[0][$i]['AssociateID'];
            }
            else{
                $teams = $teams."','".$team[0][$i]['AssociateID'];
            }
        }
        $test = array();
        array_push($test,$this->teamlead_m->fetch_missing_eob_pending($teams));
        $Missing_EOB_Pending_Data['team'] = $team;
        $Missing_EOB_Pending_Data['missingeobpendingdata'] = $test;
        $this->load->view('Topbar_view');
        $this->load->view('TLP/Sidebar_view');
        $this->load->view('TLP/Missing_EOB/Missing_EOB_Pending_TL_view',$Missing_EOB_Pending_Data);
        $this->load->view('Footer_view');
    }
    // Missing EOB Resolved Listing Page
    public function Missing_EOB_Resolved(){	
        $team = array($this->teamlead_m->fetch_associateList());
        for($i=0;$i<sizeof($team[0]);$i++){
            if($i==0){
                $teams = $team[0][$i]['AssociateID'];
            }
            else{
                $teams = $teams."','".$team[0][$i]['AssociateID']; 
            }
        }
        $test = array();
        array_push($test,$this->teamlead_m->fetch_missing_eob_resolved($teams));
        $Missing_EOB_Resolved_Data['team'] = $team;
        $Missing_EOB_Resolved_Data['missingeobresolveddata'] = $test;
        $this->load->view('Topbar_view');
		$this->load->view('TLP/Sidebar_view');
		$this->load->view('TLP/Missing_EOB/Missing_EOB_Resolved_TL_view',$Missing_EOB_Resolved_Data);
		$this->load->view('Footer_view');
	}
    // Missing EOB Archive Listing Page
    public function Missing_EOB_Archive(){	
        $team = array($this->teamlead_m->fetch_associateList());
        for($i=0;$i<sizeof($team[0]);$i++){
            if($i==0){
                $teams = $team[0][$i]['AssociateID'];
            }
            else{
                $teams = $teams."','".$team[0][$i]['AssociateID']; 
            }
        }
        $test = array();
        array_push($test,$this->teamlead_m->fetch_missing_eob_archive($teams));
        $Missing_EOB_Archive_Data['missingeobarchivedata'] = $test;
        $this->load->view('Topbar_view');
		$this->load->view('TLP/Sidebar_view');
		$this->load->view('TLP/Missing_EOB/Missing_EOB_Archive_TL_view',$Missing_EOB_Archive_Data);
		$this->load->view('Footer_view');
	}
   // Missing EOB Assigned Listing Page
    public function Missing_EOB_Assigned(){ 
        $team = array($this->teamlead_m->fetch_associateList());
        for($i=0;$i<sizeof($team[0]);$i++){
            if($i==0){
                $teams = $team[0][$i]['AssociateID'];
            }
            else{
                $teams = $teams."','".$team[0][$i]['AssociateID']; 
            }
        }
        $test = array();
        array_push($test,$this->teamlead_m->fetch_missing_eob_assigned($teams));
        $Missing_EOB_Assigned_Data['team'] = $team;
        $Missing_EOB_Assigned_Data['missingeobassigneddata'] = $test;
        $this->load->view('Topbar_view');
        $this->load->view('TLP/Sidebar_view');
        $this->load->view('TLP/Missing_EOB/Missing_EOB_Assigned_TL_view',$Missing_EOB_Assigned_Data);
        $this->load->view('Footer_view');
    }
    // Missing EOB Assigned Listing Page
    public function Missing_EOB_Issues(){ 
        $team = array($this->teamlead_m->fetch_associateList());
        for($i=0;$i<sizeof($team[0]);$i++){
            if($i==0){
                $teams = $team[0][$i]['AssociateID'];
            }
            else{
                $teams = $teams."','".$team[0][$i]['AssociateID']; 
            }
        }
        $test = array();
        array_push($test,$this->teamlead_m->fetch_missing_eob_issues($teams));
        $Missing_EOB_Issues_Data['team'] = $team;
        $Missing_EOB_Issues_Data['missingeobissuesdata'] = $test;
        $this->load->view('Topbar_view');
        $this->load->view('TLP/Sidebar_view');
        $this->load->view('TLP/Missing_EOB/Missing_EOB_Issues_TL_view',$Missing_EOB_Issues_Data);
        $this->load->view('Footer_view');
    }
    // function to update the assigned associateid in the missing table 
    function updateworkassignstatus($missingid,$assignedid,$pageid){
        $this->teamlead_m->updateworkassignstatus($missingid,$assignedid);
        header('Location: ../../../'.$pageid);
    }
    //Query Log Begins
	public function Query_Log(){	
        $team = array($this->teamlead_m->fetch_teamlist());
        if(!empty($team[0])) {
            for($i=0;$i<sizeof($team[0]);$i++){
                if($i==0){
                    $teams = $team[0][$i]['AssociateID'];
                }
                else{
                    $teams = $teams."','".$team[0][$i]['AssociateID'];
                }
            }
        }
        else{
            $teams = 0;
        }
        $test = array();
        array_push($test,$this->teamlead_m->fetch_query_log_pending($teams));
        $Query_Log_Data['querylogdata'] = $test;
        $this->load->view('Topbar_view');
		$this->load->view('TLP/Sidebar_view');
		$this->load->view('TLP/Query/Query_Log_TL_view',$Query_Log_Data);
		$this->load->view('Footer_view');
	}
    // Author: Anand Srivastava Date: 15-Mar-2019
    public function Query_Log_Archive(){	
        $team = array($this->teamlead_m->fetch_teamlist());
        if(!empty($team[0])) {
            for($i=0;$i<sizeof($team[0]);$i++){
                if($i==0){
                    $teams = $team[0][$i]['AssociateID'];
                }
                else{
                    $teams = $teams."','".$team[0][$i]['AssociateID'];
                }
            }
        }
        else{
            $teams = 0;
        }
        $test = array();
        array_push($test,$this->teamlead_m->fetch_query_log_archive($teams));
        $Query_Log_Archive_Data['querylogarchivedata'] = $test;
        $this->load->view('Topbar_view');
		$this->load->view('TLP/Sidebar_view');
		$this->load->view('TLP/Query/Query_Log_Archive_TL_view',$Query_Log_Archive_Data);
		$this->load->view('Footer_view');
	}
     // Author: Anand Srivastava Date: 15-Mar-2019
    public function Query_Log_Posted(){	
        $team = array($this->teamlead_m->fetch_teamlist());
        if(!empty($team[0])) {
            for($i=0;$i<sizeof($team[0]);$i++){
                if($i==0){
                    $teams = $team[0][$i]['AssociateID'];
                }
                else{
                    $teams = $teams."','".$team[0][$i]['AssociateID'];
                }
            }
        }
        else{
            $teams = 0;
        }
        $test = array();
        array_push($test,$this->teamlead_m->fetch_query_log_posted($teams));
        $Query_Log_Posted_Data['querylogdata'] = $test;
        $this->load->view('Topbar_view');
		$this->load->view('TLP/Sidebar_view');
		$this->load->view('TLP/Query/Query_Log_Posted_TL_view',$Query_Log_Posted_Data);
		$this->load->view('Footer_view');
	}
    // Author: Anand Srivastava Date: 15-Mar-2019
    public function Query_Working($queryid){
        $queryid = base64_decode($queryid);
        $QueryWorkingData['get_stat'] = $this->teamlead_m->fetch_Status();
        $QueryWorkingData['queryidworkingdata'] = $this->teamlead_m->query_working($queryid);
        $QueryWorkingData['Team_list'] = $this->teamlead_m->fetch_teamlist_active();
        $this->load->view('Topbar_view');
        $this->load->view('TLP/Sidebar_view');
        $this->load->view('TLP/Query/Query_Working_TL_View',$QueryWorkingData);
        $this->load->view('Footer_view');   
    }
    // Author: Anand Srivastava Date: 15-Mar-2019
    public function Save_Query_Working(){
        $queryid = $this->input->post('queryid');
        $assign = $this->input->post('assign');
        $note = $this->input->post('note');
        $comment = $this->input->post('comment');
        $status = $this->input->post('status');
        $associateid = $this->session->userdata('userdata')[0]->AssociateID;
        $assignedid = $this->input->post('assignedid');
        $finalComment = $comment."\n".$associateid." - ".date("Y-m-d H:i:s")." - ".$note;
        $this->teamlead_m->Save_Query_Working($queryid,$finalComment,$status,$assignedid);
        $this->Query_Log();
    }
	//Report and Facility List
	public function Report_Facility(){	
		$data['TeamLead_List'] = $this->teamlead_m->fetch_teamleadlist();
		$data['Cl_Names'] = $this->teamlead_m->fetch_projectlist();
		$data['Associate_List'] = $this->teamlead_m->fetch_teamlist();
    	$this->load->view('Topbar_view');
		$this->load->view('TLP/Sidebar_view');
		$this->load->view('TLP/Report/Report_Facility_TL_view',$data);
		$this->load->view('Footer_view');
	}
    //Download Report Fucntion - Anand
	public function Report_Section(){
        $reportType = $_POST['Report_Type'];
        $sdate = isset($_POST['mtdsdate'])?$_POST['mtdsdate']:'';
        $edate = isset($_POST['mtdedate'])?$_POST['mtdedate']:'';
        $edate = date('Y-m-d H:i',strtotime('+23 hour +59 minutes',strtotime($edate))); 
        $client[] = $_POST['cl_deplog'];
        if(strcmp($reportType,'TAT_Summary') == 0){
            $STATUS =  $this->teamlead_m->fetch_tat_summary($client,$sdate,$edate); 
        }
        if(strcmp($reportType,'Encounter_Summary') == 0){
           $STATUS =  $this->teamlead_m->fetch_encounter_summary($client,$sdate,$edate); 
        }
        if(strcmp($reportType,'Deposit_Log') == 0){
           $STATUS =  $this->teamlead_m->fetch_deposite_log($client,$sdate,$edate); 
        }
	 } 
	//FUNCTION TO UPDATED THE FACILITY
	public function updatefacility(){
		if (isset($_POST['facility_id_1']) && isset($_POST['facility_name_0'])){
    		$facility_id_0 = $_POST['facility_id_1'];
    		$facility_name_0 = $_POST['facility_name_0'];
    		$team_lead_client_edit = $_POST['team_lead_client_edit'];
    		$this->teamlead_m->editfacility($facility_id_0,$facility_name_0,$team_lead_client_edit);
			$this->Report_Facility();
		}
	}
    // Author: Jagdish Pandre Date: 15-Mar-2019
	public function deletefacility($projectId){
		$this->teamlead_m->deletefacility($projectId);
		$this->Report_Facility();
	}
    // Author: Jagdish Pandre Date: 15-Mar-2019
	public function addfacility(){
		if (isset($_POST['facility_name_add']) ){
    		$facility_name = $_POST['facility_name_add'];
    		$this->teamlead_m->addfacility($facility_name);
			$this->Report_Facility();
    	}
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
            if($this->teamlead_m->checkassociate($associate_id_add)){
                $this->teamlead_m->addassociate($associate_id_add,$associate_name_add,$associate_initial_add,$access_level_add);
                $this->session->set_flashdata('entry',false); 
            }
            else{
                 $this->session->set_flashdata('entry',true); 
            }
    		header('Location: ../C_teamlead/Report_Facility');
    		/*$this->teamlead_m->addassociate($associate_id_add,$associate_name_add,$associate_initial_add,$access_level_add);
    		$this->Report_Facility();*/
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
	    		$this->teamlead_m->editassociate($associate_id_edit,$associate_name_edit,$associate_initial_edit,$access_level_edit,$team_lead_edit);
    		}
    	$this->Report_Facility();
    }
    // Author: Jagdish Pandre Date: 15-Mar-2019
    public function updateAssociateStatus($AssociateID,$activeStatus){
		$active = $this->teamlead_m->updateAssociateStatus($AssociateID,$activeStatus);
        if($active == 0){
            $this->teamlead_m->migrationworklog($AssociateID);
            $this->teamlead_m->migrationquerylog($AssociateID);
            $this->teamlead_m->migrationresearch($AssociateID);
            
        }
        $this->session->set_flashdata('success',true); 
		header('Location: ../../Report_Facility');
    }
    // Author: Jagdish Pandre Date: 15-Mar-2019
    public function updateworkstatus($workid,$assignid,$pageid){
        $this->teamlead_m->updateworkstatus($workid,$assignid);
        header('Location: ../../../'.$pageid);
    }
    // Author: Anand Srivastava Date: 14-Mar-2019
    public function Query_Pending(){
        $Query_Data['Query'] = $this->teamlead_m->fetch_query_pending();
       // print_r($Query_Data);
        $this->load->view('Topbar_view');
        $this->load->view('TLP/Sidebar_view');
        $this->load->view('TLP/Query/Query_Pending_view',$Query_Data);
        $this->load->view('Footer_view');
    }
    // Author: Anand Srivastava Date: 14-Mar-2019
    public function Query_Ready(){
        $Query_Data['Query'] = $this->teamlead_m->fetch_query_ready();
        $this->load->view('Topbar_view');
        $this->load->view('TLP/Sidebar_view');
        $this->load->view('TLP/Query/Query_Ready_view',$Query_Data);
        $this->load->view('Footer_view');
    }
    // Author: Anand Srivastava Date: 14-Mar-2019
    public function Query_Posted(){
        $Query_Data['Query'] = $this->teamlead_m->fetch_query_posted();
        $this->load->view('Topbar_view');
        $this->load->view('TLP/Sidebar_view');
        $this->load->view('TLP/Query/Query_Posted_view',$Query_Data);
        $this->load->view('Footer_view');
    }
     // Author: Anand Srivastava Date: 14-Mar-2019
    public function Query_Post($queryid){
        $QueryID_Data['work']=$this->teamlead_m->fetch_queryid_data($queryid);
        //print_r($QueryID_Data);
        $this->load->view('Topbar_view');
        $this->load->view('TLP/Sidebar_view');
        $this->load->view('TLP/Query/QueryWorking_A_view',$QueryID_Data);
        $this->load->view('Footer_view');
    }
      // Author: Anand Srivastava Date: 14-Mar-2019
    public function Complete_Query($queryid){
        //Other Payment Details
        $baddebt = isset($_POST['baddebt']) ? $_POST['baddebt'] : 0;
        $incentive = isset($_POST['incentive']) ? $_POST['incentive'] : 0;
        $interest = isset($_POST['interest']) ? $_POST['interest'] : 0;
        $noncern = isset($_POST['noncern']) ? $_POST['noncern'] : 0;
        $overpayrec = isset($_POST['overpayrec']) ? $_POST['overpayrec'] : 0;
        $forbal = isset($_POST['forbal']) ? $_POST['forbal'] : 0;
        $hospital = isset($_POST['hospital']) ? $_POST['hospital'] : 0;
        $cap = isset($_POST['capitation']) ? $_POST['capitation'] : 0;
        $spm = isset($_POST['SPM']) ? $_POST['SPM'] : 0;
        $pmonpos = isset($_POST['pmonpos']) ? $_POST['pmonpos'] : 0;
        //Other Payment Total
        (float)$totalotherpayment = (float)$baddebt+(float)$incentive+(float)$interest+(float)$noncern+(float)$overpayrec+(float)$forbal+(float)$hospital+(float)$cap+(float)$spm+(float)$pmonpos;
        //CPM Batch and Splits
        $batchnum = $_POST['batchnum'];
        $cpa = $_POST['cpa'];
        for($i=0;$i<sizeof($batchnum);$i++){
            $this->teamlead_m->update_query_status($queryid);
            $MissingID_Data=$this->teamlead_m->fetch_query_post_data($queryid);
            $this->teamlead_m->update_missing_post($batchnum[$i],$cpa[$i],$MissingID_Data);
            $TAT = $this->teamlead_m->fetch_workid_data_tat($batchnum[$i],$cpa[$i]);
            if($TAT[0]['TAT']<24){
                $TATVAL = "<24 Hrs";
            }
            else if($TAT>=24 && $TAT<36){
                $TATVAL = "24-36 Hrs";
            }
            else if($TAT>=36 && $TAT<48){
                $TATVAL = "26-48 Hrs";
            }
            else{
                $TATVAL = ">48 Hrs";
            }
            $this->teamlead_m->update_workid_data_tat($batchnum[$i],$cpa[$i],$TATVAL);
            //Adding Other Payment (if Any)
            }
        if($totalotherpayment>0){
            $this->teamlead_m->add_other_payment($batchnum[0],$baddebt,$incentive,$interest,$noncern,$overpayrec,$forbal,$hospital,$cap,$spm,$pmonpos);
        }
        $this->Query_Ready();
    }
     // Author: Anand Srivastava Date: 14-Mar-2019
    public function Missing_Pending(){
        $Missing_EOB_Data['MEOB'] = $this->teamlead_m->fetch_missing_pending();
        $this->load->view('Topbar_view');
        $this->load->view('TLP/Sidebar_view');
        $this->load->view('TLP/Missing_EOB/Missing_Pending_view',$Missing_EOB_Data);
        $this->load->view('Footer_view');
    }
    // Author: Anand Srivastava Date: 14-Mar-2019
    public function Missing_Ready(){
        $Missing_EOB_Data['MEOB'] = $this->teamlead_m->fetch_missing_ready();
        $this->load->view('Topbar_view');
        $this->load->view('TLP/Sidebar_view');
        $this->load->view('TLP/Missing_EOB/Missing_Ready_view',$Missing_EOB_Data);
        $this->load->view('Footer_view');
    }
    // Author: Anand Srivastava Date: 14-Mar-2019
    public function Missing_Posted(){
        $Missing_EOB_Data['MEOB'] = $this->teamlead_m->fetch_missing_posted();
        $this->load->view('Topbar_view');
        $this->load->view('TLP/Sidebar_view');
        $this->load->view('TLP/Missing_EOB/Missing_Posted_view',$Missing_EOB_Data);
        $this->load->view('Footer_view');
    }
     // Author: Anand Srivastava Date: 14-Mar-2019
    public function Missing_Post($missingid){
            $MissingID_Data['work']=$this->teamlead_m->fetch_missingid_data($missingid);
            $this->load->view('Topbar_view');
            $this->load->view('TLP/Sidebar_view');
            $this->load->view('TLP/Missing_EOB/MissingWorking_A_view',$MissingID_Data);
            $this->load->view('Footer_view');
        }
       // Author: Anand Srivastava Date: 14-Mar-2019
    public function Complete_Missing($missingid){
        //Other Payment Details
        $baddebt = isset($_POST['baddebt']) ? $_POST['baddebt'] : 0;
        $incentive = isset($_POST['incentive']) ? $_POST['incentive'] : 0;
        $interest = isset($_POST['interest']) ? $_POST['interest'] : 0;
        $noncern = isset($_POST['noncern']) ? $_POST['noncern'] : 0;
        $overpayrec = isset($_POST['overpayrec']) ? $_POST['overpayrec'] : 0;
        $forbal = isset($_POST['forbal']) ? $_POST['forbal'] : 0;
        $hospital = isset($_POST['hospital']) ? $_POST['hospital'] : 0;
        $cap = isset($_POST['capitation']) ? $_POST['capitation'] : 0;
        $spm = isset($_POST['SPM']) ? $_POST['SPM'] : 0;
        $pmonpos = isset($_POST['pmonpos']) ? $_POST['pmonpos'] : 0;
        //Other Payment Total
        (float)$totalotherpayment = (float)$baddebt+(float)$incentive+(float)$interest+(float)$noncern+(float)$overpayrec+(float)$forbal+(float)$hospital+(float)$cap+(float)$spm+(float)$pmonpos;
        //CPM Batch and Splits
        $batchnum = isset($_POST['batchnum']) ? $_POST['batchnum'] : array(0);
        $cpa = isset($_POST['cpa']) ? $_POST['cpa'] : array(0,0,0);
        //Pending Amount
        $Amount = $this->teamlead_m->fetch_missingid_data_checkamount($missingid);
        (float)$pendingamount = (float)$Amount[0]['CheckAmt']- ((float)array_sum($cpa)+$totalotherpayment);
        for($i=0;$i<sizeof($batchnum);$i++){
            $this->teamlead_m->update_missingid_status($missingid);
            $MissingID_Data=$this->teamlead_m->fetch_missingid_post_data($missingid);
            $this->teamlead_m->update_missing_post($batchnum[$i],$cpa[$i],$MissingID_Data);
            $TAT = $this->teamlead_m->fetch_workid_data_tat($batchnum[$i],$cpa[$i]);
            if($TAT[0]['TAT']<24){
                $TATVAL = "<24 Hrs";
            }
            else if($TAT>=24 && $TAT<36){
                $TATVAL = "24-36 Hrs";
            }
            else if($TAT>=36 && $TAT<48){
                $TATVAL = "26-48 Hrs";
            }
            else{
                $TATVAL = ">48 Hrs";
            }
            $this->teamlead_m->update_workid_data_tat($batchnum[$i],$cpa[$i],$TATVAL);
            //Adding Other Payment (if Any)
            }
        if($totalotherpayment>0){
            $this->teamlead_m->add_other_payment($batchnum[0],$baddebt,$incentive,$interest,$noncern,$overpayrec,$forbal,$hospital,$cap,$spm,$pmonpos);
        }
        if($pendingamount>0){
            $MissingID_Split=$this->teamlead_m->fetch_missingid_data_pending($missingid);
            $this->teamlead_m->update_missingid_data_pending($MissingID_Split,$pendingamount);         
        }
        $this->Missing_Ready();
    }
}
?>