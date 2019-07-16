<? php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script type="text/javascript">

    function save(flag)
    {   
        switch(flag) 
        {
            case 0:
                    var r = confirm("Exit Without Saving ?");
                    if(r == true)
                    {
                        window.location.href = "<?php echo BASE_URL;?>C_teamlead/Query_Log/";
                    }
                    break;
            case 1:
                    var r = confirm("Confirm Save ?");
                    if (r == true)
                    {
                        return true
                    }
                    else{
                        return false;
                    }
                    break;
        }          
    }
</script>

<form method="POST" role="form" name="myForm" onsubmit="return save(1);" action="<?php echo BASE_URL;?>C_teamlead/Save_Query_Working">
<div id="wrapper">
<!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="page-header">Query ID : <?php echo $queryidworkingdata[0]['queryid'];?>
                    </h2>
                </div>
                <div class="col-lg-6">
                    <h2 class="page-header" align="right">
                        <input type="submit" name="submit" value="SAVE" class="btn btn-success">
                        <button type="button" onclick="save(0);" class="btn btn-primary">EXIT</button>
                    </h2>
                </div>
            </div>
             
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-14">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                    	<div class="panel panel-info">
    			                            <div class="panel-heading">
    			                                <b>Query ID</b>
    			                            </div>
    			                            <div class="panel-footer">
    			                            	<input class="form-control" type="text" value="<?php echo $queryidworkingdata[0]['queryid']?>" disabled>
                                                <input type="hidden" name="queryid" value="<?php echo $queryidworkingdata[0]['queryid']?>">
                                                
    			                            </div>
    			                        </div>	
                                    </th>
                                    <th>
                                    	<div class="panel panel-info">
    			                            <div class="panel-heading">
    			                                <b>Project Name</b>
    			                            </div>
    			                            <div class="panel-footer">
    			                            	 <input class="form-control" type="text" value="<?php echo $queryidworkingdata[0]['ProjectName']?>" disabled>
                                                 <input type="hidden" name="" value="<?php echo $queryidworkingdata[0]['ProjectName']?>">
    			                            </div>
    			                        </div>
                                    </th>
                                    <th>
                                    	<div class="panel panel-info">
    			                            <div class="panel-heading">
    			                                <b>Category</b>
    			                            </div>
    			                            <div class="panel-footer">
    			                            	 <input class="form-control" type="text" value="<?php echo $queryidworkingdata[0]['Category']?>" disabled>
                                                 <input type="hidden" name="" value="<?php echo $queryidworkingdata[0]['Category']?>">
    			                            </div>
    			                        </div>
                                    </th>
                                    <th>
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <b>Payer</b>
                                            </div>
                                            <div class="panel-footer">
                                                <input class="form-control" type="text" value="<?php echo $queryidworkingdata[0]['Payer']?>" disabled>
                                                <input type="hidden" name="" value="<?php echo $queryidworkingdata[0]['Payer']?>">
                                            </div>
                                        </div>  
                                    </th>
                                    <th>
                                    	<div class="panel panel-info">
    			                            <div class="panel-heading">
    			                                <b>Amount</b>
    			                            </div>
    			                            <div class="panel-footer">
    			                            	 <input class="form-control" type="text" value="<?php echo $queryidworkingdata[0]['Amount']?>" disabled>
                                                 <input type="hidden" name="" value="<?php echo $queryidworkingdata[0]['Amount']?>">
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
                                                 <input class="form-control" type="text" value="<?php echo $queryidworkingdata[0]['Encounter']?>" disabled>
                                                 <input type="hidden" name="" value="<?php echo $queryidworkingdata[0]['Encounter']?>">
                                            </div>
                                        </div>
                                    </th>
                                    <th>
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <b>Deposit Date</b>
                                            </div>
                                            <div class="panel-footer">
                                                 <input class="form-control" type="text" value="<?php echo $queryidworkingdata[0]['DepositDate']?>" disabled>
                                                 <input type="hidden" name="" value="<?php echo $queryidworkingdata[0]['DepositDate']?>">
                                            </div>
                                        </div>
                                    </th>
                                    <th>
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <b>Requested Date</b>
                                            </div>
                                            <div class="panel-footer">
                                                 <input class="form-control" type="text" value="<?php echo $queryidworkingdata[0]['RequestedDate']?>" disabled>
                                                 <input type="hidden" name="" value="<?php echo $queryidworkingdata[0]['RequestedDate']?>">
                                            </div>
                                        </div>
                                    </th>
                                    <th>
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <b>Requested By</b>
                                            </div>
                                            <div class="panel-footer">
                                                <input class="form-control" type="text" value="<?php echo $queryidworkingdata[0]['AssociateName']?>" disabled>
                                                <input type="hidden" name="" value="<?php echo $queryidworkingdata[0]['AssociateName']?>">
                                            </div>
                                        </div>  
                                    </th>
                                    
                                    <th>
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <b>Amount In Question</b>
                                            </div>
                                            <div class="panel-footer">
                                                <input class="form-control" type="text" value="<?php echo $queryidworkingdata[0]['amtinq']?>" disabled>
                                                <input type="hidden" name="" value="<?php echo $queryidworkingdata[0]['amtinq']?>">
                                            </div>
                                        </div>  
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-14">
                    <div class="col-lg-7">
                        <div class="panel panel-info">
                            <div class="panel-heading">Standard Comments</div><!-- /.panel-heading -->
                            <div class="panel-footer">
                                <textarea class='form-control' value="" disabled="disabled"  style='width: 100%;height: 188px;' rows='6' cols='120' wrap='hard' maxlength='1000' style='resize:none;overflow:hidden;'><?php echo   $queryidworkingdata[0]['comment']?> </textarea>
                                <input type="hidden" class="form-control" id='comment' name='comment' value="<?php echo $queryidworkingdata[0]['comment']?>" hidden="hidden">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="panel panel-danger">
                            <div class="panel-heading">Notes*</div><!-- /.panel-heading -->
                            <div class="panel-footer">
                                <!-- <input type="textarea"  class='form-control' required="required" id='note' name='note' style='width: 100%;height: 188px;' rows='6' cols='120' wrap='hard' maxlength='1000' style='resize:none;'/> -->
                                <textarea class="form-control" rows="6" style='width: 100%;height: 188px;' id='note' name='note'  maxlength='1000' required="required"></textarea>
                            </div>             
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- Standard Comments and Row Ends-->
             <div class="row">
                <div class="col-lg-14">
                    <div class="table-responsive col-lg-14">
                        <div id="actionDiv">
                            <table class="table" id="action_table">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="panel panel-danger">
                                                <div class="panel-heading">Status*</div>
                                                <div class="panel-footer">
                                                    <select class='form-control' type='text' name='status' id='status' required='required'>
                                                        <option value=''>Select Status</option>
                                                        <option value='18'>Pending</option>
                                                        <option value='33'>Resolved</option>
                                                    </select>       
                                                </div>             
                                            </div>
                                        </th>
                                        <th>
                                            <div class="panel panel-success">
                                                <div class="panel-heading">Redirect To</div>
                                                <div class="panel-footer">
                                                    <select class="form-control" name="assignedid">
                                                        <option value="">Select Associate</option>
                                                        <?php
                                                        for($i=0;$i<count($Team_list);$i++) {
                                                            if ($Team_list[$i]['AssociateID'] != $queryidworkingdata[0]['AssignedID']) {?>
                                                                <option value="<?php echo $Team_list[$i]['AssociateID'];?>"><?php echo $Team_list[$i]['AssociateName'];?></option>
                                                        <?php } } ?>
                                                    </select>
                                                </div>             
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>