
window.requestAnimFrame = (function(){
	return  window.requestAnimationFrame       ||
					window.webkitRequestAnimationFrame ||
					window.mozRequestAnimationFrame    ||
					function( callback ){
						window.setTimeout(callback, 1000 / 60);
					};
})();

var pointerDownName = 'pointerdown';
var pointerUpName = 'pointerup';
var pointerMoveName = 'pointermove';

if(window.navigator.msPointerEnabled) {
	pointerDownName = 'MSPointerDown';
	pointerUpName = 'MSPointerUp';
	pointerMoveName = 'MSPointerMove';

}

// Simple way to check if some form of pointerevents is enabled or not
window.PointerEventsSupport = false;
if(window.PointerEvent || window.navigator.msPointerEnabled) {
	window.PointerEventsSupport = true;
}

function Slider(element) {
	var isAnimating = false;

	var lastYPos = 0;
	var initialYPos = 0;
	var lastHolderYPos = 0;

	var lastXPos = 0;
	var initialXPos = 0;
	var lastHolderXPos = 0;

	var elementHold = element.querySelector('.hold');

	/* // [START handle-gestures] */
	// Handle the start of gestures
	this.handleGestureStart = function(evt) {
		evt.preventDefault();
	
		/* // [START stash-start] */
		var point = getGesturePointFromEvent(evt);
		initialYPos = point.y;
		initialXPos = point.x;
		/* // [END stash-start] */
	
		// Add the move and end listeners
		if (window.PointerEvent) {
			evt.target.setPointerCapture(evt.pointerId);
		} else {
			// Add Mouse Listeners
			document.addEventListener('mousemove', this.handleGestureMove, true);
			document.addEventListener('mouseup', this.handleGestureEnd, true);
		}
	}.bind(this);
	
	this.handleGestureEnd = function(evt) {
		evt.preventDefault();
	
		if(evt.targetTouches && evt.targetTouches.length > 0) {
			return;
		}
	
		// Remove Event Listeners
		if (window.PointerEvent) {
			evt.target.releasePointerCapture(evt.pointerId);
		} else {
			// Remove Mouse Listeners
			document.removeEventListener('mousemove', this.handleGestureMove, true);
			document.removeEventListener('mouseup', this.handleGestureEnd, true);
		}
	
		isAnimating = false;
	
		lastHolderYPos = lastHolderYPos + -(initialYPos - lastYPos);
		initialYPos = null;
	
		lastHolderXPos = lastHolderXPos + -(initialXPos - lastXPos);
		initialXPos = null;
	
	}.bind(this);
	/* // [END handle-gestures] */
	
	this.handleGestureMove = function(evt) {
		evt.preventDefault();
	
		if(evt.targetTouches && evt.targetTouches.length > 1) {
			return;
		}
	
		if (!initialYPos) {
			return;
		}
		if (!initialXPos) {
			return;
		}
	
		/* // [START handle-move] */
		var point = getGesturePointFromEvent(evt);
		lastYPos = point.y;
		lastXPos = point.x;
	
		if(isAnimating) {
			return;
		}
	
		isAnimating = true;
		window.requestAnimFrame(onAnimFrame);
		/* // [END handle-move] */
	}.bind(this);
	
	/* // [START extract-xy] */
	function getGesturePointFromEvent(evt) {
		var point = {};

		if(evt.targetTouches) {
			// Prefer Touch Events
			point.x = evt.targetTouches[0].clientX;
			point.y = evt.targetTouches[0].clientY;
		} else {
			// Either Mouse event or Pointer Event
			point.x = evt.clientX;
			point.y = evt.clientY;
		}

		return point;
	}
	/* // [END extract-xy] */
	
	/* // [START on-anim-frame] */
	function onAnimFrame() {
		if(!isAnimating) {
			return;
		}
	
		var newYTransform = lastHolderYPos + -(initialYPos - lastYPos);
		var newXTransform = lastHolderXPos + -(initialXPos - lastXPos);
	
		
	
		var transformStyle = 'translate('+newXTransform+'px,'+newYTransform+'px)';
		elementHold.style.msTransform = transformStyle;
		elementHold.style.MozTransform = transformStyle;
		elementHold.style.webkitTransform = transformStyle;
		elementHold.style.transform = transformStyle;
	
	
		isAnimating = false;
	}
	/* // [END on-anim-frame] */

	

	/* // [START addlisteners] */
	// Check if pointer events are supported.
	if (window.PointerEvent) {
		// Add Pointer Event Listener
		elementHold.addEventListener('pointerdown', this.handleGestureStart, true);
		elementHold.addEventListener('pointermove', this.handleGestureMove, true);
		elementHold.addEventListener('pointerup', this.handleGestureEnd, true);
		elementHold.addEventListener('pointercancel', this.handleGestureEnd, true);
	} else {
		// Add Touch Listeners
		elementHold.addEventListener('touchstart', this.handleGestureStart, true);
		elementHold.addEventListener('touchmove', this.handleGestureMove, true);
		elementHold.addEventListener('touchend', this.handleGestureEnd, true);
		elementHold.addEventListener('touchcancel', this.handleGestureEnd, true);

		// Add Mouse Listeners
		elementHold.addEventListener('mousedown', this.handleGestureStart, true);
	}
	/* // [END addlisteners] */
}

window.onload = function () {
	var sliderElements = document.querySelectorAll('.v-slider');
	for(var i = 0; i < sliderElements.length; i++) {
		new Slider(sliderElements[i]);
	}

	// We do this so :active pseudo classes are applied.
	window.onload = function() {
		if(/iP(hone|ad)/.test(window.navigator.userAgent)) {
			document.body.addEventListener('touchstart', function() {}, false);
		}
	};
};


