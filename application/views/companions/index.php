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
            Spravovat
            <small>Společníci</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-line-chart"></i> Domů</a></li>
            <li class="active">Společníci</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div id="messages"></div>
                <?php
                $pile_data = $this->model_piles->getPileData($user_id);
                if ($pile_data === null) {
                    $response = array();
                    $data = array(
                        'user_id' => $user_id,
                        'text' => "",
                    );
                    $create = $this->model_piles->create($data, $user_id);
                    if ($create == true) {
                        $pile_data = $this->model_piles->getPileData($user_id);
                    }
                }
                ?>
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
                <?php if (in_array('createCompanion', $user_permission)): ?>
                    <a href="<?php echo base_url('companions/create') ?>" class="btn btn-primary">Přidat Společníka</a>
                    <br/> <br/>
                <?php endif; ?>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Spravovat Společníky</h3>
                    </div>
                    <div class="box-body">
                        <table id="compTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Jméno</th>
                                <th>Kouzla/Specializace</th>
                                <th>Dovednosti</th>
                                <th>Inventář</th>
                                <th>x</th>
                                <?php if (in_array('updateCompanion', $user_permission) || in_array('deleteCompanion', $user_permission)): ?>
                                    <th>Akce</th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                        </table>
                        <br>
                        <br>
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>Společný inventář/Odkladiště/Poznámky</h3>
                                <div id="pileList">
                                    <h4><?php echo $pile_data['text']; ?></h4>
                                </div>
                            </div>
                            <div class="icon">
                                <i class="ion ion-paper-airplane"></i>
                            </div>
                            <a class="small-box-footer" data-toggle="modal"
                               data-target="#editPileModal">Upravit
                                <i class="fa fa-pencil"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="editPileModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Upravit</h4>
            </div>
            <form role="form" action="<?php echo base_url('companions/updatePile') ?>" method="post"
                  id="editPileForm">

                <div class="modal-body" id="pileListEdit">
                    <div class="form-group">
                        <label for="pile">Společný inventář/Odkladiště/Poznámky</label>
                        <textarea type="text" class="form-control" id="pile" name="pile"
                                  placeholder="<?php echo $pile_data['text']; ?>" autocomplete="off" required>
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

<?php if (in_array('deleteCompanion', $user_permission)): ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="deleteModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Odstranit Společníka</h4>
                </div>
                <form role="form" action="<?php echo base_url('companions/delete') ?>" method="post" id="deleteForm">
                    <div class="modal-body">
                        <p>Opravdu chcete odstranit Společníka?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Zrušit</button>
                        <button type="submit" class="btn btn-primary">Odstranit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<script type="text/javascript">
    var compTable;
    var base_url = "<?php echo base_url(); ?>";

    $(document).ready(function () {
        $("#pile").wysihtml5();

        $("#mainCompNav").addClass('active');
        $("#manageCompNav").addClass('active');

        compTable = $('#compTable').DataTable({
            'ajax': base_url + 'companions/fetchCompData',
            'order': []
        });

        $('#editPileForm').submit(function () {
            var form = $(this);

            $(".text-danger").remove();

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: form.serialize(),
                dataType: 'json',
                success: function (response) {
                    $("#pileList").load(location.href + " #pileList");
                    $("#pileListEdit").load(location.href + " #pileListEdit");

                    if (response.success === true) {
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                            response.messages + '</div>');
                        $('#editPileModal').on('hidden.bs.modal', function () {
                            $('.wysihtml5-sandbox, .wysihtml5-toolbar').remove();
                            $('#pile').show();
                            $('#pile').wysihtml5();
                        });
                        $("#editPileModal").modal('hide');

                        $("#editPileForm")[0].reset();
                        $("#editPileForm .form-group").removeClass('has-error').removeClass('has-success');
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

    function addQtyFunc(id) {
        if (id) {
            $.ajax({
                url: base_url + 'companions/addQty',
                type: 'POST',
                data: {comp_id: id},
                dataType: 'json',
                success: function (response) {
                    compTable.ajax.reload(null, false);
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

    function removeQtyFunc(id) {
        if (id) {
            $.ajax({
                url: base_url + 'companions/removeQty',
                type: 'POST',
                data: {comp_id: id},
                dataType: 'json',
                success: function (response) {
                    compTable.ajax.reload(null, false);
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

    function deleteFunc(id) {
        if (id) {
            $("#deleteForm").on('submit', function () {
                var form = $(this);

                $(".text-danger").remove();

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: {comp_id: id},
                    dataType: 'json',
                    success: function (response) {
                        compTable.ajax.reload(null, false);

                        if (response.success === true) {
                            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + response.messages +
                                '</div>');
                        } else {
                            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + response.messages +
                                '</div>');
                        }
                        $("#deleteModal").modal('hide');
                    }
                });

                return false;
            });
        }
    }

</script>