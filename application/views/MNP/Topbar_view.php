<? php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $Login_data = $this->session->userdata('userdata');?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="RCM Workflow Tool">
        <meta name="author" content="RevWorksDev">
        <link rel="shortcut icon" href="<?php  echo BASE_URL;?>dist/img/favicon.png"/>
        <title>Cerner : RCM Services</title>
        <!-- Bootstrap Core CSS -->
        <link href="<?php echo BASE_URL;?>dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- MetisMenu CSS -->
        <link href="<?php echo BASE_URL;?>dist/css/metisMenu.min.css" rel="stylesheet">
        <!-- Timeline CSS -->
        <link href="<?php echo BASE_URL;?>dist/css/timeline.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="<?php echo BASE_URL;?>dist/css/startmin.css" rel="stylesheet">
        <!-- Morris Charts CSS -->
        <link href="<?php echo BASE_URL;?>dist/css/morris.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="<?php echo BASE_URL;?>dist/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!--- Custom CSS ---->
        <link href="<?php echo BASE_URL;?>dist/css/custom.css" rel="stylesheet" type="text/css">
        <!-- Multiselect -->
        <link rel="stylesheet" href="<?php echo BASE_URL;?>dist/css/bootstrap-multiselect.css" type="text/css">
        <!-- Date picker -->
        <link rel="stylesheet" href="<?php echo BASE_URL;?>dist/css/bootstrap-datetimepicker.css" type="text/css">
        <!-- Datatable -->
        <link rel="stylesheet" href="<?php echo BASE_URL;?>dist/css/dataTables/dataTables.bootstrap.css" type="text/css">
        <link rel="stylesheet" href="<?php echo BASE_URL;?>dist/css/dataTables/dataTables.responsive.css" type="text/css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- jQuery -->
        <script src="<?php echo BASE_URL;?>dist/js/jquery.min.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="<?php echo BASE_URL;?>dist/js/bootstrap.min.js"></script>
        <!-- Metis Menu Plugin JavaScript -->
        <script src="<?php echo BASE_URL;?>dist/js/metisMenu.min.js"></script>
        <!-- Morris Charts JavaScript -->
        <script src="<?php echo BASE_URL;?>dist/js/raphael.min.js"></script>
        <!-- <script src="<?php echo BASE_URL;?>dist/js/morris.min.js"></script> -->
        <!-- <script src="<?php echo BASE_URL;?>dist/js/morris-data.js"></script> -->
        <!-- Custom Theme JavaScript -->
        <script src="<?php echo BASE_URL;?>dist/js/startmin.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL;?>dist/js/datatables/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL;?>dist/js/datatables/datatable.pipeline.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL;?>dist/js/datatables/dataTables.fixedColumns.min.js"></script>
        <!-- Flot Charts JavaScript -->
        <script src="<?php echo BASE_URL;?>dist/js/flot/excanvas.min.js"></script>
        <script src="<?php echo BASE_URL;?>dist/js/flot/jquery.flot.js"></script>
        <script src="<?php echo BASE_URL;?>dist/js/flot/jquery.flot.pie.js"></script>
         <!--<script src="<?php echo BASE_URL;?>dist/js/flot/jquery.flot.resize.js"></script>
        <script src="<?php echo BASE_URL;?>dist/js/flot/jquery.flot.time.js"></script>-->
        <script src="<?php echo BASE_URL;?>dist/js/flot/jquery.flot.tooltip.min.js"></script> 
        <!-- <script src="<?php echo BASE_URL;?>dist/js/flot-data.js"></script> -->
        <script src="<?php echo BASE_URL;?>dist/js/amcharts.js"></script> 
        <script src="<?php echo BASE_URL;?>dist/js/pie.js"></script> 
        <script src="<?php echo BASE_URL;?>dist/js/light.js"></script> 
        <!-- Date Picker-->
        <script type="text/javascript" src="<?php echo BASE_URL;?>dist/js/bootstrap-moment-with-locales.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL;?>dist/js/bootstrap-datetimepicker.js"></script>
        <!-- Multiselect Bootstrap -->
        <script type="text/javascript" src="<?php echo BASE_URL;?>dist/js/bootstrap-multiselect.js"></script>
        <!-- Row merge-->
        <script src="<?php echo BASE_URL;?>dist/js/jquery.rowspanizer.min.js"></script>
        <!-- Datatbles -->
        <script src="<?php echo BASE_URL;?>dist/js/dataTables/dataTables.bootstrap.min.js"></script> 
        <style>
            img{
                padding-bottom: 20px;
            }
            .sidebar {
                width: 175px;
            }
            #page-wrapper {
                margin-left: 0px;
            }
        </style>
    </head>
    <body>
        <div id="wrapper">
            <div id="wrapper">   
                <!-- Navigation -->
                <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                    <ul class="nav navbar-nav navbar-left navbar-top-links">
                        <li>
                            <!--Access Based Home Page Logo-->
                            <?php
                                if($Login_data[0]->AccessLevel==6){
                                    echo "<a class='navbar-brand' href='".BASE_URL."C_manager'>";
                                }
                                if($Login_data[0]->AccessLevel==4){
                                    echo "<a class='navbar-brand' href='".BASE_URL."C_teamlead'>";
                                }
                                if($Login_data[0]->AccessLevel==3){
                                    echo "<a class='navbar-brand' href='".BASE_URL."C_delegate'>";
                                }
                                if($Login_data[0]->AccessLevel==2){
                                    echo "<a class='navbar-brand' href='".BASE_URL."C_associate'>";
                                }
                                echo "<img src='".BASE_URL."dist/img/logo.png' alt='Homepage' width='100' height='45'>";
                                echo "</a>";
                            ?>
                        </li>
                    </ul>
                    <div class="navbar-header">
                        <!--Access Based Home Page Link-->
                        <?php
                            if($Login_data[0]->AccessLevel==6){
                                echo "<a class='navbar-brand' href='".BASE_URL."C_manager'>";
                            }
                            if($Login_data[0]->AccessLevel==4){
                                echo "<a class='navbar-brand' href='".BASE_URL."C_teamlead'>";
                            }
                            if($Login_data[0]->AccessLevel==3){
                                echo "<a class='navbar-brand' href='".BASE_URL."C_delegate'>";
                            }
                            if($Login_data[0]->AccessLevel==2){
                                echo "<a class='navbar-brand' href='".BASE_URL."C_associate'>";
                            }
                            echo "RCM Services";
                            echo "</a>";
                        ?>
                    </div>  
                    <ul class="nav navbar-right navbar-top-links">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-user fa-fw"></i> 
                                <?php echo $Login_data[0]->AssociateName ;?> 
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                 <li>
                                  <a href="<?php echo BASE_URL;?>C_manager" class="active">
                                      <i class="fa fa-dashboard fa-fw"></i>Dashboard
                                  </a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL;?>C_manager/Report_Facility" class="active">
                                        <i class="fa fa-list fa-fw"></i>Lists
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="<?php echo BASE_URL;?>C_login/logout">
                                        <i class="fa fa-sign-out fa-fw"></i> 
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right navbar-top-links">
                        <li> 
                            <a href="#">
                                Rendered in <strong>{elapsed_time}</strong> Seconds Using <strong>{memory_usage}</strong>.
                            </a>
                        </li>
                    </ul>
                <!-- /.navbar-top-links -->
               