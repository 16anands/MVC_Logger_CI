<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script type="text/javascript">
    function getmissingid(missingid){
        document.getElementById('missingid').value=missingid;
    }
    function updateworkassignstatus(assignid)
    {   
        missingid = document.getElementById('missingid').value;
        $pageid = "Missing_EOB_Issues";
        window.location.href = "<?php echo BASE_URL;?>C_mdelegate/updateworkassignstatus/"+missingid+"/"+assignid+"/"+$pageid;
    }
</script>
<div id="wrapper">
    <div id="page-wrapper">
        <div class="row"><!-- ROW -->
            <div class="col-lg-6">
                <h2 class="page-header">EOB Research - Issues</h2>
            </div>
            <div class="col-lg-6">
                <h2 class="page-header" align="right">
                    <a href="<?php echo BASE_URL;?>C_mdelegate/Missing_EOB_Assigned" class="btn btn-danger" role="button"><i class="fa fa-check"></i> ASSIGNED</a>
                    <a href="<?php echo BASE_URL;?>C_mdelegate/Missing_EOB_Pending" class="btn btn-warning" role="button"><i class="fa fa-exclamation"></i> PENDING</a>
                    <a href="<?php echo BASE_URL;?>C_mdelegate/Missing_EOB_Resolved" class="btn btn-success" role="button"><i class="fa fa-star"></i> RESOLVED</a>
                    <a href="<?php echo BASE_URL;?>C_mdelegate/Missing_EOB_Archive" class="btn btn-info" role="button"><i class="fa fa-archive"></i> ARCHIVE</a>
                    <button type="submit" id="Missing" name="Missing" class="btn btn-primary" title="DOWNLOAD" onclick="Export('MissingEOB','Research_Issues');">
                        <i class="fa fa-download"></i>
                    </button>
                </h2>
            </div>
        </div>
        <!-- /.col-lg-12 --> 
        <div class="row">            
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="MissingEOB">
                                <thead>
                                    <tr>
                                      
                                        <th>EOB ID</th>
                                        <th>Client</th> 
                                        <th>Category</th> 
                                        <th>Payer</th> 
                                        <th>Check#</th> 
                                        <th>Request Days</th>
                                        <th>Request By</th>
                                        <th>Assigned To</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for($i=0;$i<sizeof($missingeobissuesdata);$i++){
                                        echo "<tr>";
                                          
                                            echo "<td>".$missingeobissuesdata[$i]["missingid"]."</td>";
                                            echo "<td>".$missingeobissuesdata[$i]["ProjectName"]."</td>";
                                            echo "<td>".$missingeobissuesdata[$i]["Category"]."</td>";
                                            echo "<td>".$missingeobissuesdata[$i]["Payer"]."</td>";
                                            echo "<td>".$missingeobissuesdata[$i]["CheckNo"]."</td>";
                                            $date1= date("Y-m-d");
                                            $date2= date('Y-m-d',strtotime($missingeobissuesdata[$i]["RequestedDate"]));
                                            $diff=date_diff(date_create($date1),date_create($date2));
                                            echo "<td>".$diff->format("%a days")."</td>";
                                            echo "<td>".$missingeobissuesdata[$i]["RequestedByAssociateName"]."</td>";
                                            echo "<td>".$missingeobissuesdata[$i]["AssignedIDAssociateName"];
                                            ?>
                                            <a class="btn btn-info btn-xs" 
                                                data-toggle="modal" 
                                                data-target='#myModal' 
                                                onclick="getmissingid('<?php echo $missingeobissuesdata[$i]['missingid'];?>')">
                                                <i class="fa fa-edit fa-fw" title="EDIT"></i>
                                            </a>
                                            <?php
                                            echo "</td>";
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
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Assign To:</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="missingid" id="missingid">
                <select class="form-control" name="Associate_ID"  id="Associate_ID" onchange="updateworkassignstatus(this.value)">
                    <option value="">--Select--</option>
                    <?php
                    for($j=0;$j<sizeof($team[0]);$j++){
                        echo "<option value=".$team[0][$j]['AssociateID'].">".$team[0][$j]['AssociateName']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->