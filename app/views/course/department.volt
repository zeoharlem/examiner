{% extends "templates/base.volt" %}

{% block head %}
{% endblock %}
{% block content %}
    <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Create <strong>Department</strong>
                    </header>
                    <div class="panel-body">
                        <div class="position-center">
                            <form class="form-horizontal" method="post" action="{{url('course/department')}}" role="form">
                            <input type="hidden" name="headofdepartment" />
                            <div class="form-group">
                                <label for="description" class="col-lg-2 col-sm-2 control-label">Faculty</label>
                                <div class="col-lg-10">
                                    <select id="faculty" name="faculty_id" class="form-control" required>
                                    {% for keys,values in faculty %}
                                        <option value="{{values.faculty_id}}">{{values.description}}</option>
                                    {% endfor %}
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="description" class="col-lg-2 col-sm-2 control-label">Department</label>
                                <div class="col-lg-10">
                                    <input type="text" required name="description" class="form-control" id="description" placeholder="Type description of department">
                                    <p class="help-block"><strong>Example block-level help text here.</strong></p>
                                </div>
                            </div>
                            
                            <!--<div class="form-group">
                                <label for="headofdepartment" class="col-lg-2 col-sm-2 control-label">HOD</label>
                                <div class="col-lg-10">
                                    <input type="text" name="headofdepartment" class="form-control input-lg" id="headofdepartment" placeholder="Type Head of department">
                                </div>
                            </div>-->
                            
                            <div class="form-group">
                                <label class="col-lg-2 col-sm-2 control-label"><strong>HOD</strong> </label>
                                <div class="col-lg-6">
                                    <select id="e1" class="populate" required name="codename" style="width: 400px;">
                                        
                                        <optgroup label="Lecturer Zone">
                                        {% for keys, values in lecturer %}
                                            <option value="{{values['codename']}}">{{values['firstname'] | capitalize}} {{values['lastname'] | capitalize}}</option>
                                        {% endfor %}
                                        </optgroup>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button type="submit" class="btn btn-danger"><strong>Create</strong></button>
                                    <button type="reset" class="btn btn-primary"><strong>Reset</strong></button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </section>

            </div>
{% endblock %}