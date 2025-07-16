<!-- Page Sidebar Start-->
@php
use App\Services\PermissionService;
@endphp
<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper">
            <a href="{{ route('dashboard') }}">
                <img class="img-fluid for-light" style="height: auto;" src="{{ asset('frontend/assets/images/webceylon.png') }}" alt="">
                <img class="img-fluid for-dark" style="height: auto;" src="{{ asset('frontend/assets/images/webceylon.png') }}" alt="">
            </a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"></i></div>
        </div>

        <div class="logo-icon-wrapper">
            <a href="{{ route('dashboard') }}">
                <img class="img-fluid" style="width:45px;" src="{{ asset('frontend/assets/images/wcicon.png') }}" alt="">
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
                        <div>
                            <h6 class="lan-1">General</h6>
                        </div>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="{{ route('dashboard') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#fill-home') }}"></use>
                            </svg>
                            <span class="">Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="lan-8">Management</h6>
                        </div>
                    </li>
                    @permission('View Employees')
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="{{ route('clients.index') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#fill-user') }}"></use>
                            </svg>
                            <span>Client Management</span>
                        </a>

                    </li>
                    @endpermission


                    {{-- ✅ Project Management --}}
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#fill-file') }}"></use>
                            </svg>
                            <span>Project Management</span>
                        </a>
                        <ul class="sidebar-submenu">
                            @permission('Project Grid View')
                            <li><a href="{{ route('projects.index') }}">Grid View</a></li>
                            @endpermission
                            @permission('Project Table View')
                            <li><a href="{{ route('projects.tableView') }}">Table View</a></li>
                            @endpermission
                        </ul>
                    </li>

                    @permission('View Documents')
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#stroke-form') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#fill-form') }}"></use>
                            </svg>
                            <span>Documents</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('clientDocs.index') }}">Client Docs</a></li>
                            <li><a href="{{ route('projectDocs.index') }}">Project Docs</a></li>
                            <li><a href="{{ route('invoices.index') }}">Invoices</a></li>
                        </ul>
                    </li>
                    @endpermission

                    {{-- ✅ Message Management --}}
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="{{ route('messages.project_list') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#stroke-chat') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#fill-chat') }}"></use>
                            </svg>
                            <span>Message Management</span>
                        </a>

                    </li>

                    @permission('View Employees')
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="{{ route('employees.index') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#stroke-blog') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#fill-user') }}"></use>
                            </svg>
                            <span>Employee Management</span>
                        </a>

                    </li>
                    @endpermission

                    @permission('Role & Permissions')
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="{{ route('role.index') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#stroke-to-do') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#fill-to-do') }}"></use>
                            </svg>
                            <span>Role & Permissions</span>
                        </a>
                    </li>
                    @endpermission

                    




                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
<!-- Page Sidebar Ends-->

<style>
    .logo-wrapper img {
        height: 70px;
        /* Adjust height as needed */
        width: auto;
        /* Maintain aspect ratio */
        max-width: 150px;
        /* Set max width if necessary */
    }

    .logo-wrapper img.for-dark {
        height: 70px;
        /* Ensure dark mode logo has the same height */
        width: auto;
        max-width: 150px;
    }
</style>