
wp.domReady( function () {

	let postType = wp.data.select( "core/editor" ).getCurrentPostType();
	let allowedBlocks = [
		"core/paragraph",
		"core/image",
		"core/heading",
		"core/subhead",
		"core/quote",
		"core/gallery",
		"core/list",
		"core/group",
		"core/separator",
		"core/spacer",
		"acf/bfs-for-the-geek-in-you"
	];

	wp.blocks.getBlockTypes()
		.map( block => block.name )
		.forEach( function ( block ) {
			if ( ! allowedBlocks.includes( block ) )
				wp.blocks.unregisterBlockType( block );
		} );

} );
