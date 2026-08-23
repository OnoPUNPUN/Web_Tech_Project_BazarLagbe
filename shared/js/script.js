let navbar = document.querySelector('.header .flex .navbar');

if (document.querySelector('#menu-btn')) {
   document.querySelector('#menu-btn').onclick = () => {
      if (navbar) navbar.classList.toggle('active');
      if (profile) profile.classList.remove('active');
   }
}

let profile = document.querySelector('.header .flex .profile');

if (document.querySelector('#user-btn')) {
   document.querySelector('#user-btn').onclick = () => {
      if (profile) profile.classList.toggle('active');
      if (navbar) navbar.classList.remove('active');
   }
}

window.onscroll = () => {
   if (profile) profile.classList.remove('active');
   if (navbar) navbar.classList.remove('active');
}
