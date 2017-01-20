<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>iServer | <?php if (!isset($_GET['p'])): ?>Login<?php else: ?><?= $Main->getPage($_GET['p']); ?><?php endif ?></title>
        <link rel="stylesheet" href="/assets/css/style.css">
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>
          <header>
          <div class="navbar">
              <div class="logo">
                  <a href="home">iServer</a>
              </div>
              <div class="logom">
                <a id="logom" href="#">Menu</a>
              </div>
              <div class="res">
                  <ul>
                    <li><a <?php if ($page == "server/setup"): ?>class="current"<?php endif ?> href="/server/setup">Server</a></li>
                    <li><a <?php if ($page == "server/info"): ?>class="current"<?php endif ?> href="/server/info">Server's Info</a></li>
                    <li><a <?php if ($page == "account"): ?>class="current"<?php endif ?> href="/account">My account</a></li>
                    <?php if (isset($_SESSION['user'])): ?>
                        <li <?php if ($page == "logout"): ?>class="current"<?php endif ?> class="vert"><a href="/logout">Logout</a></li>
                    <?php else: ?>
                        <li <?php if ($page == "login"): ?>class="current"<?php endif ?> class="vert"><a href="/login">Login</a></li>
                    <?php endif ?>
                  </ul>
              </div>
              <div class="nav">
                  <ul>
                    <li><a href="/server/setup">Server</a></li>
                    <li><a href="/server/info">Server's Info</a></li>
                    <li><a href="/account">My account</a></li>
                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="vert"><a href="/logout">logout</a></li>
                    <?php else: ?>
                        <li class="vert"><a href="/login">Login</a></li>
                    <?php endif ?>
                  </ul>
              </div>
          </div>
      </header>
      <div class="container">

      <?php if (isset($_SESSION['flash'])): ?>
        <?php foreach ($_SESSION['flash'] as $type => $msg): ?>
          <div id="dimissible" class="alert alert-<?= $type; ?>">
            <ul>
              <li><?= $msg; ?></li>
            </ul>
          </div>
      <?php endforeach ?>
      <?php unset($_SESSION['flash']); ?>
      <?php endif ?>
