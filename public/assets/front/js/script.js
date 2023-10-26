let burgerMenu = document.querySelector('.menuBurger');
let overlay = document.getElementById('menu');
let btn = document.getElementById('nav-icon3');
/*let wrapper = document.querySelectorAll('.wrapper');
let dropdowns = document.querySelectorAll('.dropdown');*/


let acc = document.getElementsByClassName("accordion");
let i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    }
    else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    }
  });
}


btn.addEventListener('click', function() {
  overlay.classList.toggle("overlay");
  btn.classList.toggle("open");
});


/*dropdowns.forEach(dropdown => {
  dropdown.addEventListener('click', () => {

    if (dropdown.classList.contains("active")) {
      dropdown.classList.toggle("active");
    }
    else {
      dropdowns.forEach(element => {
        if (element.classList.contains("active")) {
          element.classList.remove("active");
        }
      })
      dropdown.classList.toggle("active");
    }
  })
})*/

var scrollPos = 0;
window.addEventListener("scroll", function() {
  if (document.body.getBoundingClientRect().top > scrollPos) {
    document.getElementById("header").classList.add("downHeader");
  }
  else {
    document.getElementById("header").classList.remove("downHeader");
  }
  scrollPos = document.body.getBoundingClientRect().top;
});
