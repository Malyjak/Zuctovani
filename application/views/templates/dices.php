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
            <form role="form" action="<?php echo base_url('dashboard/dices') ?>" method="post" id="throwForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-xs-6">
                            <div class="form-group">
                                <label for="dices">Kolika kostkami chcete házet?</label>
                                <input type="number" class="form-control" id="dices" name="dices"
                                       value="0" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-6">
                            <div style="text-align: center">
                                <b>Padlo:</b>
                                <p id="errorText" style="display:none; color: #b92c28; font-size: x-large">Počet kostek musí být nezáporný!</p>
                                <p id="good" style="display:none; color: #008d4c; font-size: x-large" title=""></p>
                                <p id="bad" style="display:none; color: #b92c28; font-size: x-large" title=""></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zrušit</button>
                    <button type="submit" class="btn btn-primary">Hodit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function throwFunc() {
            $("#throwForm").on('submit', function () {
                var form = $(this);
                var numOfDices = $("#dices").val();

                $("#good").hide();
                $("#bad").hide();
                $("#errorText").hide();

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (response) {
                        if (response.success === true) {
                            if (response.result >= numOfDices){
                                $("#good").html(response.result);
                                $("#good").attr('title', 'Z toho nul: '+response.zero+', jedniček: '+response.one+', dvojek: '+response.two);
                                $("#good").show();
                            } else {
                                $("#bad").html(response.result);
                                $("#bad").attr('title', 'Z toho nul: '+response.zero+', jedniček: '+response.one+', dvojek: '+response.two);
                                $("#bad").show();
                            }
                        } else {
                            $("#errorText").show();
                        }
                    }
                });

                return false;
            });
    }
</script>
