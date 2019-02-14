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
            <small>Předměty</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-line-chart"></i> Domů</a></li>
            <li><a href="<?php echo base_url('items') ?>">Předměty</a></li>
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
                        <h3 class="box-title">Upravit předmět</h3>
                    </div>
                    <form role="form" action="<?php base_url('users/update') ?>" method="post"
                          enctype="multipart/form-data">
                        <div class="box-body">
                            <?php echo validation_errors(); ?>
                            <?php
                            $link = $_SERVER['PHP_SELF'];
                            $link_array = explode('/', $link);
                            $item_id = end($link_array);
                            if ($item_id) {
                                $item_data = $this->model_items->getItemData($item_id);
                            } ?>
                            <div class="form-group">
                                <label for="product_name">Název</label>
                                <input type="text" class="form-control" id="name" name="name"
                                       placeholder="Název" value="<?php echo $item_data['name']; ?>"
                                       autocomplete="off" required/>
                            </div>
                            <div class="form-group">
                                <label for="store">Kvalita</label>
                                <select class="form-control" id="quality" name="quality">
                                    <option value="1" <?php if ($item_data['quality'] == 1) {
                                        echo "selected='selected'";
                                    } ?>>Špatná
                                    </option>
                                    <option value="2" <?php if ($item_data['quality'] == 2) {
                                        echo "selected='selected'";
                                    } ?>>Průměrná
                                    </option>
                                    </option>
                                    <option value="3" <?php if ($item_data['quality'] == 3) {
                                        echo "selected='selected'";
                                    } ?>>Mistrovská
                                    </option>
                                    </option>
                                    <option value="4" <?php if ($item_data['quality'] == 4) {
                                        echo "selected='selected'";
                                    } ?>>Artefakt/Legendární
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="store">Účel</label>
                                <select class="form-control" id="purpose" name="purpose">
                                    <option value="1" <?php if ($item_data['purpose'] == 1) {
                                        echo "selected='selected'";
                                    } ?>>Výstroj
                                    </option>
                                    <option value="2" <?php if ($item_data['purpose'] == 2) {
                                        echo "selected='selected'";
                                    } ?>>Nástroje
                                    </option>
                                    </option>
                                    <option value="3" <?php if ($item_data['purpose'] == 3) {
                                        echo "selected='selected'";
                                    } ?>>Použitelné
                                    </option>
                                    </option>
                                    <option value="4" <?php if ($item_data['purpose'] == 4) {
                                        echo "selected='selected'";
                                    } ?>>Ostatní
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="store">Typ</label>
                                <select class="form-control" id="type" name="type">
                                    <option value="1" <?php if ($item_data['type'] == 1) {
                                        echo "selected='selected'";
                                    } ?>>Běžný
                                    </option>
                                    <option value="2" <?php if ($item_data['type'] == 2) {
                                        echo "selected='selected'";
                                    } ?>>Lehký/Rychlý
                                    </option>
                                    </option>
                                    <option value="3" <?php if ($item_data['type'] == 3) {
                                        echo "selected='selected'";
                                    } ?>>Těžký
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">Detailní popis</label>
                                <textarea type="text" class="form-control" id="description" name="description"
                                          placeholder="Detailní popis" autocomplete="off">
                                        <?php echo $item_data['description']; ?>
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="store">Dostupné hráčům</label>
                                <select class="form-control" id="availability" name="availability">
                                    <option value="1" <?php if ($item_data['availability'] == 1) {
                                        echo "selected='selected'";
                                    } ?>>Ano
                                    </option>
                                    <option value="0" <?php if ($item_data['availability'] != 1) {
                                        echo "selected='selected'";
                                    } ?>>Ne
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Uložit změny</button>
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
        $("#manageItemNav").addClass('active');

    });

</script>