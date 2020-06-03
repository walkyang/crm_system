@include('components.head')
@include('components.top')
<body class="sidebar-fixed header-fixed">
<div class="page-wrapper">
<div class="main-container">
    @include('components.sidebar')
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <span class="display-1 d-block">您没有当前操作的权限！</span>
            </div>
        </div>
    </div>
</div>
</div>
@include('components.foot')
