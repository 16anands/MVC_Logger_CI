<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="<?php echo BASE_URL;?>C_teamlead" class="active">
                    <i class="fa fa-dashboard fa-fw"></i>Dashboard
                </a>
            </li>
            <li>
                <a href="<?php echo BASE_URL;?>C_teamlead/Production_Report" class="active">
                    <i class="fa fa-hourglass fa-fw"></i>Production Report 
                </a>
            </li>   
            <li>
                <a href="<?php echo BASE_URL;?>C_teamlead/Work_Queue/" class="active">
                    <i class="fa fa-star fa-fw"></i>Work Queue 
                </a>
            </li>
              <li>
                <a href="<?php echo BASE_URL;?>C_teamlead/Query_Log/" class="active">
                    <i class="fa fa-question-circle fa-fw"></i>Query Log 
                </a>
            </li>   
          <!--    <li>
                <a href="<?php echo BASE_URL;?>C_teamlead/Query_Pending" class="active">
                    <i class="fa fa-hand-o-up fa-fw"></i>My Queries 
                </a>
            </li>-->
             <li>
                <a href="<?php echo BASE_URL;?>C_teamlead/Missing_Pending" class="active">
                    <i class="fa fa-hand-grab-o fa-fw"></i>My EOB Research
                </a>
            </li>
          
            <li>
                <a href="<?php echo BASE_URL;?>C_teamlead/Missing_EOB_Pending/" class="active">
                    <i class="fa fa-exclamation-circle fa-fw"></i>EOB Research 
                </a>
            </li>
            <li>
                <a href="<?php echo BASE_URL;?>C_teamlead/Allot_Log/" class="active">
                    <i class="fa fa-random fa-fw"></i> Inventory 
                </a>
            </li>
            <li>
                <a href="<?php echo BASE_URL;?>C_teamlead/Report_Facility" class="active">
                    <i class="fa fa-gears fa-fw"></i>Management 
                </a>
            </li>
        </ul>
    </div>
</div>
</nav>