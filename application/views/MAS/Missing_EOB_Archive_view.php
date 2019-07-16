<? php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="wrapper">
    <div id="page-wrapper">
        <div class="row"><!-- ROW -->
            <div class="col-lg-6">
                <h2 class="page-header">EOB Research - Archive</h2>
            </div>
            <div class="col-lg-6">
                <h2 class="page-header" align="right">
                    <a href="<?php echo BASE_URL;?>C_massociate/Missing_EOB_Resolved" class="btn btn-info" role="button"><i class="fa fa-archive"></i> RESOLVED</a>
                    <a href="<?php echo BASE_URL;?>C_massociate/Work_Queue" class="btn btn-success" role="button"><i class="fa fa-star"></i> RESEARCH</a>
                </h2>
            </div>
        </div>
        
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
                                    for($i=0;$i<sizeof($missingeobarchivedata);$i++){
                                        echo "<tr>";
                                            echo "<td>".$missingeobarchivedata[$i]["missingid"]."</td>";
                                            echo "<td>".$missingeobarchivedata[$i]["ProjectName"]."</td>";
                                            echo "<td>".$missingeobarchivedata[$i]["Category"]."</td>";
                                            echo "<td>".$missingeobarchivedata[$i]["Payer"]."</td>";
                                            echo "<td>".$missingeobarchivedata[$i]["CheckNo"]."</td>";
                                            $date1= date("Y-m-d");
                                            $date2= date('Y-m-d',strtotime($missingeobarchivedata[$i]["RequestedDate"]));
                                            $diff=date_diff(date_create($date1),date_create($date2));
                                            echo "<td>".$diff->format("%a days")."</td>";
                                            echo "<td>".$missingeobarchivedata[$i]["AssociateName"]."</td>";
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
