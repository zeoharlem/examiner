{% extends "templates/base.volt" %}

{% block head %}
{% endblock %}
{% block content %}
    <div class="col-md-12">
        <section class="panel">
                    <header class="panel-heading">
                        Advanced | <strong>Matric Upload</strong>
                          <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                         </span>
                    </header>
                    <div class="panel-body">
                        <form method="post" action="{{url('matrics/uploadAjax')}}" class="form-horizontal" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-4">
                                    <input type="file" class="default" name="files" id="files" />
                                    <p class="help-block"><strong>Select Excel Sheet To be Uploaded</strong></p>
                                </div>
                            </div>
                            <div class="form-group">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-sm btn-success"><strong>Submit Excel</strong></button>
                            </div>
                            </div>
                        </form>
                    </div>
                </section>
    </div>
{% endblock %}