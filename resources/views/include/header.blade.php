<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container">
    <!-- Brand Name -->
    <a class="navbar-brand fw-bold text-primary" href="/">{{ config('app.name') }}</a>

    <!-- Toggle Button for Mobile View -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar Content -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Centered Search Bar -->
      <form class="d-flex mx-auto w-50" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-primary" type="submit">Search</button>
      </form>

      <!-- Navigation Links -->
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        @auth
          <li class="nav-item">
            <a class="nav-link text-dark" href="{{ route('posts.create') }}">Create Post</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-dark" href="{{ route('friend.list') }}">Follow List</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-dark" href="{{ route('messages.index') }}">Messages</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Account
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="{{ route('posts.create') }}">Create Post</a></li>
              <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">Logout</a></li>
            </ul>
          </li>
        @endauth
        @guest
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Guest
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="{{ route('registration') }}">Registration</a></li>
              <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
            </ul>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
