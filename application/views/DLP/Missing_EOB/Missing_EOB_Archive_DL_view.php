<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="wrapper">
    <div id="page-wrapper">
        <div class="row"><!-- ROW -->
             <div class="col-lg-6">
                <h2 class="page-header">EOB Research - Archive</h2>
            </div>
            <div class="col-lg-6">
                <h2 class="page-header" align="right">
                    <!--<a href="<?php echo BASE_URL;?>C_delegate/Missing_EOB_Assigned" class="btn btn-danger" role="button"><i class="fa fa-check"></i> ASSIGNED</a>-->
                    <a href="<?php echo BASE_URL;?>C_delegate/Missing_EOB_Issues" class="btn btn-warning" role="button"><i class="fa fa-question"></i> ISSUES</a>
                    <a href="<?php echo BASE_URL;?>C_delegate/Missing_EOB_Resolved" class="btn btn-success" role="button"><i class="fa fa-star"></i> RESOLVED</a>
                    <a href="<?php echo BASE_URL;?>C_delegate/Missing_EOB_Pending" class="btn btn-info" role="button"><i class="fa fa-exclamation"></i> PENDING</a>
                    <button type="submit" id="Query" name="Query" class="btn btn-primary" title="DOWNLOAD" onclick="Export('MissingEOB','Research_Archive');">
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
                                        <th>Request Age</th>
                                        <th>Request By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for($i=0;$i<sizeof($missingeobarchivedata[0]);$i++){
                                        echo "<tr>";
                                            echo "<td>".$missingeobarchivedata[0][$i]["missingid"]."</td>";
                                            echo "<td>".$missingeobarchivedata[0][$i]["ProjectName"]."</td>";
                                            echo "<td>".$missingeobarchivedata[0][$i]["Category"]."</td>";
                                            echo "<td>".$missingeobarchivedata[0][$i]["Payer"]."</td>";
                                            echo "<td>".$missingeobarchivedata[0][$i]["CheckNo"]."</td>";
                                            $date1= date("Y-m-d");
                                            $date2= date('Y-m-d',strtotime($missingeobarchivedata[0][$i]["RequestedDate"]));
                                            $diff=date_diff(date_create($date1),date_create($date2));
                                            echo "<td>".$diff->format("%a days")."</td>";
                                            echo "<td>".$missingeobarchivedata[0][$i]["AssociateName"]."</td>";
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
