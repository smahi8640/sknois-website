// Home Main Banner Start
$('.home__slider').slick({
    dots: false,
    infinite: true,
    autoplay: true,
  	autoplaySpeed: 6000,
    arrows: false,
    fade: true,
    cssEase: 'linear'
});     
// Home Main Banner End

// Category Slider Start
$('.category__slider').slick({
	dots: false,
	arrows: true,
	infinite: false,
	speed: 300,
	variableWidth: false,
	slidesToShow: 3,
	slidesToScroll: 1,
	responsive: [
	  {
		breakpoint: 1024,
		settings: {
		  slidesToShow: 3,
		  slidesToScroll: 3,
		}
	  },
	  {
		breakpoint: 768,
		settings: {
		  slidesToShow: 2,
		  slidesToScroll: 2
		}
	  },
	  {
		breakpoint: 480,
		settings: {
		  slidesToShow: 1,
		  slidesToScroll: 1
		}
	  }
	]
});
// Category Slider End	 

// Product Slider Start
$('.product__slider').slick({
	dots: false,
	arrows: true,
	infinite: false,
	speed: 300,
	slidesToShow: 4,
	slidesToScroll: 1,
	responsive: [
	  {
		breakpoint: 1199,
		settings: {
		  slidesToShow: 3,
		  slidesToScroll: 3,
		}
	  },
	  {
		breakpoint: 991,
		settings: {
		  slidesToShow: 2,
		  slidesToScroll: 2
		}
	  },
	  {
		breakpoint: 500,
		settings: {
		  slidesToShow: 1,
		  slidesToScroll: 1
		}
	  }
	]
});
// Product Slider End	 

// Product Slider Start
$('.related__product__slider').slick({
	dots: false,
	arrows: true,
	infinite: false,
	speed: 300,
	slidesToShow: 4,
	slidesToScroll: 1,
	responsive: [
	  {
		breakpoint: 1199,
		settings: {
		  slidesToShow: 3,
		  slidesToScroll: 3,
		}
	  },
	  {
		breakpoint: 991,
		settings: {
		  slidesToShow: 2,
		  slidesToScroll: 2
		}
	  },
	  {
		breakpoint: 480,
		settings: {
		  slidesToShow: 1,
		  slidesToScroll: 1
		}
	  }
	]
});
// Product Slider End	

// Single Product Slider Start
$('.slider-for').slick({
	slidesToShow: 1,
	slidesToScroll: 1,
	arrows: false,
	fade: true,
	asNavFor: '.slider-nav'
});
$('.slider-nav').slick({
	slidesToShow: 4,
	slidesToScroll: 1,
	asNavFor: '.slider-for',
	dots: false,
	arrows: true,
	centerMode: false,
	focusOnSelect: true,
	responsive: [
	  {
		breakpoint: 480,
		settings: {
		  slidesToShow: 2,
		  slidesToScroll: 1
		}
	  }
	]
});
// Single Product Slider End

// Mobile Menu Start
$(".mobile_menu").click(function(){
	$(".main__menu, .mobile_menu").toggleClass("open");
});
// Mobile Menu End

// Mobile Menu Start
$(".search__bar").click(function(){
	$(".search__main").toggleClass("open");
});
// Mobile Menu End

// SVG file to SVG code convert JS Start
function img2svg() {
	jQuery('.in__svg').each(function (i, e) {
	
		var $img = jQuery(e);
		
		var imgID = $img.attr('id');
		
		var imgClass = $img.attr('class');
		
		var imgURL = $img.attr('src');
		
		jQuery.get(imgURL, function (data) {
			// Get the SVG tag, ignore the rest
			var $svg = jQuery(data).find('svg');
			
			// Add replaced image's ID to the new SVG
			if (typeof imgID !== 'undefined') {
			$svg = $svg.attr('id', imgID);
			}
			// Add replaced image's classes to the new SVG
			if (typeof imgClass !== 'undefined') {
			$svg = $svg.attr('class', ' ' + imgClass + ' replaced-svg');
			}
			
			// Remove any invalid XML tags as per http://validator.w3.org
			$svg = $svg.removeAttr('xmlns:a');
		
			// Check if the viewport is set, if the viewport is not set the SVG wont't scale.
			// if (!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
			// $svg.attr(`viewBox 0 0 ${$svg.attr('height')} ${$svg.attr('width')}`);
			// }
		
			// Replace image with new SVG
			$img.replaceWith($svg);
			}, 'xml');
		});
	}
	img2svg();

// SVG file to SVG code convert JS End

// Bottom to Top Arrow JS Start
var back_top_top = $('.bottom__top__top');

$(window).scroll(function() {
  if ($(window).scrollTop() > 300) {
    back_top_top.addClass('show');
  } else {
    back_top_top.removeClass('show');
  }
});

back_top_top.on('click', function(e) {
  e.preventDefault();
  $('html, body').animate({scrollTop:0}, '300');
});
// Bottom to Top Arrow JS End

var product__price = $('.single__product__price');

$(window).scroll(function() {
  if ($(window).scrollTop() > 1000) {
    product__price.addClass('fixed');
  } else {
    product__price.removeClass('fixed');
  }
});


$('.ref__to_details').click(function(){
    $('html, body').animate({
        scrollTop: $( $(this).attr('href') ).offset().top - 150
    }, 500);
    return false;
});
