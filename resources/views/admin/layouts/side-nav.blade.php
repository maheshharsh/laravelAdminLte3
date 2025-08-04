<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="admin/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tree"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @can('browse_user')
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-tree"></i>
                        <p>Users</p>
                    </a>
                </li>
                @endcan
                @can('browse_permission')
                <li class="nav-item">
                    <a href="{{ route('admin.permissions.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-tree"></i>
                        <p>Permissions</p>
                    </a>
                </li>
                @endcan
                @can('browse_role')
                <li class="nav-item">
                    <a href="{{ route('admin.roles.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-tree"></i>
                        <p>Roles</p>
                    </a>
                </li>
                @endcan
                @can('browse_category')
                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-tree"></i>
                        <p>Categories</p>
                    </a>
                </li>
                @endcan
                @can('browse_headline')
                <li class="nav-item">
                    <a href="{{ route('admin.headlines.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-tree"></i>
                        <p>Headlines</p>
                    </a>
                </li>
                @endcan
                @can('browse_advertisement')
                <li class="nav-item">
                    <a href="{{ route('admin.advertisements.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-tree"></i>
                        <p>Advertisements</p>
                    </a>
                </li>
                @endcan
                @can('browse_article')
                <li class="nav-item">
                    <a href="{{ route('admin.articles.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-tree"></i>
                        <p>Articles</p>
                    </a>
                </li>
                @endcan
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        
                        <a href="route('logout')" class="nav-link"
                        onclick="event.preventDefault();
                                                this.closest('form').submit();">
                        <i class="nav-icon fas fa-tree"></i>
                            <p>Log Out</p>
                        </a>
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
