  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-light navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
        <?php
          $uri = service('uri');
        ?>
      <?php if (session()->get('isLoggedIn')): ?>
        <ul class="navbar-nav mr-auto">
          <li class="nav-item <?= ($uri->getSegment(1) == 'dashboard' ? 'active' : null) ?>">
            <a class="nav-link"  href="/dashboard"><i class="fa fa-home"></i> Dashboard</a>
          </li>
          <li class="nav-item <?= ($uri->getSegment(1) == 'profile' ? 'active' : null) ?>">
            <a class="nav-link" href="/profile"><i class="fa fa-user"></i> Profile</a>
          </li>
        </ul>
      <?php endif; ?>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Fulscreen Toggle Menu -->
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

      <?php if (session()->get('isLoggedIn')): ?>
      <ul class="navbar-nav">
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link" data-toggle="dropdown">
          <i class="fa fa-user fa-lg"></i> <span class="hidden-xs text-large">George Chitechi</span>
          <!-- <img src="/dist/img/avatar.png" class="user-image" alt="User Image"> -->
          
        </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header"><i class="fa fa-user fa-5x text-info"></i>
              <!-- <img src="/dist/img/avatar.png" class="img-circle" alt="User Image"> -->

              <p>
                George Chitechi
                <small class="text-info">george@flightsadmin.com</small>
                <small>Member since <?php echo date('M Y'); ?></small>
              </p>
            </li>
            <!-- Menu Body -->
            <li class="user-body">
              <div class="row px-2 d-flex justify-content-between align-items-center">
                  <div>
                    <a href="#" class="btn btn-info"><i class="fa fa-user"></i> Profile</a>
                  </div>
                  <div class="align-items-center">
                   <a class="btn btn-success" href="/logout"> <i class="fa fa-lock"></i>
                   Logout</a>
              </div>
              <!-- /.row -->
            </li>
          </ul>
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
    </ul>
  </nav>