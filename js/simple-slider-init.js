	jQuery(document).ready(function(){
	
	// Initialize the Slick Slider
	jQuery(".srps_slider").slick({
		slidesToShow: 3,
		prevArrow: '<button class="prev srps_button"><i class="fa fa-chevron-left"></i></button>',
		nextArrow: '<button class="next srps_button"><i class="fa fa-chevron-right"></i></button>',
		responsive: [
	    {
	      breakpoint: 720,
		      settings: {
		        slidesToShow: 2,
		      }
	    },
	    {
	      breakpoint: 520,
		      settings: {
		        slidesToShow: 1,
		      }
	    }],
	});
	function srps_thumbnail_height(){
		var height = jQuery('.srps_article').width() * 6/10;
		var top = jQuery('.srps_thumb').height();
		jQuery('.srps .srps_button').css('top', (top * 0.5) -10);
		jQuery('.srps .srps_thumb').height(height);
	}
	jQuery(window).load(function(){
		srps_thumbnail_height();
	});
	jQuery(window).resize(function(){
		srps_thumbnail_height();
	});
});