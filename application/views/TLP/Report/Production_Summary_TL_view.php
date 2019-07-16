<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  ?>
<?php
$first_date_find = strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . ", first day of this month");
$first_date = date("Y-m-d",$first_date_find);
isset($_POST['sdate']) ? $sdate = $_POST['sdate'] : $sdate = $first_date;
isset($_POST['edate']) ? $edate = $_POST['edate'] : $edate = date("Y-m-d");
isset($_POST['mtdsdate']) ? $mtdsdate = $_POST['mtdsdate'] : $mtdsdate = $first_date;;
isset($_POST['mtdedate']) ? $mtdedate = $_POST['mtdedate'] : $mtdedate = date("Y-m-d");
?>
<script type="text/javascript">
    $(function () {
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        var lastDay = new Date();
        $('#sdate').datetimepicker({format:"YYYY-MM-DD",minDate:firstDay,maxDate:lastDay});
        $('#edate').datetimepicker({format:"YYYY-MM-DD",minDate:firstDay,maxDate:lastDay});
        $('#edate').datetimepicker({useCurrent:true});
        $("#sdate").on("dp.change", function (e) {
            $('#edate').data("DateTimePicker").minDate(e.date);
        });
        $("#edate").on("dp.change", function (e) {
            $('#sdate').data("DateTimePicker").maxDate(e.date);
        });
        $('#mtdsdate').datetimepicker({format:"YYYY-MM-DD",minDate:firstDay,maxDate:lastDay});
        $('#mtdedate').datetimepicker({format:"YYYY-MM-DD",minDate:firstDay,maxDate:lastDay});
        $('#mtdedate').datetimepicker({useCurrent:true});
        $("#mtdsdate").on("dp.change", function (e) {
            $('#mtdedate').data("DateTimePicker").minDate(e.date);
        });
        $("#mtdedate").on("dp.change", function (e) {
            $('#mtdsdate').data("DateTimePicker").maxDate(e.date);
        });
    });
    //MTD Summary Call
    $(document).ready( function () {
        var prjectName = [];
        $('#client').multiselect({
            includeSelectAllOption: true, // add select all option as usual
            numberDisplayed: 1,
            onSelectAll: function(){
                console.log('SELECT ALL!');
                Cl_Name = [];                    
                brands = $('#client option:selected');
                $(brands).each(function(index, brand){
                    Cl_Name.push($(this).val());
                    console.log(Cl_Name);
                    $("#cl_deplog").val('');
                    $("#cl_deplog").val(Cl_Name);
                });
            },
            onChange: function(element, checked) {
                Cl_Name = []; 
                brands = $('#client option:selected');
                console.log(Cl_Name);
                $(brands).each(function(index, brand){
                    $("#cl_deplog").val('');
                    Cl_Name.push($(this).val());
                    console.log(Cl_Name);
                    var append = $("#cl_deplog").val();
                    if(append!='')
                        $("#cl_deplog").val(append+','+Cl_Name);
                    else
                        $("#cl_deplog").val(Cl_Name);
                });
            },
            onDeselectAll: function() {
                Cl_Name = []; 
                console.log(Cl_Name);
                $("#cl_deplog").val('');
            },
        });
    });

</script>
<div id="wrapper">
    <div id="page-wrapper">
        <div class="row"><!-- ROW -->
            <div class="col-lg-4">
                <h2 class="page-header">Download Section</h2>
            </div>
            <div class="col-lg-8">
                <h4 class="page-header"  align="right">
                    <form  method="post" action="<?php echo BASE_URL;?>C_teamlead/Report_Section">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <select class="form-control" name="Report_Type" required aria-required="true">
                                    <option value="">--Select--</option>
                                    <option value="Deposit_Log">Deposit Log</option>
                                    <option value="TAT_Summary">TAT Summary</option>
                                    <option value="Encounter_Summary">Encounter Summary</option>
                                </select>
                            </div>
                        </div>          
                        <div class='col-md-2'>
                            <div class="form-group">
                                <div class='input-group date' id='mtdsdate'>
                                    <input type='text' class="form-control"  name='mtdsdate' value="<?php echo $mtdsdate;?>" placeholder="Start Date" required aria-required="true"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-2'>
                            <div class="form-group">
                                <div class='input-group date' id='mtdedate' >
                                    <input type='text' class="form-control" name='mtdedate'  value="<?php echo $mtdedate; ?>" placeholder="End Date" required aria-required="true"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class='col-lg-2'>
                            <select id="client" multiple="multiple" name='client[]' required aria-required="true">
                                <?php for($i=0;$i<count($Cl_Names);$i++) {?>
                                <option value="<?php echo $Cl_Names[$i]['ProjectID'];?>">
                                    <?php echo $Cl_Names[$i]['ProjectName'];?></option>
                                <?php } ?> 
                            </select>
                        </div>
                        <input type="hidden" name="cl_deplog" id="cl_deplog"/>
                        <button type="submit" class="btn btn-primary" title="DOWNLOAD"><i class="fa fa-download"></i></button>
                    </form>
                </h4>
            </div>   
        </div><!-- ROW ENDS-->
        <div class="row">
            <div class="col-lg-7">
                <h2 class="page-header">Production Report</h2>
            </div>
            <div class="col-lg-5">
                <h4 class="page-header" align="right">
                    <form  method="post" action="<?php echo BASE_URL;?>C_teamlead/Production_Report">
                        <div class='col-md-4'>
                            <div class="form-group">
                                <div class='input-group date' id='sdate'>
                                    <input type='text' class="form-control"  name='sdate' value="<?php echo $sdate; ?>"  placeholder="Start Date" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-4'>
                            <div class="form-group">
                                <div class='input-group date' id='edate'>
                                    <input type='text' class="form-control" name='edate' value="<?php echo $edate; ?>" placeholder="Start Date"  />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <button type="submit" class="btn btn-info" title="APPLY DATES">
                                <i class="fa fa-filter"> </i>
                            </button>
                        </div>
                    </form>
                    <button type="submit" id="MTD" name="MTD" class="btn btn-primary" title="DOWNLOAD" onclick="Export('PROD_S','Production_Summary_LOG');">
                        <i class="fa fa-download"></i>
                    </button>
                </h4>
            </div>
        <!-- /.col-lg-12 -->
        </div>
        <div class="row">            
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="PROD_S">
                                <thead>
                                    <tr>
                                        <th>Associate ID</th>
                                        <th>Associate Name</th>
                                      <!--  <th>Encounters</th>-->
                                        <th>Transactions</th>
                                        <th>CPM Posted</th>
                                        <th>Others</th>
                                        <th>Pending</th>
                                        <th>Utilization Time</th>
                                        <th>Production Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for($i=0;$i<sizeof($TeamList);$i++){
                                        echo "<tr>";
                                        echo "<td>".$TeamList[$i]['AssociateID']."</td>";
                                        echo "<td>".$TeamList[$i]['AssociateName']."</td>";
                                      /*  echo "<td>".$production_summary[$i][0]['ESUM']."</td>";*/
                                        echo "<td>".$production_summary[$i][0]['Tsum']."</td>";
                                        echo "<td>".$production_summary[$i][0]['count_CPMAmt']." | $".$production_summary[$i][0]['sum_CPMAmt']."</td>";
                                        echo "<td>".$production_summary[$i][0]['othersome']."</td>";
                                        echo "<td>".$production_summary[$i][0]['count_Pending']." | $".$production_summary[$i][0]['sum_Pending']."</td>";
                                        $hours = floor($production_summary[$i][0]["WorkTime"]/3600);
                                        if ($hours < 10) {
                                            $hours = '0' . $hours;
                                        }
                                        $minutes = floor(($production_summary[$i][0]["WorkTime"]/ 60) % 60);
                                        if ($minutes < 10) {
                                            $minutes = '0' . $minutes;
                                        }
                                        $seconds = $production_summary[$i][0]["WorkTime"] % 60;
                                        if ($seconds < 10) {
                                            $seconds = '0' . $seconds;
                                        }
                                        echo "<td>".$hours.":".$minutes.":".$seconds."</td>" ;   
                                        $LoginTime =  (strtotime($production_summary[$i][0]["Logout"]) - strtotime($production_summary[$i][0]["Login"]));    
                                        $hours = floor($LoginTime/3600);
                                        if ($hours < 10) {
                                            $hours = '0' . $hours;
                                        }
                                        $minutes = floor(($LoginTime/ 60) % 60);
                                        if ($minutes < 10) {
                                            $minutes = '0' . $minutes;
                                        }
                                        $seconds = $LoginTime % 60;
                                        if ($seconds < 10) {
                                            $seconds = '0' . $seconds;
                                        }
                                        echo "<td>".$hours.":".$minutes.":".$seconds."</td>" ;
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
    </div><!--Page Wrapper -->
</div>