@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{trans('admin.edit')}}</h3>
                        <div class="box-tools">
                            <div class="btn-group pull-right" style="margin-right: 10px">
                                <a href="{{route('role')}}" class="btn btn-sm btn-default form-history-back"><i
                                            class="fa fa-arrow-left"></i>&nbsp;{{trans('admin.back')}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <form action="{{route('role-update',['id'=>$roles->id])}}" method="post" class="form-horizontal" pjax-container>
                            @csrf()
                            @method('PUT')
                            <div class="box-body">
                                <div class="fields-group">
                                    <div class="form-group  ">
                                        <label for="display_name" class="col-sm-2 control-label">标识名</label>
                                        <div class="col-sm-8">

                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>

                                                <input type="text" id="display_name" name="display_name"
                                                       value="{{ $roles->display_name }}"
                                                       class="form-control disabled" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group  ">
                                        <label for="name" class="col-sm-2 control-label">角色名</label>
                                        <div class="col-sm-8">

                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>

                                                <input type="text" id="name" name="name" value="{{ $roles->name }}"
                                                       class="form-control name" placeholder="不能为空,例如:管理员" required
                                                       autofocus>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group  ">
                                        <label for="description" class="col-sm-2 control-label">描述</label>
                                        <div class="col-sm-8">

                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>

                                                <input type="text" id="description" name="description"
                                                       value="{{ $roles->description }}"
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
                                                data-loading-text="<i class='fa fa-spinner fa-spin '></i> 提交">{{trans('admin.submit')}}
                                        </button>
                                    </div>

                                    <div class="btn-group pull-left">
                                        <button type="reset" class="btn btn-warning">{{trans('admin.reset')}}</button>
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