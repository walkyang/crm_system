<div class="page-header">
        <nav class="navbar page-header">
            <a href="#" class="btn btn-link sidebar-mobile-toggle d-md-none mr-auto">
                <i class="fa fa-bars"></i>
            </a>

            <a class="navbar-brand" href="#">
                CRM-后台系统
                <!-- <img src="./imgs/logo.png" alt="logo"> -->
            </a>

            <a href="#" class="btn btn-link sidebar-toggle d-md-down-none">
                <i class="fa fa-bars"></i>
            </a>

            <ul class="navbar-nav ml-auto">
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="/imgs/avatar-1.png" class="avatar avatar-sm" alt="logo">
                        <span class="small ml-1 d-md-down-none">{{Request::cookie('admin_name','')}}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        
                        <a href="/admin/info/{{Request::cookie('admin_id','')}}" class="dropdown-item">
                            <i class="fa fa-user"></i> 个人信息
                        </a>

                        <a href="/" class="dropdown-item">
                            <i class="fa fa-lock"></i> 注销
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
    </div>