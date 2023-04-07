let formReg = document.getElementById('form_reg');
let isReg = document.getElementById('isreg');

SendReg = function()
{
    let mail = formReg.mail.value;
    let name = formReg.username.value;
    let pas = formReg.pas.value;
    let rpas = formReg.rpas.value;

    if (!mail) {
        alert('Укажите Email');
        return;
        }
    if (!name) {
        alert('Укажите имя');
        return;
        }
    if (!pas) {
        alert('Укажите пароль');
        return;
        }
    if (pas != rpas) {
        alert('Пароль не совпадает с подтверждением');
        return;
        }
    
    let request = {
        mail: mail,
        name: name,
        password: pas,
    };

    SendForm('/api/users/registration', request)
    .then(function(responseOb) {
        if (responseOb.ok) {
            formReg.style.display = 'none';
            isReg.style.display = 'block';
        } else {
            alert(responseOb.error);
        }
    });
}

formReg.send.onclick = SendReg;

formReg.onkeydown = function (event) {
    if (event.keyCode == 13) {
        SendReg();
    }
}