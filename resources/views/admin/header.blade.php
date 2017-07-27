<header class="main-header">
    <!-- Logo -->
    <a href="{{ $base_url }}" class="logo">
        <span class="logo-mini"><b>后台</b></span>
        <span class="logo-lg"><b>管理</b>后台</span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <?php $user = Admin::user(); ?>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ $base_url }}/img/avatar-{{ $user['sex'] == 1 ? 'man' : 'women' }}.png" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ $user['username'] }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="{{ $base_url }}/img/avatar-{{ $user['sex'] == 1 ? 'man' : 'women' }}.png" class="img-circle" alt="User Image">
                            <p>
                                {{ $user['email'] }}
                                <small>{{ $user['mobile'] }}</small>
                                <small>{{ $user['created_at'] }}</small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ url('/info') }}" class="btn btn-default btn-flat">属性</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ $base_url }}/auth/logout" class="btn btn-default btn-flat">退出</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>