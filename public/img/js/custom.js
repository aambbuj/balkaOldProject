//nav icon FONT AWESOME ON CLICK
$('.navbar-toggler').click(function(){
    $(this).find('i').toggleClass('fas fa-equals w-100 fas fa-times w-100')
});

//button text change

$('.chng-txt').click(function(){
    var $this = $(this);
    $this.toggleClass('.chng-txt');
    if($this.hasClass('.chng-txt')){
        $this.text('Close');         
    } else {
        $this.text('Menu');
    }
});
$("#bdcmb").click(function(){
	 $(".chng-txt").text($(".chng-txt").text() == 'Menu' ? 'Close' : 'Menu');
});
//button text change

//search pop up//
  $(function(){
$("#addClass").click(function () {
          $('#qnimate').addClass('popup-box-on');
            });
          
            $("#removeClass").click(function () {
          $('#qnimate').removeClass('popup-box-on');
            });
  });

//spotlight Slider
$('.spotlight-slider').owlCarousel({
    loop:true,
    margin:0,
    nav:false,
    responsive:{
        0:{
            items:3,
            mouseDrag:true,
    		touchDrag:true,
    		autoplay:true,
    		autoplayTimeout:5000,
    		autoplayHoverPause:true,
        },
        600:{
            items:5,
            mouseDrag:true,
    		touchDrag:true,
    		autoplay:true,
    		autoplayTimeout:5000,
    		autoplayHoverPause:true,
        },
        1000:{
            items:7,
            mouseDrag:false,
    		touchDrag:false,
    		autoplay:false,
        }
    }
})  

//blog slider//
var sliderOne = $('.blog-slider').owlCarousel({
    loop:true,
    margin:0,
    nav:false,
   	mouseDrag:false,
    touchDrag:false,
   	autoplay:false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
});

//product slider//
var sliderTwo = $('.product-slider').owlCarousel({
    loop:true,
    margin:0,
    nav:false,
    dots:false,
   	mouseDrag:false,
    touchDrag:false,
   	autoplay:false,
   	animateOut: 'animate__fadeOut',
    animateIn: 'animate__fadeIn',
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
});
//Sync  sliderOne by sliderTwo
 sliderOne.on('click', '.owl-dots', function () {
     sliderTwo.trigger('next.owl.carousel')
 });
//timer
var time = 20;
setInterval(function () {
	// alert("Hello");  
  time--;
  if (time <= 0){
  	sliderOne.trigger('next.owl.carousel');
  	sliderTwo.trigger('next.owl.carousel');
  	time = 20
  }
  $(".timer").html(time);
}, 2000);

/*//Product-slider2//
$('.product-slider2').owlCarousel({
    loop:false,
    margin:30,
    nav:false,
    dots:false,
    autoplayTimeout:5000,
    autoplayHoverPause:true,    
    responsive:{
        0:{
            items:2
        },
        600:{
            items:3
        },
        1000:{
            items:4
        }
    }
})*/
$(".product-slider2")
  .on("initialized.owl.carousel changed.owl.carousel", function (e) {
    if (!e.namespace) {
      return;
    }
    var carousel = e.relatedTarget;
    $(".slider-counter").text(
      carousel.relative(carousel.current()) + 4 + " of " + carousel.items().length
    );
  })
  .owlCarousel({
    loop:false,
    margin:30,
    nav:false,
    dots:false,
    autoplayTimeout:5000,
    autoplayHoverPause:true,    
    responsive:{
        0:{
            items:2
        },
        600:{
            items:3
        },
        1000:{
            items:4
        }
    }
  });

//Product3 slider//
//product slider//
 $('.product3-slider').owlCarousel({
    loop:false,
    margin:0,
    nav:false,
    dots:false,
   	mouseDrag:false,
    touchDrag:false,
   	autoplay:false,
   	animateOut: 'animate__fadeOut',
    animateIn: 'animate__fadeIn',
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
});

//Unique slider
$('.unique-slider').owlCarousel({
    loop:true,
    margin:0,
    nav:false,
    dots:false,
    responsive:{
        0:{
            items:3
        },
        600:{
            items:4
        },
        1000:{
            items:5
        }
    }
})
//Unique slider2
$('.unique-slider2').owlCarousel({
    loop:true,
    margin:0,
    nav:false,
    dots:false,
    responsive:{
        0:{
            items:3
        },
        600:{
            items:4
        },
        1000:{
            items:5
        }
    }
})

//Unique slider3
$('.unique-slider3').owlCarousel({
    loop:true,
    margin:0,
    nav:false,
    dots:false,
    responsive:{
        0:{
            items:3
        },
        600:{
            items:4
        },
        1000:{
            items:5
        }
    }
})
//commit-slider
$('.commit-slider').owlCarousel({
    loop:true,
    margin:10,
    nav:false,
    dots:false,
    autoHeight: true,
    autoplay:true,
    autoplayTimeout:5000,
    autoplayHoverPause:true,    
    responsive:{
        0:{
            items:2
        },
        600:{
            items:3
        },
        1000:{
            items:6
        }
    }
})