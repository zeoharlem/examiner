{% extends "templates/base.volt" %}

{% block head %}
{% endblock %}
{% block content %}
    <div class="col-md-12">
        <section class="panel">
                    <header class="panel-heading">
                        Matric Number | <strong>Generation</strong>
                          <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                         </span>
                    </header>
                    <div class="panel-body">
                        <form method="post" action="{{url('generatematric/')}}" class="form-horizontal" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-4">
                                    <input type="file" class="default" name="files" id="files" />
                                    <p class="help-block"><strong>Select .TXT File To be Uploaded</strong></p>
                                </div>
                            </div>
                            <div class="form-group">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-sm btn-success"><strong>Submit Txt</strong></button>
                            </div>
                            </div>
                        </form>
                    </div>
                </section>
                {% if names is defined %}
                <section class="panel">
                 <div class="panel-body">
                 <button type="submit" class="btn btn-sm btn-success"><strong>GENERATE Ms-WORD</strong></button>
                 <button type="submit" class="btn btn-sm btn-warning"><strong>GENERATE EXCEL</strong></button>
                 <button type="submit" class="btn btn-sm btn-danger"><strong>PRINT OUT</strong></button>
                         <table class="table">
                          <thead> 
                             <tr> <th>#</th> <th>Full Names</th> <th>Numbers</th></tr> 
                             </thead> 
                             <tbody>
                             {% for keys, values in names %}
                                 <tr> 
                                     <th scope="row">{{keys+1}}</th> <td>{{values['names'] | upper}}</td> <td>{{number[keys]['number']}}</td>
                                 </tr> 
                             </tbody> 
                             {% endfor %}
                         </table>
                     </div>
                </section>
               {% endif %}
    </div>
{% endblock %}