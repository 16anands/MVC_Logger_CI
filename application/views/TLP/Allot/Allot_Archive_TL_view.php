<? php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php 
isset($_POST['Facility_Id']) ? $Facility_Id = $_POST['Facility_Id'] : $Facility_Id='--Select--';
if ($this->session->flashdata('success')){ 
?>
 <script type="text/javascript">
     $(document).ready( function () {
         $('#imported').modal();
     });
 </script>
<?php } $pageid = "Allot_Archive_Log"; ?>
<script type="text/javascript">
    //Work Status Update WRT Page Tabs
    function updateworkstatus(workid,assignid){
        pageid = "Allot_Archive_Log";
        window.location.href = "<?php echo BASE_URL;?>C_teamlead/updateworkstatus/"+workid+"/"+assignid+"/"+pageid;
    }
    //Allot Table Call
    $(document).ready( function () {
        var table = $('#AllotLog').DataTable({
            "ordering": true,
            "processing": true,
            "lengthMenu": [[10, 15, 20, 25, 30, -1], [10, 15, 20, 25, 30, "All"]]
        });
    });
</script>
<div id="wrapper">
    <div id="page-wrapper">
        <div class="row"><!-- ROW -->
            <div class="col-lg-4">
                <h2 class="page-header">Archived Deposit Log</h2>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="imported" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><i class="fa fa-fw" aria-hidden="true"></i> Success </h4>
                        </div>
                        <div class="modal-body">
                            <p>Imported Successfully !!!</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="myCPMModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="<?php echo BASE_URL;?>C_teamlead/Upload_CPM/<?php echo($pageid);?>"  method="post" enctype="multipart/form-data">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">Import CPM Report</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="file" class="btn btn-default" name="userfile" accept=".csv"   required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <div class="modal fade" id="myDepositModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="<?php echo BASE_URL;?>C_teamlead/Upload_Log/<?php echo($pageid);?>"  method="post" enctype="multipart/form-data">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">Import Deposit Log </h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="file" class="btn btn-default" name="userfile" accept=".csv" required>
                                </div>
                                <div class="form-group">
                                   <select class="form-control" name="Facility_Id" required aria-required="true">
                                        <option value="">--Select--</option>
                                        <?php  if(!$Cl_Names==''){ ?>
                                        <?php for($i=0;$i<count($Cl_Names);$i++) {?>
                                        <option value="<?php echo $Cl_Names[$i]['ProjectID'];?>">
                                            <?php echo $Cl_Names[$i]['ProjectName'];?></option>
                                        <?php } ?> 
                                        <?php } ?> 
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>   
            <div class="col-lg-8">
                <h4 class="page-header" align="right">
                    <button class="btn btn-warning" data-toggle="modal" data-target="#myCPMModal">
                       <i class="fa fa-upload"></i> <b>CPM Report</b>
                    </button>
                    <button class="btn btn-warning" data-toggle="modal" data-target="#myDepositModal">
                         <i class="fa fa-upload"></i> <b>Deposit Log</b>
                    </button>
                    ||
                     <a href="<?php echo BASE_URL;?>C_teamlead/Allot_Assigned_Log/" class="btn btn-info" role="button"><i class="fa fa-check"></i> ASSIGNED</a>
                     <a href="<?php echo BASE_URL;?>C_teamlead/Allot_Pending_Log/" class="btn btn-danger" role="button"><i class="fa fa-exclamation"></i> PENDING</a>
                     <a href="<?php echo BASE_URL;?>C_teamlead/Allot_Hold_Log/" class="btn btn-warning" role="button"><i class="fa fa-stop"></i> HOLD</a>
                     <a href="<?php echo BASE_URL;?>C_teamlead/Allot_Log/" class="btn btn-success" role="button"><i class="fa fa-close"></i>  NOT ASSIGNED</a>
                </h4>
            </div>
        </div>
        <div class="row">
            <form  method="post" action="">
               <div class='col-lg-2'>
                    <div class="form-group">
                       <select class="form-control" name="Facility_Id" required aria- required="true">
                            <option value="">--Select Client--</option>
                            <?php  if(!$Cl_Names==''){ ?>
                            <?php for($i=0;$i<count($Cl_Names);$i++) {?>
                            <option value="<?php echo $Cl_Names[$i]['ProjectID'];?>" <?php if ($Cl_Names[$i]['ProjectID']==$Facility_Id) echo 'selected="selected"'; ?>>
                                <?php echo $Cl_Names[$i]['ProjectName'];?></option>
                            <?php } ?> 
                            <?php } ?> 
                        </select>
                    </div>
                </div>
                <div class="col-lg-1">
                    <button type="submit" class="btn btn-info" title="APPLY">
                        <i class="fa fa-filter"> </i>
                    </button>
                </div>
              </form>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="confirmwarn">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-fw" aria-hidden="true"></i> Warning </h4>
                    </div>
                    <div class="modal-body">
                        <p id="count"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" id="modal-btn-yes">Yes</button>
                        <button type="button" class="btn btn-primary" id="modal-btn-no">No</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-lg-12 --> 
        <div class="row">            
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="AllotLog">
                                <thead>
                                    <tr>
                                        <th>WorkID</th>
                                        <th>Facility</th> 
                                        <th>Category</th> 
                                        <th>Deposit Date</th>
                                        <th>Amount</th>
                                        <th>Batch Details</th>
                                        <th>CPM Amt</th>
                                        <th>CPM Batch</th>
                                        <th>Assigned</th>
                                        <th>Days</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                     for($i=0;$i<sizeof($allotdata);$i++) {
                                        echo "<tr>";
                                        echo "<td>".$allotdata[$i]["WorkID"]."</td>";
                                        echo "<td>".$allotdata[$i]["ProjectName"]."</td>";
                                        echo "<td>".$allotdata[$i]["CategoryID"]."</td>";
                                        $DepositeDate = date("m-d-Y", strtotime($allotdata[$i]["DepositeDate"]));
                                        echo "<td>". $DepositeDate. "</td>" ;
                                        echo "<td>$".number_format($allotdata[$i]["Amount"],2)."</td>";
                                        echo "<td>".$allotdata[$i]["BatchNo"]."</td>";
                                        echo "<td>$".number_format($allotdata[$i]["CPMAmt"],2)."</td>";
                                        echo "<td>".$allotdata[$i]["CPM"]."</td>";
                                        echo "<td>".$allotdata[$i]['AssociateName']."</td>";
                                        $date1= date("Y-m-d");
                                        $date2= date('Y-m-d H:i:s',strtotime($allotdata[$i]["UploadDate"]));
                                        $diff=date_diff(date_create($date1),date_create($date2));
                                        echo "<td>".$diff->format("%ad %H:%I:%S")."</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>             
    </div> <!-- Main Row -->
</div>
<!-- /#page-wrapper -->
