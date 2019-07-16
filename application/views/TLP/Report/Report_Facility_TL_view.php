<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php if ($this->session->flashdata('entry')){ ?>
 <script type="text/javascript">
     $(document).ready( function () {
         $('#entryfailure').modal();
     });
 </script>
<?php } ?>
<?php if ($this->session->flashdata('success')){ ?>
 <script type="text/javascript">
     $(document).ready( function () {
         $('#activate').modal();
     });
 </script>
<?php } $pageid = "Allot_Assigned_Log"; ?>
<?php
$first_date_find = strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . ", first day of this month");
$first_date = date("Y-m-d",$first_date_find);
isset($_POST['mtdsdate']) ? $mtdsdate = $_POST['mtdsdate'] : $mtdsdate = $first_date;;
isset($_POST['mtdedate']) ? $mtdedate = $_POST['mtdedate'] : $mtdedate = date("Y-m-d");
?>
<script type="text/javascript">
    function fill_Details_facility(facilityid,facilityname,facilityowner)
    {
        document.getElementById('facility_id_0').value = facilityid;
        document.getElementById('facility_id_1').value= facilityid;
        document.getElementById('facility_name_0').value = facilityname;
        document.getElementById('team_lead_client_edit').value = facilityowner;
    }
    function fill_Details_associate(associateID,associateName,associateInitial,accesslevel,manager)
    {   
        var tempName = associateName.split(" ");
        document.getElementById('associate_id_edit').value = associateID;
        document.getElementById('associate_id_edit_0').value = associateID;
        document.getElementById('associate_fname_edit').value = tempName[0];
        document.getElementById('associate_sname_edit').value = tempName[1];
        document.getElementById('associate_initial_edit').value = associateInitial;
        document.getElementById('access_level_edit').value = accesslevel;
        document.getElementById('team_lead_associate_edit').value = manager;
    }
    function confirm_Delete(facilityid,facilityname)
    {
        var r = confirm("Delete "+facilityname+"..?");
        if(r == true)
        {
            window.location.href = "<?php echo BASE_URL;?>C_teamlead/deletefacility/"+facilityid;
        }
    }

    $(function () {
            $('#mtdsdate').datetimepicker({
                format: "YYYY-MM-DD"
            });
            $('#mtdedate').datetimepicker({
                format: "YYYY-MM-DD"
            });
            $('#mtdedate').datetimepicker({
                useCurrent: false //Important! See issue #1075
            });
            $("#mtdsdate").on("dp.change", function (e) {
                $('#mtdedate').data("DateTimePicker").minDate(e.date);
            });
            $("#mtdedate").on("dp.change", function (e) {
                $('#mtdsdate').data("DateTimePicker").maxDate(e.date);
            });
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
		//Resets the Modal after cancel 
		
		
		$('.modal').on('hidden.bs.modal', function () {
			$(this).find('input').val('');
		});
    
	});
	
</script>
<div id="wrapper">
    <div id="page-wrapper">
        <!-- /.col-lg-10 --> 
        <div class="row"><!-- ROW -->
            <div class="col-lg-6">
                <h2 class="page-header">Facility List </h2>
            </div>
            <div class="col-lg-6">
                <h4 class="page-header" align="right">
                    <button class="btn btn-success" data-toggle="modal" data-target="#add_ClientModal" title="ADD FACILITY">
                        <i class="fa fa-plus-square"></i>
                    </button>
                </h4>
            </div>
                <!-- Modal -->
            <div class="modal fade" id="entryfailure" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><i class="fa fa-fw" aria-hidden="true"></i> Failed </h4>
                        </div>
                        <div class="modal-body">
                            <p>Duplicate Entry !!!</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- ROW ENDS-->
        <div class="row">            
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="Facility_List">
                                <thead>
                                    <tr>
                                        <th>Facility ID</th>
                                        <th>Facility Name</th>
                                        <th>Edit/Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(!$Cl_Names==''){
                                        for($i=0;$i<count($Cl_Names);$i++) {
                                            echo "<tr>";
                                            echo "<td>".$Cl_Names[$i]['ProjectID']."</td>";
                                            echo "<td>".$Cl_Names[$i]['ProjectName']."</td>";
                                            echo "<td>";
                                        ?>
                                        <a class="btn btn-info btn-xs" data-toggle="modal" data-target="#edit_ClientModal" onclick="fill_Details_facility('<?php echo $Cl_Names[$i]['ProjectID'];?>','<?php echo $Cl_Names[$i]['ProjectName']; ?>','<?php echo $Cl_Names[$i]['Owner']; ?>');"><i class="fa fa-edit fa-fw" title="EDIT"></i></a>
                                        <a class="btn btn-danger btn-xs"  onclick="confirm_Delete('<?php echo $Cl_Names[$i]['ProjectID'];?>','<?php echo $Cl_Names[$i]['ProjectName']; ?>');"><i class="fa fa-trash fa-fw" title="DELETE"></i></a>
                                        <?php
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Addition Facility Modal -->
        <div class="modal fade" id="add_ClientModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-horizontal" id="add_ClientForm" role="form" method="post" action="<?php echo BASE_URL;?>C_teamlead/addfacility">
                        <div class="modal-header">
                            <button type="button" id="modalClose2" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Add Facility Mnemonic</h4>
                        </div>
                        
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4 field-label-responsive">
                                    <label for="name">Facility Mnemonic*</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                            <input type="text" 
												maxlength="8" 
												pattern="[A-Z_]{0,8}" 
												title="Capital Alphabets & Underscores Only"
												name="facility_name_add" 
												class="form-control" 
												id="facility_name_add" 
												placeholder="Facility Mnemonic"
												required autofocus>
                                        </div>
                                    </div>
                                </div>
                              
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="modalClose1" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" >Save </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--Addition Facility Modal Ends -->
        <!--Edit Facility Modal -->
        <div class="modal fade" id="edit_ClientModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-horizontal" role="form" method="post" action="<?php echo BASE_URL;?>C_teamlead/updatefacility">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Edit Facility Mnemonic</h4>
                        </div>
                        
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4 field-label-responsive">
                                    <label for="name">Facility ID</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                            <input type="text"  disabled name="facility_id_0" class="form-control" id="facility_id_0"/>
                                            <input type="hidden"  name="facility_id_1" id="facility_id_1"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 field-label-responsive">
                                    <label for="name">Facility Mnemonic*</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                            <input type="text"
											maxlength="8" 
											pattern="[A-Z_]{0,8}" 
											title="Capital Alphabets & Underscores Only"
											name="facility_name_0" 
											class="form-control" 
											id="facility_name_0" 
											placeholder="Facility Mnemonic" 
											required autofocus>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-md-4 field-label-responsive">
                                    <label for="name">Team Lead</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="input-group mb-3 mr-sm-3 mb-sm-2">
                                            <select type="text" class="form-control" name="team_lead_client_edit" id="team_lead_client_edit">
                                                <?php
                                                for($i=0;$i<count($TeamLead_List);$i++)
                                                {?>
                                                    <option value="<?php echo $TeamLead_List[$i]['AssociateID'];?>">
                                                        <?php echo $TeamLead_List[$i]['AssociateName'];?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" >Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--Edit Facility Modal Ends -->
        <div class="row"><!-- ROW -->
            <div class="col-lg-6">
                <h2 class="page-header">Associate List </h2>
            </div>
            <div class="col-lg-6">
                <h4 class="page-header" align="right">
                    <button class="btn btn-success" data-toggle="modal" data-target="#add_AssociateModal" title="ADD ASSOCIATE">
                        <i class="fa fa-user-plus"></i>
                    </button>
                </h4>
            </div>
        </div><!-- ROW ENDS-->
        <!-- Modal -->
        <div class="modal fade" id="activate" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-fw" aria-hidden="true"></i> Success </h4>
                    </div>
                    <div class="modal-body">
                        <p>Status Changed Successfully !!!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">            
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="Associate_List">
                                <thead>
                                    <tr>
                                        <th>Associate ID</th>
                                        <th>Associate Name</th>
                                        <th>Associate Initial</th>
                                        <th>Access Level</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for($i=0;$i<sizeof($Associate_List);$i++) {
                                        echo "<tr>";
                                        echo "<td>".$Associate_List[$i]['AssociateID']."</td>";
                                        echo "<td>".$Associate_List[$i]['AssociateName']."</td>";
                                        echo "<td>".$Associate_List[$i]['AssociateInitial']."</td>";
                                        if($Associate_List[$i]['AccessLevel'] == 3){
                                            echo "<td>Delegate</td>";
                                        }elseif ($Associate_List[$i]['AccessLevel'] == 2) {
                                            echo "<td>Non - Delegate</td>";
                                        }else {
                                            echo "<td>Yo - Delegate</td>";
                                        }
                                        $status = $Associate_List[$i]['Active'] == 0 ? 'Active' : 'In - Active';
                                        echo "<td>";
                                        $status = $Associate_List[$i]['Active'] == 0 ? 'Active' : 'In - Active';
                                    ?>
                                    <a href="<?php echo BASE_URL;?>C_teamlead/updateAssociateStatus/<?php echo $Associate_List[$i]['AssociateID'];?>/<?php echo $Associate_List[$i]['Active'];?>">
                                    <?php echo $status; ?> </a>
                                    <?php
                                        echo "</td>";
                                        echo "<td>";
                                    ?>
                                    <a class="btn btn-info btn-xs" data-toggle="modal" data-target="#edit_AssociateModal" id="myBtn"       onclick="fill_Details_associate('<?php echo $Associate_List[$i]['AssociateID'];?>','<?php echo $Associate_List[$i]['AssociateName'];?>','<?php echo $Associate_List[$i]['AssociateInitial'];?>','<?php echo $Associate_List[$i]['AccessLevel'];?>','<?php echo $Associate_List[$i]['ManagerID'];?>');"><i class="fa fa-edit fa-fw" title="EDIT"></i></a>
                                    <?php
                                        echo "</td>";
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
<!--Addition Associate Modal -->
        <div class="modal fade" id="add_AssociateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-horizontal" role="form" method="post" action="<?php echo BASE_URL;?>C_teamlead/addAssociate">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Add Associate</h4>
                        </div>
                        
                        <div class="modal-body">
                            <div class="row">
                                
                                <div class="col-md-4 field-label-responsive">
                                    <label for="name">Associate ID*</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                            <input type="text"  
											maxlength="8" 
											pattern="[A-Z]{2}\d{6}" 
											name="associate_id_add" 
											class="form-control" 
											id="associate_id_add" 
											placeholder="Ex: AB123456" 
											title="Must Contain First TWO Capital Letters followed by SIX Numerics" 
											required autofocus>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-4 field-label-responsive">
                                    <label for="name">First Name*</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                            <input type="text" maxlength="25" pattern="[a-zA-z ]{0,25}" 
												class="form-control" 
												name = "associate_fname_add"
												id="associate_fname_add" 
												placeholder="Associate First Name" 
												title="Must Contain Only Alpbhabets"
												required autofocus>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 field-label-responsive">
                                    <label for="name">Last Name*</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                            <input type="text"
											maxlength="25" 
											pattern="[a-zA-z ]{0,25}" 
											title="Must Contain Only Alpbhabets"
											name="associate_sname_add" 
											class="form-control" 
											id="associate_sname_add" 
											placeholder="Associate Second Name" 
											required autofocus>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 field-label-responsive">
                                    <label for="name">Associate Initial</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                            <input type="text" 
											maxlength="2" 
											pattern="[A-Z]{2}"
											title="Must contain only two capital Alpbhabet letters"
											name="associate_initial_add" 
											class="form-control" 
											id="associate_initial_add" 
											placeholder="Ex: AB" 
											required autofocus>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 field-label-responsive">
                                    <label for="name">Access Level</label>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select class="form-control" name="access_level_add" >
                                           <option value="2">Non - Delegate</option>
                                           <option value="3">Delegate</option>
                                        </select>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"> Cancel </button>
                            <button type="submit" class="btn btn-primary"> Save </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--Addition Facility Modal Ends -->
        <!--Editing Associate Modal -->
        <div class="modal fade" id="edit_AssociateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-horizontal" role="form" method="post" action="<?php echo BASE_URL;?>C_teamlead/editAssociate">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Edit Associate</h4>
                        </div>
                        
                        <div class="modal-body">
                            <div class="row">
                                
                                <div class="col-md-4 field-label-responsive">
                                    <label for="name">Associate ID</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                            <input type="text" name="associate_id_edit" disabled="disabled" class="form-control" id="associate_id_edit" placeholder="Associate ID" required autofocus>
                                            <input type="text" name="associate_id_edit_0" id="associate_id_edit_0" hidden="hidden">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-4 field-label-responsive">
                                    <label for="name">First Name*</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                            <input type="text"
											maxlength="25" 
											pattern="[a-zA-z ]{3,25}" 
											title="Must Contain Only Alpbhabet letters"
											name="associate_fname_edit" 
											class="form-control" 
											id="associate_fname_edit" 
											placeholder="Associate First Name" 
											required autofocus>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 field-label-responsive">
                                    <label for="name">Last Name*</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                            <input type="text" 
											maxlength="25" 
											pattern="[a-zA-z ]{1,25}" 
											title="Must Contain Only Alpbhabet letters"
											name="associate_sname_edit" 
											class="form-control" 
											id="associate_sname_edit" 
											placeholder="Associate Second Name" 
											required autofocus>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 field-label-responsive">
                                    <label for="name">Associate Initial*</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                            <input type="text" 
											maxlength="2" 
											pattern="[A-Z]{2}" 
											title="Must contain only two capital Alpbhabet letters"
											name="associate_initial_edit" 
											class="form-control" 
											id="associate_initial_edit" 
											placeholder="Ex: AB"
											required autofocus>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 field-label-responsive">
                                    <label for="name">Access Level</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                         <div class="input-group mb-3 mr-sm-3 mb-sm-1">
                                        <select type="text" class="form-control" name="access_level_edit" id="access_level_edit">
                                           <option value="2">Non - Delegate</option>
                                           <option value="3">Delegate</option>
                                        </select>
                                    </div>
                                    </div>
                                </div>

                                <div class="col-md-4 field-label-responsive">
                                    <label for="name">Team Lead</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                         <div class="input-group mb-3 mr-sm-3 mb-sm-2">
                                        <select type="text" class="form-control" name="team_lead_associate_edit" id="team_lead_associate_edit">
                                            <?php
                                            for($i=0;$i<count($TeamLead_List);$i++)
                                            {?>
                                                <option value="<?php echo $TeamLead_List[$i]['AssociateID'];?>">
                                                    <?php echo $TeamLead_List[$i]['AssociateName'];?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    </div>
                                </div> 

                            
                            </div><!--Row ends -->
                        </div><!--Modal Body ends -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"> Cancel </button>
                            <button type="submit" class="btn btn-primary"> Save </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--Editing Associate Modal Ends -->
        
        
       
        
    </div> <!-- Main Row -->
</div>
<!-- /#page-wrapper -->
