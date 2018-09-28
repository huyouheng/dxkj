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
                        url: '/dxkj/roles/' + id,
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

            $('.lookRolePer').on('click', function () {
                var id = $(this).data('id');
                $.ajax({
                    method: 'get',
                    url: '/dxkj/role-permissions/' + id,
                    dataTyep: 'json',

                    success: function (data) {
                        var str = '<table class="table table-bordered"><thead><tr><th class="text-center">权限名</th><th class="text-center">描述</th></tr></thead><tbody>';
                        data.forEach(function (item) {
                            str += '<tr><td>' + item.name + '</td><td>' + item.description + '</td></tr>';
                        });
                        str += '</tbody></table>';
                        $('#showRolePerModal').html(str);
                        $('#grid-role-permission-modal').modal('show');
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
                        <a href="{{route('role-create')}}" class="btn btn-sm btn-success">
                            <i class="fa fa-save"></i>&nbsp;&nbsp;新增
                        </a>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>标识名</th>
                                <th>角色名</th>
                                <th>描述</th>
                                <th>角色权限</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{$role->display_name}}</td>
                                    <td>{{$role->name}}</td>
                                    <td>{{$role->description}}</td>
                                    <td>
                                        <a href="javascript:void(0)" class="lookRolePer" data-id="{{$role->id}}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{route('role.addPer',['id'=>$role->id])}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>{{$role->created_at}}</td>
                                    <td>
                                        <a href="{{route('role-edit',['id'=>$role->id])}}">
                                            <i class="fa fa-edit"></i>
                                        </a><a href="javascript:void(0);" data-id="{{$role->id}}"
                                               class="grid-row-delete">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer clearfix">
                        从 <b>1</b> 到 <b>{{$roles->perPage()}}</b>，总共 <b>{{$roles->total()}}</b> 条
                        <div class="pull-right">
                            {{$roles->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade in" id="grid-role-permission-modal" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-header" style="border-bottom-color: #595959">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">用户角色</h4>
                </div>
                <div class="modal-content text-center" id="showRolePerModal">

                </div>
            </div>
        </div>
    </div>
@endsection