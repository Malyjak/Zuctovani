<!--
This file is part of Zuctovani.

Zuctovani is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Zuctovani is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Zuctovani.  If not, see <https://www.gnu.org/licenses/>.
-->

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Přidat
            <small>Společníci</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-line-chart"></i> Domů</a></li>
            <li><a href="<?php echo base_url('companions') ?>">Společníci</a></li>
            <li class="active">Přidat</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div id="messages"></div>
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                <?php elseif ($this->session->flashdata('error')): ?>
                    <div class="alert alert-error alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Přidat společníka</h3>
                    </div>
                    <form role="form" action="<?php base_url('companions/create') ?>" method="post"
                          enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="validation-error">
                                <?php echo validation_errors(); ?>
                            </div>
                            <div class="form-group">
                                <label for="name">Jméno</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Jméno"
                                       autocomplete="off" required/>
                            </div>
                            <div class="form-group">
                                <label for="magic">Kouzla/Specializace</label>
                                <textarea type="text" class="form-control" id="magic" name="magic"
                                          placeholder="Kouzla/Specializace" autocomplete="off">
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="skills">Dovednosti</label>
                                <select class="form-control select_group" id="skills" name="skills[]"
                                        multiple="multiple">
                                    <?php foreach ($skills as $k => $v): ?>
                                        <option value="<?php echo $v['id'] ?>"><?php echo $v['name'];
                                            switch ($v['attribute']) {
                                                case 1:
                                                    echo " - Kondice";
                                                    break;
                                                case 2:
                                                    echo " - Mysl";
                                                    break;
                                                case 3:
                                                    echo " - Působivost";
                                                    break;
                                            } ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inventory">Inventář</label>
                                <select class="form-control select_group" id="inventory" name="inventory[]"
                                        multiple="multiple">
                                    <?php foreach ($items as $k => $v): ?>
                                        <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Přidat</button>
                            <a href="<?php echo base_url('companions') ?>" class="btn btn-warning">Zpět</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $(".select_group").select2();
        $("#magic").wysihtml5();

        $("#mainCompNav").addClass('active');
        $("#addCompNav").addClass('active');

    });

</script>