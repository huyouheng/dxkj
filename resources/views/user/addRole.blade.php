@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{trans('admin.new')}} <b>{{$user->name}}</b> {{trans('admin.role')}}</h3>
                        <div class="box-tools">
                            <div class="btn-group pull-right" style="margin-right: 10px">
                                <a href="{{route('user')}}" class="btn btn-sm btn-default form-history-back"><i
                                            class="fa fa-arrow-left"></i>&nbsp;{{trans('admin.back')}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <form action="{{route('user.storeRole',['id'=>$user->id])}}" method="post" pjax-container
                              accept-charset="UTF-8" onsubmit="return getAllOpt()">
                            @csrf
                            <table class="table table-bordered">
                                <tr>
                                    <th class="text-center">所有角色</th>
                                    <th></th>
                                    <th class="text-center">已有角色</th>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <button class="btn btn-xs" style="width: 100%;" id="add_all" type="button">
                                            <span class="glyphicon glyphicon-arrow-right"></span>
                                            <span class="glyphicon glyphicon-arrow-right"></span>
                                        </button>
                                    </td>
                                    <td></td>
                                    <td class="text-center">
                                        <button class="btn btn-xs" style="width: 100%;" id="remove_all" type="button">
                                            <span class="glyphicon glyphicon-arrow-left"></span>
                                            <span class="glyphicon glyphicon-arrow-left"></span>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <select multiple="multiple" id="select1"
                                                style="width:200px;min-height:400px; max-height: 600px; border:1px #A0A0A4 outset; padding:4px; text-align: center;">
                                        </select>
                                        <nav id="pagination">
                                            <ul class="pagination" id="nav_pagination">
                                            </ul>
                                        </nav>
                                    </td>
                                    <td class="" style="vertical-align: middle;">
                                        <button class="btn btn-sm btn-info" style="width: 100%;" id="add" type="button">
                                            <span class="glyphicon glyphicon-arrow-right"></span>
                                        </button>
                                        <br>
                                        <br>
                                        <button class="btn btn-sm btn-dark" style="width: 100%;" id="remove"
                                                type="button">
                                            <span class="glyphicon glyphicon-arrow-left"></span>
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <select name="roles[]" multiple="multiple" id="select2"
                                                style="width: 200px;height:400px;max-height: 600px;  border:1px #A0A0A4 outset; padding:4px;text-align: center;">
                                            @foreach($user->roles as $role)
                                                <option value="{{$role['id']}}" selected>{{$role['name']}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-center">
                                        <div class="col-md-6">
                                            <div class="btn-group pull-right">
                                                <button type="submit" class="btn btn-info pull-right"
                                                        data-loading-text="<i class='fa fa-spinner fa-spin '></i> 提交">提交
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            initData(1);

            //移到右边
            $('#add').click(function () {
                addToRight();
            });
            //移到左边
            $('#remove').click(function () {
                removeItem();
            });
            //全部移到右边
            $('#add_all').click(function () {
                var select = document.getElementById('select1');
                for (var i = 0; i < select.options.length; i++) {
                    select.options[i].selected = true;
                }
                addToRight();
            });
            //全部移到左边
            $('#remove_all').click(function () {
                var obj = document.getElementById('select2');
                obj.options.length = 0;
            });
            //双击选项
            $('#select1').dblclick(function () { //绑定双击事件
                addToRight();
            });
            //双击选项
            $('#select2').dblclick(function () {
                removeItem();
            });
        });

        function isExistsSelect(text, value) {
            var isExit = false;
            var select = document.getElementById('select2');
            for (var i = 0; i < select.length; i++) {
                if (select[i].value == value && select[i].text == text) {
                    isExit = true;
                    break;
                }
            }
            return isExit;
        }

        function addToRight() {
            var select = document.getElementById('select1');
            for (var i = 0; i < select.options.length; i++) {
                if (select[i].selected == true) {
                    if (!isExistsSelect(select[i].text, select[i].value)) {
                        var op = new Option(select[i].text, select[i].value);
                        document.getElementById('select2').options.add(op);
                    }
                }
            }
        }

        function removeItem() {
            var select = document.getElementById('select2');
            for (var i = 0; i < select.options.length; i++) {
                if (select[i].selected == true) {
                    // select.options.remove(i);
                    select.options.remove(i);
                    removeItem();
                }
            }
        }

        function initData(page) {
            $.ajax({
                url: '/dxkj/roles',
                dataType: 'json',
                method: 'GET',
                data: {
                    page: page,
                    is_ajax:true
                },
                success: function (response) {
                    var data = response.data;
                    var result = data.data;
                    if (result) {
                        var str = '';
                        result.forEach(function (item) {
                            str += '<option value=' + item.id + '>' + item.name + '</option>';
                        });
                        $('#select1').html(str)
                    }

                    var current_page = data.current_page;
                    var last_page = data.last_page;

                    var page = '';
                    for (var i = 1; i <= last_page; i++) {
                        if (i == current_page) {
                            $('#first_btn').addClass('disabled');
                            page += '<li class="active"><a href="#">' + i + '</a></li>';
                        } else {
                            page += '<li><a href="javascript:initData(' + i + ')">' + i + '</a></li>';
                        }
                    }
                    $('#nav_pagination').html(page);
                }
            });
        }

        function getAllOpt() {
            var options = document.querySelectorAll('#select2 option');
            Array.prototype.forEach.call(options, function (option) {
                option.selected = true;
            })
        }
    </script>
@endsection