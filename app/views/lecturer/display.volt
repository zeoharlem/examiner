{% extends "templates/base.volt" %}

{% block head %}
{% endblock %}
{% block content %}
    <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <strong>All Lecturers Available</strong>
                            <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-cog"></a>
                                <a href="javascript:;" class="fa fa-times"></a>
                             </span>
                        </header>
                        <div class="panel-body">
                            <table class="table table-striped" id="dynamic-table-straight">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Lecturers Name</th>
                                    <th>Email Address</th>
                                    <th>Code Id</th>
                                    <th>Action(s)</th>
                                </tr>
                                </thead>
                                <tbody>
                                {% for keys,values in lecturers %}
                                <tr>
                                    <td>{{keys+1}}</td>
                                    <td>{{values['firstname'] | upper}} {{values['lastname'] | upper}}</td>
                                    <td>{{values['email']}}</td>
                                    <td>{{values['codename']}}</td>
                                    <td><a href='#' data-values='{{values['codename']}}' class='btn btn-primary btn-sm viewDisplay'><strong>View</strong></a></td>
                                </tr>
                                {% endfor %}
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
{% endblock %}