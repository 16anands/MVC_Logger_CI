<? php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="wrapper">
    <div id="page-wrapper">
        <div class="row"><!-- ROW -->
            <div class="col-lg-6">
                <h2 class="page-header">Query Log</h2>
            </div>
            <div class="col-lg-6">
                <h4 class="page-header" align="right">
                    <a href="<?php echo BASE_URL;?>C_teamlead/Query_Log_Archive/" class="btn btn-success" role="button"><i class="fa fa-check" title="RESOLVED" ></i> RESOLVED</a>
                     <a href="<?php echo BASE_URL;?>C_teamlead/Query_Log_Posted/" class="btn btn-info" role="button"><i class="fa fa-archive" title="POSTED" ></i> POSTED</a>
                    <button type="submit" id="Query" name="Query" class="btn btn-primary" title="DOWNLOAD" onclick="Export('QueryLog','Query_LOG');">
                        <i class="fa fa-download"></i>
                    </button>
                </h4>
            </div>
        </div>
        <!-- /.col-lg-12 --> 
        <div class="row">            
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="QueryLog">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Batch Name</th>
                                        <th>Amt in Question</th> 
                                        <th>Comments</th> 
                                        <th>Request By</th> 
                                        <th>Request Age</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        for($i=0;$i<sizeof($querylogdata[0]);$i++){
                                            echo "<tr>";
                                            if($querylogdata[0][$i]['status']==18){
                                                $queryid = base64_encode($querylogdata[0][$i]['queryid']);
                                                echo "<td>".anchor(BASE_URL."C_teamlead/Query_Working/".$queryid, 'Resolve')."</td>";
                                            }
                                            else{
                                                echo "<td>Resolved</td>";
                                            }
                                            echo "<td>".$querylogdata[0][$i]['Payer']."</td>";
                                            echo "<td>".$querylogdata[0][$i]['amtinq']."</td>";
                                            echo "<td>".$querylogdata[0][$i]['comment']."</td>";
                                            echo "<td>".$querylogdata[0][$i]['AssociateName']."</td>";
                                            $date1= date("Y-m-d");
                                            $date2= date('Y-m-d',strtotime($querylogdata[0][$i]['RequestedDate']));
                                            $diff=date_diff(date_create($date1),date_create($date2));
                                            echo "<td>".$diff->format("%a days")."</td>";
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
