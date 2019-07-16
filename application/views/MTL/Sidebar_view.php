<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="<?php echo BASE_URL;?>C_mteamlead" class="active">
                    <i class="fa fa-dashboard fa-fw"></i>Dashboard
                </a>
            </li>
        <!--    <li>
                <a href="<?php echo BASE_URL;?>C_mteamlead/Production_Report" class="active">
                    <i class="fa fa-hourglass fa-fw"></i>Production Report 
                </a>
            </li>   -->
            <li>
                <a href="<?php echo BASE_URL;?>C_mteamlead/Work_Queue/" class="active">
                    <i class="fa fa-star fa-fw"></i>Work Queue 
                </a>
            </li>
            <li>
                <a href="<?php echo BASE_URL;?>C_mteamlead/Missing_EOB_Pending/" class="active">
                    <i class="fa fa-random fa-fw"></i> Inventory 
                </a>
            </li>
            <li>
                <a href="<?php echo BASE_URL;?>C_mteamlead/Report_Facility" class="active">
                    <i class="fa fa-gears fa-fw"></i>Management 
                </a>
            </li>
        </ul>
    </div>
</div>
</nav>