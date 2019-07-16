<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
isset($_POST['Facility_Id']) ? $Facility_Id = $_POST['Facility_Id'] : $Facility_Id='--Select--';
//RECON Summary Last Date
isset($_POST['sdate']) ? $sdate = $_POST['sdate'] : $sdate=date("Y-m-d");
//MTD Summary First Date
$first_date_find = strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . ", first day of this month");
$first_date = date("Y-m-d",$first_date_find);
isset($_POST['mtdsdate']) ? $mtdsdate = $_POST['mtdsdate'] : $mtdsdate=$first_date;
//MTD Summary Last Date
isset($_POST['mtdedate']) ? $mtdedate = $_POST['mtdedate'] : $mtdedate=date("Y-m-d");
?>
<div id="wrapper">
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-9">
                <h1 class="page-header">Dashboard</h1> 
            </div>
            <div class="col-lg-3">
                <h4 class="page-header" align="right">
                    <form  method="post" action="">
                        <div class='col-md-9'>
                            <div class="form-group">
                                <select class="form-control" name="Facility_Id" required aria- required="true">
                                      <option value="">--Select Client--</option>
                                    <?php for($i=0;$i<count($ProjectList);$i++) {?>
                                    <option value="<?php echo $ProjectList[$i]['ProjectID'];?>" <?php if ($ProjectList[$i]['ProjectID']==$Facility_Id) echo 'selected="selected"'; ?>>
                                        <?php echo $ProjectList[$i]['ProjectName'];?></option>
                                    <?php } ?> 
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <button type="submit" class="btn btn-info" title="APPLY">
                                <i class="fa fa-filter"> </i>
                            </button>
                        </div>
                    </form>
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="glyphicon glyphicon-log-in fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">$<?php echo $influx[0]['MTDD'] ?></div>
                            </div>
                        </div>
                    </div>
                    <a href="">
                        <div class="panel-footer">
                            <span class="pull-right"><b>INFLUX</b></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-4">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="glyphicon glyphicon-check fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">$<?php echo $influx[0]['Assign'] ?></div>
                            </div>
                        </div>
                    </div>
                   <a href="">
                        <div class="panel-footer">
                            <span class="pull-right"><b>ASSIGNED</b></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-4">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="glyphicon glyphicon-warning-sign fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">$<?php echo $influx[0]['Dollar'] ?></div>
                            </div>
                        </div>
                    </div>
                   <a href="">
                        <div class="panel-footer">
                            <span class="pull-right"><b>> 48 Hours</b></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-4">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-trophy fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">$<?php echo $influx[0]['MTDPT'] ?></div>
                            </div>
                        </div>
                    </div>
                    <a href="">
                        <div class="panel-footer">
                            <span class="pull-right"><b>COMPLETED</b></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row"><!-- ROW -->
            <div class="col-lg-8">
                <h2 class="page-header">Reconciliation Snapshot</h2>
            </div>
            <div class="col-lg-4">
                <h4 class="page-header" align="right">
                    <form  method="post" action="">
                        <div class='col-md-5'>
                            <div class="form-group">
                                <div class='input-group date' id='sdate'>    
                                    <input type='text' class="form-control" name='sdate'  value="<?php  echo $sdate; ?>" placeholder="End Date"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <button type="submit" class="btn btn-info" title="APPLY DATE">
                                <i class="fa fa-filter"> </i>
                            </button>
                        </div>
                    </form>
                    <button type="submit" id="MTD" name="MTD" class="btn btn-primary" title="DOWNLOAD" onclick="Export('RECON_S','Reconciliation_LOG');">
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
                            <table class="table table-striped table-bordered table-hover" id="RECON_S">
                                <thead>
                                  
                                    <tr>
                                        <th>Client</th>
                                        <th>Prior Day Pending Inventory</th>
                                        <th>Inventory</th>
                                        <th>Total Inventory</th>
                                        <th>CPM Total</th>
                                        <th>Other Payment</th>
                                        <th>Non Cerner</th> 
                                        <th>Remaining Inventory after Posting</th> 
                                        <th>Ready to Post</th> 
                                        <th>Query</th> 
                                        <th>Research</th> 
                                        <th>Pending Total</th> 
                                        <th>Balance</th> 
                                    </tr>
                                      <tr>
                                        <th>Calculation</th>
                                        <th>A</th>
                                        <th>B</th>
                                        <th>C=A+B</th>
                                        <th>D</th>
                                        <th>E</th>
                                        <th>F</th> 
                                        <th>G = C-(D+E+F)</th> 
                                        <th>H = G-(I+J)</th> 
                                        <th>I</th> 
                                        <th>J</th> 
                                        <th>K= H+I+J</th> 
                                        <th>L=G-K</th> 
                                    </tr> 
                                </thead>      
                                <tbody>
                                    <?php
                                    $i=0;
                                    $k=0;
                                    foreach($ProjectList as $client){
                                        echo "<tr class='parent'>";
                                        echo "<td class='client'><i class='glyphicon glyphicon-plus'></i>".$client['ProjectName']."</td>";
                                        echo "<td>$".number_format($RECON[$i][0]['priorpendinginventorytoday'],2)."</td>";
                                        echo "<td>$".number_format($RECON[$i][0]['inventory'],2)."</td>";
                                        $C=($RECON[$i][0]['priorpendinginventorytoday']+$RECON[$i][0]['inventory']);
                                        echo "<td>$".number_format($C,2)."</td>";
                                        echo "<td>$".number_format($RECON[$i][0]['CPMTotal'],2)."</td>";
                                        echo "<td>$".number_format($RECON[$i][0]['otherpaymentTotal'],2)."</td>";
                                        echo "<td>$".number_format($RECON[$i][0]['noncerntotal'],2)."</td>";
                                        $G=(($RECON[$i][0]['priorpendinginventorytoday']+$RECON[$i][0]['inventory'])-($RECON[$i][0]['CPMTotal']+$RECON[$i][0]['otherpaymentTotal']+$RECON[$i][0]['noncerntotal']));
                                        echo "<td>$".number_format($G,2)."</td>";
                                        $H=$G-($RECON[$i][0]['querytotal']+$RECON[$i][0]['missingtotal']);
                                        echo "<td>$".number_format($H,2)."</td>";
                                        echo "<td>$".number_format($RECON[$i][0]['querytotal'],2)."</td>";
                                        echo "<td>$".number_format($RECON[$i][0]['missingtotal'],2)."</td>";
                                        $K=$H+$RECON[$i][0]['querytotal']+$RECON[$i][0]['missingtotal'];
                                        echo "<td>$".number_format($K,2)."</td>";
                                        $L=$G-$K;
                                        echo "<td>$".number_format($L,2)."</td>";
                                        echo "</tr>";
                                        if(sizeof($CategoryList[$i])>0){
                                            for($j=0;$j<sizeof($CategoryList[$i]);$j++){
                                                echo "<tr>";
                                                echo "<td class='category'>".$CategoryList[$i][$j]['CategoryID']."</td>";
                                                echo "<td>$".number_format($RECONCAT[$k][0]['priorpendinginventorytoday'],2)."</td>";
                                                echo "<td>$".number_format($RECONCAT[$k][0]['inventory'],2)."</td>";
                                                $C=($RECONCAT[$k][0]['priorpendinginventorytoday']+$RECONCAT[$k][0]['inventory']);
                                                echo "<td>$".number_format($C,2)."</td>";
                                                echo "<td>$".number_format($RECONCAT[$k][0]['CPMTotal'],2)."</td>";
                                                echo "<td>$".number_format($RECONCAT[$k][0]['otherpaymentTotal'],2)."</td>";
                                                echo "<td>$".number_format($RECONCAT[$k][0]['noncerntotal'],2)."</td>";
                                                $G=(($RECONCAT[$k][0]['priorpendinginventorytoday']+$RECONCAT[$k][0]['inventory'])-($RECONCAT[$k][0]['CPMTotal']+$RECONCAT[$k][0]['otherpaymentTotal']+$RECONCAT[$k][0]['noncerntotal']));
                                                echo "<td>$".number_format($G,2)."</td>";
                                                $H=$G-($RECONCAT[$k][0]['querytotal']+$RECONCAT[$k][0]['missingtotal']);
                                                echo "<td>$".number_format($H,2)."</td>";
                                                echo "<td>$".number_format($RECONCAT[$k][0]['querytotal'],2)."</td>";
                                                echo "<td>$".number_format($RECONCAT[$k][0]['missingtotal'],2)."</td>";
                                                $K=$H+$RECONCAT[$k][0]['querytotal']+$RECONCAT[$k][0]['missingtotal'];
                                                echo "<td>$".number_format($K,2)."</td>";
                                                $L=$G-$K;
                                                echo "<td>$".number_format($L,2)."</td>";
                                                echo "</tr>";
                                                $k=$k+1;
                                            }
                                        }
                                        $i=$i+1;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row"><!-- ROW -->
            <div class="col-lg-8">
                <h2 class="page-header">MTD Summary</h2>
            </div>
            <div class="col-lg-4">
                <h4 class="page-header" align="right">
                    <form  method="post" action="">
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
                                        <th rowspan="2">Client</th>
                                        <th rowspan="2">Prev. Month Total Posting</th>
                                        <th rowspan="2">Prev. MTD Posting</th>
                                        <th rowspan="2">Prior Month Rollover (X)</th>
                                        <th rowspan="2">Today's Inventory <?php echo date('Y-m-d');?></th>
                                        <th rowspan="2">MTD Deposit as of <?php echo $mtdedate;?></th>
                                        <th rowspan="2">Total Received MTD</th>
                                        <th rowspan="2">Posted Today <?php echo date('Y-m-d');?></th>
                                        <th rowspan="2">MTD Posted as of <?php echo $mtdedate;?></th>
                                        <th colspan="4">Pending Inventory</th>
                                        <th rowspan="2">Non-Cerner</th>  
                                        <th rowspan="2">Others</th> 
                                        <th rowspan="2">Variance</th> 
                                    </tr>
                                    <tr>
                                       <th>Ready to Post</th>
                                       <th>Query</th> 
                                       <th>Research</th> 
                                       <th>Total</th> 
                                    </tr>
                                    <tr>
                                        <th>Calculation</th>
                                        <th>Z</th>
                                        <th>Y</th>
                                        <th>X</th>
                                        <th>A</th>
                                        <th>B</th>
                                        <th>C=X+B</th>
                                        <th>D</th>
                                        <th>E</th>
                                        <th>G=C-(E+J+K)</th>
                                        <th>H</th>
                                        <th>I</th>
                                        <th>F=G+H+I</th>
                                        <th>J</th>  
                                        <th>K</th> 
                                        <th>L=(C-(E+J+K))-G</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i=0;
                                    foreach($ProjectList as $client){
                                        echo "<tr>";
                                        echo "<td class='client'>".$client['ProjectName']."</td>";
                                        echo "<td>$".number_format($MTD[$i][0]['PMTP'],2)."</td>";
                                        echo "<td>$".number_format($MTD[$i][0]['PMMP'],2)."</td>";
                                        $PMRNV = (float)$MTD[$i][0]['PMR'];
                                        $TTINV = (float)$MTD[$i][0]['TTI'];
                                        $MTDDNV = (float)$MTD[$i][0]['MTDD'];
                                        $PMPNV = (float)$MTD[$i][0]['PMP'];
                                        echo "<td>$".number_format($PMRNV,2)."</td>";
                                        echo "<td>$".number_format($TTINV,2)."</td>";
                                        echo "<td>$".number_format($MTDDNV,2)."</td>";
                                        echo "<td>$".number_format((float)(($MTDDNV+$PMRNV)-$PMPNV),2)."</td>";
                                        echo "<td>$".number_format($MTD[$i][0]['TPT'],2)."</td>";
                                        $MTDPTNV = $MTD[$i][0]['MTDPT'];
                                        echo "<td>$".number_format($MTDPTNV,2)."</td>";
                                        $OTNV = (float)$MTD[$i][0]['OT'];
                                        $NCNV = (float)$MTD[$i][0]['NC'];
                                        $QANV = (float)$MTD[$i][0]['QA'];
                                        $MANV = (float)$MTD[$i][0]['MA'];
                                        echo "<td>$".number_format((float)((($MTDDNV+$PMRNV)-$PMPNV)-($MTDPTNV+$OTNV+$NCNV)),2)."</td>";
                                        echo "<td>$".number_format($QANV,2)."</td>";
                                        echo "<td>$".number_format($MANV,2)."</td>";
                                        echo "<td>$".number_format((float)((($MTDDNV+$PMRNV)-$PMPNV)-($MTDPTNV+$OTNV+$NCNV)+($QANV+$MANV)),2)."</td>";
                                        echo "<td>$".number_format($NCNV,2)."</td>";
                                        echo "<td>$".number_format($OTNV,2)."</td>";
                                        echo "<td>$".number_format(((float)((($MTDDNV+$PMRNV)-$PMPNV)-($MTDPTNV+$OTNV+$NCNV))-((($MTDDNV+$PMRNV)-$PMPNV)-($MTDPTNV+$OTNV+$NCNV))),2)."</td>";
                                        echo"</tr>"; 
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