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
            Změnit
            <small>Údaje</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-line-chart"></i> Domů</a></li>
            <li class="active">Změna údajů</li>
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
                        <h3 class="box-title">Změna údajů</h3>
                    </div>
                    <form role="form" action="<?php base_url('users/settings') ?>" method="post">
                        <div class="box-body">
                            <div class="text-red">
                                <?php echo validation_errors(); ?>
                            </div>
                            <div class="form-group">
                                <label for="username">Jméno</label>
                                <input type="text" class="form-control" id="username" name="username"
                                       placeholder="Jméno" value="<?php echo $user_data['username'] ?>"
                                       autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                       value="<?php echo $user_data['email'] ?>" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <div class="alert alert-info alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    Pokud nechcete změnit heslo, nechte následující pole volná
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">Heslo</label>
                                <input type="password" class="form-control" id="password" name="password"
                                       placeholder="Heslo" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="confPassword">Potvrzení hesla</label>
                                <input type="password" class="form-control" id="confPassword" name="confPassword"
                                       placeholder="Potvrzení hesla" autocomplete="off">
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Uložit změny</button>
                            <a href="<?php echo base_url('dashboard') ?>" class="btn btn-warning">Zpět</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#settingsNav").addClass('active');
    });

</script>