
@include('components.head')
@include('components.top')
<body class="sidebar-fixed header-fixed">

<form action="/admin/add" method="post" class="form-horizontal">

<div class="page-wrapper">
<div class="main-container">
    @include('components.sidebar')

    <div class="content">
    
    @if(Session::has('message'))
    <div class="alert alert-dismissible alert-success">
        {{ Session::get('message') }},将在<span class="loginTime">3</span>秒后自动跳转！ 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <input type="hidden" id="success_url" value="{{ Session::get('url') }}" />
    </div>
    @endif
    @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
            <div class="alert alert-dismissible alert-danger">
                {{ $error }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endforeach
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-light">
                    员工信息
                    <a href="/admin/view-setting/info/{{$admin_id}}" class="btn-outline-info" style="float:right">自定义</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="normal-input" class="form-control-label">用户名：</label>
                                <input name="admin_name" class="form-control" value="@if($admin_info){{$admin_info->admin_name}} @endif">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="normal-input" class="form-control-label">姓名：</label>
                                <input name="real_name" class="form-control" value="@if($admin_info){{$admin_info->real_name}} @endif">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="normal-input" class="form-control-label">密码 (为空则不修改)：</label>
                                <input name="admin_pwd" class="form-control" type="password" value="">
                            </div>
                        </div>
                        <div class="col-md-12" @if($hidden_attribute_arr){{ in_array("admin_sex", $hidden_attribute_arr) ? "style=display:none": ""}} @endif>
                            <div class="form-group">
                                <label for="normal-input" class="form-control-label">性别：</label>
                                <input name="admin_sex" class="form-control"  value="@if($admin_info){{$admin_info->admin_sex}} @endif">
                            </div>
                        </div>
                        <div class="col-md-12" @if($hidden_attribute_arr){{ in_array("admin_mobile", $hidden_attribute_arr) ? "style=display:none": ""}} @endif>
                            <div class="form-group">
                                <label for="normal-input" class="form-control-label">电话：</label>
                                <input name="admin_mobile" class="form-control"  value="@if($admin_info){{$admin_info->admin_mobile}} @endif">
                            </div>
                        </div>
                        <div class="col-md-12" @if($hidden_attribute_arr){{ in_array("admin_address", $hidden_attribute_arr) ? "style=display:none": ""}} @endif>
                            <div class="form-group">
                                <label for="normal-input" class="form-control-label">地址：</label>
                                <input name="admin_address" class="form-control"  value="@if($admin_info){{$admin_info->admin_address}} @endif">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="toggle-switch" data-ts-color="danger">
                                    <label for="ts6" class="ts-label">是否离职：</label>
                                    <input id="ts6" name="is_quit" type="checkbox" hidden="hidden" @if($admin_info){{$admin_info->is_quit == 1 ? "checked='checked'": ""}} @endif />
                                    <label for="ts6" class="ts-helper"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                        <div class="form-group">
                        <button class="btn btn-success">提交保存</button>
                        <input type="hidden" name="admin_id" value="{{$admin_id}}" />
                        {{csrf_field()}}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
</div>
</form>
@include('components.foot')
