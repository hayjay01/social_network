<nav class="navbar navbar-default">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ route('home') }}">MySocial</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      @if (Auth::check())
      <ul class="nav navbar-nav">
        <li><a href="{{ route('home') }}">Timeline</a></li>
        @if(count(Auth::user()->friendRequests()) === 0)
          <li><a href="{{ route('friends.index') }}">Friends</a></li>
        @else
          <li><a href="{{ route('friends.index') }}">Friends <span class="badge">{{ count(Auth::user()->friendRequests()) }}</span></a></li>
        @endif
      </ul>
      <form class="navbar-form navbar-left" action="{{ route('search.results') }}">
        <div class="form-group">
          <input type="text" class="form-control" name="query" placeholder="Find Friends">
        </div>
        <button type="submit" class="btn btn-default">Search</button>
        
      </form>
      @endif
      <ul class="nav navbar-nav navbar-right">
        @if (Auth::check())
        <li><a href="{{ route('profile.index', ['username'=>Auth::user()->username]) }}">{{ Auth::user()->getNameOrUsername() }}</a></li>
        <li><a href="{{ route('profile.edit') }}">Update Profile</a></li>
        <li><a href="{{ route('auth.signout') }}">Sign Out</a></li>
        @else
        <li><a href="{{ route('auth.signup') }}">Sign up</a></li>
        <li><a href="{{ route('auth.signin') }}">Sign in</a></li>
        @endif
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>