let sidebarMenu = document.querySelector('header');
let navButton = document.querySelector('.icon-menu');
let navItems = document.getElementsByClassName('nav-item');


navButton.addEventListener('click', closeMainMenu);


function closeMainMenu() {
    sidebarMenu.classList.toggle('close');

    for (let i=0; i< navItems.length; i++) {
        navItems[i].classList.toggle('closed-items');
    }
}




