
function ImageSequencer ( templatePath, numberOfFrames, domCanvas ) {

	// Canvas
	this.domCanvas = domCanvas;
	this.context = domCanvas.getContext( "2d" );

	// Frames
	this.frameCount = numberOfFrames;
	this.framesLoaded = 0;
	this.frames = [ null ];
	this.aspectRatio = null;
	this.currentFrameNumber = null;
	this.nextFrameNumber = 1;
	this.frameRate = 2.5;
	// this.frameInterval = parseFloat( ( 1000 / this.frameRate ).toFixed( 2 ) );
	this.frameInterval = Math.round( 1000 / this.frameRate );

	// Is the player ready?
	this.isReady = false;

	// Behavior
	this.loop = false;
	this.playForward = true;

	// States
	this.isPlaying = false;
	this.isPaused = true;


	var onFrameLoaded = function onFrameLoaded () {
		this.framesLoaded += 1;
		if ( this.framesLoaded === this.frameCount )
			this.ready();
	}.bind( this );

	var _i;
	for ( _i = 1; _i <= numberOfFrames; _i += 1 ) {
		var image = new Image();
		image.src = templatePath.replace( "{i}", _i );
		image.onload = onFrameLoaded;
		this.frames.push( image );
	}

}

ImageSequencer.emptyFunction = function () {};

ImageSequencer.eventually = function ( fn, timeout ) {

	var timeout = ( timeout || 1 ) * 1000;
	var timeoutId = null;
	var rejectPromise;

	return function ( event ) {

		clearTimeout( timeoutId );
		if ( rejectPromise instanceof Function )
			rejectPromise();

		return new Promise( function ( resolve, reject ) {
			rejectPromise = reject;
			timeoutId = setTimeout( resolve, timeout );
		} )
			.then( fn )
			.catch( ImageSequencer.emptyFunction )

	};

}

ImageSequencer.prototype.ready = function ready () {
	this.isReady = true;

	// Constrain and Initialize the canvas's dimensions
	this.aspectRatio = this.frames[ 1 ].naturalWidth / this.frames[ 1 ].naturalHeight;
	this.domCanvas.style.maxWidth = this.frames[ 1 ].naturalWidth + "px";
	this.domCanvas.width = this.domCanvas.offsetWidth;
	this.domCanvas.height = this.domCanvas.width / this.aspectRatio;

	var player = this;
	// Re-size the canvas element correctly whenever the viewport dimensions change
	window.addEventListener( "resize", function () {
		player.domCanvas.width = player.domCanvas.offsetWidth;
		player.domCanvas.height = player.domCanvas.width;
	} );
	// Re-render the current frame whenever the viewport dimensions change
		// other the canvas just goes blank
	this.onResize( function ( event ) {
		player.renderFrame( player.currentFrameNumber );
	} );

	if ( ! ( this.readyHandler instanceof Function ) )
		return;
	this.readyHandler( this );
};

ImageSequencer.prototype.onReady = function onReady ( fn ) {

	// If the ready handler has already been set, simply return
	if ( this.readyHandler instanceof Function )
		return;

	// Set the ready handler
	if ( fn instanceof Function )
		this.readyHandler = fn;

	// If the sequencer is already "ready", then run the handler right away
	if ( this.isReady )
		return this.readyHandler( this );

};

ImageSequencer.prototype.onResize = function onResize ( fn ) {
	if ( this.resizeHandler instanceof Function )
		window.removeEventListener( "resize", this.resizeHandler );
	this.resizeHandler = ImageSequencer.eventually( fn, 250 );
	window.addEventListener( "resize", this.resizeHandler );
};

ImageSequencer.prototype.setPlayDirection = function setPlayDirection ( direction ) {
	if ( direction === 1 || direction === "forwards" )
		this.playForward = true;
	else if ( direction === -1 || direction === "backwards" )
		this.playForward = false;
};

ImageSequencer.prototype.setFrameRate = function setFrameRate ( rate ) {
	this.frameRate = rate;
	// this.frameInterval = parseFloat( ( 1000 / rate ).toFixed( 2 ) );
	this.frameInterval = Math.round( 1000 / this.frameRate );
};

// This function is set dynamically to whatever the next action the player should take
// 	be it play or pause
ImageSequencer.prototype.nextAction = ImageSequencer.emptyFunction;

ImageSequencer.prototype.renderFrame = function renderFrame ( frameNumber ) {
	var canvas = this.context.canvas;
	this.context.clearRect( 0, 0, canvas.width, canvas.height );
	this.context.drawImage( this.frames[ frameNumber ], 0, 0, canvas.width, canvas.height );
	// Set the player's `currentFrameNumber` to the provided frame number
	this.currentFrameNumber = frameNumber;
	return this.currentFrameNumber;
};

ImageSequencer.prototype._playAction = function playAction () {

	var player = this;
	setTimeout( function () {

		player.renderFrame( player.nextFrameNumber );

		if ( player.playForward ) {
			// If **not on** a loop, and on the last frame then stop playback
			if ( ! player.loop && player.currentFrameNumber === player.frameCount )
				return player.pause();

			// Go to the next frame
			player.nextFrameNumber = player.currentFrameNumber + 1;

			// If **on** a loop, and on the **last** frame, then go back to the **first**
			if ( player.loop && player.currentFrameNumber === player.frameCount )
				player.nextFrameNumber = 1;
		}
		else {
			// If **not on** a loop, and on the first frame then stop playback
			if ( ! player.loop && player.currentFrameNumber === 1 )
				return player.pause();

			// Go to the next frame
			player.nextFrameNumber = player.currentFrameNumber - 1;

			// If **on** a loop, and on the **first** frame, then go back to the **last**
			if ( player.loop && player.currentFrameNumber === 1 )
				player.nextFrameNumber = player.frameCount;
		}

		// Perform the next action ( whatever this may be )
		return player.nextAction();

	}, player.frameInterval );

};

ImageSequencer.prototype.play = function play () {

	if ( this.isPlaying )
		return;

	this.isPaused = false;
	this.isPlaying = true;
	this.nextAction = this._playAction;

	this.nextAction();

};

ImageSequencer.prototype.pause = function pause () {

	if ( this.isPaused )
		return;

	this.isPaused = true;
	this.isPlaying = false;
	this.nextAction = ImageSequencer.emptyFunction;

	this.nextAction();

};


/*
 *
 * Go to (and render) the subsequent frame in the **forward** direction
 *
 */
ImageSequencer.prototype.stepForward = function stepForward ( numberOfFrames ) {

	// numberOfFrames = numberOfFrames || 1;

	// If already on the **last** frame, then do nothing
	if ( this.currentFrameNumber === this.frameCount )
		return;

	// Go to the next frame
	this.nextFrameNumber = this.currentFrameNumber + 1;

	this.renderFrame( this.nextFrameNumber );

};

/*
 *
 * Go to (and render) the subsequent frame in the **backward** direction
 *
 */
ImageSequencer.prototype.stepBackward = function stepBackward ( numberOfFrames ) {

	// numberOfFrames = numberOfFrames || 1;

	// If already on the **first** frame, then do nothing
	if ( this.currentFrameNumber === 1 )
		return;

	// Go to the previous frame
	this.nextFrameNumber = this.currentFrameNumber - 1;

	this.renderFrame( this.nextFrameNumber );

};


/*
 *
 * Go to (and render) the next frame
 *
 */
ImageSequencer.prototype.nextFrame = function nextFrame () {

	this.pause();

	if ( this.playForward )
		this.stepForward();
	else
		this.stepBackward();

};

/*
 *
 * Go to (and render) the previous frame
 *
 */
ImageSequencer.prototype.previousFrame = function previousFrame () {

	this.pause();

	if ( this.playForward )
		this.stepBackward();
	else
		this.stepForward();

};
