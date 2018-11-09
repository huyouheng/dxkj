@extends('layouts.admin')
@section('content')
    <script>
        function refresh() {
            $.pjax.reload('#pjax-container');
            toastr.success('刷新成功');
        }
    </script>
    <style>
        th, td{
            text-align: center;
        }
        .pagination {
            margin: 10px 0 !important;
        }
    </style>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>
                        <span><a class="btn btn-sm btn-primary grid-refresh" onclick="refresh()"><i
                                        class="fa fa-refresh"></i> {{trans('admin.refresh')}}</a></span>
                        <span>
                        </span>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>文件名</th>
                                <th>类型</th>
                                <th>路径</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($files as $file)
                                <tr>
                                    <td>{{$file->buildName}}</td>
                                    <td>{{$file->type}}</td>
                                    <td>{{$file->url}}</td>
                                    <td>
                                        <a target="_blank" href="{{$file->url}}" class="btn btn-xs btn-info">下载</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer clearfix">
                        <div style="display: flex; height: 50px; line-height: 50px;">
                            <div style="width: 500px;">
                                从 <b>1</b> 到 <b>{{$files->perPage()}}</b>，总共 <b>{{$files->total()}}</b> 条
                            </div>
                            <div style="flex: 1;text-align: right;">
                                {{$files->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection