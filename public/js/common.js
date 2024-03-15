AOS.init();
$(document).ready(function() {
    //內頁側選單
    $("ul.sidefirst_ul > li > a").click(function(){
        $(this).next("ul.sidesec_ul").slideToggle();
    });

    
    //手機選單
    $(".showMenu").click(function(){
        if ($("#btn").hasClass("on")) {
            $("#btn").removeClass("on");
            $(".headerright").removeClass("active");
            $("header").removeClass("active");
            $(".mobilecover").removeClass("active");
            $("header nav.menu > ul > li .submenu").slideUp();
            $("a.opensublink").removeClass("active");
        }else{
            $("#btn").addClass("on");
            $("header").addClass("active");
            $(".headerright").addClass("active");
            $("header").addClass("active");
            $(".mobilecover").addClass("active");
        };
    });

    //手機次選單
    function mobilesubmenu() {
        if ($(window).width() < 1200) {
            $("header nav.menu > ul > li").click(function(){
                $(this).siblings().find(".submenu").slideUp();
                $(this).siblings().find("a.opensublink").removeClass("active");
                $(this).find(".submenu").slideToggle();
                $(this).find("a.opensublink").toggleClass("active");
            });
        }

        //如果手機版選單有次選單就會顯示
        $('header .firstmenu').each(function(){
            
            if( $(this).next('.submenu').length > 0 ){
                $(this).append("<a class='opensublink' href='javascript:;'></a>");
            }else{
                // $(this).find("a.opensublink").hide();
            }
        });
    };
    mobilesubmenu();


    // $(window).on("load resize", function(e) {
    //     var wdth = $(window).width();
    //     if (wdth < 1240) {
    //         $(".phone-main-nav-btn").fadeIn();
    //         $("header .desktop").fadeOut();
    //         $("header .phone").fadeIn();
    //     } else {
    //         $(".phone-main-nav-btn").fadeOut();
    //         $("header .desktop").fadeIn();
    //         $("header .phone").fadeOut();
    //     }
    // });
    
    /* header */
    // $(window).on("scroll load", function(e) {
    //     var scroll = $(this).scrollTop();
    //     if (scroll > 50) {
    //         $("header .desktop").addClass("fixed");
    //         $("header .phone").addClass("fixed");
    //         $(".phone-main-nav-btn").addClass("fixed");
    //     } else {
    //         $("header .desktop").removeClass("fixed");
    //         $("header .phone").removeClass("fixed");
    //         $(".phone-main-nav-btn").removeClass("fixed");
    //     }
    // });


    // 
    
    
    //top
    // $(".top a").click(function() {
    //     $("html,body").animate({ "scrollTop": "0" })
    //     n = 1
    // })

    

    /*拖拉重整頁面*/
    const w_w_first = $(window).width();
    $(window).on('resize load', function (event) {
        let w_w = $(window).width();
        let range = w_w_first - w_w;

        if (range < 0) { range = -range };
        if (range > 200) { location.reload(); }
    });


    // tab
	var _showTab = 0;
	var $defaultLi = $('.tabtagbox ul li a').eq(_showTab).addClass('active');
	$($defaultLi.attr('href')).siblings().hide();
	
	$('.tabtagbox ul li a').click(function() {
		var $this = $(this),
		_clickTab = $this.attr('href');
		$this.addClass('active').parent("li").siblings().children("a.active").removeClass('active');
		$(_clickTab).stop(false, true).fadeIn().siblings().hide();
		return false;
	}).find('a').focus(function(){
		this.blur();
	});

    // 元素漸入
    // AOS.init({
    //     once: true,
    //     duration: 800,
    //     easing: 'ease-in-out-back'
    // });

    // 元素漸入
    $(window).on("scroll", function () {
        AOS.init(
            {
                once: true,
                duration: 800,
                // easing: 'ease-in-out-back'
                
            }
        );
    });


    // 年月日
    $('.datepicker').datepicker({
        // Consistent format with the HTML5 picker
        dateFormat: 'yy-mm-dd'
    });


    
    
    
});



