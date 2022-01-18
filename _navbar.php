<nav class="navbar">
  <div class="navbar__container">
    <a href="index.php">
      <div class="navbar__heading">
        <h1>Clocker</h1>
        <img src="./images//logo.svg" alt="Clocker logo" />
      </div>
    </a>

    <ul class="navbar__list">
      <a href="index.php#hero" class="navbar__list-item">
        Home
      </a>
      <a href="index.php#about" class="navbar__list-item">
        About
      </a>
      <a href="index.php#statistics" class="navbar__list-item">
        Statistics
      </a>
    </ul>

    <div class="navbar__buttons-container">
      <a class="btn-primary" href="login.php">Sign in</a>
      <a class="btn-primary btn-primary--filled" href="register.php">Sign
        up</a>
    </div>

    <!-- Mobile menu -->
    <div class="navbar__menu-toggle" id="menu-toggle">
      <span></span>
      <span></span>
      <span></span>
    </div>

    <div class="navbar__mobile-menu" id="mobile-menu">
      <a href="index.php#hero" class="navbar__list-item mobile-link">
        Home
      </a>
      <a href="index.php#about" class="navbar__list-item mobile-link">
        About
      </a>
      <a href="index.php#statistics" class="navbar__list-item mobile-link">
        Statistics
      </a>

      <a class="btn-primary" href="login.php">Sign in</a>
      <a class="btn-primary btn-primary--filled" href="register.php">Sign
        up</a>
    </div>
  </div>
</nav>
