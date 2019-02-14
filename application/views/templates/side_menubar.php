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

<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li id="dashboardMainMenu">
                <a href="<?php echo base_url('dashboard') ?>">
                    <i class="fa fa-line-chart"></i> <span>Přehledy</span>
                </a>
            </li>
            <?php if ($user_permission): ?>
                <?php if (in_array('createGroup', $user_permission) || in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)): ?>
                    <li class="treeview" id="mainGroupNav">
                        <a href="#">
                            <i class="fa fa-files-o"></i>
                            <span>Skupiny</span>
                            <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                        </a>
                        <ul class="treeview-menu">
                            <?php if (in_array('createGroup', $user_permission)): ?>
                                <li id="addGroupNav"><a href="<?php echo base_url('groups/create') ?>"><i
                                                class="fa fa-circle-o"></i> Přidat skupinu</a></li>
                            <?php endif; ?>
                            <?php if (in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)): ?>
                                <li id="manageGroupNav"><a href="<?php echo base_url('groups') ?>"><i
                                                class="fa fa-circle-o"></i> Spravovat skupiny</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (in_array('createItem', $user_permission) || in_array('updateItem', $user_permission) || in_array('viewItem', $user_permission) || in_array('deleteItem', $user_permission)): ?>
                    <li class="treeview" id="mainItemNav">
                        <a href="#">
                            <i class="ion ion-ios-nutrition"></i>
                            <span>Předměty</span>
                            <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                        </a>
                        <ul class="treeview-menu">
                            <?php if (in_array('createItem', $user_permission)): ?>
                                <li id="addItemNav"><a href="<?php echo base_url('items/create') ?>"><i
                                                class="fa fa-circle-o"></i> Přidat předmět</a></li>
                            <?php endif; ?>
                            <?php if (in_array('updateItem', $user_permission) || in_array('viewItem', $user_permission) || in_array('deleteItem', $user_permission)): ?>
                                <li id="manageItemNav"><a href="<?php echo base_url('items') ?>"><i
                                                class="fa fa-circle-o"></i> Spravovat předměty</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (in_array('createNpc', $user_permission) || in_array('updateNpc', $user_permission) || in_array('viewNpc', $user_permission) || in_array('deleteNpc', $user_permission)): ?>
                    <li class="treeview" id="mainNpcNav">
                        <a href="#">
                            <i class="ion ion-social-freebsd-devil"></i>
                            <span>NPC</span>
                            <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                        </a>
                        <ul class="treeview-menu">
                            <?php if (in_array('createNpc', $user_permission)): ?>
                                <li id="addNpcNav"><a href="<?php echo base_url('npcs/create') ?>"><i
                                                class="fa fa-circle-o"></i> Přidat NPC</a></li>
                            <?php endif; ?>
                            <?php if (in_array('updateNpc', $user_permission) || in_array('viewNpc', $user_permission) || in_array('deleteNpc', $user_permission)): ?>
                                <li id="manageNpcNav"><a href="<?php echo base_url('npcs') ?>"><i
                                                class="fa fa-circle-o"></i> Spravovat NPC</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (in_array('createLocation', $user_permission) || in_array('updateLocation', $user_permission) || in_array('viewLocation', $user_permission) || in_array('deleteLocation', $user_permission)): ?>
                    <li class="treeview" id="mainLocNav">
                        <a href="#">
                            <i class="ion ion-android-home"></i>
                            <span>Lokace</span>
                            <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                        </a>
                        <ul class="treeview-menu">
                            <?php if (in_array('createLocation', $user_permission)): ?>
                                <li id="addLocNav"><a href="<?php echo base_url('locations/create') ?>"><i
                                                class="fa fa-circle-o"></i> Přidat lokaci</a></li>
                            <?php endif; ?>
                            <?php if (in_array('updateLocation', $user_permission) || in_array('viewLocation', $user_permission) || in_array('deleteLocation', $user_permission)): ?>
                                <li id="manageLocNav"><a href="<?php echo base_url('locations') ?>"><i
                                                class="fa fa-circle-o"></i> Spravovat lokace</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (in_array('createUser', $user_permission) || in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
                    <li class="treeview" id="mainUserNav">
                        <a href="#">
                            <i class="ion ion-android-people"></i>
                            <span>Hráči</span>
                            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                        </a>
                        <ul class="treeview-menu">
                            <?php if (in_array('createUser', $user_permission)): ?>
                                <li id="createUserNav"><a href="<?php echo base_url('users/create') ?>"><i
                                                class="fa fa-circle-o"></i> Přidat hráče</a></li>
                            <?php endif; ?>

                            <?php if (in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
                                <li id="manageUserNav"><a href="<?php echo base_url('users') ?>"><i
                                                class="fa fa-circle-o"></i> Spravovat hráče</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (in_array('createSkill', $user_permission) || in_array('updateSkill', $user_permission) || in_array('viewSkill', $user_permission) || in_array('deleteSkill', $user_permission)): ?>
                    <li class="treeview" id="mainSkillNav">
                        <a href="#">
                            <i class="ion ion-bonfire"></i>
                            <span>Dovednosti</span>
                            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                        </a>
                        <ul class="treeview-menu">
                            <?php if (in_array('createSkill', $user_permission)): ?>
                                <li id="addSkillNav"><a href="<?php echo base_url('skills/create') ?>"><i
                                                class="fa fa-circle-o"></i> Přidat dovednost</a></li>
                            <?php endif; ?>

                            <?php if (in_array('updateSkill', $user_permission) || in_array('viewSkill', $user_permission) || in_array('deleteSkill', $user_permission)): ?>
                                <li id="manageSkillNav"><a href="<?php echo base_url('skills') ?>"><i
                                                class="fa fa-circle-o"></i> Spravovat dovednosti</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (in_array('createRace', $user_permission) || in_array('updateRace', $user_permission) || in_array('viewRace', $user_permission) || in_array('deleteRace', $user_permission)): ?>
                    <li class="treeview" id="mainRaceNav">
                        <a href="#">
                            <i class="ion ion-earth"></i>
                            <span>Rasy</span>
                            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                        </a>
                        <ul class="treeview-menu">
                            <?php if (in_array('createRace', $user_permission)): ?>
                                <li id="addRaceNav"><a href="<?php echo base_url('races/create') ?>"><i
                                                class="fa fa-circle-o"></i> Přidat rasu</a></li>
                            <?php endif; ?>

                            <?php if (in_array('updateRace', $user_permission) || in_array('viewRace', $user_permission) || in_array('deleteRace', $user_permission)): ?>
                                <li id="manageRaceNav"><a href="<?php echo base_url('races') ?>"><i
                                                class="fa fa-circle-o"></i> Spravovat rasy</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (in_array('createCharacter', $user_permission) || in_array('updateCharacter', $user_permission) || in_array('viewCharacter', $user_permission) || in_array('deleteCharacter', $user_permission)): ?>
                    <li id="charNav">
                        <a href="<?php echo base_url('character') ?>">
                            <i class="fa fa-user"></i> <span>Postava</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (in_array('createCompanion', $user_permission) || in_array('updateCompanion', $user_permission) || in_array('viewCompanion', $user_permission) || in_array('deleteCompanion', $user_permission)): ?>
                    <li class="treeview" id="mainCompNav">
                        <a href="#">
                            <i class="fa fa-paw"></i>
                            <span>Společníci</span>
                            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                        </a>
                        <ul class="treeview-menu">
                            <?php if (in_array('createCompanion', $user_permission)): ?>
                                <li id="addCompNav"><a href="<?php echo base_url('companions/create') ?>"><i
                                                class="fa fa-circle-o"></i> Přidat společníka</a></li>
                            <?php endif; ?>

                            <?php if (in_array('updateCompanion', $user_permission) || in_array('viewCompanion', $user_permission) || in_array('deleteCompanion', $user_permission)): ?>
                                <li id="manageCompNav"><a href="<?php echo base_url('companions') ?>"><i
                                                class="fa fa-circle-o"></i> Spravovat společníky</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (in_array('viewReports', $user_permission)): ?>
                    <li id="reportNav">
                        <a href="<?php echo base_url('reports') ?>">
                            <i class="glyphicon glyphicon-stats"></i> <span>Reporty - 0.5.0</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (in_array('updateSettings', $user_permission)): ?>
                    <li id="settingsNav"><a href="<?php echo base_url('users/settings') ?>"><i class="fa fa-wrench"></i>
                            <span>Změna údajů</span></a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            <li><a href="<?php echo base_url('auth/logout') ?>"><i class="glyphicon glyphicon-log-out"></i> <span>Odhlásit se</span></a>
            </li>
        </ul>
    </section>
</aside>