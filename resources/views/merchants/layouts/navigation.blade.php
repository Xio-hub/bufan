<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="block m-t-xs font-bold">{{Auth::guard('merchant')->user()->username}}</span>
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
   
            <li>
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">新品管理</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{route('merchant.product.index')}}">新品列表</a></li>
                    <li><a href="{{route('merchant.product.create')}}">添加新品</a></li>
                </ul>
            </li>

            <li>
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">空间管理</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{route('merchant.space.category.index')}}">空间分类</a></li>
                    <li><a href="{{route('merchant.space.category.create')}}">添加分类</a></li>
                    <li><a href="{{route('merchant.space.index')}}">空间列表</a></li>
                    <li><a href="{{route('merchant.space.create')}}">添加空间</a></li>
                </ul>
            </li>

            <li>
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">风格管理</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{route('merchant.style.category.index')}}">风格分类</a></li>
                    <li><a href="{{route('merchant.style.category.create')}}">添加分类</a></li>
                    <li><a href="{{route('merchant.style.index')}}">风格列表</a></li>
                    <li><a href="{{route('merchant.style.create')}}">添加风格</a></li>
                </ul>
            </li>

            <li>
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">全景管理</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li>
                        <a href="#" id="damian">材质管理<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="{{route('merchant.material.index')}}">材质列表</a>
                            </li>
                            <li>
                                <a href="{{route('merchant.material.create')}}">添加材质</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" id="damian">空间管理<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="{{route('merchant.panorama.style.index')}}">空间列表</a>
                            </li>
                            <li>
                                <a href="{{route('merchant.panorama.style.create')}}">添加空间</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="#" id="damian">全景图管理<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="{{route('merchant.panorama.index')}}">全景图列表</a>
                            </li>
                            <li>
                                <a href="{{route('merchant.panorama.create')}}">添加全景图</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="#" id="damian">鸟瞰图管理<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="{{route('merchant.vertical_view.index')}}">鸟瞰图列表</a>
                            </li>
                            <li>
                                <a href="{{route('merchant.vertical_view.create')}}">添加鸟瞰图</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{route('merchant.introduction.index')}}"><i class="fa fa-th-large"></i> <span class="nav-label">企业风采管理</span></a>
            </li>

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