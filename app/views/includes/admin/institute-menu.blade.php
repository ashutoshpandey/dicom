<aside class="main-sidebar">

    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="dashboard">
                <a href="{{$root}}/admin-section">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="patients">
                <a href="{{$root}}/admin-patients">
                    <i class="fa fa-files-o"></i>
                    <span>Patients</span>
                </a>
            </li>
            <li class="experts">
                <a href="{{$root}}/manage-experts">
                    <i class="fa fa-files-o"></i>
                    <span>Experts</span>
                </a>
            </li>
            <li class="requests">
                <a href="{{$root}}/admin-requests">
                    <i class="fa fa-files-o"></i>
                    <span>Requests</span>
                </a>
            </li>
            <li class="categories">
                <a href="{{$root}}/admin-categories">
                    <i class="fa fa-laptop"></i>
                    <span>Categories</span>
                </a>
            </li>
            @if($adminType=='Administrator')
            <li class="users">
                <a href="{{$root}}/admin-users">
                    <i class="fa fa-laptop"></i>
                    <span>Users</span>
                </a>
            </li>
            @endif
            <li class="logout">
                <a href="{{$root}}/logout">
                    <i class="fa fa-table"></i> <span>Logout</span>
                </a>
            </li>
        </ul>
    </section>

</aside>