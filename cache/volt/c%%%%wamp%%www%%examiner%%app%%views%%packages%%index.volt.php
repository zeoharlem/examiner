
    <?php if (isset($courseList)) { ?>
    <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    <strong>Create Session Package</strong>
                    <select name="semester" id="semester">
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                    <select name="session" id="session">
                        <?= $selectSession ?>
                    </select>
                    <span class="tools pull-right">
                        <a href="javascript:;" class="fa fa-chevron-down"></a>
                        <a href="javascript:;" class="fa fa-cog"></a>
                        <a href="javascript:;" class="fa fa-times"></a>
                     </span>
                </header>
                <div class="panel-body">
                <form id="packageform" role="form">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th><input type="checkbox" id="checkbox" /></th>
                            <th>Courses Description</th>
                            <th>Course Code</th>
                            <th>Units</th>
                            <th>Status</th>
                            <th>Department</th>
                            <th>Semester</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($courseList as $keys => $values) { ?>
                        <tr>
                            <td><input type="checkbox" name="checkboxId[]" value=<?= $values->c_id ?> class="checkboxFlow" /></td>
                            <td><?= Phalcon\Text::upper($values->title) ?></td>
                            <td><?= Phalcon\Text::upper($values->code) ?></td>
                            <td><?= $values->units ?></td>
                            <td><?= $values->status ?></td>
                            <td><?= ucwords($values->department) ?></td>
                            <td><?php if ($values->semester == 1) { ?>1<?php } else { ?>2<?php } ?></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <button type="button" id="startPackage" class="btn btn-lg btn-default"><strong>Start Package</strong></button>
                    </form>
                </div>
            </section>
        </div>
    <?php } ?>
