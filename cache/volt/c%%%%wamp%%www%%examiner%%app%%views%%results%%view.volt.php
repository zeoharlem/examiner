<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <?php echo $this->tag->getTitle(); ?>
        <meta charset="utf-8">
        <title>School Portal</title>
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        
        <?php echo $this->assets->outputCss('headers'); ?>
        

        <link href="favicon.ico" rel="shortcut icon">
    </head>
    <body>
    <!-- BEGIN HEADER -->
    <section id="container">
    <!--header start-->
    <header class="header fixed-top clearfix">
    <!--logo start-->
    <div class="brand">

        <a href="<?php echo $this->url->get('dashboard/?type='); ?>" class="logo">
            <img src="<?php echo $this->url->get('assets/images/logo.png'); ?>" alt="">
        </a>
        <div class="sidebar-toggle-box">
            <div class="fa fa-bars"></div>
        </div>
    </div>
    <!--logo end-->

    <div class="nav notify-row" id="top_menu">
        <!--  notification start -->
        <ul class="nav top-menu">
            <!-- settings start -->
            <li class="dropdown" title="Send a mail to lecturer">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <i class="fa fa-envelope fa-2x"></i>
                </a>

            </li>
            <!-- settings end -->
            <!-- inbox dropdown start-->
            <li id="header_inbox_bar" class="dropdown" title="Carry Over Registration">
                <a href="">
                    <i class="fa fa-plus fa-2x"></i>
                </a>

            </li>
            <!-- inbox dropdown end -->
            <!-- notification dropdown start-->
            <li id="header_notification_bar" class="dropdown" title="Course Registration">
                <a href="">

                    <i class="fa fa-user-plus fa-2x"></i>
                </a>

            </li>
            

            <li class="dropdown" title="CGPA calculation">
                <a class="dropdown-toggle" href="">

                    <i class="fa fa-line-chart fa-2x"></i>
                </a>

            </li>

            <li class="dropdown" title="Phone contacts">
                <a class="dropdown-toggle" href="">

                    <i class="fa fa-phone fa-2x"></i>
                </a>

            </li>

            <li class="dropdown" title="Course Packages">
                <a class="dropdown-toggle" href="">

                    <i class="fa fa-hdd-o fa-2x"></i>
                </a>

            </li>
            <!-- notification dropdown start-->
            <!--
            <li id="header_notification_bar" class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                    <i class="fa fa-bell-o fa-2x"></i>
                    <span class="badge bg-success">3</span>
                </a>
                <ul class="dropdown-menu extended notification">
                    <li>
                        <p>Notifications</p>
                    </li>
                    <li>
                        <div class="alert alert-info clearfix">
                            <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                            <div class="noti-info">
                                <a href="#"> Server #1 overloaded.</a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="alert alert-danger clearfix">
                            <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                            <div class="noti-info">
                                <a href="#"> Server #2 overloaded.</a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="alert alert-success clearfix">
                            <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                            <div class="noti-info">
                                <a href="#"> Server #3 overloaded.</a>
                            </div>
                        </div>
                    </li>

                </ul>
            </li>-->
            <!-- notification dropdown end -->
            <!-- notification dropdown end -->
        </ul>
    </div>
    <div class="top-nav clearfix">
        <!--search & user info start-->
        <ul class="nav pull-right top-menu">
            <li>
                <input type="text" class="form-control search" placeholder=" Search">
            </li>
            <!-- user login dropdown start-->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <img alt="" src="<?php echo $this->url->get('/assets/images/avatar1_small.jpg'); ?>">
                    <span class="username"><?php echo $this->session->get('auth')['username']; ?></span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <li><a href=""><i class=" fa fa-suitcase"></i>Profile</a></li>
                    <li><a href=""><i class="fa fa-cog"></i> Settings</a></li>
                    <li><a href="<?php echo $this->url->get('index/logOut'); ?>"><i class="fa fa-key"></i> Sign Out</a></li>
                </ul>
            </li>
            <!-- user login dropdown end -->

        </ul>
        <!--search & user info end-->
    </div>
    </header>
    <!--header end-->

    <!--sidebar start-->
    <aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="active" href="<?php echo $this->url->get('dashboard/'); ?>">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-edit"></i>
                        <span>Courses</span>
                    </a>
                    <ul class="sub">
                        <li class="active"><a href="<?php echo $this->url->get('course/'); ?>">Create Courses</a></li>
                        <li class="active"><a href="<?php echo $this->url->get('course/multipleTable'); ?>">Course Multiple Table</a></li>
                        <li><a href="<?php echo $this->url->get('course/show'); ?>">Edit/Delete Courses</a></li>
                        <li><a href="<?php echo $this->url->get('course/department'); ?>">Create Department</a></li>
                    </ul>
                </li>
                
                
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-hdd-o"></i>
                        <span>Session Packages</span>
                    </a>
                    <ul class="sub">
                        <li class="active"><a href="<?php echo $this->url->get('packages/'); ?>">Create Packages</a></li>
                        <li><a href="<?php echo $this->url->get('packages/show'); ?>">Edit/Delete Packages</a></li>
                    </ul>
                </li>
                
                
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-user-plus"></i>
                        <span>Course Registration</span>
                    </a>
                    <ul class="sub">
                        <li><a href="<?php echo $this->url->get('students'); ?>">View Students</a></li>
                        <li class="active"><a href="<?php echo $this->url->get('courseregistration/download'); ?>">Download Registered Courses</a></li>
                        <li class="active"><a href="<?php echo $this->url->get('carryover/download'); ?>">Download CarryOver Courses</a></li>
                        <li><a href="<?php echo $this->url->get('carryover/'); ?>">Carry Over</a></li>

                    </ul>
                </li>
                
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-group"></i>
                        <span>Congregation</span>
                    </a>
                    <ul class="sub">
                        <li><a href="<?php echo $this->url->get('carryover/'); ?>">View Congregations</a></li>
                        <li><a href="<?php echo $this->url->get('congregation/add'); ?>">Add Congregation</a></li>
                        <li class="active"><a href="<?php echo $this->url->get('congregation/results'); ?>"><strong>Congregation Results</strong></a></li>

                    </ul>
                </li>
                
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-th-large"></i>
                        <span>Results</span>
                    </a>
                    <ul class="sub">
                        <li class="active"><a href="<?php echo $this->url->get('results'); ?>">Upload Results</a></li>
                        <li class="active"><a href="<?php echo $this->url->get('results/viewForm'); ?>">Check Results</a></li>
                        <li><a href="<?php echo $this->url->get('carryover/'); ?>">Upload Carry Over(s)</a></li>
                    </ul>
                </li>
                
                
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-briefcase"></i>
                        <span>Lecturer</span>
                    </a>
                    <ul class="sub">
                        <li class="active"><a href="<?php echo $this->url->get('lecturer/'); ?>">Create Lecturer</a></li>
                        <li class="active"><a href="<?php echo $this->url->get('lecturer/display'); ?>">View Lecturers</a></li>
                        <li class="active"><a href="<?php echo $this->url->get('lecturer/assign'); ?>">Assign Courses</a></li>
                    </ul>
                </li>
                
                
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-keyboard-o"></i>
                        <span>Department | Faculty | Progs</span>
                    </a>
                    <ul class="sub">
                        <li class="active"><a href="<?php echo $this->url->get('course/faculty'); ?>">Faculty</a></li>
                        <li class="active"><a href="<?php echo $this->url->get('course/department'); ?>">Department</a></li>
                        <li class="active"><a href="<?php echo $this->url->get('course/programs'); ?>">Programs</a></li>
                    </ul>
                </li>
                
                
                <li>
                    <a href="<?php echo $this->url->get('matrics/'); ?>">
                        <i class="fa fa-magnet"></i>
                        <span>Upload Matric Numbers</span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo $this->url->get('collectivegrade/'); ?>">
                        <i class="fa fa-plus"></i>
                        <span style="font-weight:bolder">Generate Broad-Sheet</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $this->url->get('summaryof/'); ?>">
                        <i class="fa fa-folder"></i>
                        <span style="font-weight:bolder">Summary Of Summary</span>
                    </a>
                </li>
                <!--<li>
                    <a href="<?php echo $this->url->get(''); ?>">
                        <i class="fa fa-magnet"></i>
                        <span>CGPA Calculations</span>
                    </a>
                </li>-->
                
                <li>
                    <a href="<?php echo $this->url->get('index/logOut'); ?>">
                        <i class="fa fa-power-off"></i>
                        <span>Sign Out</span>
                    </a>
                </li>
            </ul>            </div>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
    <!-- page start-->

    <div class="row">
    <div class="col-sm-12"><?php echo $this->flash->output(); ?></div>
    
    <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Result View | <strong><?= ucwords($studentFlow->surname) ?> <?= ucwords($studentFlow->othernames) ?></strong>
                            <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-cog"></a>
                                <a href="javascript:;" class="fa fa-times"></a>
                             </span>
                        </header>
                        <div class="panel-body">
                        <p>&nbsp;</p>
                        <p><a href="<?= $this->url->get('results/createSinglePersonExcelSheet?level=' . $this->request->getQuery('level') . '&matric=' . $this->request->getQuery('matric') . '&session=' . $this->request->getQuery('session')) ?>" class="btn btn-primary" target="_blank">Transcripts / Excel</a>
                        &nbsp;&nbsp;&nbsp;&nbsp;REMARKS <strong>|</strong>  <small><?= Phalcon\Text::upper($remarks) ?></small>
                        </p>
                        <div class="pull-right"><a href="<?= $this->url->get('results/view?' . $urlTask . '&semester=1') ?>"><i class="fa fa-map-marker"></i> Harmattan</a> | <a href="<?= $this->url->get('results/view?' . $urlTask . '&semester=2') ?>"><i class="fa fa-plus"></i> Rain</a></div>
                        <p>&nbsp;</p>
                        <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Course Description</th>
                                    <th>Code</th>
                                    <th>Matric</th>
                                    <th>Level</th>
                                    <th>Session</th>
                                    <th class="text-center">Units</th>
                                    <th class="text-center">Points</th>
                                    <th class="text-center">C.A</th>
                                    <th class="text-center">Exam</th>
                                    <th class="text-center">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($stackFlow as $keys => $values) { ?>
                                <tr>
                                    <td><?= ucwords($values['title']) ?></td>
                                    <td><?= Phalcon\Text::upper($values['code']) ?></td>
                                    <td><?= $values['matric'] ?></td>
                                    <td><?= $values['level'] ?></td>
                                    <td><?= $values['session'] ?></td>
                                    <td class="text-center"><?= $values['units'] ?></td>
                                    <td class="text-center"><?= $values['grade'] ?></td>
                                    <td class="text-center"><?= $values['ca'] ?></td>
                                    <td class="text-center"><?= $values['score'] ?></td>
                                    <td class="text-center"><?= $values['ca'] + $values['score'] ?></td>
                                </tr>
                                <?php } ?>
                                <?php if (isset($stackFlowCO)) { ?>
                                <tr>
                                    <td class="text-right"><strong class=" label label-warning label-mini">CARRY OVER</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                </tr>
                                <?php foreach ($stackFlowCO as $keys => $values) { ?>
                                <tr>
                                    <td><?= ucwords($values['title']) ?></td>
                                    <td><?= Phalcon\Text::upper($values['code']) ?></td>
                                    <td><?= $values['matric'] ?></td>
                                    <td><?= $values['level'] ?></td>
                                    <td><?= $values['session'] ?></td>
                                    <td class="text-center"><?= $values['units'] ?></td>
                                    <td class="text-center"><?= $values['grade'] ?></td>
                                    <td class="text-center"><?= $values['caCO'] ?></td>
                                    <td class="text-center"><?= $values['scoreCO'] ?></td>
                                    <td class="text-center"><?= $values['caCO'] + $values['scoreCO'] ?></td>
                                </tr>
                                <?php } ?>
                                <?php } ?>
                                <tr>
                                    <td class="text-right"><strong>TOTAL</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"><?= $totalGrade ?></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                </tr>
                                <tr>
                                    <td class="text-right"><strong class=" label label-success label-mini">TOTAL UNITS</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center"><?= $totalUnits ?></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                </tr>
                                <tr>
                                    <td class="text-right"><strong class=" label label-warning label-mini">TOTAL UNITS PASSED</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center"><?= $totalUnitP ?></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                </tr>
                                <tr>
                                    <td class="text-right"><strong class=" label label-danger label-mini">TOTAL UNITS FAILED</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center"><?= $totalUnitF ?></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                </tr>
                                <tr>
                                    <td class="text-right"><strong class="label label-info label-mini">TOTAL GRADE POINTS</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"><?= $totalGrade ?></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                </tr>
                                <tr>
                                    <td class="text-right"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                </tr>
                                <tr>
                                    <td class="text-right"><strong class="label label-warning label-mini">TOTAL WEIGHTED AVERAGE POINT</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"><strong><?= $weightedAvr ?></strong></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>

    </div>
    <!-- page end-->
    </section>
</section>
<!--main content end-->
</section>
<?php echo $this->assets->outputJs('footers'); ?>
    </body>
</html>