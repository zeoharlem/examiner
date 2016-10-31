<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        
        <meta charset="utf-8">
        <title>School Portal</title>
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        
        <?= $this->assets->outputCss('prints') ?>
        

        <link href="favicon.ico" rel="shortcut icon">
<style type="text/css">
            @media print{
                .table{
                    border-collapse: collapse !important;
                }
                .noprint{
                    display: none !important;
                }
                
                @page {
                    size: landscape;
                }
                
                td{
                    white-space: nowrap;
                    border: 1px solid #aaa;
                    font-size:10px !important;
                }
                
                th.rotates{
                    height: 190px;
                    white-space: nowrap;
                }

                th.rotates > div{
                    transform: translate(25px, 51px)rotate(-90deg);
                    width:10px !important;
                    
                }

                th.rotates > div > span{
    /*                border: 1px solid #ccc;*/
                }
            }
            .table{
                border-collapse: collapse !important;
            }
            td{
                white-space: nowrap;
                border-collapse: collapse !important;
            }
            th{
                background-color: none !important;
            }
            th.rotates{
                height: 190px;
                white-space: nowrap;
            }
            
            th.rotates > div{
                transform: translate(25px, 51px)rotate(-90deg);
                width:10px !important;
            }
            
            th.rotates > div > span{
/*                border: 1px solid #ccc;*/
            }
            body, html{
                background: white !important;
                font-size:10px !important;
            }
            .text-center{
                /*border:1px solid #333 !important;*/
            }
        </style>
</head>
<body>
<section id="main-content">
    <section class="wrapper">
    <!-- page start-->

    <div class="row">
        <div class="col-md-12">

<div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <strong>Students List</strong>
                        
                    </header>
                    <div class="panel-body">
                    <div class="adv-table">
                    <?php if (isset($registered)) { ?>
                        <table id="dynamic" class="display table table-bordered table-striped dataTable" style="display:none;">
                            <thead>
                                <th>S/N</th>
                                <th>Matric No(s)</th>
                                <th>Name Of Candidate(s)</th>
                                <th>Sex</th>
                                <th>CGPA</th>
                                <th>CTUNP</th>
                                <th>Remark(s)</th>
                            </thead>
                            
                            <?php foreach ($viewStack['totalPackage'] as $keys => $values) { ?>
                            <?php $total = $summaryOf->__setViewFlow($values['matric'], $toLevel); ?>
                            
                            <?php
                                $remarks = $gradePointer->__getRemarks();
                                $words = empty($remarks) ? 'PASSED' : $remarks;
                                $extra = array($total['weightedAvr'],$total['unitsPass'], $words); 
                                
                            ?>
                            <tr>
                                <td style="border: 1px solid #bbb"><?= $keys + 1 ?></td>
                                <td style="border: 1px solid #bbb"><?= $values['matric'] ?></td>
                                <td style="border: 1px solid #bbb"><strong>
                                <?= $values['othernames'] . ' ' . $values['surname'] ?>
                                </strong></td>
                                <td style="border: 1px solid #bbb"><?= $values['sex'] ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $total['weightedAvr']; ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $total['unitsPass']; ?></td>
                                <td style="border: 1px solid #bbb"><?php echo empty($remarks) ? 'PASSED' : $remarks; ?></td>
                                <?php $summaryOf->__segregate($total['weightedAvr'], $values, $remarks, $extra, $values['matric']); ?>
                            </tr>
                            <?php $gradePointer->__clearSetArray(); ?>
                            <?php } ?>
                        </table>
                        <?php
                            $remarks = '';
                            $getStackFlows = $summaryOf->__getStackFlows();
                        ?>
                        <p>The following <?php echo count($getStackFlows['passed']); ?>  candidates have passed all the compulsory courses required in the <?php echo $_POST['session']; ?> Rain Semester Examination and have fulfilled other University requirements</p>
                        <table id="dynamic" class="display table table-bordered table-striped dataTable">
                            <thead>
                                <th>S/N</th>
                                <th>Matric No(s)</th>
                                <th>Name Of Candidate(s)</th>
                                <th>Sex</th>
                                <th>CGPA</th>
                                <th>CTUNP</th>
                                <th>Remark(s)</th>
                            </thead>
                            
                            <?php foreach ($getStackFlows['passed'] as $keys => $values) { ?>
                            <?php //var_dump($summaryOf->__getStackFlows($values['matric'])); exit; ?>
                            <?php $arrString = $summaryOf->__getStackFlows($values['matric']); ?>
                            <?php //$total = $summaryOf->__setViewFlow($values['matric'], $toLevel); ?>
                            <tr>
                                <td style="border: 1px solid #bbb"><?= $keys + 1 ?></td>
                                <td style="border: 1px solid #bbb"><?= $values['matric'] ?></td>
                                <td style="border: 1px solid #bbb"><strong>
                                <?= $values['othernames'] . ' ' . $values['surname'] ?>
                                </strong></td>
                                <td style="border: 1px solid #bbb"><?= $values['sex'] ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][0]; ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][1]; ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][2].' : '.GradePoints::__classDivision($arrString[0][0]); ?></td>
                            </tr>
                            <?php $gradePointer->__clearSetArray(); ?>
                            <?php } ?>
                        </table>
                    <?php } else { ?>
                    <strong>No Selection Made</strong>
                    <?php } ?>
                    
                    <!-- Check Highlight -->
                    <p>&nbsp; &nbsp; </p>
                    <h3>B. Recommendation</h3>
                    <?php
                        $remarks = '';
                        $getStackFlows = $summaryOf->__getStackFlows();
                        
                    ?>
                    <?php if(isset($getStackFlows['recommend'])){ ?>
                    <p>The following <?php echo count(@$getStackFlows['recommend']); ?>  candidate is recommended for commendation for having a Current GPA of 4.50 and above</p>
                        <table id="dynamic" class="display table table-bordered table-striped dataTable">
                            <thead>
                                <th>S/N</th>
                                <th>Matric No(s)</th>
                                <th>Name Of Candidate(s)</th>
                                <th>Sex</th>
                                <th>CGPA</th>
                                <th>CTUNP</th>
                                <th>Remark(s)</th>
                            </thead>
                            
                            <?php foreach ($getStackFlows['recommend'] as $keys => $values) { ?>
                            <?php //var_dump($summaryOf->__getStackFlows($values['matric'])); exit; ?>
                            <?php $arrString = $summaryOf->__getStackFlows($values['matric']); ?>
                            <?php //$total = $summaryOf->__setViewFlow($values['matric'], $toLevel); ?>
                            <tr>
                                <td style="border: 1px solid #bbb"><?= $keys + 1 ?></td>
                                <td style="border: 1px solid #bbb"><?= $values['matric'] ?></td>
                                <td style="border: 1px solid #bbb"><strong>
                                <?= $values['othernames'] . ' ' . $values['surname'] ?>
                                </strong></td>
                                <td style="border: 1px solid #bbb"><?= $values['sex'] ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][0]; ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][1]; ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][2].' : '.GradePoints::__classDivision($arrString[0][0]); ?></td>
                            </tr>
                            <?php $gradePointer->__clearSetArray(); ?>
                            <?php } ?>
                        </table>
                    <?php } else{ ?>
                    <strong>No Recommendation Made</strong>
                    <?php } ?>
                    <p>&nbsp; &nbsp; </p>
                    
                    <!-- Check Highlight -->
                    <p>&nbsp; &nbsp; </p>
                    <h3>C. References</h3>
                    <?php
                        $remarks = '';
                        $getStackFlows = $summaryOf->__getStackFlows();
                        
                    ?>
                    <?php if(isset($getStackFlows['repeat'])){ ?>
                    <p>The following <?php echo count(@$getStackFlows['repeat']); ?> candidates have course listed against their names to take/repeat at the next available opportunity. </p>
                        <table id="dynamic" class="display table table-bordered table-striped dataTable">
                            <thead>
                                <th>S/N</th>
                                <th>Matric No(s)</th>
                                <th>Name Of Candidate(s)</th>
                                <th>Sex</th>
                                <th>CGPA</th>
                                <th>CTUNP</th>
                                <th>Remark(s)</th>
                            </thead>
                            
                            <?php foreach ($getStackFlows['repeat'] as $keys => $values) { ?>
                            <?php //var_dump($summaryOf->__getStackFlows($values['matric'])); exit; ?>
                            <?php $arrString = $summaryOf->__getStackFlows($values['matric']); ?>
                            <?php //$total = $summaryOf->__setViewFlow($values['matric'], $toLevel); ?>
                            <tr>
                                <td style="border: 1px solid #bbb"><?= $keys + 1 ?></td>
                                <td style="border: 1px solid #bbb"><?= $values['matric'] ?></td>
                                <td style="border: 1px solid #bbb"><strong>
                                <?= $values['othernames'] . ' ' . $values['surname'] ?>
                                </strong></td>
                                <td style="border: 1px solid #bbb"><?= $values['sex'] ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][0]; ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][1]; ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][2] ?></td>
                            </tr>
                            <?php $gradePointer->__clearSetArray(); ?>
                            <?php } ?>
                        </table>
                    <?php } else{ ?>
                    <strong>No Recommendation Made</strong>
                    <?php } ?>
                    <p>&nbsp; &nbsp; </p>
                    
                    <!-- Check Highlight -->
                    <p>&nbsp; &nbsp; </p>
                    <h3>D. Recommended for Faculty Counseling</h3>
                    The following candidates is/are  recommended for the Faculty Counseling for having a current GPA of less than 1.00 in the semester
                    
                    <!-- Check Highlight -->
                    <p>&nbsp; &nbsp; </p>
                    <h3>E. Recommended for University Probation</h3>
                    <?php
                        $remarks = '';
                        $getStackFlows = $summaryOf->__getStackFlows();
                        
                    ?>
                    <?php if(isset($getStackFlows['probation'])){ ?>
                    <p>The following <?php echo count(@$getStackFlows['probation']); ?> candidate is recommended for probation for having a cumulative GPA of less than 1.00 in the semester</p>
                        <table id="dynamic" class="display table table-bordered table-striped dataTable">
                            <thead>
                                <th>S/N</th>
                                <th>Matric No(s)</th>
                                <th>Name Of Candidate(s)</th>
                                <th>Sex</th>
                                <th>CGPA</th>
                                <th>CTUNP</th>
                                <th>Remark(s)</th>
                            </thead>
                            
                            <?php foreach ($getStackFlows['probation'] as $keys => $values) { ?>
                            <?php //var_dump($summaryOf->__getStackFlows($values['matric'])); exit; ?>
                            <?php $arrString = $summaryOf->__getStackFlows($values['matric']); ?>
                            <?php //$total = $summaryOf->__setViewFlow($values['matric'], $toLevel); ?>
                            <tr>
                                <td style="border: 1px solid #bbb"><?= $keys + 1 ?></td>
                                <td style="border: 1px solid #bbb"><?= $values['matric'] ?></td>
                                <td style="border: 1px solid #bbb"><strong>
                                <?= $values['othernames'] . ' ' . $values['surname'] ?>
                                </strong></td>
                                <td style="border: 1px solid #bbb"><?= $values['sex'] ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][0]; ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][1]; ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][2] ?></td>
                            </tr>
                            <?php $gradePointer->__clearSetArray(); ?>
                            <?php } ?>
                        </table>
                    <?php } else{ ?>
                    <strong>No Probation Made</strong>
                    <?php } ?>
                    
                    <!-- Check Highlight -->
                    <p>&nbsp; &nbsp; </p>
                    <h3>F. Withdrawal</h3>
                    
                    <?php
                        $remarks = '';
                        $getStackFlows = $summaryOf->__getStackFlows();
                        
                    ?>
                    <?php if(isset($getStackFlows['withdraw'])){ ?>
                    <p>The following <?php echo count(@$getStackFlows['withdraw']); ?> candidate is advised to withdraw for having a cumulative GPA less than 1.00 in two consecutive semesters</p>
                        <table id="dynamic" class="display table table-bordered table-striped dataTable">
                            <thead>
                                <th>S/N</th>
                                <th>Matric No(s)</th>
                                <th>Name Of Candidate(s)</th>
                                <th>Sex</th>
                                <th>CGPA</th>
                                <th>CTUNP</th>
                                <th>Remark(s)</th>
                            </thead>
                            
                            <?php foreach ($getStackFlows['withdraw'] as $keys => $values) { ?>
                            <?php //var_dump($summaryOf->__getStackFlows($values['matric'])); exit; ?>
                            <?php $arrString = $summaryOf->__getStackFlows($values['matric']); ?>
                            <?php //$total = $summaryOf->__setViewFlow($values['matric'], $toLevel); ?>
                            <tr>
                                <td style="border: 1px solid #bbb"><?= $keys + 1 ?></td>
                                <td style="border: 1px solid #bbb"><?= $values['matric'] ?></td>
                                <td style="border: 1px solid #bbb"><strong>
                                <?= $values['othernames'] . ' ' . $values['surname'] ?>
                                </strong></td>
                                <td style="border: 1px solid #bbb"><?= $values['sex'] ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][0]; ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][1]; ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][2] ?></td>
                            </tr>
                            <?php $gradePointer->__clearSetArray(); ?>
                            <?php } ?>
                        </table>
                    <?php } else{ ?>
                    <strong>No Withdrawal Made</strong>
                    <?php } ?>
                    
                    <!-- Check Highlight -->
                    <p>&nbsp; &nbsp; </p>
                    <h3>G. Suspension of studentship</h3>
                    The studentship of the following candidate is recommended for suspension for failing to register for the consecutive semester
                    
                    <!-- Check Highlight -->
                    <p>&nbsp; &nbsp; </p>
                    <h3>H. Determination of Studentship</h3>
                    The studentship of the following student is recommended for determination for failing to register for two consecutive semesters
                    
                    <!-- Check Highlight -->
                    <p>&nbsp; &nbsp; </p>
                    <h3>I. Summary of Summary</h3>
                    <table class="table">
                    <tr>
                        <td>Number of Candidates in class</td>
                        <td><?php echo count($getStackFlows); ?></td>
                    </tr>
                    <tr>
                        <td>Number of Candidates who sat for the examination</td>
                        <td><?php echo count($viewStack['totalPackage']); ?></td>
                    </tr>
                    <tr>
                        <td>Number of Candidates who passed the examination</td>
                        <td><?php echo count($getStackFlows['passed']); ?></td>
                    </tr>
                    <tr>
                        <td>Number of Candidates to be recommended for commendation</td>
                        <td><?php echo count($getStackFlows['recommend']); ?></td>
                    </tr>
                    <tr>
                        <td>Number of Candidates with courses to repeat/take</td>
                        <td><?php echo count($getStackFlows['repeat']); ?></td>
                    </tr>
                    </table>
                    
                    <!-- Check Highlight -->
                    <p>&nbsp; &nbsp; </p>
                    <h3>STATUS OF COURSES</h3>
                    <?php
                        $packages = $summaryOf->__getCoursePackage();
                    ?>
                    REQUIRED : <?php echo(implode(", ",$summaryOf->__getStackFlows('required'))); ?><br/>
                    CUMPULSORY : <?php echo(implode(", ",$summaryOf->__getStackFlows('cumpolsory'))); ?><br/>
                    ELECTIVE : <?php echo(@implode(", ", $summaryOf->__getStackFlows('elective'))); ?><p>&nbsp;</p>
                    </div>
                    </div>
                </section>
            </div>

        </div>
    </div>
<button class="btn btn-primary noprint" onclick="window.print();">Print Page</button>
</section>
</section>
<script type="text/javascript">
    window.print();
    
</script>
</body>
</html>