<? php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script type="text/javascript">
    function getmissingid(missingid){
        document.getElementById('missingid').value=missingid;
    }
    function updateworkassignstatus(assignid)
    {   
        missingid = document.getElementById('missingid').value;
        $pageid = "Missing_EOB_Resolved";
        window.location.href = "<?php echo BASE_URL;?>C_mdelegate/updateworkassignstatus/"+missingid+"/"+assignid+"/"+$pageid;
    }
</script>
<div id="wrapper">
    <div id="page-wrapper">
        <div class="row"><!-- ROW -->
            <div class="col-lg-6">
                <h2 class="page-header">EOB Research - Resolved
                </h2>
            </div>
            <div class="col-lg-6">
                <h2 class="page-header" align="right">
                   <a href="<?php echo BASE_URL;?>C_massociate/Work_Queue" class="btn btn-success" role="button"><i class="fa fa-star"></i> RESEARCH</a>
                    <a href="<?php echo BASE_URL;?>C_massociate/Missing_EOB_Archive" class="btn btn-info" role="button"><i class="fa fa-archive"></i> ARCHIVE</a>
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
                                        <th>Action</th>
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
                                    for($i=0;$i<sizeof($missingeobresolveddata);$i++){
                                        echo "<tr>";
                                            if(strcmp($missingeobresolveddata[$i]['AssignedIDAssociateName'], "EOB Research")==0){
                                                echo "<td>NOT ASSIGNED</td>";
                                            }
                                            else{
                                                $missingid = base64_encode($missingeobresolveddata[$i]["missingid"]);
                                                $pageid = base64_encode('Missing_EOB_Resolved');
                                                $missingIDpath = BASE_URL.'C_massociate/missingworking/'.$missingid.'/'.$pageid;
                                                echo "<td>".anchor($missingIDpath, 'Begin')."</td>";
                                            }
                                            echo "<td>".$missingeobresolveddata[$i]["missingid"]."</td>";
                                            echo "<td>".$missingeobresolveddata[$i]["ProjectName"]."</td>";
                                            echo "<td>".$missingeobresolveddata[$i]["Category"]."</td>";
                                            echo "<td>".$missingeobresolveddata[$i]["Payer"]."</td>";
                                            echo "<td>".$missingeobresolveddata[$i]["CheckNo"]."</td>";
                                            $date1= date("Y-m-d");
                                            $date2= date('Y-m-d',strtotime($missingeobresolveddata[$i]["RequestedDate"]));
                                            $diff=date_diff(date_create($date1),date_create($date2));
                                            echo "<td>".$diff->format("%a days")."</td>";
                                            echo "<td>".$missingeobresolveddata[$i]["RequestedByAssociateName"]."</td>";
                                            echo "<td>".$missingeobresolveddata[$i]["AssignedIDAssociateName"];
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