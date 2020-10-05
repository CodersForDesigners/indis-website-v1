<?php

if ( class_exists( '\BFS\CMS' ) )
	\BFS\CMS::$currentQueriedPostACF = array_merge( \BFS\CMS::$currentQueriedPostACF, get_fields() );

?>
<?php if ( $is_preview ) : ?>
<div>
	<p>Project Engineering</p>
</div>
<?php else : ?><?php endif; ?>
