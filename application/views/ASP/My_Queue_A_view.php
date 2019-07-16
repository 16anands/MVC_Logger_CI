<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php if ($this->session->flashdata('alert')){ ?>
 <script type="text/javascript">
     $(document).ready( function () {
         $('#alertwarning').modal();
     });
 </script>
<?php } ?>
<div id="wrapper">
    <div id="page-wrapper">
        <div class="row">
           <!-- ROW -->
            <div class="col-lg-12">
                <h2 class="page-header">Summary Section</h2>
            </div>
        </div>
        <div class="row"> 
            <!--Per Month -->           
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b>Pending Summary</b> 
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                           <table class="table table-striped table-bordered" id="PM1">
                                <thead>
                                    <tr>
                                        <th>HOURS</th>
                                        <th>PENDING</th>
                                        <th>DOLLAR ($)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="danger">
                                        <td>> 48</td>
                                        <td><?php echo $PM1[0]['Pending'] ?></td>
                                        <td>$<?php echo $PM1[0]['Dollar'] ?></td>
                                    </tr>
                                    <tr class="warning">
                                        <td>36 - 48</td>
                                        <td><?php echo $PM1[1]['Pending'] ?></td>
                                        <td>$<?php echo $PM1[1]['Dollar'] ?></td>
                                    </tr>
                                    <tr class="success">
                                        <td>0 - 36</td>
                                        <td><?php echo $PM1[2]['Pending'] ?></td>
                                        <td>$<?php echo $PM1[2]['Dollar'] ?></td>
                                    </tr>
                               </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-6 -->
            <!-- //Per Month -->
            <!-- PER DAY  -->
              <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                               <b>Daily Summary</b> 
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" id="PM2">
                                        <thead>
                                            <tr>
                                        <th>TAT</th>
                                        <th>Completed (#|$)</th>
                                        <th>CPM (#|$)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="danger">
                                        <td>> 48</td>
                                        <td><?php echo $PM2[0]['Count']." | $".$PM2[0]['Dollar']?></td>
                                        <td><?php echo $PM2[0]['Count']." | $".$PM3[0]['MTDPT']?></td>
                                    </tr>
                                    <tr class="warning">
                                        <td>36 - 48</td>
                                        <td><?php echo $PM2[1]['Count']." | $".$PM2[1]['Dollar']?></td>
                                        <td><?php echo $PM2[1]['Count']." | $".$PM3[1]['MTDPT']?></td>
                                    </tr>
                                    <tr class="success">
                                        <td>0 - 36</td>
                                        <td><?php echo $PM2[2]['Count']." | $".$PM2[2]['Dollar']?></td>
                                        <td><?php echo $PM2[2]['Count']." | $".$PM3[2]['MTDPT']?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <!--PER DAY -->
        </div>
        <!-- Modal -->
        <div class="modal fade" id="alertwarning" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-fw" aria-hidden="true"></i> Warning </h4>
                    </div>
                    <div class="modal-body">
                        <p>Complete In-Process Batch First !!!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row"><!-- ROW -->
            <div class="col-lg-12">
                <h2 class="page-header">Work Queue View</h2>
            </div>
        </div>
        <!-- /.col-lg-12 --> 
        <div class="row">            
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="PT">
                                 <thead>
                                    <tr>
                                        <th>Sno</th>
                                        <th>Action</th>
                                        <th>WorkID</th>
                                        <th>Facility</th> 
                                        <th>Category</th> 
                                        <th>Batch/Payer</th>
                                        <th>Deposit On</th>
                                        <th>Amount</th>
                                        <th>Day(s)</th>
                                        <th>Status</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $XCount=1;
                                    $status = array("Assigned","Assigned", "In Process","Hold");
                                    for($i=0;$i<sizeof($myqueuedata);$i++){
                                        echo "<tr>";
                                            echo "<td>".$XCount++."</td>" ;  
                                            echo "<td>";
                                            $workid = base64_encode($myqueuedata[$i]["WorkID"]);
                                            ?>
                                            <a href="<?php echo BASE_URL;?>C_associate/Begin_Work/<?php echo $workid;?>">
                                            Begin<!--<i class="fa fa-play fa-fw" title="Begin"></i>-->
                                            </a>
                                            <?php
                                            echo "</td>";
                                            echo "<td>".$myqueuedata[$i]["WorkID"]."</td>";
                                            echo "<td>".$myqueuedata[$i]["ProjectName"]."</td>";
                                            echo "<td>".$myqueuedata[$i]["CategoryID"]."</td>";
                                            echo "<td>".$myqueuedata[$i]["BatchNo"]."</td>";
                                            $DepositeDate = date("m-d-Y", strtotime($myqueuedata[$i]["DepositeDate"]));
                                            echo "<td>".$DepositeDate. "</td>" ;
                                            echo "<td>$".$myqueuedata[$i]["Amount"]. "</td>" ;
                                            $date1= date("Y-m-d");;
                                            $date2= date('Y-m-d',strtotime($myqueuedata[$i]["UploadDate"]));
                                            $diff=date_diff(date_create($date1),date_create($date2));
                                            echo "<td>".$diff->format("%a")."</td>";
                                            echo "<td>".$status[$myqueuedata[$i]["Status"]]."</td>";
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
