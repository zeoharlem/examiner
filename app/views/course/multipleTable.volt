{% extends "templates/base.volt" %}

{% block head %}
{% endblock %}
{% block content %}
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                Create Courses | <strong>Multiple Table</strong>
                <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                    <a href="javascript:;" class="fa fa-cog"></a>
                    <a href="javascript:;" class="fa fa-times"></a>
                 </span>
            </header>
            <div class="panel-body">
                <div class="col-lg-10">
                    <button type="button" class="btn btn-default btn-sm" id="add"><strong><i class="fa fa-plus"></i> Add Row</strong></button>
                    <button type="button" class="btn btn-default btn-sm" id="subtract"><strong><i class="fa fa-minus"></i> &nbsp;Minus Row</strong></button>
                </div>
                <div class="col-lg-2">
                    <select id="nums" class="form-control">
                    <option value=""> --- </option>
                    {% for vars in 1..10 %}
                        <option value="{{vars}}">{{vars}}</option>
                    {% endfor %}
                    </select>
                </div>
            <p>&nbsp;</p>
            <div class="form-group">
                <form method="post" class="form-horizontal" id="multipleTable" action="{{url('course/multipleTable')}}">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        
                        <th>Semester</th>
                        <th>Session</th>
                        <th>Level</th>
                        <th>Code</th>
                        <th>Units</th>
                        <th>Title</th>
                        <th>Department</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        
                        <td style="border:1px solid #bbb"><select required class="form-control" name="semester[]" required>
                                <option value="1">1</option>  
                                <option value="2">2</option>  
                            </select></td>
                        <td style="border:1px solid #bbb">
                            <input type="text" class="form-control" required style="font-size:12px;" name="session[]" placeholder="Session"/>
                        </td>
                        <td style="border:1px solid #bbb"><input required type="text" class="form-control" style="font-size:12px;" name="level[]" required placeholder="Level"/></td>
                        <td style="border:1px solid #bbb"><input required type="text" class="form-control" style="font-size:12px;" name="code[]" required placeholder="Course Code"/></td>
                        <td style="border:1px solid #bbb"><input required type="numeric" maxlength="1" class="form-control" style="font-size:12px;" name="units[]" required placeholder="Units"/></td>
                        <td style="border:1px solid #bbb"><input required type="text" class="form-control" style="font-size:12px;" name="title[]" required placeholder="Title "/></td>
                        <td style="border:1px solid #bbb"><select required class="form-control m-bot15" style="font-size:12px;" name="department[]" required>
                                {% for keys, values in departments %}
                                <option value="{{values.description}}">{{values.description}}</option>  
                                {% endfor %}
                            </select><input type="hidden" name="codename[]" class="codename" value="{{codename}}" /></td>
                        <td style="border:1px solid #bbb"><select required class="form-control" style="font-size:12px;" name="status[]" required>
                                <option value="C">Compulsory</option>  
                                <option value="E">Elective</option>  
                                <option value="R">Required</option>  
                            </select></td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                        <div class="col-lg-10">
                            <button type="submit" class="btn btn-danger btn-sm"><strong>Submit Now</strong></button>
                            <button type="reset" class="btn btn-primary btn-sm"><strong>Reset Now</strong></button>
                        </div>

                    </div>
                </form>
            </div>

        </section>
    </div>
{% endblock %}