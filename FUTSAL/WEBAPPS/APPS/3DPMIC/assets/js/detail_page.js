$(document).ready(function(){
	// Add slideDown animation to Bootstrap dropdown when expanding.
	$('.dropdown').on('show.bs.dropdown', function() {
	    $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
	});

	// Add slideUp animation to Bootstrap dropdown when collapsing.
	$('.dropdown').on('hide.bs.dropdown', function() {
	    $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
	});
	$("#move_top_btn").click(function() {
        $('html, body').animate({
            scrollTop : 0
        }, 400);
        return false;
    });

    $(document).on("scroll",function(){
    	var n=$(".sub_bg").offset().top;
		var m=$(".sub_bg").offset().top;
		if ($(window).scrollTop() > n + 180) {
			$(".nav_md").addClass("fixed");
		}else{
			$(".nav_md").removeClass("fixed");
		}
		if ($(this).scrollTop() > 0) {
	        $('#move_top_btn').fadeIn();
	    } else {
	        $('#move_top_btn').fadeOut();
	    }
	});



	$(window).resize(function(){
        var width = parseInt($(this).width());
            if (width > 960){
                $(document).on("scroll",function(){

				    if($(window).scrollTop() + $(window).height() > $(document).height() - 260) {
				       	$("a#move_top_btn").addClass("stop_move");
				   	}else{
				   		$("a#move_top_btn").removeClass("stop_move");
				   	}
				});
            } else {
                $(document).on("scroll",function(){
					
				    if($(window).scrollTop() + $(window).height() > $(document).height() - 260) {
				       	$("a#move_top_btn").addClass("stop_move");
				   	}else{
				   		$("a#move_top_btn").removeClass("stop_move");
				   	}
				});
            }

      }).resize();

});

