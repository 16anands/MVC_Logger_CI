<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
if ($this->session->flashdata('entry')){ 
?>
 <script type="text/javascript">
     $(document).ready( function () {
         $('#entryfailure').modal();
     });
 </script>
<?php } ?>
<div id="wrapper">
    <div id="page-wrapper">
        <div class="row"><!-- ROW -->
            <div class="col-lg-12">
                <h2 class="page-header">Facility List</h2>
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
                                        <th>TeamLead (Owner)</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for($i=0;$i<sizeof($Cl_Names);$i++) {?>
                                    <tr>
                                        <td><?php echo $Cl_Names[$i]['ProjectID'];?></td>
                                        <td><?php echo $Cl_Names[$i]['ProjectName'];?></td>
                                        <td><?php echo $Cl_Names[$i]['AssociateName'];?></td>
                                        <td>
                                            <?php
                                                if($Cl_Names[$i]['status'] == 1){
                                                    echo "Active";
                                                }else{
                                                    echo "In - Active";
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row"><!-- ROW -->
            <div class="col-lg-6">
                <h2 class="page-header">Leads List</h2>
            </div>
            <div class="col-lg-6">
                <h4 class="page-header" align="right">
                    <button class="btn btn-success" data-toggle="modal" data-target="#add_LeadModal" title="ADD ASSOCIATE">
                        <i class="fa fa-user-plus"></i>
                    </button>
                </h4>
            </div>
        </div><!-- ROW ENDS-->
        <div class="row">            
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="Leads_List">
                                <thead>
                                    <tr>
                                        <th>Associate ID</th>
                                        <th>Associate Name</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for($i=0;$i<sizeof($As_Names);$i++) {?>
                                    <tr>
                                        <td><?php echo $As_Names[$i]['AssociateID'];?></td>
                                        <td><?php echo $As_Names[$i]['AssociateName'];?></td>
                                        <td>
                                            <?php
                                                if($As_Names[$i]['Active'] == 1){
                                                    echo "In - Active";
                                                }else{
                                                    echo "Active";
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Addition Lead Modal -->
        <div class="modal fade" id="add_LeadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-horizontal" role="form" method="post" action="<?php echo BASE_URL;?>C_manager/addlead">
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
        <!--Addition Lead Modal Ends -->
    </div> <!-- Main Row -->
</div>
<!-- /#page-wrapper -->
