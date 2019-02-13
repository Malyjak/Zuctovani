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
            <small>Skupiny</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard/') ?>"><i class="fa fa-line-chart"></i> Domů</a></li>
            <li><a href="<?php echo base_url('groups/') ?>">Skupiny</a></li>
            <li class="active">Přidat</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12 col-xs-12">
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
                        <h3 class="box-title">Přidat skupinu</h3>
                    </div>
                    <form role="form" action="<?php base_url('groups/create') ?>" method="post">
                        <div class="box-body">
                            <?php echo validation_errors(); ?>
                            <div class="form-group">
                                <label for="group_name">Název skupiny</label>
                                <input type="text" class="form-control" id="group_name" name="group_name"
                                       placeholder="Název skupiny" required>
                            </div>
                            <div class="form-group">
                                <label for="permission">Oprávnění</label>
                                <table class="table table-responsive">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Vytvořit</th>
                                        <th>Měnit</th>
                                        <th>Zobrazit</th>
                                        <th>Smazat</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Předměty</td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                   value="createItem" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                   value="updateItem" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="viewItem"
                                                   class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                   value="deleteItem" class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>NPC</td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="createNpc"
                                                   class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="updateNpc"
                                                   class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="viewNpc"
                                                   class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteNpc"
                                                   class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>Lokace</td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                   value="createLocation" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                   value="updateLocation" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                   value="viewLocation" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                   value="deleteLocation" class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>Hráči</td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                   value="createUser" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                   value="updateUser" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="viewUser"
                                                   class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                   value="deleteUser" class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>Dovednosti</td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                   value="createSkill" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                   value="updateSkill" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="viewSkill"
                                                   class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                   value="deleteSkill" class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>Rasy</td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                   value="createRace" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                   value="updateRace" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="viewRace"
                                                   class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                   value="deleteRace" class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>Postava</td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                   value="createCharacter" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                   value="updateCharacter" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                   value="viewCharacter" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                   value="deleteCharacter" class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>Společníci/Zvířátka</td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                   value="createCompanion" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                   value="updateCompanion" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                   value="viewCompanion" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                   value="deleteCompanion" class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>Reporty</td>
                                        <td> -</td>
                                        <td> -</td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                   value="viewReports" class="minimal"></td>
                                        <td> -</td>
                                    </tr>
                                    <tr>
                                        <td>Změna údajů</td>
                                        <td> -</td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                   value="updateSettings" class="minimal"></td>
                                        <td> -</td>
                                        <td> -</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Přidat</button>
                            <a href="<?php echo base_url('groups/') ?>" class="btn btn-warning">Zpět</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#mainGroupNav").addClass('active');
        $("#addGroupNav").addClass('active');

        $('input[type="checkbox"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
    });

</script>