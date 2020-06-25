<header class="main-header">
  <a href="#" class="logo">
    <span class="logo-mini">H</span>
    <span>Herbanext</span>
  </a>
  <nav class="navbar navbar-static-top">
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            @if (isset(Auth::user()->avatar_location))
              <img src="{{ route('dashboard.profile.view_avatar', Auth::user()->slug) }}" class="user-image" alt="User Image">
            @else
              <img src="{{ asset('images/avatar.jpeg') }}" class="user-image" alt="User Image">
            @endif
            @if(Auth::check())
              {{ __sanitize::html_encode(Auth::user()->firstname) }}
            @endif
          </a>
          <ul class="dropdown-menu">
            <li class="user-header">
              @if (isset(Auth::user()->avatar))
                <img src="data:image/jpg;base64,{{ Auth::user()->avatar }}" class="img-circle" alt="User Image">
              @else
                <img src="{{ asset('images/avatar.jpeg') }}" class="img-circle" alt="User Image">
              @endif
              <p>
                @if(Auth::check())
                  {{ __sanitize::html_encode(Auth::user()->firstname) .' '. __sanitize::html_encode(Auth::user()->lastname) }}
                  <small>{{ __sanitize::html_encode(Auth::user()->position) }}</small>
                @endif
                
              </p>
            </li>
            <li class="user-footer">
              <div class="pull-left">
                <a href="{{ route('dashboard.profile.details') }}" class="btn btn-default btn-flat">Profile</a>
              </div>
              <div class="pull-right">
                <a  href="{{ route('auth.logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();" class="btn btn-default btn-flat">Sign out</a>
              </div>
              <form id="frm-logout" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
              </form>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>