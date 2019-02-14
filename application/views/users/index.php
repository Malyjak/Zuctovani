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
            <small>Hráči</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-line-chart"></i> Domů</a></li>
            <li class="active">Hráči</li>
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
                <?php if (in_array('createUser', $user_permission)): ?>
                    <a href="<?php echo base_url('users/create') ?>" class="btn btn-primary">Přidat hráče</a>
                    <br/> <br/>
                <?php endif; ?>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Spravovat hráče</h3>
                    </div>
                    <div class="box-body">
                        <table id="userTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Jméno</th>
                                <th>Email</th>
                                <th>Oprávnění</th>
                                <?php if (in_array('updateUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
                                    <th>Akce</th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($user_data): ?>
                                <?php foreach ($user_data as $k => $v): ?>
                                    <tr>
                                        <td><?php echo $v['user_info']['username']; ?></td>
                                        <td><?php echo $v['user_info']['email']; ?></td>
                                        <td><?php echo $v['user_group']['group_name']; ?></td>
                                        <?php if (in_array('updateUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
                                            <td>
                                                <?php if (in_array('updateUser', $user_permission)): ?>
                                                    <a href="<?php echo base_url('users/update/' . $v['user_info']['id']) ?>"
                                                       class="btn btn-default"><i class="fa fa-edit"></i></a>
                                                <?php endif; ?>
                                                <?php if (in_array('deleteUser', $user_permission)): ?>
                                                    <a href="<?php echo base_url('users/delete/' . $v['user_info']['id']) ?>"
                                                       class="btn btn-default"><i class="fa fa-trash"></i></a>
                                                <?php endif; ?>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#userTable').DataTable();

        $("#mainUserNav").addClass('active');
        $("#manageUserNav").addClass('active');
    });

</script>