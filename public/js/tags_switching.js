// JavaScript Document

$(function(){
	var _showTab = 0;
	var $defaultLi = $('.rentalreview_link_ul li a').eq(_showTab).addClass('active');
	$($defaultLi.attr('href')).siblings().hide();
	
	$('.rentalreview_link_ul li a').click(function() {
		var $this = $(this),
		_clickTab = $this.attr('href');
		$this.addClass('active').parent("li").siblings().children("a.active").removeClass('active');
		$(_clickTab).stop(false, true).fadeIn().siblings().hide();
		return false;
	}).find('a').focus(function(){
		this.blur();
	});
});