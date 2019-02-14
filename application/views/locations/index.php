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
            <small>Lokace</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-line-chart"></i> Domů</a></li>
            <li class="active">Lokace</li>
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
                <?php if (in_array('createLocation', $user_permission)): ?>
                    <a href="<?php echo base_url('locations/create') ?>" class="btn btn-primary">Přidat lokaci</a>
                    <br/> <br/>
                <?php endif; ?>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Spravovat lokace</h3>
                    </div>
                    <div class="box-body">
                        <table id="locationTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Název</th>
                                <th>Druh terénu</th>
                                <th>Skryté věci</th>
                                <th>Pasti</th>
                                <th>Další poznámky</th>
                                <?php if (in_array('updateLocation', $user_permission) || in_array('deleteLocation', $user_permission)): ?>
                                    <th>Akce</th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php if (in_array('deleteLocation', $user_permission)): ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="deleteModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Odstranit lokaci</h4>
                </div>
                <form role="form" action="<?php echo base_url('locations/delete') ?>" method="post" id="deleteForm">
                    <div class="modal-body">
                        <p>Opravdu chcete odstranit lokaci?</p>
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
    var locationTable;
    var base_url = "<?php echo base_url(); ?>";

    $(document).ready(function () {
        $("#mainLocNav").addClass('active');
        $("#manageLocNav").addClass('active');

        locationTable = $('#locationTable').DataTable({
            'ajax': base_url + 'locations/fetchLocationData',
            'order': []
        });

    });

    function deleteFunc(id) {
        if (id) {
            $("#deleteForm").on('submit', function () {
                var form = $(this);

                $(".text-danger").remove();

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: {location_id: id},
                    dataType: 'json',
                    success: function (response) {
                        locationTable.ajax.reload(null, false);

                        if (response.success === true) {
                            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + response.messages +
                                '</div>');
                            $("#deleteModal").modal('hide');
                        } else {
                            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + response.messages +
                                '</div>');
                        }
                    }
                });

                return false;
            });
        }
    }

</script>