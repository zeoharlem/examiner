
{% block head %}
{% endblock %}
{% block content %}
{% if packs is defined %}
    <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Course Package 
                            <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-cog"></a>
                                <a href="javascript:;" class="fa fa-times"></a>
                             </span>
                        </header>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Course Title</th>
                                    <th>Course Code</th>
                                    <th>Lecturer</th>
                                    <th>Department</th>
                                    <th>Action(s)</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                {% for keys,values in packs%}
                                <tr>
                                    <td>{{keys+1}}</td>
                                    <td>{{values.title | capitalize}}</td>
                                    <td>{{values.code | uppercase}}</td>
                                    <td>{{values.lecturer | capitalize}}</td>
                                    <td>{{values.department | capitalize}}</td>
                                    <td>
                                        <a href="{{url('results/viewRegs?department='~values.department~'&code='~values.code~'&session='~values.session)}}" class="btn btn-primary btn-sm pull-left"><strong>Load View</strong></a>
                                    </td>
                                    <td><form id="fileupload" action="{{url('results/uploadAjax')}}" method="POST" enctype="multipart/form-data">
                                        <div class="fileupload-buttonbar pull-left">
                                            
                                                <!-- The fileinput-button span is used to style the file input field as button -->
                                                <span class="btn btn-success fileinput-button btn-sm">
                                                <i class="glyphicon glyphicon-plus"></i>
                                                <span class="addFile"><strong>Add | Browse Excel File ...</strong></span>
                                                <input type="file" name="files" id="files">
                                                </span>
                                            
                                            <!-- The global progress state -->
                                        </div>
                                    </form>
                                    </td>
                                </tr>
                                {% endfor %}
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
{% else %}
<div class="col-sm-12">
<div class="alert alert-danger fade in">
<button data-dismiss="alert" class="close close-sm" type="button">
    <i class="fa fa-times"></i>
</button>
<strong>Sorry No Registration!!!</strong></div>
</div>
{% endif  %}
{% endblock %}