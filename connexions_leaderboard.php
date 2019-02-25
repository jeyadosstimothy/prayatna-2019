<?php
  require 'constants.php';

  if(isset($_COOKIE['user_id'])) {
    if(calculate_hash($_COOKIE['user_id'], $_COOKIE['name'], $_COOKIE['email'], $_COOKIE['phone']) != $_COOKIE['signature']) {
      header('Location: '.$domain.'/ajax_responses/logout.php');
      exit;
    }
  }

  $currentTime = time();
  if ($currentTime < $connexionsStartTime) {
    header('Location: '.$domain.'/details.php?id=connexions-online');
    exit;
  }

  $conn = new mysqli($db_server, $db_username, $db_password, $db_name);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = 'SELECT name, level from connexions c inner join user_details u on u.user_id=c.user_id order by level desc, lastTime';
  $result = $conn->query($sql);

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <!-- COMMON TAGS -->
  <meta charset="utf-8">
  <title>Prayatna '19</title>
  <!-- Search Engine -->
  <meta name="description" content="Witness the celebration of technology! Come, be a part of one of the city's biggest CSE symposiums on March 8 & 9 at MIT, Chennai">
  <meta name="image" content="https://prayatna.org.in/res/prayatna-small.png">
  <!-- Schema.org for Google -->
  <meta itemprop="name" content="Prayatna '19">
  <meta itemprop="description" content="Witness the celebration of technology! Come, be a part of one of the city's biggest CSE symposiums on March 8 & 9 at MIT, Chennai">
  <meta itemprop="image" content="https://prayatna.org.in/res/prayatna-small.png">
  <!-- Twitter -->
  <meta name="twitter:card" content="summary">
  <meta name="twitter:title" content="Prayatna '19">
  <meta name="twitter:description" content="Witness the celebration of technology on March 8 & 9">
  <meta name="twitter:image:src" content="https://prayatna.org.in/res/prayatna-small.png">
  <!-- Open Graph general (Facebook, Pinterest & Google+) -->
  <meta name="og:title" content="Prayatna '19">
  <meta name="og:description" content="Witness the celebration of technology on March 8 & 9">
  <meta name="og:image:secure_url" content="https://prayatna.org.in/res/prayatna-small.png">
  <meta name="og:url" content="https://prayatna.org.in/">
  <meta name="og:site_name" content="Prayatna '19">
  <meta name="fb:admins" content="217178335072713">
  <meta name="og:type" content="website">
  <meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="dist/material-components-web.min.css">
  <script type="text/javascript" src="dist/material-components-web.min.js"></script>
  <script type="text/javascript" src="dist/mithril.js"></script>
  <link rel="stylesheet" type="text/css" href="stylesheet.css">
  <style type="text/css">
    html, body {
      height: 100%;
    }
    .root {
      --mdc-theme-primary: #aaaaaa;
    }
    .section-dark .mdc-button--raised:not(:disabled), .section-dark .mdc-button--unelevated:not(:disabled) {
      background-color: #050505;
    }
    .center50 {
      display: block;
      margin: auto;
      width: 50%;
    }
    .leaderboard .mdc-list-item {
      display: flex;
      min-height: 48px;
      height: auto;
    }
    .leaderboard .mdc-list-item__graphic, .leaderboard .mdc-list-item__text, .leaderboard .mdc-list-item__meta {
      flex: 1 0 0;
      text-align: center;
      white-space: normal;
      color: black;
      margin: 0;
    }
    .leaderboard .mdc-list-item__text {
      flex: 3 0 0;
    }
    @media(max-width: 1024px) {
      .center50 {
        display: block;
        margin: auto;
        width: 95%;
      }
    }
  </style>
</head>
<body class="mdc-typography section-dark">
  <header class="mdc-top-app-bar mdc-elevation--z4" style="box-shadow: 0 2px 4px rgba(0,0,0,.5)">
    <div class="mdc-top-app-bar__row">
      <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start" style="padding-left: 20px">
        <a href="home.php">
          <img src="res/prayatna-small.png" style="width: 35px;height: 35px;" />
        </a>
        <span class="mdc-top-app-bar__title" style="letter-spacing: .3rem;">
          <a href="details.php?id=connexions-online" style="color: white">CONNEXIONS</a>
        </span>
      </section>
      <?php
       if (isset($_COOKIE['user_id'])) {
      ?>
      <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
        <button class="mdc-button app-bar-button" style="--mdc-theme-primary: #ffffff;" onclick="openMenu()">
          <i class="material-icons">more_vert</i>
        </button>
        <div class="mdc-menu-surface--anchor">
          <div class="mdc-menu mdc-menu-surface anim-appear-pulse" style="width: 160px;" tabindex="-1">
            <ul class="mdc-list" role="menu" aria-hidden="true" aria-orientation="vertical">
              <a href="home.php">
                <li class="mdc-list-item" role="menuitem">
                  <span class="mdc-list-item__text">Home</span>
                </li>
              </a>
              <a href="dashboard.php">
                <li class="mdc-list-item" role="menuitem">
                  <span class="mdc-list-item__text">Dashboard</span>
                </li>
              </a>
              <a href="ajax_responses/logout.php">
                <li class="mdc-list-item" role="menuitem">
                  <span class="mdc-list-item__text">Log out</span>
                </li>
              </a>
            </ul>
          </div>
        </div>
      </section>
      <?php
       }
      ?>
    </div>
  </header>
  <section class="mdc-top-app-bar--fixed-adjust root center50">
    <div class="dashboard-card mdc-elevation--z4 anim-appear-fadein leaderboard" style="margin-top: 1rem;">
      <div class="dashboard-card-content" style="padding: .5rem">
        <h1 class="mdc-typography--headline5 dashboard-card-title">Leaderboard</h1>
        <ul class="mdc-list" role="group">
          <?php
            if ($result->num_rows > 0) {
          ?>
          <li class="mdc-list-item">
            <span class="mdc-list-item__graphic"><b>Rank</b></span>
            <span class="mdc-list-item__text"><b>Name</b></span>
            <span class="mdc-list-item__meta"><b>Level</b></span>
          </li>
          <?php
              $rank = 1;
              while($row = $result->fetch_assoc()) {
          ?>
          <li role="separator" class="mdc-list-divider"></li>
          <li class="mdc-list-item">
            <span class="mdc-list-item__graphic"><?=$rank?></span>
            <span class="mdc-list-item__text"><?=$row['name']?></span>
            <span class="mdc-list-item__meta"><?=$row['level']?></span>
          </li>
          <?php
                $rank = $rank + 1;
              }
            }
            else {
          ?>
          <li class="mdc-list-item">
            <span class="mdc-list-item__text">Nothing to show here</span>
          </li>
          <?php
            }
          ?>

        </ul>
      </div>
    </div>
  </section>
  <script type="text/javascript">
    var appBar = mdc.topAppBar.MDCTopAppBar.attachTo(document.querySelector('.mdc-top-app-bar'));
    var ripples = [];
    var lists = document.querySelectorAll('.mdc-list');
    var mdcLists = [];
    for (var i = lists.length - 1; i >= 0; i--) {
      mdcList = new mdc.list.MDCList(lists[i]);
      ripples.push.apply(mdcList.listElements.map((listItemEl) => new mdc.ripple.MDCRipple(listItemEl)));
      mdcLists.push(mdcList);
    }
    var buttons = document.querySelectorAll('.mdc-button');
    for (var i = buttons.length - 1; i >= 0; i--) {
      ripples.push(new mdc.ripple.MDCRipple(buttons[i]));
    }
    <?php
     if (isset($_COOKIE['user_id'])) {
    ?>
    var mdcMenu = new mdc.menu.MDCMenu(document.querySelector('.mdc-menu'));
    function openMenu(){
      mdcMenu.open = true;
    }
    <?php
      }
    ?>
  </script>
  <?php
    $conn->close();
  ?>
</body>
</html>
