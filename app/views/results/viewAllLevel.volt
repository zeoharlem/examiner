{% extends "templates/base.volt" %}

{% block head %}
{% endblock %}
{% block content %}
<div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Total Results For {{results[0]['matric']}} | <strong>{{studentFlow.surname | capitalize}} {{studentFlow.othernames | capitalize}}</strong>
                            <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-cog"></a>
                                <a href="javascript:;" class="fa fa-times"></a>
                             </span>
                        </header>
                        <div class="panel-body">
                        <p>&nbsp;</p>
                        <p><a href="{{url('results/createSinglePersonExcelSheet?level='~this.request.getQuery('level')~'&matric='~this.request.getQuery('matric')~'&session='~this.request.getQuery('session'))}}" class="btn btn-primary" target="_blank">Transcripts / Excel</a>
                        &nbsp;&nbsp;&nbsp;&nbsp;REMARKS <strong>|</strong>  <small>{{remarks | upper}}</small>
                        </p>
                        <p>&nbsp;</p>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Course Description</th>
                                    <th style="border:1px solid #ddd;">Code</th>
                                    <th style="border:1px solid #ddd;">Matric</th>
                                    <th style="border:1px solid #ddd;">Level</th>
                                    <th style="border:1px solid #ddd;">Session</th>
                                    <th style="border:1px solid #ddd;" class="text-center">Units</th>
                                    <th style="border:1px solid #ddd;" class="text-center">Points</th>
                                    <th style="border:1px solid #ddd;" class="text-center">C.A</th>
                                    <th style="border:1px solid #ddd;" class="text-center">Exam</th>
                                    <th class="text-center">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                {% for keys, values in results %}
                                <tr>
                                    <td style="border:1px solid #ddd;">{{values['title'] | capitalize}}</td>
                                    <td style="border:1px solid #ddd;">{{values['code'] | upper}}</td>
                                    <td style="border:1px solid #ddd;" class="text-center">{{values['matric']}}</td>
                                    <td style="border:1px solid #ddd;" class="text-center">{{values['level']}}</td>
                                    <td style="border:1px solid #ddd;" class="text-center">{{values['session']}}</td>
                                    <td style="border:1px solid #ddd;" class="text-center">{{values['units']}}</td>
                                    <td style="border:1px solid #ddd;" class="text-center">{{values['gradePoint']}}</td>
                                    <td style="border:1px solid #ddd;" class="text-center">{{values['ca']}}</td>
                                    <td style="border:1px solid #ddd;" class="text-center">{{values['exam']}}</td>
                                    <td style="border:1px solid #ddd;" class="text-center">{{values['totalScore']}}</td>
                                </tr>
                                {% endfor %}
                                {% if stackFlowCO is defined %}
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
                                {% for keys,values in stackFlowCO %}
                                <tr>
                                    <td style="border:1px solid #ddd;">{{values['title'] | capitalize}}</td>
                                    <td style="border:1px solid #ddd;">{{values['code'] | uppercase}}</td>
                                    <td style="border:1px solid #ddd;">{{values['matric']}}</td>
                                    <td style="border:1px solid #ddd;">{{values['level']}}</td>
                                    <td style="border:1px solid #ddd;">{{values['session']}}</td>
                                    <td style="border:1px solid #ddd;" class="text-center">{{values['units']}}</td>
                                    <td style="border:1px solid #ddd;" class="text-center">{{values['grade']}}</td>
                                    <td style="border:1px solid #ddd;" class="text-center">{{values['caCO']}}</td>
                                    <td style="border:1px solid #ddd;" class="text-center">{{values['scoreCO']}}</td>
                                    <td style="border:1px solid #ddd;" class="text-center">{{values['caCO']+values['scoreCO']}}</td>
                                </tr>
                                {% endfor %}
                                {% endif %}
                                <tr>
                                    <td style="border:1px solid #ddd;" class="text-right"><strong>TOTAL</strong></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                    <td style="border:1px solid #ddd;" class="text-center">{{totalGrade}}</td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #ddd;" class="text-right"><strong class=" label label-success label-mini">TOTAL UNITS</strong></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;" class="text-center">{{totalUnits}}</td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #ddd;" class="text-right"><strong class=" label label-warning label-mini">TOTAL UNITS PASSED</strong></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;" class="text-center">{{totalUnitP}}</td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #ddd;" class="text-right"><strong class=" label label-danger label-mini">TOTAL UNITS FAILED</strong></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;" class="text-center">{{totalUnitF}}</td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #ddd;" class="text-right"><strong class="label label-info label-mini">TOTAL GRADE POINTS</strong></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                    <td style="border:1px solid #ddd;" class="text-center">{{totalGrade}}</td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #ddd;" class="text-right"></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #ddd;" class="text-right"><strong class="label label-warning label-mini">TOTAL WEIGHTED AVERAGE POINT</strong></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;"></td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                    <td style="border:1px solid #ddd;" class="text-center"><strong>{{weightedAvr}}</strong></td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                    <td style="border:1px solid #ddd;" class="text-center"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
{% endblock %} 