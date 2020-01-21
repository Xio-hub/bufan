<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">Example user</span>
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

            <li>
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">用户管理</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href={{route('show_users')}}>用户列表</a></li>
                    <li><a href={{route('show_permission')}}>权限管理</a></li>
                    <li><a href="{{route('show_roles')}}">角色管理</a></li>
                    <li><a href="{{route('add_user')}}">添加用户</a></li>
                </ul>
            </li>

            <li>
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">商家管理</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="index.html">商家列表</a></li>
                    <li><a href="index.html">添加商家</a></li>
                </ul>
            </li>

            <li>
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">图册管理</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="index.html">首页设置</a></li>
                    <li><a href="index.html">图册列表</a></li>
                    <li><a href="index.html">添加图册</a></li>
                </ul>
            </li>

            <li>
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">个人管理</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{route('reset_password')}}">修改密码</a></li>
                </ul>
            </li>
        </ul>

    </div>
</nav>