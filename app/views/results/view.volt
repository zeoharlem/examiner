{% extends "templates/base.volt" %}

{% block head %}
{% endblock %}
{% block content %}
    <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Result View | <strong>{{studentFlow.surname | capitalize}} {{studentFlow.othernames | capitalize}}</strong>
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
                        <div class="pull-right"><a href="{{url('results/view?'~urlTask~'&semester=1')}}"><i class="fa fa-map-marker"></i> Harmattan</a> | <a href="{{url('results/view?'~urlTask~'&semester=2')}}"><i class="fa fa-plus"></i> Rain</a></div>
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
                                {% for keys,values in stackFlow %}
                                <tr>
                                    <td>{{values['title'] | capitalize}}</td>
                                    <td>{{values['code'] | uppercase}}</td>
                                    <td>{{values['matric']}}</td>
                                    <td>{{values['level']}}</td>
                                    <td>{{values['session']}}</td>
                                    <td class="text-center">{{values['units']}}</td>
                                    <td class="text-center">{{values['grade']}}</td>
                                    <td class="text-center">{{values['ca']}}</td>
                                    <td class="text-center">{{values['score']}}</td>
                                    <td class="text-center">{{values['ca']+values['score']}}</td>
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
                                    <td>{{values['title'] | capitalize}}</td>
                                    <td>{{values['code'] | uppercase}}</td>
                                    <td>{{values['matric']}}</td>
                                    <td>{{values['level']}}</td>
                                    <td>{{values['session']}}</td>
                                    <td class="text-center">{{values['units']}}</td>
                                    <td class="text-center">{{values['grade']}}</td>
                                    <td class="text-center">{{values['caCO']}}</td>
                                    <td class="text-center">{{values['scoreCO']}}</td>
                                    <td class="text-center">{{values['caCO']+values['scoreCO']}}</td>
                                </tr>
                                {% endfor %}
                                {% endif %}
                                <tr>
                                    <td class="text-right"><strong>TOTAL</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center"></td>
                                    <td class="text-center">{{totalGrade}}</td>
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
                                    <td class="text-center">{{totalUnits}}</td>
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
                                    <td class="text-center">{{totalUnitP}}</td>
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
                                    <td class="text-center">{{totalUnitF}}</td>
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
                                    <td class="text-center">{{totalGrade}}</td>
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
                                    <td class="text-center"><strong>{{weightedAvr}}</strong></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
{% endblock %}