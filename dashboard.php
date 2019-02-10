<?php
  require 'constants.php';

  if(!isset($_COOKIE['user_id'])) {
    header('Location: '.$domain.'/home.php');
  } else {
    if(calculate_hash($_COOKIE['user_id'], $_COOKIE['name'], $_COOKIE['email'], $_COOKIE['phone']) != $_COOKIE['signature']) {
      header('Location: '.$domain.'/ajax_responses/logout.php');
    }
  }

  // Create connection
  $conn = new mysqli($db_server, $db_username, $db_password, $db_name);

  // check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
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
  <meta name="og:description" content="Witness the celebration of technology March 8 & 9">
  <meta name="og:image:secure_url" content="https://prayatna.org.in/res/prayatna-small.png">
  <meta name="og:url" content="https://prayatna.org.in/">
  <meta name="og:site_name" content="Prayatna '19">
  <meta name="fb:admins" content="217178335072713">
  <meta name="og:type" content="website">

  <meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
  <script type="text/javascript" src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
  <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body class="mdc-typography section-dark">
  <main class="root">
    <header class="mdc-top-app-bar mdc-elevation--z4" style="box-shadow: 0 2px 4px rgba(0,0,0,.5)">
      <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start" style="padding-left: 20px">
          <a href="home.php">
            <img src="res/prayatna-small.png" style="width: 35px;height: 35px;" />
          </a>
          <span class="mdc-top-app-bar__title" style="letter-spacing: .5rem">PRAYATNA</span>
        </section>
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
          <button class="mdc-button app-bar-button" style="--mdc-theme-primary: #ffffff;" onclick="openMenu()">
            <i class="material-icons">more_vert</i>
          </button>
          <div class="mdc-menu-surface--anchor">
            <div class="mdc-menu mdc-menu-surface anim-appear-pulse" style="width: 150px;" tabindex="-1">
              <ul class="mdc-list" role="menu" aria-hidden="true" aria-orientation="vertical">
                <a href="home.php">
                  <li class="mdc-list-item" role="menuitem">
                    <span class="mdc-list-item__text">Home</span>
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
    <section class="mdc-top-app-bar--fixed-adjust">
      <h1 class="mdc-typography--headline4 anim-appear-pulse" style="text-align: center">Welcome <?php if (isset($_COOKIE['user_id'])) echo $_COOKIE['name'];?>!</h1>
      <div class="mdc-layout-grid anim-appear-slideup-fadein">
        <div class="mdc-layout-grid__inner">
          <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-8-tablet">
            <div class="mdc-layout-grid__inner">
              <div class="mdc-layout-grid__cell mdc-elevation--z4 mdc-layout-grid__cell--span-12-desktop mdc-layout-grid__cell--span-8-tablet dashboard-card" style="text-align: center">
                <div class="dashboard-card-content">
                  <h1 class="mdc-typography--headline5 dashboard-card-title">Skip the Queue!</h1>
                  <h1 class="mdc-typography--subtitle1">Why wait in line when you can register online?</h1>
                  <h1 class="mdc-typography--subtitle1">Buy your Entry Ticket now to get 10% off!</h1>
                  <h1 class="mdc-typography--subtitle1">Price: <s>Rs. 249</s> Rs. 224!</h1>
                  <h1 class="mdc-typography--subtitle1">Note: Workshop participants need not buy entry tickets</h1>
                  <div class="dashboard-card-button-container">
                    <form method="post" action='cashfree/request.php'>
                      <?php
                        $sql = 'select bought_entry from user_details where user_id=?';
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $_COOKIE['user_id']);
                        $result = $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                          $row = $result->fetch_assoc();
                          if ($row['bought_entry']) {
                      ?>
                      <button class="mdc-button mdc-button--raised dashboard-card-button" disabled>
                        Bought
                      </button>
                      <?php
                          }
                          else {
                      ?>
                      <button class="mdc-button mdc-button--raised dashboard-card-button">
                        Buy Now
                      </button>
                      <?php
                          }
                        }
                      ?>
                      <input type="hidden" name="type" value="entry" />
                    </form>
                  </div>
                </div>
              </div>
              <div class="mdc-layout-grid__cell mdc-elevation--z4 mdc-layout-grid__cell--span-12-desktop mdc-layout-grid__cell--span-8-tablet dashboard-card">
                <div class="dashboard-card-content">
                  <h1 class="mdc-typography--headline5 dashboard-card-title">Upcoming Events</h1>
                  <ul class="mdc-list mdc-list--two-line" role="group">
                    <a href="details.php?id=freeze-it">
                      <li class="mdc-list-item">
                        <span class="mdc-list-item__text">
                          <span class="mdc-list-item__primary-text">Freeze It!</span>
                          <span class="mdc-list-item__secondary-text">Currently Live</span>
                        </span>
                        <span class="mdc-list-item__meta material-icons" aria-hidden="true">info</span>
                      </li>
                    </a>
                    <li role="separator" class="mdc-list-divider"></li>
                    <a href="details.php?id=connexions-online">
                      <li class="mdc-list-item">
                        <span class="mdc-list-item__text">
                          <span class="mdc-list-item__primary-text">Connexions Online</span>
                          <span class="mdc-list-item__secondary-text">Feb 26, 2019</span>
                        </span>
                        <span class="mdc-list-item__meta material-icons" aria-hidden="true">info</span>
                      </li>
                    </a>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-8-tablet">
            <div class="mdc-layout-grid__inner">
              <div class="mdc-layout-grid__cell mdc-elevation--z4 mdc-layout-grid__cell--span-12-desktop mdc-layout-grid__cell--span-8-tablet dashboard-card">
                <div class="dashboard-card-content">
                  <h1 class="mdc-typography--headline5 dashboard-card-title">New Workshops</h1>
                  <form method="post" action="cashfree/request.php" id="new-workshop-form">
                    <ul class="mdc-list mdc-list--two-line" role="group" aria-label="List with checkbox items">
                      <?php
                        $sql = 'select workshop_id, workshop_name, date, price from workshop_details where workshop_id not in (select workshop_id from register_details where user_id = ?)';
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $_COOKIE['user_id']);
                        $result = $stmt->execute();
                        $result = $stmt->get_result();
                        $new_workshop_ids = array(-1);
                        if ($result != NULL && $result->num_rows > 0) {
                          // output data of each row
                          $sql = "select count(user_id) as cnt, workshop_id from register_details group by workshop_id";
                          $ans = $conn->query($sql);
                          $count_id_pair = array();
                          while($row = $ans->fetch_assoc()) {
                            $count_id_pair[$row['workshop_id']] = $row['cnt'];
                          }
                          $count = 1;
                          while($row = $result->fetch_assoc()) {
                            array_push($new_workshop_ids, $row['workshop_id']);
                            $filled = (array_key_exists($row['workshop_id'], $count_id_pair) && $count_id_pair[$row['workshop_id']] >= $seats);
                            echo '<li class="mdc-list-item '.($filled?'mdc-list-item--disabled':'').'" role="checkbox" aria-checked="false">
                                <span class="mdc-list-item__graphic">
                                <div class="mdc-checkbox">
                                <input type="checkbox" name="selectedWorkshop[]" class="mdc-checkbox__native-control"
                                  value="'.$row['workshop_id'].'" price="' .$row["price"]. '" '.'" date="' .$row["date"]. '" '.($filled?'disabled':'').'/>
                                <div class="mdc-checkbox__background">
                                <svg class="mdc-checkbox__checkmark"
                                  viewBox="0 0 24 24">
                                  <path class="mdc-checkbox__checkmark-path"
                                  fill="none"
                                  d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
                                </svg>
                                <div class="mdc-checkbox__mixedmark"></div>
                                </div>
                                </div>
                                </span>
                                <span class="mdc-list-item__text">
                                <span class="mdc-list-item__primary-text">' . $row['workshop_name'] . '</span>
                                <span class="mdc-list-item__secondary-text">'.($filled?'Registrations closed':$row['date'].', Rs. '.$row['price']).'</span>
                                </span>
                                <a href="details.php?id='.$row['workshop_id'].'" class="mdc-list-item__meta material-icons" aria-hidden="true">
                                  info
                                </a>
                              </li>';
                              if($count != $result->num_rows) {
                                echo'<li role="separator" class="mdc-list-divider"></li>';
                              }
                              $count = $count + 1;
                          }
                        }
                        else {
                          echo "<p style='text-align: center;'>Nothing to show</p>";
                        }
                      ?>
                    </ul>
                    <p id="total-amount" style="text-align: center;"></p>
                    <div class="dashboard-card-button-container">
                      <button class="mdc-button mdc-button--raised dashboard-card-button">
                        Pay Now
                      </button>
                    </div>
                    <input type="hidden" name="type" value="workshop" />
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-8-tablet">
            <div class="mdc-layout-grid__inner">
              <script type="text/javascript">
                var registeredWorkshopDates = [];
              </script>
              <div class="mdc-layout-grid__cell mdc-elevation--z4 mdc-layout-grid__cell--span-12-desktop mdc-layout-grid__cell--span-8-tablet dashboard-card">
                <div class="dashboard-card-content">
                  <h1 class="mdc-typography--headline5 dashboard-card-title">Registered Workshops</h1>
                  <ul class="mdc-list mdc-list--two-line" role="group">
                    <?php
                      $ids = "'" . implode("', '", $new_workshop_ids) . "'" ;
                      $sql = 'select workshop_id, workshop_name, date from workshop_details where workshop_id not in ('.$ids.')';
                      $result = $conn->query($sql);

                      if ($result->num_rows > 0) {
                        $count = 1;
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                          echo '
                            <a href="details.php?id='.$row['workshop_id'].'">
                              <li class="mdc-list-item">
                                <span class="mdc-list-item__text">
                                  <span class="mdc-list-item__primary-text">' . $row['workshop_name'] . '</span>
                                  <span class="mdc-list-item__secondary-text">' . $row['date'] . '</span>
                                </span>
                                <span class="mdc-list-item__meta material-icons" aria-hidden="true">info</button>
                              </li>
                            </a>';
                          ?>
                          <script type="text/javascript">
                            registeredWorkshopDates.push('<?=$row['date'];?>');
                          </script>
                          <?php
                          if($count != $result->num_rows) {
                            echo'<li role="separator" class="mdc-list-divider"></li>';
                          }
                          $count = $count + 1;
                        }
                      }
                      else {
                        echo '<p style="text-align: center">Nothing to show</p>';
                      }
                    ?>
                  </ul>
                </div>
              </div>
              <div class="mdc-layout-grid__cell mdc-elevation--z4 mdc-layout-grid__cell--span-12-desktop mdc-layout-grid__cell--span-8-tablet dashboard-card">
                <script type="text/javascript">
                  var datefield=document.createElement("input")
                  datefield.setAttribute("type", "date")
                  if (datefield.type!="date"){ //if browser doesn't support input type="date", load files for jQuery UI Date Picker
                    document.write('<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />\n')
                    document.write('<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"><\/script>\n')
                  }
                </script>
                <div class="dashboard-card-content">
                  <h1 class="mdc-typography--headline5 dashboard-card-title">Need Accomodation?</h1>
                  <h1 class="mdc-typography--subtitle1" style="text-align: center">Let us know!</h1>
                  <?php
                    $sql = 'select check_in, check_out from user_details where user_id=?';
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $_COOKIE['user_id']);
                    $result = $stmt->execute();
                    $result = $stmt->get_result();
                    if($result->num_rows > 0) {
                      $row = $result->fetch_assoc();
                      $reserved = ($row['check_in'] != NULL);
                    }

                  ?>
                  <form method="post" action="ajax_responses/reserve_accomodation.php" id="accomodation-form" class="center90">
                    <div class="mdc-text-field mdc-text-field--with-leading-icon">
                      <div>
                        <i class="material-icons mdc-text-field__icon">event</i>
                        <input class="mdc-text-field__input" placeholder="Check in" type='date' name='check_in' required <?=($reserved?'disabled':'')?> value="<?=$row['check_in'];?>" id="check_in"/>
                        <label class="mdc-floating-label mdc-floating-label--float-above">
                          Check-in
                        </label>
                        <div class="mdc-line-ripple"></div>
                      </div>
                    </div>
                    <div class="mdc-text-field mdc-text-field--with-leading-icon">
                      <div>
                        <i class="material-icons mdc-text-field__icon">event</i>
                        <input class="mdc-text-field__input" placeholder="Check out" type='date' name='check_out' required <?=($reserved?'disabled':'')?> value="<?=$row['check_out'];?>" id="check_out"/>
                        <label class="mdc-floating-label mdc-floating-label--float-above">
                          Check-out
                        </label>
                        <div class="mdc-line-ripple"></div>
                      </div>
                    </div>
                    <div class="dashboard-card-button-container">
                      <span class="dashboard-card-button">
                        <a href="res/accomodation-prayatna.pdf" download>
                          <button class="mdc-button mdc-button--outlined" style="margin-right: .5rem" type="button">
                            Get Details
                          </button>
                        </a>
                        <button class="mdc-button mdc-button--raised" <?=($reserved?'disabled':'')?>  style="margin-left: .5rem">
                          <?=($reserved?'Reserved':'Reserve Now')?>
                        </button>
                      </div>
                    </div>
                    <script>
                      if (datefield.type!="date"){ //if browser doesn't support input type="date", initialize date picker widget:
                          jQuery(function($){ //on document.ready
                              $('#check_in').datepicker();
                              $('#check_out').datepicker();
                          })
                      }
                    </script>
                  </form>


                </div>
              </div>

            </div>
          </div>
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
            var mdcMenu = new mdc.menu.MDCMenu(document.querySelector('.mdc-menu'));
            function openMenu(){
              mdcMenu.open = true;
            }
            var tfs = document.querySelectorAll('.mdc-text-field');
            var mdTfs = []
            for (var i = tfs.length - 1; i >= 0; i--) {
              mdTfs.push(new mdc.textField.MDCTextField(tfs[i]));
            }
          </script>
          <script type="text/javascript">
            var value = 0, paymentAmount = document.getElementById("total-amount");
            $('input[type=checkbox]').change(function(){
              var txt = $(this).attr('price');
              if($(this).is(':checked')) {
                value = value + parseInt(txt);
              } else {
                value = value - parseInt(txt);
              }
              paymentAmount.innerHTML = "Total Amount: Rs. " + value;
            });
          </script>
          <script type="text/javascript">
            $('#new-workshop-form').submit(function () {
              var workshops = document.querySelectorAll('input[type=checkbox]:checked');
              var selectedDates = [];
              for (var i = workshops.length - 1; i >= 0; i--) {
                var date = workshops[i].attributes.date.value;
                if(registeredWorkshopDates.includes(date) || selectedDates.includes(date))
                {
                  showSnackbar("Can't register 2 workshops on same day!");
                  return false;
                }
                selectedDates.push(workshops[i].attributes.date.value);
              }
              return true;
            });
          </script>
        </div>
      </div>
    </section>
  </main>
  <?php include('snackbar.php') ?>
  <?php
    $conn->close();
  ?>
</body>
</html>
