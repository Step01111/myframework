let formLogin = document.getElementById('form_login');

SendLogin = function()
{
    let mail = formLogin.mail.value;
    let pas = formLogin.pas.value;

    if (!mail) {
        alert('Укажите Email');
        return;
        }
    if (!pas) {
        alert('Укажите пароль');
        return;
        }
    
    let request = {
        mail: mail,
        password: pas,
    };

    SendForm('/api/users/login', request)
    .then(function(responseOb) {
        if (responseOb.ok) {
            location = '/';
        } else {
            alert(responseOb.error);
        }
    });
}

formLogin.send.onclick = SendLogin;

formLogin.onkeydown = function (event) {
    if (event.keyCode == 13) {
        SendLogin();
    }
}