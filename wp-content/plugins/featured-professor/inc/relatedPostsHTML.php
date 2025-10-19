<?php
function relatedPostsHTML($id) {
    $id = (int) $id; // sanitize

    $postsAboutThisProf = new WP_Query( array(
        'posts_per_page' => -1,
        'post_type'      => 'post',
        'meta_query'     => array(
            array(
                'key'     => 'featuredProfessor',
                'value'   => $id,
                'compare' => '=',
                'type'    => 'NUMERIC',
            ),
        ),
    ) );

    ob_start();

    $prof_name = get_the_title( $id );

    if ( $postsAboutThisProf->have_posts() ) {
        echo '<p>' . esc_html( $prof_name ) . ' is mentioned in the following posts:</p>';
        echo '<ul>';

        while ( $postsAboutThisProf->have_posts() ) {
            $postsAboutThisProf->the_post();
            printf(
                '<li><a href="%s">%s</a></li>',
                esc_url( get_permalink() ),
                esc_html( get_the_title() )
            );
        }

        echo '</ul>';
    }

    wp_reset_postdata();

    return ob_get_clean();
}
