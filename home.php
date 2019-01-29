<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Prayatna</title>
  <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">

  <script type="text/javascript" src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
  <script type="text/javascript" src="https://unpkg.com/mithril/mithril.js"></script>

  <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
  <script type="text/javascript" src="slick/slick.min.js"></script>

  <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>

<body class="mdc-typography">
  <header class="mdc-top-app-bar mdc-elevation--z4" style="box-shadow: 0 2px 4px rgba(0,0,0,.5)">
    <div class="mdc-top-app-bar__row">
      <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start" style="padding-left: 20px">
        <img src="res/small_logo.jpg" style="width: 35px;height: 35px;" />
        <span class="mdc-top-app-bar__title" style="letter-spacing: .5rem">Prayatna</span>
      </section>

      <!--PHP for user-->
      <?php
        // if logged in show dashboard
        if (isset($_COOKIE["user_id"])) {
	        echo '<section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
                  <button class="mdc-button app-bar-button" style="--mdc-theme-primary: #ffffff;" onclick = "location.href=\'dashboard.php\'">
                    <!--<i class="material-icons mdc-button__icon" aria-hidden="true">person_add</i>-->
                    <span class="mdc-button__label" style="letter-spacing: .1rem">My Dashboard</span>
                  </button>
                </section>';
        }
        // else show register button
        else {
          echo '<section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
                  <button class="mdc-button app-bar-button" style="--mdc-theme-primary: #ffffff;" onclick = "location.href=\'register.php\'">
                    <i class="material-icons mdc-button__icon" aria-hidden="true">person_add</i>
                    <span class="mdc-button__label" style="letter-spacing: .1rem">Register</span>
                  </button>
                </section>';
        }
      ?>


    </div>
  </header>
  <section class="section-dark section-full title-section mdc-layout-grid">
    <div class="mdc-layout-grid__inner anim-appear">
      <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
        <img class="logo" src="res/prayatna.png">
      </div>
      <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop mdc-layout-grid__cell--align-middle">
        <h1 class="mdc-typography--headline3 title-text" align="center">Ignite. Inspire. Innovate.</h1>
        <div class="slider">
          <h1 class="mdc-typography--headline4" align="center">March 8 & 9</h1>
          <h1 class="mdc-typography--headline4" align="center"><span id="days"></span> days to go!</h1>
        </div>
      </div>
    </div>

    <div class="floating-social-icons">
      <p align="right">
        <a href="facebook"><img src="res/facebook_white.png" class="img-social" /></a>
        <a href="instagram"><img src="res/instagram_white.png" class="img-social" /></a>
        <a href="whatsapp"><img src="res/whatsapp_white.png" class="img-social" /></a>
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
    <div>
      <div class="mdc-layout-grid anim-appear">
        <div class="mdc-layout-grid__cell">
          <h1 class="mdc-typography--headline3 section-header">About Us</h1>
        </div>
        <div class="mdc-layout-grid__cell">
          <p class="mdc-typography--body1 content-about">The Association of Computer Technologists takes great pride in conducting PRAYATNA, our annual national level inter-college technical festival. PRAYATNA, a conglomeration of the brightest minds in India, is hosted by the Department of Computer Technology, Anna University, MIT Campus. Over 3000 students from over 150 colleges flock to take part in this festival. In a nutshell, PRAYATNA is a platform that churns out technical and creative ideas from upcoming engineers by assessing their aptitude in coding, design, entrepreneurial skills and other multi-faceted concepts with special workshops with the help of experts from the industry enhance the participant's knowledge and creative potentials.</p>
        </div>
        <div class="mdc-layout-grid__cell ">
            <h1 class="mdc-typography--headline3 section-header">Our Sponsors</h1>
        </div>
        <ul class="mdc-layout-grid__inner mdc-image-list margin sponsors-list">
          <li class="mdc-image-list__item mdc-layout-grid__cell--span-2">
            <img class="mdc-image-list__image" src="res/LIC.png">
          </li>
          <li class="mdc-image-list__item mdc-layout-grid__cell--span-2">
            <img class="mdc-image-list__image" src="res/facebook.png">
          </li>
          <li class="mdc-image-list__item mdc-layout-grid__cell--span-2">
            <img class="mdc-image-list__image" src="res/zoho.png">
          </li>
          <li class="mdc-image-list__item mdc-layout-grid__cell--span-2">
            <img class="mdc-image-list__image" src="res/google.png">
          </li>
          <li class="mdc-image-list__item mdc-layout-grid__cell--span-2">
            <img class="mdc-image-list__image" src="res/dell.png">
          </li>
          <li class="mdc-image-list__item mdc-layout-grid__cell--span-2">
            <img class="mdc-image-list__image" src="res/amazon.jpeg">
          </li>
          <li class="mdc-image-list__item mdc-layout-grid__cell--span-2">
            <img class="mdc-image-list__image" src="res/uber.png">
          </li>
        </ul>
      </div>
    </div>
  </section>
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
      var CardPrimaryAction = {
        view: function(vnode) {
          return m('div', {class: 'mdc-card__primary-action', tabindex:"0", onclick: function() {window.location.href = "details.html?id="+vnode.attrs.id;}},
            m('div', {class: 'mdc-card__media mdc-card__media--16-9', style: vnode.attrs.style}),
            m('div', {class: 'mdc-card__primary'},
              m('h2', {class: 'mdc-card__title mdc-typography--headline6'}, vnode.attrs.title),
              m('h3', {class: 'mdc-card__subtitle mdc-typography--subtitle2'}, vnode.attrs.subtitle)
            ),
            m('div', {class: 'mdc-card__secondary mdc-typography--body2'}, vnode.attrs.secondary)
          );
        },
        oncreate: function(vnode) {
          ripples.push(new mdc.ripple.MDCRipple(vnode.dom));
        }
      }
      var Card = {
        view: function(vnode) {
          return m('div', {class: 'mdc-card mdc-elevation--z4'},
            m(CardPrimaryAction, {title: vnode.attrs.title, subtitle: vnode.attrs.subtitle, secondary: vnode.attrs.secondary, id: vnode.attrs.id, style: vnode.attrs.style})
          );
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
        m(Cell, {
          child: m(Card, {
            title: 'Flutter',
            subtitle: 'Geeky Ants',
            secondary: 'Build beautiful apps with Flutter!',
            id: 'flutter',
            style: "background-image: url('res/flutter.jpg');"
          })
        }),
        m(Cell, {
          child: m(Card, {
            title: 'Cyber Security',
            subtitle: 'Ernst & Young',
            secondary: 'Security in Computers',
            id: 'cyber-security',
            style: "background-image: url('res/cyber-security.jpg');"
          })
        }),
        m(Cell, {
          child: m(Card, {
            title: 'Artificial Intelligence',
            subtitle: 'Microsoft',
            secondary: 'Machine Learning',
            id: 'artificial-intelligence',
            style: "background-image: url('res/artificial-intelligence.jpg');"
          })
        }),
        m(Cell, {
          child: m(Card, {
            title: 'ReactJS and Node.js',
            subtitle: 'Microsoft',
            secondary: 'Machine Learning',
            id: 'react-and-node-js',
            style: "background-image: url('res/react-node-js.png');"
          })
        }),
        m(Cell, {
          child: m(Card, {
            title: 'Placement Workshop',
            subtitle: 'Microsoft',
            secondary: 'Machine Learning',
            id: 'placement',
            style: "background-image: url('res/placements.jpeg');"
          })
        }),
        m(Cell, {
          child: m(Card, {
            title: 'System Design',
            subtitle: 'Microsoft',
            secondary: 'Machine Learning',
            id: 'system-design',
            style: "background-image: url('res/system-design.jpeg');"
          })
        }),
      ]
      var techEvents = [
        m(Cell, {
          child: m(Card, {
            title: 'OSPC',
            subtitle: 'OnSite Programming Contest',
            id: 'ospc',
            style: "background-image: url('res/ospc.jpg');"
          })
        }),
        m(Cell, {
          child: m(Card, {
            title: 'Coffee With Java',
            subtitle: 'Present a Paper',
            id: 'coffee-with-java',
            style: "background-image: url('res/coffee-with-java.jpg');"
          })
        }),
        m(Cell, {
          child: m(Card, {
            title: 'Web Hub',
            subtitle: 'Present a Paper',
            id: 'paper-presentation',
            style: "background-image: url('res/web-hub.jpg');"
          })
        }),
        m(Cell, {
          child: m(Card, {
            title: 'SQL Scholar',
            subtitle: 'Present a Paper',
            id: 'sql-scholar',
            style: "background-image: url('res/sql-scholar.jpg');"
          })
        }),
        m(Cell, {
          child: m(Card, {
            title: 'Mini Placement',
            subtitle: 'Present a Paper',
            id: 'mini-placement',
            style: "background-image: url('res/mini-placement.jpg');"
          })
        }),
        m(Cell, {
          child: m(Card, {
            title: 'Street Coding',
            subtitle: 'Present a Paper',
            id: 'street-coding',
            style: "background-image: url('res/street-coding.jpg');"
          })
        }),
        m(Cell, {
          child: m(Card, {
            title: 'Paper Presentation',
            subtitle: 'Present a Paper',
            id: 'paper-presentation',
            style: "background-image: url('res/paper-presentation.jpg');"
          })
        }),
        m(Cell, {
          child: m(Card, {
            title: 'Python Event',
            subtitle: 'Present a Paper',
            id: 'python-event',
            style: "background-image: url('res/python.jpg');"
          })
        }),
        m(Cell, {
          child: m(Card, {
            title: 'Hackathon',
            subtitle: 'Present a Paper',
            id: 'hackathon',
            style: "background-image: url('res/hackathon.jpg');"
          })
        }),
      ]
      var nonTechEvents = [
        m(Cell, {
          child: m(Card, {
            title: 'Mega Event',
            subtitle: 'A oneliner about this event',
            id: 'mega-event',
            style: "background-image: url('res/mega-event.png');"
          })
        }),
        m(Cell, {
          child: m(Card, {
            title: 'Bplan',
            subtitle: 'Present a Paper',
            id: 'bplan',
            style: "background-image: url('res/bplan.jpg');"
          })
        }),
        m(Cell, {
          child: m(Card, {
            title: 'Connections',
            subtitle: 'Present a Paper',
            id: 'connections',
            style: "background-image: url('res/connections.png');"
          })
        }),
        m(Cell, {
          child: m(Card, {
            title: 'IPL Auctions',
            subtitle: 'Present a Paper',
            id: 'ipl-auctions',
            style: "background-image: url('res/ipl-auc.jpg');"
          })
        }),
        m(Cell, {
          child: m(Card, {
            title: 'Google Desk',
            subtitle: 'Present a Paper',
            id: 'google-desk',
            style: "background-image: url('res/google-desk.jpg');"
          })
        }),
        m(Cell, {
          child: m(Card, {
            title: 'Math O Mania',
            subtitle: 'Present a Paper',
            id: 'math-o-mania',
            style: "background-image: url('res/math-o-mania.jpg');"
          })
        }),
        m(Cell, {
          child: m(Card, {
            title: 'Treasure Hunt',
            subtitle: 'Present a Paper',
            id: 'treasure-hunt',
            style: "background-image: url('res/treasure-hunt.jpg');"
          })
        }),
        m(Cell, {
          child: m(Card, {
            title: 'Gaming',
            subtitle: 'Present a Paper',
            id: 'gaming',
            style: "background-image: url('res/gaming.png');"
          })
        }),
      ]
      var onlineEvents = [
        m(Cell, {
          child: m(Card, {
            title: 'Connexions',
            subtitle: 'A oneliner about this event',
            id: 'connexions',
            style: "background-image: url('res/connexions.png');"
          })
        }),
        m(Cell, {
          child: m(Card, {
            title: 'OLPC',
            subtitle: 'Present a Paper',
            id: 'olpc',
            style: "background-image: url('res/olpc.jpg');"
          })
        }),
        m(Cell, {
          child: m(Card, {
            title: 'Photography Contest',
            subtitle: 'Present a Paper',
            id: 'photo-contest',
            style: "background-image: url('res/photo-contest.jpg');"
          })
        }),
        m(Cell, {
          child: m(Card, {
            title: 'Musically',
            subtitle: 'Present a Paper',
            id: 'musically',
            style: "background-image: url('res/musically.png');"
          })
        }),
        m(Cell, {
          child: m(Card, {
            title: 'Flaw',
            subtitle: 'Present a Paper',
            id: 'flaw',
            style: "background-image: url('res/flaw.jpg');"
          })
        }),
        m(Cell, {
          child: m(Card, {
            title: 'IPL Auction',
            subtitle: 'Present a Paper',
            id: 'ipl-auction',
            style: "background-image: url('res/ipl.jpg');"
          })
        }),
        m(Cell, {
          child: m(Card, {
            title: 'Legends of Hidden Temple',
            subtitle: 'Present a Paper',
            id: 'loht',
            style: "background-image: url('res/loht.jpg');"
          })
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
          return m('div', {class: 'mdc-layout-grid'},
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
            m('div', m(Panel, {child: panelContent[currentPanel]})),
          );
        }
      }
      m.mount(document.querySelector('.workshops-events-section'), workshopEventPanel, {child: panelContent[currentPanel]});


    </script>
  </section>
  <section>
    <div class="mdc-layout-grid">
      <div class="mdc-layout-grid__cell">
          <h1 class="mdc-typography--headline3 section-header">Contact Us</h1>
      </div>
      <ul class="mdc-layout-grid__inner mdc-image-list margin contacts-list" >
        <li class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-2-phone mdc-layout-grid__cell--span-4-tablet mdc-image-list__item">
          <img class="mdc-image-list__image mdc-elevation--z4" src="res/small_logo.jpg">
          <div class="mdc-image-list__supporting">
            <span class="mdc-image-list__label"><center class="mdc-typography--body2">Praveen Siva<br>Chairman<br>+91 92768547867<br>mail@gmail.com</center></span>
          </div>
        </li>
        <li class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-2-phone mdc-layout-grid__cell--span-4-tablet mdc-image-list__item" >
          <img class="mdc-image-list__image mdc-elevation--z4" src="res/small_logo.jpg">
          <div class="mdc-image-list__supporting">
            <span class="mdc-image-list__label"><center class="mdc-typography--body2">Praveen Siva<br>Chairman<br>+91 92768547867<br>mail@gmail.com</center></span>
          </div>
        </li>
        <li class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-2-phone mdc-layout-grid__cell--span-4-tablet mdc-image-list__item">
          <img class="mdc-image-list__image mdc-elevation--z4" src="res/small_logo.jpg">
          <div class="mdc-image-list__supporting">
            <span class="mdc-image-list__label"><center class="mdc-typography--body2">Praveen Siva<br>Chairman<br>+91 92768547867<br>mail@gmail.com</center></span>
          </div>
        </li>
        <li class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-2-phone mdc-layout-grid__cell--span-4-tablet mdc-image-list__item">
          <img class="mdc-image-list__image mdc-elevation--z4" src="res/small_logo.jpg">
          <div class="mdc-image-list__supporting">
            <span class="mdc-image-list__label"><center class="mdc-typography--body2">Praveen Siva<br>Chairman<br>+91 92768547867<br>mail@gmail.com</center></span>
          </div>
        </li>
        <li class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-2-phone mdc-layout-grid__cell--span-4-tablet mdc-image-list__item">
          <img class="mdc-image-list__image mdc-elevation--z4" src="res/small_logo.jpg">
          <div class="mdc-image-list__supporting">
            <span class="mdc-image-list__label"><center class="mdc-typography--body2">Praveen Siva<br>Secratary<br>+91 92768547867<br>email@gmail.com</center></span>
          </div>
        </li>
        <li class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-2-phone mdc-layout-grid__cell--span-4-tablet mdc-image-list__item">
          <img class="mdc-image-list__image mdc-elevation--z4" src="res/small_logo.jpg">
          <div class="mdc-image-list__supporting">
            <span class="mdc-image-list__label"><center class="mdc-typography--body2">Praveen Siva<br>Event Organizer<br>+91 92768547867<br>emailid@gmail.com</center></span>
          </div>
        </li>
        <li class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-2-phone mdc-layout-grid__cell--span-4-tablet mdc-image-list__item">
          <img class="mdc-image-list__image mdc-elevation--z4" src="res/small_logo.jpg">
          <div class="mdc-image-list__supporting">
            <span class="mdc-image-list__label"><center class="mdc-typography--body2">Praveen Siva<br>Workshop Organizer<br>+91 92768547867<br>email@gmail.com</center></span>
          </div>
        </li>
        <li class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-2-phone mdc-layout-grid__cell--span-4-tablet mdc-image-list__item">
          <img class="mdc-image-list__image mdc-elevation--z4" src="res/small_logo.jpg">
          <div class="mdc-image-list__supporting">
            <span class="mdc-image-list__label"><center class="mdc-typography--body2">Praveen Siva<br>Accomodation & Hospitality<br>+91 92768547867<br>gnaighdryfl@gmail.com</center></span>
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

          <form class="query-form" method="post">
            <div class="mdc-text-field mdc-text-field--fullwidth">
              <input class="mdc-text-field__input" type="text" name="email" placeholder="Email Address" aria-label="Full-Width Text Field" />
              <div class="mdc-line-ripple"></div>
            </div>
            <div class="mdc-text-field mdc-text-field--textarea mdc-text-field--fullwidth" style="margin-top: 1rem">
              <textarea id="textarea" class="mdc-text-field__input" name="query" rows="4"></textarea>
              <div class="mdc-notched-outline">
                <div class="mdc-notched-outline__leading"></div>
                <div class="mdc-notched-outline__notch">
                  <label for="textarea" class="mdc-floating-label">Query</label>
                </div>
                <div class="mdc-notched-outline__trailing"></div>
              </div>
            </div>
            <div style="margin-top: 1rem;">
              <button class="mdc-button mdc-button--outlined" type="submit" style="display: block; margin-left: auto;">
                <span class="mdc-button__label">Submit</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <footer>
      <section style="position: relative;">
          <img src="res/small_logo.jpg" style="width: 85px; height: 85px; margin: 1rem;" />
          <div style="display: inline-block;position: absolute;vertical-align: middle;height: 100%;">
            <p class="mdc-typography--body2" style="display: block;margin-top: 1rem">Prayatna 2019<br>
              Association of Computer Technologists<br>
              Connect with us!<br>
              <a href="https://www.facebook.com">Facebook</a>&nbsp;/
              <a href="https://www.instagram.com">Instagram</a>&nbsp;/
              <a href="https://www.whatsapp.com">Whatsapp</a>
            </p>
          </div>
      </section>
    </footer>


    <script type="text/javascript">
      var tfs = document.querySelectorAll('.mdc-text-field');
      var mdTfs = []
      for (var i = tfs.length - 1; i >= 0; i--) {
        mdTfs.push(new mdc.textField.MDCTextField(tfs[i]));
      }
      var buttons = document.querySelectorAll('.mdc-button');
      for (var i = tfs.length - 1; i >= 0; i--) {
        ripples.push(new mdc.ripple.MDCRipple(buttons[i]));
      }
      var appBar = mdc.topAppBar.MDCTopAppBar.attachTo(document.querySelector('.mdc-top-app-bar'));
    </script>
  </section>
</body>
</html>





