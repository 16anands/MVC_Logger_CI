<? php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="wrapper">
    <div id="page-wrapper">
        <div class="row"><!-- ROW -->
            <div class="col-lg-12">
                <h2 class="page-header">EOB Research Queue</h2>
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
                                    </tr>
                                </thead>
                                <?php
                               //2 print_r($team);
                                ?>
                                <tbody>
                                    <?php
                                    for($i=0;$i<sizeof($myqueuedata);$i++){
                                        echo "<tr>";
                                        $missingid = base64_encode($myqueuedata[$i]["missingid"]);
                                        $pageid = base64_encode('Work_Queue');
                                        $missingIDpath = BASE_URL.'C_mdelegate/missingworking/'.$missingid.'/'.$pageid;
                                        echo "<td>".anchor($missingIDpath, 'Begin')."</td>";
                                        echo "<td>".$myqueuedata[$i]["missingid"]."</td>";
                                        echo "<td>".$myqueuedata[$i]["ProjectName"]."</td>";
                                        echo "<td>".$myqueuedata[$i]["Category"]."</td>";
                                        echo "<td>".$myqueuedata[$i]["Payer"]."</td>";
                                        echo "<td>".$myqueuedata[$i]["CheckNo"]."</td>";
                                        $date1= date("Y-m-d");
                                        $date2= date('Y-m-d',strtotime($myqueuedata[$i]["RequestedDate"]));
                                        $diff=date_diff(date_create($date1),date_create($date2));
                                        echo "<td>".$diff->format("%a days")."</td>";
                                        echo "<td>".$myqueuedata[$i]["RequestedByAssociateName"]."</td>";
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