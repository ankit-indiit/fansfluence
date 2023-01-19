window.onscroll = function() {myFunction()};


function myFunction() {
  if (window.pageYOffset > sticky) {
	header.classList.add("sticky");
  } else {
	header.classList.remove("sticky");
  }
}


feather.replace();


$(document).ready(function(){
  $('.submenu-dropdown-tgl').on("click", function(e){
    $(this).next('ul').toggle();
    e.stopPropagation();
    e.preventDefault();
  });
});


$('.profile-item-carousel').owlCarousel({
  loop: false,
  margin: 20,
  nav: true,
  navText: [
    "<i class='fa fa-chevron-left'></i>",
    "<i class='fa fa-chevron-right'></i>"
  ],
  autoplay: true,
  autoplayHoverPause: true,
  responsive: {
    0: {
      items: 2
    },
    600: {
      items: 2
    },
    768: {
      items: 3
    },
    1000: {
      items: 4
    },
    1180: {
      items: 5
    }
  }
});


$('.influencers-img-carousel').owlCarousel({
  loop: true,
  margin: 20,
  nav: true,
  navText: [
  "<i class='fa fa-chevron-left'></i>",
  "<i class='fa fa-chevron-right'></i>"
  ],
  autoplay: true,
  autoplayHoverPause: true,
  responsive: {
  0: {
    items: 1
  },
  600: {
    items: 1
  },
  1000: {
    items: 1
  }
  }
  });