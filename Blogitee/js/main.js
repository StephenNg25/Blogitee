// =================== SMALL DEVICE DROP DOWN NAVIGATION BAR =======================

const navItems = document.querySelector('.nav_items');
const openNavBtn = document.querySelector('#open_nav_opts');
const closeNavBtn = document.querySelector('#close_nav_opts');

// Opens nav dropdown ( ON SMALL DEVICES )
const openNav = () => {  // when openNav is called
    navItems.style.display = 'flex';
    openNavBtn.style.display = 'none';
    closeNavBtn.style.display = 'inline-block';
};

// Closes nav dropdown ( ON SMALL DEVICES )
const closeNav = () => { // when closeNav is called
    navItems.style.display = 'none';
    openNavBtn.style.display = 'inline-block';
    closeNavBtn.style.display = 'none';
};

openNavBtn.addEventListener('click', openNav);
closeNavBtn.addEventListener('click', closeNav);

// ===================== END OF SMALL DEVICE DROP DOWN NAVIGATION BAR ==============

// ============== TOGGLE SIDEBUTTONS OF DASHBOARD =======================
const sidebar = document.querySelector('aside');
const showSidebarBtn = document.getElementById('show_sidebar-btn');
const hideSidebarBtn = document.getElementById('hide_sidebar-btn');

//  Show sidebar on small devices while left pointed toggle is clicked
const showSidebar = () => {
console.log("Show Sidebar triggered");
sidebar.style.setProperty('left', '0', 'important'); // Apply !important
showSidebarBtn.style.setProperty('display', 'none', 'important'); // Apply !important
hideSidebarBtn.style.setProperty('display', 'inline-block', 'important'); // Apply !important
};
//  Hide sidebar on small devices while right pointed toggle is clicked
const hideSidebar = () => {
console.log("Hide Sidebar triggered");
sidebar.style.setProperty('left', '-100%', 'important'); // Apply !important
showSidebarBtn.style.setProperty('display', 'inline-block', 'important'); // Apply !important
hideSidebarBtn.style.setProperty('display', 'none', 'important'); // Apply !important
};
showSidebarBtn.addEventListener('click', showSidebar);
hideSidebarBtn.addEventListener('click', hideSidebar);
 




