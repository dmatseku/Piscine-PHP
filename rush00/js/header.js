{
    let login_elements = document.getElementsByClassName("auth_login");
    for (let login of login_elements) {
        login.addEventListener("input", function (event) {
            let warning = event.currentTarget.parentElement.parentElement.children[1];
            warning.textContent = "";

            if (event.currentTarget.value.length > 0) {
                if (event.currentTarget.value.slice(0, 1).match(/[A-Za-z]/) == null) {
                    warning.textContent = "Login must begin with a letter";
                } else if (event.currentTarget.value.match(/^[A-Za-z]\w*$/g) == null) {
                    warning.textContent = "login characters: <br>[A-Z, a-z][A-Z, a-z, 0-9, _]";
                } else if (event.currentTarget.value.length > 25) {
                    warning.textContent = "Login is too long";
                }
            }
        });
    }

    document.getElementById("auth_confirm").addEventListener("input", function (event) {
        let passwd = document.getElementById("auth_reg_password");
        let warning = event.currentTarget.parentElement.parentElement.children[1];

        warning.textContent = "";
        if (event.currentTarget.value.length > 0 && passwd.value.length > 0 && passwd.value !== event.currentTarget.value) {
            warning.textContent = "Passwords are different";
        }
    });

    document.getElementById("auth_reg_password").addEventListener("input", function (event) {
        let confirm = document.getElementById("auth_confirm");
        let warning = event.currentTarget.parentElement.parentElement.children[1];

        warning.textContent = "";
        if (event.currentTarget.value.length > 0 && confirm.value.length > 0 && confirm.value !== event.currentTarget.value) {
            warning.textContent = "Passwords are different";
        }
    });

    document.getElementById("register").addEventListener("submit", function (event) {
        let orig = document.getElementById("auth_reg_password").value;
        let conf = document.getElementById("auth_confirm").value;
        return !(orig.length > 0 && conf.length > 0 && orig !== conf);
    });

    if (document.getElementById("non_profile") !== null) {
        let buttons = document.getElementById("non_profile").children[0].children;
        buttons[0].addEventListener("click", function (event) {
            show_window(document.getElementById("login").parentElement);
        });
        buttons[1].addEventListener("click", function (event) {
            show_window(document.getElementById("register").parentElement);
        });
    } else {
        document.getElementById("profile").children[1].children[0].addEventListener("click", function (event) {
            show_window(document.getElementById("change_passwd").parentElement);
        });
    }
    let close_buttons = document.getElementsByClassName("auth_button_close");
    for (let button of close_buttons) {
        button.addEventListener("click", function (event) {
            hide_window(event.currentTarget.parentElement.parentElement.parentElement);
        });
    }

    document.getElementById("search_field").addEventListener("change", function (event) {
        let text = event.currentTarget.value.trim();

        if (text.length > 45) {
            text = text.substr(0, 45);
        }
        event.currentTarget.value = text;
    });

}