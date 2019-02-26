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
            Zobrazit
            <small>Společníci</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-line-chart"></i> Domů</a></li>
            <li><a href="<?php echo base_url('companions') ?>">Společníci</a></li>
            <li class="active">Zobrazit</li>
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
                    <form role="form" action="<?php base_url('npcs/view') ?>" method="post"
                          enctype="multipart/form-data">
                        <div class="box-body">
                            <?php echo validation_errors(); ?>
                            <?php
                            $link = $_SERVER['PHP_SELF'];
                            $link_array = explode('/', $link);
                            $comp_id = end($link_array);
                            if ($comp_id) {
                                $comp_data = $this->model_companions->getCompDataById($comp_id);

                                $skills = $this->model_skills->getSkillData();
                                $items = $this->model_items->getPlayerItemData();

                                $skills_comp = $comp_data['skills'];
                            }
                            ?>
                            <div class="row">
                                <div class="col-lg-6 col-xs-6">
                                    <div class="small-box bg-aqua">
                                        <div class="inner" id="nameList">
                                            <h3><?php echo $comp_data['name']; ?></h3>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-social-freebsd-devil"></i>
                                        </div>
                                        <a class="small-box-footer" data-toggle="modal" data-target="#editNameModal">Upravit
                                            <i class="fa fa-pencil"></i></a>
                                    </div>
                                    <div class="small-box bg-red">
                                        <div class="inner" id="hpList">
                                            <h3>HP: <?php echo $comp_data['hp'] . "/" . $comp_data['hp_max']; ?></h3>
                                            <h4>MP: <?php echo $comp_data['mp'] . "/" . $comp_data['mp_max']; ?></h4>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-arrow-graph-up-right"></i>
                                        </div>
                                        <a class="small-box-footer" data-toggle="modal" data-target="#editHpModal">Upravit
                                            <i class="fa fa-pencil"></i></a>
                                    </div>
                                    <div class="small-box bg-blue">
                                        <div class="inner">
                                            <h3>Kouzla/Specializace</h3>
                                            <div id="magicList">
                                                <h4><?php echo $comp_data['magic']; ?></h4>
                                            </div>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-wand"></i>
                                        </div>
                                        <a class="small-box-footer" data-toggle="modal" data-target="#editMagicModal">Upravit
                                            <i class="fa fa-pencil"></i></a>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xs-6">
                                    <h3>Dovednosti</h3>
                                    <a class="btn btn-primary" data-toggle="modal" data-target="#addSkillModal"><i
                                                class="fa fa-plus"></i> Přidat dovednost</a>
                                    <br/> <br/>
                                    <table id="skillsTable" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Název</th>
                                            <th>Kostky (lvl)</th>
                                            <th>Atribut</th>
                                            <th>Detailní popis</th>
                                            <th>Akce</th>
                                        </tr>
                                        </thead>
                                    </table>
                                    <h3>Inventář</h3>
                                    <a class="btn btn-primary" data-toggle="modal" data-target="#addItemModal"><i
                                                class="fa fa-plus"></i> Přidat předmět</a>
                                    <br/> <br/>
                                    <table id="itemsTable" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Název</th>
                                            <th>Kvalita</th>
                                            <th>Účel</th>
                                            <th>Typ</th>
                                            <th>Popis</th>
                                            <th>x</th>
                                            <th>Akce</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="box-footer">
                                <a href="<?php echo base_url('companions') ?>" class="btn btn-success">Zpět na přehled
                                    NPC</a>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="editNameModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Upravit</h4>
            </div>
            <form role="form" action="<?php echo base_url('companions/updateName/') . $comp_id ?>" method="post"
                  id="editNameForm">
                <div class="modal-body" id="nameListEdit">
                    <div class="form-group">
                        <label for="name">Jméno</label>
                        <input type="text" class="form-control" id="name" name="name"
                               value="<?php echo $comp_data['name']; ?>" autocomplete="off" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zpět</button>
                    <button type="submit" class="btn btn-primary">Uložit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="editHpModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Upravit</h4>
            </div>
            <form role="form" action="<?php echo base_url('companions/updateHp/') . $comp_id ?>" method="post"
                  id="editHpForm">
                <div class="modal-body" id="hpListEdit">
                    <div class="row">
                        <div class="col-lg-6 col-xs-6">
                            <div class="form-group">
                                <label for="hp">HP</label>
                                <input type="number" class="form-control" id="hp" name="hp"
                                       value="<?php echo $comp_data['hp']; ?>" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="mp">MP</label>
                                <input type="number" class="form-control" id="mp" name="mp"
                                       value="<?php echo $comp_data['mp']; ?>" autocomplete="nope" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-6">
                            <div class="form-group">
                                <label for="hp_max">Max HP</label>
                                <input type="number" class="form-control" id="hp_max" name="hp_max"
                                       value="<?php echo $comp_data['hp_max']; ?>" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="mp_max">Max MP</label>
                                <input type="number" class="form-control" id="mp_max" name="mp_max"
                                       value="<?php echo $comp_data['mp_max']; ?>" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zpět</button>
                    <button type="submit" class="btn btn-primary">Uložit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="editMagicModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Upravit</h4>
            </div>
            <form role="form" action="<?php echo base_url('companions/updateMagic/') . $comp_id ?>" method="post"
                  id="editMagicForm">

                <div class="modal-body" id="magicListEdit">
                    <div class="form-group">
                        <label for="magic">Kouzla/Specializace</label>
                        <textarea type="text" class="form-control" id="magic" name="magic"
                                  placeholder="<?php echo $comp_data['magic']; ?>" autocomplete="off" required>
                                </textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zpět</button>
                    <button type="submit" class="btn btn-primary">Uložit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="addSkillModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Upravit</h4>
            </div>
            <form role="form" action="<?php echo base_url('companions/addSkill/') . $comp_id ?>" method="post"
                  id="addSkillForm">
                <div class="modal-body">
                    <div class="form-group" id="skillList">
                        <label for="skill">Dovednost</label>
                        <select class="form-control select_group" id="skill" name="skill" required>
                            <?php $ids = array();
                            $uskills = unserialize($skills_comp);
                            foreach ($skills as $k => $v):
                                if (!in_array($v['id'], $uskills)) {
                                    ?>
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
                                    }
                                } ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zpět</button>
                    <button type="submit" class="btn btn-primary">Uložit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="removeSkillModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Odstranit dovednost</h4>
            </div>
            <form role="form" action="<?php echo base_url('companions/removeSkill/') . $comp_id ?>" method="post"
                  id="removeSkillForm">
                <div class="modal-body">
                    <p>Opravdu chcete odstranit dovednost?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zrušit</button>
                    <button type="submit" class="btn btn-primary">Odstranit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="addItemModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Upravit</h4>
            </div>
            <form role="form" action="<?php echo base_url('companions/addItem/') . $comp_id ?>" method="post"
                  id="addItemForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="item">Předmět</label>
                        <select class="form-control select_group" id="item" name="item" required>
                            <?php $ids = array();
                            foreach ($items as $k => $v):
                                ?>
                                <option value="<?php echo $v['id'] ?>"><?php echo $v['name'];
                                    switch ($v['quality']) {
                                        case 1:
                                            echo " - Špatná";
                                            break;
                                        case 2:
                                            echo " - Průměrná";
                                            break;
                                        case 3:
                                            echo " - Mistrovská";
                                            break;
                                        case 4:
                                            echo " - Artefakt/Legendární";
                                            break;
                                    }
                                    ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zpět</button>
                    <button type="submit" class="btn btn-primary">Uložit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="removeItemModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Odstranit předmět</h4>
            </div>
            <form role="form" action="<?php echo base_url('companions/removeItem/') . $comp_id ?>" method="post"
                  id="removeItemForm">
                <div class="modal-body">
                    <p>Opravdu chcete odstranit předmět?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zrušit</button>
                    <button type="submit" class="btn btn-primary">Odstranit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    var skillsTable;
    var itemsTable;
    var base_url = "<?php echo base_url(); ?>";
    var comp_id = "<?php $link = $_SERVER['PHP_SELF'];
        $link_array = explode('/', $link);
        echo end($link_array); ?>"

    $(document).ready(function () {
        $("#magic").wysihtml5();

        $("#mainCompNav").addClass('active');
        $("#manageCompNav").addClass('active');

        skillsTable = $('#skillsTable').DataTable({
            'ajax': base_url + 'companions/fetchSkillsData/' + comp_id,
            'order': []
        });

        itemsTable = $('#itemsTable').DataTable({
            'ajax': base_url + 'companions/fetchItemsData/' + comp_id,
            'order': []
        });

        $('#editNameForm').submit(function () {
            var form = $(this);

            $(".text-danger").remove();

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: form.serialize(),
                dataType: 'json',
                success: function (response) {
                    $("#nameList").load(location.href + " #nameList");
                    $("#nameListEdit").load(location.href + " #nameListEdit");

                    if (response.success === true) {
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                            response.messages + '</div>');
                        $("#editNameModal").modal('hide');
                        $("#editNameForm")[0].reset();
                        $("#editNameForm .form-group").removeClass('has-error').removeClass('has-success');
                    } else {
                        if (response.messages instanceof Object) {
                            $.each(response.messages, function (index, value) {
                                var id = $("#" + index);

                                id.closest('.form-group')
                                    .removeClass('has-error')
                                    .removeClass('has-success')
                                    .addClass(value.length > 0 ? 'has-error' : 'has-success');

                                id.after(value);
                            });
                        } else {
                            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                +response.messages + '</div>');
                        }
                    }
                }
            });

            return false;
        });

        $('#editHpForm').submit(function () {
            var form = $(this);

            $(".text-danger").remove();

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: form.serialize(),
                dataType: 'json',
                success: function (response) {
                    $("#hpList").load(location.href + " #hpList");
                    $("#hpListEdit").load(location.href + " #hpListEdit");

                    if (response.success === true) {
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                            response.messages + '</div>');
                        $("#editHpModal").modal('hide');
                        $("#editHpForm")[0].reset();
                        $("#editHpForm .form-group").removeClass('has-error').removeClass('has-success');
                    } else {
                        if (response.messages instanceof Object) {
                            $.each(response.messages, function (index, value) {
                                var id = $("#" + index);

                                id.closest('.form-group')
                                    .removeClass('has-error')
                                    .removeClass('has-success')
                                    .addClass(value.length > 0 ? 'has-error' : 'has-success');

                                id.after(value);
                            });
                        } else {
                            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                +response.messages + '</div>');
                        }
                    }
                }
            });

            return false;
        });

        $('#editMagicForm').submit(function () {
            var form = $(this);

            $(".text-danger").remove();

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: form.serialize(),
                dataType: 'json',
                success: function (response) {
                    $("#magicList").load(location.href + " #magicList");
                    $("#magicListEdit").load(location.href + " #magicListEdit");

                    if (response.success === true) {
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                            response.messages + '</div>');
                        $('#editMagicModal').on('hidden.bs.modal', function () {
                            $('.wysihtml5-sandbox, .wysihtml5-toolbar').remove();
                            $('#magic').show();
                            $('#magic').wysihtml5();
                        });
                        $("#editMagicModal").modal('hide');

                        $("#editMagicForm")[0].reset();
                        $("#editMagicForm .form-group").removeClass('has-error').removeClass('has-success');
                    } else {
                        if (response.messages instanceof Object) {
                            $.each(response.messages, function (index, value) {
                                var id = $("#" + index);

                                id.closest('.form-group')
                                    .removeClass('has-error')
                                    .removeClass('has-success')
                                    .addClass(value.length > 0 ? 'has-error' : 'has-success');

                                id.after(value);
                            });
                        } else {
                            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                +response.messages + '</div>');
                        }
                    }
                }
            });

            return false;
        });

        $('#addSkillForm').submit(function () {
            var form = $(this);

            $(".text-danger").remove();

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: form.serialize(),
                dataType: 'json',
                success: function (response) {
                    $("#skillList").load(location.href + " #skillList");
                    skillsTable.ajax.reload(null, false);

                    if (response.success === true) {
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                            response.messages + '</div>');
                        $("#addSkillModal").modal('hide');

                        $("#addSkillForm")[0].reset();
                        $("#addSkillForm .form-group").removeClass('has-error').removeClass('has-success');
                    } else {
                        if (response.messages instanceof Object) {
                            $.each(response.messages, function (index, value) {
                                var id = $("#" + index);

                                id.closest('.form-group')
                                    .removeClass('has-error')
                                    .removeClass('has-success')
                                    .addClass(value.length > 0 ? 'has-error' : 'has-success');

                                id.after(value);
                            });
                        } else {
                            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                +response.messages + '</div>');
                        }
                    }
                }
            });

            return false;
        });

        $('#addItemForm').submit(function () {
            var form = $(this);

            $(".text-danger").remove();

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: form.serialize(),
                dataType: 'json',
                success: function (response) {
                    itemsTable.ajax.reload(null, false);

                    if (response.success === true) {
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                            response.messages + '</div>');
                        $("#addItemModal").modal('hide');

                        $("#addItemForm")[0].reset();
                        $("#addItemForm .form-group").removeClass('has-error').removeClass('has-success');
                    } else {
                        if (response.messages instanceof Object) {
                            $.each(response.messages, function (index, value) {
                                var id = $("#" + index);

                                id.closest('.form-group')
                                    .removeClass('has-error')
                                    .removeClass('has-success')
                                    .addClass(value.length > 0 ? 'has-error' : 'has-success');

                                id.after(value);
                            });
                        } else {
                            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                +response.messages + '</div>');
                        }
                    }
                }
            });

            return false;
        });

    });

    function addSkillLvlFunc(id) {
        if (id) {
            $.ajax({
                url: base_url + 'companions/addSkillLvl/' + comp_id,
                type: 'POST',
                data: {skill_pos: id},
                dataType: 'json',
                success: function (response) {
                    skillsTable.ajax.reload(null, false);
                    if (response.success === true) {
                    } else {
                        $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + response.messages +
                            '</div>');
                    }
                }
            });
        }
    }

    function removeSkillLvlFunc(id) {
        if (id) {
            $.ajax({
                url: base_url + 'companions/removeSkillLvl/' + comp_id,
                type: 'POST',
                data: {skill_pos: id},
                dataType: 'json',
                success: function (response) {
                    skillsTable.ajax.reload(null, false);
                    if (response.success === true) {
                    } else {
                        $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + response.messages +
                            '</div>');
                    }
                }
            });
        }
    }

    function removeSkillFunc(id) {
        if (id) {
            $("#removeSkillForm").on('submit', function () {
                var form = $(this);

                $(".text-danger").remove();

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: {skill_id: id},
                    dataType: 'json',
                    success: function (response) {
                        $("#skillList").load(location.href + " #skillList");
                        skillsTable.ajax.reload(null, false);

                        if (response.success === true) {
                            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + response.messages +
                                '</div>');
                        } else {
                            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + response.messages +
                                '</div>');
                        }
                        $("#removeSkillModal").modal('hide');
                    }
                });

                return false;
            });
        }
    }

    function addItemQtyFunc(id) {
        if (id) {
            $.ajax({
                url: base_url + 'companions/addItemQty/' + comp_id,
                type: 'POST',
                data: {item_pos: id},
                dataType: 'json',
                success: function (response) {
                    itemsTable.ajax.reload(null, false);
                    if (response.success === true) {
                    } else {
                        $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + response.messages +
                            '</div>');
                    }
                }
            });
        }
    }

    function removeItemQtyFunc(id) {
        if (id) {
            $.ajax({
                url: base_url + 'companions/removeItemQty/' + comp_id,
                type: 'POST',
                data: {item_pos: id},
                dataType: 'json',
                success: function (response) {
                    itemsTable.ajax.reload(null, false);
                    if (response.success === true) {
                    } else {
                        $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + response.messages +
                            '</div>');
                    }
                }
            });
        }
    }

    function removeItemFunc(id) {
        if (id) {
            $("#removeItemForm").on('submit', function () {
                var form = $(this);

                $(".text-danger").remove();

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: {item_id: id},
                    dataType: 'json',
                    success: function (response) {
                        itemsTable.ajax.reload(null, false);
                        if (response.success === true) {
                            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + response.messages +
                                '</div>');
                        } else {
                            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + response.messages +
                                '</div>');
                        }
                        $("#removeItemModal").modal('hide');
                    }
                });

                return false;
            });
        }
    }

</script>