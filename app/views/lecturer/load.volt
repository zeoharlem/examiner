{% extends "templates/base.volt" %}

{% block head %}
{% endblock %}
{% block content %}
    <div class="col-sm-12">
    {% if lecturerPacks is empty %}
    <div class="alert alert-danger"><strong>No Assigned Courses or Registered Student(s)<a class="pull-right" href="{{url('lecturer/display')}}"> Back to Display Lecturers</a></strong></div>
    {% else %}
                    <section class="panel">
                        <header class="panel-heading">
                            Lecturer Table | <strong>{{lecturerPacks[0]['lecturer']}}</strong>
                            <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-cog"></a>
                                <a href="javascript:;" class="fa fa-times"></a>
                             </span>
                        </header>
                        <div class="panel-body">
                        <form method="post" class="form-inline">
                            <table class="table table-striped" id="dynamic-table-straight">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student(s)</th>
                                    <th>Matric</th>
                                    <th>Title</th>
                                    <th>Department</th>
                                    <th>Semester</th>
                                    <th>Session</th>
                                    <th>Action(s)</th>
                                </tr>
                                </thead>
                                <tbody>
                                {% for keys,values in lecturerPacks %}
                                <tr>
                                    <td>{{keys+1}}</td>
                                    <td>{{values['fullname'] | capitalize}}<br/><small><strong><i class="fa fa-phone"></i> &nbsp; {{values['phone']}}</strong></small></td>
                                    <td>{{values['matric']}}</td>
                                    <td>{{values['title'] | capitalize}}</td>
                                    <td>{{values['department'] | capitalize}}</td>
                                    <td>{{values['semester']}}</td>
                                    <td>{{values['session']}}</td>
                                    <td>
                                        <input type="text" class="form-control" name="ca[]" value="{{values['ca']}}" size="4" maxlength="2" />
                                        <input type="text" class="form-control" name="exam[]" value="{{values['exam']}}" size="4" maxlength="2" />
                                        <input type="hidden" class="form-control" name="matric[]" value="{{values['matric']}}" />
                                        <input type="hidden" class="form-control" name="course[]" value="{{values['code']}}" size="4" maxlength="2" />
                                        <input type="hidden" class="form-control" name="creg_id[]" value="{{values['creg_id']}}" size="4" maxlength="2" />
                                    </td>
                                </tr>
                                {% endfor %}
                                </tbody>
                            </table>
                            <button class="btn btn-primary" type="submit">Submit</button>
                            <button class="btn btn-danger" type="reset">Reset</button>
                            </form>
                        </div>
                    </section>
                </div>
                {% endif %}
{% endblock %}