var owling = null;
var startPlay = null;

$(document).ready(function(e) {
    var lengthh = $(".pop-slider").find(".item").length;
    var sata_str = "";

    $(".pop-slider").find(".owl-prev").on("click", function(e) {
        stopAutoPlay();
        setTimeout(function(e) {
                startAutoPlay();
            },
            500);
    });
    $(".pop-slider").find(".owl-next").on("click", function(e) {
        stopAutoPlay();
        setTimeout(function(e) {
                startAutoPlay();
            },
            500);
    });

    for (var i = 0; i < lengthh; i++) {
        sata_str += '<div id="slide_progress_main_' + i + '" class="slide-progress-main"><div class="slide-progress"></div></div>';
    }
    $(".slide-list").html(sata_str);
    initSlider();

    owling.on('changed.owl.carousel', function(event) {
        $(".pop-slider").find(".owl-item").show();
        console.log($(".pop-slider").find('.owl-item.active'));
        resetProgressBar();
        startProgressBar();
    });
    // $(".pop-slider").find(".owl-item").hide();
    $('#instapop').on('shown.bs.modal', function() {
        resetProgressBar();
        startProgressBar();
        setTimeout(function() {
            $("#pop-loading").hide();
            $("#owl-demo").show();

            // $(".pop-slider").find(".owl-item").show();
        }, 500);
    });
});


//nav icon FONT AWESOME ON CLICK
$('.navbar-toggler').click(function() {
    $(this).find('i').toggleClass('fal fa-equals w-100 fal fa-times w-100')
});

//button text change

$('.chng-txt').click(function() {
    var $this = $(this);
    $this.toggleClass('.chng-txt');
    if ($this.hasClass('.chng-txt')) {
        $this.text('Close');
    } else {
        $this.text('Menu');
    }
});
$("#bdcmb").click(function() {
    $(".chng-txt").text($(".chng-txt").text() == 'Menu' ? 'Close' : 'Menu');
});
//button text change

/**search pop up
  $(function(){
$("#addClass").click(function () {
          $('#qnimate').addClass('popup-box-on');
            });

            $("#removeClass").click(function () {
          $('#qnimate').removeClass('popup-box-on');
            });
  });**/


//serach bar open
$(document).ready(function() {
    $("#addClass").click(function() {
        $(".search-bar").show();
        $("#sch-opc").addClass("search-opacity");
    });
    $("#closebar").click(function() {
        $(".search-bar").hide();
        $("#sch-opc").removeClass("search-opacity");
    });
});


//spotlight Slider
$('.spotlight-slider').owlCarousel({
    loop: true,
    margin: 0,
    nav: false,
    dots: false,
    responsive: {
        0: {
            items: 4,
            mouseDrag: true,
            touchDrag: true,
            autoplay: false,
            center: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: false,
        },
        600: {
            items: 5,
            mouseDrag: true,
            touchDrag: true,
            autoplay: false,
            center: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: false,
        },
        1000: {
            items: 7,
            mouseDrag: false,
            touchDrag: false,
            autoplay: false,
        }
    }
})

//blog slider//
var sliderOne = $('.blog-slider').owlCarousel({
    loop: true,
    margin: 0,
    nav: false,
    mouseDrag: true,
    touchDrag: true,
    autoplay: false,
    autoplayTimeout: 20000,
    autoplayHoverPause: false,
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
//product slider//
var sliderTwo = $('.product-slider').owlCarousel({
    loop: true,
    margin: 0,
    nav: false,
    dots: false,
    mouseDrag: false,
    touchDrag: false,
    autoplay: false,
    animateOut: 'animate__fadeOut',
    animateIn: 'animate__fadeIn',
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
//Sync  sliderOne by sliderTwo
sliderOne.on('changed.owl.carousel', function() {
    sliderTwo.trigger('next.owl.carousel');
    time = 20;
});
var timer_blog = 20;
sliderOne.on('changed.owl.carousel', function() {
    // sliderTwo.trigger('next.owl.carousel');
    console.log($("#next_circle"));
    $("#next_circle").css("animation-play-state", "running");
    timer_blog = 21;
});
setInterval(function() {
    // alert("Hello");
    timer_blog = timer_blog - 1;
    if (timer_blog <= 0) {
        sliderOne.trigger('next.owl.carousel');
        timer_blog = 20
    }
    $(".timer").html(timer_blog);
}, 1000);

//timer
var time = 20;
setInterval(function() {
    // alert("Hello");
    time = timer - 1;
    if (time <= 0) {
        sliderTwo.trigger('next.owl.carousel');
        time = 20
    }
    $(".timer").html(time);
}, 1000);

sliderOne.on('changed.owl.carousel', function() {
    $(".percent1 circle:nth-child(2)").css("animation", "none");
    $(".percent1 circle:nth-child(2)").css("-webkit-animation", "none");
    $(".percent1 circle:nth-child(2)").css("-moz-animation", "none");
    setTimeout(function() {
        $(".percent1 circle:nth-child(2)").css("animation", "");
        $(".percent1 circle:nth-child(2)").css("-webkit-animation", "");
        $(".percent1 circle:nth-child(2)").css("-moz-animation", "");
    }, 0);

});

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
    .on("initialized.owl.carousel changed.owl.carousel", function(e) {
        if (!e.namespace) {
            return;
        }
        var carousel = e.relatedTarget;
        $(".slider-counter").text(
            carousel.relative(carousel.current()) + 4 + " of " + carousel.items().length
        );
    })
    .owlCarousel({
        loop: false,
        margin: 30,
        nav: false,
        dots: false,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 2
            },
            600: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    });
$('.product-slider2').owlCarouselProgressBar({
    size: '2px',
    margin: '10px 0px 0px 0px',
    foregroundColor: 'var(--l-yellow)',
    color: 'var(--yellow)',
    borderRadius: 0,
    transitionInterval: 1,
    progressBarClassName: 'product-bar',
    scrollerClassName: 'product-scroll'
});
//Product3 slider//
//product slider//
$('.product3-slider').owlCarousel({
    loop: false,
    margin: 0,
    nav: false,
    dots: false,
    mouseDrag: false,
    touchDrag: false,
    autoplay: false,
    animateOut: 'animate__fadeOut',
    animateIn: 'animate__fadeIn',
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

//Unique slider
$('.unique-slider').owlCarousel({
        autoWidth: false,
        loop: true,
        margin: 0,
        nav: false,
        dots: false,
        responsive: {
            0: {
                items: 3
            },
            600: {
                items: 4
            },
            1000: {
                items: 5
            }
        }
    })
    //Unique slider2
$('.unique-slider2').owlCarousel({
    autoWidth: false,
    loop: true,
    margin: 0,
    nav: false,
    dots: false,
    responsive: {
        0: {
            items: 3
        },
        600: {
            items: 4
        },
        1000: {
            items: 5
        }
    }
})

//Unique slider3
$('.unique-slider3').owlCarousel({
        autoWidth: false,
        loop: true,
        margin: 0,
        nav: false,
        dots: false,
        responsive: {
            0: {
                items: 3
            },
            600: {
                items: 4
            },
            1000: {
                items: 5
            }
        }
    })
    //commit-slider
$('.commit-slider').owlCarousel({
    loop: true,
    margin: 10,
    nav: false,
    dots: false,
    autoHeight: true,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    responsive: {
        0: {
            items: 2,
            center: true,
        },
        600: {
            items: 3,
            center: true,
        },
        1000: {
            items: 6,
        }
    }
})

//Insta-desktop-slider
$('.insta-desktop-slider').owlCarousel({
    loop: true,
    margin: 10,
    nav: false,
    autoplay: true,
    autoplayTimeout: 5000,
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
})

//Insta-mobile-slider
$('.insta-mobile-slider').owlCarousel({
    loop: true,
    margin: 10,
    nav: false,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 2
        },
        1000: {
            items: 2
        }
    }
})

//pop slider


function initSlider() {
    owling = $(".pop-slider").owlCarousel({
        items: 1,
        loop: true,
        dots: false,
        stagePadding: 0,
        nav: true,
        autoplay: false,
        autoplayHoverPause: false,
        navText: [
            "<i class='fal fa-chevron-left'></i>",
            "<i class='fal fa-chevron-right'></i>"
        ],
        onInitialized: callChange,
        onTranslate: resetProgressBar,
        onTranslated: startProgressBar
    });
}

function callChange() {
    var settingTime = setInterval(function(e) {
            var idd = $(".pop-slider").find('.owl-item.active').find(".item").data("id");
            if (idd != undefined) {
                startProgressBar();
                startAutoPlay();
                clearInterval(settingTime);
            }
        },
        500);
}

function startAutoPlay() {
    startPlay = setInterval(function(e) {
            owling.trigger('next.owl.carousel');
        },
        5000);
}

function stopAutoPlay() {
    clearInterval(startPlay);
}

function startProgressBar() {
    // alert("Hello");
    //
    // apply keyframe animation
    var idd = $(".pop-slider").find('.owl-item.active').find(".item").data("id");
    // console.log("start");
    // console.log(idd);
    for (var i = 0; i < idd; i++) {
        $("#slide_progress_main_" + i).find(".slide-progress").css({
            width: "100%"
        });
    }
    $("#slide_progress_main_" + idd).find(".slide-progress").css({
        width: "100%",
        transition: "width 5000ms"
    });
}

function resetProgressBar() {
    // alert("Hello1");
    var idd = $(".pop-slider").find('.owl-item.active').find(".item").data("id");
    // console.log("start");
    // console.log(idd);
    for (var i = 0; i < idd; i++) {
        $("#slide_progress_main_" + i).find(".slide-progress").css({
            width: 0
        });
    }
    $("#slide_progress_main_" + idd).find(".slide-progress").css({
        width: 0,
        transition: "width 0s"
    });
}
//product page value slider
$('.pd-value-slider').owlCarousel({
    loop: false,
    margin: 0,
    nav: true,
    responsive: {
        0: {
            items: 2

        },
        600: {
            items: 3

        },
        1000: {
            items: 6
        }
    }
});
//listing page product slider
$(".liproduct-slider")
    .on("initialized.owl.carousel changed.owl.carousel", function(e) {
        if (!e.namespace) {
            return;
        }
        var carousel = e.relatedTarget;
        $(".slider-counter").text(
            carousel.relative(carousel.current()) + 3 + " of " + carousel.items().length
        );
        if (window.matchMedia('(max-width: 600px)').matches) {
            $(".slider-counter").text(
                carousel.relative(carousel.current()) + 2 + " of " + carousel.items().length
            );
        }
    })
    .owlCarousel({
        loop: false,
        margin: 30,
        nav: false,
        dots: false,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 2
            },
            600: {
                items: 3
            },
            1000: {
                items: 3
            }
        }
    });
$('.liproduct-slider').owlCarouselProgressBar({
    size: '2px',
    margin: '10px 0px 0px 0px',
    foregroundColor: 'var(--l-yellow)',
    color: 'var(--yellow)',
    borderRadius: 0,
    transitionInterval: 1,
    progressBarClassName: 'product-bar',
    scrollerClassName: 'product-scroll'
});
//custom select menu js//
$(document).ready(function() {
    $("select").niceSelect();
});
//listing tags//


//view grid css
$(document).ready(function() {
    $("#view-style2").click(function() {
        $(".grid-mnl").find(".col-lg-3.mb-4").toggleClass("col-lg-4");
        $(".grid-mnl").find(".col-lg-3.order-4").removeClass("order-4").addClass("order-7");
    });
    $("#view-style1").click(function() {
        $(".grid-mnl").find(".col-lg-3.mb-4").removeClass("col-lg-4");
        $(".grid-mnl").find(".col-lg-3.order-7").removeClass("order-7").addClass("order-4");
    });
});
/*******value btn fixe***********/
$(window).scroll(function() {
    var scroll = $(window).scrollTop();
    if (scroll >= 500) {
        $(".val-btns").addClass("val-btn-fixed");
    } else {
        $(".val-btns").removeClass("val-btn-fixed");
    }
});
//missing )
/*******scrollbar css************/
// var userAgent = navigator.userAgent.toLowerCase();

// if (userAgent.search('iphone') == -1 && userAgent.search('ipod') == -1)
// {
//   $('head').append('<link rel="stylesheet" href="css/scrollbars.css"/>');
// }

/********Product page header js**********/
$(window).scroll(function() {
    var scroll = $(window).scrollTop();

    //>=, not <=
    if (scroll >= 100) {
        //clearHeader, not clearheader - caps H
        $(".cstm-nv").removeClass("sticky-top");
    }
});

lastScroll = 0;
$(window).on('scroll', function() {
    var scroll = $(window).scrollTop();
    if (lastScroll - scroll > 0) {
        $(".cstm-nv").addClass("sticky-top");
        $(".image-gallery").addClass("img-gal-top");
    } else {
        $(".cstm-nv").removeClass("sticky-top");
        $(".image-gallery").addClass("img-gal-top");
    }
    lastScroll = scroll;
});

//custom radio button product page//
$('.size-xs input').on('click', e => {
    console.log(e.target.value);
});

//mobile side panels
function openNav() {
    document.getElementById("mySidepanel").style.right = "0px";
}

function closeNav() {
    document.getElementById("mySidepanel").style.right = "-85%";
}

function openNav2() {
    document.getElementById("mySidepanel2").style.right = "0px";
}

function closeNav2() {
    document.getElementById("mySidepanel2").style.right = "-85%";
}

function openNav3() {
    document.getElementById("mySidepanel3").style.right = "0px";
}

function closeNav3() {
    document.getElementById("mySidepanel3").style.right = "-85%";
}
$(".open-rpanel").click(function() {
    $(".overlay").addClass("enabled");
});
$(".sidepanel .closebtn").click(function() {
    $(".overlay").removeClass("enabled");
});
$("#njpq1").click(function() {
    $("#mbapq").show();
    $(".li-filters").hide();
    $("#jkopq").hide();
    $("#soimgh").show();
});
$("#soimgh").click(function() {
    $("#mbapq").hide();
    $(".li-filters").show();
    $("#jkopq").show();
    $("#soimgh").hide();
});

$(window).on('load', function() {
    $(".product-scroll").css("width", "33.3%");
    if (window.matchMedia('(min-width: 600px)').matches) {
        $(".product-scroll").css("width", "66.6667%");
    }
})

// //dropdown show
// lastScroll = 0;
// $(".dropdown-menu.dektp").on('scroll',function() {    
//     var scroll = $(".dropdown-menu.dektp").scrollTop();
//     if(lastScroll - scroll > 0) {
//         $(".dropdown-menu.dektp").removeClass("dml-top");

//     } else {
//         $(".dropdown-menu.dektp").addClass("dml-top");
//     }
//     lastScroll = scroll;
// });

//footer appera btn hide
var isScrolledIntoView = function(elem) {
    var $elem = $(elem);
    var $window = $(window);

    var docViewTop = $window.scrollTop();
    var docViewBottom = docViewTop + $window.height() + 500;

    var elemTop = $elem.offset().top;
    var elemBottom = elemTop + $elem.height();

    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}

$(window).on('scroll', function() {
    if (window.matchMedia('(max-width: 767px)').matches) {
        $('.val-btn-fixed').toggle(!isScrolledIntoView('.footer'));
    }
});
$(window).on('scroll', function() {
    $('.random-click').toggle(!isScrolledIntoView('.footer'));
});

//random-click rotation
$(".random-click").unbind().click(function() {
    $(".random-click i").css("animation-play-state", "running");
    $(".random-click i").css("animation-iteration-count", "1");
});

//vertical carousel//
$('.carousel .vertical .carousel-item').each(function() {
    var next = $(this).next();
    if (!next.length) {
        next = $(this).siblings(':first');
    }
    next.children(':first-child').clone().appendTo($(this));

    for (var i = 1; i < 1; i++) {
        next = next.next();
        if (!next.length) {
            next = $(this).siblings(':first');
        }

        next.children(':first-child').clone().appendTo($(this));
    }
});
// added script
$("#carousel-main .left").click(function() {
    $("#carousel-main").carousel('prev');
});
$("#carousel-main .right").click(function() {
    $("#carousel-main").carousel('next');
});

$("#carousel-main").swipe({
    swipe: function(event, direction, distance, duration, fingerCount, fingerData) {
        if (direction == 'left') $(this).carousel('next');
        if (direction == 'right') $(this).carousel('prev');
    },
    allowPageScroll: "vertical"
});



//product page scrollin
// lastScroll2 = 0;
// $(window).on('scroll',function() {    
//     var scroll2 = $("#section1").scrollTop();
//     if(lastScroll2 - scroll2 > 0) {
//         $("#section1").show();
//     } else {
//         $("#section1").hide();
//     }
//     lastScroll2 = scroll2;
// });


// $(window).scroll(function() {    
//     var scroll = $(window).scrollTop();
//     var scroll2 = $("#section1").scrollTop();
//     var scroll3 = $("#section2");
//     var scroll4 = $("#section3").scrollTop();
//     var scroll5 = $("#section4").scrollTop();
//     var scroll6 = $("#section5").scrollTop();

//      //>=, not <=
//     // if (scroll >= scroll3) {
//     //     //clearHeader, not clearheader - caps H
//     //     $("#section1").hide();
//     // }
//     if (scroll - scroll3 )  {
//         $("#section1").hide();
//     }
//     else {
//         $("#section1").show();
//     }


//     if (scroll - scroll6)  {
//         $("#section2").show();
//     }
//     else {
//         $("#section2").hide();
//     }


// });

// lastScroll3 = 0;
// $(window).on('scroll',function() {    
//     var scroll3 = $("#section2").scrollTop();
//     if(lastScroll3 - scroll3 > 0) {
//         $("#section2").show();

//     } else {
//         // $("#section1").show();
//         $("#section2").hide();
//     }
//     lastScroll3 = scroll3;
// });