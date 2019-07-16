<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="wrapper">
    <div id="page-wrapper">
        <div class="row"><!-- ROW -->
            <div class="col-lg-6">
                <h2 class="page-header">My EOB Research - Ready</h2>
            </div>
            <div class="col-lg-6">
                <h4 class="page-header" align="right">
                    <a href="<?php echo BASE_URL;?>C_associate/Missing_EOB_Pending" class="btn btn-danger" role="button"><i class="fa fa-question"></i> PENDING</a>
                    <a href="<?php echo BASE_URL;?>C_associate/Missing_EOB_Posted" class="btn btn-info" role="button"><i class="fa fa-archive"></i> POSTED</a>
                </h4>
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
                                        <th>Request Age</th>
                                      <!--  <th>Assigned To</th>-->
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for($i=0;$i<sizeof($MEOB);$i++){
                                        echo "<tr>";
                                        echo "<td>".$MEOB[$i]["missingid"]."</td>";
                                        echo "<td>".$MEOB[$i]["ProjectName"]."</td>";
                                        echo "<td>".$MEOB[$i]["Category"]."</td>";
                                        echo "<td>".$MEOB[$i]["Payer"]."</td>";
                                        echo "<td>".$MEOB[$i]["CheckNo"]."</td>";
                                        $date1= date("Y-m-d");
                                        $date2= date('Y-m-d',strtotime($MEOB[$i]["RequestedDate"]));
                                        $diff=date_diff(date_create($date1),date_create($date2));
                                        echo "<td>".$diff->format("%a days")."</td>";
                                       /* echo "<td>".$MEOB[$i]["AssignedIDAssociateName"]."</td>";*/
                                        if($MEOB[$i]["Status"]==33){
                                            $missingID = BASE_URL.'C_associate/Missing_Post/'.$MEOB[$i]["missingid"];
                                            echo "<td>".anchor($missingID, 'Post Now')."</td>";
                                        }
                                        else{
                                            echo "<td>".$MEOB[$i]["Status"]."</td>";
                                        }
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
