// toggle sidebar-offcanvas
$(document).ready(function() {
  $('[data-toggle=offcanvas]').click(function() {
    $('.row-offcanvas').toggleClass('active');
  });
});

// Nivo Slider
$(window).load(function() {
	$('#slider').nivoSlider();
});

