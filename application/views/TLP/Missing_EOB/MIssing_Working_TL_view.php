<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script type="text/javascript">
    function saveMissing(flag){
        var status = "<?php echo $status[0]?>";
        switch(flag){
            case 0:
                var r = confirm("Exit Without Saving ?");
                if(r == true){
                    window.location.href = "<?php echo BASE_URL;?>C_teamlead/"+status;
                }
                break;
            case 1:
                var r = confirm("Confirm Save ?");
                if (r == true){
                    return true
                }
                else{
                    return false;
                }
                break;  
        }          
    }
    $(document).ready(function(){   
        $('#action').change(function(){
            var note = document.getElementById("note").value;
            var val = $('#action').val();          
            // $("#comment").val(Final_Comment+"\n"+"metric : "+$(this).find('option:selected').text());
            $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL;?>C_teamlead/getMetrics",
                data:'metricId='+val,
                success: function(data){
                    var response = JSON.parse(data);
                    metricSelect ="";
                    for(var i=0;i<response['metrics'].length;i++){   
                        metricSelect+='<option value='+response['metrics'][i]['eta']+'>'+response['metrics'][i]['eta']+'</option>';
                    }
                    $("#metric").html(metricSelect);
                }
            });
            document.getElementById("note").value = note + "->" + $('#action option:selected').text();
        });
        $('#status').change(function(){
            var note = document.getElementById("note").value;
            var val = $('#status').val();          
            $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL;?>C_teamlead/getActions",
                data:'statusId='+val,
                success: function(data){
                    var response = JSON.parse(data);
                    actionSelect ="<option value=''>Select Action</option>";
                    for(var i=0;i<response['actions'].length;i++){   
                        actionSelect+='<option value='+response['actions'][i]['actionid']+'>'+response['actions'][i]['description']+'</option>';
                    }
                    //alert(actionSelect);
                    $("#action").html(actionSelect);
                }
            });
            document.getElementById("note").value = note + " " + $('#status option:selected').text();
        });
    });
</script>
<form method="POST" role="form" name="myForm" onsubmit="return saveMissing(1);" action="<?php echo BASE_URL;?>C_teamlead/saveMissing/<?php echo $status[0]?>">
 <div id="wrapper">
 <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="page-header">EOB Research Work Queue : #<?php echo $missingid[0];?>
                    </h2>
                </div>
                <div class="col-lg-6">
                    <h2 class="page-header" align="right">
                        <input type="submit" name="submit" value="SAVE" class="btn btn-success">
                        <button type="button" onclick="saveMissing(0);" class="btn btn-primary">EXIT</button>
                    </h2>
                    <!-- /.col-lg-12 -->
                </div>
            </div>
           
            <div class="row">
                <div class="col-lg-14">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                    	<div class="panel panel-info">
				                            <div class="panel-heading">
				                                <b>EOB ID</b>
				                            </div>
				                            <div class="panel-footer">
				                            	<input class="form-control" type="text" value="<?php echo $missingworkingdata[0]['missingid'];?>" disabled>
                                                <input type="hidden" class="form-control" id="missingid" name="missingid" value="<?php echo $missingworkingdata[0]['missingid'];?>" hidden="hidden">
				                            </div>
				                        </div>	
                                    </th>
                                    <th>
                                    	<div class="panel panel-info">
				                            <div class="panel-heading">
				                                <b>Facility</b>
				                            </div>
				                            <div class="panel-footer">
				                            	 <input class="form-control" id="disabledInput" type="text" value="<?php echo $missingworkingdata[0]['ProjectName'];?>" disabled>
				                            </div>
				                        </div>
                                    </th>
                                    <th>
                                    	<div class="panel panel-info">
				                            <div class="panel-heading">
				                                <b>Category</b>
				                            </div>
				                            <div class="panel-footer">
				                            	 <input class="form-control" id="disabledInput" type="text" value="<?php echo $missingworkingdata[0]['Category'];?>" disabled>
				                            </div>
				                        </div>
                                    </th>
                                    <th>
                                    	<div class="panel panel-info">
				                            <div class="panel-heading">
				                                <b>Deposite Date</b>
				                            </div>
				                            <div class="panel-footer">
				                            	 <input class="form-control" id="disabledInput" type="text" value="<?php echo $missingworkingdata[0]['DepositDate'];?>" disabled>
				                            </div>
				                        </div>
                                    </th>
                                    <th>
                                    	<div class="panel panel-info">
				                            <div class="panel-heading">
				                                <b>Amount $</b>
				                            </div>
				                            <div class="panel-footer">
				                            	 <input class="form-control" id="disabledInput" type="text" value="<?php echo $missingworkingdata[0]['Amount'];?>" disabled>
				                            </div>
				                        </div>
                                    </th>
                                    <th>
                                    	<div class="panel panel-info">
				                            <div class="panel-heading">
				                                <b>Batch/Payer</b>
				                            </div>
				                            <div class="panel-footer">
				                            	 <input class="form-control" id="disabledInput" type="text" value="<?php echo $missingworkingdata[0]['Payer'];?>" disabled>
				                            </div>
				                        </div>
                                    </th>
                                    <th>
                                    	<div class="panel panel-info">
				                            <div class="panel-heading">
				                                <b>Request Date</b>
				                            </div>
				                            <div class="panel-footer">
				                            	 <input class="form-control" id="disabledInput" type="text" value="<?php echo $missingworkingdata[0]['RequestedDate'];?>" disabled>
				                            </div>
				                        </div>
                                    </th>
                                </tr>
                            </thead>
                        </table>
						<table class="table">
                        <thead>
                            <tr>
                                <th>
                                	<div class="panel panel-info">
			                            <div class="panel-heading">
			                                <b>Encounter</b>
			                            </div>
			                            <div class="panel-footer">
			                            	 <input class="form-control" id="disabledInput" type="text" value="<?php echo $missingworkingdata[0]['Encounter'];?>" disabled>
			                                
			                            </div>
			                        </div>	
                                </th>
                                <th>
                                	<div class="panel panel-info">
			                            <div class="panel-heading">
			                                <b>CheckAmt</b>
			                            </div>
			                            <div class="panel-footer">
			                            	 <input class="form-control" id="disabledInput" type="text" value="<?php echo $missingworkingdata[0]['CheckAmt'];?>" disabled>
			                            </div>
			                        </div>
                                </th>
                                <th>
                                	<div class="panel panel-info">
			                            <div class="panel-heading">
			                                <b>CheckDate</b>
			                            </div>
			                            <div class="panel-footer">
			                            	 <input class="form-control" id="disabledInput" type="text" value="<?php echo $missingworkingdata[0]['CheckDate'];?>" disabled>
			                            </div>
			                        </div>
                                </th>
                                <th>
                                	<div class="panel panel-info">
			                            <div class="panel-heading">
			                                <b>CheckNo</b>
			                            </div>
			                            <div class="panel-footer">
			                            	 <input class="form-control" id="disabledInput" type="text" value="<?php echo $missingworkingdata[0]['CheckNo'];?>" disabled>
			                            </div>
			                        </div>
                                </th>
                                <th>
                                	<div class="panel panel-info">
			                            <div class="panel-heading">
			                                <b>Insurance</b>
			                            </div>
			                            <div class="panel-footer">
			                            	 <input class="form-control" id="disabledInput" type="text" value="<?php echo $missingworkingdata[0]['Website'];?>" disabled>
			                            </div>
			                        </div>
                                </th>
                                <th>
                                	<div class="panel panel-info">
			                            <div class="panel-heading">
			                                <b>Availibility</b>
			                            </div>
			                            <div class="panel-footer">
			                                <input class="form-control" id="disabledInput" type="text" value="<?php echo $missingworkingdata[0]['Availibility'];?>" disabled>
                                        </div>
			                        </div>
                                </th>
                                <th>
                                	<div class="panel panel-info">
			                            <div class="panel-heading">
			                                <b>CPDIPage</b>
			                            </div>
			                            <div class="panel-footer">
			                                <input class="form-control" id="disabledInput" type="text" value="<?php echo $missingworkingdata[0]['CPDIPage'];?>" disabled>
			                            </div>
			                        </div>
                                </th>
                                <th>
                                	<div class="panel panel-info">
			                            <div class="panel-heading">
			                                <b>Requested By</b>
			                            </div>
			                            <div class="panel-footer">
			                                <input class="form-control" id="disabledInput" type="text" value="<?php echo $missingworkingdata[0]['RequestedName'];?>" disabled>
			                            </div>
			                        </div>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div><!--Row  -->

                <div class="row">
                	<div class="col-lg-14">
                		<div class="col-lg-7">
	                        <div class="panel panel-info">
	                            <div class="panel-heading">Standard Comments</div><!-- /.panel-heading -->
	                            <div class="panel-footer">
	                            	<textarea class='form-control' value="" disabled="disabled"  style='width: 100%;height: 188px;' rows='6' cols='120' wrap='hard' maxlength='1000' style='resize:none;overflow:hidden;'><?php echo  $missingworkingdata[0]['Comment']?> </textarea>
                                    <input type="hidden" class="form-control" id='comment' name='comment' value="<?php echo $missingworkingdata[0]['Comment'];?>" hidden="hidden">

	                       		</div>
	                        </div>
                    	</div>
                    	<div class="col-lg-5">
                        	<div class="panel panel-danger">
                            	<div class="panel-heading">Notes*</div><!-- /.panel-heading -->
                            	<div class="panel-footer">
	                              	<!-- <input type="textarea"  class='form-control' required="required" id='note' name='note' style='width: 100%;height: 188px;' rows='6' cols='120' wrap='hard' maxlength='1000' style='resize:none;'/> -->
                                    <textarea class="form-control" rows="6" id='note' name='note' style='width: 100%;height: 188px;' maxlength='5000' required="required"></textarea>
	                            </div>             
                        	</div>
                    	</div>
                    </div>
               </div>
              <!-- Standard Comments and Row Ends-->

              <div class="row">
                    <div class="col-lg-14">
                    	<div class="table-responsive col-lg-12">
                                <div id="actionDiv">
                                    <table class="table" id="action_table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="panel panel-danger">
                                                        <div class="panel-heading">Status*</div><!-- /.panel-heading -->
                                                        <div class="panel-footer">
                                                            <?php       
                                                    echo "<select class='form-control' type='text' name='status' id='status' required='required'>";
                                                    echo "<option value=''></option>";
                                                        for($i=0;$i<sizeof($get_stat);$i++) 
                                                        {
                                                            echo "<option value=".$get_stat[$i]['statusid'].">".$get_stat[$i]['description']."</option>";
                                                        }?>
                                                            
                                                        </div>             
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="panel panel-danger">
                                                        <div class="panel-heading">Action*</div><!-- /.panel-heading -->
                                                        <div class="panel-footer">
                                                            <select class='form-control' name='action' id='action' required='required'>
                                                                
                                                            </select>
                                                        </div>             
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="panel panel-danger">
                                                        <div class="panel-heading">ETA*</div><!-- /.panel-heading -->
                                                        <div class="panel-footer">
                                                            <select type='text' class='form-control' name="metric" id="metric" required='required'>
                                                                
                                                        </select>
                                                        </div>             
                                                    </div>
                                                </th>
<!--
                                                <th>
                                                    <div class="panel panel-danger">
                                                        <div class="panel-heading">Select Associate to assign*</div> /.panel-heading 
                                                        <div class="panel-footer">
                                                            <select class="form-control" name="assign" id="assign" required aria-required="true">
                                                                <?php
                                                                if(isset($missingworkingdata[0]['AssignedName']))
                                                                {?>
                                                                    <option value="<?php echo $missingworkingdata[0]['AssignedID'];?>">
                                                                        <?php echo $missingworkingdata[0]['AssignedName'];?>
                                                                    </option>
                                                                <?php }
                                                                else
                                                                {?>
                                                                     <option value="">Select Associate</option>
                                                                <?php }
                                                                for($i=0;$i<count($Team_list);$i++) {
                                                                    if ($Team_list[$i]['AssociateID'] != $missingworkingdata[0]['AssignedID']) {?>
                                                                    <option value="<?php echo $Team_list[$i]['AssociateID'];?>">
                                                                        <?php echo $Team_list[$i]['AssociateName'];?>
                                                                    </option>
                                                                <?php } } ?> 
                                                            </select>
                                                        </div>             
                                                    </div>
                                                </th>
-->
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                           
                    	</div>
                    </div>
                </div>


        <!---Wrappper -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

</div>
</form>