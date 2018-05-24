<!DOCTYPE html>
<html>
<head>
    <title>System Admin By WorkByThai</title>

    <link href="{{asset('assets/admin/css/application.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.css')}}" />
    <link rel="shortcut icon" href="{{asset('assets/admin/img/favicon.png')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        /* yeah we need this empty stylesheet here. It's cool chrome & chromium fix
           chrome fix https://code.google.com/p/chromium/issues/detail?id=167083
                      https://code.google.com/p/chromium/issues/detail?id=332189
        */
    </script>
</head>
<body>
        <div class="single-widget-container">
            <section class="widget login-widget">
                <header class="text-align-center">
                    <h3>MENARINI</h3>
                </header>
                <div class="body">
                    <form class="no-margin" id="FormLogin" action="" method="get">
                        <fieldset>
                            <div class="form-group">
                                <label for="email" >Email</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <input name="username" type="text" class="form-control input-lg input-transparent" placeholder="Your Email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" >Password</label>

                                <div class="input-group input-group-lg">
                                    <span class="input-group-addon">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                    <input name="password" type="password" class="form-control input-lg input-transparent"
                                           placeholder="Your Password">
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-block btn-lg btn-danger">
                                <span class="small-circle"><i class="fa fa-caret-right"></i></span>
                                <small>เข้าสู่ระบบ</small>
                            </button>
                            <br><br>
                            <!-- <a class="forgot" href="{{asset('#')}}">Forgot Username or Password?</a> -->
                        </div>
                    </form>
                </div>
                <!-- <footer>
                    <div class="facebook-login">
                        <a href="{{url('index.html')}}"><span><i class="fa fa-facebook-square fa-lg"></i> LogIn with Facebook</span></a>
                    </div>
                </footer> -->
            </section>
        </div>
<!-- common libraries. required for every page-->
<script src="{{asset('assets/admin/lib/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('assets/admin/lib/jquery-pjax/jquery.pjax.js')}}"></script>
<script src="{{asset('assets/admin/lib/bootstrap-sass/assets/javascripts/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/admin/lib/widgster/widgster.js')}}"></script>
<script src="{{asset('assets/admin/lib/underscore/underscore.js')}}"></script>
<script src="{{asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.js')}}"></script>

<!-- common application js -->
<script src="{{asset('assets/admin/js/app.js')}}"></script>
<script src="{{asset('assets/admin/js/settings.js')}}"></script>

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
            <a href="{{url('dark/index.html')}}" class="btn btn-sm btn-default">&nbsp; Switch &nbsp;   <i class="fa fa-angle-right"></i></a>
        </div>
    </div>
    <div class="setting clearfix">
        <div>White Version</div>
        <div>
            <a href="{{url('white/index.html')}}" class="btn btn-sm btn-default">&nbsp; Switch &nbsp;   <i class="fa fa-angle-right"></i></a>
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
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var url_gb = '{{url('')}}';
    function makeid(){
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for( var i=0; i < 5; i++ )
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        return text;
    }
     function addNumformat(nStr){
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
    jQuery('body').on('submit','#FormLogin',function(e){
        e.preventDefault();
        var btn = $(this).find('button');
        btn.button('loading');
        $.ajax({
          method: "POST",
          url: "{{url('admin/CheckLogin')}}",
          data: $(this).serialize()
        }).done(function( res ) {
            if(res==0){
                swal('เข้าสู่ระบบ','ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง','error');
                btn.button('reset');
            }else{
                window.location = "{{url('/admin')}}";
            }
        }).error(function(){
            swal('เข้าสู่ระบบ','ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง','error');
            btn.button('reset');
        });
    });
</script>

    <!-- page specific scripts -->


</body>
</html>