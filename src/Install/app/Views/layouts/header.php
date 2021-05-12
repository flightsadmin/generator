<header class="navbar navbar-light bg-light sticky-top flex-md-nowrap p-0">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Flight Admin</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

    <?php
      $uri = service('uri');
    ?>
  <?php if (session()->get('isLoggedIn')): ?>
    <ul class="navbar-nav text-nowrap">
      <li class="nav-item <?= ($uri->getSegment(1) == 'profile' ? 'active' : null) ?>">
        <a class="nav-link" href="/profile"><i class="fa fa-user"></i> Profile</a>
      </li>
    </ul>
  <?php else: ?>
  <ul class="navbar-nav mr-auto ">
    <li class="nav-item <?= ($uri->getSegment(1) == '' ? 'active' : null) ?>">
      <a class="nav-link" href="/">Login</a>
    </li>
    <li class="nav-item <?= ($uri->getSegment(1) == 'register' ? 'active' : null) ?>">
      <a class="nav-link" href="/register">Register</a>
    </li>
  </ul>
  <?php endif; ?>
</header>