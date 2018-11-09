<header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini" style="font-size:18px !important;"><b>奉化区</b></span>
    {{--<span class="logo-mini"><b><img src="http://www.popsmart.cn/Src/static/favicon.ico" alt=""></b></span>--}}
    <!-- logo for regular state and mobile devices -->
        <span class="logo-lg" style="font-size:18px !important;"><b>{{config('app.name')}}</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                {{--<li class="dropdown user user-menu">--}}
                    {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">--}}
                        {{--<img src="{{url('/dist/img/user2-160x160.jpg')}}" class="user-image" alt="User Image">--}}
                        {{--<span class="hidden-xs">@auth {{Auth::user()->name}} @endauth</span>--}}
                        {{--<ul class="dropdown-menu">--}}
                            {{--<li>12</li>--}}
                        {{--</ul>--}}
                    {{--</a>--}}
                {{--</li>--}}
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <!-- The user image in the navbar-->
                        <img src="{{url('/dist/img/user2-160x160.jpg')}}" class="user-image" alt="User Image">
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">@auth {{Auth::user()->name}} @endauth</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-footer text-center">
                            <a href="/">返回前台页面</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>