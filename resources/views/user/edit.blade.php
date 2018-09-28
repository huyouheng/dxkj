@extends('layouts.admin')
@section('content')
    <script>
        $(function () {
            $('#fuck-refresh').click(function () {
                $.pjax.reload('#pjax-container');
                toastr.success('刷新成功');
            });
        })
    </script>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">编辑</h3>
                        <div class="box-tools">
                            <div class="btn-group pull-right" style="margin-right: 10px">
                                <a href="{{route('user')}}" class="btn btn-sm btn-default form-history-back"><i
                                            class="fa fa-arrow-left"></i>&nbsp;返回</a>
                            </div>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <form action="{{route('user-update',['id'=>$user->id])}}" method="post" class="form-horizontal" pjax-container>
                            @csrf()
                            @method("PUT")
                            <div class="box-body">

                                <div class="fields-group">

                                    <div class="form-group  ">
                                        <label for="name" class="col-sm-2 control-label">用户名</label>
                                        <div class="col-sm-8">

                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>

                                                <input type="text" id="name" name="name" value="{{ $user->name }}"
                                                       class="form-control name" placeholder="不能为空" required autofocus>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group  ">
                                        <label for="name" class="col-sm-2 control-label">邮箱</label>
                                        <div class="col-sm-8">

                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>

                                                <input type="email" id="eamil" name="email" value="{{ $user->email }}"
                                                       class="form-control name" placeholder="不能为空" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group  ">
                                        <label for="name" class="col-sm-2 control-label">密码</label>
                                        <div class="col-sm-8">

                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-eye-slash"></i></span>

                                                <input type="password" id="password" name="password"
                                                       value="@@@@@@?"
                                                       class="form-control name" placeholder="不能为空" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group  ">
                                        <label for="name" class="col-sm-2 control-label">确认密码</label>
                                        <div class="col-sm-8">

                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-eye-slash"></i></span>

                                                <input type="password" id="password-a" name="password-fore"
                                                       value="@@@@@@?"
                                                       class="form-control name" placeholder="不能为空" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">

                                <input type="hidden" name="_token" value="DQ0KhXL3RZzlTvDZGEGLFGmG9JcK5OFfYIaMsVZF">
                                <div class="col-md-2">

                                </div>
                                <div class="col-md-8">

                                    <div class="btn-group pull-right">
                                        <button type="submit" class="btn btn-info pull-right"
                                                data-loading-text="<i class='fa fa-spinner fa-spin '></i> 提交">提交
                                        </button>
                                    </div>

                                    <div class="btn-group pull-left">
                                        <button type="reset" class="btn btn-warning">撤销</button>
                                    </div>

                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection