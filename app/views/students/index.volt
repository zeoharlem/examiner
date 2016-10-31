{% extends "templates/base.volt" %}

{% block head %}
{% endblock %}
{% block content %}
    <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Students List
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                         </span>
                    </header>
                    <div class="panel-body">
                    <div class="adv-table">
                        <table id="student-datatable" class="display table table-bordered table-striped dataTable">
                            <thead>
                                <th>#</th>
                                <th>Othername(s)</th>
                                <th>Surname</th>
                                <th>Phone Number</th>
                                <th>Email</th>
                                <th>Matric(s)</th>
                                <th>Department(s)</th>
                                <th>Action(s)</th>
                                
                                
                                
                            </thead>

                        </table>
                    </div>
                    </div>
                </section>
            </div>
{% endblock %}