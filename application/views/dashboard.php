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
            Přehledy
            <small>Kontrolní panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href=""<?php echo base_url('dashboard/') ?>""><i class="fa fa-line-chart"></i> Domů</a></li>
            <li class="active">Přehledy</li>
        </ol>
    </section>
    <section class="content">
        <?php if ($is_admin || $is_storyteller) { ?>
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-aqua-gradient">
                        <div class="inner">
                            <h3><?php echo $total_items ?></h3>
                            <p>Celkově předmětů</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-nutrition"></i>
                        </div>
                        <a href="<?php echo base_url('items') ?>" class="small-box-footer">Více informací <i
                                    class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green-gradient">
                        <div class="inner">
                            <h3><?php echo $total_npcs ?></h3>
                            <p>Celkově NPC</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-social-freebsd-devil"></i>
                        </div>
                        <a href="<?php echo base_url('npcs') ?>" class="small-box-footer">Více informací <i
                                    class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-red-gradient">
                        <div class="inner">
                            <h3><?php echo $total_locations ?></h3>
                            <p>Celkově lokací</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-home"></i>
                        </div>
                        <a href="<?php echo base_url('locations') ?>" class="small-box-footer">Více informací <i
                                    class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-yellow-gradient">
                        <div class="inner">
                            <h3><?php echo $total_users ?></h3>
                            <p>Celkově hráčů</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-people"></i>
                        </div>
                        <a href="<?php echo base_url('users') ?>" class="small-box-footer">Více informací <i
                                    class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?php echo $total_skills ?></h3>
                            <p>Celkově dovedností</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bonfire"></i>
                        </div>
                        <a href="<?php echo base_url('skills') ?>" class="small-box-footer">Více informací <i
                                    class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3><?php echo $total_races ?></h3>
                            <p>Celkově ras</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-earth"></i>
                        </div>
                        <a href="<?php echo base_url('races') ?>" class="small-box-footer">Více informací <i
                                    class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3><?php echo $total_characters ?></h3>
                            <p>Celkově postav</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <a href="<?php echo base_url('TODO') ?>" class="small-box-footer">Více informací <i
                                    class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?php echo $total_companions ?></h3>
                            <p>Celkově společníků</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-paw"></i>
                        </div>
                        <a href="<?php echo base_url('TODO') ?>" class="small-box-footer">Více informací <i
                                    class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <!--            TODO - dashboard pro hrace -->
        <?php } ?>
    </section>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#dashboardMainMenu").addClass('active');
    });

</script>