{% extends "templates/base.volt" %}

{% block head %}
{% endblock %}
{% block content %}
    <div class="col-md-4" class="addToCart">
    <!--pagination start-->
    <section class="panel">
        <header class="panel-heading">
            <strong><i class="fa fa-edit"></i> &nbsp; <a href="{{url('course/')}}" style="text-transform: capitalize">Courses</a></strong>
        <span class="tools pull-right">
            <a href="javascript:;" class="fa fa-chevron-up"></a>
            <a href="javascript:;" class="fa fa-times"></a>
        </span>
        </header>
    </section>
    <!--pagination end-->
    </div>

    <div class="col-md-4" class="addToCart">
    <!--pagination start-->
    <section class="panel">
        <header class="panel-heading">
            <strong><i class="fa fa-hdd-o"></i> &nbsp; <a href="{{url('packages/')}}" style="text-transform: capitalize">Session Packages</a></strong>
        <span class="tools pull-right">
            <a href="javascript:;" class="fa fa-chevron-up"></a>
            <a href="javascript:;" class="fa fa-times"></a>
        </span>
        </header>
    </section>
    <!--pagination end-->
    </div>

    <div class="col-md-4" class="addToCart">
    <!--pagination start-->
    <section class="panel">
        <header class="panel-heading">
            <strong><i class="fa fa-user-plus"></i> &nbsp; <a href="{{url('students/')}}" style="text-transform: capitalize">Course Registration</a></strong>
        <span class="tools pull-right">
            <a href="javascript:;" class="fa fa-chevron-up"></a>
            <a href="javascript:;" class="fa fa-times"></a>
        </span>
        </header>
    </section>
    <!--pagination end-->
    </div>

    <div class="col-md-4" class="addToCart">
    <!--pagination start-->
    <section class="panel">
        <header class="panel-heading">
            <strong><i class="fa fa-magnet"></i> &nbsp; <a href="{{url('matrics/')}}" style="text-transform: capitalize">Upload Matric Numbers</a></strong>
        <span class="tools pull-right">
            <a href="javascript:;" class="fa fa-chevron-up"></a>
            <a href="javascript:;" class="fa fa-times"></a>
        </span>
        </header>
    </section>
    <!--pagination end-->
    </div>

    <div class="col-md-4" class="addToCart">
    <!--pagination start-->
    <section class="panel">
        <header class="panel-heading">
            <strong><i class="fa fa-plus"></i> &nbsp; <a href="{{url('collectivegrade/')}}" style="text-transform: capitalize">Generate BroadSheet</a></strong>
        <span class="tools pull-right">
            <a href="javascript:;" class="fa fa-chevron-up"></a>
            <a href="javascript:;" class="fa fa-times"></a>
        </span>
        </header>
    </section>
    <!--pagination end-->
    </div>
    
    <div class="col-md-4" class="addToCart">
    <!--pagination start-->
    <section class="panel">
        <header class="panel-heading">
            <strong><i class="fa fa-keyboard-o"></i> &nbsp; <a href="{{url('course/department')}}" style="text-transform: capitalize">Department | Faculty</a></strong>
        <span class="tools pull-right">
            <a href="javascript:;" class="fa fa-chevron-up"></a>
            <a href="javascript:;" class="fa fa-times"></a>
        </span>
        </header>
    </section>
    <!--pagination end-->
    </div>
    
    <div class="col-md-4" class="addToCart">
    <!--pagination start-->
    <section class="panel">
        <header class="panel-heading">
            <strong><i class="fa fa-th-large"></i> &nbsp; <a href="{{url('results/')}}" style="text-transform: capitalize">Results</a></strong>
        <span class="tools pull-right">
            <a href="javascript:;" class="fa fa-chevron-up"></a>
            <a href="javascript:;" class="fa fa-times"></a>
        </span>
        </header>
    </section>
    <!--pagination end-->
    </div>
    
    <div class="col-md-4" class="addToCart">
    <!--pagination start-->
    <section class="panel">
        <header class="panel-heading">
            <strong><i class="fa fa-group"></i> &nbsp; <a href="{{url('lecturer/')}}" style="text-transform: capitalize">Lecturer</a></strong>
        <span class="tools pull-right">
            <a href="javascript:;" class="fa fa-chevron-up"></a>
            <a href="javascript:;" class="fa fa-times"></a>
        </span>
        </header>
    </section>
    <!--pagination end-->
    </div>

    <div class="col-md-4" class="addToCart">
    <!--pagination start-->
    <section class="panel">
        <header class="panel-heading">
            <strong><i class="fa fa-power-off"></i> &nbsp; <a href="{{url('index/logOut')}}" style="text-transform: capitalize">Sign Out</a></strong>
        <span class="tools pull-right">
            <a href="javascript:;" class="fa fa-chevron-up"></a>
            <a href="javascript:;" class="fa fa-times"></a>
        </span>
        </header>
    </section>
    <!--pagination end-->
    </div>
{% endblock %}