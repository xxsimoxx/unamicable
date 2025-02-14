<?php Backdrop\Pagination\display( 'posts', [
	'container_class' => 'pagination pagination--%s clear my-16 text-center font-secondary',
	'list_class'      => 'pagination__items list-none inline-block m-0 p-0',
	'item_class'      => 'pagination__item pagination__item--%s sm:inline-block mr-3 text-sm font-700',
	'anchor_class'    => 'pagination__anchor pagination__anchor--%s block leading-none py-3 px-4 no-underline',
	'prev_text'       => __( '&larr; Previous', 'amicable' ),
	'next_text'       => __( 'Next &rarr;', 'amicable' ),
	'title_text'      => __( 'Posts Navigation', 'amicable' )
] );