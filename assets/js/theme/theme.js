jQuery(document).ready(function ($) {

    // Mobile navigation

    $(".menu-toggle").click(function () {
        $("#primary-menu").fadeToggle();
        $(this).toggleClass('menu-open')
    });
    // Sub Menu Trigger

    $( "#primary-menu li.menu-item-has-children > a" ).after('<span class="sub-menu-trigger"><svg xmlns="http://www.w3.org/2000/svg" width="18.816" height="11.628" viewBox="0 0 18.816 11.628"><path id="Path_1" data-name="Path 1" d="M922,78.5l8.229,8.433,8.454-8.433" transform="translate(-920.927 -77.438)" fill="none" stroke="#fff" stroke-width="3"/></svg></span>');

    $( ".sub-menu-trigger" ).click(function() {
		$( this ).parent().toggleClass('sub-menu-open')
		$( this ).siblings(".sub-menu").slideToggle();
	});

	var $temp = $("<input>");
	var $url = $(location).attr('href');
	$('#btn').click(function() {
	$("body").append($temp);
	$temp.val($url).select();
	document.execCommand("copy");
	$temp.remove();
	$(".result").text("URL copied!");
	});


});
