
@include('components.head')
@include('components.top')
<body class="sidebar-fixed header-fixed">

<form action="/admin/power/add" method="post" class="form-horizontal">

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
                    员工权限
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <div class="toggle-switch" data-ts-color="warning">
                                        <label for="customer_all" class="ts-label">客户管理：</label>
                                        <input id="customer_all" name="customer_all" type="checkbox" hidden="hidden"/>
                                        <label for="customer_all" class="ts-helper"></label>
                                    </div>
                                </div>
                                <div class="card-body">
                                        <div class="toggle-switch" data-ts-color="warning">
                                            <label for="customer_view" class="ts-label">查看：</label>
                                            <input id="customer_view" name="customer_view" type="checkbox" hidden="hidden"/>
                                            <label for="customer_view" class="ts-helper"></label>
                                        </div>
                                       <div class="toggle-switch" data-ts-color="warning">
                                            <label for="customer_add" class="ts-label">新增：</label>
                                            <input id="customer_add" name="customer_add" type="checkbox" hidden="hidden"/>
                                            <label for="customer_add" class="ts-helper"></label>
                                        </div>
                                        <div class="toggle-switch" data-ts-color="warning">
                                            <label for="customer_edit" class="ts-label">编辑：</label>
                                            <input id="customer_edit" name="customer_edit" type="checkbox" hidden="hidden"/>
                                            <label for="customer_edit" class="ts-helper"></label>
                                        </div>
                                        <div class="toggle-switch" data-ts-color="warning">
                                            <label for="customer_delete" class="ts-label">删除：</label>
                                            <input id="customer_delete" name="customer_delete" type="checkbox" hidden="hidden"/>
                                            <label for="customer_delete" class="ts-helper"></label>
                                        </div>
                                        <div class="toggle-switch" data-ts-color="warning">
                                            <label for="customer_import" class="ts-label">导入：</label>
                                            <input id="customer_import" name="customer_import" type="checkbox" hidden="hidden"/>
                                            <label for="customer_import" class="ts-helper"></label>
                                        </div>
                                        <div class="toggle-switch" data-ts-color="warning">
                                            <label for="customer_export" class="ts-label">导出：</label>
                                            <input id="customer_export" name="customer_export" type="checkbox" hidden="hidden"/>
                                            <label for="customer_export" class="ts-helper"></label>
                                        </div>
                                    
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <div class="toggle-switch" data-ts-color="warning">
                                        <label for="admin_all" class="ts-label">员工管理：</label>
                                        <input id="admin_all" name="admin_all" type="checkbox" hidden="hidden"/>
                                        <label for="admin_all" class="ts-helper"></label>
                                    </div>
                                </div>
                                <div class="card-body">
                                        <div class="toggle-switch" data-ts-color="warning">
                                            <label for="admin_view" class="ts-label">查看：</label>
                                            <input id="admin_view" name="admin_view" type="checkbox" hidden="hidden" @if($is_power_arr){{ in_array("admin_view", $is_power_arr) ? "checked='checked'": ""}} @endif />
                                            <label for="admin_view" class="ts-helper"></label>
                                        </div>
                                       <div class="toggle-switch" data-ts-color="warning">
                                            <label for="admin_add" class="ts-label">新增：</label>
                                            <input id="admin_add" name="admin_add" type="checkbox" hidden="hidden" @if($is_power_arr){{ in_array("admin_add", $is_power_arr) ? "checked='checked'": ""}} @endif/>
                                            <label for="admin_add" class="ts-helper"></label>
                                        </div>
                                        <div class="toggle-switch" data-ts-color="warning">
                                            <label for="admin_edit" class="ts-label">编辑：</label>
                                            <input id="admin_edit" name="admin_edit" type="checkbox" hidden="hidden" @if($is_power_arr){{ in_array("admin_edit", $is_power_arr) ? "checked='checked'": ""}} @endif/>
                                            <label for="admin_edit" class="ts-helper"></label>
                                        </div>

                                        <div class="toggle-switch" data-ts-color="warning">
                                            <label for="admin_delete" class="ts-label">删除：</label>
                                            <input id="admin_delete" name="admin_delete" type="checkbox" hidden="hidden" @if($is_power_arr){{ in_array("admin_delete", $is_power_arr) ? "checked='checked'": ""}} @endif/>
                                            <label for="admin_delete" class="ts-helper"></label>
                                        </div>

                                        <div class="toggle-switch" data-ts-color="warning">
                                            <label for="admin_power" class="ts-label">权限：</label>
                                            <input id="admin_power" name="admin_power" type="checkbox" hidden="hidden" @if($is_power_arr){{ in_array("admin_power", $is_power_arr) ? "checked='checked'": ""}} @endif/>
                                            <label for="admin_power" class="ts-helper"></label>
                                        </div>

                                        <div class="toggle-switch" data-ts-color="warning">
                                            <label for="admin_import" class="ts-label">导入：</label>
                                            <input id="admin_import" name="admin_import" type="checkbox" hidden="hidden" @if($is_power_arr){{ in_array("admin_import", $is_power_arr) ? "checked='checked'": ""}} @endif/>
                                            <label for="admin_import" class="ts-helper"></label>
                                        </div>

                                        <div class="toggle-switch" data-ts-color="warning">
                                            <label for="admin_export" class="ts-label">导出：</label>
                                            <input id="admin_export" name="admin_export" type="checkbox" hidden="hidden" @if($is_power_arr){{ in_array("admin_export", $is_power_arr) ? "checked='checked'": ""}} @endif/>
                                            <label for="admin_export" class="ts-helper"></label>
                                        </div>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="toggle-switch" data-ts-color="warning">
                                    <label for="check_all" class="ts-label">全部：</label>
                                    <input id="check_all" name="check_all" type="checkbox" hidden="hidden"/>
                                    <label for="check_all" class="ts-helper"></label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                        <div class="form-group">
                        <button class="btn btn-success">提交保存</button>
                        <input type="hidden" name="admin_ids" value="{{$ids}}" />
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
<script>
$("input[id$='_all']").click(function(){
    var this_id = $(this).attr('id');
    var this_block = $(this).attr('id').split('_')[0];
    var this_status = $(this).is(':checked');
    if(this_status){
        if(this_block == "check"){
            $("input[type=checkbox]").attr("checked",'true');
        }else{
            $("input[type=checkbox][id^='"+this_block+"_']").attr("checked",'true');
        }
    }else{
        if(this_block == "check"){
            $("input[type=checkbox]").removeAttr("checked");
        }else{
            $("input[type=checkbox][id^='"+this_block+"_']").removeAttr("checked");
        }
    }
});
</script>