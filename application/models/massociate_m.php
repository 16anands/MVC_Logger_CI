<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
Class massociate_m extends CI_Model{
        // Author: Anand Srivastava Date: 31-Jan-2019
    function fetch_teamlist(){//Get the list of associates under a specific teamlead
        $Login_data = $this->session->userdata('userdata');
        $sql = "SELECT *  FROM `associate` WHERE `ManagerID` = '".$Login_data[0]->ManagerID."'";
        $query = $this->db->query($sql);
        $row = $query->result_array(); 
        return $row;
    }  
    function fetch_teamleadlist(){
        $sql = "select * from associate where AccessLevel = 14";
        $query = $this->db->query($sql);
        $row = $query->result_array(); 
        return $row;
    }
    // Missing Working Ends
    function fetch_missing_eob_resolved($team){
        $Login_data = $this->session->userdata('userdata');
        $sql = "SELECT `missingid`, `project`.`ProjectName`, `Category`, `Payer`, `CheckNo`, `RequestedDate`, 
            `AssociateName` as RequestedByAssociateName,
            associate.AssociateID as RequestedByAssociateID,
            (SELECT associate.AssociateID from associate WHERE associate.AssociateID=missing.AssignedID) as AssignedIDAssociateID,
            (SELECT associate.AssociateName from associate WHERE associate.AssociateID=missing.AssignedID) as AssignedIDAssociateName,
            missing.Status,
            status.*
             FROM `missing`, `project`, associate, status 
             WHERE status.statusid=missing.Status AND 
                            project.ProjectID=missing.ProjectID AND 
                            associate.AssociateID = missing.RequestedBy AND 
                            missing.Status=33 AND
                            AssignedID IN ('".$Login_data[0]->AssociateID."')";
        $query = $this->db->query($sql);
        $row = $query->result_array(); 
        return $row;
    }
    function fetch_missing_eob_archive($team){
        $Login_data = $this->session->userdata('userdata');
        $sql = "SELECT `missingid`, `project`.`ProjectName`, `Category`, `Payer`, `CheckNo`, `RequestedDate`, `AssociateName`, missing.Status 
                FROM `missing`, `project`,associate 
                WHERE project.ProjectID=missing.ProjectID AND associate.AssociateID = missing.RequestedBy AND AssignedID IN ('".$Login_data[0]->AssociateID."') AND missing.Status=34";
        $query = $this->db->query($sql);
        $row = $query->result_array(); 
        return $row;
    }
     // Missing Working Starts
    function missingworking($missingid){
        //$sql = "SELECT missing.*, project.ProjectName FROM missing, project WHERE missingid='$missingid' AND project.ProjectID=missing.ProjectID";
        $sql = " SELECT missing.*, project.ProjectID, project.ProjectName, associate.AssociateName as RequestedName, 
                (Select associate.AssociateName from associate,missing WHERE associate.AssociateID=missing.AssignedID and missingid='$missingid' ) as AssignedName
                FROM associate, missing, project 
                WHERE 
                    missingid='$missingid' AND
                    project.ProjectID=missing.ProjectID AND 
                    associate.AssociateID=missing.RequestedBy";

        $query = $this->db->query($sql);
        $row = $query->result_array(); 
        return $row;
    }
     #function get STATUS
    public function fetch_Status(){
        $sql="SELECT * FROM status WHERE statusid BETWEEN 17 AND 33";
        $query = $this->db->query($sql);
        $result = $query->result_array(); 
        return $result;
    }
     // Author: Anand Srivastava Date: 15-Mar-2019
    public function getActions($status){
        $sql = "SELECT * FROM action WHERE Parent = '$status'";
        $query = $this->db->query($sql);
        $result = $query->result(); 
        return $result;
    } 
    // Author: Anand Srivastava Date: 15-Mar-2019
    public function getMetrics($metrics){
        $sql = "SELECT * FROM action WHERE ActionID = '$metrics'";
        $query = $this->db->query($sql);
        $result = $query->result(); 
        return $result;
    }
    // Author: Anand Srivastava Date: 15-Mar-2019
    public function saveMissing($missingid,$comment,$note,$status,$action,$metric,$assignedID){
        $Login_data = $this->session->userdata('userdata');
        $Login_data[0]->AssociateID;
        $PostDate = date("m/d/Y H:i:s");
        $comment = htmlspecialchars($comment, ENT_QUOTES);
        $note = htmlspecialchars($note, ENT_QUOTES);
        if(isset($comment)){
            $finalcomment = $comment.'\n'.$Login_data[0]->AssociateID.' : '.$PostDate.' : '.$note;
        }
        else{
            $finalcomment = $Login_data[0]->AssociateID.':'.$PostDate.':'.$note;
        }    
        $sql = "UPDATE missing SET Comment ='$finalcomment', Status='$status', action='$action', eta='$metric', AssignedID='$assignedID' WHERE missingid='$missingid'";
        $this->db->query($sql);
        return true;
    }
       // Author: Anand Srivastava Date: 31-Jan-2019
    function fetch_my_queue(){
        $Login_data = $this->session->userdata('userdata');
        $sql = "SELECT `missingid`, `project`.`ProjectName`, `Category`, `Payer`, `CheckNo`, `RequestedDate`, 
            `AssociateName` as RequestedByAssociateName,
            associate.AssociateID as RequestedByAssociateID,
            (SELECT associate.AssociateID from associate WHERE associate.AssociateID=missing.AssignedID) as AssignedIDAssociateID,
            (SELECT associate.AssociateName from associate WHERE associate.AssociateID=missing.AssignedID) as AssignedIDAssociateName,
            missing.Status,
            status.*
             FROM `missing`, `project`, associate, status 
             WHERE status.statusid=missing.Status AND 
                            project.ProjectID=missing.ProjectID AND 
                            associate.AssociateID = missing.RequestedBy AND missing.Status IN (18,10,17) AND AssignedID IN ('".$Login_data[0]->AssociateID."')";
        $query = $this->db->query($sql);
        $row = $query->result_array(); 
        return $row;
    }
    function fetch_associateList(){// Get the list of associates under a specific teamlead along the teamlead
        $Login_data = $this->session->userdata('userdata');
        $sql = "SELECT *  FROM `associate` WHERE `ManagerID` = '".$Login_data[0]->AssociateID."' or AssociateID = '".$Login_data[0]->AssociateID."'";
        $query = $this->db->query($sql);
        $row = $query->result_array(); 
        return $row;
    }
     // Author: Anand Srivastava Date: 15-Mar-2019
    public function production_summary($sdate,$edate,$associateID){
       $sql = "SELECT 
            sum(sum_CPMAmt) as sum_CPMAmt, 
            sum(count_CPMAmt) as count_CPMAmt, 
            sum(ESUM) as ESUM, 
            sum(TSUM) as Tsum, 
            Login, 
            Logout, 
            sum(WorkTime) as WorkTime, 
            sum(othersome) as othersome, 
            sum(count_Pending) as count_Pending, 
            sum(sum_Pending) as sum_Pending FROM (
                
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
                WHERE Encounter IN (SELECT CPM FROM `worklog` WHERE (PostDate BETWEEN '$sdate' AND '$edate') AND AssignedID = '$associateID')
                
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
     // Author: Anand Srivastava Date: 15-Mar-2019
    function fetch_dashboard_data($Project_List_ID,$sdate,$edate){
        $Login_data = $this->session->userdata('userdata');
    	$sql = "SELECT  sum(ACount) as ACount, sum(AAmount) as AAmount, sum(ICount) as ICount, sum(IAmount) as IAmount, sum(PCount) as PCount, sum(PAmount) as PAmount, sum(RCount) as RCount, 
        sum(RAmount) as RAmount FROM (
        
        SELECT COUNT(*) as ACount, SUM(CheckAmt) as AAmount, 0 as ICount, 0 as IAmount, 0 as PCount, 0 as PAmount, 0 as RCount, 0 as RAmount  FROM missing WHERE RequestedDate BETWEEN  '$sdate' AND '$edate' AND missing.ProjectID IN ('".$Project_List_ID."') AND Status=10 AND missing.AssignedID='".$Login_data[0]->AssociateID."'
        UNION ALL
        SELECT 0 as ACount, 0 as AAmount, COUNT(*) as ICount, SUM(CheckAmt) as IAmount, 0 as PCount, 0 as PAmount, 0 as RCount, 0 as RAmount FROM missing WHERE RequestedDate BETWEEN  '$sdate' AND '$edate' AND missing.ProjectID IN ('".$Project_List_ID."') AND Status=17 AND missing.AssignedID='".$Login_data[0]->AssociateID."'
        UNION ALL
        SELECT 0 as ACount, 0 as AAmount, 0 as ICount, 0 as IAmount, COUNT(*) as PCount, SUM(CheckAmt) as PAmount, 0 as RCount, 0 as RAmount FROM missing WHERE RequestedDate BETWEEN  '$sdate' AND '$edate' AND missing.ProjectID IN ('".$Project_List_ID."') AND Status=18 AND missing.AssignedID='".$Login_data[0]->AssociateID."'
        UNION ALL
        SELECT 0 as ACount, 0 as AAmount, 0 as ICount, 0 as IAmount,0 as PCount, 0 as PAmount, COUNT(*) as RCount, SUM(CheckAmt) as RAmount FROM missing WHERE RequestedDate BETWEEN  '$sdate' AND '$edate' AND missing.ProjectID IN ('".$Project_List_ID."') AND Status=33 AND missing.AssignedID='".$Login_data[0]->AssociateID."'
        
       ) A";
        $query = $this->db->query($sql);
        $row = $query->result_array(); 
        return $row;	
    }
    // Author: Anand Srivastava Date: 31-Jan-2019
    function fetch_projectlist(){
        $sql = "SELECT DISTINCT(missing.ProjectID),ProjectName FROM missing,project WHERE missing.ProjectID=project.ProjectID";
        $query = $this->db->query($sql);
        $row = $query->result_array(); 
        return $row;
    }
}
?>