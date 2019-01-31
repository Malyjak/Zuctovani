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

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $page_title; ?></title>
    <link rel="icon" type="image/png" href="../../assets/images/title_icon.png" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet"
          href="<?php echo base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet"
          href="<?php echo base_url('assets/bower_components/font-awesome/css/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/Ionicons/css/ionicons.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/skins/_all-skins.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/morris.js/morris.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/jvectormap/jquery-jvectormap.css') ?>">
    <link rel="stylesheet"
          href="<?php echo base_url('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') ?>">
    <link rel="stylesheet"
          href="<?php echo base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css') ?>">
    <link rel="stylesheet"
          href="<?php echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') ?>">
    <link rel="stylesheet"
          href="<?php echo base_url('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/select2/dist/css/select2.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/fileinput/fileinput.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/iCheck/all.css') ?>">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <script src="<?php echo base_url('assets/bower_components/jquery/dist/jquery.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/bower_components/jquery-ui/jquery-ui.min.js') ?>"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="<?php echo base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/bower_components/raphael/raphael.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/bower_components/morris.js/morris.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') ?>"></script>
    <script src="<?php echo base_url('assets/bower_components/jquery-knob/dist/jquery.knob.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/bower_components/moment/min/moment.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.js') ?>"></script>
    <script src="<?php echo base_url('assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/bower_components/fastclick/lib/fastclick.js') ?>"></script>
    <script src="<?php echo base_url('assets/bower_components/select2/dist/js/select2.full.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/dist/js/adminlte.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/dist/js/pages/dashboard.js') ?>"></script>
    <script src="<?php echo base_url('assets/dist/js/demo.js') ?>"></script>
    <script src="<?php echo base_url('assets/plugins/fileinput/fileinput.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/bower_components/Chart.js/Chart.js') ?>"></script>
    <script src="<?php echo base_url('assets/plugins/iCheck/icheck.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') ?>"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">