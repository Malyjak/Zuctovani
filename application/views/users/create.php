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
            <small>Hráči</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-line-chart"></i> Domů</a></li>
            <li><a href="<?php echo base_url('users') ?>">Hráči</a></li>
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
                        <h3 class="box-title">Přidat hráče</h3>
                    </div>
                    <form role="form" action="<?php base_url('users/create') ?>" method="post">
                        <div class="box-body">
                            <div class="text-red">
                                <?php echo validation_errors(); ?>
                            </div>
                            <div class="form-group">
                                <label for="group">Oprávnění</label>
                                <select class="form-control" id="group" name="group" required>
                                    <?php foreach ($group_data as $k => $v): ?>
                                        <option value="<?php echo $v['id'] ?>" <?php if ($v['id'] == 3) {
                                            echo "selected='selected'";
                                        } ?>><?php echo $v['group_name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="username">Jméno</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Jméno"
                                       autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                       autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Heslo</label>
                                <input type="password" class="form-control" id="password" name="password"
                                       placeholder="Heslo" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="confPassword">Potvrzení hesla</label>
                                <input type="password" class="form-control" id="confPassword" name="confPassword"
                                       placeholder="Potvrzení hesla" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Přidat</button>
                            <a href="<?php echo base_url('users') ?>" class="btn btn-warning">Zpět</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#mainUserNav").addClass('active');
        $("#createUserNav").addClass('active');

    });

</script>