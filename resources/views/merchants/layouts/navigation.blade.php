<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="block m-t-xs font-bold">{{Auth::guard('merchant')->user()->username}}</span>
                    <span class="block m-t-xs font-bold">到期时间：{{Carbon\Carbon::parse(Auth::guard('merchant')->user()->expired_at)->toDateString()}}</span>
                        <span class="text-muted text-xs block">menu <b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="dropdown-item" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a></li>
                        <form id="logout-form" action="{{ route('merchant.logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>

            <li>
                <a href="{{route('merchant.index.edit')}}"><i class="fa fa-th-large"></i> <span class="nav-label">首页设置</span></a>
            </li>
   
            @can('新品管理')
            <li>
                <a href="{{route('merchant.product.index')}}"><i class="fa fa-th-large"></i> <span class="nav-label">新品管理</span></a>
            </li>
            @endcan

            @can('空间管理')
            <li>
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">空间管理</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{route('merchant.space.category.index')}}">空间分类</a></li>
                    <li><a href="{{route('merchant.space.index')}}">空间列表</a></li>
                </ul>
            </li>
            @endcan


            @can('风格管理')
            <li>
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">风格管理</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{route('merchant.style.category.index')}}">风格分类</a></li>
                    <li><a href="{{route('merchant.style.index')}}">风格列表</a></li>
                </ul>
            </li>
            @endcan

            @can('全景管理')
            <li>
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">全景管理</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{route('merchant.material.index')}}">材质管理</a></li>
                    <li><a href="{{route('merchant.panorama.style.index')}}">风格管理</a></li>
                    <li><a href="{{route('merchant.panorama.index')}}" id="damian">全景图管理</a></li>
                    <li><a href="{{route('merchant.vertical_view.index')}}" id="damian">鸟瞰图管理</a></li>
                    <li><a href="{{route('merchant.panorama.single_space.index')}}" id="damian">单个空间</a></li>
                </ul>
            </li>
            @endcan

            @can('风采管理')
            <li>
                <a href="{{route('merchant.introduction.index')}}"><i class="fa fa-th-large"></i> <span class="nav-label">企业风采管理</span></a>
            </li>
            @endcan

            <!-- all user -->
            <li>
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">个人管理</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{route('merchant.password.edit')}}">修改密码</a></li>
                </ul>
            </li>
        </ul>

    </div>
</nav>