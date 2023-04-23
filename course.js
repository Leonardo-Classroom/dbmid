$(document).ready(function() {
	//mouse hover
	$(".card").mouseenter(function(){
		$( this ).find(".bi").addClass( "bi-hover" );
		$( this ).find(".xuan").addClass( "xuan-hover" );
		$( this ).addClass( "card-hover" );
	});
	
	$(".card").mouseleave(function(){
		$( this ).find(".bi").removeClass( "bi-hover" );
		$( this ).find(".xuan").removeClass( "xuan-hover" );
		$( this ).removeClass( "card-hover" );
	});

	//touch
	$(document).on('touchstart', '.card', function(e){
		$( this ).find(".bi").addClass( "bi-hover" );
		$( this ).find(".xuan").addClass( "xuan-hover" );
		$( this ).addClass( "card-hover" );
	});

	$(document).on('touchend', '.card', function(e){
		$( this ).find(".bi").removeClass( "bi-hover" );
		$( this ).find(".xuan").removeClass( "xuan-hover" );
		$( this ).removeClass( "card-hover" );
	});

	$(document).on('touchcancel', '.card', function(e){
		$( this ).find(".bi").removeClass( "bi-hover" );
		$( this ).find(".xuan").removeClass( "xuan-hover" );
		$( this ).removeClass( "card-hover" );
	});


	

	
});