<?php
session_start();
$role = $_SESSION['role'];
if($role!=='admin'){
  include('errors-404.php');
  exit;
}
?>
<aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="home.php"> <img alt="image" src="assets/img/logotip.png" class="header-logo" /> <span
                class="logo-name">KarNews</span>
            </a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown active">
              <a href="home.php" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="briefcase"></i><span>Category</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="category.php">Add Category</a></li>
                <li><a class="nav-link" href="category_all.php">All Categories</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="command"></i><span>Posts</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="add_post.php">Add Post</a></li>
                <li><a class="nav-link" href="view_post.php">View Post</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="mail"></i><span>Email</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="email.php">Inbox</a></li>
              </ul>
            </li>
            <li class="menu-header">Settings</li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="copy"></i><span>Settings</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="home_settings.php">Homepage settings</a></li>
                <li><a class="nav-link" href="about_settings.php">About settings</a></li>
                <li><a class="nav-link" href="team_settings.php">Team settings</a></li>
                <li><a class="nav-link" href="address_settings.php">Address settings</a></li>
              </ul>
            </li>
          </ul>
        </aside>