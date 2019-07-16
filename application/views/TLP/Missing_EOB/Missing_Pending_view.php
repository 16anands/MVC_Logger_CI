<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="wrapper">
    <div id="page-wrapper">
        <div class="row"><!-- ROW -->
            <div class="col-lg-6">
                <h2 class="page-header"> My EOB Research - Pending</h2>
            </div>
            <div class="col-lg-6">
                <h4 class="page-header" align="right">
                    <a href="<?php echo BASE_URL;?>C_teamlead/Missing_Ready" class="btn btn-warning" role="button"><i class="fa fa-star"></i> READY</a>
                    <a href="<?php echo BASE_URL;?>C_teamlead/Missing_Posted" class="btn btn-info" role="button"><i class="fa fa-archive"></i> POSTED</a>
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
<!--                                        <th>Assigned To</th>-->
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
//                                        echo "<td>".$MEOB[$i]["AssignedIDAssociateName"]."</td>";
                                        if($MEOB[$i]["Status"]==18){
                                            echo "<td>Pending</td>";
                                        }
                                        else if($MEOB[$i]["Status"]==10){
                                            echo "<td>Assigned</td>";
                                        }
                                        else if($MEOB[$i]["Status"]==17){
                                            echo "<td>Issues</td>";
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
