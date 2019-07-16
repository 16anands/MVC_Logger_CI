<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php 
isset($_POST['sdate']) ? $sdate = $_POST['sdate'] : $sdate=date("Y-m-d");
$first_date_find = strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . ", first day of this month");
$first_date = date("Y-m-d",$first_date_find);
isset($_POST['mtdsdate']) ? $mtdsdate = $_POST['mtdsdate'] : $mtdsdate=$first_date;
//MTD Summary Last Date
isset($_POST['mtdedate']) ? $mtdedate = $_POST['mtdedate'] : $mtdedate=date("Y-m-d");
?>
<div id="wrapper">
    <div id="page-wrapper">
        <div class="row"><!-- ROW -->
            <div class="col-lg-8">
                <h2 class="page-header">MTD Summary</h2>
            </div>
            <div class="col-lg-4">
                <h4 align="right" class="page-header">
                    <form  method="post" action="<?php echo BASE_URL;?>C_massociate">
                        <div class='col-md-5'>
                            <div class="form-group">
                                <div class='input-group date' id='mtdsdate'>
                                    <input type='text' class="form-control"  name='mtdsdate' value="<?php echo $mtdsdate; ?>"  placeholder="Start Date" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <button type="submit" class="btn btn-info" title="APPLY MONTH">
                                <i class="fa fa-filter"> </i>
                            </button>
                        </div>
                    </form>
                    <button type="submit" id="MTD" name="MTD" class="btn btn-primary" title="DOWNLOAD" onclick="Export('MTD_S','MTD_LOG');">
                        <i class="fa fa-download"></i>
                    </button>
                </h4>
            </div>
        </div>
        <div class="row">            
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="MTD_S">
                                <thead>
                                     <tr>
                                        <th>Client</th>
                                        <th>Assigned (#)</th>
                                        <th>Assigned ($)</th>
                                        <th>Issues (#)</th>
                                        <th>Issues ($)</th>
                                        <th>Pending (#)</th>
                                        <th>Pending ($)</th>
                                        <th>Resolved (#)</th>
                                        <th>Resolved ($)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i=0;
                                    foreach($ProjectList as $client){
                                        echo "<tr>";
                                        echo "<td class='client'>".$client['ProjectName']."</td>";
                                        echo "<td>".$mtd[$i][0]['ACount']."</td>";
                                        echo "<td>$".$mtd[$i][0]['AAmount']."</td>";
                                        echo "<td>".$mtd[$i][0]['ICount']."</td>";
                                        echo "<td>$".$mtd[$i][0]['IAmount']."</td>";
                                        echo "<td>".$mtd[$i][0]['PCount']."</td>";
                                        echo "<td>$".$mtd[$i][0]['PAmount']."</td>";
                                        echo "<td>".$mtd[$i][0]['RCount']."</td>";
                                        echo "<td>$".$mtd[$i][0]['RAmount']."</td>";
                                        echo "</tr>";
                                        $i++;
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