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
                    <p>The following 42  candidates have passed all the compulsory courses required in the 2010/2011 Rain Semester Examination and have fulfilled other University requirements</p>
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
                            <?php $counter = 0; ?>
                            
                            {% for keys, values in gradePoints %}
                            
                            <?php foreach($values as $index=>$elem){
                                $gradePointer->__gradeParser($elem['totalGrades'],$elem['units'],$elem['codes']);
                                $gradePointer->__setUnits($elem['units']);
                            }
                            ?>
                            <tr>
                                <td><?php echo $counter+1; ?></td>
                                <td>{{keys}}</td>
                                <td><strong>
                                <?php echo $values[0]['othernames'].' '.$values[0]['surname']; ?>
                                </strong></td>
                                <td>{{values[0]['sex'] | capitalize}}</td>
                                <td><?php echo $gradePointer->__weightedGradeAvr(); ?></td>
                                <td><?php echo $gradePointer->__getTotalUnitPass(); ?></td>
                                <td><?php echo $gradePointer->__getRemarks(); ?></td>
                            </tr>
                            <?php $counter++; ?>
                            <?php $gradePointer->__clearSetArray(); ?>
                            {% endfor %}
                        </table>
                    {% else %}
                    <strong>No Selection Made</strong>
                    {% endif %}
                    </div>
                    </div>
                </section>
            </div>
{% endblock %}