<?php  if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }  ?>
<nav class="navbar">
  <div class="nav-desktop-menu">
    <div class="nav-logo">
      <a href="/project/">
        <img src="/project/assets/StanoviSrbijeLogo.png" alt="logo">
      </a>
    </div>
    <ul class="nav-links">
      <li><a href="index.php">Rent</a></li>
      <li><a href="index.php">Buy</a></li>
      <li><a href="index.php">Sell</a></li>
    </ul>
  </div>
  <div class="nav-auth">
    <?php if (isset($_SESSION['user_id'])): ?>
      <span class="nav-username">Welcome, <?= htmlspecialchars($_SESSION['username']) ?></span>
      <a href="/project/auth/logout.php" class="nav-auth-logout" style="margin-left: 10px;">Logout</a>
      <a href="/project/pages/profil.php" class="nav-auth-logout-mobile" style="margin-left: 10px;">Profil</a>
    <?php else: ?>
      <a href="/project/pages/login.php" class="nav-auth-login">Login</a>
      <a href="/project/pages/register.php" class="nav-auth-register">Sign Up</a>
    <?php endif; ?>
  </div>

  <div class="nav-toggle" id="menu-toggle">
    <i class="bi bi-list" id="menu-icon"></i>
  </div>

  <div class="nav-mobile-menu" id="mobile-menu">
    <ul class="nav-links-mobile">
      <li><a href="index.php">Rent <i class="bi bi-chevron-right"></i></a></li>
      <li><a href="index.php">Buy <i class="bi bi-chevron-right"></i></a></li>
      <li><a href="index.php">Sell <i class="bi bi-chevron-right"></i></a></li>
    </ul>
    <div class="nav-auth-mobile">
      <?php if (isset($_SESSION['user_id'])): ?>
        <span class="nav-username-mobile">Welcome, <?= htmlspecialchars($_SESSION['username']) ?></span>
        <a href="/project/auth/logout.php" class="nav-auth-logout-mobile" style="margin-left: 10px;">Logout</a>
        <a href="/project/pages/profil.php" class="nav-auth-logout-mobile" style="margin-left: 10px;">Profil</a>
      <?php else: ?>
        <a href="/project/pages/login.php" class="nav-auth-login">Login</a>
        <a href="/project/pages/register.php" class="nav-auth-register">Sign Up</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
