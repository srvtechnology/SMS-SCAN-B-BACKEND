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
        <li class="menu-item {{ request()->segment(2) == 'dashboard' ? 'active' : '' }}">
            <a href="{{ url('school/dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        {{--  <li class="menu-item {{ request()->segment(2) == 'sections' ? 'active' : '' }}">
            <a href="{{ route('school.sections') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Sections</div>
            </a>
        </li>  --}}

        <!-- Layouts -->
        <li class="menu-item @if(request()->segment(2) == 'sections' OR request()->segment(2) == 'subjects' OR request()->segment(2) == 'class') active open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Academics</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ request()->segment(2) == 'sections' ? 'active' : '' }}">
                    <a href="{{ route('school.sections') }}" class="menu-link">
                        <div data-i18n="Without menu">Sections</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->segment(2) == 'subjects' ? 'active' : '' }}">
                    <a href="{{ route('school.subjects') }}" class="menu-link">
                        <div data-i18n="Without menu">Subjects</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->segment(2) == 'class' ? 'active' : '' }}">
                    <a href="{{ route('school.class') }}" class="menu-link">
                        <div data-i18n="Without menu">Class</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item @if(request()->segment(2) == 'teachers' OR request()->segment(2) == 'designations' OR request()->segment(2) == 'students' OR request()->segment(2) == 'parents') active open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon bx bxs-user-detail'></i>
                <div data-i18n="Layouts">Human Resource</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ request()->segment(2) == 'designations' ? 'active' : '' }}">
                    <a href="{{ route('school.designations') }}" class="menu-link">
                        <div data-i18n="Without menu">Designation</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->segment(2) == 'teachers' ? 'active' : '' }}">
                    <a href="{{ route('school.teachers') }}" class="menu-link">
                        <div data-i18n="Without menu">Teachers</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->segment(2) == 'students' ? 'active' : '' }}">
                    <a href="{{ route('school.students') }}" class="menu-link">
                        <div data-i18n="Without menu">Student</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->segment(2) == 'parents' ? 'active' : '' }}">
                    <a href="{{ route('school.parents') }}" class="menu-link">
                        <div data-i18n="Without menu">Parents</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item @if(request()->segment(2) == 'study-material') active open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon bx bxs-user-detail'></i>
                <div data-i18n="Layouts">Study Material</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ request()->segment(3) == 'view-content' ? 'active' : '' }}">
                    <a href="{{ route('school.studyMaterial.view-content') }}" class="menu-link">
                        <div data-i18n="Without menu">Upload Content</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item @if(request()->segment(2) == 'time-table') active open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon bx bxs-user-detail'></i>
                <div data-i18n="Layouts">Timetable</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ request()->segment(3) == 'setting' ? 'active' : '' }}">
                    <a href="{{ route('school.timetable.setting') }}" class="menu-link">
                        <div data-i18n="Without menu">Setting</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->segment(3) == 'periods' ? 'active' : '' }}">
                    <a href="{{ route('school.timetable.periods') }}" class="menu-link">
                        <div data-i18n="Without menu">Periods</div>
                    </a>
                </li>
            </ul>
        </li>


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
