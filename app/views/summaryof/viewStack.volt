{% extends "templates/print.volt" %}

{% block head %}
{% endblock %}
{% block content %}
<div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <strong>Students List</strong>
                        
                    </header>
                    <div class="panel-body">
                    <div class="adv-table">
                    {% if registered is defined %}
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
                            
                            {% for keys, values in viewStack['totalPackage'] %}
                            <?php $total = $summaryOf->__setViewFlow($values['matric'], $toLevel); ?>
                            
                            <?php
                                $remarks = $gradePointer->__getRemarks();
                                $words = empty($remarks) ? 'PASSED' : $remarks;
                                $extra = array($total['weightedAvr'],$total['unitsPass'], $words); 
                                
                            ?>
                            <tr>
                                <td style="border: 1px solid #bbb">{{keys+1}}</td>
                                <td style="border: 1px solid #bbb">{{values['matric']}}</td>
                                <td style="border: 1px solid #bbb"><strong>
                                {{values['othernames']~' '~values['surname']}}
                                </strong></td>
                                <td style="border: 1px solid #bbb">{{values['sex']}}</td>
                                <td style="border: 1px solid #bbb"><?php echo $total['weightedAvr']; ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $total['unitsPass']; ?></td>
                                <td style="border: 1px solid #bbb"><?php echo empty($remarks) ? 'PASSED' : $remarks; ?></td>
                                <?php $summaryOf->__segregate($total['weightedAvr'], $values, $remarks, $extra, $values['matric']); ?>
                            </tr>
                            <?php $gradePointer->__clearSetArray(); ?>
                            {% endfor %}
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
                            
                            {% for keys, values in getStackFlows['passed'] %}
                            <?php //var_dump($summaryOf->__getStackFlows($values['matric'])); exit; ?>
                            <?php $arrString = $summaryOf->__getStackFlows($values['matric']); ?>
                            <?php //$total = $summaryOf->__setViewFlow($values['matric'], $toLevel); ?>
                            <tr>
                                <td style="border: 1px solid #bbb">{{keys+1}}</td>
                                <td style="border: 1px solid #bbb">{{values['matric']}}</td>
                                <td style="border: 1px solid #bbb"><strong>
                                {{values['othernames']~' '~values['surname']}}
                                </strong></td>
                                <td style="border: 1px solid #bbb">{{values['sex']}}</td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][0]; ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][1]; ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][2].' : '.GradePoints::__classDivision($arrString[0][0]); ?></td>
                            </tr>
                            <?php $gradePointer->__clearSetArray(); ?>
                            {% endfor %}
                        </table>
                    {% else %}
                    <strong>No Selection Made</strong>
                    {% endif %}
                    
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
                            
                            {% for keys, values in getStackFlows['recommend'] %}
                            <?php //var_dump($summaryOf->__getStackFlows($values['matric'])); exit; ?>
                            <?php $arrString = $summaryOf->__getStackFlows($values['matric']); ?>
                            <?php //$total = $summaryOf->__setViewFlow($values['matric'], $toLevel); ?>
                            <tr>
                                <td style="border: 1px solid #bbb">{{keys+1}}</td>
                                <td style="border: 1px solid #bbb">{{values['matric']}}</td>
                                <td style="border: 1px solid #bbb"><strong>
                                {{values['othernames']~' '~values['surname']}}
                                </strong></td>
                                <td style="border: 1px solid #bbb">{{values['sex']}}</td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][0]; ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][1]; ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][2].' : '.GradePoints::__classDivision($arrString[0][0]); ?></td>
                            </tr>
                            <?php $gradePointer->__clearSetArray(); ?>
                            {% endfor %}
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
                            
                            {% for keys, values in getStackFlows['repeat'] %}
                            <?php //var_dump($summaryOf->__getStackFlows($values['matric'])); exit; ?>
                            <?php $arrString = $summaryOf->__getStackFlows($values['matric']); ?>
                            <?php //$total = $summaryOf->__setViewFlow($values['matric'], $toLevel); ?>
                            <tr>
                                <td style="border: 1px solid #bbb">{{keys+1}}</td>
                                <td style="border: 1px solid #bbb">{{values['matric']}}</td>
                                <td style="border: 1px solid #bbb"><strong>
                                {{values['othernames']~' '~values['surname']}}
                                </strong></td>
                                <td style="border: 1px solid #bbb">{{values['sex']}}</td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][0]; ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][1]; ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][2] ?></td>
                            </tr>
                            <?php $gradePointer->__clearSetArray(); ?>
                            {% endfor %}
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
                            
                            {% for keys, values in getStackFlows['probation'] %}
                            <?php //var_dump($summaryOf->__getStackFlows($values['matric'])); exit; ?>
                            <?php $arrString = $summaryOf->__getStackFlows($values['matric']); ?>
                            <?php //$total = $summaryOf->__setViewFlow($values['matric'], $toLevel); ?>
                            <tr>
                                <td style="border: 1px solid #bbb">{{keys+1}}</td>
                                <td style="border: 1px solid #bbb">{{values['matric']}}</td>
                                <td style="border: 1px solid #bbb"><strong>
                                {{values['othernames']~' '~values['surname']}}
                                </strong></td>
                                <td style="border: 1px solid #bbb">{{values['sex']}}</td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][0]; ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][1]; ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][2] ?></td>
                            </tr>
                            <?php $gradePointer->__clearSetArray(); ?>
                            {% endfor %}
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
                            
                            {% for keys, values in getStackFlows['withdraw'] %}
                            <?php //var_dump($summaryOf->__getStackFlows($values['matric'])); exit; ?>
                            <?php $arrString = $summaryOf->__getStackFlows($values['matric']); ?>
                            <?php //$total = $summaryOf->__setViewFlow($values['matric'], $toLevel); ?>
                            <tr>
                                <td style="border: 1px solid #bbb">{{keys+1}}</td>
                                <td style="border: 1px solid #bbb">{{values['matric']}}</td>
                                <td style="border: 1px solid #bbb"><strong>
                                {{values['othernames']~' '~values['surname']}}
                                </strong></td>
                                <td style="border: 1px solid #bbb">{{values['sex']}}</td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][0]; ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][1]; ?></td>
                                <td style="border: 1px solid #bbb"><?php echo $arrString[0][2] ?></td>
                            </tr>
                            <?php $gradePointer->__clearSetArray(); ?>
                            {% endfor %}
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
{% endblock %}