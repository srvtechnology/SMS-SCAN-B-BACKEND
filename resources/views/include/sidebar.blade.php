<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ url('home') }}" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bolder ms-2">SMS SCAN</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1" id="sidebar_btn">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->is('home') ? 'active' : '' }}">
            <a href="{{ url('home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        <li class="menu-item {{ request()->segment(1) == 'schools' ? 'active' : '' }}">
            <a href="{{ route('superadmin.schools') }}" class="menu-link">
                <i class='menu-icon bx bxs-school'></i>
                <div data-i18n="Analytics">Schools</div>
            </a>
        </li>
        <li class="menu-item {{ request()->segment(1) == 'teachers' ? 'active' : '' }}">
            <a href="{{ route('superadmin.teachers') }}" class="menu-link">
                <i class='menu-icon bx bxs-user-detail'></i>
                <div data-i18n="Analytics">Teachers</div>
            </a>
        </li>
        <li class="menu-item {{ request()->segment(1) == 'students' ? 'active' : '' }}">
            <a href="{{ route('superadmin.students') }}" class="menu-link">
                <i class='menu-icon bx bxs-user-circle' ></i>
                <div data-i18n="Analytics">Students</div>
            </a>
        </li>
        <li class="menu-item {{ request()->segment(1) == 'parents' ? 'active' : '' }}">
            <a href="{{ route('superadmin.parents') }}" class="menu-link">
                <i class='menu-icon bx bx-user-pin' ></i>
                <div data-i18n="Analytics">Parents</div>
            </a>
        </li>
        {{-- <!-- Layouts -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Layouts</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="layouts-without-menu.html" class="menu-link">
                        <div data-i18n="Without menu">Without menu</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="layouts-without-navbar.html" class="menu-link">
                        <div data-i18n="Without navbar">Without navbar</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="layouts-container.html" class="menu-link">
                        <div data-i18n="Container">Container</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="layouts-fluid.html" class="menu-link">
                        <div data-i18n="Fluid">Fluid</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="layouts-blank.html" class="menu-link">
                        <div data-i18n="Blank">Blank</div>
                    </a>
                </li>
            </ul>
        </li> --}}
        {{-- <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Teams</span>
        </li> --}}
        {{--  @can('Manage Roles')
            <li class="menu-item {{ request()->is('roles') ? 'active' : '' }}">
                <a href="{{ route('roles') }}" class="menu-link ">

                    <i class="menu-icon fa-solid fa-user-gear"></i>
                    Manage Roles
                </a>
            </li>
        @endcan

        @can('Manage Users')
            <li class="menu-item {{ request()->is('users') ? 'active' : '' }}">
                <a href="{{ route('users') }}" class="menu-link ">

                    <i class="menu-icon  fa-solid fa-people-roof"></i>
                    Manage Users
                </a>
            </li>
        @endcan
        @can('Manage Permissions')
            <li class="menu-item {{ request()->is('permissions') ? 'active' : '' }}">
                <a href="{{ route('permissions') }}" class="menu-link ">
                    <i class="menu-icon fa-solid fa-person-circle-check"></i>

                    Manage Permissions
                </a>
            </li>
        @endcan  --}}


    </ul>
</aside>
@push('footer-script')
    <script>
        // Add active class to the current button (highlight it)
        var header = document.getElementById("sidebar_btn");
        var btns = header.getElementsByClassName("menu-item");
        for (var i = 0; i < btns.length; i++) {
            btns[i].addEventListener("click", function() {
                var current = document.getElementsByClassName("active");
                current[0].className = current[0].className.replace("active", "");
                this.className += " active";
            });
        }
    </script>
@endpush
