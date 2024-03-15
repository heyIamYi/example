const winW = $(this).width();

AOS.init({
    duration: 700,
});
// main menu
if(winW >= 1100){
    $('.main-menu .has-sub').hover(function(){
        $(this).find('.sub-menu').stop(true).fadeIn(400);
    },function(){
        $(this).find('.sub-menu').stop(true).fadeOut(400);
    })
}else{
    $('.main-menu .has-sub a').click(function(){
        $(this).siblings('.sub-menu').stop(true).slideToggle(400);
    })

    // mobile menu triggrt
    $('.mobile-toggle').click(function(e){
        e.preventDefault();
        
        $(this).stop(true).toggleClass('open');
        $('.main-menu').stop(true).fadeToggle(400);
    })
}
