<!--PHP for user-->
<?php
    require 'https_redirect.php';
    require 'constants.php';
    if (isset($_COOKIE["user_id"])) {
        header('Location: '.$domain);
        exit;
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
    .root {
        --mdc-theme-primary: #aaaaaa;
    }
    .section-dark .mdc-button--raised:not(:disabled), .section-dark .mdc-button--unelevated:not(:disabled) {
        background-color: #050505;
    }
    .logo {
        display: block;
        max-width: 50%;
        margin: auto;
    }
    .center30 {
        display: block;
        margin: auto;
        width: 30%;
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
      .center30 {
        display: block;
        margin: auto;
        width: 85%;
      }
    }
  </style>
</head>
<body class="mdc-typography section-dark">
  <main class="margin">
    <section class="root center30">
    </section>
  </main>
  <script type="text/javascript">
    var textfields = [];
    var ripples = [];
    var json_data = {};
    var TextField = {
        view: function(vnode) {
            var textFieldValues = {class: "mdc-text-field__input input input-text-color", type: (vnode.attrs.type?vnode.attrs.type:"text"), name: vnode.attrs.name, placeholder: vnode.attrs.placeholder}
            if(vnode.attrs.disabled)
                textFieldValues['disabled'] = true
            if(vnode.attrs.required)
                textFieldValues['required'] = true
            if(vnode.attrs.pattern)
                textFieldValues['pattern'] = vnode.attrs.pattern
            if(vnode.attrs.minlength)
                textFieldValues['minlength'] = vnode.attrs.pattern
            if(vnode.attrs.maxlength)
                textFieldValues['maxlength'] = vnode.attrs.maxlength

            return m('div', {class: "mdc-text-field" + (vnode.attrs.fullwidth?" mdc-text-field--fullwidth":"") + (vnode.attrs.disabled?" mdc-text-field--disabled":"")}, [
                m('input', textFieldValues),
                m('div', {class: 'mdc-line-ripple'})
            ]);
        },
        oncreate: function(vnode) {
            textfields.push(new mdc.textField.MDCTextField(vnode.dom));
        }
    }
    var Button = {
        view: function(vnode) {
            var buttonValues = {class: (vnode.attrs.class?vnode.attrs.class:'mdc-button mdc-button--raised mdc-ripple-upgraded'), style: vnode.attrs.style?vnode.attrs.style:"", type: vnode.attrs.type?vnode.attrs.type:"", onclick: vnode.attrs.onclick}
            if(vnode.attrs.disabled) {
                buttonValues['disabled'] = true;
            }
            if(vnode.attrs.name) {
                buttonValues['name'] = vnode.attrs.name;
            }
            return m('button', buttonValues,
                m('span', {class: 'mdc-button__label'}, vnode.attrs.label)
            );
        },
        oncreate: function(vnode) {
            ripples.push(new mdc.ripple.MDCRipple(vnode.dom));
        }
    }
    var LoginPanel = function (initialVnode) {
        var formToShow;
        var loginForm = {
            view: function() {
                return m('form', {id: 'loginform', class: "form-container margin anim-appear-panel-slideright-fadein", action:"ajax_responses/login.php", method: "post"},
                    [
                        m("h1", {class: "mdc-typography--headline6", style:"text-align: center;"}, "Welcome"),
                        m(TextField, {name: 'email', placeholder: 'Email ID', fullwidth: true, type: "email", required: true, maxlength: '254'}),
                        m(TextField, {name: 'password', type: 'password', placeholder: 'Password', fullwidth: true, required: true, maxlength: '60'}),
                        m('div', {class: " margin",style: "float: right;"},
                            m(Button, { class: "mdc-button mdc-button--outlined mdc-ripple-upgraded", style:"color:#ffffff;",label: 'Sign Up', type:"button", onclick: function() {
                                    formToShow = signupForm;
                                }
                            }),
                            m(Button, {label: 'Sign In', style:" margin-left: 15px;", name: 'submit'})
                        ),
                        <?php
                            if(isset($_GET['location'])) {
                        ?>
                        m('input', {type: 'hidden', name: 'location', value: '<?=htmlspecialchars($_GET['location'])?>'})
                        <?php
                            }
                        ?>
                    ]
                );
            }
        }
        var signupForm = {
            view: function(){
                return m('form', {id: 'signupform', class: "form-container margin anim-appear-panel-slideleft-fadein", action:"ajax_responses/signup.php", method: "post", onsubmit: function(event) {
                            event.preventDefault();

                            var json_val = {
                                "email": event.srcElement.email.value,
                                "name": event.srcElement.name.value,
                                "contact": event.srcElement.phone.value};
                            param = JSON.stringify(json_val);
                            // ajax request for unique mail, phone number, name
                            var url = 'ajax_responses/check_user.php';
                            var xhttp = new XMLHttpRequest();

                            xhttp.onreadystatechange = function () {
                                if (this.readyState == 4 && this.status == 200) {
                                    json_data =  JSON.parse(this.responseText);
                                    if(json_data["email"] == "False") {
                                        showSnackbar('Email ID already exists!');
                                    } else if(json_data["contact"] == "False") {
                                        showSnackbar('Phone number already exists!');
                                    } else {
                                        document.getElementById("signupform").submit();
                                    }
                                }
                            };
                            xhttp.open("POST", url, true);
                            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                            xhttp.send("x=" + param);
                        }
                    },
                    [
                        m("h1", {class: "mdc-typography--headline6", style:"text-align: center;"}, "Create your Prayatna Account"),
                        m(TextField, {name: 'name', placeholder: 'Name', fullwidth: true, required: true, maxlength: '64'}),
                        m(TextField, {name: 'email', placeholder: 'Email ID', fullwidth: true, type: "email", required: true, maxlength: '254'}),
                        m(TextField, {name: 'password', placeholder: 'Password', fullwidth: true, minlength: 8, type:  "password", required: true, maxlength: '60'}),
                        m(TextField, {name: 'college', placeholder: 'Institution', fullwidth: true, required: true, maxlength: '300'}),
                        m(TextField, {name: 'department', placeholder: 'Department', fullwidth: true, maxlength: '300'}),
                        m(TextField, {name: 'year', placeholder: 'Year of Study (1 to 4)', fullwidth: true, pattern: "[1-4]"}),
                        m(TextField, {name: 'city', placeholder: 'City', fullwidth: true, required: true, maxlength: '64'}),
                        m(TextField, {name: 'phone', placeholder: 'Phone Number', fullwidth: true, pattern: "[6-9][0-9]{9}", required: true}),
                        m('div', {class: " margin", style: "float: right;"},
                            m(Button, {class: "mdc-button mdc-button--outlined mdc-ripple-upgraded", style:"color:#ffffff;",label: 'Cancel',type:"button", onclick: function() {
                                    formToShow = loginForm;
                                }
                            }),
                            m(Button, {label: 'Sign Up', style:" margin-left: 15px;"})
                        ),
                        <?php
                            if(isset($_GET['location'])) {
                        ?>
                        m('input', {type: 'hidden', name: 'location', value: '<?=htmlspecialchars($_GET['location'])?>'})
                        <?php
                            }
                        ?>
                    ]
                );
            }
        }
        formToShow = loginForm;
        return {
            view: function() {
                return [
                    m('a', {href: '/'},
                        m('img', {src: 'res/prayatna.png', class: "logo", style: "cursor: pointer;"})
                    ),
                    m(formToShow)
                ];
            }
        }
    }
    var root = document.querySelector('.root');
    m.mount(root, LoginPanel);

  </script>
  <?php include('snackbar.php') ?>
</body>
</html>
