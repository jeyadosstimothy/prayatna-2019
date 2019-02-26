<?php
  require 'constants.php';

  $currentTime = time();
  if ($currentTime < $connexionsStartTime) {
    header('Location: '.$domain.'/details.php?id=connexions-online');
    exit;
  }
  elseif ($currentTime > $connexionsEndTime) {
    header('Location: '.$domain.'/connexions_leaderboard.php');
    exit;
  }

  if(!isset($_COOKIE['user_id'])) {
    header('Location: '.$domain.'/register.php?location=' . urlencode($_SERVER['REQUEST_URI']));
    exit;
  } else {
    if(calculate_hash($_COOKIE['user_id'], $_COOKIE['name'], $_COOKIE['email'], $_COOKIE['phone']) != $_COOKIE['signature']) {
      header('Location: '.$domain.'/ajax_responses/logout.php');
      exit;
    }
  }

  $conn = new mysqli($db_server, $db_username, $db_password, $db_name);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = 'SELECT level from connexions where user_id=?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $_COOKIE['user_id']);
  $result = $stmt->execute();
  $result = $stmt->get_result();

  $completedLevel = 0;
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if($row['level'] != NULL) {
      $completedLevel = $row['level'];
    }
  }
  else {
    $sql = 'INSERT into connexions (user_id, level) values (?, ?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $_COOKIE['user_id'], $completedLevel);
    $result = $stmt->execute();
  }
  $nextLevel = $completedLevel + 1;

  $totalLevels = 5;
  $captions = array(
    1 => 'this is a caption',
    2 => 'this is a caption',
    3 => 'this is a caption',
    4 => 'this is a caption',
    5 => 'this is a caption'
  );

  if(isset($_POST['answer'])) {
    $answers = array(
      1 => 'level1',
      2 => 'level2',
      3 => 'level3',
      4 => 'level4',
      5 => 'level5'
    );
    $submittedAnswer = strtolower($_POST['answer']);
    $submittedAnswer = preg_replace('/\s+/', '',$submittedAnswer);
    if(isset($answers[$nextLevel]) && $answers[$nextLevel] == $submittedAnswer) {
      $sql = 'UPDATE connexions set level = ?, lastTime = ? where user_id = ?';
      $stmt = $conn->prepare($sql);
      $datetime = date("Y-m-d H:i:s");
      $stmt->bind_param("isi", $nextLevel, $datetime, $_COOKIE['user_id']);
      $result = $stmt->execute();
    }
    $conn->close();
    header('Location: '.$domain.'/connexions.php');
    exit;
  }
  $conn->close();

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
    .center40 {
      display: block;
      margin: auto;
      width: 40%;
    }
    .mdc-text-field--disabled {
      background-color: #303030;
    }
    .mdc-text-field:not(.mdc-text-field--disabled) .mdc-text-field__input {
      color: #ffffff;
    }
    .mdc-text-field__input::placeholder {
      color: #888888;
    }
    .mdc-text-field:not(.mdc-text-field--disabled):not(.mdc-text-field--outlined):not(.mdc-text-field--textarea) .mdc-text-field__input {
      border-bottom-color: #888888;
    }
    .mdc-text-field:not(.mdc-text-field--disabled):not(.mdc-text-field--outlined):not(.mdc-text-field--textarea) .mdc-text-field__input:hover {
      border-bottom-color: #cccccc;
    }
    .mdc-text-field .mdc-line-ripple {
      background-color: #ffffff;
    }
    @media(max-width: 1024px) {
      .center40 {
        display: block;
        margin: auto;
        width: 90%;
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
              <a href="connexions_leaderboard.php">
                <li class="mdc-list-item" role="menuitem">
                  <span class="mdc-list-item__text">Leaderboard</span>
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
    </div>
  </header>
  <section class="mdc-top-app-bar--fixed-adjust root center40" style="margin-bottom: 3rem">
    <?php
      if($completedLevel >= $totalLevels) {
    ?>
    <div class="form-container anim-appear-fadein">
      <h1 class="mdc-typography--headline5" style="text-align: center;">Congrats! You've beaten the game!</h1>
      <h1 class="mdc-typography--headline6" style="text-align: center;">Check out the Leaderboard to know your rank</h1>
      <?php
        $gif = time() % 8;
        if($gif == 0) {
          echo '<div class="tenor-gif-embed" data-postid="5220411" data-share-method="host" data-width="100%" data-aspect-ratio="1.923076923076923"><a href="https://tenor.com/view/deadpool-clapping-nice-good-great-gif-5220411">Well Done GIF</a> from <a href="https://tenor.com/search/deadpool-gifs">Deadpool GIFs</a></div><script type="text/javascript" async src="https://tenor.com/embed.js"></script>';
        }
        else if($gif == 1) {
          echo '<div class="tenor-gif-embed" data-postid="10132248" data-share-method="host" data-width="100%" data-aspect-ratio="1.2296296296296296"><a href="https://tenor.com/view/congrats-congratulations-bravo-cheers-gif-10132248">مبروك GIF</a> from <a href="https://tenor.com/search/congrats-gifs">Congrats GIFs</a></div><script type="text/javascript" async src="https://tenor.com/embed.js"></script>';
        }
        else if($gif == 2) {
          echo '<div class="tenor-gif-embed" data-postid="5027237" data-share-method="host" data-width="100%" data-aspect-ratio="0.9818181818181817"><a href="https://tenor.com/view/djkhaled-you-agenius-genius-smart-intelligent-gif-5027237">DJKhaled You AGenius GIF</a> from <a href="https://tenor.com/search/djkhaled-gifs">Djkhaled GIFs</a></div><script type="text/javascript" async src="https://tenor.com/embed.js"></script>';
        }
        else if($gif == 3) {
          echo '<div class="tenor-gif-embed" data-postid="3529637" data-share-method="host" data-width="100%" data-aspect-ratio="1.025"><a href="https://tenor.com/view/bean-comedy-rowan-atkins-clap-congrats-gif-3529637">Great Job GIF</a> from <a href="https://tenor.com/search/bean-gifs">Bean GIFs</a></div><script type="text/javascript" async src="https://tenor.com/embed.js"></script>';
        }
        else if($gif == 4) {
          echo '<div class="tenor-gif-embed" data-postid="6217699" data-share-method="host" data-width="100%" data-aspect-ratio="1.3184713375796178"><a href="https://tenor.com/view/friends-phoebe-rachel-excited-gif-6217699">Friends Phoebe GIF</a> from <a href="https://tenor.com/search/friends-gifs">Friends GIFs</a></div><script type="text/javascript" async src="https://tenor.com/embed.js"></script>';
        }
        else if($gif == 5) {
          echo '<div class="tenor-gif-embed" data-postid="13256253" data-share-method="host" data-width="100%" data-aspect-ratio="1.1720430107526882"><a href="https://tenor.com/view/clapping-very-good-congratulations-congrats-gif-13256253">Clapping Very Good GIF</a> from <a href="https://tenor.com/search/clapping-gifs">Clapping GIFs</a></div><script type="text/javascript" async src="https://tenor.com/embed.js"></script>';
        }
        else if($gif == 6) {
          echo '<div class="tenor-gif-embed" data-postid="5704070" data-share-method="host" data-width="100%" data-aspect-ratio="1.776"><a href="https://tenor.com/view/elf-coffee-santa-christmas-congratulations-gif-5704070">Elf Coffee GIF</a> from <a href="https://tenor.com/search/elf-gifs">Elf GIFs</a></div><script type="text/javascript" async src="https://tenor.com/embed.js"></script>';
        }
        else if($gif == 7) {
          echo '<div class="tenor-gif-embed" data-postid="7212866" data-share-method="host" data-width="100%" data-aspect-ratio="1.3871866295264623"><a href="https://tenor.com/view/jonah-hill-yay-greek-aldos-gif-7212866">Jonah Hill Yay GIF</a> from <a href="https://tenor.com/search/jonahhill-gifs">Jonahhill GIFs</a></div><script type="text/javascript" async src="https://tenor.com/embed.js"></script>';
        }
      ?>
      <div style="margin: 1rem; text-align: center;">
        <a href="connexions_leaderboard.php">
          <button class="mdc-button mdc-button--raised mdc-ripple-upgraded">
            <span class="mdc-button__label">
              View Leaderboard
            </span>
          </button>
        </a>
      </div>
    </div>
    <?php
      }
      else {
    ?>
    <form class="form-container anim-appear-fadein" action="" method="post">
      <h1 class="mdc-typography--headline5" style="text-align: center;">Level <?=$nextLevel?></h1>
      <h1 class="mdc-typography--headline6" style="text-align: center;"><?=$captions[$nextLevel]?></h1>
      <img class="mdc-elevation--z6" src="res/connexions/<?=$nextLevel?>.jpg" style="width: 100%;margin-bottom: 1.5rem"/>
      <div class="mdc-text-field mdc-text-field--fullwidth" style="margin-bottom: 1.5rem">
        <input class="mdc-text-field__input input input-text-color"type="text" name="answer" placeholder="Enter your answer here" />
        <div class="mdc-line-ripple"></div>
      </div>
      <div style="float: right;margin-bottom: 2rem">
        <button class="mdc-button mdc-button--raised mdc-ripple-upgraded">
          <span class="mdc-button__label">
            Submit
          </span>
        </button>
      </div>
    </form>
    <?php
      }
    ?>
  </section>
  <script type="text/javascript">
    <?php
      if($completedLevel < $totalLevels) {
    ?>
    var textField = new mdc.textField.MDCTextField(document.querySelector('.mdc-text-field'));
    <?php
      }
    ?>
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
    var mdcMenu = new mdc.menu.MDCMenu(document.querySelector('.mdc-menu'));
    function openMenu(){
      mdcMenu.open = true;
    }
  </script>
</body>
</html>
