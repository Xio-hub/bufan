<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="block m-t-xs font-bold">{{Auth::user()->name}}</span>
                        <span class="text-muted text-xs block">menu <b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="dropdown-item" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>

            <!-- super admin -->
            @hasrole('super_admin')
            <li>
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">后台管理</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{route('admin.index')}}">管理用户列表</a></li>
                    <li><a href="{{route('permissions.index')}}">权限管理</a></li>
                    <li><a href="{{route('roles.index')}}">角色管理</a></li>
                    <li><a href="{{route('admin.create')}}">添加管理员</a></li>
                </ul>
            </li>
            @endhasrole

            <!-- admin -->
            {{-- @can('1') --}}
            <li>
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">商家管理</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{route('merchants.index')}}">商家列表</a></li>
                    <li><a href="{{route('merchants.create')}}">添加商家</a></li>
                </ul>
            </li>
            {{-- @endcan --}}

            <li>
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">课程管理</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{route('courses.config.background.edit')}}">更换背景</a></li>
                    <li><a href="{{route('courses.config.introduction.edit')}}">课程简介</a></li>
                    <li><a href="{{route('courses.index')}}">课程列表</a></li>
                    <li><a href="{{route('courses.create')}}">添加课程</a></li>
                </ul>
            </li>

            <li>
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">订单管理</span> <span class="fa arrow"></span></a>
            </li>

            <!-- all user -->
            <li>
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">个人管理</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{route('admin.password.edit')}}">修改密码</a></li>
                </ul>
            </li>
        </ul>

    </div>
</nav>