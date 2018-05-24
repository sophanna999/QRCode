        <nav id="sidebar" class="sidebar nav-collapse collapse">
            <ul id="side-nav" class="side-nav">
                @foreach($menus as $menu)
                    @if(sizeof($menu->SubMenu)>0)
                        <li class="panel {{ (isset($main_menu)&&$menu->link==$main_menu)? 'active':'' }}">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#side-nav" href="#forms-collapse">
                                <i class="{{$menu->icon or 'fa fa-pencil'}}"></i>
                                <span class="name">{{$menu->name}}</span>
                            </a>
                            <ul id="forms-collapse" class="panel-collapse collapse ">
                                @foreach($menu->SubMenu as $sub)
                                <li class="{{ (isset($sub_menu)&&$sub->link==$sub_menu)? 'active':'' }}">
                                    <a href="{{url('admin/'.$sub->link)}}">
                                        {{$sub->name}}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li class="{{ (isset($main_menu)&&$menu->link==$main_menu)? 'active':'' }}">
                            <a href="{{url('admin/'.$menu->link)}}">
                                <i class="{{$menu->icon or 'fa fa-home'}}"></i>
                                <span class="name">{{$menu->name}}</span>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
{{--
            <h5 class="sidebar-nav-title">Labels <a class="action-link" href="#"><i class="glyphicon glyphicon-plus"></i></a></h5>
            <!-- some styled links in sidebar. ready to use as links to email folders, projects, groups, etc -->
            <ul class="sidebar-labels">
                <li>
                    <a href="#">
                        <!-- yep, .circle again -->
                        <i class="fa fa-circle text-warning"></i>
                        <span class="label-name">My Recent</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-circle text-gray"></i>
                        <span class="label-name">Starred</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-circle text-danger"></i>
                        <span class="label-name">Background</span>
                    </a>
                </li>
            </ul>

            <h5 class="sidebar-nav-title">Projects</h5>
            <!-- A place for sidebar notifications & alerts -->
            <div class="sidebar-alerts">
                <div class="alert fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
                    <span class="fw-semi-bold">Sales Report</span> <br>
                    <div class="progress progress-xs mt-xs mb-0">
                        <div class="progress-bar progress-bar-gray-light" style="width: 16%"></div>
                    </div>
                    <small>Calculating x-axis bias... 65%</small>
                </div>
                <div class="alert fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
                    <span class="fw-semi-bold">Personal Responsibility</span> <br>
                    <div class="progress progress-xs mt-xs mb-0">
                        <div class="progress-bar progress-bar-danger" style="width: 23%"></div>
                    </div>
                    <small>Provide required notes</small>
                </div>
            </div>  --}}
        </nav>
