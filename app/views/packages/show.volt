{% extends "templates/base.volt" %}

{% block head %}
{% endblock %}
{% block content %}
    <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Edit / Delete <strong>Packages</strong>
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                         </span>
                    </header>
                    <div class="panel-body">
                    <div class="adv-table">
                        <table id="dynamic-table-package" class="display table table-bordered table-striped dataTable">
                            <thead>
                                <th>Package ID</th>
                                <th>Course Description</th>
                                <th>Code</th>
                                <th>Session</th>
                                <th>Department(s)</th>
                                <th>Semester(s)</th>
                                <th>Lecturer (ID)</th>
                                <th>Action(s)</th>
                            </thead>

                        </table>
                    </div>
                    </div>
                </section>
            </div>
{% endblock %}