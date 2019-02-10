<?php
  require 'constants.php';
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

  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <link rel="icon" href="favicon.ico" type="image/x-icon">

  <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">

  <script type="text/javascript" src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>

  <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
  <script type="text/javascript" src="slick/slick.min.js"></script>
  <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>

<body class="mdc-typography">
  <header class="mdc-top-app-bar mdc-top-app-bar--fixed mdc-elevation--z4" style="box-shadow: 0 2px 4px rgba(0,0,0,.5)">
    <div class="mdc-top-app-bar__row">
      <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start" style="padding-left: 20px">
        <img src="res/prayatna-small.png" style="width: 35px;height: 35px;" />
        <span class="mdc-top-app-bar__title" style="letter-spacing: .5rem">Prayatna</span>
      </section>

      <!--PHP for user-->
      <?php
        // if logged in show dashboard
        if (isset($_COOKIE["user_id"])) {
          if(calculate_hash($_COOKIE['user_id'], $_COOKIE['name'], $_COOKIE['email'], $_COOKIE['phone']) != $_COOKIE['signature']) {
            header('Location: '.$domain.'/ajax_responses/logout.php');
          }
          echo '<section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
            <button class="mdc-button app-bar-button" style="--mdc-theme-primary: #ffffff;" onclick="openMenu()">
              <i class="material-icons">more_vert</i>
            </button>
            <div class="mdc-menu-surface--anchor">
              <div class="mdc-menu mdc-menu-surface anim-appear-pulse" style="width: 150px;" tabindex="-1">
                <ul class="mdc-list" role="menu" aria-hidden="true" aria-orientation="vertical">
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
          </section>';
        }
        // else show register button
        else {
          echo '<section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
            <a href="register.php">
              <button class="mdc-button app-bar-button" style="--mdc-theme-primary: #ffffff;">
                <i class="material-icons mdc-button__icon" aria-hidden="true">person_add</i>
                <span class="mdc-button__label" style="letter-spacing: .1rem">Register</span>
              </button>
            </a>
          </section>';
        }
      ?>

    </div>
  </header>
  <section class="section-dark section-full title-section mdc-layout-grid mdc-top-app-bar--fixed-adjust">
    <div class="mdc-layout-grid__inner anim-appear-slideup-fadein">
      <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
        <img class="logo" src="res/prayatna.png">
      </div>
      <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop mdc-layout-grid__cell--align-middle">
        <h1 class="mdc-typography--headline3 title-text" align="center">Let the mindgames begin!</h1>
        <div class="slider">
          <h1 class="mdc-typography--headline4" align="center">March 8 & 9</h1>
          <h1 class="mdc-typography--headline4" align="center"><span id="days"></span> days to go!</h1>
        </div>
      </div>
    </div>

    <div class="floating-social-icons anim-appear-slideright-fadein">
      <p align="right">
        <a href="https://www.facebook.com/prayatnact"><img src="res/facebook_white.png" class="img-social" /></a>
        <a href="https://www.instagram.com/act.mit/"><img src="res/instagram_white.png" class="img-social" /></a>
        <a href="https://www.linkedin.com/in/prayatna-mit-642b23158/"><img src="res/linkedin_white.png" class="img-social" /></a>
      </p>
    </div>
    <script>
      var getRemainingDays = function() {
        var date1 = new Date();
        var date2 = new Date("3/8/2019");
        var diff =  date2.getTime()-date1.getTime();
        return Math.ceil(diff/86400000);
      }
      document.querySelector('#days').innerHTML = getRemainingDays()
      $('.slider').slick({
        vertical: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        arrows: false,
        pauseOnFocus: false,
        pauseOnHover: false,
      });
    </script>
  </section>
  <section>
    <div class="mdc-layout-grid anim-appear-fadein">
      <div class="mdc-layout-grid__cell">
        <h1 class="mdc-typography--headline3 section-header">About Us</h1>
      </div>
      <div class="mdc-layout-grid__cell">
        <p class="mdc-typography--body1 content-about">The Association of Computer Technologists takes great pride in conducting PRAYATNA, our annual national level inter-college technical festival. PRAYATNA, a conglomeration of the brightest minds in India, is hosted by the Department of Computer Technology, Anna University, MIT Campus. Over 3000 students from over 150 colleges flock to take part in this festival. In a nutshell, PRAYATNA is a platform that churns out technical and creative ideas from upcoming engineers by assessing their aptitude in coding, design, entrepreneurial skills and other multi-faceted concepts. With special workshops conducted by experts from the industry, PRAYATNA enhances the participants' knowledge and creative potential.</p>
      </div>
      <div class="mdc-layout-grid__cell ">
        <h1 class="mdc-typography--headline3 section-header">Interns & Sponsors</h1>
      </div>
      <ul class="mdc-layout-grid__inner mdc-image-list margin sponsors-list">
        <li class="mdc-image-list__item mdc-layout-grid__cell--span-2">
          <a href="https://www.amazon.in/"><img class="mdc-image-list__image" src="res/amazon.png"></a>
        </li>
        <li class="mdc-image-list__item mdc-layout-grid__cell--span-2">
          <a href="https://www.gigamon.com/"><img class="mdc-image-list__image" src="res/gigamon.png"></a>
        </li>
        <li class="mdc-image-list__item mdc-layout-grid__cell--span-2">
          <a href="https://www.skcript.com/"><img class="mdc-image-list__image" src="res/skcript.svg"></a>
        </li>
        <li class="mdc-image-list__item mdc-layout-grid__cell--span-2">
          <a href="https://www.cns-inc.com/"><img class="mdc-image-list__image" src="res/cnsi.png"></a>
        </li>
        <li class="mdc-image-list__item mdc-layout-grid__cell--span-2">
          <a href="http://accolite.com/"><img class="mdc-image-list__image" src="res/accolite.png"></a>
        </li>
        <li class="mdc-image-list__item mdc-layout-grid__cell--span-2">
          <a href="https://www.freshworks.com/"><img class="mdc-image-list__image" src="res/freshworks.png"></a>
        </li>
        <li class="mdc-image-list__item mdc-layout-grid__cell--span-2">
          <a href="http://www.f22labs.com/"><img class="mdc-image-list__image" src="res/f22labs.png"></a>
        </li>
        <li class="mdc-image-list__item mdc-layout-grid__cell--span-2">
          <a href="https://motorq.co/"><img class="mdc-image-list__image" src="res/motorq.png"></a>
        </li>
        <li class="mdc-image-list__item mdc-layout-grid__cell--span-2">
          <a href="https://linkstreet.in/"><img class="mdc-image-list__image" src="res/linkstreet.png"></a>
        </li>
        <li class="mdc-image-list__item mdc-layout-grid__cell--span-2">
          <a href="https://www.madstreetden.com/"><img class="mdc-image-list__image" src="res/mad-street-den.jpeg"></a>
        </li>
        <li class="mdc-image-list__item mdc-layout-grid__cell--span-2">
          <a href="https://www.zoho.com/"><img class="mdc-image-list__image" src="res/zoho.png"></a>
        </li>
        <li class="mdc-image-list__item mdc-layout-grid__cell--span-2">
          <a href="http://botcode.com/"><img class="mdc-image-list__image" src="res/botcode.png"></a>
        </li>
      </ul>
    </div>
  </section>
  <script type="text/javascript" src="https://unpkg.com/mithril/mithril.js"></script>
  <section class="section-dark">
    <div class="workshops-events-section"></div>
    <script type="text/javascript">
      var Tab = {
        view: function(vnode) {
          return m('button', {
              class: 'mdc-tab' + (vnode.attrs.active?' mdc-tab--active':''),
              role: 'tab',
              'aria-selected': (vnode.attrs.active?'true':'false'),
              tabindex: 0,
              onclick: vnode.attrs.onclick
            },
            [
              m('span', {class: 'mdc-tab__content'},
                m('span', {class: 'mdc-tab__text-label'}, vnode.attrs.text),
              ),
              m('span', {class: 'mdc-tab-indicator' + (vnode.attrs.active?' mdc-tab-indicator--active':'')},
                m('span', {class: 'mdc-tab-indicator__content mdc-tab-indicator__content--underline'}),
              ),
              m('span', {class: 'mdc-tab__ripple'}),
            ]
          );
        }
      }
      var tabBars = {};
      var TabBar = {
        view: function(vnode) {
          return m('nav', {class: 'mdc-tab-bar', role: 'tablist', id: vnode.attrs.id},
            m('div', {class: 'mdc-tab-scroller'},
              m('div', {class: 'mdc-tab-scroller__scroll-area'},
                m('div', {class: 'mdc-tab-scroller__scroll-content'}, vnode.attrs.tabs)
              )
            )
          );
        },
        oncreate: function(vnode) {
          tabBars[vnode.dom.id] = new mdc.tabBar.MDCTabBar(vnode.dom);
        }
      }
      var ripples = []
      var CellCard = {
        view: function(vnode) {
          return m('a', {href: 'details.php?id='+vnode.attrs.id, class: 'mdc-card mdc-elevation--z4 mdc-card__primary-action mdc-layout-grid__cell mdc-layout-grid__cell--span-' + (vnode.attrs.span?vnode.attrs.span:'3-desktop mdc-layout-grid__cell--span-2-phone'), tabindex:"0"},
            m('div', {class: 'mdc-card__media mdc-card__media--16-9', style: vnode.attrs.style}),
            m('div', {class: 'mdc-card__primary'},
              m('h2', {class: 'mdc-card__title mdc-typography--headline6'}, vnode.attrs.title),
              m('h3', {class: 'mdc-card__subtitle mdc-typography--subtitle2'}, vnode.attrs.subtitle)
            ),
            (vnode.attrs.secondary?m('div', {class: 'mdc-card__secondary mdc-typography--body2'}, vnode.attrs.secondary):null)
          );
        },
        oncreate: function(vnode) {
          ripples.push(new mdc.ripple.MDCRipple(vnode.dom));
        }
      }
      var Cell = {
        view: function(vnode) {
          return m('div', {class: 'mdc-layout-grid__cell mdc-layout-grid__cell--span-' + (vnode.attrs.span?vnode.attrs.span:'3-desktop mdc-layout-grid__cell--span-2-phone')}, vnode.attrs.child);
        }
      }
      var Panel = {
        view: function(vnode) {
          return m('div', {class: 'mdc-layout-grid__inner margin', role: 'tabpanel'}, vnode.attrs.child);
        }
      }
      var eventTabs = [
        m(Tab, {active: true, text: 'Technical', onclick: function(){currentPanel = 'techEvents'}}),
        m(Tab, {active: false, text: 'Non Technical', onclick: function(){currentPanel = 'nonTechEvents'}}),
        m(Tab, {active: false, text: 'Online', onclick: function(){currentPanel = 'onlineEvents'}}),
      ]
      var workshops = [
        m(CellCard, {
          title: 'Flutter',
          subtitle: 'Ruchika, Geeky Ants',
          secondary: 'Build beautiful apps with Flutter!',
          id: 'flutter',
          style: "background-image: url('res/flutter.jpg');"
        }),
        m(CellCard, {
          title: 'System Design',
          subtitle: 'Gaurav Sen, Youtuber',
          secondary: 'Build your own Whatsapp!',
          id: 'system-design',
          style: "background-image: url('res/system-design.jpeg');"
        }),
        m(CellCard, {
          title: 'ReactJS',
          subtitle: 'Google Developers Group',
          secondary: 'Designing Websites with Perfection',
          id: 'react-js',
          style: "background-image: url('res/react.png');"
        }),
        m(CellCard, {
          title: 'Cyber Security',
          subtitle: 'Ernst & Young',
          secondary: "Something's Phishy!",
          id: 'cyber-security',
          style: "background-image: url('res/cyber-security.jpg');"
        }),
        m(CellCard, {
          title: 'Artificial Intelligence',
          subtitle: 'Ramkumar, InMobi',
          secondary: 'The Future of Technology, Demystified',
          id: 'artificial-intelligence',
          style: "background-image: url('res/artificial-intelligence.jpg');"
        }),
        m(CellCard, {
          title: 'Cracking the Coding Interview',
          subtitle: 'Hemanth, PayPal',
          secondary: 'Placements just got easier!',
          id: 'cracking-the-coding-interview',
          style: "background-image: url('res/placements.jpeg');"
        }),
      ]
      var techEvents = [
        m(CellCard, {
          title: 'Motorq Hackathon',
          subtitle: 'The Flagship Event',
          id: 'hackathon',
          style: "background-image: url('res/hackathon.png');"
        }),
        m(CellCard, {
          title: 'Amazon Intern Hiring',
          subtitle: "Win Internships at Amazon!",
          id: 'amazon-intern-hiring',
          style: "background-image: url('res/amazon-intern-hiring.jpg');"
        }),
        m(CellCard, {
          title: 'OSPC',
          subtitle: "The Problem Solvers's Paradise",
          id: 'ospc',
          style: "background-image: url('res/ospc.png');"
        }),
        m(CellCard, {
          title: 'Mini Placement',
          subtitle: 'Simulate Your Interviews',
          id: 'mini-placement',
          style: "background-image: url('res/mini-placement.png');"
        }),
        m(CellCard, {
          title: 'Web Hub',
          subtitle: 'What You See Is What You Get',
          id: 'web-hub',
          style: "background-image: url('res/web-hub.jpg');"
        }),
        m(CellCard, {
          title: 'Code ‘N Chaos',
          subtitle: 'How well do you code under pressure?',
          id: 'code-n-chaos',
          style: "background-image: url('res/code-n-chaos.jpg');"
        }),
        m(CellCard, {
          title: 'DB Dwellers',
          subtitle: 'Select * from the Universe',
          id: 'db-dwellers',
          style: "background-image: url('res/db-dwellers.jpg');"
        }),
        m(CellCard, {
          title: 'Parseltongue',
          subtitle: 'Express Your Fluency In Python',
          id: 'parseltongue',
          style: "background-image: url('res/parseltongue.jpg');"
        }),
        m(CellCard, {
          title: "OOPS! It's Java",
          subtitle: 'Are you a jaw-dropping Java Developer?',
          id: 'oops-its-java',
          style: "background-image: url('res/oops-its-java.jpg');"
        }),
        m(CellCard, {
          title: 'Paper Presentation',
          subtitle: 'Give your idea the recognition it deserves!',
          id: 'paper-presentation',
          style: "background-image: url('res/paper-presentation.jpg');"
        }),
      ]
      var nonTechEvents = [
        m(CellCard, {
          title: 'Kaleidoscope',
          subtitle: 'The Mega Event',
          id: 'kaleidoscope',
          style: "background-image: url('res/kaleidoscope.jpg');"
        }),
        m(CellCard, {
          title: 'IPL Auction',
          subtitle: 'Bid, Win, Have a Grin',
          id: 'ipl-auction',
          style: "background-image: url('res/ipl-auction.jpg');"
        }),
        m(CellCard, {
          title: 'Bplan',
          subtitle: "It's always wise to look ahead",
          id: 'bplan',
          style: "background-image: url('res/bplan.jpg');"
        }),
        m(CellCard, {
          title: 'Treasure Hunt',
          subtitle: 'Clear Vision holds the Key',
          id: 'treasure-hunt',
          style: "background-image: url('res/treasure-hunt.jpg');"
        }),
        m(CellCard, {
          title: 'Math O Mania',
          subtitle: 'Do you speak the language of the Gods?',
          id: 'math-o-mania',
          style: "background-image: url('res/math-o-mania.jpg');"
        }),
        m(CellCard, {
          title: 'Gaming',
          subtitle: 'Life is short, Game More',
          id: 'gaming',
          style: "background-image: url('res/gaming.png');"
        }),
        m(CellCard, {
          title: 'Connexions',
          subtitle: 'Crack it quicker and collar up as connectors.',
          id: 'connexions',
          style: "background-image: url('res/connexions.png');"
        }),
      ]
      var onlineEvents = [
        m(CellCard, {
          title: 'Freeze It!',
          subtitle: 'Let your Lens Speak',
          id: 'freeze-it',
          style: "background-image: url('res/freeze-it.jpg');"
        }),
        m(CellCard, {
          title: 'OLPC',
          subtitle: 'Think twice, Code once',
          id: 'olpc',
          style: "background-image: url('res/olpc.jpg');"
        }),
        m(CellCard, {
          title: 'Daily Quiz',
          subtitle: 'Unlocking knowledge at the speed of thought!',
          id: 'daily-quiz',
          style: "background-image: url('res/quiz.jpeg');"
        }),
        m(CellCard, {
          title: 'Connexions Online',
          subtitle: 'Pause coding and start connecting!',
          id: 'connexions-online',
          style: "background-image: url('res/connexions-online.png');"
        }),
      ]
      var currentPanel = 'techEvents';

      var panelContent = {
        'techEvents': techEvents,
        'nonTechEvents': nonTechEvents,
        'onlineEvents': onlineEvents
      }
      var workshopEventPanel = {
        view: function() {
          return m('div', {class: 'mdc-layout-grid anim-appear-fadein'},
            m(Cell, {
              child: m('h1', {class: 'mdc-typography--headline3 section-header'}, 'Workshops'),
              span: 4,
            }),
            m(Panel, {child: workshops}),
            m(Cell, {
              child: m('h1', {class: 'mdc-typography--headline3 section-header'}, 'Events'),
              span: 4,
            }),
            m(Cell, {
              child: m(TabBar, {tabs: eventTabs, id: 'eventTabBar'}),
              span: 4,
            }),
            m(Panel, {child: panelContent[currentPanel]})
          );
        }
      }
      m.mount(document.querySelector('.workshops-events-section'), workshopEventPanel, {child: panelContent[currentPanel]});


    </script>
  </section>
  <section>
    <div class="mdc-layout-grid anim-appear-fadein">
      <div class="mdc-layout-grid__cell">
          <h1 class="mdc-typography--headline3 section-header">Contact Us</h1>
      </div>
      <ul class="mdc-layout-grid__inner mdc-image-list margin contacts-list" >
        <li class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-2-phone mdc-layout-grid__cell--span-4-tablet mdc-image-list__item">
          <img class="mdc-image-list__image mdc-elevation--z4" src="res/praveen_siva.jpg">
          <div class="mdc-image-list__supporting">
            <span class="mdc-image-list__label mdc-typography--body2">
              Praveen Siva<br>Chairman<br>
              <a href="tel:+919597180925"><span class="desktop">+91 9597180925</span><button class="mobile mdc-icon-button material-icons">phone</button></a><br class="desktop"/>
              <a href="mailto:praveen17siva@gmail.com"><span class="desktop">praveen17siva@gmail.com</span><button class="mobile mdc-icon-button material-icons">email</button></a>
            </span>
          </div>
        </li>
        <li class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-2-phone mdc-layout-grid__cell--span-4-tablet mdc-image-list__item" >
          <img class="mdc-image-list__image mdc-elevation--z4" src="res/amarnath.jpeg">
          <div class="mdc-image-list__supporting">
            <span class="mdc-image-list__label mdc-typography--body2">
              Amarnath D<br>Secretary<br>
              <a href="tel:+919080082180"><span class="desktop">+91 9080082180</span><button class="mobile mdc-icon-button material-icons">phone</button></a><br class="desktop"/>
              <a href="mailto:amarnathdevraj@gmail.com"><span class="desktop">amarnathdevraj@gmail.com</span><button class="mobile mdc-icon-button material-icons">email</button></a>
            </span>
          </div>
        </li>
        <li class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-2-phone mdc-layout-grid__cell--span-4-tablet mdc-image-list__item">
          <img class="mdc-image-list__image mdc-elevation--z4" src="res/harshitha.jpeg">
          <div class="mdc-image-list__supporting">
            <span class="mdc-image-list__label mdc-typography--body2">
              Harshitha P R<br>Women's Secretary<br>
              <a href="tel:+918883183838"><span class="desktop">+91 8883183838</span><button class="mobile mdc-icon-button material-icons">phone</button></a><br class="desktop"/>
              <a href="mailto:harshithapr1997@gmail.com"><span class="desktop">harshithapr1997@gmail.com</span><button class="mobile mdc-icon-button material-icons">email</button></a>
            </span>
          </div>
        </li>
        <li class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-2-phone mdc-layout-grid__cell--span-4-tablet mdc-image-list__item">
          <img class="mdc-image-list__image mdc-elevation--z4" src="res/prashanth.jpeg">
          <div class="mdc-image-list__supporting">
            <span class="mdc-image-list__label mdc-typography--body2">
              Prashanth T R<br>Workshop Coordinator<br>
              <a href="tel:+919003165816"><span class="desktop">+91 9003165816</span><button class="mobile mdc-icon-button material-icons">phone</button></a><br class="desktop"/>
              <a href="mailto:prachoo2198@gmail.com"><span class="desktop">prachoo2198@gmail.com</span><button class="mobile mdc-icon-button material-icons">email</button></a>
            </span>
          </div>
        </li>
        <li class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-2-phone mdc-layout-grid__cell--span-4-tablet mdc-image-list__item">
          <img class="mdc-image-list__image mdc-elevation--z4" src="res/akshay.jpeg">
          <div class="mdc-image-list__supporting">
            <span class="mdc-image-list__label mdc-typography--body2">
              Akshay V<br>Event Coordinator (Tech)<br>
              <a href="tel:+918056027690"><span class="desktop">+91 8056027690</span><button class="mobile mdc-icon-button material-icons">phone</button></a><br class="desktop"/>
              <a href="mailto:akshayred@gmail.com"><span class="desktop">akshayred@gmail.com</span><button class="mobile mdc-icon-button material-icons">email</button></a>
            </span>
          </div>
        </li>
        <li class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-2-phone mdc-layout-grid__cell--span-4-tablet mdc-image-list__item">
          <img class="mdc-image-list__image mdc-elevation--z4" src="res/swetha.jpg">
          <div class="mdc-image-list__supporting">
            <span class="mdc-image-list__label mdc-typography--body2">
              Swetha B<br>Paper Presentation Coordinator<br>
              <a href="tel:+917373124348"><span class="desktop">+91 7373124348</span><button class="mobile mdc-icon-button material-icons">phone</button></a><br class="desktop"/>
              <a href="mailto:swethadhanam494@gmail.com"><span class="desktop">swethadhanam494@gmail.com</span><button class="mobile mdc-icon-button material-icons">email</button></a>
            </span>
          </div>
        </li>
        <li class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-2-phone mdc-layout-grid__cell--span-4-tablet mdc-image-list__item">
          <img class="mdc-image-list__image mdc-elevation--z4" src="res/manikandan.jpeg">
          <div class="mdc-image-list__supporting">
            <span class="mdc-image-list__label mdc-typography--body2">
              Manikandan M<br>Accommodation - Boys<br>
              <a href="tel:+917639118010"><span class="desktop">+91 7639118010</span><button class="mobile mdc-icon-button material-icons">phone</button></a><br class="desktop"/>
              <a href="mailto:vairavanmani2@gmail.com"><span class="desktop">vairavanmani2@gmail.com</span><button class="mobile mdc-icon-button material-icons">email</button></a>
            </span>
          </div>
        </li>
        <li class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-2-phone mdc-layout-grid__cell--span-4-tablet mdc-image-list__item">
          <img class="mdc-image-list__image mdc-elevation--z4" src="res/chandrika.jpeg">
          <div class="mdc-image-list__supporting">
            <span class="mdc-image-list__label mdc-typography--body2">
              Chandrika V<br>Accommodation - Girls<br>
              <a href="tel:+919787171852"><span class="desktop">+91 9787171852</span><button class="mobile mdc-icon-button material-icons">phone</button></a><br class="desktop"/>
              <a href="mailto:vchandrika228@gmail.com"><span class="desktop">vchandrika228@gmail.com</span><button class="mobile mdc-icon-button material-icons">email</button></a>
            </span>
          </div>
        </li>
      </ul>
      <div class="mdc-layout-grid__inner margin">
        <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop center90">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3888.369112328477!2d80.13758015030977!3d12.948216590826457!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a525fac595c29ff%3A0xb76082ae18b51418!2sMadras+Institute+Of+Technology%2C+Anna+University!5e0!3m2!1sen!2sin!4v1547558861807" width="600" height="600" frameborder="0" id="map" class="center90"></iframe>
        </div>
        <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop center90">
          <p class="mdc-typography--body2">Department of Computer Technology,
            <br>Madras Institute of Technology,
            <br>MIT Road, Radha Nagar,
            <br>Chromepet, Chennai,
            <br>Tamil Nadu - 600044
          </p>

          <h1 class="mdc-typography--headline5">Drop us a query</h1>

          <form class="query-form" id="query-form" method="post"  accept-charset="UTF-8">
            <div class="mdc-text-field mdc-text-field--fullwidth">
              <input class="mdc-text-field__input" type="email" name="email" placeholder="Email Address" aria-label="Full-Width Text Field" required value="<?=$_COOKIE['email']; ?>"/>
              <div class="mdc-line-ripple"></div>
            </div>
            <div class="mdc-text-field mdc-text-field--textarea mdc-text-field--fullwidth" style="margin-top: 1rem">
              <textarea id="textarea" class="mdc-text-field__input" name="query" rows="4" required></textarea>
              <div class="mdc-notched-outline">
                <div class="mdc-notched-outline__leading"></div>
                <div class="mdc-notched-outline__notch">
                  <label for="textarea" class="mdc-floating-label">Query</label>
                </div>
                <div class="mdc-notched-outline__trailing"></div>
              </div>
            </div>
            <div style="margin-top: 1rem;">
              <button class="mdc-button mdc-button--outlined" type="submit" value="submit" style="display: block; margin-left: auto;">
                <span class="mdc-button__label">Submit</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      var tfs = document.querySelectorAll('.mdc-text-field');
      var mdTfs = []
      for (var i = tfs.length - 1; i >= 0; i--) {
        mdTfs.push(new mdc.textField.MDCTextField(tfs[i]));
      }
      var buttons = document.querySelectorAll('.mdc-button');
      for (var i = buttons.length - 1; i >= 0; i--) {
        ripples.push(new mdc.ripple.MDCRipple(buttons[i]));
      }
      var iconButtons = document.querySelectorAll('.mdc-icon-button');
      for (var i = iconButtons.length - 1; i >= 0; i--) {
        var iconButtonRipple = new mdc.ripple.MDCRipple(iconButtons[i]);
        ripples.push(iconButtonRipple);
        iconButtonRipple.unbounded = true;
      }
      var appBar = mdc.topAppBar.MDCTopAppBar.attachTo(document.querySelector('.mdc-top-app-bar'));
      var lists = document.querySelectorAll('.mdc-list');
      var mdcLists = [];
      for (var i = lists.length - 1; i >= 0; i--) {
        mdcList = new mdc.list.MDCList(lists[i]);
        ripples.push.apply(mdcList.listElements.map((listItemEl) => new mdc.ripple.MDCRipple(listItemEl)));
        mdcLists.push(mdcList);
      }
      var menu = document.querySelector('.mdc-menu');
      var mdcMenu;
      if(menu) {
        mdcMenu = new mdc.menu.MDCMenu(menu);
      }
      function openMenu(){
        mdcMenu.open = true;
      }
    </script>
    <script type="text/javascript">
      $("#query-form").submit(function(e){
        e.preventDefault();
        document.querySelector('#query-form button').setAttribute('disabled', 'true');
        var form = $("#query-form");
        $.ajax({
          url: "ajax_responses/feedback_mail.php",
          type:"POST",
          data: form.serialize(),
          success: function(response){
            $("#textarea").val('');
            $("#query-form input[name='email']").val('');
            document.querySelector('#query-form button').removeAttribute('disabled');
            showSnackbar(response);
          }
        });
      });
    </script>
  </section>
  <?php include('snackbar.php') ?>
  <?php include('footer.php') ?>
</body>
</html>
