$(document).ready(function() {

	var isMoving = false;
	var isdragging = false;
	var chatMode = false;

	$(".postloader").click(function() {
	  $("#preloader").css({"animation": "fadeIn 0.5s ease-in 0s forwards"});
		$("#preloader").css({"z-index": "100"});
		// alert("test");
	});

	$(".bubble").css("top", "80%").css("left", "-25px");
	// var bubbleX=0;
	// var bubbleY=0;
	var bubbleX=$(".bubble").position().left;
	var bubbleY=$(".bubble").position().top;
	
	function bubbleMove(){
		pos = $(".chat_container").offset();
		if($(window).width()>=992){
			$(".bubble").css("top", (70	+0) + "px").css("left", (pos.left+10) + "px").css("transition", "all 0.25s");
		}else{
			$(".bubble").css("top", (70) + "px").css("left", (pos.left+10) + "px").css("transition", "all 0.25s");
		}
	}
	
	$(window).on('resize', function(){
		$(".bubble").css("top", "80%").css("left", "-25px");
	});

	$(".bubble").draggable();
	
	
	function hide_chat_container(){
		$(".chat_container").css("z-index",-100);
	}
	function closeChat(){
			$(".bubble").css("top", bubbleY+"px").css("left", bubbleX+"px").css("transition", "all 0.5s");
	    // $(".bubble").css("top", "50%").css("left", "-25px").css("transition", "all 0.5s");
	    $(".chat").addClass("bounceout").removeClass("bouncein");
	    $(".chat").replaceWith($(".chat").clone(true));
			$(".timetableMask").css("display","none");
			setTimeout(hide_chat_container, 1000);
			
		 	
	}

	
	$(".bubble").on("click", function(){

		$(".timetableMask").css("display","block");

		$(".chat_container").css("z-index",2);
		
		// if(!chatMode){
		// 	bubbleX=$(".bubble").position().left;
		// 	bubbleY=$(".bubble").position().top;
		// }
		
		// console.log(bubbleX+","+bubbleY);
	  
	  var pos = $(".chat_container").offset();
	  
	  if(chatMode){
	    closeChat();
	    chatMode = false;
	  }else{
	    $(".chat").addClass("bouncein").removeClass("bounceout");
			bubbleMove();
			$(".chat").replaceWith($(".chat").clone(true));
			$(".timetableMask").css({"animation": "fadeIn 0.3s forwards"});
	    chatMode = true;
	  }
	});
	
	$(".bubble").mousedown(function(){
		if(isdragging){
			if(chatMode){
				closeChat();
		    chatMode = false;
			}
		}
		
	  isdragging = false;
		// console.log("test");
		
	});
	
	$(".bubble").mousemove(function(){
	  isdragging = true;
	  $(this).css("transition", "all 0s");
		
	});
	
	$(".bubble").mouseup(function(e){
	  e.preventDefault();
	  var lastY = window.event.clientY;
	  var lastX = window.event.clientX;
	  var swidth = $( window ).width();
	  
	  if(isdragging){
	    
	    // if(chatMode){
	    //   chatMode = false;
	    //   closeChat();
	    // }
	    var leftVal=0;
	    if(lastX > (swidth/2)){
	      // $(this).css("top", lastY).css("left", (swidth-55) + "px").css("transition", "all 0.4s");
				leftVal=swidth-55;
	    }else{
	      // $(this).css("top", lastY).css("left", "-25px").css("transition", "all 0.4s");	   
				leftVal=-25;
			}
			$(this).css("top", lastY).css("left", leftVal + "px").css("transition", "all 0.4s");
			bubbleX=leftVal;
			bubbleY=$(".bubble").position().top;
			
	  }
	});


	$(".timetableMask").click(function(e){
		if(chatMode){
			closeChat();
			chatMode = false;
		}
	});

	// $(".chat").click(function(e){
	// 	var chat = $(".chat");
	// 	if(chat.is(e.target) &&
 //       !chat.has(e.target).length){

			
	// 	    closeChat();
	// 	    chatMode = false;
		  
	// 	} 
	// });

	
	// 點擊畫面DIV和按鈕以外的任何地方就隱藏DIV
	$("body").click(function(e){  
		var container = $(".chatIn");
		var btn = $(".bubble");
		// 判斷點擊的地方不是DIV或按鈕
		if(!container.is(e.target) &&
			 !container.has(e.target).length &&
			 !btn.is(e.target) &&
       !btn.has(e.target).length){

			if(chatMode){
		    closeChat();
		    chatMode = false;
		  }
			
		}  
	});	

	
});

