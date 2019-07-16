<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="wrapper">
    <div id="page-wrapper">
        <div class="row"><!-- ROW -->
            <div class="col-lg-6">
                <h2 class="page-header">Queries Resolved</h2>
            </div>
             <div class="col-lg-6">
                 <h4 class="page-header" align="right">
                     <a href="<?php echo BASE_URL;?>C_delegate/Query_Log" class="btn btn-danger" role="button"><i class="fa fa-question"></i> QUERIES</a>
                      <a href="<?php echo BASE_URL;?>C_delegate/Query_Log_Posted" class="btn btn-info" role="button"><i class="fa fa-archive"></i> POSTED</a>
                     <button type="submit" id="Query" name="Query" class="btn btn-primary" title="DOWNLOAD" onclick="Export('QueryLog','Query_Resolved');">
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
                                        <th>#</th>
                                        <th>Batch Name</th>
                                        <th>Amt in Question</th> 
                                        <th>Comments</th> 
                                        <th>Request By</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for($i=0;$i<sizeof($querylogarchivedata[0]);$i++){
                                        echo "<tr>";
                                        echo "<td>".$querylogarchivedata[0][$i]['queryid']."</td>";
                                        echo "<td>".$querylogarchivedata[0][$i]['Payer']."</td>";
                                        echo "<td>".$querylogarchivedata[0][$i]['amtinq']."</td>";
                                        echo "<td>".$querylogarchivedata[0][$i]['comment']."</td>";
                                        echo "<td>".$querylogarchivedata[0][$i]['AssociateName']."</td>";
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
    </div>             
</div>
<!-- /#page-wrapper -->
