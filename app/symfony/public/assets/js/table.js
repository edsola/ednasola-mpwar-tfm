let ticketsTable = $('.responsive-table');
let ticketStatus = document.getElementsByClassName('ticket-status');
let ticketPriority = document.getElementsByClassName('ticket-priority');
let filterButtons = document.getElementsByClassName('btn-filter');


tableStatusAndPriorityStyle();
displayResponsiveTableTitles();

let table = new DataTable('.tickets-table', {});


window.onload = () => {
    displayActiveStyleFilterButton();
    saveFilterButtonStorage();
    responsiveTable();
};


window.onresize = () => {
    responsiveTable();
};



function tableStatusAndPriorityStyle() {
    for (let i=0; i < ticketStatus.length; i++) {
        let status = ticketStatus[i].textContent;

        if (status === 'OPEN') {
            ticketStatus[i].style.setProperty('background', '#6c95d4');
        }
        if (status === 'COMPLETED') {
            ticketStatus[i].style.setProperty('background', '#9cc995');
        }
        if (status === 'CLOSED') {
            ticketStatus[i].style.setProperty('background', '#b4b8bf');
        }
    }

    for (let i=0; i < ticketPriority.length; i++) {
        let priority = ticketPriority[i].childNodes[1].textContent.trim();

        if (priority === 'Low') {
            ticketPriority[i].children[0].style.setProperty('color', '#80c900');
        }
        if (priority === 'Medium') {
            ticketPriority[i].children[0].style.setProperty('color', '#ffae00');
        }
        if (priority === 'High') {
            ticketPriority[i].children[0].style.setProperty('color', '#ff0000');
        }
    }
}


function saveFilterButtonStorage() {
    for (let i = 0; i < filterButtons.length; i++) {
        let button = filterButtons[i].textContent;

        filterButtons[i].addEventListener('click', () => {
            localStorage.setItem('filterButton', button);
        });
    }
}


function displayActiveStyleFilterButton() {
    let currentButton = localStorage.getItem('filterButton');
    for (let i = 0; i < filterButtons.length; i++) {
        if (filterButtons[i].innerHTML === currentButton) {
            filterButtons[i].classList.add('filter-active');
        }
    }
}


function responsiveTable() {
    if (window.innerWidth < 900) {
        for (let i=0; i < ticketsTable.length; i++) {
            ticketsTable.find(".responsive-table-titles").show();
            ticketsTable.find('thead').hide();
        }
    }

    if (window.innerWidth >= 900) {
        for (let i=0; i < ticketsTable.length; i++) {
            ticketsTable.find(".responsive-table-titles").hide();
            ticketsTable.find('thead').show();
        }
    }
}


function displayResponsiveTableTitles() {
    ticketsTable.find("th").each(function (i) {
        $('.responsive-table td:nth-child(' + (i + 1) + ')').prepend('<span class="responsive-table-titles">'+ $(this).text() + ':</span> ');
        $('.responsive-table-titles').hide();
    });
}

