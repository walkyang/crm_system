@include('components.head')
@include('components.top')
<body class="sidebar-fixed header-fixed">
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
                    员工列表
                </div>
                
                <div class="card-body">
                    <form action="/admin/list" method="post" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="normal-input" class="form-control-label">用户名</label>
                                <input id="admin_name" name="admin_name" class="form-control" value="">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="normal-input" class="form-control-label">真实姓名</label>
                                <input id="real_name"  name="real_name" class="form-control" value="">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group" style="margin-top: 30px">
                            <button class="btn btn-primary">查 询</button>
                            {{csrf_field()}}
                            </div>
                        </div>
                    </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width:80px;"><input type="checkbox" id="check_all" name="check_all" >全选</th>
                                <th style="width:80px;">ID</th>
                                <th >用户名</th>
                                <th style="width:100px;">真实姓名</th>
                                <th style="width:100px;">是否离职</th>
                                <th style="width:180px;">入职日期</th>
                                <th style="width:200px;">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($admin_list as $k=>$v)
                                <tr>
                                    <td><input type="checkbox" id="check_admin_{{$v->admin_id}}" name="check_admin_{{$v->admin_id}}" ></td>
                                    <td>{{$v->admin_id}}</td>
                                    <td>{{$v->admin_name}}</td>
                                    <td>{{$v->real_name}}</td>
                                    <td>{{$v->is_quit == 1 ? "离职" : "在职"}}</td>
                                    <td>{{$v->created_time}}</td>
                                    <td><a href="/admin/info/{{$v->admin_id}}" class="btn-sm btn-info" @if($admin_power_arr){{!in_array("admin_edit", $admin_power_arr) ? "style=display:none": ""}} @endif>编 辑</a> 
                                    <a href="/admin/power/{{$v->admin_id}}" class="btn-sm btn-warning" @if($admin_power_arr){{!in_array("admin_power", $admin_power_arr) ? "style=display:none": ""}} @endif>权 限</a> 
                                    <a href="/admin/delete/{{$v->admin_id}}" class="btn-sm btn-danger" @if($admin_power_arr){{!in_array("admin_delete", $admin_power_arr) ? "style=display:none": ""}} @endif>删 除</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mb-4">
                        <a href="/admin/info" class="btn btn-secondary" style="color:#fff" @if($admin_power_arr){{!in_array("admin_add", $admin_power_arr) ? "style=display:none": ""}} @endif>新 增</a>
                        <button id="btn_delete" class="btn btn-danger" @if($admin_power_arr){{!in_array("admin_delete", $admin_power_arr) ? "style=display:none": ""}} @endif>删 除</button>
                        <button id="btn_power" class="btn btn-warning" @if($admin_power_arr){{!in_array("admin_power", $admin_power_arr) ? "style=display:none": ""}} @endif>权 限</button>
                        <button id="btn_import" class="btn btn-success" @if($admin_power_arr){{!in_array("admin_import", $admin_power_arr) ? "style=display:none": ""}} @endif>导 入</button>
                        <a href="/admin/export" class="btn btn-info" @if($admin_power_arr){{!in_array("admin_export", $admin_power_arr) ? "style=display:none": ""}} @endif>导 出</a>
                    </div>
                </div>

                <div class="am-cf">
                <?php echo $pagestr;?>
                </div>

            </div>
            
        </div>
     </div>     
    </div>
    </div>
    
    <div  class="card import">
        <div class="import_div ">
            <div class="progress mt-3">
                <div class="progress-bar bg-danger progress-bar-striped" role="progressbar" style="width: 0%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <input type="file" id="upload_file" style="margin-top: 10px;" />
            <input type="hidden" id="file_url" value="" />
            <input type="hidden" id="now_cnt" value="1" />
            <button id="btn_upload_file" class="btn btn-success" style="margin-top: 10px;">上传导入</button>
            <label id="upload_tip">请选择上传的文件..</label>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    </div>

</div>
</div>
@include('components.foot')
<script>
$("#check_all").click(function(){
    var this_status = $(this).is(':checked');
    if(this_status){
        $("input[type=checkbox][id^='check_admin_']").attr("checked",'true');
    }else{
        $("input[type=checkbox][id^='check_admin_']").removeAttr("checked");
    }
});
$("#btn_power").click(function(){
    var ids = "";
    $("input[type=checkbox][id^='check_admin_']:checkbox:checked").each(function(){
        var this_admin_id = $(this).attr('id').split('_')[2];
        if(this_admin_id){
            ids += this_admin_id+",";
        }
    });
    if(ids.length > 0){
        window.location.href="/admin/power/"+ids;
    }
    else{
        alert('请选择员工');
    }
});
$("#btn_delete").click(function(){
    var ids = "";
    $("input[type=checkbox][id^='check_admin_']:checkbox:checked").each(function(){
        var this_admin_id = $(this).attr('id').split('_')[2];
        if(this_admin_id){
            ids += this_admin_id+",";
        }
    });
    if(ids.length > 0){
        window.location.href="/admin/delete/"+ids;
    }
    else{
        alert('请选择员工');
    }
});
$("#btn_import").click(function(){
    $(".import").show();
    $(".import_div").show();
});
$('#btn_upload_file').click(function(){
    $("#upload_tip").html("上传中...");
    var file = document.getElementById("upload_file").files[0];
    var form = new FormData();
    form.append("file", file);
    form.append("path",'admin');
    form.append("_token","{{ csrf_token() }}");
    $.ajax({
        type: 'post', // 提交方式 get/post
        url: '/file/uploads', // 需要提交的 url
        data: form,
        contentType : false,
        processData: false,
        xhr: function() { //用以显示上传进度
            var xhr = $.ajaxSettings.xhr();
            if (xhr.upload) {
                xhr.upload.addEventListener('progress', function(event) {
                    var percent = Math.floor(event.loaded / event.total * 100);
                    document.querySelector(".progress .progress-bar").style.width = percent + "%";
//                    $("#datadd").html(percent + "%");
                }, false);
            }return xhr
        },
        success: function(data){
            if(data.code == 1){
                console.log(data);
                $("#file_url").val(data.url);
                $("#upload_tip").html("上传完成");
                $("#upload_tip").html("导入中...");
                document.querySelector(".progress .progress-bar").style.width = "0%";
                ajax_import();
            }else{
                $("#upload_tip").html(data.msg);
            }
        },
        error: function(){
        }
    });
});
function ajax_import(){
    var file_url = $("#file_url").val();
    var now_cnt = $("#now_cnt").val();
    var form = new FormData();
    form.append("file_url", file_url);
    form.append("now_cnt", now_cnt);
    form.append("_token","{{ csrf_token() }}");
    $.ajax({
        type: 'post', // 提交方式 get/post
        url: '/admin/import', // 需要提交的 url
        data: form,
        processData: false,
        contentType : false,
        success: function(data){
            if(data.code == 1){
                console.log(data);
                document.querySelector(".progress .progress-bar").style.width ="100%";
                $("#upload_tip").html("导入完成");
            }else if(data.code == 2){
                console.log(data);
                $("#now_cnt").val(data.now_cnt);
                var percent = Math.floor(data.now_cnt / data.total_cnt * 100);
                document.querySelector(".progress .progress-bar").style.width = percent + "%";
                ajax_import();
            }
            else{
                $("#upload_tip").html(data.msg);
            }
        },
        error: function(){
        }
    });
}
$(".close").click(function(){
    $(".import").hide();
});
</script>