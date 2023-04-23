function disapear(){
	loader.style.zIndex="-10000";
}

var loader=document.getElementById("preloader");
window.addEventListener("load",function(){
	// loader.style.display="none";
	loader.style.animation="fadeOut 0.5s ease-out 0s forwards";
	setTimeout(disapear, 500);
	// loader.style.animation="";
})