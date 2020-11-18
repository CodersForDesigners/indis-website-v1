
( function () {

// This condition prevents the block from being registered in time before all the blocks are parsed, hence omitted
// if ( wp.data.select( "core/editor" ).getCurrentPostType() !== "projects" )
// 	return;









// BEGINNING
const { groupBy } = lodash;

const { select, dispatch, withSelect, withDispatch, useSelect, useDispatch } = wp.data;
const { createElement: el } = wp.element;
const { Fragment } = wp.element;
const { useState, useEffect } = wp.element;

const { registerBlockType } = wp.blocks;

const { TabPanel, HorizontalRule } = wp.components;

registerBlockType( "bfs/construction-update-listing", {
	title: "Construction Update Listing",
	description: "Returns the contruction updates associated with this post",
	icon: "bank",
	category: "common",
	attributes: {
		className: {
			type: "string",
			default: ""
		}
	},
	edit: constructionUpdateListingBlockEditor,
	// save () { return null; }
} );

function PostsComponent ( { postId, posts } ) {

	// Fallback UI if posts are being fetchec
	if ( ! posts )
		return el( "p", { }, "Fetching construction updates..." );

	let AddUpdate = el( "p", { }, el( "a", { target: "_blank", href: location.origin + "/cms/wp-admin/post-new.php?post_type=update" + ( postId ? `&parent=${ postId }` : "" ) }, "Add an update." ) );

	// Fallback UI if no posts exist
	if ( ! posts.length )
		return el( Fragment, { },
			el( "p", { }, "This project has no updates yet." ),
			AddUpdate
		);

	// If posts exist,
	// Prep the data
	let monthIndexMap = { "1": "January", "2": "February", "3": "March", "4": "April", "5": "May", "6": "June", "7": "July", "8": "August", "9": "September", "10": "October", "11": "November", "12": "December" };
	posts = posts.map( function ( post ) {
		let date = new Date( post.date_gmt + ".000Z" );
		let monthInWords = monthIndexMap[ date.getMonth() + 1 ];
		return {
			...post,
			yearPublished: date.getFullYear(),
			monthInWords
		}
	} );
	postsByYear = Object.entries( groupBy( posts, "yearPublished" ) ).sort( ( a, b ) => a[ 0 ] < b[ 0 ] ? 1 : -1 );
	// Now, render
	return el( Fragment, { },
		postsByYear.map( function ( [ year, posts ] ) {
			return el( Fragment, { },
				el( "h3", { key: year }, year ),
				posts.map( ( post, index ) => {
					return el( Fragment, { },
						el( "a", { target: "_blank", href: location.origin + "/cms/wp-admin/post.php?post=" + post.id + "&action=edit" }, post.monthInWords ),
						( index !== posts.length - 1 ) ? " · " : null
					)
				} ),
				el( HorizontalRule )
			)
		} ),
		AddUpdate
	);
}
function constructionUpdateListingBlockEditor ( { className } ) {
	let { postId, posts } = useSelect( function ( select ) {
		return {
			postId: select( "core/editor" ).getEditedPostAttribute( "id" ),
			posts: select( "core" ).getEntityRecords( "postType", "update", {
				parent: select( "core/editor" ).getEditedPostAttribute( "id" ),
				// parent: 187,
				per_page: -1,
				order: "desc",
				_fields: "id,title,date,date_gmt"
			} )
		}
	} );
	return el( "div", { className },
		el( "h2", { }, "Construction Updates" ),
		el( PostsComponent, { postId, posts } )
	);
}









}() );
