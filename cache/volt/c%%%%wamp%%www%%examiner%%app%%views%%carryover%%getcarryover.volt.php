
    <div class="col-sm-12">
                    <?php if (isset($carryovers)) { ?>
                    <section class="panel">
                        <header class="panel-heading">
                            <strong>Students Carry Over</strong>
                            <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-cog"></a>
                                <a href="javascript:;" class="fa fa-times"></a>
                             </span>
                        </header>
                        <div class="panel-body">
                        
                            <table class="table table-striped table-bordered" id="dynamic-table-carry">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student(s)</th>
                                    <th>Matric(s)</th>
                                    <th>Course(s)</th>
                                    <th>Department</th>
                                    <th>Session</th>
                                    <th>CA</th>
                                    <th>Exam</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($carryovers as $keys => $values) { ?>
                                <tr>
                                    <td><?= $keys + 1 ?></td>
                                    <td><?= $values['fullname'] ?><input type="hidden" name="creg_id[]" value="<?= $values['creg_id'] ?>" /></td>
                                    <td><?= $values['matric'] ?><input type="hidden" name="matric[]" value="<?= $values['matric'] ?>" /></td>
                                    <td><?= Phalcon\Text::upper($values['course']) ?><input type="hidden" name="course[]" value="<?= $values['course'] ?>" /></td>
                                    <td><?= $values['department'] ?></td>
                                    <td><?= $values['session'] ?></td>
                                    <td><input type="text" name="ca[]" value="<?= $values['ca'] ?>" class="form-control input-sm" maxlength="3" size="3" /></td>
                                    <td><input type="text" name="exam[]" value="<?= $values['exam'] ?>" class="form-control input-sm" maxlength="3" size="3" /></td>
                                    <td><button class="btn btn-success btn-sm individual"><strong>Upload</strong></button></td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <p></p>
                            <form id="fileuploader" action="<?= $this->url->get('results/uploadAjax') ?>" method="POST" enctype="multipart/form-data">
                                <div class="fileupload-buttonbar" style="float:right">
                                        <button type="submit" id="submitResult" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> <strong>Submit</strong></button>
                                        
                                        <!-- The fileinput-button span is used to style the file input field as button -->
                                        <span class="btn btn-success fileinput-button btn-sm">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span class="addFile"><strong>Add | Browse Excel File</strong></span>
                                        <input type="file" name="files" id="files">
                                        </span>

                                        <!-- The global progress state -->
                                </div>
                            </form>
                        </div>
                    </section>
                
                <?php } else { ?>
                    <div class="alert alert-danger"><strong>No Carry Over Registration</strong></div>
                 <?php } ?>
    </div>
