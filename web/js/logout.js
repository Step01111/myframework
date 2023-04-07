let logout = document.getElementById('logout');

logout.onclick = function()
{
    SendForm('/api/users/logout', '')
    .then(function(responseOb) {
        if (responseOb.ok) {
            location = '/';
        }
    });
}