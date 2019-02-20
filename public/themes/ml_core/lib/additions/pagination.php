<?php
// Numbered Pagination
function pagination( $custom_query, $pagesNum = 0, $range = 2 ) {
    $showitems = ( $range * 2 ) + 1;

    global $paged;
    if ( empty( $paged ) ) {
        $paged = 1;
    }

    if ( $pagesNum == 0 ) {
        $pagesNum = $custom_query->max_num_pages;
        if ( ! $pagesNum ) {
            $pagesNum = 1;
        }
    }

    if ( 1 != $pagesNum ) : ?>
        <ul class='pagination'>
            <?php if ( $paged > 1 && $pagesNum > 1 ) :
                // Setting previous page arrow //
                ?>
                <li class="pagination-prev">
                    <a title="Previous Page"
                       href="<?php echo removeTrailingSlash( get_pagenum_link( $paged - 1 ) ); ?>">
                        <span class="icon-arrowLeft">
                            <span class="invisible" aria-hidden="true">Previous Page</span>
                        </span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( $paged > 2 && $paged > $range + 1 && $showitems < $pagesNum ):
                // Setting first page number //
                ?>
                <li>
                    <a href="<?php echo removeTrailingSlash( get_pagenum_link( 1 ) ); ?>">1</a>
                </li>
            <?php endif; ?>
            <?php if ( $paged > 3 && $paged > $range + 2 && $showitems < $pagesNum ) :
                // Setting Ellipsis between first number and current range //
                ?>
                <li aria-hidden="true">
                    <a>&hellip;</a>
                </li>
            <?php endif; ?>

            <?php for ( $i = 1; $i <= $pagesNum; $i ++ ) :
                // Listing page range //
                if ( 1 != $pagesNum && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pagesNum <= $showitems ) ) :
                    if ( $paged == $i ) : ?>
                        <li class="selected">
                            <a><?php echo $i; ?></a>
                        </li>
                    <?php else : ?>
                        <li>
                            <a href="<?php echo removeTrailingSlash( get_pagenum_link( $i ) ); ?>"
                               class='inactive'><?php echo $i; ?></a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ( $paged < $pagesNum - 3 && $paged + $range - 2 < $pagesNum && $showitems < $pagesNum ) :
                // Setting Ellipsis between last number and current range //
                ?>
                <li aria-hidden="true">
                    <a>&hellip;</a>
                </li>
            <?php endif; ?>
            <?php if ( $paged < $pagesNum - 2 && $paged + $range - 2 < $pagesNum && $showitems < $pagesNum ) :
                // Setting last page number //
                ?>
                <li>
                    <a href="<?php echo removeTrailingSlash( get_pagenum_link( $pagesNum ) ); ?>"><?php echo $pagesNum; ?></a>
                </li>
            <?php endif; ?>
            <?php if ( $paged < $pagesNum && $pagesNum > 1 ) :
                // Setting next page arrow //
                ?>
                <li class="pagination-next">
                    <a title="Next Page" href="<?php echo removeTrailingSlash( get_pagenum_link( $paged + 1 ) ); ?>">
                        <span class="icon-arrowRight">
                            <span class="invisible" aria-hidden="true">Next Page</span>
                        </span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    <?php
    endif;
}
