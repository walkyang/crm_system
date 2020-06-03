
@include('components.head')
@include('components.top')
<body class="sidebar-fixed header-fixed">

<form action="/admin/view-setting/add" method="post" class="form-horizontal">

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
                    自定义：员工管理显示字段
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <div class="toggle-switch" data-ts-color="warning">
                                        <label for="admin_view_all" class="ts-label">选择禁用字段：</label>
                                        <input id="admin_view_all" name="admin_view_all" type="checkbox" hidden="hidden"/>
                                        <label for="admin_view_all" class="ts-helper"></label>
                                    </div>
                                </div>
                                <div class="card-body">
                                        <div class="toggle-switch" data-ts-color="warning">
                                            <label for="admin_sex" class="ts-label">性别：</label>
                                            <input id="admin_sex" name="admin_sex" type="checkbox" hidden="hidden" @if($hidden_attribute_arr){{ in_array("admin_sex", $hidden_attribute_arr) ? "checked='checked'": ""}} @endif />
                                            <label for="admin_sex" class="ts-helper"></label>
                                        </div>
                                       <div class="toggle-switch" data-ts-color="warning">
                                            <label for="admin_mobile" class="ts-label">电话：</label>
                                            <input id="admin_mobile" name="admin_mobile" type="checkbox" hidden="hidden" @if($hidden_attribute_arr){{ in_array("admin_mobile", $hidden_attribute_arr) ? "checked='checked'": ""}} @endif />
                                            <label for="admin_mobile" class="ts-helper"></label>
                                        </div>
                                        <div class="toggle-switch" data-ts-color="warning">
                                            <label for="admin_address" class="ts-label">地址：</label>
                                            <input id="admin_address" name="admin_address" type="checkbox" hidden="hidden" @if($hidden_attribute_arr){{ in_array("admin_address", $hidden_attribute_arr) ? "checked='checked'": ""}} @endif />
                                            <label for="admin_address" class="ts-helper"></label>
                                        </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                        <div class="form-group">
                        <button class="btn btn-success">提交保存</button>
                        <input type="hidden" name="n_admin_id" value="{{$n_admin_id}}" />
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