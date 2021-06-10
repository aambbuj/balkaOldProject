// SAHINOOR JS
// CARD OVERLAY PANNEL
// $('.product-cart-slider').owlCarousel({
//     // stagePadding: 200,
//     loop: true,
//     margin: 10,
//     nav: false,
//     items: 2,
//     lazyLoad: true,
//     nav: true,
//     responsive: {
//         0: {
//             items: 1,
//             // stagePadding: 60
//         },

//         600: {
//             items: 1,
//             // stagePadding: 100
//         },

//         1000: {
//             items: 1,
//             // stagePadding: 200
//         },

//         1200: {
//             items: 1,
//             // stagePadding: 250
//         },

//         1400: {
//             items: 1,
//             // stagePadding: 300
//         },

//         1600: {
//             items: 1,
//             // stagePadding: 350
//         },

//         1800: {
//             items: 1,
//             // stagePadding: 400
//         }
//     }
// });

// $('.loop').owlCarousel({
//     center: true,
//     items: 2,
//     loop: true,
//     margin: 10,
//     responsive: {
//         600: {
//             items: 4
//         }
//     }
// });

// number increase start 
(function() {
    "use strict";
    var jQueryPlugin = window.jQueryPlugin = function(ident, func) {
        return function(arg) {
            if (this.length > 1) {
                this.each(function() {
                    var $this = $(this);

                    if (!$this.data(ident)) {
                        $this.data(ident, func($this, arg));
                    }
                });

                return this;
            } else if (this.length === 1) {
                if (!this.data(ident)) {
                    this.data(ident, func(this, arg));
                }

                return this.data(ident);
            }
        };
    };
})();

// (function() {
//     "use strict";

//     function Guantity($root) {
//         const element = $root;
//         const quantity = $root.first("data-quantity");
//         const quantity_target = $root.find("[data-quantity-target]");
//         const quantity_minus = $root.find("[data-quantity-minus]");
//         const quantity_plus = $root.find("[data-quantity-plus]");
//         var quantity_ = quantity_target.val();
//         $(quantity_minus).click(function() {
//             quantity_target.val(--quantity_);
//         });
//         $(quantity_plus).click(function() {
//             quantity_target.val(++quantity_);
//         });
//     }
//     $.fn.Guantity = jQueryPlugin("Guantity", Guantity);
//     $("[data-quantity]").Guantity();
// })();


// increaseValue and decreaseValue JS
function increaseValue() {
    var value = parseInt(document.getElementById('number').value, 10);
    value = isNaN(value) ? 0 : value;
    value++;
    document.getElementById('number').value = value;
}

function decreaseValue() {
    var value = parseInt(document.getElementById('number').value, 10);
    value = isNaN(value) ? 0 : value;
    value < 1 ? value = 1 : '';
    value--;
    document.getElementById('number').value = value;
}

$(document).ready(function() {
    $(".del").click(function() {
        $(this).parents(".del-cart").remove();
    });
});



$(".card-slider2")
    .owlCarousel({
        // center: true,
        loop: false,
        margin: 30,
        nav: false,
        autoWidth: false,
        dots: false,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 2
            }
        }
    });

$(".bank-card-details")
    .owlCarousel({
        // center: true,
        loop: false,
        margin: 30,
        nav: false,
        autoWidth: true,
        dots: false,
        autoplay: false,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        touchDrag: true,
        mouseDrag: true,
        responsive: {
            0: {
                items: 2
            }
        }
    });

// wishlist tutorial model
$(document).ready(function() {
    $("#wishlistmodel").modal('show');
});


// ******************************** secend test ********************************
// this.$('.js-loading-bar').modal({
//     backdrop: 'static',
//     show: false
// });


// $('#load').onload(function() {
//     var $modal = $('.js-loading-bar'),
//         $bar = $modal.find('.progress-bar');

//     $modal.modal('show');
//     $bar.addClass('animate');

//     setTimeout(function() {
//         $bar.removeClass('animate');
//         $modal.modal('hide');
//     }, 1500);
// });

// ******************************** third test ********************************
// $('#wishlistmodel').on('shown.bs.modal', function() {

//     var progress = setInterval(function() {
//         var $bar = $('.bar');

//         if ($bar.width() == 100) {
//             $bar.width(0);
//         } else {
//             // perform processing logic (ajax) here
//             $bar.width($bar.width() + 100);
//         }
//     }, 800);

// });
$(function() { $('[data-toggle="tooltip"]').tooltip() });
// /* ******************************************************
// ******************************************************
// style 2
// ******************************************************
// ****************************************************** */