<!--PHP for user-->
<?php
    if (isset($_COOKIE["user_id"])) {
        header('Location: http://localhost/prayatna-2019/home.php');
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
    .mdc-text-field:not(.mdc-text-field--disabled) .mdc-text-field__input::placeholder {
        color: #555555;
    }
    .mdc-text-field:not(.mdc-text-field--disabled) .mdc-text-field__input:focus::placeholder {
        color: #aaaaaa;
    }
    .mdc-text-field:not(.mdc-text-field--disabled):not(.mdc-text-field--outlined):not(.mdc-text-field--textarea) .mdc-text-field__input {
        border-bottom-color: #555555;
    }
    .mdc-text-field:not(.mdc-text-field--disabled):not(.mdc-text-field--outlined):not(.mdc-text-field--textarea) .mdc-text-field__input:hover {
        border-bottom-color: #aaaaaa;
    }
    .mdc-text-field .mdc-line-ripple {
        background-color: #ffffff;
    }
    @media(max-width: 1024px) {
      .center30 {
        display: block;
        margin: auto;
        width: 70%;
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
            var textFieldValues = {class: "mdc-text-field__input", type: (vnode.attrs.type?vnode.attrs.type:"text"), name: vnode.attrs.name, placeholder: vnode.attrs.placeholder}
            if(vnode.attrs.disabled)
                textFieldValues['disabled'] = true
            if(vnode.attrs.required)
                textFieldValues['required'] = true
            if(vnode.attrs.pattern)
                textFieldValues['pattern'] = vnode.attrs.pattern
            if(vnode.attrs.minlength)
                textFieldValues['minlength'] = vnode.attrs.pattern
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
                return m('form', {id: 'loginform', class: "form-container margin", action:"/prayatna-2019/ajax_responses/login.php", method: "post"},
                    [
                        m("h1", {class: "mdc-typography--headline6", style:"text-align: center;"}, "Welcome"),
                        m(TextField, {name: 'email', placeholder: 'Email ID', fullwidth: true, type: "email", required: true}),
                        m(TextField, {name: 'password', type: 'password', placeholder: 'Password', fullwidth: true, required: true}),
                        m('div', {class: " margin",style: "float: right;"},
                            m(Button, { class: "mdc-button mdc-button--outlined mdc-ripple-upgraded", style:"color:#ffffff;",label: 'Sign Up', type:"button", onclick: function() {
                                    formToShow = signupForm;
                                }
                            }
                            ),
                            m(Button, {label: 'Sign In', style:" margin-left: 15px;"})
                        )
                    ]
                );
            }
        }
        var signupForm = {
            view: function(){
                return m('form', {id: 'signupform', class: "form-container margin", action:"/prayatna-2019/ajax_responses/signup.php", method: "post", onsubmit: function(event) {
                            event.preventDefault();

                            var json_val = {
                                "email": event.srcElement.email.value,
                                "name": event.srcElement.name.value,
                                "contact": event.srcElement.phone.value};
                            param = JSON.stringify(json_val);
                            console.log(param);
                            // ajax request for unique mail, phone number, name
                            var url = '/prayatna-2019/ajax_responses/check_user.php';
                            var xhttp = new XMLHttpRequest();

                            xhttp.onreadystatechange = function () {
                                if (this.readyState == 4 && this.status == 200) {
                                    json_data =  JSON.parse(this.responseText);
                                    if(json_data["email"] == "False") {
                                        alert('email already existed');
                                    } else if(json_data["user"] == "False"){
                                        alert('username already existed');
                                    } else if(json_data["contact"] == "False") {
                                        alert ('phone number already existed');
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
                        m(TextField, {name: 'name', placeholder: 'Name', fullwidth: true, required: true}),
                        m(TextField, {name: 'email', placeholder: 'Email ID', fullwidth: true, type: "email", required: true}),
                        m(TextField, {name: 'password', placeholder: 'Password', fullwidth: true, minlength: 8, type:  "password", required: true}),
                        m(TextField, {name: 'year', placeholder: 'Year of Study (1 to 4)', fullwidth: true, pattern: "[1-4]", required: true}),
                        m(TextField, {name: 'college', placeholder: 'College', fullwidth: true,required: true}),
                        m(TextField, {name: 'phone', placeholder: 'Phone Number', fullwidth: true, pattern: "[6-9][0-9]{9}", required: true}),
                        m('div', {class: " margin", style: "float: right;"},
                            m(Button, {class: "mdc-button mdc-button--outlined mdc-ripple-upgraded", style:"color:#ffffff;",label: 'Cancel',type:"button", onclick: function() {
                                    formToShow = loginForm;
                                }
                            }
                            ),
                            m(Button, {label: 'Sign Up', style:" margin-left: 15px;"})
                        )
                    ]
                );
            }
        }
        formToShow = loginForm;
        return {
            view: function() {
                return [
                    m('img', {src: 'res/prayatna.png', class: "logo"}),
                    m(formToShow)
                ];
            }
        }
    }
    var root = document.querySelector('.root');
    m.mount(root, LoginPanel);

  </script>

</body>
</html>
