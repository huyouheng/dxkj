@extends('layouts.admin')
@section('content')
    <style>
        .files > li {
            float: left;
            width: 150px;
            border: 1px solid #eee;
            margin-bottom: 10px;
            margin-right: 10px;
            position: relative;
        }

        .files > li > .file-select {
            position: absolute;
            top: -4px;
            left: -1px;
        }

        .file-icon {
            text-align: center;
            font-size: 65px;
            color: #666;
            display: block;
            height: 100px;
        }

        .file-info {
            text-align: center;
            padding: 10px;
            background: #f4f4f4;
        }

        .file-name {
            font-weight: bold;
            color: #666;
            display: block;
            overflow: hidden !important;
            white-space: nowrap !important;
            text-overflow: ellipsis !important;
        }

        .file-size {
            color: #999;
            font-size: 12px;
            display: block;
        }

        .files {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .file-icon.has-img {
            padding: 0;
        }

        .file-icon.has-img > img {
            max-width: 100%;
            height: auto;
            max-height: 92px;
        }

        .operation {
            width: 25px;
            height: 23px;
            position: absolute;
            right: 0px;
            bottom: 0px;
            opacity: 0;
        }

        .dropdown-menu li {
            text-align: center;
        }
    </style>
    <script>
        $(function () {
            $('.files li').hover(function () {
                    $(this).find('.operation').css({'opacity': 1})
                },
                function () {
                    $(this).find('.operation').css({'opacity': 0})
                });
            $('.deleteUserFileOrDir').unbind('click').bind('click', function () {
                var path = $(this).data('path');
                var id = $(this).data('id');

                deleteTip(function () {
                    NProgress.start();
                    $.ajax({
                        method: 'post',
                        url: "{{route('media-delete')}}",
                        data: {
                            _method: 'delete',
                            _token: LA.token,
                            files: path
                        },
                        success: function (data) {
                            // $.pjax.reload('#pjax-container');
                            if (typeof data === 'object') {
                                if (data.status) {
                                    swal(data.message, '', 'success');
                                    $('#template-user-file-' + id).hide(200);
                                } else {
                                    swal(data.message, '', 'error');
                                }
                            }
                            NProgress.done();
                        }
                    });
                });
            }); //删除文件或者目录

            $('.file-upload').on('change', function () {
                $('.file-upload-form').submit();
            });

            $('#new-folder').on('submit', function (event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    method: 'POST',
                    url: '{{ $url['new-folder'] }}',
                    data: formData,
                    async: false,
                    success: function (data) {
                        $.pjax.reload('#pjax-container');

                        if (typeof data === 'object') {
                            if (data.status) {
                                toastr.success(data.message);
                            } else {
                                toastr.error(data.message);
                            }
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });

                closeModal();
            });
            $('#moveModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var name = button.data('name');

                var modal = $(this);
                modal.find('[name=path]').val(name)
                modal.find('[name=new]').val(name)
            });

            $('#urlModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var url = button.data('url');

                $(this).find('input').val(url)
            });

            $('.showFileurlModal').on('click', function () {
                $('#grid-modal-look-file-url').modal('show');
                var url = $(this).data('url');
                $('#setFileUrl').html(url);
            });
            $('#file-move').on('submit', function (event) {

                event.preventDefault();

                var form = $(this);

                var path = form.find('[name=path]').val();
                var name = form.find('[name=new]').val();

                $.ajax({
                    method: 'put',
                    url: '{{ $url['move'] }}',
                    data: {
                        path: path,
                        'new': name,
                        _token: LA.token,
                    },
                    success: function (data) {
                        $.pjax.reload('#pjax-container');

                        if (typeof data === 'object') {
                            if (data.status) {
                                toastr.success(data.message);
                            } else {
                                toastr.error(data.message);
                            }
                        }
                    }
                });

                closeModal();
            });
        });

        function refresh() {
            $.pjax.reload('#pjax-container');
        }


        function closeModal() {
            $("#moveModal").modal('toggle');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }

    </script>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>
                        <span><a class="btn btn-sm btn-primary grid-refresh" onclick="refresh()"><i
                                        class="fa fa-refresh"></i> {{trans('admin.refresh')}}</a></span>
                        <span>
                            <label class="btn btn-default btn"{{-- data-toggle="modal" data-target="#uploadModal"--}}>
                                <i class="fa fa-upload"></i>&nbsp;&nbsp;{{ trans('admin.upload') }}
                                <form action="{{ $url['upload'] }}" method="post" class="file-upload-form"
                                      enctype="multipart/form-data"
                                      pjax-container>
                                    <input type="file" name="files[]" class="hidden file-upload" multiple>
                                    <input type="hidden" name="dir" value="{{ $url['path'] }}"/>
                                    {{ csrf_field() }}
                                </form>
                            </label>
                        </span>
                        <span>
                            <a class="btn btn-default btn" data-toggle="modal" data-target="#newFolderModal">
                                <i class="fa fa-folder"></i>&nbsp;&nbsp;{{ trans('admin.new_folder') }}
                            </a>
                        </span>

                        <div class="clearfix"></div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                    </div>
                    <div class="box-footer clearfix">
                        <ol class="breadcrumb" style="margin-bottom: 10px;">

                            <li><a href="{{ route('media-index') }}"><i class="fa fa-th-large"></i> </a></li>

                            @foreach($nav as $item)
                                <li><a href="{{ $item['url'] }}"> {{ $item['name'] }}</a></li>
                            @endforeach
                        </ol>
                        <ul class="list-unstyled files">
                            @foreach($paginate as $key => $item)
                                <li id="template-user-file-{{$key}}">
                                    {!! $item['preview'] !!}
                                    <div class="file-info">
                                        @if($item['isDir'])
                                            <a href="{{ $item['link'] }}" class="file-name" title="{{ $item['name'] }}">
                                                {{ $item['icon'] }} {{ basename($item['name']) }}
                                            </a>
                                        @else
                                            <a href="javascript:void(0)" class="file-name" title="{{ $item['name'] }}">
                                                {{ $item['icon'] }} {{ basename($item['name']) }}
                                            </a>
                                        @endif
                                        <small>{{$item['time']}}</small>
                                        <span class="file-size">{{ $item['size'] }}&nbsp;</span>
                                    </div>

                                    <div class="btn-group operation">
                                        <button type="button" class="btn btn-success btn-xs dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            @unless($item['isDir'])
                                                <li>
                                                    <a href="{{ $item['download'] }}" target="_blank" class="btn-xs"><i
                                                                class="fa fa-download"></i>{{trans('admin.download')}}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" data-url="{{ $item['url'] }}"
                                                       class="showFileurlModal" target="_blank" class="btn-xs"><i
                                                                class="fa fa-anchor"></i>url</a>
                                                </li>
                                            @endunless

                                            <li>
                                                <a href="javascript:void(0)" class="deleteUserFileOrDir"
                                                   data-id="{{$key}}"
                                                   data-path="{{$item['path']}}" class="btn-xs">
                                                    <i class="fa fa-trash"></i>{{trans('admin.delete')}}
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="pull-right">
                        {{$paginate->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="newFolderModal" tabindex="-1" role="dialog" aria-labelledby="newFolderModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="newFolderModalLabel">{{trans('admin.new_folder')}}</h4>
                </div>
                <form id="new-folder">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" name="name"/>
                        </div>
                        <input type="hidden" name="dir" value="{{ $url['path'] }}"/>
                        {{ csrf_field() }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm"
                                data-dismiss="modal">{{trans('admin.close')}}</button>
                        <button type="submit" class="btn btn-primary btn-sm">{{trans('admin.submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="moveModal" tabindex="-1" role="dialog" aria-labelledby="moveModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="moveModalLabel">{{trans('admin.rename')}} & {{trans('admin.move')}}</h4>
                    <small>移动后,用户可能无法找到,请谨慎操作.根目录为`/`</small>
                </div>
                <form id="file-move">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">{{trans('admin.path')}}:</label>
                            <input type="text" class="form-control" name="new"/>
                        </div>
                        <input type="hidden" name="path"/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm"
                                data-dismiss="modal">{{trans('admin.cancel')}}</button>
                        <button type="submit" class="btn btn-primary btn-sm">{{trans('admin.submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade in" id="grid-modal-look-file-url" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">
                        <small>查看</small>
                    </h4>
                </div>
                <div class="modal-body">
                    <div id="grid-map-" style="height:max-height: 400px;">
                        <span id="setFileUrl"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection