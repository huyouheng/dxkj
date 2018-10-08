<aside class="main-sidebar">
    <section class="sidebar" style="height: auto;">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{url('/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>@auth {{Auth::user()->name}} @endauth</p>
                <a href="#"><i class="fa fa-circle text-success"></i> 在线</a>
            </div>
        </div>
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="header">公共功能</li>
            <li class="active">
                <a href="{{route('user')}}">
                    <i class="fa fa-user"></i> <span>用户</span>
                </a>
            </li>
            <li>
                <a href="{{route('role')}}">
                    <i class="fa fa-users"></i> <span>角色</span>
                </a>
            </li>
            <li>
                <a href="{{route('media-index')}}">
                    <i class="fa fa-file-text-o"></i> <span>文件管理</span>
                </a>
            </li>
        </ul>
    </section>
</aside>
<script>
    $(function () {
        $('.sidebar-menu').children().not($('.header')).click(function(){
            $(this).addClass('active');
            $('.sidebar-menu').children().not($(this)).removeClass('active');
        })
    });
</script>