<?php
  if(!isset($_COOKIE['user_id'])) {
    header('Location: http://localhost/prayatna-2019/home.php');
  }
  else {
    $servername = "localhost";
    $s_username = "student";
    $s_password = "student";
    $db_name = 'prayatna';

    // Create connection
    $conn = new mysqli($servername, $s_username, $s_password, $db_name);

    // check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = 'select workshop_id, workshop_name, date from workshop_details where workshop_id in (select workshop_id from register_details where user_id = ?)';

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_COOKIE['user_id']);
    $result = $stmt->execute();
    $result = $stmt->get_result();
    $workshop_ids = array(-1); // -1 for distinguish from workshop id
  }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Prayatna</title>
  <meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">
  <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
  <script type="text/javascript" src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
  <script type="text/javascript" src="https://unpkg.com/mithril/mithril.js"></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
  <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body class="mdc-typography section-dark">
  <main class="root">
    <header class="mdc-top-app-bar mdc-elevation--z4" style="box-shadow: 0 2px 4px rgba(0,0,0,.5)">
      <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start" style="padding-left: 20px">
          <img src="res/prayatna-small.jpeg" style="width: 35px;height: 35px;" />
          <span class="mdc-top-app-bar__title" style="letter-spacing: .5rem">PRAYATNA</span>
        </section>
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
          <button class="mdc-button app-bar-button" style="--mdc-theme-primary: #ffffff;" onclick="openMenu()">
            <i class="material-icons">more_vert</i>
          </button>
          <div class="mdc-menu-surface--anchor">
            <div class="mdc-menu mdc-menu-surface anim-appear-pulse" style="width: 150px;" tabindex="-1">
              <ul class="mdc-list" role="menu" aria-hidden="true" aria-orientation="vertical">
                <li class="mdc-list-item" role="menuitem" onclick="window.location.href='home.php'">
                  <span class="mdc-list-item__text">Home</span>
                </li>
                <li class="mdc-list-item" role="menuitem" onclick="window.location.href='ajax_responses/logout.php'">
                  <span class="mdc-list-item__text">Log out</span>
                </li>
              </ul>
            </div>
          </div>
        </section>
      </div>
    </header>
    <section class="mdc-top-app-bar--fixed-adjust">
      <h1 class="mdc-typography--headline4 anim-appear-pulse" style="text-align: center">Welcome <?php if (isset($_COOKIE['user_id'])) echo $_COOKIE['name'];?></h1>
      <div class="workshops mdc-layout-grid anim-appear-slideup-fadein">
        <div class="mdc-layout-grid__inner">
          <div class="mdc-layout-grid__cell">
            <div class="mdc-layout-grid__inner">
              <div class="center90 mdc-layout-grid__cell mdc-elevation--z4 mdc-layout-grid__cell--span-12-desktop mdc-layout-grid__cell--span-8-tablet dashboard-cards" style="text-align: center">
                <h1 class="mdc-typography--headline5">Skip the Queue!</h1>
                <h1 class="mdc-typography--subtitle1">Why wait in line when you can register online?</h1>
                <h1 class="mdc-typography--subtitle1">Buy entry tickets now!</h1>
                <h1 class="mdc-typography--subtitle1">Note: Workshop participants need not buy entry tickets</h1>
                <div class="dashboard-card-button-container">
                  <button class="mdc-button mdc-button--raised dashboard-card-button">
                    Buy Now
                  </button>
                </div>
              </div>
              <div class="center90 mdc-layout-grid__cell mdc-elevation--z4 mdc-layout-grid__cell--span-12-desktop mdc-layout-grid__cell--span-8-tablet dashboard-cards">
                <h1 class="mdc-typography--headline5" style="text-align: center">Registered Workshops</h1>
                <ul class="mdc-list mdc-list--two-line" role="group">
                  <?php
                    if(isset($_COOKIE['user_id'])) {
                      if ($result->num_rows > 0) {
                        $count = 1;
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                          array_push($workshop_ids, $row['workshop_id']);
                          echo '
                            <li class="mdc-list-item" onclick="window.location.href=\'details.php?id='.$row['workshop_id'].'\'">
                              <span class="mdc-list-item__text">
                                <span class="mdc-list-item__primary-text">' . $row['workshop_name'] . '</span>
                                <span class="mdc-list-item__secondary-text">' . $row['date'] . '</span>
                              </span>
                              <span class="mdc-list-item__meta material-icons" aria-hidden="true">info</button>
                            </li>';
                            if($count != $result->num_rows) {
                              echo'<li role="separator" class="mdc-list-divider"></li>';
                            }
                            $count = $count + 1;
                        }
                      }
                    }
                  ?>
                </ul>
              </div>
            </div>
          </div>

          <div class="dashboard-cards mdc-elevation--z4 mdc-layout-grid__cell">
            <h1 class="mdc-typography--headline5" style="text-align: center;">New Workshops</h1>
            <form id = "workshop_selection" method = "post" action = "/prayatna-2019/ajax_responses/add_workshop.php">
              <ul class="mdc-list mdc-list--two-line" role="group" aria-label="List with checkbox items">
                <?php
                  if(isset($_COOKIE['user_id'])) {
                    $ids = "'" . implode("', '", $workshop_ids) . "'" ;// making array('val1', 'val2', 'val3') because of string
                    $sql = 'select workshop_id, workshop_name, date from workshop_details where workshop_id not in (' . $ids .')';
                    $result = $conn->query($sql);
                    if ($result != NULL && $result->num_rows > 0) {
                      // output data of each row
                      $count = 1;
                      while($row = $result->fetch_assoc()) {
                        array_push($workshop_ids, $row['workshop_id']);
                        echo '<li class="mdc-list-item" role="checkbox" aria-checked="false">
                            <span class="mdc-list-item__graphic">
                            <div class="mdc-checkbox">
                            <input type="checkbox" name = "selectedWorkshop[]"
                              class="mdc-checkbox__native-control"
                              id="demo-list-checkbox-item-1" value="'.$row['workshop_id'].'"/>
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
                            <span class="mdc-list-item__secondary-text">' . $row['date'] . '</span>
                            </span>
                            <button type="button" class="mdc-list-item__meta mdc-icon-button material-icons" aria-hidden="true" onclick="window.location.href=\'details.php?id='.$row['workshop_id'].'\'">info</button>
                          </li>';
                          if($count != $result->num_rows) {
                            echo'<li role="separator" class="mdc-list-divider"></li>';
                          }
                          $count = $count + 1;
                      }
                    }
                    else {
                      echo "Nothing to show";
                    }
                  }
                ?>
              </ul>
              <div class="dashboard-card-button-container">
                <button class="mdc-button mdc-button--raised dashboard-card-button">
                  Pay Now
                </button>
              </div>
            </form>
          </div>
          <div class="mdc-layout-grid__cell">
            <div class="mdc-layout-grid__inner">
              <div class="mdc-layout-grid__cell mdc-elevation--z4 mdc-layout-grid__cell--span-12-desktop mdc-layout-grid__cell--span-8-tablet dashboard-cards" style="text-align: center">
                <h1 class="mdc-typography--headline5">Accomodation</h1>
                <h1 class="mdc-typography--subtitle1">add some line for accomodation</h1>
                <div class="dashboard-card-button-container">
                  <button class="mdc-button mdc-button--raised dashboard-card-button">
                    Book Now
                  </button>
                </div>
                <!-- Buy entry ticket 250 -->
              </div>
              <div class="mdc-layout-grid__cell mdc-elevation--z4 mdc-layout-grid__cell--span-12-desktop mdc-layout-grid__cell--span-8-tablet dashboard-cards">
                <h1 class="mdc-typography--headline5" style="text-align: center">Upcoming Events</h1>
                <ul class="mdc-list mdc-list--two-line" role="group">
                  <li class="mdc-list-item">
                    <span class="mdc-list-item__text">
                      <span class="mdc-list-item__primary-text">Flaw</span>
                      <span class="mdc-list-item__secondary-text">Link for flaw</span>
                    </span>
                    <span class="mdc-list-item__meta material-icons" aria-hidden="true">info</span>
                  </li>
                  <li role="separator" class="mdc-list-divider"></li>
                  <li class="mdc-list-item">
                    <span class="mdc-list-item__text">
                      <span class="mdc-list-item__primary-text">Cyber Security</span>
                      <span class="mdc-list-item__secondary-text">March 8th, 2019</span>
                    </span>
                    <span class="mdc-list-item__meta material-icons" aria-hidden="true">info</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <script type="text/javascript">
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
        </div>
      </div>
    </section>
  </main>
</body>
</html>
