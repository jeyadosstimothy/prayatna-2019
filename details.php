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
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
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
                        child: m('span', {class: 'mdc-list-item__text'}, 'ReactJS')
                    }),
                    m(NavItem, {
                        id: 'cracking-the-coding-interview',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Cracking the Coding Interview')
                    }),
                    m('h3', {class: 'mdc-list-group__subheader', style: 'color: #212121'}, 'Technical Events'),
                    m(NavItem, {
                        id: 'hackathon',
                        child: m('span', {class: 'mdc-list-item__text'}, 'Hackathon')
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
                m('h1', {class: 'mdc-typography--headline3'}, 'Flutter'),
                m('p', {class: 'mdc-typography--body1'}, 'Learn to create stunning new Android apps from scratch using the new Flutter Software Development Kit (SDK) released by Google very recently.'),
                m('p', {class: 'mdc-typography--body1'}, 'Guiding you through this workshop would be Ruchika Gupta, a Software Engineer working at Geeky Ants, who happens to be one of the few developers in the world who were invited to attend the prestigious Flutter Live, an international conference for Flutter developers conducted by Google in December 2018. She is also well versed in mobile and web app development.'),
                m('p', {class: 'mdc-typography--body1'}, 'For this workshop, there is no prerequisite knowledge required, as it will be suitable for even beginners who have never created an Android application yet. At the end of the workshop, you will realize how easy it is to develop material design apps for Android in a streamlined and clutter-free manner.'),
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
                    m('li', 'For any queries contact Timothy: 9677207736, Gowtham: 9487685854')
                ),
            ]),
            'system-design': m('div.anim-appear-fadein', [
                m('h1', {class: 'mdc-typography--headline3'}, 'System Design'),
                m('p', {class: 'mdc-typography--body1'}, 'The first step towards solving a real-world problem is designing its architecture and system. Without it, there would be no foundation for a project and rectifying issues later on can become very troublesome.'),
                m('p', {class: 'mdc-typography--body1'}, 'In this workshop, you will learn to design complex systems from scratch, starting from analyzing requirements to building its system architecture and generating a high-level solution. You will also gain expert knowledge on designing scalable systems, load balancing and acquire hands-on experience of designing a Whatsapp Messenger system.'),
                m('p', {class: 'mdc-typography--body1'}, 'Mentoring you in this workshop is Gaurav Sen, who, currently working at Uber, has significant expertise in this area having developed such systems for top tech-companies. Gaurav also happens to be one of India’s most famous Youtubers in the Computer Science domain, having over 50000 subscribers. '),
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
                    m('li', 'For any queries, contact Chaitanya: 7893366966, Varshini: 8124319730')
                ),
            ]),
            'artificial-intelligence': m('div.anim-appear-fadein', [
                m('h1', {class: 'mdc-typography--headline3'}, 'Artificial Intelligence'),
                m('p', {class: 'mdc-typography--body1'}, 'From smart cities to self-driving cars, Artificial Intelligence is progressing rapidly. It is quickly taking over various parts of our day-to-day life. The gap between human intelligence and machine intelligence is getting closer and closer. Hence, it is vital to understand how we can use this technology and implement powerful and innovative ideas harnessing the power of AI.'),
                m('p', {class: 'mdc-typography--body1'}, "That would exactly be what you are going to learn by attending this workshop, which is hosted by InMobi, one of the world's leading platform providers for mobile marketing and advertising. They have pioneered many ideas in this field, and will be teaching you how you can do gain expert knowledge on Artificial Intelligence. Gear up to be inspired and motivated by the magic of AI after attending this workshop."),
                m('h1', {class: 'mdc-typography--headline6'}, 'Time and Date: 9am - 5pm on March 8'),
                m('h1', {class: 'mdc-typography--headline6'}, 'Registration Amount: Rs. 699'),
                m('h1', {class: 'mdc-typography--headline4'}, 'Note'),
                m('ul', {class: 'mdc-typography--body1'},
                    m('li', 'Participants have to bring their own laptop'),
                    m('li', 'Registration is provided on first come first serve basis'),
                    m('li', 'For any queries, contact Rohini: 9443666720, Janani: 9791150172')
                ),
            ]),
            'react-js': m('div.anim-appear-fadein', [
                m('h1', {class: 'mdc-typography--headline3'}, 'ReactJS'),
                m('p', {class: 'mdc-typography--body1'}, 'React is a JavaScript library designed to be a straightforward and painless way to develop interactive user interfaces. Developed by Facebook, this is one of the most powerful libraries present for designing modern applications in real-time with impressive aesthetics and simplified back-ends. You will learn to use this library for designing such applications from scratch, and get yourself acquainted with some impressive techniques that you can use for developing your own, using this library.'),
                m('p', {class: 'mdc-typography--body1'}, "The workshop is hosted by GUVI, an IIT-Madras incubated company, which provides an online technical learning platform and have been successful in kickstarting many students' professional careers and enabling them to transform ideas into productive solutions. In 2017, GUVI was one of the ten startups all over India selected for the prestigious Google Developers’ Launchpad Build, a mentorship and startup accelerator initiative by Google."),
                m('h1', {class: 'mdc-typography--headline6'}, 'Time and Date: 9am - 5pm on March 9'),
                m('h1', {class: 'mdc-typography--headline6'}, 'Registration Amount: Rs. 649'),
                m('h1', {class: 'mdc-typography--headline4'}, 'Note'),
                m('ul', {class: 'mdc-typography--body1'},
                    m('li', 'Participants have to bring their own laptop'),
                    m('li', 'Registration is provided on first come first serve basis'),
                    m('li', 'For any queries, contact Aravind: 9976771656, Sri Sainee: 7358297483')
                ),
            ]),
            'cracking-the-coding-interview': m('div.anim-appear-fadein', [
                m('h1', {class: 'mdc-typography--headline3'}, 'Cracking the Coding Interview'),
                m('p', {class: 'mdc-typography--body1'}, 'With advancements in Computer Science, tech companies have sprung up in huge numbers all over the world. The demand for good talent is always high, and one needs to equip themselves with the necessary skills to be hired. Enter Cracking the Coding Interviews – a workshop where you’ll be taught the art of acing interviews. You’ll learn in-depth about the various modes in which interviews are conducted, the skills necessary to crack them, best ways to prepare for placements and tips to present yourself in the best way possible.'),
                m('p', {class: 'mdc-typography--body1'}, "The workshop is hosted by Hemanth Prasath, a software engineer currently working with PayPal and an alumnus of MIT. Hemanth balanced both competitive programming and learning application development during his college days, and regularly aced coding competitions and hackathons. He has also mentored many of his juniors, to become successful programmers in this field. He also happens to be one of the youngest members of the PayPal interviewing team in India."),
                m('h1', {class: 'mdc-typography--headline6'}, 'Time and Date: 9am - 5pm on March 8'),
                m('h1', {class: 'mdc-typography--headline6'}, 'Registration Amount: Rs. 499'),
                m('h1', {class: 'mdc-typography--headline4'}, 'Note'),
                m('ul', {class: 'mdc-typography--body1'},
                    m('li', 'Participants have to bring their own laptop'),
                    m('li', 'Registration is provided on first come first serve basis'),
                    m('li', 'For any queries, contact Praveennath: 7094281691')
                ),
            ]),
            'cyber-security': m('div.anim-appear-fadein', [
                m('h1', {class: 'mdc-typography--headline3'}, 'Cyber Security'),
                m('p', {class: 'mdc-typography--body1'}, 'With the constantly evolving nature of security risks, it is imperative for the tech-world to design secure systems that are safe from cyberattacks. In 2018, it was estimated that the big four software companies spent 75+ billion dollars for their cybersecurity measures. "With great tech comes great responsibility" - to protect it from evil.'),
                m('p', {class: 'mdc-typography--body1'}, "Enroll for this workshop and become acquainted with the mystic world of Computer Security and Ethical Hacking. Handling this workshop would be experts from Ernst and Young (EY), one of the largest accounting firms in the world. Handling hundreds of billions of dollars in assets, EY requires complex and robust security measures to counter attacks from hackers all over the world. Come - learn from the experts! "),
                m('h1', {class: 'mdc-typography--headline6'}, 'Time and Date: 9am - 5pm on March 9'),
                m('h1', {class: 'mdc-typography--headline6'}, 'Registration Amount: Rs. 799'),
                m('h1', {class: 'mdc-typography--headline4'}, 'Note'),
                m('ul', {class: 'mdc-typography--body1'},
                    m('li', 'Participants have to bring their own laptop'),
                    m('li', 'Registration is provided on first come first serve basis'),
                    m('li', 'For any queries, contact Pradeepa: 7358547119, Preethi: 9884398352')
                ),
            ]),
            'ospc': m('div.anim-appear-fadein', [
                m('h1', {class: 'mdc-typography--headline3'}, 'OnSite Programming Contest'),
                m('p', {class: 'mdc-typography--body1'},
                    `Although there is exponential development in the compiling power in recent times, a great programmer is the one who can write seamless code without the aid of fancy machine configurations. An efficient code comes to our rescue every single time there needs an optimization in the system. OSPC is the contest which tests the coders’ talent in coming up with fast yet creative solutions for algorithmic problems. Being one of the most rigorous programming contests, OSPC covers multiple facets of coding and skills including logical thinking, programming and debugging.`),
                m('p', {class: 'mdc-typography--body1'},
                    `This event, that mainly deals with domains of CS like data structures and algorithms, consists of two rounds. The first round is a pen and paper test involving variety of coding questions. The second round is an online coding contest on online judges such as Hackerrank or Codechef.`),
            ]),
            'oops-its-java': m('div.anim-appear-fadein', [
                m('h1', {class: 'mdc-typography--headline3'}, "OOPS! It's Java"),
                m('p', {class: 'mdc-typography--body1'},
                    `The real challenge for a coder lies in his ability to write code that ensures readability, by reducing complexity and improving the maintainability of the system. For ages, Object Oriented Programming Systems have aided coders to face this challenge and Java is widely used to create complete applications that can run on a single computer. OOPS! It’s JAVA! is a JAVA-specific programming contest conducted to put your knowledge of the language to test.`),
                m('p', {class:'mdc-typography--body1'},
                    `In the first round, the participants should answer simple programming questions on JAVA concepts. The second round requires participants to design small real-world applications using JAVA. `),
            ]),
            'parseltongue': m('div.anim-appear-fadein', [
                m('h1', {class: 'mdc-typography--headline3'}, 'Parseltongue'),
                m('p', {class: 'mdc-typography--body1'},
                    `Soaring high above all other object-oriented programming languages due to its elegant code syntax, it is not surprising for Python to be preferred by tech giants such as Google and Facebook. With a plethora of open source libraries available for applications in data analysis and web development, Python is versatile to meet the requirements of any programmer. `),
                m('p', {class:'mdc-typography--body1'},
                    `Our event mainly focuses on testing your coding skills in Python. The prelims would be a pen-and-paper round focusing on logic-cracking, programming and debugging. The second round requires you to get your hands dirty with Python, developing simple applications. `),
            ]),
            'hackathon': m('div.anim-appear-fadein', [
                m('h1', {class: 'mdc-typography--headline3'}, 'Motorq Hackathon'),
                m('p', {class: 'mdc-typography--body1'},
                    `The flagship event of Prayatna 2019, Motorq Hackathon, sponsored by Motorq, would serve as a platform for creative problem solving and to foster innovation through collaboration.`),
                m('p', {class:'mdc-typography--body1'},
                    `This is a single round event in which you will be asked to implement your own ideas for the given domain. A team of at-most three members can attend this contest. The problem statements and domains would be released before hand, and you’d have to implement your proposal during the 12 Hour Hackathon event at our campus. Each team would be judged on several parameters such as uniqueness of their idea, complexity, innovation, usefulness and relevance to the theme. The top performing teams will stand a chance to interview with some of the biggest tech giants for full-time and internship opportunities!`),
            ]),
            'mini-placement': m('div.anim-appear-fadein', [
                m('h1', {class: 'mdc-typography--headline3'}, 'Mini Placement'),
                m('p', {class: 'mdc-typography--body1'},
                    `Want to know what's it like to attend a job interview? If you are an enthusiastic student who is seeking an exciting challenge for your placement year, Mini Placement is an exceptional opportunity for you. Mini Placements simulates the interview rounds including preliminary pen-and-paper test, group discussions, and HR interviews. The initial round of aptitude test may contain logical reasoning, aptitude/ math, and verbal questions, etc. The second round known as Group Discussion (GD) comprises a group of students expressing opinions on a problem statement given to them. The final HR interview would ultimately test the soft skills of the applicant, general and domain knowledge.`),
                m('p', {class:'mdc-typography--body1'},
                    `You will gain valuable experience on how to practice, prepare and present yourself during actual interviews. We will provide you tips, tricks and advices on what to expect in the placement rounds, what the interviewer would expect from you in return and how to answer them during the interview. Come, participate and get ready for your final year placements!`),
            ]),
            'web-hub': m('div.anim-appear-fadein', [
                m('h1', {class: 'mdc-typography--headline3'}, 'Web Hub'),
                m('p', {class: 'mdc-typography--body1'},
                    `Prove your talent as a web developer in Web Hub! Web Hub covers the fundamentals of front-end web development. Test your skills on HTML, CSS, DOM, JavaScript and also on languages for web frameworks like Java and Python.`),
                m('p', {class:'mdc-typography--body1'},
                    `There will be two rounds for the event. In the first round, participants will be quizzed on the basics of various web technologies. The participants will have to showcase their creativity and talents by developing a web page based on a given theme in the second round.`),
            ]),
            'paper-presentation': m('div.anim-appear-fadein', [
                m('h1', {class: 'mdc-typography--headline3'}, 'Paper Presentation'),
                m('p', {class: 'mdc-typography--body1'},
                    `Share your ideas to the world by presenting your topic in front of an inquisitive audience. One may choose any topic and/or domain from Computer science and its related disciplines, and we provide the platform for you to take it to the next level in front of a panel of esteemed judges. `),
                m('p', {class:'mdc-typography--body1'},
                    `All participants need to mail their abstracts/papers in IEEE standard format to act@mitindia.edu with title as “Paper Presentation: Prayatna 2019” as the headline before 3rd March 2019. Shortlisted papers will be intimated beforehand, and they will have a presentation time of 5 minutes in front of the jury during the event.`),
            ]),
            'code-n-chaos': m('div.anim-appear-fadein', [
                m('h1', {class: 'mdc-typography--headline3'}, "Code 'N Chaos"),
                m('p', {class: 'mdc-typography--body1'},
                    `A wise man once said – “A good programmer is one who can code with the highest level of concentration; a great programmer is one who can code in-spite of losing it.” Are you ready to face loud music, insane outdoor disturbances and frequent interruptions, all the while coding your way through algorithmic problems?`),
                m('p', {class:'mdc-typography--body1'},
                    `The first round will be a normal pen-and-paper test, with questions on Algorithms, Data Structures and debugging. The second round will be an outdoor-event, where participants will be coding on the streets facing loud music and many other disturbances. Do you have what it takes? `),
            ]),
            'db-dwellers': m('div.anim-appear-fadein', [
                m('h1', {class: 'mdc-typography--headline3'}, 'DB Dwellers'),
                m('p', {class: 'mdc-typography--body1'},
                    `The world’s most valuable asset is no longer oil – it is data”, The Economist, May 2017. With terabytes of data being ingested every year, the need to organize data in a usable format is one of the most important tasks for Software Engineers around the world. Writing efficient DBMS queries to handle this data is even more important, and that’s exactly what you’ll be evaluated upon.`),
                m('p', {class:'mdc-typography--body1'},
                    `The first round will be a pen-and-paper round quizzing participants on simple DBMS concepts. The second round would have the participants practically apply various Database concepts and optimizations in a timed environment to claim the title. `),
            ]),
            'kaleidoscope': m('div.anim-appear-fadein', [
                m('h1', {class: 'mdc-typography--headline3'}, 'Kaleidoscope'),
                m('p', {class: 'mdc-typography--body1'},
                    `Prayatna sports a wide array of events solely concentrating on the funky and cheerful side of all the geeks coming to our symposium. Some of the popular ones are Connexions, IPL auction, Treasure Hunt and Gaming; but the most coveted of them all is undoubtedly "Kaleidoscope".`),
                m('p', {class: 'mdc-typography--body1'},
                    `Kaleidoscope tries and tests the participants' personality to the extreme. There are several rounds in this event with increasing difficulty. The specialty of these rounds is they are totally ad hoc, that is, the questions asked and the characteristics being tested depend on the kind of participants. This adds to the suspense and unpredictability of the event. The final round will culminate in a stress interview where the contestants will be pushed to insanity. The people who come out victorious out of these many stressful conditions will be crowned the fiercest champion among all.`),
            ]),
            'connexions': m('div.anim-appear-fadein', [
                m('h1', {class: 'mdc-typography--headline3'}, 'Connexions'),
                m('p', {class: 'mdc-typography--body1'},
                    `Tired trying the Technical track? Jump out of the techie circle for minutes and let your geeky neurons zeal out to the world of fun. Prayatna2k19 presents Connexions for the enthusiast in you. Puzzle up the pictures and collor up as best connectors.`),
            ]),
            'bplan': m('div.anim-appear-fadein', [
                m('h1', {class: 'mdc-typography--headline3'}, 'BPlan'),
                m('p', {class: 'mdc-typography--body1'},
                    `"A goal without a plan is just a wish". Do you have a clear-cut goal and a well thought-out plan to achieve the goal? Don't wait for opportunities to knock; instead build your own door. The B-Plan event of Prayatna gives you a stage to present a Business plan or Startup plan of commercial and technical well sound ideas where you can express the entrepreneur and leader in you.`),
            ]),
            'ipl-auction': m('div.anim-appear-fadein', [
                m('h1', {class: 'mdc-typography--headline3'}, 'IPL Auction'),
                m('p', {class: 'mdc-typography--body1'},
                    `More players, more money, fewer slots available – there is set to be some monster bidding battles when the world's best T20 cricketers go under the hammer. IPL Auction - Every cricket fan's dream is all set at Prayatna 19. Get set to witness India's biggest bidding war. Build a strong, aggressive and solid fantasy team to grab the victory.`),
            ]),
            'treasure-hunt': m('div.anim-appear-fadein', [
                m('h1', {class: 'mdc-typography--headline3'}, 'Treasure Hunt'),
                m('p', {class: 'mdc-typography--body1'},
                    `Have you ever wondered how much attention you pay to details? Are you an expert in cracking hidden clues? Test it out by participating in our Treasure Hunt, an exciting and enthralling event where you would have to explore our campus thoroughly (every nook and corner) and look for hidden clues, solving them one by one till you reach the final clue. Good luck on hitting the jackpot!`),
            ]),
            'gaming': m('div.anim-appear-fadein', [
                m('h1', {class: 'mdc-typography--headline3'}, 'Gaming'),
                m('p', {class: 'mdc-typography--body1'},
                    `Escape reality and own the virtual world where you can have a second chance to life. Do you have what it takes to weave around the defenders and score a screamer of goal in FIFA? Deserted, alone, and a winner-takes-it-all battle royale – can you get the better of 99 other participants in PUBG? Can you help the terrorists triumph in Call of Duty? Calling all the gaming maniacs to participate in our Gaming event!`),
            ]),
            'math-o-mania': m('div.anim-appear-fadein', [
                m('h1', {class: 'mdc-typography--headline3'}, 'Math O Mania'),
                m('p', {class: 'mdc-typography--body1'},
                    `People say mathematics is the poetry of logic ideas. Are you a math freak? If you love working your brain and solving problems, Math O Mania is the perfect event for you. Put your analytical, logical reasoning and mathematical skills to use in this event and walk away with exciting prizes!`),
            ]),
            'olpc': m('div.anim-appear-fadein', [
                m('h1', {class: 'mdc-typography--headline3'}, 'Online Programming Contest'),
                m('p', {class: 'mdc-typography--body1'},
                    `Programming is logic-based creativity. It is a skill best acquired by practice. OLPC is an online programming contest which tests the contestants programming skills and how fast they can come up with creative, easy and efficient solutions for problems. OLPC will be conducted on an online IDE such as Hackerrank or Codechef where you can build your code, debug and test them to solve the given problems efficiently.`),
            ]),
            'connexions-online': m('div.anim-appear-fadein', [
                m('h1', {class: 'mdc-typography--headline3'}, 'Connexions Online'),
                m('p', {class: 'mdc-typography--body1'},
                    `Alert for the connectors in you! It's time for your fingers to be busy. Stay connected from every corner and let's be online on-time. Crack our clues and top the leaderboard.`),
                m('p', {class: 'mdc-typography--body1'}, `Stay alert! Every detail counts!`),
                m('h1', {class: 'mdc-typography--headline6'}, 'Date: February 15th, 2019'),
                m('h1', {class: 'mdc-typography--headline4'}, 'Note'),
                m('ul', {class: 'mdc-typography--body1'},
                    m('li', 'Participation is free for all'),
                    m('li', 'Further details will be updated later'),
                    m('li', 'For any queries, contact Preethi: 9884398352')
                ),
            ]),
            'freeze-it': m('div.anim-appear-fadein', [
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
            ]),
            'daily-quiz': m('div.anim-appear-fadein', [
                m('h1', {class: 'mdc-typography--headline3'}, 'Daily Quiz'),
                m('p', {class: 'mdc-typography--body1'},
                    `Want to test your knowledge on various subjects? Want to experience the feeling of getting the question right everyday? You are at the right place. Participate in our Daily Quiz event where you answer quizzes daily and earn chances to feature in our LeaderBoard every week. Get ready to spark your grey cells and walk away with exciting prizes!`),
            ]),
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
