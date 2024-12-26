const bars = document.querySelector('.bars-btn');
const sidebar = document.querySelector('nav ul');

let sidebarOpen = false;

bars.addEventListener('click', () => {
  if (!sidebarOpen) { 
    sidebar.style.left = "0%";
    bars.style.transform = "rotate(90deg)";
    sidebarOpen = true;

  } else {
    sidebar.style.left = "-100%";
    bars.style.transform = "rotate(0deg)";
    sidebarOpen = false;
  }
});