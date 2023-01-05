$(document).ready(function() {
	setTimeout(function() {

      $(".border_line").hide();
      $(".navbar-default .gnb > ul.navbar-nav").hover(
      	function(){
      		$("DH_HEADER").addClass("menu_on");
      		$(".dark_bg").css("display", "block");
      		$(".border_line").fadeIn(100);
      		$(".navbar-default .gnb > ul.navbar-nav > li").removeClass("over");
      	},
      	function(){
      		$("DH_HEADER").removeClass("menu_on");
      		$(".dark_bg").css("display", "none");
      		$(".border_line").fadeOut(100);
      		$(".navbar-default .gnb > ul.navbar-nav > li").removeClass("over");
      		$(".nav_third_level").removeClass("show_third");
      	}
      );
      $(".navbar-default .gnb > ul.navbar-nav > li").hover(
      	function(){

      		$(this).children("DH_MENU_1ST").addClass("over");
      		$(this).siblings("li").children("DH_MENU_1ST").removeClass("over");
      	}
      );
      $("DH_MENU_2ND").hover(
      	function(){
      		$(this).parents("li").siblings().find("div").removeClass("show_third");
      		$(this).next(".nav_third_level").addClass("show_third");
      		$(this).siblings("a").next(".nav_third_level").removeClass("show_third");
      	}
      );
      $(".show_third DH_MENU_3RD").hover(
      	function(){
      		$(this).parent().prev("DH_MENU_3RD").css("color", "#555");
      	}
      );
      $(".full_Menu").click(
           function(){
                  $(".all_menu").removeClass("hide_all_menu");
                  $(".all_menu").addClass("show_all_menu");
           } 
      );
      $(".full_menu_close").click(
            function(){
                  $(".all_menu").removeClass("show_all_menu");
                  $(".all_menu").addClass("hide_all_menu");

            }
      );

      $(window).resize(function(){
        var width = parseInt($(this).width()); //parseint는 정수로 하기 위함


            if (width > 768){
                  $("#accordion > li").removeClass("panel");
                  $("#accordion > li .nav_second_level").removeClass("collapse");
                  $("#accordion > li > a").attr("data-toggle", "false");

            } else {
                  $("#accordion > li").addClass("panel");
                  $("#accordion > li .nav_second_level").addClass("collapse");
                  $("#accordion > li > a").attr("data-toggle", "collapse");
            }

      }).resize();
		
	}, 500);

});
