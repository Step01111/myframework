let topmenuButton = document.getElementById('topmenu_button');
let siteMenu = document.getElementById('site_menu');
let siteMenuClose = siteMenu.querySelector('.close');

topmenuButton.onclick = function()
{
    siteMenu.style.display = 'block';
};

siteMenuClose.onclick = function()
{
    siteMenu.style.display = 'none';
}