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
                        url: '/dxkj/permissions/' + id,
                        dataTyep: 'json',
                        data: {
                            _method: 'delete',
                            _token: LA.token
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
        })
    </script>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <a class="btn btn-sm btn-primary grid-refresh" id="fuck-refresh"><i class="fa fa-refresh"></i>
                            刷新</a>
                        <a href="{{route('per-create')}}" class="btn btn-sm btn-success">
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
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($permissions as $permission)
                                <tr>
                                    <td>{{$permission->display_name}}</td>
                                    <td>{{$permission->name}}</td>
                                    <td>{{$permission->description}}</td>
                                    <td>{{$permission->created_at}}</td>
                                    <td>
                                        <a href="{{route('per-edit',['id'=>$permission->id])}}">
                                            <i class="fa fa-edit"></i>
                                        </a><a href="javascript:void(0);" data-id="{{$permission->id}}"
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
                        从 <b>1</b> 到 <b>{{$permissions->perPage()}}</b>，总共 <b>{{$permissions->total()}}</b> 条
                        <div class="pull-right">
                            {{$permissions->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection