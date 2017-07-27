<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="header">主菜单</li>
            @foreach (Admin::menus() as $menu)
            <li class="treeview {{ $menu['id'] == Admin::getParentMenuId() ? 'active' : '' }}">
                <a href="#">
                    <i class = "fa {{ $menu['icon'] }}"></i>
                    <span>{{  $menu['title'] }}</span>
                    <i class = "fa fa-angle-left pull-right"></i>
                </a>
                @if (isset($menu['children']) && !empty($menu['children']))
                <ul class="treeview-menu">
                    @foreach ($menu['children'] as $child)
                    <li class="{{  $child['id'] == Admin::getMenuId() ? 'active' : '' }}">
                        <a href="{{ $base_url . $child['uri'] }}">
                            <i class="fa {{ $child['icon'] }}"></i>{{ $child['title'] }}
                        </a>
                    </li>
                    @endforeach
                </ul>
                @endif
            </li>
            @endforeach
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>