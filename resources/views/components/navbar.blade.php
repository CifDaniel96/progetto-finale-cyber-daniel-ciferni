<nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{route('homepage')}}">The Aulab Post</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{route('careers')}}">Work with us</a>
                </li>
            @auth
                <li class="nav-item">
                    <a class="btn btn-info" href="{{route('articles.create')}}">Write you Article</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Hi, {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                Profile
                            </a>
                        </li>
                        @if (Auth::user()->is_admin)
                            <li><a class="dropdown-item" href="{{route('admin.dashboard')}}">Admin panel</a></li>
                        @endif
                        @if (Auth::user()->is_revisor)
                            <li><a class="dropdown-item" href="{{route('revisor.dashboard')}}">Revisor panel</a></li>
                        @endif
                        @if (Auth::user()->is_writer)
                            <li><a class="dropdown-item" href="{{route('writer.dashboard')}}">Writer panel</a></li>
                        @endif
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.querySelector('#form-logout').submit();">Logout</a></li>
                        <form action="{{route('logout')}}" method="POST" id="form-logout" class="d-none">
                            @csrf
                        </form>
                    </ul>
                </li>
            @endauth
            @guest
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Welcome guest
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{route('register')}}">Sign Up</a></li>
                        <li><a class="dropdown-item" href="{{route('login')}}">Sign In</a></li>
                    </ul>
                </li>
            @endguest
            </ul>
            <form action="{{route('articles.search')}}" method="GET" class="d-flex" role="search">
                <input class="form-control me-2" type="search" name="query" placeholder="Search articles..." aria-label="Search">
                <button class="btn btn-outline-info" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>