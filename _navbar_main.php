<nav class="navbar">
  <div class="navbar__container">
    <a href="main.php">
      <div class="navbar__heading">
        <h1>Clocker</h1>
        <img src="./images/logo.svg" alt="Clocker logo" />
      </div>
    </a>

    <ul class="navbar__list">
      <a href="projects.php" class="navbar__list-item">
        Projects
      </a>
      <a href="groups.php" class="navbar__list-item">
        Groups
      </a>
      <a href="reports.php" class="navbar__list-item">
        Reports
      </a>
    </ul>

    <div class="navbar__buttons-container">
      <a class="btn-primary btn-primary--filled" href="logout.php">
        Log out</a>
    </div>

    <!-- Mobile menu -->
    <div class="navbar__menu-toggle" id="menu-toggle">
      <span></span>
      <span></span>
      <span></span>
    </div>

    <div class="navbar__mobile-menu" id="mobile-menu">
      <a href="projects.php" class="navbar__list-item mobile-link">
        Projects
      </a>
      <a href="groups.php" class="navbar__list-item mobile-link">
        Groups
      </a>
      <a href="reports.php" class="navbar__list-item mobile-link">
        Reports
      </a>

      <a class="btn-primary btn-primary--filled" href="logout.php">Log out</a>
    </div>
  </div>
</nav>