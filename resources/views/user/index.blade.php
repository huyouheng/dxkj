@extends('layouts.admin')
@section('content')
    <script>
        $(function () {
            $('#fuck-refresh').click(function () {
                $.pjax.reload('#pjax-container');
                toastr.success('刷新成功');
            });

            $('.grid-row-delete').on('click', function () {
                var id = $(this).data('id');

                deleteTip(function () {
                    $.ajax({
                        method: 'post',
                        url: '/dxkj/users/' + id,
                        dataTyep: 'json',
                        data: {
                            _method: 'delete',
                            _token: LA.token,
                        },
                        success: function (data) {

                            if (data.code == 0) {
                                $.pjax.reload('#pjax-container');
                                swal(data.msg, '', 'success');
                            } else {
                                swal(data.msg, '', 'error');
                            }
                        }
                    });
                })
            });
            $('.lookUserRole').on('click', function () {
                var id = $(this).data('id');
                $.ajax({
                    method: 'get',
                    url: '/dxkj/users-role/' + id,
                    dataTyep: 'json',

                    success: function (data) {
                        var str = '<table class="table table-bordered"><thead><tr><th>角色名</th><th>描述</th></tr></thead><tbody>';
                        data.forEach(function (item) {
                            str += '<tr><td>' + item.name + '</td><td>' + item.description + '</td></tr>';
                        });
                        str += '</tbody></table>';
                        $('#showUserRoleModal').html(str);
                        $('#grid-user-role-modal').modal('show');
                    }
                });
            });
        })
    </script>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <a class="btn btn-sm btn-primary grid-refresh" id="fuck-refresh"><i class="fa fa-refresh"></i>
                            刷新</a>
                        <a href="{{route('user-create')}}" class="btn btn-sm btn-success">
                            <i class="fa fa-save"></i>&nbsp;&nbsp;新增
                        </a>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead>
                            <tr class="text-center">
                                <th class="text-center">用户名</th>
                                <th class="text-center">邮箱</th>
                                <th class="text-center">用户角色</th>
                                <th class="text-center">创建于</th>
                                <th class="text-center">上次登录</th>
                                <th class="text-center">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr class="text-center">
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        <a href="javascript:void(0)" class="lookUserRole" data-id="{{$user->id}}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{route('user.addRole',['id'=>$user->id])}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>{{$user->created_at}}</td>
                                    <td>{{$user->last_time}}</td>
                                    <td>
                                        <a href="{{route('user-edit',['id'=>$user->id])}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0);" data-id="{{$user->id}}"
                                           class="grid-row-delete">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div style="display: flex; height: 50px; line-height: 50px;">
                        <div style="width: 500px;">
                            从 <b>1</b> 到 <b>{{$users->perPage()}}</b>，总共 <b>{{$users->total()}}</b> 条
                        </div>
                        <div style="flex: 1;text-align: right;">
                            {{$users->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade in" id="grid-user-role-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-header" style="border-bottom-color: #595959">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">用户角色</h4>
                </div>
                <div class="modal-content" id="showUserRoleModal">

                </div>
            </div>
        </div>
    </div>
@endsection