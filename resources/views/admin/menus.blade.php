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
        @foreach(App\Models\Admin\Menu::lists() as $v)
          <li class="{{ Request::getUri() == $v['url'] ? 'active' : '' }}">
              <a href="{{ $v['url'] }}" data="{{ Request::getUri() }}" data="{{ $v['url'] }}">
                  <i class="{{ $v['ico'] }}"></i>
                  <span class="nav-label">{{ $v['name'] }} </span>
                  @if(isset($v['child']))
                  <span class="fa arrow"></span>
                  @endif
              </a>
              @if(isset($v['child']))
              <ul class="nav nav-second-level">
                  @foreach($v['child'] as $vv)
                    <li><a class="J_menuItem {{ Request::getUri() == $vv['url'] ? 'current' : '' }}" href="{{ $vv['url'] }}"><i class="{{ $vv['ico'] }}"></i>{{ $vv['name'] }}</a></li>
                  @endforeach
              </ul>
              @endif
          </li>
        @endforeach
      </ul>
    </div>
  </nav>