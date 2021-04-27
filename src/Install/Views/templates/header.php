<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/css/style.css">
    <title>Codeigniter 4</title>
  </head>
  <body>
    <?php
      $uri = service('uri');
     ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/">Codeigniter</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <?php if (session()->get('isLoggedIn')): ?>
      <ul class="navbar-nav mr-auto">
        <li class="nav-item <?= ($uri->getSegment(1) == 'dashboard' ? 'active' : null) ?>">
          <a class="nav-link"  href="/dashboard">Dashboard</a>
        </li>
        <li class="nav-item <?= ($uri->getSegment(1) == 'profile' ? 'active' : null) ?>">
          <a class="nav-link" href="/profile">Profile</a>
        </li>
      </ul>
      <ul class="navbar-nav my-2 my-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="/logout">Logout</a>
        </li>
      </ul>
    <?php else: ?>
      <ul class="navbar-nav mr-auto">
        <li class="nav-item <?= ($uri->getSegment(1) == '' ? 'active' : null) ?>">
          <a class="nav-link" href="/">Login</a>
        </li>
        <li class="nav-item <?= ($uri->getSegment(1) == 'register' ? 'active' : null) ?>">
          <a class="nav-link" href="/register">Register</a>
        </li>
      </ul>
      <?php endif; ?>
  </div>
</nav>
