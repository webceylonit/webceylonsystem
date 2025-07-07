<!-- Page Sidebar Start-->
<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper">
            <a href="{{ route('dashboard') }}">
                <img class="img-fluid for-light" src="{{ asset('frontend/assets/images/eSupport Logo.png') }}" alt="">
                <img class="img-fluid for-dark" src="{{ asset('frontend/assets/images/eSupport Logo.png') }}" alt="">
            </a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"></i></div>
        </div>

        <div class="logo-icon-wrapper">
            <a href="{{ route('dashboard') }}">
                <img class="img-fluid" src="{{ asset('frontend/assets/images/logo/logo-icon.png') }}" alt="">
            </a>
        </div>

        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn">
                        <a href="{{ route('dashboard') }}">
                            <img class="img-fluid" src="{{ asset('frontend/assets/images/logo/logo-icon.png') }}" alt="">
                        </a>
                        <div class="mobile-back text-end">
                            <span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i>
                        </div>
                    </li>

                    <li class="sidebar-main-title">
                        <div><h6 class="lan-1">General</h6></div>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="{{ route('dashboard') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#fill-home') }}"></use>
                            </svg>
                            <span class="lan-3">Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar-main-title">
                        <div><h6 class="lan-8">Management</h6></div>
                    </li>

                    {{-- ✅ Show Employee Management Only for Admin & Manager --}}
                    @if(Auth::user()->role->name === 'Admin' || Auth::user()->role->name === 'Manager')
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="#">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#fill-user') }}"></use>
                                </svg>
                                <span>Employee Management</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('employees.index') }}">Employee List</a></li>
                                <li><a href="{{ route('employees.create') }}">Add Employee</a></li>
                            </ul>
                        </li>
                    @endif

                    {{-- ✅ Project Management --}}
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#fill-user') }}"></use>
                            </svg>
                            <span>Project Management</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('projects.index') }}">Project List</a></li>

                            {{-- ✅ Only Admin & Manager Can Add Projects --}}
                            @if(Auth::user()->role->name === 'Admin' || Auth::user()->role->name === 'Manager')
                                <li><a href="{{ route('projects.create') }}">Add Projects</a></li>
                            @endif
                        </ul>
                    </li>

                    {{-- ✅ Message Management --}}
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#fill-user') }}"></use>
                            </svg>
                            <span>Message Management</span>
                        </a>
                        <ul class="sidebar-submenu">
                            @foreach(auth()->user()->projects as $project)
                                <li>
                                    <a href="{{ route('messages.index', ['project' => $project->id]) }}">
                                        {{ $project->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>


                    

                    

                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
<!-- Page Sidebar Ends-->

<style>
    .logo-wrapper img {
        height: 70px; /* Adjust height as needed */
        width: auto; /* Maintain aspect ratio */
        max-width: 150px; /* Set max width if necessary */
    }

    .logo-wrapper img.for-dark {
        height: 70px; /* Ensure dark mode logo has the same height */
        width: auto;
        max-width: 150px;
    }
</style>
