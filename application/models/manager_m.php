<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
Class manager_m extends CI_Model{
     // Author: Anand Srivastava Date: 15-Mar-2019
    function fetch_dashboard_data($Project_List_ID,$sdate,$edate){
    	$sql = "SELECT SUM(MTDD) as MTDD, SUM(MTDPT) as MTDPT, SUM(Dollar) as Dollar, SUM(Assign) as Assign FROM (
        
        
        SELECT SUM(w.Amount) as MTDD, 0 as MTDPT, 0 as Dollar, 0 as Assign FROM worklog w WHERE w.UploadDate BETWEEN '$sdate' AND '$edate' AND w.FacilityID IN ('".$Project_List_ID."')
        
        UNION ALL 
        
        SELECT 0 as MTDD, SUM(claimpaidamount) as MTDPT, 0 as Dollar, 0 as Assign FROM `dailylog` 
        RIGHT JOIN worklog ON dailylog.batchnumber=worklog.CPM AND dailylog.transactiontype='Payment'
        WHERE worklog.PostDate  BETWEEN  '$sdate' AND '$edate' AND worklog.FacilityID IN ('".$Project_List_ID."')
        
        UNION ALL
        
        SELECT  0 as MTDD, 0 as MTDPT, SUM(worklog.Amount) as Dollar, 0 as Assign   FROM worklog
        WHERE worklog.FacilityID IN ('".$Project_List_ID."') AND worklog.Status!=5 AND TIMESTAMPDIFF(HOUR, UploadDate,NOW())>48
        
        UNION ALL
        
        SELECT  0 as MTDD, 0 as MTDPT, 0 as Dollar, SUM(worklog.Amount) as Assign  FROM worklog
        WHERE worklog.FacilityID IN ('".$Project_List_ID."') AND worklog.Status=1
        
        ) A";
        $query = $this->db->query($sql);
        $row = $query->result_array(); 
        return $row;	
    }
    // Author: Anand Srivastava Date: 15-Mar-2019
    function fetch_projectlist(){
        $sql = "select ProjectID, ProjectName, status, AssociateName from project p, associate a where p.Owner = a.AssociateID";
        $query = $this->db->query($sql);
        $row = $query->result_array(); 
        return $row;
    }
    function fetch_associatelist(){
        $sql = "select `AssociateID`, `AssociateName`, `ManagerID`, `Active` from associate WHERE AccessLevel=4";
        $query = $this->db->query($sql);
        $row = $query->result_array(); 
        return $row;
    }
    // Author: Anand Srivastava Date: 15-Mar-2019
    function fetch_projectlist_r(){
        $sql = "select ProjectID,ProjectName from project where status=1";
        $query = $this->db->query($sql);
        $row = $query->result_array(); 
        return $row;
    }
    // Author: Anand Srivastava Date: 15-Mar-2019
    function mtd_half_fetch($Project_List_ID,$pmfd,$pmld,$pmcdate,$sdate,$edate,$uedate){
        $sql ="SELECT SUM(PMTP) as PMTP, SUM(PMMP) as PMMP, SUM(PMR) as PMR , SUM(TTI) as TTI, SUM(MTDD) as MTDD, SUM(PMP) as PMP, SUM(TPT) as TPT, SUM(MTDPT) as MTDPT,SUM(OT) as OT, SUM(NC) as NC, SUM(QA) as QA,SUM(MA) as MA  FROM 
    (
    SELECT SUM(`baddebt`)+SUM(`incentive`)+SUM(`interest`)+SUM(`noncern`)+SUM(`overpayrec`)+SUM(`forbal`)+SUM(`hospital`)+SUM(`capitation`) as PMTP, 0 as PMMP, 0 as PMR, 0 as TTI, 0 as MTDD, 0 as PMP, 0 as TPT, 0 as MTDPT, 0 as OT, 0 as NC, 0 as QA, 0 as MA 
    FROM `otherpayment` 
    RIGHT JOIN dailylog ON otherpayment.Encounter=dailylog.batchnumber 
    RIGHT JOIN worklog ON dailylog.batchnumber=worklog.CPM 
    WHERE worklog.PostDate BETWEEN '$pmfd' AND '$pmld' AND worklog.FacilityID IN (".$Project_List_ID.") AND dailylog.transactiontype='Payment'
    UNION ALL
    SELECT SUM(dailylog.claimpaidamount) as PMTP, 0 as PMMP, 0 as PMR, 0 as TTI, 0 as MTDD, 0 as PMP, 0 as TPT, 0 as MTDPT,0 as OT, 0 as NC, 0 as QA, 0 as MA 
    FROM `dailylog` 
    RIGHT JOIN worklog ON dailylog.batchnumber=worklog.CPM 
    WHERE worklog.PostDate BETWEEN '$pmfd' AND '$pmld' AND worklog.FacilityID IN (".$Project_List_ID.") AND dailylog.transactiontype='Payment'
    UNION ALL 
    SELECT 0 as PMTP, SUM(`baddebt`)+SUM(`incentive`)+SUM(`interest`)+SUM(`noncern`)+SUM(`overpayrec`)+SUM(`forbal`)+SUM(`hospital`)+SUM(`capitation`) as PMMP, 0 as PMR, 0 as TTI, 0 as MTDD, 0 as PMP, 0 as TPT, 0 as MTDPT, 0 as OT, 0 as NC, 0 as QA, 0 as MA 
    FROM `otherpayment` 
    RIGHT JOIN dailylog ON otherpayment.Encounter=dailylog.batchnumber 
    RIGHT JOIN worklog ON dailylog.batchnumber=worklog.CPM 
    WHERE worklog.PostDate BETWEEN '$pmfd' AND '$pmcdate' AND worklog.FacilityID IN (".$Project_List_ID.") AND dailylog.transactiontype='Payment'
    UNION ALL
    SELECT 0 as PMTP, SUM(dailylog.claimpaidamount) as PMMP, 0 as PMR, 0 as TTI, 0 as MTDD, 0 as PMP, 0 as TPT, 0 as MTDPT,0 as OT, 0 as NC, 0 as QA, 0 as MA 
    FROM `dailylog` 
    RIGHT JOIN worklog ON dailylog.batchnumber=worklog.CPM 
    WHERE worklog.PostDate BETWEEN '$pmfd' AND '$pmcdate' AND worklog.FacilityID IN (".$Project_List_ID.") AND dailylog.transactiontype='Payment'
    UNION ALL
    SELECT 0 as PMTP,0 as PMMP, SUM(worklog.Amount) as PMR, 0 as TTI, 0 as MTDD, 0 as PMP, 0 as TPT, 0 as MTDPT,0 as OT, 0 as NC, 0 as QA, 0 as MA 
    FROM worklog
    WHERE worklog.UploadDate BETWEEN  '$pmfd' AND '$pmld' AND worklog.FacilityID IN (".$Project_List_ID.") AND worklog.Status!=5
    UNION ALL
    SELECT 0 as PMTP,0 as PMMP, 0 as PMR, SUM(worklog.Amount) as TTI, 0 as MTDD, 0 as PMP, 0 as TPT, 0 as MTDPT ,0 as OT, 0 as NC, 0 as QA, 0 as MA 
    FROM worklog 
    WHERE worklog.UploadDate BETWEEN '$edate' AND '$uedate' AND worklog.FacilityID IN (".$Project_List_ID.")
    UNION ALL
    SELECT 0 as PMTP,0 as PMMP, 0 as PMR, 0 as TTI, SUM(w.Amount) as MTDD, 0 as PMP, 0 as TPT, 0 as MTDPT ,0 as OT, 0 as NC, 0 as QA,0 as MA FROM worklog w 
    WHERE w.UploadDate BETWEEN '$sdate' AND '$uedate' AND w.FacilityID IN (".$Project_List_ID.")
    UNION ALL
    SELECT 0 as PMTP,0 as PMMP, 0 as PMR, 0 as TTI, 0 as MTDD, SUM(otherpayment.pmonpos) as PMP, 0 as TPT, 0 as MTDPT,0 as OT, 0 as NC, 0 as QA,0 as MA  
    FROM `otherpayment` 
    RIGHT JOIN dailylog ON otherpayment.Encounter=dailylog.batchnumber
    RIGHT JOIN worklog ON dailylog.batchnumber=worklog.CPM AND dailylog.transactiontype='Payment'
    WHERE worklog.PostDate  BETWEEN  '$sdate' AND '$uedate' AND worklog.FacilityID IN (".$Project_List_ID.")
    UNION ALL
    SELECT 0 as PMTP,0 as PMMP, 0 as PMR, 0 as TTI, 0 as MTDD, 0 as PMP, SUM(claimpaidamount) as TPT, 0 as MTDPT,0 as OT, 0 as NC, 0 as QA,0 as MA
    FROM `dailylog` 
    RIGHT JOIN worklog ON dailylog.batchnumber=worklog.CPM AND dailylog.transactiontype='Payment'
    WHERE worklog.PostDate BETWEEN '$edate' AND '$uedate' AND worklog.FacilityID IN (".$Project_List_ID.")
    UNION ALL
    SELECT 0 as PMTP,0 as PMMP, 0 as PMR, 0 as TTI, 0 as MTDD, 0 as PMP, 0 as TPT, SUM(claimpaidamount) as MTDPT,0 as OT, 0 as NC, 0 as QA,0 as MA
    FROM `dailylog` 
    RIGHT JOIN worklog ON dailylog.batchnumber=worklog.CPM AND dailylog.transactiontype='Payment'
    WHERE worklog.PostDate  BETWEEN  '$sdate' AND '$uedate' AND worklog.FacilityID IN (".$Project_List_ID.")
    UNION ALL
    SELECT 0 as PMTP,0 as PMMP, 0 as PMR, 0 as TTI, 0 as MTDD, 0 as PMP, 0 as TPT, 0 as MTDPT, SUM(`baddebt`)+SUM(`incentive`)+ SUM(`interest`)+ SUM(`overpayrec`)+ SUM(`forbal`)+ SUM(`hospital`)+ SUM(`capitation`) as OT, 0 as NC, 0 as QA,0 as MA
    FROM `otherpayment` 
    RIGHT JOIN dailylog ON otherpayment.Encounter=dailylog.batchnumber
    RIGHT JOIN worklog ON dailylog.batchnumber=worklog.CPM AND dailylog.transactiontype='Payment'
    WHERE worklog.PostDate  BETWEEN  '$sdate' AND '$uedate' AND worklog.FacilityID IN (".$Project_List_ID.")   
    UNION ALL
    SELECT 0 as PMTP,0 as PMMP, 0 as PMR, 0 as TTI, 0 as MTDD, 0 as PMP, 0 as TPT, 0 as MTDPT, 0 as OT, SUM(`noncern`) as NC, 0 as QA,0 as MA
    FROM `otherpayment` 
    RIGHT JOIN worklog ON otherpayment.Encounter=worklog.CPM
    WHERE worklog.PostDate  BETWEEN  '$sdate' AND '$uedate' AND worklog.FacilityID IN (".$Project_List_ID.")   
    UNION ALL
    SELECT 0 as PMTP,0 as PMMP, 0 as PMR, 0 as TTI, 0 as MTDD, 0 as PMP, 0 as TPT, 0 as MTDPT, 0 as OT, 0 as NC, SUM(querylog.amtinq) as QA,0 as MA FROM querylog  WHERE status= 18 AND querylog.ProjectID IN (".$Project_List_ID.")
    UNION ALL
    SELECT 0 as PMTP,0 as PMMP, 0 as PMR, 0 as TTI, 0 as MTDD, 0 as PMP, 0 as TPT, 0 as MTDPT, 0 as OT, 0 as NC,0 as QA, SUM(missing.CheckAmt) as MA FROM missing  WHERE status!=33 AND missing.ProjectID IN (".$Project_List_ID.")
    ) A";
        $query = $this->db->query($sql);
       	$row = $query->result_array(); 
        return $row;
    }
    // Author: Anand Srivastava Date: 15-Mar-2019
    function fetch_categorylist($Project_List_ID,$sdate,$edate){
    	$sql = "SELECT DISTINCT(CategoryID) FROM worklog WHERE FacilityID=".$Project_List_ID;
        $query = $this->db->query($sql);
        $row = $query->result_array(); 
        return $row;	
    }
    // Author: Anand Srivastava Date: 15-Mar-2019
    function newReconcilliation($Project_List_ID,$sdate,$edate){
    	$sql = "SELECT
    		SUM(priorpendinginventorytoday) as priorpendinginventorytoday,
    		SUM(inventory) as inventory, 
    		SUM(CPMTotal) as CPMTotal, 
    		SUM(otherpaymentTotal) as otherpaymentTotal,
    		SUM(noncerntotal) as noncerntotal, 
    		SUM(querytotal) as querytotal, 
    		SUM(missingtotal) as missingtotal
			FROM
			(
				SELECT SUM(Amount) as priorpendinginventorytoday, 0 as inventory, 0 as CPMTotal, 0 as otherpaymentTotal, 0 as noncerntotal, 0 as querytotal, 0 as missingtotal
			    FROM worklog  WHERE worklog.UploadDate NOT BETWEEN '$sdate' AND '$edate' AND worklog.Status!=5 AND FacilityID IN (".$Project_List_ID.")

			    UNION ALL
			    
			    SELECT 0 as priorpendinginventorytoday, SUM(Amount) as inventory, 0 as CPMTotal, 0 as otherpaymentTotal, 0 as noncerntotal, 0 as querytotal, 0 as missingtotal
			    FROM worklog WHERE worklog.UploadDate BETWEEN '$sdate' AND '$edate' AND FacilityID IN (".$Project_List_ID.")
			    
			    UNION ALL
			    
			    SELECT 0 as priorpendinginventorytoday, 0 as inventory, sum(claimpaidamount) as CPMTotal, 0 as otherpaymentTotal,0 as noncerntotal, 0 as querytotal, 0 as missingtotal
			    from dailylog
			    RIGHT JOIN worklog on dailylog.batchnumber=worklog.CPM
			    WHERE worklog.PostDate BETWEEN '$sdate' AND '$edate' AND worklog.FacilityID=".$Project_List_ID." AND dailylog.transactiontype='Payment'
			    
			    UNION ALL
			    
			    SELECT 0 as priorpendinginventorytoday, 0 as inventory, 0 as CPMTotal, SUM(otherpayment.baddebt) + SUM(otherpayment.incentive) + SUM(otherpayment.interest) + SUM(otherpayment.hospital) + SUM(otherpayment.overpayrec) + SUM(otherpayment.forbal) + SUM(otherpayment.capitation) + SUM(otherpayment.spm) as otherpaymentTotal, 0 as noncerntotal, 0 as querytotal,0 as missingtotal
			    from otherpayment
			    RIGHT JOIN dailylog on otherpayment.Encounter=dailylog.batchnumber
			    RIGHT JOIN worklog on dailylog.batchnumber=worklog.CPM
			    WHERE worklog.PostDate BETWEEN '$sdate' AND '$edate' AND worklog.FacilityID=".$Project_List_ID."
			    
			    
			    UNION ALL
                  SELECT 0 as priorpendinginventorytoday, 0 as inventory, 0 as CPMTotal, 0 as otherpaymentTotal, sum(otherpayment.noncern) as noncerntotal, 0 as querytotal,0 as missingtotal
			    from otherpayment
			    RIGHT JOIN worklog on otherpayment.Encounter=worklog.CPM
			    WHERE worklog.PostDate BETWEEN '$sdate' AND '$edate' AND worklog.FacilityID=".$Project_List_ID."
			    
			    
			    UNION ALL
			    
			    SELECT 0 as priorpendinginventorytoday, 0 as inventory, 0 as CPMTotal, 0 as otherpaymentTotal,0 as noncerntotal, SUM(querylog.amtinq) as querytotal, 0 as missingtotal
			    FROM querylog  WHERE status= 18 AND querylog.ProjectID IN (".$Project_List_ID.")
			    
			    UNION ALL

			    SELECT 0 as priorpendinginventorytoday, 0 as inventory, 0 as CPMTotal, 0 as otherpaymentTotal,0 as noncerntotal, 0 as querytotal,
			    SUM(missing.CheckAmt) as missingtotal
			    FROM missing  WHERE status!=33 AND missing.ProjectID=".$Project_List_ID."			    
			    
			) A";
		$query = $this->db->query($sql);
	    $row = $query->result_array(); 
        return $row;    	
	}
    // Author: Anand Srivastava Date: 15-Mar-2019
	function newReconcillitionCat($Project_List_ID,$Categpry_List_ID,$sdate,$edate){
		$sql = "SELECT SUM(priorpendinginventorytoday) as priorpendinginventorytoday,
			SUM(inventory) as inventory,
		    SUM(CPMTotal) as CPMTotal,
		    SUM(otherpaymentTotal) as otherpaymentTotal,
		    SUM(noncerntotal) as noncerntotal,
		    SUM(querytotal) as querytotal,
		    SUM(missingtotal) as missingtotal
			FROM
			(
				SELECT SUM(Amount) as priorpendinginventorytoday, 0 as inventory, 0 as CPMTotal, 0 as otherpaymentTotal, 0 as noncerntotal, 0 as querytotal, 0 as missingtotal
			    FROM worklog  WHERE worklog.UploadDate NOT BETWEEN '$sdate' AND '$edate' AND worklog.Status!=5 AND FacilityID IN (".$Project_List_ID.") AND worklog.CategoryID='$Categpry_List_ID'
			    UNION ALL
			    
			    SELECT 0 as priorpendinginventorytoday, SUM(Amount) as inventory, 0 as CPMTotal, 0 as otherpaymentTotal, 0 as noncerntotal, 0 as querytotal, 0 as missingtotal
			    FROM worklog WHERE worklog.UploadDate BETWEEN '$sdate' AND '$edate' AND FacilityID IN (".$Project_List_ID.") AND worklog.CategoryID ='$Categpry_List_ID'
			    
			    UNION ALL
			    
			    SELECT 0 as priorpendinginventorytoday, 0 as inventory, sum(claimpaidamount) as CPMTotal, 0 as otherpaymentTotal,0 as noncerntotal, 0 as querytotal, 0 as missingtotal
			    from dailylog
			    RIGHT JOIN worklog on dailylog.batchnumber=worklog.CPM
			    WHERE worklog.PostDate BETWEEN '$sdate' AND '$edate' AND worklog.FacilityID=".$Project_List_ID." AND dailylog.transactiontype='Payment' AND worklog.CategoryID='$Categpry_List_ID'
			    
			    UNION ALL
			    
			    SELECT 0 as priorpendinginventorytoday, 0 as inventory, 0 as CPMTotal, SUM(otherpayment.baddebt) + SUM(otherpayment.incentive) + SUM(otherpayment.interest) + SUM(otherpayment.hospital) + SUM(otherpayment.overpayrec) + SUM(otherpayment.forbal) + SUM(otherpayment.capitation) + SUM(otherpayment.spm) as otherpaymentTotal, 0 as noncerntotal, 0 as querytotal,0 as missingtotal
			    from otherpayment
			    RIGHT JOIN dailylog on otherpayment.Encounter=dailylog.batchnumber
			    RIGHT JOIN worklog on dailylog.batchnumber=worklog.CPM
			    WHERE worklog.PostDate BETWEEN '$sdate' AND '$edate' AND worklog.FacilityID=".$Project_List_ID." AND worklog.CategoryID='$Categpry_List_ID'
			    
			    
			    UNION ALL
                  SELECT 0 as priorpendinginventorytoday, 0 as inventory, 0 as CPMTotal, 0 as otherpaymentTotal, sum(otherpayment.noncern) as noncerntotal, 0 as querytotal,0 as missingtotal
			    from otherpayment
			    RIGHT JOIN worklog on otherpayment.Encounter=worklog.CPM
			    WHERE worklog.PostDate BETWEEN '$sdate' AND '$edate' AND worklog.FacilityID=".$Project_List_ID." AND worklog.CategoryID='$Categpry_List_ID'
			    
			    
			    UNION ALL
			    
			    SELECT 0 as priorpendinginventorytoday, 0 as inventory, 0 as CPMTotal, 0 as otherpaymentTotal,0 as noncerntotal, SUM(querylog.amtinq) as querytotal, 0 as missingtotal
			    FROM querylog  WHERE status= 18 AND querylog.ProjectID IN (".$Project_List_ID.") AND querylog.Category='$Categpry_List_ID'
			    
			    UNION ALL

			    SELECT 0 as priorpendinginventorytoday, 0 as inventory, 0 as CPMTotal, 0 as otherpaymentTotal,0 as noncerntotal, 0 as querytotal,
			    SUM(missing.CheckAmt) as missingtotal
			    FROM missing  WHERE status!=33 AND missing.ProjectID=".$Project_List_ID." and missing.Category='$Categpry_List_ID'	    
			    
			) A";
		$query = $this->db->query($sql);
	    $row = $query->result_array(); 
        return $row;    	
	}
     // Author: Anand Srivastava Date: 15-Mar-2019
    public function addassociate($associate_id_add, $associate_name_add, $access_level_add){
        $Login_data = $this->session->userdata('userdata');
        $data = array(
            'AssociateID' => $associate_id_add,
            'AssociateName' => $associate_name_add,
            'AccessLevel' => $access_level_add,
            'ManagerID' => $Login_data[0]->AssociateID,
            'Active' => '0',
        );
        $sql = $this->db->insert('associate',$data);
        return $sql;
    }
    public function checkassociate($associate_id_add){
        $sql = "Select * from associate where AssociateID = '".$associate_id_add."'";
        $query = $this->db->query($sql); 
        $result = $query->result();
        if($query->num_rows()==0) {
            return TRUE;
        }
        else{
            return FALSE;
        }  
    }
}
?>