<?php
    require 'constants.php';

    if(isset($_COOKIE['user_id']) && calculate_hash($_COOKIE['user_id'], $_COOKIE['name'], $_COOKIE['email'], $_COOKIE['phone']) != $_COOKIE['signature']) {
        header('Location: '.$domain.'/ajax_responses/logout.php');
        exit;
    }

    $currentTime = time();
    $connexionsLive = ($currentTime >= $connexionsStartTime && $currentTime <= $connexionsEndTime);
?>

<!DOCTYPE html>
<html>
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

    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="dist/material-components-web.min.css" />
    <script type="text/javascript" src="dist/material-components-web.min.js"></script>
    <script type="text/javascript" src="dist/mithril.js"></script>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body class="details-container">
    <div id='root' class='mdc-typography footer--fixed-adjust'></div>
    <?php include('footer.php') ?>
    <?php include('snackbar.php') ?>
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
                                        m('a', {href: 'home.php'},
                                            m('li', {class: 'mdc-list-item', role: 'menuitem'},
                                                m('span', {class: 'mdc-list-item__text'}, 'Home')
                                            )
                                        ),
                                        m('a', {href: 'dashboard.php'},
                                            m('li', {class: 'mdc-list-item', role: 'menuitem'},
                                                m('span', {class: 'mdc-list-item__text'}, 'Dashboard')
                                            )
                                        ),
                                        m('a', {href: 'ajax_responses/logout.php'},
                                            m('li', {class: 'mdc-list-item', role: 'menuitem'},
                                                m('span', {class: 'mdc-list-item__text'}, 'Log out')
                                            )
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
                var mdcList;
                if(cookieExists) {
                    mdcList = new mdc.list.MDCList(vnode.dom.querySelector('.mdc-list'));
                    ripples.push.apply(mdcList.listElements.map((listItemEl) => new mdc.ripple.MDCRipple(listItemEl)));
                }
            }
        }

        var currentPage = getPageToShow();
        var fabText;
        if(currentPage == 'flutter' || currentPage == 'system-design' || currentPage == 'cyber-security' || currentPage == 'artificial-intelligence' || currentPage == 'react-js' || currentPage == 'cracking-the-coding-interview')
            fabText = "Pay Now";
        else
            fabText = "Register";
        var switchPage = function(page) {
            window.history.replaceState("", "", '<?=$domain?>/details.php?id='+page);
            currentPage = page;
            if(currentPage == 'flutter' || currentPage == 'system-design' || currentPage == 'cyber-security' || currentPage == 'artificial-intelligence' || currentPage == 'react-js' || currentPage == 'cracking-the-coding-interview')
                fabText = "Pay Now";
            else
                fabText = "Register";
            registrationFab.dom.style.display = 'flex';
            if(currentPage == 'hackathon'){
                registrationFab.dom.style.display = 'none';
            }
            else if (currentPage == 'paper-presentation') {
                registrationFab.dom.style.display = 'none';
            }
            else if (currentPage == 'olpc') {
                registrationFab.dom.style.display = 'none';
            }
            drawer.open = false;
        }
        var ripples = []
        var Button = {
            view: function(vnode) {
                var buttonValues = {class: 'mdc-button mdc-ripple-upgraded '+(vnode.attrs.class?vnode.attrs.class:'mdc-button--raised'), style: vnode.attrs.style?vnode.attrs.style:""};
                return m('button', buttonValues,
                    m('span', {class: 'mdc-button__label'}, vnode.attrs.label)
                );
            },
            oncreate: function(vnode) {
                ripples.push(new mdc.ripple.MDCRipple(vnode.dom));
            }
        }
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
                        child: m('span', {class: 'mdc-list-item__text'}, 'Flutter App Development')
                    }),
                    m(NavItem, {
                        id: 'system-design',
                        child: m('span', {class: 'mdc-list-item__text'}, 'System Design')
                    }),
                    m(NavItem, {
                        id: 'cyber-security',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Cyber Security')
                    }),
                    m(NavItem, {
                        id: 'artificial-intelligence',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Artificial Intelligence')
                    }),
                    m(NavItem, {
                        id: 'react-js',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Web Development with ReactJS')
                    }),
                    m(NavItem, {
                        id: 'cracking-the-coding-interview',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Cracking the Coding Interview')
                    }),
                    m('h3', {class: 'mdc-list-group__subheader', style: 'color: #212121'}, 'Technical Events'),
                    m(NavItem, {
                        id: 'hackathon',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Motorq Hackathon')
                    }),
                    m(NavItem, {
                        id: 'amazon-intern-hiring',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Amazon Intern Hiring')
                    }),
                    m(NavItem, {
                        id: 'ospc',
                        child: m('span', {class: 'mdc-list-item__text'}, 'OnSite Programming Contest')
                    }),
                    m(NavItem, {
                        id: 'oops-its-java',
                        child: m('span', {class: 'mdc-list-item__text'}, "Oops! It's Java!")
                    }),
                    m(NavItem, {
                        id: 'web-hub',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Web Hub')
                    }),
                    m(NavItem, {
                        id: 'db-dwellers',
                        child: m('span', {class: 'mdc-list-item__text'}, 'DB Dwellers')
                    }),
                    m(NavItem, {
                        id: 'mini-placement',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Mini Placement')
                    }),
                    m(NavItem, {
                        id: 'code-n-chaos',
                        child: m('span', {class: 'mdc-list-item__text'}, "Code 'N Chaos")
                    }),
                    m(NavItem, {
                        id: 'parseltongue',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Parseltongue')
                    }),
                    m(NavItem, {
                        id: 'paper-presentation',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Paper Presentation')
                    }),
                    m('h3', {class: 'mdc-list-group__subheader', style: 'color: #212121'}, 'Non Technical Events'),
                    m(NavItem, {
                        id: 'kaleidoscope',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Kaleidoscope')
                    }),
                    m(NavItem, {
                        id: 'connexions',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Connexions')
                    }),
                    m(NavItem, {
                        id: 'bplan',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Bplan')
                    }),
                    m(NavItem, {
                        id: 'ipl-auction',
                        child: m('span', {class: 'mdc-list-item__text'}, 'IPL Auction')
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
                        id: 'freeze-it',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Freeze It!')
                    }),
                    m(NavItem, {
                        id: 'connexions-online',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Connexions Online')
                    }),
                    m(NavItem, {
                        id: 'olpc',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Online Programming Contest')
                    }),
                    m(NavItem, {
                        id: 'daily-quiz',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Daily Quiz')
                    }),
                ]);

        var drawer;
        var appDrawer = {
            view: function() {
                return m('aside', {class: 'mdc-drawer mdc-drawer--modal'}, [
                        m('a', {href: 'home.php'},
                            m('div', {class: 'mdc-drawer__header', style: 'position:relative'}, [
                                m('img', {src: 'res/prayatna-small.png', style: 'width: 50px; height: 50px;'}),
                                m('h3', {class: 'mdc-drawer__title', style: 'display: inline-block;position: absolute;margin-left: 1rem'}, "Prayatna '19")
                            ])
                        ),
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
            'flutter': {
                view: function(){
                    return m('div.anim-appear-fadein', [
                        m('h1', {class: 'mdc-typography--headline3'}, 'Flutter App Development'),
                        m('div', {class: 'center90 video-container'},
                            m('iframe', {width: '853', height: '480', src: 'https://www.youtube.com/embed/fq4N0hgOWzU', frameborder: '0', allow: 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture', allowfullscreen: 'true'})
                        ),
                        m('p', {class: 'mdc-typography--body1'}, 'Learn to create stunning new Android & iOS apps from scratch using the new Flutter Software Development Kit (SDK) released by Google very recently.'),
                        m('p', {class: 'mdc-typography--body1'}, 'Guiding you through this workshop would be Ruchika Gupta, a Software Engineer working at Geeky Ants, who happens to be one of the few developers in the world who were invited to attend the prestigious Flutter Live, an international conference for Flutter developers conducted by Google in December 2018. She is also well versed in mobile and web app development.'),
                        m('p', {class: 'mdc-typography--body1'}, 'For this workshop, there is no prerequisite knowledge required, as it will be suitable for even beginners who have never created a mobile application yet. At the end of the workshop, you will realize how easy it is to develop material design apps for Android & iOS in a streamlined and clutter-free manner.'),
                        m('p', {class: 'mdc-typography--body1'},
                            'To know more about the speaker, check out their',
                            m('a', {href: "https://github.com/geekruchika", style: 'color: black; font-weight: bold;'}, ' GitHub,'),
                            m('a', {href: "https://www.linkedin.com/in/ruchika-gupta-b18946134", style: 'color: black; font-weight: bold;'}, ' LinkedIn,'),
                            m('a', {href: "https://blog.geekyants.com/how-flutter-took-me-all-the-way-to-london-flutter-live-2018-900f0b789560", style: 'color: black; font-weight: bold;'}, ' Medium'),
                            ' profiles.'
                        ),
                        m('h1', {class: 'mdc-typography--headline6'}, 'Time and Date: 9am - 5pm on March 8'),
                        m('h1', {class: 'mdc-typography--headline6'}, 'Registration Amount: Rs. 799'),
                        m('h1', {class: 'mdc-typography--headline4'}, 'Objectives'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'Learn about how app development is done'),
                            m('li', 'Learn the difference between native development & cross-platform'),
                            m('li', 'Learn the basics of dart'),
                            m('li', 'Learn about Flutter and its Architecture'),
                            m('li', 'Build a Real-Time App with 2-3 screens, beautiful layouts and navigation'),
                        ),
                        m('h1', {class: 'mdc-typography--headline4'}, 'Note'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'Participants have to bring their own laptop'),
                            m('li', 'Registration is provided on first come first serve basis'),
                            m('li', 'Lunch will be provided to participants during the workshop'),
                            m('li',
                                'For any queries contact Thiruveni: ',
                                m('a', {href: 'tel:+918870680356'}, '8870680356'),
                                ', Gowtham: ',
                                m('a', {href: 'tel:+918124965971'}, '8124965971')
                            ),
                        ),
                    ]);
                }
            },
            'system-design': {
                view: function(){
                    return m('div.anim-appear-fadein', [
                        m('h1', {class: 'mdc-typography--headline3'}, 'System Design'),
                        m('p', {class: 'mdc-typography--body1'}, 'The first step towards solving a real-world problem is designing its architecture and system. Without it, there would be no foundation for a project and rectifying issues later on can become very troublesome.'),
                        m('p', {class: 'mdc-typography--body1'}, 'In this workshop, you will learn to design complex systems from scratch, starting from analyzing requirements to building its system architecture and generating a high-level solution. You will also gain expert knowledge on designing scalable systems, load balancing and acquire hands-on experience of designing a Whatsapp Messenger system.'),
                        m('p', {class: 'mdc-typography--body1'}, 'Mentoring you in this workshop is Gaurav Sen, who, currently working at Uber, has significant expertise in this area having developed such systems for top tech-companies. Gaurav also happens to be one of India’s most famous Youtubers in the Computer Science domain, having over 50000 subscribers.'),
                        m('p', {class: 'mdc-typography--body1'},
                            'To know more about the speaker, check out their',
                            m('a', {href: "https://www.youtube.com/channel/UCRPMAqdtSgd0Ipeef7iFsKw", style: 'color: black; font-weight: bold;'}, ' YouTube,'),
                            m('a', {href: "https://www.linkedin.com/in/gaurav-sen-56b6a941", style: 'color: black; font-weight: bold;'}, ' LinkedIn'),
                            ' profiles.'
                        ),
                        m('h1', {class: 'mdc-typography--headline6'}, 'Time and Date: 9am - 5pm on March 9'),
                        m('h1', {class: 'mdc-typography--headline6'}, 'Registration Amount: Rs. 699'),
                        m('h1', {class: 'mdc-typography--headline4'}, 'Objectives'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'Learn about Scalability on the Cloud'),
                            m('li', 'Learn about NoSQL Databases'),
                            m('li', 'Learn the basics of Load Balancing'),
                            m('li', 'Designing a Rate Limiter'),
                            m('li', 'Designing a Messenger like Whatsapp'),
                        ),
                        m('h1', {class: 'mdc-typography--headline4'}, 'Note'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'Participants have to bring their own laptop'),
                            m('li', 'Registration is provided on first come first serve basis'),
                            m('li', 'Lunch will be provided to participants during the workshop'),
                            m('li',
                                'For any queries contact Deepak: ',
                                m('a', {href: 'tel:+919940393325'}, '9940393325'),
                                ', Varshini: ',
                                m('a', {href: 'tel:+918124319730'}, '8124319730')
                            ),
                        ),
                    ]);
                }
            },
            'artificial-intelligence': {
                view: function(){
                    return m('div.anim-appear-fadein', [
                        m('h1', {class: 'mdc-typography--headline3'}, 'Artificial Intelligence'),
                        m('p', {class: 'mdc-typography--body1'}, 'From smart cities to self-driving cars, Artificial Intelligence is progressing rapidly. It is quickly taking over various parts of our day-to-day life. The gap between human intelligence and machine intelligence is getting closer and closer. Hence, it is vital to understand how we can use this technology and implement powerful and innovative ideas harnessing the power of AI.'),
                        m('p', {class: 'mdc-typography--body1'}, "That would exactly be what you are going to learn by attending this workshop, which is hosted by InMobi, one of the world's leading platform providers for mobile marketing and advertising. They have pioneered many ideas in this field, and will be teaching you how you can do gain expert knowledge on Artificial Intelligence. Gear up to be inspired and motivated by the magic of AI after attending this workshop."),
                        m('p', {class: 'mdc-typography--body1'},
                            'To know more about the speaker, check out their',
                            m('a', {href: "https://www.linkedin.com/in/ramkumarcs31", style: 'color: black; font-weight: bold;'}, ' LinkedIn'),
                            ' profile.'
                        ),
                        m('h1', {class: 'mdc-typography--headline6'}, 'Time and Date: 9am - 5pm on March 8'),
                        m('h1', {class: 'mdc-typography--headline6'}, 'Registration Amount: Rs. 699'),
                        m('h1', {class: 'mdc-typography--headline4'}, 'Note'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'Participants have to bring their own laptop'),
                            m('li', 'Registration is provided on first come first serve basis'),
                            m('li', 'Lunch will be provided to participants during the workshop'),
                            m('li',
                                'For any queries contact Prashanth: ',
                                m('a', {href: 'tel:+919003165816'}, '9003165816'),
                                ', Janani: ',
                                m('a', {href: 'tel:+919791150172'}, '9791150172')
                            ),
                        ),
                    ]);
                }
            },
            'react-js': {
                view: function(){
                    return m('div.anim-appear-fadein', [
                        m('h1', {class: 'mdc-typography--headline3'}, 'Web Development with ReactJS'),
                        m('p', {class: 'mdc-typography--body1'}, 'React is a JavaScript library designed to be a straightforward and painless way to develop interactive user interfaces. Developed by Facebook, this is one of the most powerful libraries present for designing modern applications in real-time with impressive aesthetics and simplified back-ends. You will learn to use this library for designing such applications from scratch, and get yourself acquainted with some impressive techniques that you can use for developing your own, using this library.'),
                        m('p', {class: 'mdc-typography--body1'}, "The workshop is conducted by the official chapter of Google Developers Group (GDG) in Chennai, who host a vareity of technical activites like Tech Talks, Meetups, Code Sprints and Hackathons."),
                        m('h1', {class: 'mdc-typography--headline6'}, 'Time and Date: 9am - 5pm on March 9'),
                        m('h1', {class: 'mdc-typography--headline6'}, 'Registration Amount: Rs. 649'),
                        m('h1', {class: 'mdc-typography--headline4'}, 'Objectives'),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Theory'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'Learn the What, Why and How of ReactJS'),
                            m('li', 'Learn to setup a React Development Environment'),
                            m('li', 'Learn about JSX'),
                            m('li', 'Learn about React Components and their interactions'),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Hands on'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'Install and setup Cloud Firestore database'),
                            m('li', 'Create a sample React Web application'),
                            m('li', 'Integrate React Router'),
                            m('li', 'Run and test the application'),
                        ),
                        m('h1', {class: 'mdc-typography--headline4'}, 'Note'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'Participants have to bring their own laptop'),
                            m('li', 'Registration is provided on first come first serve basis'),
                            m('li', 'Lunch will be provided to participants during the workshop'),
                            m('li',
                                'For any queries contact Abilash: ',
                                m('a', {href: 'tel:+917871615411'}, '7871615411'),
                                ', Bharani: ',
                                m('a', {href: 'tel:+919698907530'}, '9698907530')
                            ),
                        ),
                    ]);
                }
            },
            'cracking-the-coding-interview': {
                view: function(){
                    return m('div.anim-appear-fadein', [
                        m('h1', {class: 'mdc-typography--headline3'}, 'Cracking the Coding Interview'),
                        m('p', {class: 'mdc-typography--body1'}, 'With advancements in Computer Science, tech companies have sprung up in huge numbers all over the world. The demand for good talent is always high, and one needs to equip themselves with the necessary skills to be hired. Enter Cracking the Coding Interviews – a workshop where you’ll be taught the art of acing interviews. You’ll learn in-depth about the various modes in which interviews are conducted, the skills necessary to crack them, best ways to prepare for placements and tips to present yourself in the best way possible.'),
                        m('p', {class: 'mdc-typography--body1'}, "The workshop is hosted by Hemanth Prasath, a software engineer currently working with PayPal and an alumnus of MIT. Hemanth balanced both competitive programming and learning application development during his college days, and regularly aced coding competitions and hackathons. He has also mentored many of his juniors, to become successful programmers in this field. He also happens to be one of the youngest members of the PayPal interviewing team in India."),
                        m('p', {class: 'mdc-typography--body1'},
                            'To know more about the speaker, check out their',
                            m('a', {href: "https://www.linkedin.com/in/itsmehemm", style: 'color: black; font-weight: bold;'}, ' LinkedIn,'),
                            m('a', {href: "https://github.com/itsmehemm", style: 'color: black; font-weight: bold;'}, ' GitHub'),
                            ' profiles.'
                        ),
                        m('h1', {class: 'mdc-typography--headline6'}, 'Time and Date: 9am - 5pm on March 8'),
                        m('h1', {class: 'mdc-typography--headline6'}, 'Registration Amount: Rs. 499'),
                        m('h1', {class: 'mdc-typography--headline4'}, 'Objectives'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'Learn what happens behind the scenes of a Programming Interview'),
                            m('li', 'Tips for pre-interview and post-interview measures'),
                            m('li', 'Learn about various concepts vis-a-vis Arrays, LinkedLists, Trees, Graphs, DP, String'),
                            m('li', 'Learn various Algorithm Strategies (Searching, Sorting, BIT Manipulation, Memoization. etc)'),
                            m('li', 'Learn the steps involved in solving an algorithmic problem'),
                            m('li', 'Learn how companies evaluate candidates during interviews'),
                            m('li', 'Sample Mock Interviews')
                        ),
                        m('h1', {class: 'mdc-typography--headline4'}, 'Note'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'Registration is provided on first come first serve basis'),
                            m('li', 'Lunch will be provided to participants during the workshop'),
                            m('li',
                                'For any queries contact Prashanth: ',
                                m('a', {href: 'tel:+919003165816'}, '9003165816'),
                                ', Amarnath: ',
                                m('a', {href: 'tel:+919080082180'}, '9080082180')
                            ),
                        ),
                    ]);
                }
            },
            'cyber-security': {
                view: function(){
                    return m('div.anim-appear-fadein', [
                        m('h1', {class: 'mdc-typography--headline3'}, 'Cyber Security'),
                        m('p', {class: 'mdc-typography--body1'}, 'With the constantly evolving nature of security risks, it is imperative for the tech-world to design secure systems that are safe from cyberattacks. In 2018, it was estimated that the big four software companies spent 75+ billion dollars for their cybersecurity measures. "With great tech comes great responsibility" - to protect it from evil.'),
                        m('p', {class: 'mdc-typography--body1'}, "Enroll for this workshop and become acquainted with the mystic world of Computer Security and Ethical Hacking. Handling this workshop would be experts from Ernst and Young (EY), one of the largest accounting firms in the world. Handling hundreds of billions of dollars in assets, EY requires complex and robust security measures to counter attacks from hackers all over the world. Come - learn from the experts! "),
                        m('h1', {class: 'mdc-typography--headline6'}, 'Time and Date: 9am - 5pm on March 9'),
                        m('h1', {class: 'mdc-typography--headline6'}, 'Registration Amount: Rs. 699'),
                        m('h1', {class: 'mdc-typography--headline4'}, 'Objectives'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'Learn the basics and recent trends in Cyber Security'),
                            m('li', 'Learn the phases of a Security Breach'),
                            m('li', 'Learn the basics of Cyber Forensics'),
                            m('li', 'Learn and simulate Email Phishing'),
                            m('li', 'Learn about TOR and VPN'),
                            m('li', 'Learn the basics of Cyrptocurrency'),
                        ),
                        m('h1', {class: 'mdc-typography--headline4'}, 'Note'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'Participants have to bring their own laptop'),
                            m('li', 'Registration is provided on first come first serve basis'),
                            m('li', 'Lunch will be provided to participants during the workshop'),
                            m('li',
                                'For any queries contact Pradeepa: ',
                                m('a', {href: 'tel:+917358547119'}, '7358547119'),
                                ', Preethi: ',
                                m('a', {href: 'tel:+918248670229'}, '8248670229')
                            ),
                        ),
                    ]);
                }
            },
            'amazon-intern-hiring': {
                view: function(){
                    return m('div.anim-appear-fadein', [
                        m('h1', {class: 'mdc-typography--headline3'}, 'Amazon Intern Hiring'),
                        m('p', {class: 'mdc-typography--body1'},
                            `The event you've been waiting for is finally here! Prayatna '19 is proud to partner with Amazon for their intern hiring.`),
                        m('p', {class: 'mdc-typography--body1'},
                            `There will be 3 rounds in the hiring challenge. The first round will be a pen-and-paper test open to all. Shortlisted candidates will go through a coding round. The questions for the coding round will be officially administered by a team of Amazon Engineers. Those selected from the coding round will be interviewed in a Face-to-Face (F2F) round by volunteers of Prayatna. The combined results (pen and paper, coding, f2f) of all F2F participants will be forwarded to Amazon.`),
                        m('p', {class: 'mdc-typography--body1'},
                            `Selection of the top participants of the F2F round lies at Amazon's discretion and they will be offered an internship interview opportunity.`),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Prizes'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'Internship(s) at Amazon for top candidates'),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Schedule'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'March 8 - Pen & Paper round, Coding round'),
                            m('li', 'March 9 - F2F interviews'),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Rules'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'This is an individual event'),
                            m('li', 'Participation is restricted to second and third year students currently enrolled in their Engineering Bachelors program'),
                            m('li',
                                'For any queries contact Srinivas: ',
                                m('a', {href: 'tel:+919442248023'}, '9442248023'),
                            ),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'General Guidelines'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'It is mandatory to have a valid Prayatna entry ticket to participate in this event'),
                            m('li', 'The schedule published is only tentative and may be subjected to change. Participants are requested to regularly check the website for updates'),
                            m('li', "The internship winners for all events are promptly forwarded to the  respective companies. The decision to hire the interns directly (or) conduct additional interviews is at the discretion of the company and Prayatna shall not be held responsible for the company's decisions"),
                            m('li', "The internship companies' allotment for various events is tentative. There might be changes or modifications to the same. Participants are requested to regularly check the website for updates"),
                            m('li', 'If multiple companies are offering internships for the same event, the preference of companies is left to the participants. Highest placed team will get priority to reserve their preference first'),
                            m('li', 'Decisions made by the administrators will be final'),
                            m('li', 'Participants found to indulge in any malpractice will be disqualified immediately'),
                            m('li', 'The participants will not be permitted to refer to any additional material or mobile phones, unless explicitly specified in the event description'),
                        ),
                    ]);
                }
            },
            'ospc': {
                view: function(){
                    return m('div.anim-appear-fadein', [
                        m('h1', {class: 'mdc-typography--headline3'}, 'OnSite Programming Contest'),
                        m('p', {class: 'mdc-typography--body1'},
                            `Although there is exponential development in the compiling power in recent times, a great programmer is the one who can write seamless code without the aid of fancy machine configurations. An efficient code comes to our rescue every single time there needs an optimization in the system. OSPC is the contest which tests the coders’ talent in coming up with fast yet creative solutions for algorithmic problems. Being one of the most rigorous programming contests, OSPC covers multiple facets of coding and skills including logical thinking, programming and debugging.`),
                        m('p', {class: 'mdc-typography--body1'},
                            `This event, that mainly deals with domains of CS like data structures and algorithms, consists of two rounds. The first round is a pen and paper test involving variety of coding questions. The second round is an online coding contest on online judges such as Hackerrank or Codechef.`),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Prizes'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'Cash prizes worth Rs. 3000 for the top two teams'),
                            m('li', 'Internships at Freshworks (6 months) and Caratlane Solutions for the top two teams'),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Schedule'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'March 8 - Prelims and Finals'),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Rules'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'This is a team event and a maximum of 2 members can be a part of a team'),
                            m('li', 'The same person cannot be a part of more than one team.'),
                            m('li', 'First Round: Pen & Paper Round'),
                            m('ul', {class: 'mdc-typography--body1'},
                                m('li', 'Topics: DS, Algorithms, Debugging'),
                                m('li', 'Format: Short answers and simple code-writing'),
                                m('li', 'Time Limit: 45 mins'),
                            ),
                            m('li', 'Second Round: Online Coding Round'),
                            m('ul', {class: 'mdc-typography--body1'},
                                m('li', 'Format: Competitive programming challenge on Hackerrank/Codechef'),
                                m('li', 'Time Limit: 90 minutes'),
                            ),
                            m('li',
                                'For any queries contact Akshay: ',
                                m('a', {href: 'tel:+918056027690'}, '8056027690'),
                                ', Timothy: ',
                                 m('a', {href: 'tel:+919677207736'}, '9677207736')
                            ),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'General Guidelines'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'It is mandatory to have a valid Prayatna entry ticket to participate in this event'),
                            m('li', 'The schedule published is only tentative and may be subjected to change. Participants are requested to regularly check the website for updates'),
                            m('li', "The internship winners for all events are promptly forwarded to the  respective companies. The decision to hire the interns directly (or) conduct additional interviews is at the discretion of the company and Prayatna shall not be held responsible for the company's decisions"),
                            m('li', "The internship companies' allotment for various events is tentative. There might be changes or modifications to the same. Participants are requested to regularly check the website for updates"),
                            m('li', 'If multiple companies are offering internships for the same event, the preference of companies is left to the participants. Highest placed team will get priority to reserve their preference first'),
                            m('li', 'Decisions made by the administrators will be final'),
                            m('li', 'Participants found to indulge in any malpractice will be disqualified immediately'),
                            m('li', 'The participants will not be permitted to refer to any additional material or mobile phones, unless explicitly specified in the event description'),
                        ),
                    ]);
                }
            },
            'oops-its-java': {
                view: function(){
                    return m('div.anim-appear-fadein', [
                        m('h1', {class: 'mdc-typography--headline3'}, "OOPS! It's Java"),
                        m('p', {class: 'mdc-typography--body1'},
                            `The real challenge for a coder lies in his ability to write code that ensures readability, by reducing complexity and improving the maintainability of the system. For ages, Object Oriented Programming Systems have aided coders to face this challenge and Java is widely used to create complete applications that can run on a single computer. OOPS! It’s JAVA! is a JAVA-specific programming contest conducted to put your knowledge of the language to test.`),
                        m('p', {class:'mdc-typography--body1'},
                            `In the first round, the participants should answer simple programming questions on JAVA concepts. The second round requires participants to design small real-world applications using JAVA. `),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Prizes'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'Cash prizes worth Rs. 3000 for the top two teams'),
                            m('li', 'Internships at Zoho and CNSI for the top two teams'),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Schedule'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'March 9 - Prelims and Finals'),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Rules'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'This is a team event and a maximum of 2 members can be a part of a team'),
                            m('li', 'The same person cannot be a part of more than one team.'),
                            m('li', 'First Round: Pen & Paper Round'),
                            m('ul', {class: 'mdc-typography--body1'},
                                m('li', 'Objective type questions on various concepts of JAVA'),
                                m('li', 'Simple coding questions in JAVA'),
                                m('li', 'Time Limit: 45 mins'),
                            ),
                            m('li', 'Second Round: Coding Round'),
                            m('ul', {class: 'mdc-typography--body1'},
                                m('li', 'Solve as many as you can (Algorithmic Questions, Application Development with Databases, JAVA Concepts like Threading etc)'),
                                m('li', 'Time Limit: 60 minutes'),
                            ),
                            m('li',
                                'For any queries contact Karthik: ',
                                m('a', {href: 'tel:+919940191782'}, '9940191782'),
                                ', Abinav: ',
                                m('a', {href: 'tel:+919445841217'}, '9445841217')
                            ),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'General Guidelines'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'It is mandatory to have a valid Prayatna entry ticket to participate in this event'),
                            m('li', 'The schedule published is only tentative and may be subjected to change. Participants are requested to regularly check the website for updates'),
                            m('li', "The internship winners for all events are promptly forwarded to the  respective companies. The decision to hire the interns directly (or) conduct additional interviews is at the discretion of the company and Prayatna shall not be held responsible for the company's decisions"),
                            m('li', "The internship companies' allotment for various events is tentative. There might be changes or modifications to the same. Participants are requested to regularly check the website for updates"),
                            m('li', 'If multiple companies are offering internships for the same event, the preference of companies is left to the participants. Highest placed team will get priority to reserve their preference first'),
                            m('li', 'Decisions made by the administrators will be final'),
                            m('li', 'Participants found to indulge in any malpractice will be disqualified immediately'),
                            m('li', 'The participants will not be permitted to refer to any additional material or mobile phones, unless explicitly specified in the event description'),
                        ),
                    ]);
                }
            },
            'parseltongue': {
                view: function(){
                    return m('div.anim-appear-fadein', [
                        m('h1', {class: 'mdc-typography--headline3'}, 'Parseltongue'),
                        m('p', {class: 'mdc-typography--body1'},
                            `Soaring high above all other object-oriented programming languages due to its elegant code syntax, it is not surprising for Python to be preferred by tech giants such as Google and Facebook. With a plethora of open source libraries available for applications in data analysis and web development, Python is versatile to meet the requirements of any programmer. `),
                        m('p', {class:'mdc-typography--body1'},
                            `Our event mainly focuses on testing your coding skills in Python. The prelims would be a pen-and-paper round focusing on logic-cracking, programming and debugging. The second round requires you to get your hands dirty with Python, developing simple applications. `),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Prizes'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'Cash prizes worth Rs. 3000 for the top two teams'),
                            m('li', 'Internships at Skcript and Mad Street Den for the top two teams'),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Schedule'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'March 9 - Prelims and Finals'),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Rules'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'This is a team event and a maximum of 2 members can be a part of a team'),
                            m('li', 'The same person cannot be a part of more than one team.'),
                            m('li', 'First Round: Pen & Paper Round'),
                            m('ul', {class: 'mdc-typography--body1'},
                                m('li', 'Objective type questions on various concepts of Python'),
                                m('li', 'Simple coding questions in Python'),
                                m('li', 'Time Limit: 45 mins'),
                            ),
                            m('li', 'Second Round: Coding Round'),
                            m('ul', {class: 'mdc-typography--body1'},
                                m('li', 'Solve as many as you can (Algorithmic Questions, UI Development, Web services and simple machine learning questions)'),
                                m('li', 'Time Limit: 60 minutes'),
                            ),
                            m('li',
                                'For any queries contact Madhumitha: ',
                                m('a', {href: 'tel:+918680851230'}, '8680851230'),
                                ', Harshavardhan: ',
                                m('a', {href: 'tel:+918072843284'}, '8072843284')
                            ),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'General Guidelines'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'It is mandatory to have a valid Prayatna entry ticket to participate in this event'),
                            m('li', 'The schedule published is only tentative and may be subjected to change. Participants are requested to regularly check the website for updates'),
                            m('li', "The internship winners for all events are promptly forwarded to the  respective companies. The decision to hire the interns directly (or) conduct additional interviews is at the discretion of the company and Prayatna shall not be held responsible for the company's decisions"),
                            m('li', "The internship companies' allotment for various events is tentative. There might be changes or modifications to the same. Participants are requested to regularly check the website for updates"),
                            m('li', 'If multiple companies are offering internships for the same event, the preference of companies is left to the participants. Highest placed team will get priority to reserve their preference first'),
                            m('li', 'Decisions made by the administrators will be final'),
                            m('li', 'Participants found to indulge in any malpractice will be disqualified immediately'),
                            m('li', 'The participants will not be permitted to refer to any additional material or mobile phones, unless explicitly specified in the event description'),
                        ),
                    ]);
                }
            },
            'hackathon': {
                view: function(){
                    showSnackbar('Last Date for Hackathon Idea submission: Feb 28', 10);
                    return m('div.anim-appear-fadein', [
                        m('h1', {class: 'mdc-typography--headline3'}, 'Motorq Hackathon'),
                        m('p', {class: 'mdc-typography--body1'},
                            'We are proud to partner with ', m('a', {href: "https://motorq.co", style: 'color: black; font-weight: bold;'}, 'Motorq  - Accelerating Connected Cars'), ' for this event.'
                        ),
                        m('p', {class: 'mdc-typography--body1'},
                            'The flagship event of Prayatna 2019, Motorq Hackathon, would serve as a platform for creative problem solving and to foster innovation through collaboration.'
                        ),
                        m('p', {class: 'mdc-typography--body1'},
                            'This is a single round event in which you will be asked to implement your own ideas for the given problem statements. A team of at-most three members can attend this contest.'
                        ),
                        m('p', {class: 'mdc-typography--body1'},
                            "The judging would be done by industry veterans and experts. Each team would be judged on several parameters such as uniqueness of their idea, complexity, innovation, usefulness and relevance to the theme."
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Schedule'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li',
                                'Last Date for sending proposals: ',
                                m('b', 'February 28'),
                            ),
                            m('li', 'Hackathon: March 2, 10AM to March 3, 10AM (24 hours)'),
                            m('li', 'Followed by demo (approx. 2-3 hours)'),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Prizes'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'Cash prizes worth ',
                                m('b', 'Rs. 30,000'),
                                ' for the top teams'
                            ),
                            m('li', 'Teams working on ',
                                m('b', 'starred domains'),
                                ' also stand a chance at getting interview opportunities for ',
                                m('b', 'internships with stipends of 1L per month'),
                                ' at Motorq!'
                            ),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Domains'),
                        m('h1', {class: 'mdc-typography--headline6'},
                            m('span', {class: 'material-icons star-animation', style: 'line-height: 32px; width: 24px; padding-right: 6px'}, 'star_rate'),
                            m('span', {style: 'font-weight: 400'}, 'Connected Cars')
                        ),
                        m('p', {class: 'mdc-typography--body1'},
                            "The connected car technology enables vechicles equipped with intelligent systems to leverage services connected to the Internet. The advent of connected car technology brings with it a host of interesting use cases such as predictive car maintenance, fleet monitoring, smart in-car infotainment, adapative driving and driver safety, insurance, smart parking, dealership etc."
                        ),
                        m('h1', {class: 'mdc-typography--headline6'},
                            m('span', {class: 'material-icons star-animation', style: 'line-height: 32px; width: 24px; padding-right: 6px'}, 'star_rate'),
                            'Natural Language Processing'
                        ),
                        m('p', {class: 'mdc-typography--body1'},
                            "Natural Language Processing is a sub-field of AI focussed on bringing computers closer to human-level understanding of language. One of the problem statements we are interested in - Leverage NLP to query a relational database in natural language for a generic schema."
                        ),
                        m('h1', {class: 'mdc-typography--headline6'},
                            m('span', {class: 'material-icons star-animation', style: 'line-height: 32px; width: 24px; padding-right: 6px'}, 'star_rate'),
                            'AR - VR - MR (Augmented Reality, Virtual Reality, Mixed Reality)'
                        ),
                        m('p', {class: 'mdc-typography--body1'},
                            "AR adds digital elements to a live-view using the camera on a smartphone. VR implies a complete immersive experience, shutting out the user from the physical world. MR combines AR and VR, with real-world and digital-world objects interacting with one another. Transport us to another world with your applications based on any of these three subdomains!"
                        ),
                        m('h1', {class: 'mdc-typography--headline6'}, 'Social Welfare'),
                        m('p', {class: 'mdc-typography--body1'},
                            "This domain involves creation of applications which could impact the welfare of the society in distinct way. Generic example for representative purposes: Apps Ensuring Women safety."
                        ),
                        m('h1', {class: 'mdc-typography--headline6'}, 'Health Care'),
                        m('p', {class: 'mdc-typography--body1'},
                            "This domain involves creation of applications that handle the health and medical related issues associated with the user, providing guidance for better health etc."
                        ),
                        m('h1', {class: 'mdc-typography--headline6'}, 'Natural Diaster Management'),
                        m('p', {class: 'mdc-typography--body1'},
                            "This domain concerns creations of applications that can help prevent/predict natural calamities and/or handling the aftermath of the natural phenomenon. Brownie points for crowdsourcing aspects incorporated into the application."
                        ),
                        m('h1', {class: 'mdc-typography--headline6'}, 'Social Networking'),
                        m('p', {class: 'mdc-typography--body1'},
                            "Do you have groundbreaking ideas that could redefine social networking? Bring it to life by picking this domain. Create the next Tinder for dogs, network between zombies and what not!"
                        ),
                        m('h1', {class: 'mdc-typography--headline6'}, 'User assistance'),
                        m('p', {class: 'mdc-typography--body1'},
                            "This domain demands the creation of applications that provides recommendations to better the user's lifestyle. A simple generic example could be travel-and-planning recommendation through online source based on a budget provided by the user."
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Judging Criteria'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'Relevance'),
                            m('li', 'Utility'),
                            m('li', 'Uniqueness of idea'),
                            m('li', 'Complexity'),
                            m('li', 'Innovation'),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Rules'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'Each team can consist of a maximum of 3 members'),
                            m('li', 'The team members can belong to different colleges/educational institutions'),
                            m('li',
                                'Each team should send a detailed proposal of their work to ',
                                m('a', {href: 'mailto:p19.hackathon@gmail.com', style: 'color: black; font-weight: bold;'}, 'p19.hackathon@gmail.com'),
                                ' before ',
                                m('b', '28th of February, 2019')
                            ),
                            m('li', 'The proposal must contain the problem statement, the intended solution, an architecture diagram for the modules, the technologies used in the tech-stack etc.'),
                            m('li', 'The proposal should also contain details regarding their team members, the institutes of each team member, and their personal contact details such as email and mobile numbers'),
                            m('li', 'We will be hosting a maximum of 25-30 teams for the hackathon, and teams will be shortlisted based on the quality of their proposal. Teams will also be shortlisted on a first-come-first-serve basis, hence kindly submit your proposals well before the deadline'),
                            m('li', 'Participants can build mobile applications, web applications, desktop applications, browser extensions or end-to-end applications for the purpose of the hackathon'),
                            m('li',
                                'Each shortlisted team member must pay a registration fee of ',
                                m('b', 'Rs. 200'),
                                ' to enroll in this event. This fee is inclusive of their food expenses during the hackathon. Prayatna entry tickets are not required for Hackathon participation'
                            ),
                            m('li', 'The participants will be intimated about their selection for the hackathon well in advance, and only those teams that pay the fees before March 1 will be permitted for the hackathon. If a selected team fails to pay the registration amount before the deadline, they will be substituted by other teams'),
                            m('li', 'Each shortlisted participant must carry a valid college ID card with them'),
                            m('li', 'As per university rules, girls who wish to take part in the hackathon are requested to carry a letter from their parents, permitting them to attend the event'),
                            m('li', 'The hackathon will be a 24-hour event conducted in our campus CSE department labaratory. If participants require accomodation before or after the duration of the hackathon, it can be arranged externally. Kindly inform us regarding such requirements before hand'),
                            m('li', 'The timings of the hackathon are tentative and subject to change'),
                            m('li', 'If participants are indulging in any sort of malpractice, Prayatna reserves the rights to disqualify such teams'),
                            m('li', 'The domains specified are subject to change. Participants are requested to regularly check the site to keep themselves updated regarding new domains that are added'),
                            m('li',
                                'For any queries contact Akshay: ',
                                m('a', {href: 'tel:+918056027690'}, '8056027690'),
                                ', Amarnath: ',
                                m('a', {href: 'tel:+919003284939'}, '9003284939')
                            ),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'General Guidelines'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'The schedule published is only tentative and may be subjected to change. Participants are requested to regularly check the website for updates'),
                            m('li', "The internship winners for all events are promptly forwarded to the  respective companies. The decision to hire the interns directly (or) conduct additional interviews is at the discretion of the company and Prayatna shall not be held responsible for the company's decisions"),
                            m('li', "The internship companies' allotment for various events is tentative. There might be changes or modifications to the same. Participants are requested to regularly check the website for updates"),
                            m('li', 'If multiple companies are offering internships for the same event, the preference of companies is left to the participants. Highest placed team will get priority to reserve their preference first'),
                            m('li', 'Decisions made by the administrators will be final'),
                            m('li', 'Participants found to indulge in any malpractice will be disqualified immediately'),
                            m('li', 'The participants will not be permitted to refer to any additional material or mobile phones, unless explicitly specified in the event description'),
                        ),
                    ]);
                }
            },
            'mini-placement': {
                view: function(){
                    return m('div.anim-appear-fadein', [
                        m('h1', {class: 'mdc-typography--headline3'}, 'Mini Placement'),
                        m('p', {class: 'mdc-typography--body1'},
                            `Want to know what's it like to attend a job interview? If you are an enthusiastic student who is seeking an exciting challenge for your placement year, Mini Placement is an exceptional opportunity for you. Mini Placements simulates the interview rounds including preliminary pen-and-paper test, group discussions, and HR interviews. The initial round of aptitude test may contain logical reasoning, aptitude/ math, and verbal questions, etc. The second round known as Group Discussion (GD) comprises a group of students expressing opinions on a problem statement given to them. The final HR interview would ultimately test the soft skills of the applicant, general and domain knowledge.`),
                        m('p', {class:'mdc-typography--body1'},
                            `You will gain valuable experience on how to practice, prepare and present yourself during actual interviews. We will provide you tips, tricks and advices on what to expect in the placement rounds, what the interviewer would expect from you in return and how to answer them during the interview. Come, participate and get ready for your final year placements!`),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Prizes'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'Cash prizes worth Rs. 2000 for the winner of the event'),
                            m('li', 'Internships at Accolite, Gigamon (6 months), Linkstreet and Trimble (6 months)'),
                            m('li', 'Fulltime opportunities at Gigamon for final years'),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Schedule'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'March 8 - Pen and paper round'),
                            m('li', 'March 9 - Online Test and F2F interviews'),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Rules'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'This is an individual event'),
                            m('li', 'First Round: Pen & Paper Round'),
                            m('ul', {class: 'mdc-typography--body1'},
                                m('li', 'Topics: DS, Algo and Aptitude'),
                                m('li', 'Format: MCQs'),
                                m('li', 'Time Limit: 45 mins'),
                            ),
                            m('li', 'Second Round: Online Coding Test'),
                            m('ul', {class: 'mdc-typography--body1'},
                                m('li', 'Topic: Problem solving'),
                                m('li', 'Format: Candidates have to solve 3 problems on Hackerrank'),
                                m('li', 'Time Limit: 60 minutes'),
                            ),
                            m('li', 'Third Round: Technical interview'),
                            m('ul', {class: 'mdc-typography--body1'},
                                m('li', 'Topic: OS, Networking, DBMS System Design, OOPS (may vary for first and second years)'),
                                m('li', 'Format: F2F interview'),
                                m('li', 'Time Limit: 30 minutes'),
                            ),
                            m('li',
                                'For any queries contact Kiruthika: ',
                                m('a', {href: 'tel:+918220952727'}, '8220952727'),
                                ', Swarnalakshmi: ',
                                m('a', {href: 'tel:+919445234191'}, '9445234191')
                            ),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'General Guidelines'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'It is mandatory to have a valid Prayatna entry ticket to participate in this event'),
                            m('li', 'The schedule published is only tentative and may be subjected to change. Participants are requested to regularly check the website for updates'),
                            m('li', "The internship winners for all events are promptly forwarded to the  respective companies. The decision to hire the interns directly (or) conduct additional interviews is at the discretion of the company and Prayatna shall not be held responsible for the company's decisions"),
                            m('li', "The internship companies' allotment for various events is tentative. There might be changes or modifications to the same. Participants are requested to regularly check the website for updates"),
                            m('li', 'If multiple companies are offering internships for the same event, the preference of companies is left to the participants. Highest placed team will get priority to reserve their preference first'),
                            m('li', 'Decisions made by the administrators will be final'),
                            m('li', 'Participants found to indulge in any malpractice will be disqualified immediately'),
                            m('li', 'The participants will not be permitted to refer to any additional material or mobile phones, unless explicitly specified in the event description'),
                        ),
                    ]);
                }
            },
            'web-hub': {
                view: function(){
                    return m('div.anim-appear-fadein', [
                        m('h1', {class: 'mdc-typography--headline3'}, 'Web Hub'),
                        m('p', {class: 'mdc-typography--body1'},
                            `Prove your talent as a web developer in Web Hub! Web Hub covers the fundamentals of front-end web development. Test your skills on HTML, CSS, DOM, JavaScript and also on languages for web frameworks like Java and Python.`),
                        m('p', {class:'mdc-typography--body1'},
                            `There will be two rounds for the event. In the first round, participants will be quizzed on the basics of various web technologies. The participants will have to showcase their creativity and talents by developing a web page based on a given theme in the second round.`),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Prizes'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'Cash prizes worth Rs. 3000 for the top two teams'),
                            m('li', 'Internships at Mad Street Den and Caratlane Solutions for the top two teams'),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Schedule'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'March 9 - Prelims and finals'),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Rules'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'This is a team event and a maximum of 2 members can be a part of a team'),
                            m('li', 'The same person cannot be a part of more than one team'),
                            m('li', 'First Round: Pen & Paper Round'),
                            m('ul', {class: 'mdc-typography--body1'},
                                m('li', 'Topic: Front-end Development'),
                                m('li', 'Format: Multiple Choice Questions'),
                                m('li', 'Time Limit: 30 minutes'),
                            ),
                            m('li', 'Second Round: Designing a webpage'),
                            m('ul', {class: 'mdc-typography--body1'},
                                m('li', 'Time Limit: 45 minutes'),
                            ),
                            m('li',
                                'For any queries contact Lakshmi: ',
                                m('a', {href: 'tel:+919962396478'}, '9962396478'),
                                ', Sandhya: ',
                                m('a', {href: 'tel:+919159155566'}, '9159155566')
                            ),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'General Guidelines'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'It is mandatory to have a valid Prayatna entry ticket to participate in this event'),
                            m('li', 'The schedule published is only tentative and may be subjected to change. Participants are requested to regularly check the website for updates'),
                            m('li', "The internship winners for all events are promptly forwarded to the  respective companies. The decision to hire the interns directly (or) conduct additional interviews is at the discretion of the company and Prayatna shall not be held responsible for the company's decisions"),
                            m('li', "The internship companies' allotment for various events is tentative. There might be changes or modifications to the same. Participants are requested to regularly check the website for updates"),
                            m('li', 'If multiple companies are offering internships for the same event, the preference of companies is left to the participants. Highest placed team will get priority to reserve their preference first'),
                            m('li', 'Decisions made by the administrators will be final'),
                            m('li', 'Participants found to indulge in any malpractice will be disqualified immediately'),
                            m('li', 'The participants will not be permitted to refer to any additional material or mobile phones, unless explicitly specified in the event description'),
                        ),
                    ]);
                }
            },
            'paper-presentation': {
                view: function(){
                    showSnackbar('Last date for submission of papers: Mar 3', 10);
                    return m('div.anim-appear-fadein', [
                        m('h1', {class: 'mdc-typography--headline3'}, 'Paper Presentation'),
                        m('p', {class: 'mdc-typography--body1'},
                            `Share your ideas to the world by presenting your topic in front of an inquisitive audience. One may choose any topic and/or domain from Computer science and its related disciplines, and we provide the platform for you to take it to the next level in front of a panel of esteemed judges.`),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Prizes'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'Cash Prizes worth Rs. 5000 for the top two teams'),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Schedule'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'March 3 - Last date for submission of papers by email'),
                            m('li', 'March 8 - Presentation of shortlisted papers (Finals)'),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Rules'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'Maximum number of participants in a team is 3'),
                            m('li', 'Persons from different institutions can be a part of the same team. However, one person may not be a part of multiple teams for the same event.'),
                            m('li', 'Papers should be from CS/IT related domains'),
                            m('li', 'Abstract should not exceed 1 page and Paper should not exceed 15 pages'),
                            m('li', 'Paper should be in two column format'),
                            m('li', 'Paper should be in Times New Roman font with size 12. Headings should be in bold with size 16'),
                            m('li', 'Paper must contain index, list of figures, list of tables, abstract, introduction, point wise description of subject, conclusion and references'),
                            m('li', 'Paper must be preceded by a cover page specifying the Title of the paper, Names of Team Members, their college names, their contact numbers and email ids'),
                            m('li',
                                'Mail your abstract, paper and ppt to ',
                                m('a', {href: 'mailto:paperpresentation.p19@gmail.com', style: 'color: black; font-weight: bold;'}, 'paperpresentation.p19@gmail.com'),
                                ', with subject "Paper Presentation: Prayatna 2019"'
                            ),
                            m('li', 'There is no registration/payment required for sending your papers. Only shortlisted candidates are required to register & buy a Prayatna entry ticket.'),
                            m('li', 'The mail with submissions should contain:'),
                            m('ul', {class: 'mdc-typography--body1'},
                                m('li', 'Title - Theme of the paper'),
                                m('li', 'Name, Phone and EmailID of Team Members'),
                            ),
                            m('li', 'Soft-copies of the submitted paper must be in .docx format'),
                            m('li',
                                'Last day to mail the soft copy of your report is on ',
                                m('b','March 3, 2019')
                            ),
                            m('li', 'After submission of the soft copy, a panel of judges will go through the paper and if shortlisted, you will be invited onsite for presenting your paper'),
                            m('li', 'It is advisable that the presentation focuses on one particular topic. Report should be comprehensive enough to appeal to an undergraduate. Kindly contact the coordinator for clarifications'),
                            m('li', 'Bring your college/Organization ID card'),
                            m('li', 'Bring your PowerPoint presentation on a pen-drive'),
                            m('li', 'Bring hardcopies of the submitted paper on the day of the presentation'),
                            m('li', 'The shortlisted teams will get 10-15 minutes for presentation followed by a Q&A session'),
                            m('li', 'The decision of judges will be final and no arguments or appeal will be entertained.'),
                            m('li',
                                'For any queries contact Swetha: ',
                                m('a', {href: 'tel:+917373124348'}, '7373124348'),
                                ', Narmatha: ',
                                m('a', {href: 'tel:+918526865414'}, '8526865414')
                            ),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'General Guidelines'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'The schedule published is only tentative and may be subjected to change. Participants are requested to regularly check the website for updates'),
                            m('li', "The internship winners for all events are promptly forwarded to the  respective companies. The decision to hire the interns directly (or) conduct additional interviews is at the discretion of the company and Prayatna shall not be held responsible for the company's decisions"),
                            m('li', "The internship companies' allotment for various events is tentative. There might be changes or modifications to the same. Participants are requested to regularly check the website for updates"),
                            m('li', 'If multiple companies are offering internships for the same event, the preference of companies is left to the participants. Highest placed team will get priority to reserve their preference first'),
                            m('li', 'Decisions made by the administrators will be final'),
                            m('li', 'Participants found to indulge in any malpractice will be disqualified immediately'),
                            m('li', 'The participants will not be permitted to refer to any additional material or mobile phones, unless explicitly specified in the event description'),
                        ),
                    ]);
                }
            },
            'code-n-chaos': {
                view: function(){
                    return m('div.anim-appear-fadein', [
                        m('h1', {class: 'mdc-typography--headline3'}, "Code 'N Chaos"),
                        m('p', {class: 'mdc-typography--body1'},
                            `A wise man once said – “A good programmer is one who can code with the highest level of concentration; a great programmer is one who can code in-spite of losing it.” Are you ready to face loud music, insane outdoor disturbances and frequent interruptions, all the while coding your way through algorithmic problems?`),
                        m('p', {class:'mdc-typography--body1'},
                            `The first round will be a normal pen-and-paper test, with questions on Algorithms, Data Structures and debugging. The second round will be an outdoor-event, where participants will be coding on the streets facing loud music and many other disturbances. Do you have what it takes? `),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Prizes'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'Cash prizes worth Rs. 3000 for the top two teams'),
                            m('li', 'Internships at Zoho and F22 Labs for the top two teams'),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Schedule'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'March 9 - Prelims and finals'),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Rules'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'This is a team event and a maximum of 2 members can be a part of a team'),
                            m('li', 'The same person cannot be a part of more than one team'),
                            m('li', 'First Round: Pen & Paper Round'),
                            m('ul', {class: 'mdc-typography--body1'},
                                m('li', 'Simple coding questions and algorithms'),
                                m('li', 'Time Limit: 45 minutes'),
                            ),
                            m('li', 'Second Round: Online Coding round'),
                            m('ul', {class: 'mdc-typography--body1'},
                                m('li', 'Coding round will be conducted on Hackerrank'),
                                m('li', 'The participants will be subjected to frequent disturbances and made to do fun tasks while coding'),
                            ),
                            m('li',
                                'For any queries contact Dharshna: ',
                                m('a', {href: 'tel:+919500759938'}, '9500759938'),
                                ', Sugan: ',
                                m('a', {href: 'tel:+917200090217'}, '7200090217')
                            ),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'General Guidelines'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'It is mandatory to have a valid Prayatna entry ticket to participate in this event'),
                            m('li', 'The schedule published is only tentative and may be subjected to change. Participants are requested to regularly check the website for updates'),
                            m('li', "The internship winners for all events are promptly forwarded to the  respective companies. The decision to hire the interns directly (or) conduct additional interviews is at the discretion of the company and Prayatna shall not be held responsible for the company's decisions"),
                            m('li', "The internship companies' allotment for various events is tentative. There might be changes or modifications to the same. Participants are requested to regularly check the website for updates"),
                            m('li', 'If multiple companies are offering internships for the same event, the preference of companies is left to the participants. Highest placed team will get priority to reserve their preference first'),
                            m('li', 'Decisions made by the administrators will be final'),
                            m('li', 'Participants found to indulge in any malpractice will be disqualified immediately'),
                            m('li', 'The participants will not be permitted to refer to any additional material or mobile phones, unless explicitly specified in the event description'),
                        ),
                    ]);
                }
            },
            'db-dwellers': {
                view: function(){
                    return m('div.anim-appear-fadein', [
                        m('h1', {class: 'mdc-typography--headline3'}, 'DB Dwellers'),
                        m('p', {class: 'mdc-typography--body1'},
                            `The world’s most valuable asset is no longer oil – it is data”, The Economist, May 2017. With terabytes of data being ingested every year, the need to organize data in a usable format is one of the most important tasks for Software Engineers around the world. Writing efficient DBMS queries to handle this data is even more important, and that’s exactly what you’ll be evaluated upon.`),
                        m('p', {class:'mdc-typography--body1'},
                            `The first round will be a pen-and-paper round quizzing participants on simple DBMS concepts. The second round would have the participants practically apply various Database concepts and optimizations in a timed environment to claim the title. `),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Prizes'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'Cash prizes worth Rs. 3000 for the top two teams'),
                            m('li', 'Internships at Cosgrid Networks and F22 Labs for the top two teams'),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Schedule'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'March 8 - Prelims and finals'),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Rules'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'This is a team event and a maximum of 2 members can be a part of a team'),
                            m('li', 'The same person cannot be a part of more than one team'),
                            m('li', 'First Round: Pen & Paper Round'),
                            m('ul', {class: 'mdc-typography--body1'},
                                m('li', 'Objective type questions on various concepts of DBMS'),
                                m('li', 'Time Limit: 45 minutes'),
                            ),
                            m('li', 'Second Round: Finals'),
                            m('ul', {class: 'mdc-typography--body1'},
                                m('li', 'DB Design for a given problem statement'),
                                m('li', 'Time Limit: 90 minutes'),
                            ),
                            m('li',
                                'For any queries contact Kesavan: ',
                                m('a', {href: 'tel:+917358681208'}, '7358681208'),
                                ', Seshadri: ',
                                m('a', {href: 'tel:+917358197776'}, '7358197776')
                            ),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'General Guidelines'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'It is mandatory to have a valid Prayatna entry ticket to participate in this event'),
                            m('li', 'The schedule published is only tentative and may be subjected to change. Participants are requested to regularly check the website for updates'),
                            m('li', "The internship winners for all events are promptly forwarded to the  respective companies. The decision to hire the interns directly (or) conduct additional interviews is at the discretion of the company and Prayatna shall not be held responsible for the company's decisions"),
                            m('li', "The internship companies' allotment for various events is tentative. There might be changes or modifications to the same. Participants are requested to regularly check the website for updates"),
                            m('li', 'If multiple companies are offering internships for the same event, the preference of companies is left to the participants. Highest placed team will get priority to reserve their preference first'),
                            m('li', 'Decisions made by the administrators will be final'),
                            m('li', 'Participants found to indulge in any malpractice will be disqualified immediately'),
                            m('li', 'The participants will not be permitted to refer to any additional material or mobile phones, unless explicitly specified in the event description'),
                        ),
                    ]);
                }
            },
            'kaleidoscope': {
                view: function(){
                    return m('div.anim-appear-fadein', [
                        m('h1', {class: 'mdc-typography--headline3'}, 'Kaleidoscope'),
                        m('p', {class: 'mdc-typography--body1'},
                            `Prayatna sports a wide array of events solely concentrating on the funky and cheerful side of all the geeks coming to our symposium. Some of the popular ones are Connexions, IPL auction, Treasure Hunt and Gaming; but the most coveted of them all is undoubtedly "Kaleidoscope".`),
                        m('p', {class: 'mdc-typography--body1'},
                            `Kaleidoscope tries and tests the participants' personality to the extreme. There are several rounds in this event with increasing difficulty. The specialty of these rounds is they are totally ad hoc, that is, the questions asked and the characteristics being tested depend on the kind of participants. This adds to the suspense and unpredictability of the event. The final round will culminate in a stress interview where the contestants will be pushed to insanity. The people who come out victorious out of these many stressful conditions will be crowned the fiercest champion among all.`),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Schedule'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'March 8 - Prelims'),
                            m('li', 'March 9 - Finals'),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Rules'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'This is an individual event'),
                            m('li', 'Just be yourself!'),
                            m('li',
                                'For any queries contact Aslam: ',
                                m('a', {href: 'tel:+919087907515'}, '9087907515'),
                                ', Sugan: ',
                                m('a', {href: 'tel:+917200090217'}, '7200090217')
                            ),
                        ),
                    ]);
                }
            },
            'connexions': {
                view: function(){
                    return m('div.anim-appear-fadein', [
                        m('h1', {class: 'mdc-typography--headline3'}, 'Connexions'),
                        m('p', {class: 'mdc-typography--body1'},
                            `Tired trying the Technical track? Jump out of the techie circle for minutes and let your geeky neurons zeal out to the world of fun. Prayatna2k19 presents Connexions for the enthusiast in you. Puzzle up the pictures and collor up as best connectors.`),
                    ]);
                }
            },
            'bplan': {
                view: function(){
                    return m('div.anim-appear-fadein', [
                        m('h1', {class: 'mdc-typography--headline3'}, 'BPlan'),
                        m('p', {class: 'mdc-typography--body1'},
                            `"A goal without a plan is just a wish". Do you have a clear-cut goal and a well thought-out plan to achieve the goal? Don't wait for opportunities to knock; instead build your own door. The B-Plan event of Prayatna gives you a stage to present a Business plan or Startup plan of commercial and technical well sound ideas where you can express the entrepreneur and leader in you.`),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Schedule'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'March 9 - Prelims and finals'),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Rules'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'This is a team event and a maximum of 2 members can be a part of a team'),
                            m('li', 'The same person cannot be a part of more than one team'),
                            m('li',
                                'For any queries contact Pradeep: ',
                                m('a', {href: 'tel:+919500504137'}, '9500504137'),
                                ', Chaitanya: ',
                                m('a', {href: 'tel:+917893366966'}, '7893366966')
                            ),
                        ),
                    ]);
                }
            },
            'ipl-auction': {
                view: function(){
                    return m('div.anim-appear-fadein', [
                        m('h1', {class: 'mdc-typography--headline3'}, 'IPL Auction'),
                        m('p', {class: 'mdc-typography--body1'},
                            `More players, more money, fewer slots available – there is set to be some monster bidding battles when the world's best T20 cricketers go under the hammer. IPL Auction - Every cricket fan's dream is all set at Prayatna 19. Get set to witness India's biggest bidding war. Build a strong, aggressive and solid fantasy team to grab the victory.`),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Schedule'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'March 8 - Prelims and finals'),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Rules'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', "Prelimimary Quiz: So, do you think you've good cricket knowledge? This quiz highlights some of the memorable, stastical, humorous and special events of cricket. Top 8 contestants will have an opportunity to take part in the monster bidding!"),
                            m('li', 'Rules for the finals of IPL Auction will be announced prior to the beginning of the event'),
                            m('li',
                                'For any queries contact Abilash: ',
                                m('a', {href: 'tel:+917871615411'}, '7871615411'),
                                ', Bharani: ',
                                m('a', {href: 'tel:+919698907530'}, '9698907530'),
                                ', Gokulnath: ',
                                m('a', {href: 'tel:+919445577849'}, '9445577849')
                            ),
                        ),
                    ]);
                }
            },
            'treasure-hunt': {
                view: function(){
                    return m('div.anim-appear-fadein', [
                        m('h1', {class: 'mdc-typography--headline3'}, 'Treasure Hunt'),
                        m('p', {class: 'mdc-typography--body1'},
                            `Have you ever wondered how much attention you pay to details? Are you an expert in cracking hidden clues? Test it out by participating in our Treasure Hunt, an exciting and enthralling event where you would have to explore our campus thoroughly (every nook and corner) and look for hidden clues, solving them one by one till you reach the final clue. Good luck on hitting the jackpot!`),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Schedule'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'March 8 - Prelims'),
                            m('li', 'March 9 - Finals'),
                        ),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Rules'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'This is a team event and a maximum of 3 members can be a part of a team'),
                            m('li', 'The same person cannot be a part of more than one team'),
                            m('li', 'Come participate for a fun experience!'),
                            m('li',
                                'For any queries contact Ruby: ',
                                m('a', {href: 'tel:+919171889661'}, '9171889661'),
                                ', Gayathri: ',
                                m('a', {href: 'tel:+919487410469'}, '9487410469'),
                                ', Priya: ',
                                m('a', {href: 'tel:+918056150979'}, '8056150979')
                            ),
                        ),
                    ]);
                }
            },
            'gaming': {
                view: function(){
                    return m('div.anim-appear-fadein', [
                        m('h1', {class: 'mdc-typography--headline3'}, 'Gaming'),
                        m('p', {class: 'mdc-typography--body1'},
                            `Escape reality and own the virtual world where you can have a second chance to life. Do you have what it takes to weave around the defenders and score a screamer of goal in FIFA? Deserted, alone, and a winner-takes-it-all battle royale – can you get the better of 99 other participants in PUBG? Can you help the terrorists triumph in Call of Duty? Calling all the gaming maniacs to participate in our Gaming event!`),
                    ]);
                }
            },
            'math-o-mania': {
                view: function(){
                    return m('div.anim-appear-fadein', [
                        m('h1', {class: 'mdc-typography--headline3'}, 'Math O Mania'),
                        m('p', {class: 'mdc-typography--body1'},
                            `People say mathematics is the poetry of logic ideas. Are you a math freak? If you love working your brain and solving problems, Math O Mania is the perfect event for you. Put your analytical, logical reasoning and mathematical skills to use in this event and walk away with exciting prizes!`),
                    ]);
                }
            },
            'olpc': {
                view: function(){
                    return m('div.anim-appear-fadein', [
                        m('h1', {class: 'mdc-typography--headline3'}, 'Online Programming Contest'),
                        m('p', {class: 'mdc-typography--body1'},
                            `Programming is logic-based creativity. It is a skill best acquired by practice. OLPC is an online programming contest which tests the contestants programming skills and how fast they can come up with creative, easy and efficient solutions for problems. OLPC will be conducted on an online IDE such as Hackerrank or Codechef where you can build your code, debug and test them to solve the given problems efficiently.`),
                    ]);
                }
            },
            'connexions-online': {
                view: function(){
                    <?php
                        if($connexionsLive) {
                    ?>
                    showSnackbar('Online Connexions is now live!', 10, 'Play Now', 'connexions.php');
                    <?php
                        }
                    ?>
                    return m('div.anim-appear-fadein', [
                        m('h1', {class: 'mdc-typography--headline3'}, 'Connexions Online'),
                        m('p', {class: 'mdc-typography--body1'},
                            `Alert for the connectors in you! It's time for your fingers to be busy. Stay connected from every corner and let's be online on-time. Crack our clues and top the leaderboard.`),
                        m('p', {class: 'mdc-typography--body1'}, `Stay alert! Every detail counts!`),
                        m('h1', {class: 'mdc-typography--headline6'}, 'Date: February 27th, 2019'),
                        <?php
                            if($currentTime >= $connexionsStartTime) {
                        ?>
                        m('div', [
                            m('a', {href: 'connexions_leaderboard.php'},
                                m(Button, {class: 'mdc-button--outlined', style:"--mdc-theme-primary: #252525;color:#121212;", label: 'View Leaderboard'}),
                            ),
                            <?php
                                if($connexionsLive) {
                            ?>
                            m('a', {href: 'connexions.php'},
                                m(Button, {label: 'Play Now', style: 'margin-left: 13px;'}),
                            ),
                            <?php
                                }
                            ?>
                        ]),
                        <?php
                            }
                        ?>
                        m('h1', {class: 'mdc-typography--headline4'}, 'Note'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'Participation is free for all'),
                            m('li', 'Further details will be updated later'),
                            m('li', 'For any queries, contact Preethi: 9884398352')
                        ),
                    ]);
                }
            },
            'freeze-it': {
                view: function(){
                    return m('div.anim-appear-fadein', [
                        m('h1', {class: 'mdc-typography--headline3'}, 'Freeze It!'),
                        m('p', {class: 'mdc-typography--body1'},
                            `Photography is the only language that can be understood anywhere and by anyone in the world. Photos can exhibit a lot more than words can. It doesn't exhibit the things you see, but the way you see things.`),
                        m('p', {class: 'mdc-typography--body1'},
                            `The contest will be conducted on our Instagram and Facebook pages, based on a theme. The winners will be decided by two criteria, namely the number of likes for their submission and creativity. `),
                        m('h1', {class: 'mdc-typography--headline4'}, 'Round 1'),
                        m('h1', {class: 'mdc-typography--headline5'}, 'Rules'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'One entry per person'),
                            m('li', 'Theme is open'),
                            m('li', 'Captions must be provided'),
                            m('li', 'No watermarks'),
                            m('li', 'No Editing'),
                            m('li', "Results are based on likes & Jury's decision"),
                            m('li', 'Entries will be accepted until March 3rd, 2019'),
                            m('li', 'Send in your snaps to freezeit.prayatna@gmail.com')
                        ),
                        m('h1', {class: 'mdc-typography--headline4'}, 'Round 2'),
                        m('p', {class: 'mdc-typography--body1'},
                            `This round will happen onsite on March 8. Further details will be updated later.`),
                        m('h1', {class: 'mdc-typography--headline4'}, 'Note'),
                        m('ul', {class: 'mdc-typography--body1'},
                            m('li', 'For any queries, contact Darwin: 9655268440')
                        ),
                    ]);
                }
            },
            'daily-quiz': {
                view: function(){
                    return m('div.anim-appear-fadein', [
                        m('h1', {class: 'mdc-typography--headline3'}, 'Daily Quiz'),
                        m('p', {class: 'mdc-typography--body1'},
                            `Want to test your knowledge on various subjects? Want to experience the feeling of getting the question right everyday? You are at the right place. Participate in our Daily Quiz event where you answer quizzes daily and earn chances to feature in our LeaderBoard every week. Get ready to spark your grey cells and walk away with exciting prizes!`),
                    ]);
                }
            }
        }
        var registrationFab;
        var registrationFabExtended = {
            view: function() {
                return m('button', {class: 'mdc-fab mdc-fab--extended app-fab--absolute anim-appear-pulse', onclick: function(){
                        if(cookieExists)
                            window.location.href = "dashboard.php";
                        else
                            window.location.href = "register.php";
                    }},
                    m('span', {class: 'mdc-fab__icon material-icons'}, 'person_add'),
                    m('span', {class: 'mdc-fab__label'}, fabText)
                );
            },
            oncreate: function(vnode) {
                registrationFab = vnode;
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
                        m('main', {class: 'center60 main-content-details'}, m(contents[currentPage])),
                        m(registrationFabExtended)
                    )
                ]);
            }
        };

        m.mount(root, Home);

    </script>
    <script type="text/javascript">
        if(currentPage == 'hackathon') {
            registrationFab.dom.style.display = 'none';
        }
        else if (currentPage == 'paper-presentation') {
            registrationFab.dom.style.display = 'none';
        }
        else if (currentPage == 'olpc') {
            registrationFab.dom.style.display = 'none';
        }
        <?php
            if ($connexionsLive) {
        ?>
        if(currentPage != 'connexions-online')
            showSnackbar('Online Connexions is now live!', 10, 'Play Now', 'connexions.php');
        <?php
            }
        ?>
    </script>
</body>
</html>
