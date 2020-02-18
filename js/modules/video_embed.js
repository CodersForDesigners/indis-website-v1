
/*
 *
 * This script handles embedding of videos
 *
 */

/*
 * Inject iframes into the video containers.
 * 	These iframes hold urls to the videos hosted on YouTube.
 */
function initialiseVideoEmbed ( domElement, videoId ) {
	var $iframe = $( "<iframe>" );
	var videoId = videoId || domElement.dataset.src;
	var attributes = {
		// Add the origin parameter
 		// This is to protect against malicious third-party JavaScript being
 		// injected into the page and hijacking control of the YouTube player.
		src: "https://www.youtube.com/embed/" + videoId + "?html5=1&color=white&disablekb=1&fs=0&autoplay=0&loop=0&modestbranding=1&playsinline=1&rel=0&showinfo=0&origin=" + location.origin,
		frameborder: 0,
		allow: "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture",
		allowfullscreen: ""
	};
	if ( $( domElement ).hasClass( "js_video_get_player" ) )
		attributes.src += "&enablejsapi=1&mute=1&controls=0";
	$iframe.attr( attributes );
	$( domElement ).append( $iframe );
}

function destroyVideoEmbed ( domElement ) {
	$( domElement ).find( "iframe" ).remove();
}

/*
 * Sets the containing iframe's src attribute
 * 	to what's in its equivalent data attribute
 */
function setVideoEmbed ( domEl ) {
	var $el = $( domEl );
	var src = $el.find( "iframe" ).data( "src" );
	if ( src )
		$el.find( "iframe" ).attr( "src", src );
}

/*
 * Unsets the containing iframe's src attribute to an empty value
 */
function unsetVideoEmbed ( domEl ) {
	var $el = $( domEl );
	var src = $el.find( "iframe" ).attr( "src" );
	$el.find( "iframe" ).data( "src", src );
}

/*
 *
 * Setup the YouTube Iframe API
 *
 */
function setupYoutubeIframeAPI () {

	// If there is a background YouTube embed, then
	// 1. Load the YouTube API library (asynchronously)
	//  	reference: https://developers.google.com/youtube/iframe_api_reference
	var scriptElement = document.createElement( "script" );
	scriptElement.src = "https://www.youtube.com/iframe_api";
	$( "script" ).last().after( scriptElement );

	// When the YouTube video player is ready, this function is run
	function onPlayerReady ( event ) {
		var $videoContainer = $( event.target.a ).closest( ".js_video_get_player" );
		$videoContainer.data( "player", event.target );
		if ( $videoContainer.data( "autoplay" ) === true )
			event.target.playVideo();
	}

	// Whenever the YouTube video player's state changes, this function is run
	function onPlayerStateChange ( event ) {
		var domVideo = event.target.a;
		var $video = $( domVideo );
		var $videoContainer = $video.closest( ".js_video_get_player" );
		var loopVideo = $videoContainer.data( "loop" ) === true;
		if ( event.data == YT.PlayerState.PLAYING )
			$videoContainer.find( ".video-embed-placeholder" ).addClass( "opacity-0" );
		if ( loopVideo && event.data == YT.PlayerState.ENDED )
			event.target.seekTo( 0 )
	}

	// This function needs to exposed as a global
	window.onYouTubeIframeAPIReady = function ( event ) {
		var players = { };
		$( document ).on( "youtube/player/create", function ( event, domVideo ) {
			players[ domVideo.id ] = new YT.Player( domVideo, {
				events: {
					onReady: onPlayerReady,
					onStateChange: onPlayerStateChange
				}
			} );
		} );
		$( document ).on( "youtube/player/destroy", function ( event, playerId ) {
			if ( players[ playerId ] )
				players[ playerId ].destroy();
		} );
	};

}
window.__BFS = window.__BFS || { };
window.__BFS.setupYoutubeIframeAPI = setupYoutubeIframeAPI;

/*
 * The first time a YouTube player is created, also set up the YouTube Iframe API
 */
$( document ).one( "youtube/player/create", function ( event, domVideo ) {

	// Only run this function **once**
	if ( window.__BFS.setupYoutubeIframeAPI ) {
		window.__BFS.setupYoutubeIframeAPI();
		window.__BFS.setupYoutubeIframeAPI = null;
	}

	$( document ).trigger( "youtube/player/create", domVideo );

} );

$( function () {

	// Wait for a bit
	waitFor( 3 )
		.then( function () {
			// Initialize, load and setup the video embeds and their players
			initialiseVideoEmbeds();
			setupYoutubePlayers();
		} )

} );
