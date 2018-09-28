<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <title>Laravel</title>

        <script src="{{asset('js/app.js')}}"></script>
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div class="links">
                   <button onclick="test()">开始</button>
                    <br>
                    <button onclick="logout()">结束</button>
                    <br>
                    <button onclick="checkLogin()">是否登录</button><br><br>
                    <form action="/api/uploadFile" method="post" enctype="multipart/form-data">
                        <input type="file" name="files" /><br>
                        <input type="text" name="buildName" id=""><br>
                        type:<input type="text" name="type" id=""><br>

                        <input type="submit" value="上传dxf文件">
                    </form>
                </div>
            </div>
            
        </div>

        <script>
            function test(){
                $.ajax({
                    url: '/dxkj/login',
                    method: 'POST',
                    dataType: 'json',
                    data:{
                        "username":"test",
                        "password":"111111"
                    },
                    success: function(data){
                        console.log(data);
                    }

                });
            }

            function logout(){
                $.ajax({
                    url: '/dxkj/logout',
                    method: 'POST',
                    dataType: 'json',
                    data:{
                        "username":"admin",
                        "password":"111111"
                    },
                    success: function(data){
                        console.log(data);
                    }

                });
            }
            function checkLogin() {
                $.ajax({
                    url: '/dxkj/checkLogin',
                    method: 'POST',
                    dataType: 'json',
                    success: function(data){
                        console.log(data);
                    }

                });
            }
        </script>
    </body>
</html>
