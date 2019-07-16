<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
    class C_associate extends CI_Controller {
        function __construct(){
            parent::__construct();
            /*$this->output->cache(60);*/
            $this->load->library('session');
            $this->load->helper('url');	
            $this->load->model('associate_m','',TRUE);
            if($this->session->userdata('userdata')[0]->AccessLevel != '2'){
                $this->session->sess_destroy();
                redirect('');
            }
            //Date/Time Zone Variable
            date_default_timezone_set('Asia/Kolkata');
        }
        public function index(){	
            $this->Dashboard();
        }
         // Author: Anand Srivastava Date: 12-Mar-2019
        public function Dashboard(){	
            $sdate =isset($_POST['sdate'])?$_POST['sdate']:date("Y-m-d");
            $edate = date('Y-m-d H:i',strtotime('+23 hour +59 minutes',strtotime($sdate)));
            //Getting the Project Details
            $Dashboard_Data['ProjectList'] = $this->associate_m->fetch_projectlist();
             //Getting Reconcillition data of Clients
            for($i=0;$i<sizeof($Dashboard_Data['ProjectList']);$i++){
                $Dashboard_Data['RECON'][$i] = $this->associate_m->newReconcilliation($Dashboard_Data['ProjectList'][$i]['ProjectID'],$sdate,$edate);
                $Dashboard_Data['CategoryList'][$i] = $this->associate_m->fetch_categorylist($Dashboard_Data['ProjectList'][$i]['ProjectID'],$sdate,$edate);
            }
            $buffer = array();
             for ($i=0; $i <sizeof($Dashboard_Data['CategoryList']) ; $i++) { 
                if(!$Dashboard_Data['CategoryList'][$i]==''){ 
                 for ($j=0; $j < sizeof($Dashboard_Data['CategoryList'][$i]); $j++) { 
                   array_push($buffer,$this->associate_m->newReconcillitionCat($Dashboard_Data['ProjectList'][$i]['ProjectID'],$Dashboard_Data['CategoryList'][$i][$j]['CategoryID'],$sdate,$edate));
                 }
                }
            }
            $Dashboard_Data['RECONCAT']=$buffer;
            ///MTD
            $pmfd = date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1));
            //Last Date of Previous Month
            $pmld = date("Y-m-d", mktime(0, 0, 0, date("m"), 0));
            //Previous Month Today's Date
            $pcdate = strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "-1 months");
            $pmcdate = date("Y-m-d",$pcdate);
            $first_date_find = strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . ", first day of this month");
            $first_date = date("Y-m-d",$first_date_find);
            if((null !== $this->input->post('mtdsdate')) && (null !==$this->input->post('mtdsdate')) ){
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
                $Dashboard_Data['MTD'][$i] = $this->associate_m->mtd_half_fetch($Dashboard_Data['ProjectList'][$i]['ProjectID'],$pmfd,$pmld,$pmcdate,$sdate,$edate,$uedate);
            }
            $this->load->view('Topbar_view');
            $this->load->view('ASP/Sidebar_view');
            $this->load->view('ASP/Report/Dashboard_view',$Dashboard_Data);
            $this->load->view('Footer_view');
        }
        // Author: Anand Srivastava Date: 12-Mar-2019
        public function Production_Summary(){	
            //Date/Time Zone Variable
            date_default_timezone_set('Asia/Kolkata');
            $first_date_find = strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . ", first day of this month");
            $first_date = date("Y-m-d",$first_date_find);
            $sdate = isset($_POST['sdate'])?$_POST['sdate']:$first_date;
            $edate =isset($_POST['edate'])?$_POST['edate']:date("Y-m-d");
            $uedate = date('Y-m-d H:i',strtotime('+23 hour +59 minutes',strtotime($edate)));
            $data['Cl_Names'] = $this->associate_m->fetch_projectlist();
            $data['production_summary'] = $this->associate_m->production_summary($sdate,$uedate);
            $this->load->view('Topbar_view');
            $this->load->view('ASP/Sidebar_view');
            $this->load->view('ASP/Report/Production_Summary_A_view',$data);
            $this->load->view('Footer_view');
        }
        // Author: Anand Srivastava Date: 12-Mar-2019
        public function Report_Section(){
            $reportType = $_POST['Report_Type'];
            $sdate = isset($_POST['mtdsdate'])?$_POST['mtdsdate']:'';
            $edate = isset($_POST['mtdedate'])?$_POST['mtdedate']:'';
            $edate = date('Y-m-d H:i',strtotime('+23 hour +59 minutes',strtotime($edate))); 
            $client[] = $_POST['cl_deplog'];
            if(strcmp($reportType,'TAT_Summary') == 0){
                $STATUS =  $this->associate_m->fetch_tat_summary($client,$sdate,$edate); 
            }
            if(strcmp($reportType,'Encounter_Summary') == 0){
               $STATUS =  $this->associate_m->fetch_encounter_summary($client,$sdate,$edate); 
            }
            if(strcmp($reportType,'Deposit_Log') == 0){
               $STATUS =  $this->associate_m->fetch_deposite_log($client,$sdate,$edate); 
            }
         } 
        // Author: Anand Srivastava Date: 12-Mar-2019
         public function Work_Queue(){	
             $edate =isset($_POST['edate'])?$_POST['edate']:date("Y-m-d");
             $uedate = date('Y-m-d H:i',strtotime('+23 hour +59 minutes',strtotime($edate)));
             $My_Queue_Data['myqueuedata'] = $this->associate_m->fetch_my_queue();
             $My_Queue_Data['PM1'] = $this->associate_m->fetch_assigned_summary();
             $My_Queue_Data['PM2'] = $this->associate_m->fetch_daily_completed_summary($edate,$uedate);
             $My_Queue_Data['PM3'] = $this->associate_m->fetch_daily_cpm_summary($edate,$uedate);
             $this->load->view('Topbar_view');
             $this->load->view('ASP/Sidebar_view');
             $this->load->view('ASP/My_Queue_A_view',$My_Queue_Data);
             $this->load->view('Footer_view');
        }
        // Author: Anand Srivastava Date: 12-Mar-2019
        public function Begin_Work($WorkID){
            $WorkID = base64_decode($WorkID);
            $Count = $this->associate_m->fetch_my_queue_count();
            if($Count[0]['Count']==1){
                $WorkID_Status=$this->associate_m->fetch_workid_status($WorkID);
                if($WorkID_Status[0]['status']==2){
                    $this->associate_m->update_workid_data_start($WorkID);
                    $WorkID_Data['work']=$this->associate_m->fetch_workid_data($WorkID);
                    $this->load->view('Topbar_view');
                    $this->load->view('ASP/Sidebar_view');
                    $this->load->view('ASP/Working_A_view',$WorkID_Data);
                    $this->load->view('Footer_view');
                }
                else{
                    $this->session->set_flashdata('alert',true); 
                    header('Location: ../Work_Queue');
                }
            }
            else{
                $this->associate_m->update_workid_data_start($WorkID);
                $WorkID_Data['work']=$this->associate_m->fetch_workid_data($WorkID);
                $this->load->view('Topbar_view');
                $this->load->view('ASP/Sidebar_view');
                $this->load->view('ASP/Working_A_view',$WorkID_Data);
                $this->load->view('Footer_view');
            }
        }
        // Author: Anand Srivastava Date: 12-Mar-2019
        public function Hold_Queue($WorkID){
            $this->associate_m->update_workid_data_hold($WorkID);
            $this->Work_Queue();
        }
        // Author: Anand Srivastava Date: 12-Mar-2019
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
            $Amount = $this->associate_m->fetch_workid_data_amount($WorkID);
           (float)$pendingamount = (float)$Amount[0]['Amount']- ((float)array_sum($amtinq)+(float)array_sum($camt)+(float)array_sum($cpa)+$totalotherpayment);
            //CPM Batch Wise Update
            for($i=0;$i<sizeof($batchnum);$i++){
                if($i==0){
                    $this->associate_m->update_workid_data_complete($WorkID,$batchnum[$i],$cpa[$i],$note);
                    $TAT = $this->associate_m->fetch_workid_data_tat($batchnum[$i],$cpa[$i]);
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
                    $this->associate_m->update_workid_data_tat($batchnum[$i],$cpa[$i],$TATVAL);
                    //Adding Other Payment (if Any)
                    if($totalotherpayment!=0){
                        $this->associate_m->add_other_payment($batchnum[$i],$baddebt,$incentive,$interest,$noncern,$overpayrec,$forbal,$hospital,$cap,$spm,$pmonpos);
                    }
                }
                else{
                    $WorkID_Split=$this->associate_m->fetch_workid_data_split($WorkID);
                    $this->associate_m->update_workid_data_split($batchnum[$i],$cpa[$i],$note,$WorkID_Split);
                }
            }
            if(array_sum($amtinq)>0){
                for($i=0;$i<sizeof($amtinq);$i++){
                    $WorkID_Query=$this->associate_m->fetch_workid_data_query($WorkID);
                    $this->associate_m->add_query($amtinq[$i],$querycom[$i],$WorkID_Query);      
                }
            }
            if(array_sum($camt)>0){
                for($i=0;$i<sizeof($camt);$i++){
                    $MissingTL_ID=$this->associate_m->fetch_missingtl_data();
                    $WorkID_Query=$this->associate_m->fetch_workid_data_query($WorkID);
                    $this->associate_m->add_missing($cpdipage[$i],$website[$i],$available[$i],$mcomment[$i],$checknum[$i],$camt[$i],$sdate[$i],$MissingTL_ID,$WorkID_Query);      
                }
            }
            if($pendingamount>0){
                $WorkID_Split=$this->associate_m->fetch_workid_data_pending($WorkID);
                $this->associate_m->update_workid_data_pending($WorkID_Split,$pendingamount);             
            }
            header('Location: ../Work_Queue');
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
            $Amount = $this->associate_m->fetch_missingid_data_checkamount($missingid);
            (float)$pendingamount = (float)$Amount[0]['CheckAmt']- ((float)array_sum($cpa)+$totalotherpayment);
            for($i=0;$i<sizeof($batchnum);$i++){
                $this->associate_m->update_missingid_status($missingid);
                $MissingID_Data=$this->associate_m->fetch_missingid_post_data($missingid);
                $this->associate_m->update_missing_post($batchnum[$i],$cpa[$i],$MissingID_Data);
                $TAT = $this->associate_m->fetch_workid_data_tat($batchnum[$i],$cpa[$i]);
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
                $this->associate_m->update_workid_data_tat($batchnum[$i],$cpa[$i],$TATVAL);
                //Adding Other Payment (if Any)
                }
            if($totalotherpayment>0){
                $this->associate_m->add_other_payment($batchnum[0],$baddebt,$incentive,$interest,$noncern,$overpayrec,$forbal,$hospital,$cap,$spm,$pmonpos);
            }
            if($pendingamount>0){
                $MissingID_Split=$this->associate_m->fetch_missingid_data_pending($missingid);
                $this->associate_m->update_missingid_data_pending($MissingID_Split,$pendingamount);         
            }
            $this->Missing_EOB_Ready();
        }
        // Author: Anand Srivastava Date: 14-Mar-2019
        public function Missing_EOB_Pending(){
            $Missing_EOB_Data['MEOB'] = $this->associate_m->fetch_missing_eob_pending();
            $this->load->view('Topbar_view');
            $this->load->view('ASP/Sidebar_view');
            $this->load->view('ASP/Missing/Missing_Pending_view',$Missing_EOB_Data);
            $this->load->view('Footer_view');
        }
        // Author: Anand Srivastava Date: 14-Mar-2019
        public function Missing_EOB_Ready(){
            $Missing_EOB_Data['MEOB'] = $this->associate_m->fetch_missing_eob_ready();
            $this->load->view('Topbar_view');
            $this->load->view('ASP/Sidebar_view');
            $this->load->view('ASP/Missing/Missing_Ready_view',$Missing_EOB_Data);
            $this->load->view('Footer_view');
        }
        // Author: Anand Srivastava Date: 14-Mar-2019
        public function Missing_EOB_Posted(){
            $Missing_EOB_Data['MEOB'] = $this->associate_m->fetch_missing_eob_posted();
            $this->load->view('Topbar_view');
            $this->load->view('ASP/Sidebar_view');
            $this->load->view('ASP/Missing/Missing_Posted_view',$Missing_EOB_Data);
            $this->load->view('Footer_view');
        }
        // Author: Anand Srivastava Date: 14-Mar-2019
        public function Missing_Post($missingid){
            $MissingID_Data['work']=$this->associate_m->fetch_missingid_data($missingid);
            $this->load->view('Topbar_view');
            $this->load->view('ASP/Sidebar_view');
            $this->load->view('ASP/Missing/MissingWorking_A_view',$MissingID_Data);
            $this->load->view('Footer_view');
        }
         // Author: Anand Srivastava Date: 14-Mar-2019
        public function Query_Pending(){
            $Query_Data['Query'] = $this->associate_m->fetch_query_pending();
           // print_r($Query_Data);
            $this->load->view('Topbar_view');
            $this->load->view('ASP/Sidebar_view');
            $this->load->view('ASP/Query/Query_Pending_view',$Query_Data);
            $this->load->view('Footer_view');
        }
        // Author: Anand Srivastava Date: 14-Mar-2019
        public function Query_Ready(){
            $Query_Data['Query'] = $this->associate_m->fetch_query_ready();
            $this->load->view('Topbar_view');
            $this->load->view('ASP/Sidebar_view');
            $this->load->view('ASP/Query/Query_Ready_view',$Query_Data);
            $this->load->view('Footer_view');
        }
        // Author: Anand Srivastava Date: 14-Mar-2019
        public function Query_Posted(){
            $Query_Data['Query'] = $this->associate_m->fetch_query_posted();
            $this->load->view('Topbar_view');
            $this->load->view('ASP/Sidebar_view');
            $this->load->view('ASP/Query/Query_Posted_view',$Query_Data);
            $this->load->view('Footer_view');
        }
        // Author: Anand Srivastava Date: 14-Mar-2019
        public function Query_Post($queryid){
            $QueryID_Data['work']=$this->associate_m->fetch_queryid_data($queryid);
            //print_r($QueryID_Data);
            $this->load->view('Topbar_view');
            $this->load->view('ASP/Sidebar_view');
            $this->load->view('ASP/Query/QueryWorking_A_view',$QueryID_Data);
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
            $batchnum = isset($_POST['batchnum']) ? $_POST['batchnum'] : array(0);
            $cpa = isset($_POST['cpa']) ? $_POST['cpa'] : array(0,0,0);
            //Pending Amount
            $Amount = $this->associate_m->fetch_queryid_data_checkamount($queryid);
            (float)$pendingamount = (float)$Amount[0]['amtinq']- ((float)array_sum($cpa)+$totalotherpayment);
            for($i=0;$i<sizeof($batchnum);$i++){
                $this->associate_m->update_query_status($queryid);
                $MissingID_Data=$this->associate_m->fetch_query_post_data($queryid);
                $this->associate_m->update_missing_post($batchnum[$i],$cpa[$i],$MissingID_Data);
                $TAT = $this->associate_m->fetch_workid_data_tat($batchnum[$i],$cpa[$i]);
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
                $this->associate_m->update_workid_data_tat($batchnum[$i],$cpa[$i],$TATVAL);
                //Adding Other Payment (if Any)
                }
            if($totalotherpayment>0){
                $this->associate_m->add_other_payment($batchnum[0],$baddebt,$incentive,$interest,$noncern,$overpayrec,$forbal,$hospital,$cap,$spm,$pmonpos);
            }
            if($pendingamount>0){
                $QueryID_Split=$this->associate_m->fetch_queryid_data_pending($queryid);
                $this->associate_m->update_queryid_data_pending($QueryID_Split,$pendingamount);         
            }
            $this->Query_Ready();
        }
        
    }
?>