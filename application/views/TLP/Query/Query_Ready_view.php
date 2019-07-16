<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="wrapper">
    <div id="page-wrapper">
        <div class="row"><!-- ROW -->
            <div class="col-lg-6">
                <h2 class="page-header">My Ready Queries</h2>
            </div>
            <div class="col-lg-6">
                <h4 class="page-header" align="right">
                    <a href="<?php echo BASE_URL;?>C_teamlead/Query_Pending" class="btn btn-danger" role="button"><i class="fa fa-question"></i> PENDING</a>
                    <a href="<?php echo BASE_URL;?>C_teamlead/Query_Posted" class="btn btn-info" role="button"><i class="fa fa-archive"></i> POSTED</a>
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
                                        <th>QueryID</th>
                                        <th>Client</th> 
                                        <th>Category</th> 
                                        <th>Payer</th> 
                                        <th>Amount</th> 
                                        <th>Request Age</th>
                                        <th>Requested By</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for($i=0;$i<sizeof($Query);$i++){
                                        echo "<tr>";
                                        echo "<td>".$Query[$i]["queryid"]."</td>";
                                        echo "<td>".$Query[$i]["ProjectName"]."</td>";
                                        echo "<td>".$Query[$i]["Category"]."</td>";
                                        echo "<td>".$Query[$i]["Payer"]."</td>";
                                        echo "<td>".$Query[$i]["amtinq"]."</td>";
                                        $date1= date("Y-m-d");
                                        $date2= date('Y-m-d',strtotime($Query[$i]["RequestedDate"]));
                                        $diff=date_diff(date_create($date1),date_create($date2));
                                        echo "<td>".$diff->format("%a days")."</td>";
                                        echo "<td>".$Query[$i]["RequestedByAssociateName"]."</td>";
                                        if($Query[$i]["Status"]==33){
                                             $QueryID = BASE_URL.'C_teamlead/Query_Post/'.$Query[$i]["queryid"];
                                            echo "<td>".anchor($QueryID, 'Post Now')."</td>";
                                        }
                                        else{
                                            echo "<td>".$Query[$i]["Status"]."</td>";
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
