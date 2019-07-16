<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="<?php echo BASE_URL;?>C_delegate" class="active">
                    <i class="fa fa-dashboard fa-fw"></i>Dashboard
                </a>
            </li>
            <li>
                <a href="<?php echo BASE_URL;?>C_delegate/production_summary_dl" class="active">
                    <i class="fa fa-hourglass fa-fw"></i>Production Report 
                </a>
            </li>
            <li>
                <a href="<?php echo BASE_URL;?>C_delegate/Work_Queue" class="active">
                    <i class="fa fa-star fa-fw"></i>Work Queue 
                </a>
            </li>
            <li>
                <a href="<?php echo BASE_URL;?>C_delegate/Query_Pending" class="active">
                    <i class="fa fa-hand-o-up fa-fw"></i>My Queries 
                </a>
            </li>
              <li>
                <a href="<?php echo BASE_URL;?>C_delegate/Query_Log" class="active">
                    <i class="fa fa-question-circle fa-fw"></i>Queries Log 
                </a>
            </li>
            <li>
                <a href="<?php echo BASE_URL;?>C_delegate/Missing_Pending" class="active">
                    <i class="fa fa-hand-grab-o fa-fw"></i>My EOB Research
                </a>
            </li>
          
            <li>
                <a href="<?php echo BASE_URL;?>C_delegate/Missing_EOB_Pending" class="active">
                    <i class="fa fa-exclamation-circle fa-fw"></i>EOB Research
                </a>
            </li>
            <li>
                <a href="<?php echo BASE_URL;?>C_delegate/Allot_Log" class="active">
                    <i class="fa fa-random fa-fw"></i> Inventory 
                </a>
            </li>
        </ul>
    </div>
</div>
</nav>