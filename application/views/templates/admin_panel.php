	<div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url('index.php/admin')?>">Admin Page</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?=$name?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
						
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo base_url('index.php/logout')?>"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="<?php echo base_url('index.php/admin')?>"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
					<!-- Event -->
					<li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#event"><i class="fa fa-calendar"></i> Manage Event <i class="fa fa-fw fa-arrows-v"></i></a>
                        <ul id="event" class="collapse in">
                            <li>
                                <a href="<?php echo base_url('index.php/event'); ?>"><i class="fa fa-fw fa-table"></i> Event </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('index.php/event_type'); ?>"><i class="fa fa-fw fa-table"></i> Type </a>
                            </li>
							<li>
                                <a href="<?php echo base_url('index.php/user_event'); ?>"><i class="fa fa-fw fa-table"></i> Attended </a>
                            </li>
                        </ul>
                    </li>
					<li>&nbsp;</li>
					<!-- User -->
					 <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#user"><i class="fa fa-users"></i> Manage User <i class="fa fa-fw fa-arrows-v"></i></a>
                        <ul id="user" class="collapse in">
                            <li>
                                <a href="<?php echo base_url('index.php/user'); ?>"><i class="fa fa-fw fa-table"></i> Details </a>
                            </li>
							<li>
                                <a href="<?php echo base_url('index.php/position'); ?>"><i class="fa fa-fw fa-table"></i> Position</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('index.php/department'); ?>"><i class="fa fa-fw fa-table"></i> Department</a>
                            </li>
							<li>
                                <a href="<?php echo base_url('index.php/level'); ?>"><i class="fa fa-fw fa-table"></i> Level</a>
                            </li>
                        </ul>
                    </li>
		
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?=$title ?>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i> <a href="<?php echo base_url('index.php/admin'); ?>">Dashboard</a>
                            </li>
							<li class="active">
                                <i class="fa fa-table"></i> <?=$title2 ?>
                            </li>
                        </ol>
                    </div>
                </div>
                           
                <!-- /.row -->
				<!--
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">12</div>
                                        <div>New Tasks!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
				</div>
				
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Area Chart</h3>
                            </div>
                            <div class="panel-body">
                                <div id="morris-area-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
				
				-->
				
            

   

    
