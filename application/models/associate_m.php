<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
    Class associate_m extends CI_Model{
        function __construct(){
            //Date/Time Zone Variable
            date_default_timezone_set('Asia/Kolkata');
        }
        // Author: Anand Srivastava Date: 12-Mar-2019
        function fetch_projectlist(){
            $Login_data = $this->session->userdata('userdata');
            $sql = "select ProjectID,ProjectName from project where status=1 AND Owner='".$Login_data[0]->ManagerID."'";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
        // Author: Anand Srivastava Date: 12-Mar-2019
        function fetch_categorylist($Project_List_ID,$sdate,$edate){
            $sql = "SELECT DISTINCT(CategoryID) FROM worklog WHERE FacilityID=".$Project_List_ID;
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;	
        }
        // Author: Anand Srivastava Date: 12-Mar-2019
        function newReconcilliation($Project_List_ID,$sdate,$edate){
            $Login_data = $this->session->userdata('userdata');
            $sql = "SELECT SUM(priorpendinginventorytoday) as priorpendinginventorytoday, SUM(inventory) as inventory, SUM(CPMTotal) as CPMTotal, SUM(otherpaymentTotal) as otherpaymentTotal,
                SUM(noncerntotal) as noncerntotal, SUM(querytotal) as querytotal, SUM(missingtotal) as missingtotal	FROM (
                    SELECT SUM(Amount) as priorpendinginventorytoday, 0 as inventory, 0 as CPMTotal, 0 as otherpaymentTotal, 0 as noncerntotal, 0 as querytotal, 0 as missingtotal
                    FROM worklog  
                    WHERE worklog.UploadDate NOT BETWEEN '$sdate' AND '$edate' AND worklog.Status!=5 AND FacilityID IN (".$Project_List_ID.") AND worklog.AssignedID ='".$Login_data[0]->AssociateID."'
                UNION ALL
                    SELECT 0 as priorpendinginventorytoday, SUM(Amount) as inventory, 0 as CPMTotal, 0 as otherpaymentTotal, 0 as noncerntotal, 0 as querytotal, 0 as missingtotal
                    FROM worklog 
                    WHERE worklog.UploadDate BETWEEN '$sdate' AND '$edate' AND FacilityID IN (".$Project_List_ID.") AND worklog.AssignedID ='".$Login_data[0]->AssociateID."'
                UNION ALL
                    SELECT 0 as priorpendinginventorytoday, 0 as inventory, sum(claimpaidamount) as CPMTotal, 0 as otherpaymentTotal,0 as noncerntotal, 0 as querytotal, 0 as missingtotal
                    from dailylog
                    RIGHT JOIN worklog on dailylog.batchnumber=worklog.CPM
                    WHERE worklog.PostDate BETWEEN '$sdate' AND '$edate' AND worklog.FacilityID=".$Project_List_ID." AND dailylog.transactiontype='Payment' AND worklog.AssignedID ='".$Login_data[0]->AssociateID."'
                UNION ALL
                    SELECT 0 as priorpendinginventorytoday, 0 as inventory, 0 as CPMTotal, SUM(otherpayment.baddebt) + SUM(otherpayment.incentive) + SUM(otherpayment.interest) + SUM(otherpayment.hospital) + SUM(otherpayment.overpayrec) + SUM(otherpayment.forbal) + SUM(otherpayment.capitation) + SUM(otherpayment.spm) as otherpaymentTotal, 0 as noncerntotal, 0 as querytotal,0 as missingtotal
                    from otherpayment
                    RIGHT JOIN dailylog on otherpayment.Encounter=dailylog.batchnumber
                    RIGHT JOIN worklog on dailylog.batchnumber=worklog.CPM
                    WHERE worklog.PostDate BETWEEN '$sdate' AND '$edate' AND worklog.FacilityID=".$Project_List_ID." AND worklog.AssignedID ='".$Login_data[0]->AssociateID."'
                UNION ALL
                 SELECT 0 as priorpendinginventorytoday, 0 as inventory, 0 as CPMTotal, 0 as otherpaymentTotal, sum(otherpayment.noncern) as noncerntotal, 0 as querytotal,0 as missingtotal
                    from otherpayment
                    RIGHT JOIN worklog on otherpayment.Encounter=worklog.CPM
                    WHERE worklog.PostDate BETWEEN '$sdate' AND '$edate' AND worklog.FacilityID=".$Project_List_ID." AND worklog.AssignedID ='".$Login_data[0]->AssociateID."'
                UNION ALL
                    SELECT 0 as priorpendinginventorytoday, 0 as inventory, 0 as CPMTotal, 0 as otherpaymentTotal,0 as noncerntotal, SUM(querylog.amtinq) as querytotal, 0 as missingtotal
                    FROM querylog  
                    WHERE status= 18 AND querylog.ProjectID IN (".$Project_List_ID.") AND querylog.requestedby = '".$Login_data[0]->AssociateID."'
                UNION ALL
                    SELECT 0 as priorpendinginventorytoday, 0 as inventory, 0 as CPMTotal, 0 as otherpaymentTotal,0 as noncerntotal, 0 as querytotal, SUM(missing.CheckAmt) as missingtotal
                    FROM missing  
                    WHERE status!=33 AND missing.ProjectID=".$Project_List_ID." AND missing.RequestedBy = '".$Login_data[0]->AssociateID."'	    
                ) A";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;    	
        }
        // Author: Anand Srivastava Date: 12-Mar-2019
        function newReconcillitionCat($Project_List_ID,$Categpry_List_ID,$sdate,$edate){
             $Login_data = $this->session->userdata('userdata');
            $sql = "SELECT SUM(priorpendinginventorytoday) as priorpendinginventorytoday, SUM(inventory) as inventory, SUM(CPMTotal) as CPMTotal, SUM(otherpaymentTotal) as otherpaymentTotal,
            SUM(noncerntotal) as noncerntotal, SUM(querytotal) as querytotal, SUM(missingtotal) as missingtotal FROM (
                SELECT SUM(Amount) as priorpendinginventorytoday, 0 as inventory, 0 as CPMTotal, 0 as otherpaymentTotal, 0 as noncerntotal, 0 as querytotal, 0 as missingtotal
                FROM worklog  
                WHERE worklog.UploadDate NOT BETWEEN '$sdate' AND '$edate' AND worklog.Status!=5 AND FacilityID IN (".$Project_List_ID.") AND worklog.CategoryID='$Categpry_List_ID' AND worklog.AssignedID ='".$Login_data[0]->AssociateID."'
            UNION ALL
                SELECT 0 as priorpendinginventorytoday, SUM(Amount) as inventory, 0 as CPMTotal, 0 as otherpaymentTotal, 0 as noncerntotal, 0 as querytotal, 0 as missingtotal
                FROM worklog 
                WHERE worklog.UploadDate BETWEEN '$sdate' AND '$edate' AND FacilityID IN (".$Project_List_ID.") AND worklog.CategoryID ='$Categpry_List_ID' AND worklog.AssignedID ='".$Login_data[0]->AssociateID."'
            UNION ALL
                SELECT 0 as priorpendinginventorytoday, 0 as inventory, sum(claimpaidamount) as CPMTotal, 0 as otherpaymentTotal,0 as noncerntotal, 0 as querytotal, 0 as missingtotal
                from dailylog
                RIGHT JOIN worklog on dailylog.batchnumber=worklog.CPM
                WHERE worklog.PostDate BETWEEN '$sdate' AND '$edate' AND worklog.FacilityID=".$Project_List_ID." AND dailylog.transactiontype='Payment' AND worklog.CategoryID='$Categpry_List_ID' AND worklog.AssignedID ='".$Login_data[0]->AssociateID."'
            UNION ALL
                SELECT 0 as priorpendinginventorytoday, 0 as inventory, 0 as CPMTotal, SUM(otherpayment.baddebt) + SUM(otherpayment.incentive) + SUM(otherpayment.interest) + SUM(otherpayment.hospital) + SUM(otherpayment.overpayrec) + SUM(otherpayment.forbal) + SUM(otherpayment.capitation) + SUM(otherpayment.spm) as otherpaymentTotal, 0 as noncerntotal, 0 as querytotal,0 as missingtotal
                from otherpayment
                RIGHT JOIN dailylog on otherpayment.Encounter=dailylog.batchnumber
                RIGHT JOIN worklog on dailylog.batchnumber=worklog.CPM
                WHERE worklog.PostDate BETWEEN '$sdate' AND '$edate' AND worklog.FacilityID=".$Project_List_ID." AND worklog.CategoryID='$Categpry_List_ID' AND worklog.AssignedID ='".$Login_data[0]->AssociateID."'
            UNION ALL
             SELECT 0 as priorpendinginventorytoday, 0 as inventory, 0 as CPMTotal, 0 as otherpaymentTotal, sum(otherpayment.noncern) as noncerntotal, 0 as querytotal,0 as missingtotal
                from otherpayment
                RIGHT JOIN worklog on otherpayment.Encounter=worklog.CPM
                WHERE worklog.PostDate BETWEEN '$sdate' AND '$edate' AND worklog.FacilityID=".$Project_List_ID." AND worklog.CategoryID='$Categpry_List_ID' AND worklog.AssignedID ='".$Login_data[0]->AssociateID."'
            UNION ALL
                SELECT 0 as priorpendinginventorytoday, 0 as inventory, 0 as CPMTotal, 0 as otherpaymentTotal,0 as noncerntotal, SUM(querylog.amtinq) as querytotal, 0 as missingtotal
                FROM querylog  WHERE status= 18 AND querylog.ProjectID IN (".$Project_List_ID.")  AND querylog.Category='$Categpry_List_ID' AND querylog.requestedby = '".$Login_data[0]->AssociateID."'
            UNION ALL
                SELECT 0 as priorpendinginventorytoday, 0 as inventory, 0 as CPMTotal, 0 as otherpaymentTotal,0 as noncerntotal, 0 as querytotal, SUM(missing.CheckAmt) as missingtotal
                FROM missing  WHERE status!=33 AND missing.ProjectID=".$Project_List_ID." and missing.Category='$Categpry_List_ID' AND missing.RequestedBy = '".$Login_data[0]->AssociateID."'	         
            ) A";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;    	
        }
        // Author: Anand Srivastava Date: 12-Mar-2019
        function mtd_half_fetch($Project_List_ID,$pmfd,$pmld,$pmcdate,$sdate,$edate,$uedate){
            $Login_data = $this->session->userdata('userdata');
            $sql ="SELECT SUM(PMTP) as PMTP, SUM(PMMP) as PMMP, SUM(PMR) as PMR , SUM(TTI) as TTI, SUM(MTDD) as MTDD, SUM(PMP) as PMP, SUM(TPT) as TPT, SUM(MTDPT) as MTDPT,
            SUM(OT) as OT, SUM(NC) as NC, SUM(QA) as QA,SUM(MA) as MA FROM (
                SELECT SUM(`baddebt`)+SUM(`incentive`)+SUM(`interest`)+SUM(`noncern`)+SUM(`overpayrec`)+SUM(`forbal`)+SUM(`hospital`)+SUM(`capitation`) as PMTP, 0 as PMMP, 
                0 as PMR, 0 as TTI, 0 as MTDD, 0 as PMP, 0 as TPT, 0 as MTDPT, 0 as OT, 0 as NC, 0 as QA, 0 as MA FROM `otherpayment`
                RIGHT JOIN dailylog ON otherpayment.Encounter=dailylog.batchnumber 
                RIGHT JOIN worklog ON dailylog.batchnumber=worklog.CPM 
                WHERE worklog.PostDate BETWEEN '$pmfd' AND '$pmld' AND worklog.FacilityID IN (".$Project_List_ID.") AND dailylog.transactiontype='Payment' AND worklog.AssignedID = '".$Login_data[0]->AssociateID."'
            UNION ALL
                SELECT SUM(dailylog.claimpaidamount) as PMTP, 0 as PMMP, 0 as PMR, 0 as TTI, 0 as MTDD, 0 as PMP, 0 as TPT, 0 as MTDPT,0 as OT, 0 as NC, 0 as QA, 0 as MA 
                FROM `dailylog` 
                RIGHT JOIN worklog ON dailylog.batchnumber=worklog.CPM 
                WHERE worklog.PostDate BETWEEN '$pmfd' AND '$pmld' AND worklog.FacilityID IN (".$Project_List_ID.") AND dailylog.transactiontype='Payment' AND worklog.AssignedID = '".$Login_data[0]->AssociateID."'
            UNION ALL
                SELECT 0 as PMTP, SUM(`baddebt`)+SUM(`incentive`)+SUM(`interest`)+SUM(`noncern`)+SUM(`overpayrec`)+SUM(`forbal`)+SUM(`hospital`)+SUM(`capitation`) as PMMP, 0 as PMR, 0 as TTI, 0 as MTDD, 0 as PMP, 0 as TPT, 0 as MTDPT, 0 as OT, 0 as NC, 0 as QA, 0 as MA 
                FROM `otherpayment` 
                RIGHT JOIN dailylog ON otherpayment.Encounter=dailylog.batchnumber 
                RIGHT JOIN worklog ON dailylog.batchnumber=worklog.CPM 
                WHERE worklog.PostDate BETWEEN '$pmfd' AND '$pmcdate' AND worklog.FacilityID IN (".$Project_List_ID.") AND dailylog.transactiontype='Payment' AND worklog.AssignedID = '".$Login_data[0]->AssociateID."'
            UNION ALL
                SELECT 0 as PMTP, SUM(dailylog.claimpaidamount) as PMMP, 0 as PMR, 0 as TTI, 0 as MTDD, 0 as PMP, 0 as TPT, 0 as MTDPT,0 as OT, 0 as NC, 0 as QA, 0 as MA 
                FROM `dailylog` 
                RIGHT JOIN worklog ON dailylog.batchnumber=worklog.CPM 
                WHERE worklog.PostDate BETWEEN '$pmfd' AND '$pmcdate' AND worklog.FacilityID IN (".$Project_List_ID.") AND dailylog.transactiontype='Payment' AND worklog.AssignedID = '".$Login_data[0]->AssociateID."'   
            UNION ALL
                SELECT 0 as PMTP,0 as PMMP, SUM(worklog.Amount) as PMR, 0 as TTI, 0 as MTDD, 0 as PMP, 0 as TPT, 0 as MTDPT,0 as OT, 0 as NC, 0 as QA, 0 as MA 
                FROM worklog
                WHERE worklog.UploadDate BETWEEN  '$pmfd' AND '$pmld' AND worklog.FacilityID IN (".$Project_List_ID.") AND worklog.Status!=5 AND worklog.AssignedID = '".$Login_data[0]->AssociateID."'
            UNION ALL
                SELECT 0 as PMTP,0 as PMMP, 0 as PMR, SUM(worklog.Amount) as TTI, 0 as MTDD, 0 as PMP, 0 as TPT, 0 as MTDPT ,0 as OT, 0 as NC, 0 as QA, 0 as MA 
                FROM worklog 
                WHERE worklog.UploadDate BETWEEN '$edate' AND '$uedate' AND worklog.FacilityID IN (".$Project_List_ID.") AND worklog.AssignedID = '".$Login_data[0]->AssociateID."'
            UNION ALL
                SELECT 0 as PMTP,0 as PMMP, 0 as PMR, 0 as TTI, SUM(w.Amount) as MTDD, 0 as PMP, 0 as TPT, 0 as MTDPT ,0 as OT, 0 as NC, 0 as QA,0 as MA FROM worklog w 
                WHERE w.UploadDate BETWEEN '$sdate' AND '$uedate' AND w.FacilityID IN (".$Project_List_ID.") AND w.AssignedID = '".$Login_data[0]->AssociateID."'
            UNION ALL
                SELECT 0 as PMTP,0 as PMMP, 0 as PMR, 0 as TTI, 0 as MTDD, SUM(otherpayment.pmonpos) as PMP, 0 as TPT, 0 as MTDPT,0 as OT, 0 as NC, 0 as QA,0 as MA  
                FROM `otherpayment` 
                RIGHT JOIN dailylog ON otherpayment.Encounter=dailylog.batchnumber
                RIGHT JOIN worklog ON dailylog.batchnumber=worklog.CPM AND dailylog.transactiontype='Payment'
                WHERE worklog.PostDate  BETWEEN  '$sdate' AND '$uedate' AND worklog.FacilityID IN (".$Project_List_ID.") AND worklog.AssignedID = '".$Login_data[0]->AssociateID."'
            UNION ALL
                SELECT 0 as PMTP,0 as PMMP, 0 as PMR, 0 as TTI, 0 as MTDD, 0 as PMP, SUM(claimpaidamount) as TPT, 0 as MTDPT,0 as OT, 0 as NC, 0 as QA,0 as MA
                FROM `dailylog` 
                RIGHT JOIN worklog ON dailylog.batchnumber=worklog.CPM AND dailylog.transactiontype='Payment'
                WHERE worklog.PostDate BETWEEN '$edate' AND '$uedate' AND worklog.FacilityID IN (".$Project_List_ID.") AND worklog.AssignedID = '".$Login_data[0]->AssociateID."'
            UNION ALL
                SELECT 0 as PMTP,0 as PMMP, 0 as PMR, 0 as TTI, 0 as MTDD, 0 as PMP, 0 as TPT, SUM(claimpaidamount) as MTDPT,0 as OT, 0 as NC, 0 as QA,0 as MA
                FROM `dailylog` 
                RIGHT JOIN worklog ON dailylog.batchnumber=worklog.CPM AND dailylog.transactiontype='Payment'
                WHERE worklog.PostDate  BETWEEN  '$sdate' AND '$uedate' AND worklog.FacilityID IN (".$Project_List_ID.") AND worklog.AssignedID = '".$Login_data[0]->AssociateID."'
            UNION ALL
                SELECT 0 as PMTP,0 as PMMP, 0 as PMR, 0 as TTI, 0 as MTDD, 0 as PMP, 0 as TPT, 0 as MTDPT, SUM(`baddebt`)+SUM(`incentive`)+ SUM(`interest`)+ SUM(`noncern`)+ SUM(`overpayrec`)+ SUM(`forbal`)+ SUM(`hospital`)+ SUM(`capitation`) as OT, 0 as NC, 0 as QA,0 as MA
                FROM `otherpayment` 
                RIGHT JOIN dailylog ON otherpayment.Encounter=dailylog.batchnumber
                RIGHT JOIN worklog ON dailylog.batchnumber=worklog.CPM AND dailylog.transactiontype='Payment'
                WHERE worklog.PostDate  BETWEEN  '$sdate' AND '$uedate' AND worklog.FacilityID IN (".$Project_List_ID.") AND worklog.AssignedID = '".$Login_data[0]->AssociateID."'
            UNION ALL
             SELECT 0 as PMTP,0 as PMMP, 0 as PMR, 0 as TTI, 0 as MTDD, 0 as PMP, 0 as TPT, 0 as MTDPT, 0 as OT, SUM(`noncern`) as NC, 0 as QA,0 as MA
                FROM `otherpayment` 
                RIGHT JOIN worklog ON otherpayment.Encounter=worklog.CPM 
                WHERE worklog.PostDate  BETWEEN  '$sdate' AND '$uedate' AND worklog.FacilityID IN (".$Project_List_ID.") AND worklog.AssignedID = '".$Login_data[0]->AssociateID."'
            UNION ALL
                SELECT 0 as PMTP,0 as PMMP, 0 as PMR, 0 as TTI, 0 as MTDD, 0 as PMP, 0 as TPT, 0 as MTDPT, 0 as OT, 0 as NC, SUM(querylog.amtinq) as QA,0 as MA 
                FROM querylog  
                WHERE status= 18 AND querylog.ProjectID IN (".$Project_List_ID.") AND querylog.RequestedBy = '".$Login_data[0]->AssociateID."'
            UNION ALL
                SELECT 0 as PMTP,0 as PMMP, 0 as PMR, 0 as TTI, 0 as MTDD, 0 as PMP, 0 as TPT, 0 as MTDPT, 0 as OT, 0 as NC,0 as QA, SUM(missing.CheckAmt) as MA 
                FROM missing  WHERE status!=33 AND missing.ProjectID IN (".$Project_List_ID.") AND missing.RequestedBy = '".$Login_data[0]->AssociateID."'
            ) A";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
        // Author: Anand Srivastava Date: 12-Mar-2019
        public function production_summary($sdate,$edate){
            $Login_data = $this->session->userdata('userdata');
            $associateID = $Login_data[0]->AssociateID;
            $sql = "SELECT sum(sum_CPMAmt) as sum_CPMAmt, sum(count_CPMAmt) as count_CPMAmt, sum(ESUM) as   ESUM, sum(TSUM) as Tsum, Login, Logout, sum(WorkTime) as WorkTime, sum(othersome) as othersome,     sum(count_Pending) as count_Pending, sum(sum_Pending) as sum_Pending FROM	(

                SELECT 
                SUM(CPMAmt)  as sum_CPMAmt,
                COUNT(CPMAmt) as count_CPMAmt,
                SUM(EncCount) as ESUM,
                SUM(TranCount) as TSUM,
                MIN(StartTime) as Login,
                MAX(PostDate) as Logout,
                SUM(Duration) as WorkTime,
                0 as othersome,
                0 as sum_Pending,
                0 as count_Pending
               FROM worklog
               WHERE PostDate BETWEEN '$sdate' AND '$edate' AND AssignedID = '$associateID' 
           UNION ALL
                SELECT
                0  as sum_CPMAmt,
                0 as count_CPMAmt,
                0 as ESUM,
                0 as TSUM,
                0 as Login,
                0 as Logout,
                0 as WorkTime,
                SUM(otherpayment.baddebt)+
                SUM(otherpayment.incentive)+ 
                SUM(otherpayment.interest)+
                SUM(otherpayment.hospital)+ 
                SUM(otherpayment.overpayrec)+
                SUM(otherpayment.forbal)+
                SUM(otherpayment.capitation)+ 
                SUM(otherpayment.spm)+
                SUM(otherpayment.noncern) as othersome,
                0 as sum_Pending,
                0 as count_Pending
                FROM `otherpayment`
                WHERE Encounter IN (SELECT CPM FROM `worklog` WHERE (PostDate BETWEEN '$sdate' AND '$edate')
                AND AssignedID = '$associateID')
            UNION ALL
                SELECT
                0  as sum_CPMAmt,
                0 as count_CPMAmt,
                0 as ESUM,
                0 as TSUM,
                0 as Login,
                0 as Logout,
                0 as WorkTime,
                0 as othersome,
                SUM(Amount) as sum_Pending,
                COUNT(Amount) count_Pending
                FROM worklog WHERE AssignedID = '$associateID' AND Status!=5
            ) A";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
        function fetch_assigned_summary(){
            $now = date("Y-m-d H:i:s");
            $Login_data = $this->session->userdata('userdata');
            $sql = "SELECT COUNT(worklog.WorkID) as Pending, SUM(worklog.Amount) as Dollar  FROM worklog
            WHERE AssignedID='".$Login_data[0]->AssociateID."' AND worklog.Status!=5 AND TIMESTAMPDIFF(HOUR, UploadDate,'".$now."')>48
            UNION ALL
            SELECT COUNT(worklog.WorkID) as Pending, SUM(worklog.Amount) as Dollar  FROM worklog
            WHERE AssignedID='".$Login_data[0]->AssociateID."' AND worklog.Status!=5 AND TIMESTAMPDIFF(HOUR, UploadDate,'".$now."') BETWEEN 36 AND 48
            UNION ALL
            SELECT COUNT(worklog.WorkID) as Pending, SUM(worklog.Amount) as Dollar  FROM worklog
            WHERE AssignedID='".$Login_data[0]->AssociateID."' AND worklog.Status!=5 AND TIMESTAMPDIFF(HOUR, UploadDate,'".$now."') BETWEEN 0 AND 36";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
        function fetch_daily_completed_summary($edate,$uedate){
            $now = date("Y-m-d H:i:s");
            $Login_data = $this->session->userdata('userdata');
            $sql = "SELECT COUNT(worklog.WorkID) as Count, SUM(worklog.`CPMAmt`) as Dollar  FROM worklog
            WHERE AssignedID='".$Login_data[0]->AssociateID."' AND worklog.Status=5 AND TIMESTAMPDIFF(HOUR, UploadDate,'".$now."')>48 AND PostDate BETWEEN '$edate' AND '$uedate'
            UNION ALL
            SELECT COUNT(worklog.WorkID) as Count, SUM(worklog.`CPMAmt`) as Dollar  FROM worklog
            WHERE AssignedID='".$Login_data[0]->AssociateID."' AND worklog.Status=5 AND TIMESTAMPDIFF(HOUR, UploadDate,'".$now."') BETWEEN 36 AND 48 AND PostDate BETWEEN '$edate' AND '$uedate'
            UNION ALL
            SELECT COUNT(worklog.WorkID) as Count, SUM(worklog.`CPMAmt`) as Dollar  FROM worklog
            WHERE AssignedID='".$Login_data[0]->AssociateID."' AND worklog.Status=5 AND TIMESTAMPDIFF(HOUR, UploadDate,'".$now."') BETWEEN 0 AND 36 AND PostDate BETWEEN '$edate' AND '$uedate'";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
        function fetch_daily_cpm_summary($edate,$uedate){
            $now = date("Y-m-d H:i:s");
            $Login_data = $this->session->userdata('userdata');
            $sql = "SELECT SUM(claimpaidamount) as MTDPT
            FROM `dailylog` 
            RIGHT JOIN worklog ON dailylog.batchnumber=worklog.CPM AND dailylog.transactiontype='Payment'
            WHERE worklog.AssignedID='".$Login_data[0]->AssociateID."' AND worklog.Status=5 AND TIMESTAMPDIFF(HOUR, worklog.UploadDate,'".$now."')>48 AND worklog.PostDate BETWEEN '$edate' AND '$uedate'
            UNION ALL
            SELECT SUM(claimpaidamount) as MTDPT
            FROM `dailylog` 
            RIGHT JOIN worklog ON dailylog.batchnumber=worklog.CPM AND dailylog.transactiontype='Payment'
            WHERE worklog.AssignedID='".$Login_data[0]->AssociateID."' AND worklog.Status=5 AND TIMESTAMPDIFF(HOUR, worklog.UploadDate,'".$now."') BETWEEN 36 AND 48 AND worklog.PostDate BETWEEN '$edate' AND '$uedate'
            UNION ALL
           SELECT SUM(claimpaidamount) as MTDPT
            FROM `dailylog` 
            RIGHT JOIN worklog ON dailylog.batchnumber=worklog.CPM AND dailylog.transactiontype='Payment'
            WHERE worklog.AssignedID='".$Login_data[0]->AssociateID."' AND worklog.Status=5 AND TIMESTAMPDIFF(HOUR, worklog.UploadDate,'".$now."') BETWEEN 0 AND 36 AND worklog.PostDate BETWEEN '$edate' AND '$uedate'";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
        // Author: Anand Srivastava Date: 12-Mar-2019
        function fetch_my_queue_count(){
            $Login_data = $this->session->userdata('userdata');
            $sql = "SELECT COUNT(WorkID) as Count FROM worklog WHERE AssignedID='".$Login_data[0]->AssociateID."' AND Status=2";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
        // Author: Anand Srivastava Date: 12-Mar-2019
        function fetch_workid_status($WorkID){
            $Login_data = $this->session->userdata('userdata');
            $sql = "SELECT status FROM worklog WHERE WorkID='$WorkID'";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
        // Author: Anand Srivastava Date: 12-Mar-2019
        function update_workid_data_start($WorkID){
            $startdate = date("Y-m-d H:i:s");
            $sql = "UPDATE `worklog` SET `Status`=2, `StartTime`='$startdate'  WHERE WorkID='$WorkID'";
            $this->db->query($sql);
            return true;
        }
        // Author: Anand Srivastava Date: 12-Mar-2019
        function update_workid_data_hold($WorkID){
            $sql = "UPDATE `worklog` SET `Status`=3 WHERE WorkID='$WorkID'";
            $this->db->query($sql);
            return true;
        }
        // Author: Anand Srivastava Date: 12-Mar-2019
        function update_workid_data_complete($WorkID,$batchnum,$cpa,$note){
            $postdate = date("Y-m-d H:i:s");
            $note = htmlspecialchars($note, ENT_QUOTES);
            $sql = "UPDATE `worklog` SET `Status`=5, CPM='$batchnum', CPMAmt='$cpa', Comments='$note', PostDate='$postdate', Duration=TIMESTAMPDIFF(SECOND,STR_TO_DATE(StartTime,'%Y-%m-%d %H:%i:%s'),STR_TO_DATE(PostDate,'%Y-%m-%d %H:%i:%s')), TAT=TIMESTAMPDIFF(HOUR,STR_TO_DATE(UploadDate,'%Y-%m-%d %H:%i:%s'),STR_TO_DATE(PostDate,'%Y-%m-%d %H:%i:%s')) WHERE WorkID='$WorkID'";
            $this->db->query($sql);
            return true;
        }
        // Author: Anand Srivastava Date: 12-Mar-2019
        function fetch_workid_data_tat($batchnum,$cpa){
            $sql = "SELECT TAT FROM worklog WHERE CPM='$batchnum' AND CPMAmt='$cpa'";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
        // Author: Anand Srivastava Date: 12-Mar-2019
        function fetch_workid_data_split($WorkID){
            $Login_data = $this->session->userdata('userdata');
            $sql = "SELECT `CategoryID`, `FacilityID`, `DepositeDate`, `BatchNo`, `UploadDate`, `AssignedID`, `StartTime`, `PostDate`, `CPM`, `Comments`, `CPMAmt`, `Duration`, `TAT`, `TATVal` FROM worklog, project WHERE WorkID='$WorkID' AND project.ProjectID=worklog.FacilityID";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
        // Author: Anand Srivastava Date: 12-Mar-2019
        function update_workid_data_split($batchnum,$cpa,$note,$WorkID_Split){
            $categoryid = $WorkID_Split[0]['CategoryID'];
            $projectname = $WorkID_Split[0]['FacilityID'];
            $depositedate = $WorkID_Split[0]['DepositeDate'];
            $batchno = $WorkID_Split[0]['BatchNo'];
            $UploadDate = $WorkID_Split[0]['UploadDate'];
            $AssignedID = $WorkID_Split[0]['AssignedID'];
            $StartTime = $WorkID_Split[0]['StartTime'];
            $postdate = $WorkID_Split[0]['PostDate'];
            $duration = $WorkID_Split[0]['Duration'];
            $tat = $WorkID_Split[0]['TAT'];
            $tatval = $WorkID_Split[0]['TATVal'];
            $note = htmlspecialchars($note, ENT_QUOTES);
            $sql = "INSERT INTO `worklog`(`CategoryID`, `FacilityID`, `DepositeDate`, `BatchNo`, `UploadDate`, `AssignedID`, `StartTime`, `PostDate`, `CPM`, `Comments`, `CPMAmt`, `Duration`, `TAT`, `TATVal`, `Status`) VALUES ('$categoryid', '$projectname', '$depositedate', '$batchno', '$UploadDate', '$AssignedID', '$StartTime', '$postdate', '$batchnum', '$note', '$cpa', '$duration', '$tat', '$tatval', '5')";
            $this->db->query($sql);
            return true;
        }
        // Author: Anand Srivastava Date: 12-Mar-2019
        function update_workid_data_tat($batchnum,$cpa,$TATVAL){
            $sql = "UPDATE worklog SET  TATVal='$TATVAL' WHERE CPM='$batchnum' AND CPMAmt='$cpa'";
            $this->db->query($sql);
            return true;
        }
        // Author: Anand Srivastava Date: 12-Mar-2019
        function add_other_payment($batchnum,$baddebt,$incentive,$interest,$noncern,$overpayrec,$forbal,$hospital,$cap,$spm,$pmonpos){
            $sql = "INSERT INTO `otherpayment`(`Encounter`, `baddebt`, `incentive`, `interest`, `noncern`, `overpayrec`, `forbal`, `hospital`, `capitation`, `spm`, `pmonpos`) VALUES   ('$batchnum','$baddebt','$incentive','$interest','$noncern','$overpayrec','$forbal','$hospital','$cap','$spm','$pmonpos')";
            $this->db->query($sql);
            return true;
        }
        // Author: Anand Srivastava Date: 12-Mar-2019
        function fetch_workid_data_query($WorkID){
            $sql = "SELECT `FacilityID`, `CategoryID`, `DepositeDate`, `Amount`, `BatchNo`, `CPM` FROM worklog WHERE WorkID='$WorkID'";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
        // Author: Anand Srivastava Date: 12-Mar-2019
        function add_query($amtinq,$querycom,$WorkID_Query){
            $Login_data = $this->session->userdata('userdata');
            $postdate = date("Y-m-d H:i:s");
            $projectname = $WorkID_Query[0]['FacilityID'];
            $categoryid = $WorkID_Query[0]['CategoryID'];
            $depositedate = $WorkID_Query[0]['DepositeDate'];
            $amount = $WorkID_Query[0]['Amount'];
            $batchno = $WorkID_Query[0]['BatchNo'];
            $cpm = $WorkID_Query[0]['CPM'];
            $sql = " INSERT INTO `querylog`(`ProjectID`, `Category`, `DepositDate`, `Amount`, `Payer`, `Encounter`, `RequestedDate`, `RequestedBy`, `amtinq`, `comment`, `AssignedID`, `status`) VALUES ('$projectname','$categoryid','$depositedate','$amount','$batchno','$cpm','$postdate','".$Login_data[0]->AssociateID."','$amtinq','$querycom','".$Login_data[0]->ManagerID."','18')";
            $this->db->query($sql);
            return true;
        }
        // Author: Anand Srivastava Date: 12-Mar-2019
        function fetch_missingtl_data(){
            $sql = "SELECT `AssociateID` FROM `associate` WHERE AccessLevel=14";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
        // Author: Anand Srivastava Date: 12-Mar-2019
        function add_missing($cpdipage,$website,$available,$mcomment,$checknum,$camt,$sdate,$MissingTL_ID,$WorkID_Query){
            $Login_data = $this->session->userdata('userdata');
            $postdate = date("Y-m-d H:i:s");
            $missingtl = $MissingTL_ID[0]['AssociateID'];
            $projectname = $WorkID_Query[0]['FacilityID'];
            $categoryid = $WorkID_Query[0]['CategoryID'];
            $depositedate = $WorkID_Query[0]['DepositeDate'];
            $amount = $WorkID_Query[0]['Amount'];
            $batchno = $WorkID_Query[0]['BatchNo'];
            $cpm = $WorkID_Query[0]['CPM'];
            $sql = "INSERT INTO `missing`(`ProjectID`, `Category`, `DepositDate`, `Amount`, `Payer`, `Encounter`, `CheckAmt`, `CheckDate`, `CheckNo`, `Website`, `Availibility`, `CPDIPage`, `RequestedDate`, `RequestedBy`, `Comment`, `AssignedID`, `Status`, `action`, `eta`, `location`) VALUES ('$projectname','$categoryid','$depositedate','$amount','$batchno','$cpm','$camt','$sdate','$checknum','$website','$available','$cpdipage','$postdate','".$Login_data[0]->AssociateID."','$mcomment','$missingtl','18','0','0','0')";
            $this->db->query($sql);
            return true;
        }
        // Author: Anand Srivastava Date: 12-Mar-2019
        function fetch_workid_data($WorkID){
            $sql = "SELECT WorkID,ProjectName,CategoryID,DepositeDate,Amount,BatchNo,CPM,Comments FROM worklog, project WHERE WorkID='$WorkID' AND project.ProjectID=worklog.FacilityID";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
        // Author: Anand Srivastava Date: 12-Mar-2019
        function fetch_my_queue(){
            $Login_data = $this->session->userdata('userdata');
            $sql = "SELECT worklog.WorkID, worklog.BatchNo, project.ProjectName, worklog.CategoryID, worklog.UploadDate, worklog.Status, worklog.DepositeDate, worklog.Amount FROM worklog, project
            WHERE AssignedID='".$Login_data[0]->AssociateID."' AND project.ProjectID=worklog.FacilityID AND worklog.Status!=5 order by WorkID";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
        #FUNCTION TO DOWNLAOD THE TAT Summary - ANAND
        function fetch_tat_summary($client,$sdate,$edate){
            $client = implode("','",$client);        
            # output headers so that the file is downloaded rather than displayed
            header("Content-Type: text/csv");
            header("Content-Disposition: attachment; filename=TATSummary.csv");
            # Disable caching - HTTP 1.1
            header("Cache-Control: no-cache, no-store, must-revalidate");
            # Disable caching - HTTP 1.0
            header("Pragma: no-cache");
            # Disable caching - Proxies
            header("Expires: 0");
            # Start the ouput
            $output = fopen("php://output", "w");
            //Excel File Header
            fputcsv($output, array('WorkID','Amount','CPM','EncCount', 'TranCount','Category','Facility','DepositeDate','PostDate','UploadDate','TAT'));  
            //Query to Fetch Report Rows
            $sql = "SELECT WorkID, concat('$', format(Amount, 2)), CPM, EncCount, TranCount, CategoryID, ProjectName, DepositeDate, PostDate, UploadDate, TATVal FROM worklog, project WHERE UploadDate between '$sdate' and '$edate' AND worklog.Status=5 AND FacilityID IN (".$client.") AND worklog.FacilityID=project.ProjectID";  
            $query = $this->db->query($sql);
            foreach ($query->result_array() as $value){
                //Write Each Result Row to the File
                fputcsv($output, $value);  
            }
            fclose($output); 
            return true; 
        }
        #FUNCTION TO DOWNLAOD THE ENCOUNTER SUMMARY - ANAND
        function fetch_encounter_summary($client,$sdate,$edate){
            $client = implode("','",$client);              
            # output headers so that the file is downloaded rather than displayed
            header("Content-Type: text/csv");
            header("Content-Disposition: attachment; filename=EncounterSummary.csv");
            # Disable caching - HTTP 1.1
            header("Cache-Control: no-cache, no-store, must-revalidate");
            # Disable caching - HTTP 1.0
            header("Pragma: no-cache");
            # Disable caching - Proxies
            header("Expires: 0");
            # Start the ouput
            $output = fopen("php://output", "w");
             //Excel File Header
            fputcsv($output, array('Facility', 'Category', 'CPM Post Date','Transaction Type', 'Claim Paid', 'Operator', 'Facility', 'Primary Health Plan', 'Transaction Alias', 'Transaction Reason', 'Financial Class','Payment Method','Transaction ID','Transaction Type','CPM Batch','Batch Type','Batch Desc','Insurance','Post Date','Comments'));   

            $sql = "SELECT project.ProjectName, worklog.CategoryID, dailylog.`PostDate`, `transactiontype`, concat('$',format(claimpaidamount,2)), operatorID, facility, primaryhealthplan, transactionsalias, transreason, financialclass, paymentmethod, transactionbdid, transactionsubtype, batchnumber, batchtype, batchdesc, insurance, worklog.PostDate, worklog.Comments FROM `dailylog` LEFT JOIN worklog ON dailylog.batchnumber=worklog.CPM AND dailylog.transactiontype='Payment' INNER JOIN project ON worklog.FacilityID=project.ProjectID WHERE worklog.DepositeDate  BETWEEN '$sdate' AND '$edate' AND worklog.FacilityID IN (".$client.")"; 
            $query = $this->db->query($sql);
            foreach ($query->result_array() as $value)
            {
                //Write Each Result Row to the File
                fputcsv($output, $value);  
            }
            fclose($output); 
            return true; 
        }
        #FUNCTION TO DOWNLAOD THE Deposite Log - ANAND
        function fetch_deposite_log($client,$sdate,$edate){
            $client = implode("','",$client);        
            # output headers so that the file is downloaded rather than displayed
            header("Content-Type: text/csv");
            header("Content-Disposition: attachment; filename=DepositeLog.csv");
            # Disable caching - HTTP 1.1
            header("Cache-Control: no-cache, no-store, must-revalidate");
            # Disable caching - HTTP 1.0
            header("Pragma: no-cache");
            # Disable caching - Proxies
            header("Expires: 0");
            # Start the ouput
            $output = fopen("php://output", "w");

            //CPM TOTAL Today
            fputcsv($output, array('WorkID', 'Client ID', 'Type', 'Bank AC',  'Prime #', 'Deposit Date', 'Received Date', 'Amount', 'Payer', 'CPM', 'AssignedID', 'Other Payment', 'CPMPosted', 'Outstanding', 'PostDate','Comments')); 

            $sql = "SELECT worklog.WorkID, project.ProjectName, worklog.CategoryID, worklog.WorkID-worklog.WorkID AS Bank,worklog.WorkID-worklog.WorkID AS Prime, worklog.DepositeDate,worklog.UploadDate, concat('$', format(worklog.Amount, 2)), worklog.BatchNo, worklog.CPM, worklog.AssignedID,concat('$', format(`baddebt`+`incentive`+`interest`+`noncern`+`overpayrec`+`forbal`+`hospital`+`capitation`, 2)) AS OP,concat('$', format(SUM(dailylog.claimpaidamount), 2)) AS CA, concat('$', format(worklog.Amount-(SUM(dailylog.claimpaidamount)+`baddebt`+`incentive`+`interest`+`noncern`+`overpayrec`+`forbal`+`hospital`+`capitation`), 2)) AS OS ,worklog.PostDate,worklog.Comments FROM `otherpayment` RIGHT JOIN dailylog ON otherpayment.Encounter=dailylog.batchnumber RIGHT JOIN worklog ON dailylog.batchnumber=worklog.CPM AND dailylog.transactiontype='Payment' INNER JOIN project ON worklog.FacilityID=project.ProjectID WHERE worklog.DepositeDate  BETWEEN '$sdate' AND '$edate' AND worklog.FacilityID IN (".$client.") GROUP BY worklog.WorkID, dailylog.batchnumber";   

            $query = $this->db->query($sql);
            foreach ($query->result_array() as $value){
                //Write Each Result Row to the File
                fputcsv($output, $value);  
            }
            fclose($output); 
            return true; 
        }
        // Author: Anand Srivastava Date: 14-Mar-2019
        function fetch_missing_eob_pending(){
            $Login_data = $this->session->userdata('userdata');
            $sql = "SELECT `missingid`, `project`.`ProjectName`, `Category`, `Payer`, `CheckNo`, `RequestedDate`, `AssociateName` as RequestedByAssociateName, associate.AssociateID as RequestedByAssociateID, (SELECT associate.AssociateID from associate WHERE associate.AssociateID=missing.AssignedID) as AssignedIDAssociateID, (SELECT associate.AssociateName from associate WHERE associate.AssociateID=missing.AssignedID) as AssignedIDAssociateName, missing.Status, status.*
            FROM `missing`, `project`, associate, status 
            WHERE status.statusid=missing.Status AND project.ProjectID=missing.ProjectID AND        associate.AssociateID = missing.RequestedBy AND missing.Status<33 AND                       RequestedBy IN ('".$Login_data[0]->AssociateID."')";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
        // Author: Anand Srivastava Date: 14-Mar-2019
        function fetch_missing_eob_ready(){
            $Login_data = $this->session->userdata('userdata');
            $sql = "SELECT `missingid`, `project`.`ProjectName`, `Category`, `Payer`, `CheckNo`, `RequestedDate`, `AssociateName` as RequestedByAssociateName, associate.AssociateID as RequestedByAssociateID, (SELECT associate.AssociateID from associate WHERE associate.AssociateID=missing.AssignedID) as AssignedIDAssociateID, (SELECT associate.AssociateName from associate WHERE associate.AssociateID=missing.AssignedID) as AssignedIDAssociateName, missing.Status, status.*
            FROM `missing`, `project`, associate, status 
            WHERE status.statusid=missing.Status AND project.ProjectID=missing.ProjectID AND        associate.AssociateID = missing.RequestedBy AND missing.Status=33 AND                       RequestedBy IN ('".$Login_data[0]->AssociateID."')";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
        // Author: Anand Srivastava Date: 14-Mar-2019
        function fetch_missing_eob_posted(){
            $Login_data = $this->session->userdata('userdata');
            $sql = "SELECT `missingid`, `project`.`ProjectName`, `Category`, `Payer`, `CheckNo`, `RequestedDate`, `AssociateName` as RequestedByAssociateName, associate.AssociateID as RequestedByAssociateID, (SELECT associate.AssociateID from associate WHERE associate.AssociateID=missing.AssignedID) as AssignedIDAssociateID, (SELECT associate.AssociateName from associate WHERE associate.AssociateID=missing.AssignedID) as AssignedIDAssociateName, missing.Status, status.*
            FROM `missing`, `project`, associate, status 
            WHERE status.statusid=missing.Status AND project.ProjectID=missing.ProjectID AND        associate.AssociateID = missing.RequestedBy AND missing.Status=34 AND                       RequestedBy IN ('".$Login_data[0]->AssociateID."')";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
        // Author: Anand Srivastava Date: 14-Mar-2019
        function fetch_missingid_data($missingid){
            $sql = "SELECT missingid,ProjectName,Category,DepositDate,Amount,Payer,Comment,Encounter,CheckAmt,CheckDate,CheckNo,Website,Availibility,CPDIPage,RequestedDate,action,eta FROM `missing`, project WHERE missingid='$missingid' AND project.ProjectID=missing.ProjectID";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
        // Author: Anand Srivastava Date: 14-Mar-2019
        function update_missingid_status($missingid){
            $sql = "UPDATE `missing` SET `Status`=34 WHERE missingid='$missingid'";
            $this->db->query($sql);
            return true;
        }
        // Author: Anand Srivastava Date: 14-Mar-2019
        function fetch_missingid_post_data($missingid){
            $sql = "SELECT missing.ProjectID,Category,DepositDate,Payer,RequestedDate FROM `missing`, project WHERE missingid='$missingid' AND project.ProjectID=missing.ProjectID";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
        // Author: Anand Srivastava Date: 14-Mar-2019
        function update_missing_post($batchnum,$cpa,$MissingID_Data){
            $Login_data = $this->session->userdata('userdata');
            $postdate = date("Y-m-d H:i:s");
            $categoryid = $MissingID_Data[0]['Category'];
            $projectname = $MissingID_Data[0]['ProjectID'];
            $depositedate = $MissingID_Data[0]['DepositDate'];
            $batchno = $MissingID_Data[0]['Payer'];
            $UploadDate = $MissingID_Data[0]['RequestedDate'];
            $StartTime = date("Y-m-d H:i:s");
            $sql = "INSERT INTO `worklog`(`CategoryID`, `FacilityID`, `DepositeDate`, `BatchNo`, `UploadDate`, `AssignedID`, `StartTime`, `PostDate`, `CPM`, `CPMAmt`, `Duration`, `TAT`, `Status`) VALUES ('$categoryid', '$projectname', '$depositedate', '$batchno', '$UploadDate', '".$Login_data[0]->AssociateID."', '$StartTime', '$postdate', '$batchnum', '$cpa', '0', TIMESTAMPDIFF(HOUR,STR_TO_DATE(UploadDate,'%Y-%m-%d %H:%i:%s'),STR_TO_DATE(PostDate,'%Y-%m-%d %H:%i:%s')), '5')";
            $this->db->query($sql);
            return true;
        }
        // Author: Anand Srivastava Date: 14-Mar-2019
        function fetch_query_pending(){
            $Login_data = $this->session->userdata('userdata');
            $sql = "SELECT `queryid`, ProjectName, `Category`, `DepositDate`, `amtinq`, `Payer`, `Encounter`, `RequestedDate`, `AssociateName` as RequestedByAssociateName, associate.AssociateID as RequestedByAssociateID, (SELECT associate.AssociateID from associate WHERE associate.AssociateID=querylog.AssignedID) as AssignedIDAssociateID, (SELECT associate.AssociateName from associate WHERE associate.AssociateID=querylog.AssignedID) as AssignedIDAssociateName, querylog.Status, status.*
            FROM `querylog`, `project`, associate, status 
            WHERE status.statusid=querylog.Status AND project.ProjectID=querylog.ProjectID AND        associate.AssociateID = querylog.RequestedBy AND querylog.Status<33 AND                       RequestedBy IN ('".$Login_data[0]->AssociateID."')";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
        // Author: Anand Srivastava Date: 14-Mar-2019
        function fetch_query_posted(){
            $Login_data = $this->session->userdata('userdata');
            $sql = "SELECT `queryid`, ProjectName, `Category`, `DepositDate`, `amtinq`, `Payer`, `Encounter`, `RequestedDate`, `AssociateName` as RequestedByAssociateName, associate.AssociateID as RequestedByAssociateID, (SELECT associate.AssociateID from associate WHERE associate.AssociateID=querylog.AssignedID) as AssignedIDAssociateID, (SELECT associate.AssociateName from associate WHERE associate.AssociateID=querylog.AssignedID) as AssignedIDAssociateName, querylog.Status, status.*
            FROM `querylog`, `project`, associate, status 
            WHERE status.statusid=querylog.Status AND project.ProjectID=querylog.ProjectID AND        associate.AssociateID = querylog.RequestedBy AND querylog.Status=34 AND                       RequestedBy IN ('".$Login_data[0]->AssociateID."')";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
        // Author: Anand Srivastava Date: 14-Mar-2019
        function fetch_query_ready(){
            $Login_data = $this->session->userdata('userdata');
            $sql = "SELECT `queryid`, ProjectName, `Category`, `DepositDate`, `amtinq`, `Payer`, `Encounter`, `RequestedDate`, `AssociateName` as RequestedByAssociateName, associate.AssociateID as RequestedByAssociateID, (SELECT associate.AssociateID from associate WHERE associate.AssociateID=querylog.AssignedID) as AssignedIDAssociateID, (SELECT associate.AssociateName from associate WHERE associate.AssociateID=querylog.AssignedID) as AssignedIDAssociateName, querylog.Status, status.*
            FROM `querylog`, `project`, associate, status 
            WHERE status.statusid=querylog.Status AND project.ProjectID=querylog.ProjectID AND        associate.AssociateID = querylog.RequestedBy AND querylog.Status=33 AND                       RequestedBy IN ('".$Login_data[0]->AssociateID."')";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
        // Author: Anand Srivastava Date: 14-Mar-2019
        function fetch_queryid_data($queryid){
            $sql = "SELECT `queryid`, `ProjectName`, `Category`, `DepositDate`, `Amount`, `Payer`, `Encounter`, `RequestedDate`, `RequestedBy`, `amtinq`, `comment`, `AssignedID` FROM querylog, project WHERE queryid='$queryid' AND project.ProjectID=querylog.ProjectID";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
        // Author: Anand Srivastava Date: 14-Mar-2019
        function update_query_status($queryid){
            $sql = "UPDATE `querylog` SET `status`=34 WHERE queryid='$queryid'";
            $this->db->query($sql);
            return true;
        }
        // Author: Anand Srivastava Date: 14-Mar-2019
        function fetch_query_post_data($queryid){
            $sql = "SELECT querylog.ProjectID,Category,DepositDate,Payer,RequestedDate FROM `querylog`, project WHERE queryid='$queryid' AND project.ProjectID=querylog.ProjectID";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
        //Production Status=5
        function update_workid_data_pending($WorkID_Split,$pendingamount){
            $categoryid = $WorkID_Split[0]['CategoryID'];
            $projectname = $WorkID_Split[0]['FacilityID'];
            $depositedate = $WorkID_Split[0]['DepositeDate'];
            $batchno = $WorkID_Split[0]['BatchNo'];
            $UploadDate = $WorkID_Split[0]['UploadDate'];
            $AssignedID = $WorkID_Split[0]['AssignedID'];
            $sql = "INSERT INTO `worklog`(`CategoryID`, `FacilityID`, `DepositeDate`,`Amount`, `BatchNo`, `UploadDate`, `AssignedID`, `Status`) VALUES ('$categoryid', '$projectname', '$depositedate', '$pendingamount','$batchno', '$UploadDate', '$AssignedID','1')";
            $this->db->query($sql);
            return true;
        }
        //Production Status=5
        function update_queryid_data_pending($QueryID_Split,$pendingamount){
            $ProjectID = $QueryID_Split[0]['ProjectID'];
            $Category = $QueryID_Split[0]['Category'];
            $DepositDate = $QueryID_Split[0]['DepositDate'];
            $Amount = $QueryID_Split[0]['Amount'];
            $Payer = $QueryID_Split[0]['Payer'];
            $Encounter = $QueryID_Split[0]['Encounter'];
            $RequestedDate = $QueryID_Split[0]['RequestedDate'];
            $RequestedBy = $QueryID_Split[0]['RequestedBy'];//AMT
            $comment = $QueryID_Split[0]['comment'];
            $AssignedID = $QueryID_Split[0]['AssignedID'];
            $sql = "INSERT INTO `querylog`(`ProjectID`, `Category`, `DepositDate`, `Amount`, `Payer`, `Encounter`, `RequestedDate`, `RequestedBy`, `amtinq`, `comment`, `AssignedID`, `status`) VALUES  ('$ProjectID', '$Category', '$DepositDate', '$Amount','$Payer', '$Encounter', '$RequestedDate','$RequestedBy','$pendingamount','$comment','$AssignedID','18')";
            $this->db->query($sql);
            return true;
        }
         //Production Status=5
        function update_missingid_data_pending($MissingID_Split,$pendingamount){
            $ProjectID = $MissingID_Split[0]['ProjectID'];
            $Category = $MissingID_Split[0]['Category'];
            $DepositDate = $MissingID_Split[0]['DepositDate'];
            $Amount = $MissingID_Split[0]['Amount'];
            $Payer = $MissingID_Split[0]['Payer'];
            $Encounter = $MissingID_Split[0]['Encounter'];
            $CheckDate = $MissingID_Split[0]['CheckDate'];
            $CheckNo = $MissingID_Split[0]['CheckNo'];
            $Website = $MissingID_Split[0]['Website'];
            $Availibility = $MissingID_Split[0]['Availibility'];
            $CPDIPage = $MissingID_Split[0]['CPDIPage'];
            $RequestedDate = $MissingID_Split[0]['RequestedDate'];
            $RequestedBy = $MissingID_Split[0]['RequestedBy'];//AMT
            $comment = $MissingID_Split[0]['Comment'];
            $AssignedID = $MissingID_Split[0]['AssignedID'];
            $sql = "INSERT INTO `missing`(`ProjectID`, `Category`, `DepositDate`, `Amount`, `Payer`, `Encounter`, `CheckAmt`, `CheckDate`, `CheckNo`, `Website`, `Availibility`, `CPDIPage`, `RequestedDate`, `RequestedBy`, `Comment`, `AssignedID`, `Status`)VALUES  ('$ProjectID', '$Category', '$DepositDate', '$Amount','$Payer', '$Encounter', '$pendingamount','$CheckDate', '$CheckNo', '$Website', '$Availibility', '$CPDIPage', '$RequestedDate', '$RequestedBy', '$comment', '$AssignedID' , '18')";
            $this->db->query($sql);
            return true;
        }
        function fetch_workid_data_amount($WorkID){
            $Login_data = $this->session->userdata('userdata');
            $sql = "SELECT Amount FROM worklog WHERE WorkID='$WorkID'";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
        function fetch_queryid_data_checkamount($queryid){
            $sql = "SELECT amtinq FROM querylog WHERE queryid='$queryid'";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
         function fetch_missingid_data_checkamount($missingid){
            $sql = "SELECT CheckAmt FROM missing WHERE missingid='$missingid'";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
        // Author: Anand Srivastava Date: 15-Mar-2019
        function fetch_workid_data_pending($WorkID){
            $sql = "SELECT `CategoryID`, `FacilityID`, `DepositeDate`, `BatchNo`, `UploadDate`, `AssignedID`  FROM worklog, project WHERE WorkID='$WorkID' AND project.ProjectID=worklog.FacilityID";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
         // Author: Anand Srivastava Date: 15-Mar-2019
        function fetch_queryid_data_pending($queryid){
            $sql = "SELECT querylog.`ProjectID`, `Category`, `DepositDate`, `Amount`, `Payer`, `Encounter`, `RequestedDate`, `RequestedBy`, `comment`, `AssignedID` FROM `querylog`, project WHERE queryid='$queryid' AND project.ProjectID=querylog.ProjectID";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
         // Author: Anand Srivastava Date: 15-Mar-2019
        function fetch_missingid_data_pending($missingid){
            $sql = "SELECT missing.`ProjectID`, `Category`, `DepositDate`, `Amount`, `Payer`, `Encounter`, `CheckDate`, `CheckNo`, `Website`, `Availibility`, `CPDIPage`, `RequestedDate`, `RequestedBy`, `Comment`, `AssignedID` FROM `missing`, project WHERE missingid='$missingid' AND project.ProjectID=missing.ProjectID";
            $query = $this->db->query($sql);
            $row = $query->result_array(); 
            return $row;
        }
    }
?>