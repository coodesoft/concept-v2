window.onscroll = function() {setSticky()};

var navbar = document.getElementById("navbar");
var logo = document.getElementsByClassName("logo-nav");
var cart = document.getElementsByClassName("cart-nav");
var sticky = navbar.offsetTop;

function setSticky() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky");
    logo[0].classList.add("unhidden");
    cart[0].classList.add("unhidden");
  } else {
    navbar.classList.remove("sticky");
    logo[0].classList.remove("unhidden");
    cart[0].classList.remove("unhidden");
  }
}