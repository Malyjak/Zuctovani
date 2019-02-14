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
            <small>Skupiny</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-line-chart"></i> Domů</a></li>
            <li><a href="<?php echo base_url('groups') ?>">Skupiny</a></li>
            <li class="active">Upravit</li>
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
                        <h3 class="box-title">Upravit skupinu</h3>
                    </div>
                    <form role="form" action="<?php base_url('groups/update') ?>" method="post">
                        <div class="box-body">
                            <?php echo validation_errors(); ?>
                            <div class="form-group">
                                <label for="group_name">Název skupiny</label>
                                <input type="text" class="form-control" id="group_name" name="group_name"
                                       placeholder="Název skupiny" value="<?php echo $group_data['group_name']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="permission">Oprávnění</label>
                                <?php $serialize_permission = unserialize($group_data['permission']); ?>
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
                                        <td><input type="checkbox" class="minimal" name="permission[]" id="permission"
                                                   class="minimal" value="createItem" <?php if ($serialize_permission) {
                                                if (in_array('createItem', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            } ?> ></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="updateItem" <?php
                                            if ($serialize_permission) {
                                                if (in_array('updateItem', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            }
                                            ?>></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="viewItem" <?php
                                            if ($serialize_permission) {
                                                if (in_array('viewItem', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            }
                                            ?>></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="deleteItem" <?php
                                            if ($serialize_permission) {
                                                if (in_array('deleteItem', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            }
                                            ?>></td>
                                    </tr>
                                    <tr>
                                        <td>NPC</td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="createNpc" <?php
                                            if ($serialize_permission) {
                                                if (in_array('createNpc', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            }
                                            ?>></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="updateNpc" <?php
                                            if ($serialize_permission) {
                                                if (in_array('updateNpc', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            }
                                            ?>></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="viewNpc" <?php
                                            if ($serialize_permission) {
                                                if (in_array('viewNpc', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            }
                                            ?>></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="deleteNpc" <?php
                                            if ($serialize_permission) {
                                                if (in_array('deleteNpc', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            }
                                            ?>></td>
                                    </tr>
                                    <tr>
                                        <td>Lokace</td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="createLocation" <?php if ($serialize_permission) {
                                                if (in_array('createLocation', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            } ?>></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="updateLocation" <?php if ($serialize_permission) {
                                                if (in_array('updateLocation', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            } ?>></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="viewLocation" <?php if ($serialize_permission) {
                                                if (in_array('viewLocation', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            } ?>></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="deleteLocation" <?php if ($serialize_permission) {
                                                if (in_array('deleteLocation', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            } ?>></td>
                                    </tr>
                                    <tr>
                                        <td>Hráči</td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="createUser" <?php if ($serialize_permission) {
                                                if (in_array('createUser', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            } ?>></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="updateUser" <?php if ($serialize_permission) {
                                                if (in_array('updateUser', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            } ?>></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="viewUser" <?php if ($serialize_permission) {
                                                if (in_array('viewUser', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            } ?>></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="deleteUser" <?php if ($serialize_permission) {
                                                if (in_array('deleteUser', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            } ?>></td>
                                    </tr>
                                    <tr>
                                        <td>Dovednosti</td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="createSkill" <?php if ($serialize_permission) {
                                                if (in_array('createSkill', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            } ?>></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="updateSkill" <?php if ($serialize_permission) {
                                                if (in_array('updateSkill', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            } ?>></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="viewSkill" <?php if ($serialize_permission) {
                                                if (in_array('viewSkill', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            } ?>></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="deleteSkill" <?php if ($serialize_permission) {
                                                if (in_array('deleteSkill', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            } ?>></td>
                                    </tr>
                                    <tr>
                                        <td>Rasy</td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="createRace" <?php if ($serialize_permission) {
                                                if (in_array('createRace', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            } ?>></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="updateRace" <?php if ($serialize_permission) {
                                                if (in_array('updateRace', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            } ?>></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="viewRace" <?php if ($serialize_permission) {
                                                if (in_array('viewRace', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            } ?>></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="deleteRace" <?php if ($serialize_permission) {
                                                if (in_array('deleteRace', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            } ?>></td>
                                    </tr>
                                    <tr>
                                        <td>Postava</td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="createCharacter" <?php if ($serialize_permission) {
                                                if (in_array('createCharacter', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            } ?>></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="updateCharacter" <?php if ($serialize_permission) {
                                                if (in_array('updateCharacter', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            } ?>></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="viewCharacter" <?php if ($serialize_permission) {
                                                if (in_array('viewCharacter', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            } ?>></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="deleteCharacter" <?php if ($serialize_permission) {
                                                if (in_array('deleteCharacter', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            } ?>></td>
                                    </tr>
                                    <tr>
                                        <td>Společníci/Zvířátka</td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="createCompanion" <?php if ($serialize_permission) {
                                                if (in_array('createCompanion', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            } ?>></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="updateCompanion" <?php if ($serialize_permission) {
                                                if (in_array('updateCompanion', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            } ?>></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="viewCompanion" <?php if ($serialize_permission) {
                                                if (in_array('viewCompanion', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            } ?>></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="deleteCompanion" <?php if ($serialize_permission) {
                                                if (in_array('deleteCompanion', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            } ?>></td>
                                    </tr>
                                    <tr>
                                        <td>Reporty</td>
                                        <td> -</td>
                                        <td> -</td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="viewReports" <?php if ($serialize_permission) {
                                                if (in_array('viewReports', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            } ?>></td>
                                        <td> -</td>
                                    </tr>
                                    <tr>
                                        <td>Změna údajů</td>
                                        <td>-</td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                                                   value="updateSettings" <?php if ($serialize_permission) {
                                                if (in_array('updateSettings', $serialize_permission)) {
                                                    echo "checked";
                                                }
                                            } ?>></td>
                                        <td> -</td>
                                        <td> -</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Uložit změny</button>
                            <a href="<?php echo base_url('groups') ?>" class="btn btn-warning">Zpět</a>
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
        $("#manageGroupNav").addClass('active');

        $('input[type="checkbox"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
    });

</script>
