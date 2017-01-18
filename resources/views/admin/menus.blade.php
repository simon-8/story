  <nav class="navbar-default navbar-static-side" role="navigation">
    <div class="nav-close"><i class="fa fa-times-circle"></i>
    </div>
    <div class="sidebar-collapse">
      <ul class="nav" id="side-menu">
        <li class="nav-header">
          <div class="dropdown profile-element">
            <span><img alt="image" class="img-circle" src="/skin/manager/img/profile_small.jpg" /></span>
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
              <span class="clear">
                <span class="block m-t-xs"><strong class="font-bold">刘文静</strong></span>
                <span class="text-muted text-xs block">超级管理员<b class="caret"></b></span>
              </span>
            </a>
            <ul class="dropdown-menu animated fadeInRight m-t-xs">
              <li><a class="J_menuItem" href="form_avatar.html">修改头像</a></li>
              <li><a class="J_menuItem" href="profile.html">个人资料</a></li>
              <li><a class="J_menuItem" href="contacts.html">联系我们</a></li>
              <li><a class="J_menuItem" href="mailbox.html">信箱</a></li>
              <li class="divider"></li>
              <li><a href="{{ route('getAdminLogout') }}">安全退出</a></li>
            </ul>
          </div>
          <div class="logo-element">SCMS</div>
        </li>
        <li>
          <a class="J_menuItem" href="{{ url() }}">
            <i class="fa fa fa-destop"></i> 
            <span class="nav-label">前台首页</span>
          </a>
        </li>
        <li>
          <a class="J_menuItem" href="{{ url('admin') }}">
            <i class="fa fa-home"></i> 
            <span class="nav-label">后台首页</span>
          </a>
        </li>
        <li>
          <a href="{{ url('admin/article') }}">
            <i class="fa fa-book"></i> 
            <span class="nav-label">文章管理 </span>
            <span class="fa arrow"></span>
          </a>
          <ul class="nav nav-second-level">
            <li><a class="J_menuItem" href="{{ url('admin/article') }}">文章列表</a></li>
            <li><a class="J_menuItem" href="{{ url('admin') }}">文章分类</a></li>
            <li><a class="J_menuItem" href="{{ url('admin') }}">评价</a></li>
            <li><a class="J_menuItem" href="{{ url('admin/article/recycle') }}">回收站</a></li>
          </ul>
        </li>
        <li>
          <a href="{{ url('admin/user') }}">
            <i class="fa fa-user"></i> 
            <span class="nav-label">用户管理 </span>
            <span class="fa arrow"></span>
          </a>
          <ul class="nav nav-second-level">
            <li><a class="J_menuItem" href="{{ url('admin/user') }}">用户列表</a></li>
            <li><a class="J_menuItem" href="{{ url('admin') }}">用户权限</a></li>
            <li><a class="J_menuItem" href="{{ url('admin/article/recycle') }}">回收站</a></li>
          </ul>
        </li>

        <li>
          <a href="{{ url('admin/article') }}">
            <i class="fa fa-picture-o"></i> 
            <span class="nav-label">相册管理 </span>
            <span class="fa arrow"></span>
          </a>
          <ul class="nav nav-second-level">
            <li><a class="J_menuItem" href="{{ url('admin/article') }}">相册列表</a></li>
            <li><a class="J_menuItem" href="{{ url('admin') }}">相册分类</a></li>
            <li><a class="J_menuItem" href="{{ url('admin/article/recycle') }}">回收站</a></li>
          </ul>
        </li>

        <li>
          <a href="{{ url('admin/article') }}">
            <i class="fa fa-wechat"></i> 
            <span class="nav-label">微信管理 </span>
            <span class="fa arrow"></span>
          </a>
          <ul class="nav nav-second-level">
            <li><a class="J_menuItem" href="{{ url('admin/article') }}">相册列表</a></li>
            <li><a class="J_menuItem" href="{{ url('admin') }}">相册分类</a></li>
            <li><a class="J_menuItem" href="{{ url('admin/article/recycle') }}">回收站</a></li>
          </ul>
        </li>

        <li>
          <a href="{{ url('admin/article') }}">
            <i class="fa fa-database"></i> 
            <span class="nav-label">数据管理 </span>
            <span class="fa arrow"></span>
          </a>
          <ul class="nav nav-second-level">
            <li><a class="J_menuItem" href="{{ url('admin/article') }}">相册列表</a></li>
            <li><a class="J_menuItem" href="{{ url('admin') }}">相册分类</a></li>
            <li><a class="J_menuItem" href="{{ url('admin/article/recycle') }}">回收站</a></li>
          </ul>
        </li>
        <li>
          <a href="{{ url('admin/user') }}">
            <i class="fa fa-cog"></i> 
            <span class="nav-label">系统设置 </span>
            <span class="fa arrow"></span>
          </a>
          <ul class="nav nav-second-level">
            <li><a class="J_menuItem" href="{{ url('admin/user') }}">基本设置</a></li>
            <li><a class="J_menuItem" href="{{ url('admin') }}">邮件配置</a></li>
            <li><a class="J_menuItem" href="{{ url('admin/article/recycle') }}">一键登录</a></li>
          </ul>
        </li>

      </ul>
    </div>
  </nav>