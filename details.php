<?php
    require 'constants.php';

    if(isset($_COOKIE['user_id']) && calculate_hash($_COOKIE['user_id'], $_COOKIE['name'], $_COOKIE['email'], $_COOKIE['phone']) != $_COOKIE['signature']) {
        header('Location: '.$domain.'/ajax_responses/logout.php');
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Prayatna</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" />
    <script type="text/javascript" src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/mithril/mithril.js"></script>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
    <div id='root' class='mdc-typography' style="margin-bottom: 5rem"></div>
    <?php include('footer.php') ?>
    <script type="text/javascript">
        function parseURLParams(url) {
            var queryStart = url.indexOf("?") + 1,
                queryEnd   = url.indexOf("#") + 1 || url.length + 1,
                query = url.slice(queryStart, queryEnd - 1),
                pairs = query.replace(/\+/g, " ").split("&"),
                parms = {}, i, n, v, nv;

            if (query === url || query === "") return;

            for (i = 0; i < pairs.length; i++) {
                nv = pairs[i].split("=", 2);
                n = decodeURIComponent(nv[0]);
                v = decodeURIComponent(nv[1]);

                if (!parms.hasOwnProperty(n)) parms[n] = [];
                parms[n].push(nv.length === 2 ? v : null);
            }
            return parms;
        }
    </script>
    <script type='text/javascript'>
        var root = document.getElementById('root');
        var getPageToShow = function() {
            var params = parseURLParams(window.location.href);
            if(params == undefined) {
                window.location.href = "home.php";
            }
            return params.id
        }
        var topAppBar, cookieExists = "<?php echo isset($_COOKIE['user_id']); ?>";
        var appBar = {
            view: function() {
                var sections = [
                            m('section', {class: 'mdc-top-app-bar__section mdc-top-app-bar__section--align-start'}, [
                                m('a', {class: 'material-icons mdc-top-app-bar__navigation-icon', tabindex: '0'}, 'menu'),
                                m('span', {class: 'mdc-top-app-bar__title details-app-bar-title', style: 'font-size: 100%'}, 'Workshops and Events')
                            ]),
                        ];
                if(cookieExists) {
                    var menuButtonSection = m('section', {class: 'mdc-top-app-bar__section mdc-top-app-bar__section--align-end', role: 'toolbar'}, [
                            m('button', {class: 'mdc-button app-bar-button', style:'--mdc-theme-primary: #ffffff;', onclick:function(){
                                var mdcMenu = new mdc.menu.MDCMenu(document.querySelector('.mdc-menu'));
                                mdcMenu.open = true;
                            }} ,
                                m('i', {class: 'material-icons'}, 'more_vert')
                            ),
                            m('div', {class: 'mdc-menu-surface--anchor'},
                                m('div', {class: 'mdc-menu mdc-menu-surface anim-appear-pulse', style: 'width: 150px;', tabindex: '-1'},
                                    m('ul', {class: 'mdc-list', role: 'menu', "aria-hidden":"true", "aria-orientation":"vertical"},
                                        m('li', {class: 'mdc-list-item', role: 'menuitem', onclick: function(){
                                            window.location.href='dashboard.php'}},
                                            m('span', {class: 'mdc-list-item__text'}, 'Dashboard')
                                        ),
                                        m('li', {class: 'mdc-list-item', role: 'menuitem', onclick: function(){
                                            window.location.href='ajax_responses/logout.php'}},
                                            m('span', {class: 'mdc-list-item__text'}, 'Log out')
                                        )
                                    )
                                )
                            )
                        ]);
                    sections.push(menuButtonSection);
                }
                return m('header', {class: 'mdc-top-app-bar mdc-elevation--z4', id: 'app-bar'},
                    m('div', {class: 'mdc-top-app-bar__row'}, sections)
                );
            },
            oncreate: function(vnode) {
                topAppBar = mdc.topAppBar.MDCTopAppBar.attachTo(vnode.dom);
                topAppBar.listen('MDCTopAppBar:nav', () => {
                  drawer.open = true;
                });
            }
        }

        var currentPage = getPageToShow();
        var switchPage = function(page) {
            currentPage = page;
            drawer.open = false;
        }
        var ripples = []
        var NavItem = {
            view: function(vnode) {
                return m('a', {
                        class: 'mdc-list-item' + ((currentPage == vnode.attrs.id)?' mdc-list-item--activated':''),
                        onclick: function() {switchPage(vnode.attrs.id); },
                        'aria-selected': 'true',
                        tabindex: '0'
                    },
                    vnode.attrs.child
                );
            },
            oncreate: function(vnode) {
                ripples.push(new mdc.ripple.MDCRipple(vnode.dom));
            }
        }
        var nav = m('nav', {class: 'mdc-list'}, [
                    m('a', {class: 'mdc-list-item', href: 'home.php', 'aria-selected': 'true', tabindex: '0'}, [
                        m('h3', {class: 'mdc-list-group__subheader', style: 'color: #212121'}, 'Home')
                    ]),
                    m('h3', {class: 'mdc-list-group__subheader', style: 'color: #212121'}, 'Workshops'),
                    m(NavItem, {
                        id: 'flutter',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Flutter')
                    }),
                    m(NavItem, {
                        id: 'react-and-node-js',
                        child: m('span', {class: 'mdc-list-item__text'}, 'ReactJS and Node.js')
                    }),
                    m(NavItem, {
                        id: 'placement',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Placement Workshop')
                    }),
                    m(NavItem, {
                        id: 'cyber-security',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Cyber Security')
                    }),
                    m(NavItem, {
                        id: 'system-design',
                        child: m('span', {class: 'mdc-list-item__text'}, 'System Design')
                    }),
                    m(NavItem, {
                        id: 'artificial-intelligence',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Artificial Intelligence')
                    }),
                    m('h3', {class: 'mdc-list-group__subheader', style: 'color: #212121'}, 'Technical Events'),
                    m(NavItem, {
                        id: 'ospc',
                        child: m('span', {class: 'mdc-list-item__text'}, 'OSPC')
                    }),
                    m(NavItem, {
                        id: 'coffee-with-java',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Coffee With Java')
                    }),
                    m(NavItem, {
                        id: 'web-hub',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Web Hub')
                    }),
                    m(NavItem, {
                        id: 'sql-scholar',
                        child: m('span', {class: 'mdc-list-item__text'}, 'SQL Scholar')
                    }),
                    m(NavItem, {
                        id: 'mini-placement',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Mini Placement')
                    }),
                    m(NavItem, {
                        id: 'street-coding',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Street Coding')
                    }),
                    m(NavItem, {
                        id: 'python-event',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Python Event')
                    }),
                    m(NavItem, {
                        id: 'hackathon',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Hackathon')
                    }),
                    m(NavItem, {
                        id: 'paper-presentation',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Paper Presentation')
                    }),
                    m('h3', {class: 'mdc-list-group__subheader', style: 'color: #212121'}, 'Non Technical Events'),
                    m(NavItem, {
                        id: 'mega-event',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Mega Event')
                    }),
                    m(NavItem, {
                        id: 'bplan',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Bplan')
                    }),
                    m(NavItem, {
                        id: 'connections',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Connections')
                    }),
                    m(NavItem, {
                        id: 'ipl-auctions',
                        child: m('span', {class: 'mdc-list-item__text'}, 'IPL Auction')
                    }),
                    m(NavItem, {
                        id: 'google-desk',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Google Desk')
                    }),
                    m(NavItem, {
                        id: 'math-o-mania',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Math O Mania')
                    }),
                    m(NavItem, {
                        id: 'treasure-hunt',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Treasure Hunt')
                    }),
                    m(NavItem, {
                        id: 'gaming',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Gaming')
                    }),
                    m('h3', {class: 'mdc-list-group__subheader', style: 'color: #212121'}, 'Online Events'),
                    m(NavItem, {
                        id: 'connexions',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Connexions')
                    }),
                    m(NavItem, {
                        id: 'olpc',
                        child: m('span', {class: 'mdc-list-item__text'}, 'OLPC')
                    }),
                    m(NavItem, {
                        id: 'photo-contest',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Photography Contest')
                    }),
                    m(NavItem, {
                        id: 'musically',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Musically')
                    }),
                    m(NavItem, {
                        id: 'flaw',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Flaw')
                    }),
                    m(NavItem, {
                        id: 'ipl-auction',
                        child: m('span', {class: 'mdc-list-item__text'}, 'IPL Auction')
                    }),
                    m(NavItem, {
                        id: 'loht',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Legends of Hidden Temple')
                    }),
                ]);

        var drawer;
        var appDrawer = {
            view: function() {
                return m('aside', {class: 'mdc-drawer mdc-drawer--modal'}, [
                        m('div', {class: 'mdc-drawer__header', style: 'position:relative'}, [
                            m('img', {src: 'res/prayatna-small.png', style: 'width: 50px; height: 50px;'}),
                            m('h3', {class: 'mdc-drawer__title', style: 'display: inline-block;position: absolute;margin-left: 1rem'}, "Prayatna '19")
                        ]),
                        m('div', {class: 'mdc-drawer__content'},
                            nav
                        )
                    ]);
            },
            oncreate: function(vnode) {
                drawer = mdc.drawer.MDCDrawer.attachTo(vnode.dom);
            }
        }
        var contents = {
            'flutter': m('div.anim-appear-fadein', [
                m('h1', {class: 'mdc-typography--headline3'}, 'Flutter Workshop'),
                m('p', {class: 'mdc-typography--body1'},
                    `Flutter allows you to build beautiful native apps on iOS and Android from a single codebase. Delight your users with Flutter's built-in beautiful Material Design and Cupertino (iOS-flavor) widgets, rich motion APIs, smooth natural scrolling, and platform awareness. Flutter's widgets incorporate all critical platform differences such as scrolling, navigation, icons and fonts to provide full native performance on both iOS and Android. Flutter's hot reload helps you quickly and easily experiment, build UIs, add features, and fix bugs faster. Experience sub-second reload times, without losing state, on emulators, simulators, and hardware for iOS and Android.`),
                m('h1', {class: 'mdc-typography--headline6'}, 'Time and Date: 9am - 5pm on March 8'),
                m('h1', {class: 'mdc-typography--headline6'}, 'Registration Amount: Rs. 599'),
                m('h1', {class: 'mdc-typography--headline4'}, 'Objectives'),
                m('ul', {class: 'mdc-typography--body1'},
                    m('li', 'Learn about Material Design Components'),
                    m('li', 'Learn about Dart and Flutter widgets'),
                    m('li', 'Build a sample app'),
                    m('li', 'Explore Dart packages for Flutter'),
                ),
                m('h1', {class: 'mdc-typography--headline4'}, 'Speakers'),
                m('h1', {class: 'mdc-typography--headline5'}, 'Ruchika Gupta, Geeky Ants'),
                m('p', {class: 'mdc-typography--body1'},
                    `Flutter allows you to build beautiful native apps on iOS and Android from a single codebase. Delight your users with Flutter's built-in beautiful Material Design and Cupertino (iOS-flavor) widgets, rich motion APIs, smooth natural scrolling, and platform awareness. Flutter's widgets incorporate all critical platform differences such as scrolling, navigation, icons and fonts to provide full native performance on both iOS and Android. Flutter's hot reload helps you quickly and easily experiment, build UIs, add features, and fix bugs faster. Experience sub-second reload times, without losing state, on emulators, simulators, and hardware for iOS and Android.`),
                m('h1', {class: 'mdc-typography--headline4'}, 'Note'),
                m('ul', {class: 'mdc-typography--body1'},
                    m('li', 'Participants have to bring their own laptop'),
                    m('li', 'Registration is provided on first come first serve basis'),
                    m('li', 'For any queries, contact Praveen Siva: 9876543210')
                ),
            ]),
            'cyber-security': m('p', 'cyber-security'),
            'artificial-intelligence': m('p', 'artificial-intelligence'),
            'ospc': m('div.anim-appear-fadein', [
                m('h1', {class: 'mdc-typography--headline3'}, 'OSPC'),
                m('p', {class: 'mdc-typography--body1'},
                    `Flutter allows you to build beautiful native apps on iOS and Android from a single codebase. Delight your users with Flutter's built-in beautiful Material Design and Cupertino (iOS-flavor) widgets, rich motion APIs, smooth natural scrolling, and platform awareness. Flutter's widgets incorporate all critical platform differences such as scrolling, navigation, icons and fonts to provide full native performance on both iOS and Android. Flutter's hot reload helps you quickly and easily experiment, build UIs, add features, and fix bugs faster. Experience sub-second reload times, without losing state, on emulators, simulators, and hardware for iOS and Android.`),
                m('h1', {class: 'mdc-typography--headline6'}, 'Time and Date: 9am - 5pm on March 8'),
                m('h1', {class: 'mdc-typography--headline6'}, 'Prizes: Rs. 1000 for winners, Rs. 750 for runners'),
                m('h1', {class: 'mdc-typography--headline4'}, 'Note'),
                m('ul', {class: 'mdc-typography--body1'},
                    m('li', 'Participants must register to participate in the event'),
                    m('li', 'For any queries, contact Praveen Siva: 9876543210')
                ),
            ]),
            'paper-presentation': m('p', 'paper-presentation'),
            'mega-event': m('p', 'mega-event'),
            'connexions': m('p', 'connexions'),
        }
        var registrationFabExtended = {
            view: function() {
                return m('button', {class: 'mdc-fab mdc-fab--extended app-fab--absolute app-fab--pc anim-appear-pulse', onclick: function(){
                        if(cookieExists)
                            window.location.href = "dashboard.php";
                        else
                            window.location.href = "register.php";
                    }},
                    m('span', {class: 'mdc-fab__icon material-icons'}, 'person_add'),
                    m('span', {class: 'mdc-fab__label'}, 'Register')
                );
            },
            oncreate: function(vnode) {
                ripples.push(new mdc.ripple.MDCRipple(vnode.dom))
            }
        }
        var registrationFab = {
            view: function() {
                return m('button', {class: 'mdc-fab app-fab--absolute app-fab--mobile anim-appear-pulse', onclick: function(){
                        if(cookieExists)
                            window.location.href = "dashboard.php";
                        else
                            window.location.href = "register.php";
                    }},
                    m('span', {class: 'mdc-fab__icon material-icons'}, 'person_add')
                );
            },
            oncreate: function(vnode) {
                ripples.push(new mdc.ripple.MDCRipple(vnode.dom))
            }
        }
        var Home = {
            view: function() {
                return m('div', [
                    m(appDrawer),
                    m('div.mdc-drawer-scrim'),
                    m('div', {class: 'drawer-frame-app-content'},
                        m(appBar),
                        m('div', {class: 'mdc-top-app-bar--fixed-adjust'}),
                        m('main', {class: 'center60 main-content-details'}, contents[currentPage]),
                        m(registrationFab),
                        m(registrationFabExtended)
                    )
                ]);
            }
        };

        m.mount(root, Home);

    </script>
</body>
</html>
