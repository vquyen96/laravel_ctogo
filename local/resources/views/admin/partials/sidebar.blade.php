<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</p>
                {{--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>--}}
            </div>
        </div>
        <!-- search form -->
        {{--<form action="#" method="get" class="sidebar-form">--}}
            {{--<div class="input-group">--}}
                {{--<input type="text" name="q" class="form-control" placeholder="Search...">--}}
                {{--<span class="input-group-btn">--}}
                {{--<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>--}}
                {{--</button>--}}
              {{--</span>--}}
            {{--</div>--}}
        {{--</form>--}}
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            @if( Auth::guard('admin')->user()->permiss == \App\Models\Admin::ADMIN_PERMISSION )
                <li class="@if (Request::segment(2) == 'account') active @endif">
                    <a href="{{asset('admin/account')}}"
                       >
                        <i class="fa fa-users"></i> <span>Quản lý admin</span>
                    </a>
                </li>
            @endif
            <li class="@if (Request::segment(2) == 'guest') active @endif">
                <a href="{{route("list_guest")}}" >
                    <i class="fa fa-child"></i> <span>Quản lý tài khoản khách</span>
                </a>
            </li>

            <li class="@if (Request::segment(2) == 'host') active @endif">
                <a href="{{route("list_host")}}">
                    <i class="fa fa-home"></i> <span>Danh sách tài khoản chủ nhà</span>
                </a>
            </li>

            <li class="treeview @if (Request::segment(2) == 'comment') active @endif">
                <a href="#">
                    <i class="fa fa-comments-o"></i> <span>Quản lý bình luận</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route("list_comment")}}"><i class="fa fa-circle-o"></i> Danh sách bình luận</a></li>
                    <li><a href="{{route("sort_comment")}}"><i class="fa fa-circle-o"></i> Sắp xếp bình luận</a></li>
                </ul>
            </li>

            <li class="treeview @if (Request::segment(2) == 'homestay') active @endif">
                <a href="#">
                    <i class="fa fa-hotel"></i> <span>Quản lý homestay</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('list_homestay')}}"><i class="fa fa-circle-o"></i> Danh sách homestay</a></li>
                    <li><a href="{{route('list_non_active')}}"><i class="fa fa-circle-o"></i> Danh sách homestay chờ duyệt</a></li>
                </ul>
            </li>

            <li class="treeview @if (Request::segment(2) == 'books') active @endif">
                <a href="#">
                    <i class="fa fa-cart-arrow-down"></i><span>Quản lý đơn</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route("list_book")}}"><i class="fa fa-circle-o"></i> Danh sách đơn</a></li>
                </ul>
            </li>

            <li class="@if (Request::segment(2) == 'config') active @endif">
                <a href="{{ asset('admin/config') }}">
                    <i class="fa fa-gear"></i> <span>Cài đặt website</span>
                    <span class="pull-right-container"></span>
                </a>
            </li>

            <li class="@if (Request::segment(2) == 'website_info') active @endif">
                <a href="{{ route('website_info') }}">
                    <i class="fa fa-info"></i> <span>Cài đặt thông tin website</span>
                    <span class="pull-right-container"></span>
                </a>
            </li>

            <li class="">
                <a href="{{ route('website_info') }}">
                    <i class="fa fa-info"></i> <span>Đăng xuất</span>
                    <span class="pull-right-container"></span>
                </a>
            </li>

            {{--<li>--}}
                {{--<a href="pages/widgets.html">--}}
                    {{--<i class="fa fa-th"></i> <span>Widgets</span>--}}
                    {{--<span class="pull-right-container"><small class="label pull-right bg-green">new</small></span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--<li class="header">LABELS</li>--}}
            {{--<li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>--}}
            {{--<li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>--}}
            {{--<li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>--}}
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>