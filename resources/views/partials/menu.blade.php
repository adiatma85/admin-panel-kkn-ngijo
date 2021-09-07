<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">{{ trans('panel.site_title') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route("admin.home") }}">
                        <i class="fas fa-fw fa-tachometer-alt nav-icon">
                        </i>
                        <p>
                            {{ trans('global.dashboard') }}
                        </p>
                    </a>
                </li>
                @can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/permissions*") ? "menu-open" : "" }} {{ request()->is("admin/roles*") ? "menu-open" : "" }} {{ request()->is("admin/users*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-users">

                            </i>
                            <p>
                                {{ trans('cruds.userManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-unlock-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.permission.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-briefcase">

                                        </i>
                                        <p>
                                            {{ trans('cruds.role.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user">

                                        </i>
                                        <p>
                                            {{ trans('cruds.user.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('scope_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.scopes.index") }}" class="nav-link {{ request()->is("admin/scopes") || request()->is("admin/scopes/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-desktop">

                                        </i>
                                        <p>
                                            {{ trans('cruds.scope.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('iuran_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/bills*") ? "menu-open" : "" }} {{ request()->is("admin/monthly-bills*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon far fa-credit-card">

                            </i>
                            <p>
                                {{ trans('cruds.iuran.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('bill_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.bills.index") }}" class="nav-link {{ request()->is("admin/bills") || request()->is("admin/bills/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-credit-card">

                                        </i>
                                        <p>
                                            {{ trans('cruds.bill.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('monthly_bill_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.monthly-bills.index") }}" class="nav-link {{ request()->is("admin/monthly-bills") || request()->is("admin/monthly-bills/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-credit-card">

                                        </i>
                                        <p>
                                            {{ trans('cruds.monthlyBill.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                {{-- @can('pembayran_access') --}}
                <li class="nav-item has-treeview {{ request()->is("admin/pembayarans*") ? "menu-open" : "" }} {{ request()->is("admin/monthly-bill-to-bills*") ? "menu-open" : "" }}">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="fa-fw nav-icon fas fa-credit-card">

                        </i>
                        <p>
                            {{ trans('cruds.pembayaran.title') }}
                            <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- @can('user_to_monthly_bill_access') --}}
                            <li class="nav-item">
                                <a href="{{ route("admin.pembayarans.index") }}" class="nav-link {{ request()->is("admin/user-to-monthly-bills") || request()->is("admin/user-to-monthly-bills/*") ? "active" : "" }}">
                                    <i class="fa-fw nav-icon fas fa-cogs">

                                    </i>
                                    <p>
                                        {{-- {{ trans('cruds.userToMonthlyBill.title') }} --}}
                                        Pembayaran
                                    </p>
                                </a>
                            </li>
                        {{-- @endcan --}}
                    </ul>
                </li>
                {{-- @endcan --}}
                @can('misc_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/user-to-monthly-bills*") ? "menu-open" : "" }} {{ request()->is("admin/monthly-bill-to-bills*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-allergies">

                            </i>
                            <p>
                                {{ trans('cruds.misc.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('user_to_monthly_bill_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.user-to-monthly-bills.index") }}" class="nav-link {{ request()->is("admin/user-to-monthly-bills") || request()->is("admin/user-to-monthly-bills/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.userToMonthlyBill.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('monthly_bill_to_bill_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.monthly-bill-to-bills.index") }}" class="nav-link {{ request()->is("admin/monthly-bill-to-bills") || request()->is("admin/monthly-bill-to-bills/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.monthlyBillToBill.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('pengumuman_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/announcements*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon far fa-newspaper">

                            </i>
                            <p>
                                {{ trans('cruds.pengumuman.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('announcement_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.announcements.index") }}" class="nav-link {{ request()->is("admin/announcements") || request()->is("admin/announcements/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-align-justify">

                                        </i>
                                        <p>
                                            {{ trans('cruds.announcement.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                    @can('profile_password_edit')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}">
                                <i class="fa-fw fas fa-key nav-icon">
                                </i>
                                <p>
                                    {{ trans('global.change_password') }}
                                </p>
                            </a>
                        </li>
                    @endcan
                @endif
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <p>
                            <i class="fas fa-fw fa-sign-out-alt nav-icon">

                            </i>
                            <p>{{ trans('global.logout') }}</p>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>