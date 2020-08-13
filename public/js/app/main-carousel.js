$('.category-carousel').owlCarousel({
    loop:true,
    margin:10,
    responsiveClass:true,
    responsive:{
        0:{
            items:5,
            nav:false,
            dots:false,
            loop: true,
            autoplay: true,
            autoplaySpeed: 1000,
            autoplayHoverPause: true,
            slidesToScroll: 3,
            margin: 0
        },
        320:{
            items:3,
            nav:false,
            dots:false,
            loop: true,
            autoplay: true,
            autoplaySpeed: 1000,
            autoplayHoverPause: true,
            slidesToScroll: 3,
            margin: 0
        },
        360:{
            items:3,
            nav:false,
            dots:false,
            loop: true,
            autoplay: true,
            autoplaySpeed: 1000,
            autoplayHoverPause: true,
            slidesToScroll: 3
        },
        600:{
            items:5,
            nav:false,
            dots:false,
            loop: true,
            autoplay: true,
            autoplaySpeed: 1000,
            autoplayHoverPause: true,
            slidesToScroll: 3,
            margin: 0
        },
        1000:{
            items:8,
            nav:false,
            dots:false,
            loop: true,
            autoplay: true,
            autoplaySpeed: 1000,
            autoplayHoverPause: true,
            slidesToScroll: 3,
            margin: 0,
            stagePadding: 5
        }
    }
});

$('.highlights-carousel').owlCarousel({
    loop:true,
    margin:10,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:false,
            dots:true,
            slidesToScroll: 1
        },
        600:{
            items:1,
            nav:false,
            dots:true,
            loop: true,
            slidesToScroll: 1
        },
        1000:{
            items:1,
            nav:false,
            dots:true,
            slidesToScroll: 1
        }
    }
});