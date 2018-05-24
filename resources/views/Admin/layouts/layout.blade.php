<!DOCTYPE html>
<html>
<head>
    <title>{{ isset($title_page)? $title_page.' |':'' }} WorkByThai</title>
    <!-- <link href="{{asset('assets/admin/css/application.css')}}" rel="stylesheet"> -->
    <link rel="stylesheet" href="{{asset('assets/admin/css/application.css')}}" />

    <link rel="stylesheet" href="{{asset('assets/global/plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.css')}}" />
    <!-- <link rel="stylesheet" href="{{asset('assets/global/plugins/bootstrap-daterangepicker-master/daterangepicker.css')}}" /> -->
    <link rel="stylesheet" href="{{asset('assets/global/plugins/orakuploader/orakuploader.css')}}" />
    <!-- <link rel="stylesheet" href="{{asset('assets/global/css/modal.css')}}" /> -->
    <link rel="stylesheet" href="{{asset('assets/admin/css/jquery.timepicker.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.css')}}" />

    <!-- tinymce -->
    <link rel="stylesheet" href="{{asset('assets/admin/plugin/tinymce/skins/lightgray/skin.min.css')}}">


    <link rel="stylesheet" href="{{asset('assets/admin/css/custom.css')}}" />

    <link rel="shortcut icon" href="{{asset('assets/admin/img/favicon.png')}}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="WorkByThai.Co.Ltd.">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <style>
            /* body {
                font-weight: 400;
                padding-bottom: 100px;
                background-color: #2b6e80 20%;
                background-image: radial-gradient(farthest-side ellipse at 10% 0, #2b6e80 20%, #0c3252);
                background-image: -webkit-radial-gradient(10% 0, farthest-side ellipse, #2b6e80 20%, #0c3252);
                background-image: -moz-radial-gradient(10% 0, farthest-side ellipse, #2b6e80 20%, #0c3252);
                background-attachment: fixed, fixed;
            } */
            /* body {
                font-family: 'Kanit', sans-serif;
                font-size: 14px;
                line-height: 1.428571429;
                color: #f8f8f8;
                background-color: #fff;
            }     */
            /* .widget {
                border-radius: 3px;
                -webkit-box-sizing: content-box;
                -moz-box-sizing: content-box;
                box-sizing: content-box;
                padding: 12px 17px;
                color: #606060;
                background: #ffffff;
                margin-bottom: 30px;
                position: relative;
            } */
            /* .widget .table th {
                color: #606060;
            } */
            /* .pagination > .disabled > span, .pagination > .disabled > span:hover, .pagination > .disabled > span:focus, .pagination > .disabled > a, .pagination > .disabled > a:hover, .pagination > .disabled > a:focus {
                color: #020202;
                background-color: transparent;
                border-color: transparent;
                cursor: not-allowed;
            } */
            /* .checkbox label::after {
                color: #100f0f;
            } */
            /* .page-header .nav > li > a {
                color: rgba(255, 255, 255, 0.8);
                width: 40px;
                padding: 0;
                font-size: 19.5px;
                outline: 0;
                background: none;
                text-align: center;
                vertical-align: middle;
                line-height: 36px;
                text-shadow: none;
            } */
            /* .sweet-alert {
                color: black;
            } */
            /* .text-muted {
                color: #ff0000;
            } */
            /* .pagination > .active > a, .pagination > .active > a:hover, .pagination > .active > a:focus, .pagination > .active > span, .pagination > .active > span:hover, .pagination > .active > span:focus {
                z-index: 2;
                color: #f8f8f8;
                background-color: #2b6e80;
                border-color: #2b6e80;
                cursor: default;
            } */
            /* .pagination > li > a, .pagination > li > span {
                position: relative;
                float: left;
                padding: 5px 12px;
                line-height: 1.42857;
                text-decoration: none;
                color: #0a0a0a;
                background-color: transparent;
                border: 1px solid transparent;
                margin-left: -1px;
            } */
            /* .pie-chart-footer .control {
                color: black;
            } */
            /* .pie-chart .visits {
                color: black;
            } */
        </style>
        @yield('css_bottom')
</head>
<body>
    <div class="logo">
        <h4><a href="{{url('admin')}}"><strong>MENARINI</strong></a></h4>
    </div>
        @include('Admin.layouts.sidebar')
    <div class="wrap">
        <header class="page-header">
            <div class="navbar">
                <ul class="nav navbar-nav navbar-right pull-right">
                    <li class="visible-phone-landscape">
                        <a href="#" id="search-toggle">
                            <i class="fa fa-search"></i>
                        </a>
                    </li>

                    <li class="divider"></li>
                    <li class="hidden-xs">
                        <a href="#" id="settings"
                           title="Settings"
                           data-toggle="popover"
                           data-placement="bottom">
                            <i class="glyphicon glyphicon-cog"></i>
                        </a>
                    </li>

                    <li class="visible-xs">
                        <a href="#"
                           class="btn-navbar"
                           data-toggle="collapse"
                           data-target=".sidebar"
                           title="">
                            <i class="fa fa-bars"></i>
                        </a>
                    </li>
                    <li class="hidden-xs">
                        <a href="{{url('admin/logout')}}"><i class="glyphicon glyphicon-off"></i></a>
                    </li>
                </ul>
                <!-- <form id="search-form" class="navbar-form pull-right" role="search">
                    <input type="search" class="form-control search-query" placeholder="Search...">
                </form> -->

            </div>
        </header>
        <div class="content container">
            @yield('body')
            <!-- <footer class="content-footer">
                <div class="pull-right float-right">
                    Develope By <a href="https://www.workbythai.com/" target="_blank">WorkByThai Internet And Marketing</a> V 1.1
                </div>
            </footer> -->
        </div>
        <!-- <div class="loader-wrap hiding hide">
            <i class="fa fa-circle-o-notch fa-spin"></i>
        </div> -->
    </div>
<!-- common libraries. required for every page-->
<script>
    var url_gb = '{{url('')}}';
    var asset_gb = '{{asset('')}}';
</script>
<script src="{{asset('assets/admin/lib/jquery/dist/jquery.min.js')}}"></script>
<!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
<script src="{{asset('assets/global/plugins/orakuploader/jquery-ui.min.js')}}"></script>
<script src="{{asset('assets/global/plugins/bootstrap-daterangepicker-master/moment.js')}}"></script>
<!-- <script src="{{asset('assets/admin/lib/jquery-pjax/jquery.pjax.js')}}"></script> -->
<script src="{{asset('assets/admin/lib/bootstrap-sass/assets/javascripts/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/admin/lib/widgster/widgster.js')}}"></script>
<script src="{{asset('assets/admin/lib/underscore/underscore.js')}}"></script>

<!-- common application js -->
<script src="{{asset('assets/admin/js/app.js')}}"></script>
<script src="{{asset('assets/admin/js/settings.js')}}"></script>

<script src="{{asset('assets/admin/lib/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
<script src="{{asset('assets/admin/lib/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/admin/lib/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('assets/admin/lib/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/global/js/modal.js')}}"></script>
<script src="{{asset('assets/global/js/validate.js')}}"></script>
<script src="{{asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.js')}}"></script>
<script src="{{asset('assets/global/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js')}}"></script>
<script src="{{asset('assets/global/plugins/bootstrap-daterangepicker-master/daterangepicker.js')}}"></script>
<script src="{{asset('assets/global/plugins/Jquery-Price-Format/jquery.priceformat.js')}}"></script>
<!-- <script src="{{asset('assets/global/plugins/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('assets/global/plugins/ckeditor/config.js')}}"></script> -->
<script src="{{asset('assets/admin/js/function.js')}}"></script>
<script src="{{asset('assets/admin/js/jquery.timepicker.js')}}"></script>

<!-- tinymce -->
<script src="{{asset('assets/admin/plugin/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('assets/admin/plugin/tinymce/jquery.tinymce.min.js')}}"></script>
<script src="{{asset('assets/admin/plugin/tinymce/themes/modern/theme.min.js')}}"></script>

<!-- chartjs -->
<script src="{{asset('assets/admin/plugin/chart.js/dist/Chart.min.js')}}"></script>

<!-- common templates -->
<script type="text/template" id="settings-template">
    <div class="setting clearfix">
        <div>Sidebar on the</div>
        <div id="sidebar-toggle" class="pull-left btn-group" data-toggle="buttons-radio">
            <% onRight = sidebar == 'right'%>
            <button type="button" data-value="left" class="btn btn-sm btn-default <%= onRight? '' : 'active' %>">Left</button>
            <button type="button" data-value="right" class="btn btn-sm btn-default <%= onRight? 'active' : '' %>">Right</button>
        </div>
    </div>
    <div class="setting clearfix">
        <div>Sidebar</div>
        <div id="display-sidebar-toggle" class="pull-left btn-group" data-toggle="buttons-radio">
            <% display = displaySidebar%>
            <button type="button" data-value="true" class="btn btn-sm btn-default <%= display? 'active' : '' %>">Show</button>
            <button type="button" data-value="false" class="btn btn-sm btn-default <%= display? '' : 'active' %>">Hide</button>
        </div>
    </div>
    <div class="setting clearfix">
        <div>Dark Version</div>
        <div>
            <a href="../dark/index.html" class="btn btn-sm btn-default">&nbsp; Switch &nbsp;   <i class="fa fa-angle-right"></i></a>
        </div>
    </div>
    <div class="setting clearfix">
        <div>White Version</div>
        <div>
            <a href="../white/index.html" class="btn btn-sm btn-default">&nbsp; Switch &nbsp;   <i class="fa fa-angle-right"></i></a>
        </div>
    </div>
</script>

<script type="text/template" id="sidebar-settings-template">
    <% auto = sidebarState == 'auto'%>
    <% if (auto) {%>
    <button type="button"
            data-value="icons"
            class="btn-icons btn btn-transparent btn-sm">Icons</button>
    <button type="button"
            data-value="auto"
            class="btn-auto btn btn-transparent btn-sm">Auto</button>
    <%} else {%>
    <button type="button"
            data-value="auto"
            class="btn btn-transparent btn-sm">Auto</button>
    <% } %>
</script>

    <!-- page specific scripts -->
        <!-- page libs -->
        @yield('js_bottom')

        <!-- page template -->
        <script type="text/template" id="message-template">
            <div class="sender pull-left">
                <div class="icon">
                    <img src="{{asset('assets/admin/img/2.png')}}" class="img-circle" alt="">
                </div>
                <div class="time">
                    just now
                </div>
            </div>
            <div class="chat-message-body">
                <span class="arrow"></span>
                <div class="sender"><a href="#">Tikhon Laninga</a></div>
                <div class="text">
                    <%- text %>
                </div>
            </div>
        </script>


<script>
    $('body').on('click','.btn-tooltip', function () {
        $(this).tooltip('hide');
    });
</script>
</body>
</html>
