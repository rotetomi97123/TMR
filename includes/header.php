<?php  
    require_once 'config.php';
    if (session_status() === PHP_SESSION_NONE) {
          session_start();
      }  
?>
<nav class="navbar">
  <div class="nav-desktop-menu">
    <div class="nav-logo">
      <a href="<?= $base_url ?>">
        <img src="<?= $base_url ?>assets/StanoviSrbijeLogo.png" alt="logo">
      </a>
    </div>
    <ul class="nav-links">
      <li><a href="<?= $base_url ?>pages/results.php?type=apartment&listing_type=rent">Rent</a></li>
      <li><a href="<?= $base_url ?>pages/results.php?type=apartment&listing_type=sale">Buy</a></li>
      <?php if (isset($_SESSION['user_id'])): ?>
      <li><a href="<?= $base_url ?>pages/create-listing.php">Sell </a></li>
      <?php else: ?>
      <li><a href="<?= $base_url ?>auth/login.php">Sell </a></li>
    <?php endif; ?>
    </ul>
  </div>
  <div class="nav-auth">
    <?php if (isset($_SESSION['user_id'])): ?>
      <span class="nav-username">Welcome, <?= htmlspecialchars($_SESSION['username']) ?></span>
      <a href="<?= $base_url ?>auth/logout.php" class="nav-auth-logout" style="margin-left: 10px;">Logout</a>
      <a href="<?= $base_url ?>pages/profil.php" class="nav-auth-profil" style="margin-left: 10px;">Profil</a>
    <?php else: ?>
      <a href="<?= $base_url ?>pages/login.php" class="nav-auth-login">Login</a>
      <a href="<?= $base_url ?>pages/register.php" class="nav-auth-register">Sign Up</a>
    <?php endif; ?>
  </div>

  <div class="nav-toggle" id="menu-toggle">
    <i class="bi bi-list" id="menu-icon"></i>
  </div>

  <div class="nav-mobile-menu" id="mobile-menu">
    <ul class="nav-links-mobile">
      <li><a href="<?= $base_url ?>pages/results.php?type=apartment&listing_type=rent">Rent <i class="bi bi-chevron-right"></i></a></li>
      <li><a href="<?= $base_url ?>pages/results.php?type=apartment&listing_type=sale">Buy <i class="bi bi-chevron-right"></i></a></li>
      <?php if (isset($_SESSION['user_id'])): ?>
      <li><a href="<?= $base_url ?>pages/create-listing.php">Sell <i class="bi bi-chevron-right"></i></a></li>
      <?php else: ?>
      <li><a href="<?= $base_url ?>auth/login.php">Sell <i class="bi bi-chevron-right"></i></a></li>
    <?php endif; ?>

    </ul>
    <div class="nav-auth-mobile">
      <?php if (isset($_SESSION['user_id'])): ?>
        <span class="nav-username-mobile">Welcome, <?= htmlspecialchars($_SESSION['username']) ?></span>
        <a href="<?= $base_url ?>auth/logout.php" class="nav-auth-logout-mobile" style="margin-left: 10px;">Logout</a>
        <a href="<?= $base_url ?>pages/profil.php" class="nav-auth-profil-mobile" style="margin-left: 10px;">Profil</a>
      <?php else: ?>
        <a href="<?= $base_url ?>pages/login.php" class="nav-auth-login">Login</a>
        <a href="<?= $base_url ?>pages/register.php" class="nav-auth-register-mobile">Sign Up</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
