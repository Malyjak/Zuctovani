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
            <small>Předměty</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-line-chart"></i> Domů</a></li>
            <li><a href="<?php echo base_url('items') ?>">Předměty</a></li>
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
                        <h3 class="box-title">Přidat předmět</h3>
                    </div>
                    <form role="form" action="<?php base_url('items/create') ?>" method="post"
                          enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="validation-error">
                                <?php echo validation_errors(); ?>
                            </div>
                            <div class="form-group">
                                <label for="name">Název</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Název"
                                       autocomplete="off" required/>
                            </div>
                            <div class="form-group">
                                <label for="quality">Kvalita</label>
                                <select class="form-control " id="quality" name="quality">
                                    <option value="1">Špatná</option>
                                    <option value="2">Průměrná</option>
                                    <option value="3">Mistrovská</option>
                                    <option value="4">Artefakt/Legendární</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="category">Účel</label>
                                <select class="form-control" id="purpose" name="purpose">
                                    <option value="1">Výstroj</option>
                                    <option value="2">Nástroje</option>
                                    <option value="3">Použitelné</option>
                                    <option value="4">Ostatní</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="type">Typ</label>
                                <select class="form-control" id="type" name="type">
                                    <option value="1">Běžný</option>
                                    <option value="2">Lehký/Rychlý</option>
                                    <option value="3">Těžký</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">Detailní popis</label>
                                <textarea type="text" class="form-control" id="description" name="description"
                                          placeholder="Detailní popis" autocomplete="off">
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="store">Dostupné hráčům</label>
                                <select class="form-control" id="availability" name="availability">
                                    <option value="1">Ano</option>
                                    <option value="0">Ne</option>
                                </select>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Přidat</button>
                            <a href="<?php echo base_url('items') ?>" class="btn btn-warning">Zpět</a>
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

        $("#mainItemNav").addClass('active');
        $("#addItemNav").addClass('active');

    });

</script>