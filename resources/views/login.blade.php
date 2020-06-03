@include('components.head')
<body>
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

<form action="/login" method="post" class="form-horizontal">
<div class="page-wrapper flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card p-4">
                    <div class="card-header text-center text-uppercase h4 font-weight-light">
                        登 录
                    </div>

                    <div class="card-body py-5">
                        <div class="form-group">
                            <label class="form-control-label">用户名</label>
                            <input name="admin_name" class="form-control" value="admin">
                        </div>

                        <div class="form-group">
                            <label class="form-control-label">密码</label>
                            <input type="password" name="admin_pwd" class="form-control" value="123456">
                        </div>

                        <!-- <div class="custom-control custom-checkbox mt-4">
                            <input type="checkbox" class="custom-control-input" id="login">
                            <label class="custom-control-label" for="login">Check this custom checkbox</label>
                        </div> -->
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary px-5">登 录</button>
                                {{csrf_field()}}
                            </div>
                            <div class="col-6">
                                <a href="#" class="btn btn-link">忘记密码?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
</body>
@include('components.foot')
