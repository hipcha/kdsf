
// Executes the function when DOM will be loaded fully
$(document).ready(function () {
	// hover property will help us set the events for mouse enter and mouse leave
	$('.nav li').hover(
	// When mouse enters the .navigation element
		function () {
			var idx = $("#first_hd",this).val();
			//Fade in the navigation submenu
			$("#scnd_mu_"+idx, this).fadeIn(100); // fadeIn will show the sub cat menu
			$('.2nd li').hover(
						function () {
							$('ul', this).fadeIn(100);
						},
						function () {
							$('ul', this).fadeOut(100);
						});
		},
		// When mouse leaves the .navigation element
		function () {
			//Fade out the navigation submenu
			$('ul', this).fadeOut(100); // fadeOut will hide the sub cat menu
		});
});