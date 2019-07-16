<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php /*//Page Variable*/ $WID = $work[0]["queryid"]; ?>
<script type="text/javascript">
function saveMissing(flag){   
    switch(flag){
        case 0:
            var r = confirm("Exiting Query ?");
            if(r == true){
                window.location.href = "<?php echo BASE_URL;?>C_associate/Query_Ready";
            }
            break;
         case 1:
            var r = confirm("Complete Batch ?");
            if (r == true){
                return true
            }
            else{
                return false;
            }
    }          
}
$(document).ready( function () { 
    //Character Count for Comments    
    //OtherPayment Table Call
    var table = $('#OtherPayment').DataTable({
        "lengthChange": false, 
        "ordering": false,
        "info": false,
        "paging": false,
        "searching": false
    });
    //Data Table Call
    var table = $('#WorkingFetch').DataTable({
        "lengthChange": false, 
        "ordering": false,
        "info": false,
        "paging": false,
        "searching": false
    });
    //Input Table Call
    var table = $('#WorkingHeader').DataTable({
        "lengthChange": false, 
        "ordering": false,
        "info": false,
        "paging": false,
        "searching": false
    });
    //Add CPM Row
     $('#WorkingHeader thead').on( 'click', '#addcpm', function () {  
         table.row.add( [
             '<input type="text" id="batchnum" name="batchnum[]" required aria-   required="true" value=""/>',
             '<input type="number" class="txtCal" step="0.01" id="cpa" name="cpa[]" required aria-required="true" value=""/>',
             '<button id="deletecpm" class="btn btn-danger">'+'<i class="fa fa-trash" title="DELETE CPM"></i>'+'</button>'
         ] ).draw( true );
    });
    //Delete CPM Row
    $('#WorkingHeader tbody').on( 'click', '#deletecpm', function () {  
        table.row($(this).parents('tr')).remove().draw();
    });
});
//On Claim Paid Amount Calculation
$(document).ready(function(){
    var calculated_total_sum = 0;
    $("#total_sum_value").html(calculated_total_sum);
    $("#WorkingHeader").on('input', '.txtCal', function () {
        var calculated_total_sum = 0;
        $("#WorkingHeader .txtCal").each(function () {
            var get_textbox_value = $(this).val();
            if ($.isNumeric(get_textbox_value)) {
                calculated_total_sum += parseFloat(get_textbox_value);
            }                  
        });
        calculated_total_sum = calculated_total_sum.toFixed(2);
        $("#total_sum_value").html(calculated_total_sum);
    });
});
//On Other Payment Calculation
$(document).ready(function(){
    var calculated_total_sum = 0;
    $("#total_sum_other").html(calculated_total_sum);
    $("#OtherPayment").on('input', '.txtOC', function () {
        var calculated_total_sum = 0;
        $("#OtherPayment .txtOC").each(function () {
            var get_textbox_value = $(this).val();
            if ($.isNumeric(get_textbox_value)) {
                calculated_total_sum += parseFloat(get_textbox_value);
            }                  
        });
        calculated_total_sum = calculated_total_sum.toFixed(2);
        $("#total_sum_other").html(calculated_total_sum);
    });
});
//On Non Cerner Calculation
$(document).ready(function(){
    var calculated_total_sum = 0;
    $("#total_non_cern").html(calculated_total_sum);
    $("#OtherPayment").on('input', '.txtNC', function () {
        var calculated_total_sum = 0;
        $("#OtherPayment .txtNC").each(function () {
            var get_textbox_value = $(this).val();
            if ($.isNumeric(get_textbox_value)) {
                calculated_total_sum += parseFloat(get_textbox_value);
            }                  
        });
        calculated_total_sum = calculated_total_sum.toFixed(2);
        $("#total_non_cern").html(calculated_total_sum);
    });
});
//On Claim Paid Amount Pending Calculation
$(document).ready(function(){
    var calculated_total_sum = 0;
    $("#WorkingHeader").on('input', '.txtCal', function () {
        var x = $("#Amount").html();
        x = parseFloat(x);
        var cpm =  $("#total_sum_value").html();
        cpm = parseFloat(cpm);
        var ocpm =  $("#total_sum_other").html();
        ocpm = parseFloat(ocpm);
        var nonc =  $("#total_non_cern").html();
        nonc = parseFloat(nonc);
        var c = parseFloat(x) - parseFloat(ocpm + nonc + cpm);
        calculated_total_sum = (c).toFixed(2);
        $("#total_sum_pend").css("color", "white");
        if(calculated_total_sum==0.00){
            $("#total_sum_pend").css("background-color", "green");
        }
        else{
            $("#total_sum_pend").css("background-color", "red");
        }
        $("#total_sum_pend").html(calculated_total_sum);
    });
});
//On Other Payment Pending Calculation
$(document).ready(function(){
    var calculated_total_sum = 0;
    $("#OtherPayment").on('input', '.txtOC', function () {
        var x = $("#Amount").html();
        x = parseFloat(x);
        var cpm =  $("#total_sum_value").html();
        cpm = parseFloat(cpm);
        var ocpm =  $("#total_sum_other").html();
        ocpm = parseFloat(ocpm);
        var nonc =  $("#total_non_cern").html();
        nonc = parseFloat(nonc);
        var c = parseFloat(x) - parseFloat(ocpm + nonc + cpm);
        calculated_total_sum = (c).toFixed(2);
        $("#total_sum_pend").css("color", "white");
        if(calculated_total_sum==0.00){
            $("#total_sum_pend").css("background-color", "green");
        }
        else{
            $("#total_sum_pend").css("background-color", "red");
        }
        $("#total_sum_pend").html(calculated_total_sum);
    });
});
//On Non Cerner Pending Calculation
$(document).ready(function(){
    $("#OtherPayment").on('input', '.txtNC', function () {
        var x = $("#Amount").html();
        x = parseFloat(x);
        var cpm =  $("#total_sum_value").html();
        cpm = parseFloat(cpm);
        var ocpm =  $("#total_sum_other").html();
        ocpm = parseFloat(ocpm);
        var nonc =  $("#total_non_cern").html();
        nonc = parseFloat(nonc);
        var c = parseFloat(x) - parseFloat(ocpm + nonc + cpm);
        calculated_total_sum = (c).toFixed(2);
        $("#total_sum_pend").css("color", "white");
        if(calculated_total_sum==0.00){
            $("#total_sum_pend").css("background-color", "green");
        }
        else{
            $("#total_sum_pend").css("background-color", "red");
        }
        $("#total_sum_pend").html(calculated_total_sum);
    });
});
</script>
<style type="text/css">
table.table thead tr{
    border: 1px solid #000000;
}
table.table thead tr th {
    padding: 0px; 
    border: 1px solid #000000;
    line-height: 4rem;
    width:10%;
    vertical-align: middle;
    text-align: center;
}
.panel-info .panel-heading, .panel-success .panel-heading {
    border-color: #000000;
}
table.table tbody tr{
    border: 1px solid #000000;
}
table.table tbody tr td {
    padding: 0px; 
    border: 1px solid #000000;
    line-height: 4rem;
    width:10%;
    vertical-align: middle;
    text-align: center;
} 
table#QueryForm tbody tr td:last-child, table#WorkingHeader tbody tr td:last-child, table#MissingForm tbody tr td:last-child { 
    width:1%;
} 
input[type=text],input[type=number]{
    width:100%;
}
input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
</style>
<div id="wrapper">
    <div id="page-wrapper">
        <form method="POST" role="form" name="myForm" onsubmit="return saveMissing(2);" action="<?php echo BASE_URL;?>C_associate/Complete_Query/<?php echo $WID;?>">
            <div class="row"><!-- ROW -->
                <div class="col-lg-6">
                    <h2 class="page-header">Query ID # <?php echo $WID; ?> </h2>
                </div>
                <div class="col-lg-6">
                    <h4 class="page-header" align="right">
                        <!-- <input type="submit" name="submit"> -->
                        <input type="submit" name="submit"  value="COMPLETE" class="btn btn-success">
                        <button type="button" onclick="saveMissing(0);" class="btn btn-danger"><i class="fa fa-fw"></i>EXIT</button>
                    </h4>
                </div>
            </div>
            <div class="row"><!-- ROW -->
                <div class="col-xs-12">
                    <div class="panel-body">
                        <table class="table" id="WorkingFetch">
                            
                            <thead>
                                <tr class="panel panel-info">
                                    <th class="panel-heading">
                                        <b>Query ID</b>
                                    </th>
                                    <th class="panel-heading">
                                        <b>Facility</b>
                                    </th>
                                    <th class="panel-heading">
                                        <b>Category</b>
                                    </th>
                                    <th class="panel-heading">
                                        <b>Deposite ON</b>
                                    </th>
                                    <th class="panel-heading">
                                        <b>Amount in Question</b>
                                    </th>
                                    <th class="panel-heading">
                                        <b>Batch/Payer</b>
                                    </th>
                                    <th class="panel-heading">
                                        <b>Claim Paid Total $</b>
                                    </th>
                                    <th class="panel-heading">
                                        <b>Other Payment Total $</b>
                                    </th>
                                    <th class="panel-heading">
                                        <b>Non Cerner $</b>
                                    </th>
                                    <th class="panel-heading">
                                        <b>Batch Pending $</b>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="panel panel-info">
                                    <td class="panel-footer">
                                        <?php echo $work[0]["queryid"];?>
                                    </td>
                                    <td class="panel-footer">
                                        <?php echo $work[0]["ProjectName"];?>        
                                    </td>
                                    <td class="panel-footer">
                                        <?php echo $work[0]["Category"];?>       
                                    </td>
                                    <td class="panel-footer">
                                        <?php echo $work[0]["DepositDate"];?>
                                    </td>
                                    <td class="panel-footer">
                                        <?php echo "<p id='Amount'>".$work[0]["amtinq"]."</p>";?>  
                                        <?php 
                                        $Amount =  $work[0]["amtinq"];
                                        ?>
                                    </td>
                                    <td class="panel-footer">
                                        <?php 
                                        echo $work[0]["Payer"];
                                        ?>
                                    </td>
                                    <td class="panel-footer">
                                        <?php echo "<p id='total_sum_value'> </p>";?>          
                                    </td>
                                    <td class="panel-footer">
                                        <?php echo "<p id='total_sum_other'> </p>";?>   
                                    </td>
                                    <td class="panel-footer">
                                        <?php echo "<p id='total_non_cern'> </p>";?>     
                                    </td>
                                    <td class="panel-footer">
                                        <?php echo "<p id='total_sum_pend'> </p>";?>    
                                    </td>
                                </tr>
                            </tbody>
                            
                            
                        </table>
                    </div>
                    <div class="panel-body">
                        <div class="panel-group" id="accordion">
                            <div class="col-xs-12">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="collapsed" aria-expanded="false">Other Payment</a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            <table class="table" id="OtherPayment">
                                                <thead>
                                                    <tr class="panel panel-success">
                                                        <th class="panel-heading">
                                                            <B>Bad Debt</B>
                                                        </th>
                                                         <th class="panel-heading">
                                                             <B>Incentive / Bonus</B>
                                                        </th>
                                                        <th class="panel-heading">
                                                            <B>Interest</B>
                                                        </th>     
                                                        <th class="panel-heading">
                                                            <B>Non Cerner</B>
                                                        </th>   
                                                        <th class="panel-heading">
                                                            <B>Overpay Recover</B>
                                                        </th>
                                                        <th class="panel-heading">
                                                            <B>Forward Balance</B>
                                                        </th>
                                                        <th class="panel-heading">
                                                            <B>Hospital / Dental</B>
                                                        </th>
                                                        <th class="panel-heading">
                                                            <B>Capitation</B>
                                                        </th>
                                                        <th class="panel-heading">
                                                            <B>SPM</B>
                                                        </th> 
                                                        <th class="panel-heading">
                                                            <B>Duplicate / PMP</B>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="panel panel-success">
                                                        <td class="panel-footer">
                                                            <input type="number" step="0.01" class="txtOC" id="baddebt" name="baddebt" value=""/>
                                                        </td>
                                                         <td class="panel-footer">
                                                            <input type="number" step="0.01" class="txtOC" id="incentive" name="incentive" value=""/>
                                                        </td>
                                                        <td class="panel-footer">
                                                            <input type="number" step="0.01" class="txtOC" id="interest" name="interest" value=""/>
                                                        </td>
                                                        <td class="panel-footer">
                                                            <input type="number" step="0.01" class="txtNC" id="noncern" name="noncern" value=""/>
                                                        </td>
                                                        <td class="panel-footer">
                                                            <input type="number" step="0.01" class="txtOC" id="overpayrec" name="overpayrec" value=""/>
                                                        </td>
                                                        <td class="panel-footer">
                                                            <input type="number" step="0.01" class="txtOC" id="forbal" name="forbal" value=""/>
                                                        </td>
                                                        <td class="panel-footer">
                                                            <input type="number" step="0.01" class="txtOC" id="hospital" name="hospital" value=""/>
                                                        </td>
                                                        <td class="panel-footer">
                                                            <input type="number" step="0.01"  class="txtOC" id="capitation" name="capitation" value=""/>
                                                        </td>
                                                        <td class="panel-footer">
                                                            <input type="number" step="0.01"  class="txtOC" id="SPM" name="SPM" value=""/>
                                                        </td>
                                                        <td class="panel-footer">
                                                            <input type="number" step="0.01"  class="txtOC" id="pmonpos" name="pmonpos" value=""/>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>         
                                    </div>
                                </div>
                            </div>              
                        </div>
                    </div>
                </div>  
                <div class="row"><!-- ROW -->
                    <div class="col-xs-12">
                        <div class="panel-body">
                            <div class="col-xs-6">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <b>Notes</b>
                                    </div><!-- /.panel-heading -->
                                    <div class="panel-footer">
                                        <textarea class='form-control' value="" disabled="disabled"  style='width: 100%;height: 188px;' rows='6' cols='120' wrap='hard' maxlength='1000' style='resize:none;overflow:hidden;'><?php echo  $work[0]['comment']?> </textarea>
                                    <input type="hidden" class="form-control" id='comment' name='comment' value="<?php echo $work[0]['comment'];?>" hidden="hidden">
                                    </div>             
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <table class="table" id="WorkingHeader">
                                    <thead>
                                        <tr class="panel panel-danger">
                                            <th class="panel-heading">
                                                <b>CPM Batch Number*</b>
                                            </th>      
                                            <th class="panel-heading">
                                                <b>Claim Paid Amount*</b>
                                            </th>      
                                            <th class="panel-heading">
                                                <button id="addcpm" class="btn btn-warning">
                                                    <i class="fa fa-plus" title="ADD CPM"></i>
                                                </button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="panel panel-success">
                                            <td class="panel-footer">
                                                <input type="text" id="batchnum" name="batchnum[]"  onkeypress="return  event.charCode >= 48 && event.charCode <= 57" required aria-required="true" value=""/>
                                            </td>      
                                            <td class="panel-footer">
                                                <input type="number" step="0.01" class="txtCal"  id="cpa" name="cpa[]" required aria-required="true" value="" />
                                            </td>      
                                            <td class="panel-footer">
                                                <button id="deletecpm" class="btn btn-danger" disabled>
                                                    <i class="fa fa-trash" title="DELETE CPM"></i>
                                                </button>
                                            </td> 
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
</div>
    