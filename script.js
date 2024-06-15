$(document).ready(function(){
    var owl = $(".projects-carousel");

    owl.owlCarousel({
        loop: true,
        margin: 10,
        nav: false, 
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 5
            }
        }
    });
    $("#Prev").click(function(){
        owl.trigger('prev.owl.carousel');
    });

    $("#Next").click(function(){
        owl.trigger('next.owl.carousel');
    });
});
