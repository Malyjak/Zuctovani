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

<div class="modal fade" tabindex="-1" role="dialog" id="throwModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Hod kostkami</h4>
            </div>
            <form role="form" action="<?php echo base_url('dashboard/dices/10') ?>" method="post" id="diceForm">
                <div class="modal-body">
                    <p>Kolika kostkami chcete házet?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zrušit</button>
                    <button type="submit" class="btn btn-primary">Hodit</button>
                </div>
            </form>
        </div>
    </div>
</div>