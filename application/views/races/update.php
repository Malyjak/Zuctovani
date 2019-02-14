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
            Upravit
            <small>Rasy</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-line-chart"></i> Domů</a></li>
            <li><a href="<?php echo base_url('races') ?>">Rasy</a></li>
            <li class="active">Upravit</li>
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
                        <h3 class="box-title">Upravit rasu</h3>
                    </div>
                    <form role="form" action="<?php base_url('races/update') ?>" method="post"
                          enctype="multipart/form-data">
                        <div class="box-body">
                            <?php echo validation_errors(); ?>
                            <?php
                            $link = $_SERVER['PHP_SELF'];
                            $link_array = explode('/', $link);
                            $race_id = end($link_array);
                            if ($race_id) {
                                $race_data = $this->model_races->getRaceData($race_id);
                            } ?>
                            <div class="form-group">
                                <label for="name">Název</label>
                                <input type="text" class="form-control" id="name" name="name"
                                       placeholder="Název" value="<?php echo $race_data['name']; ?>"
                                       autocomplete="off" required/>
                            </div>
                            <div class="form-group">
                                <label for="description">Detailní popis</label>
                                <textarea type="text" class="form-control" id="description" name="description"
                                          placeholder="Detailní popis" autocomplete="off">
                                        <?php echo $race_data['description']; ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Uložit změny</button>
                            <a href="<?php echo base_url('races') ?>" class="btn btn-warning">Zpět</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#description").wysihtml5();

        $("#mainRaceNav").addClass('active');
        $("#manageRaceNav").addClass('active');

    });
</script>