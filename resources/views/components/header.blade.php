<header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b></b></span>
    {{--<span class="logo-mini"><b><img src="http://www.popsmart.cn/Src/static/favicon.ico" alt=""></b></span>--}}
    <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>{{config('app.name')}}</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <li class="dropdown user user-menu">
                    <a href="#">
                        <img src="{{url('/dist/img/user2-160x160.jpg')}}" class="user-image" alt="User Image">
                        <span class="hidden-xs">@auth {{Auth::user()->name}} @endauth</span>
                    </a>

                </li>
            </ul>
        </div>
    </nav>
</header>