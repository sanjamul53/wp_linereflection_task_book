<?php

// $book_gallery = get_post_meta( 15, 'book_gallery', true );

// var_dump($book_gallery);

// var_dump( Bk5_ROOTURL . 'assets/books_page.js');

$categories = get_terms([
    'taxonomy' => 'book_category',
    'orderby' => 'name',
    'order' => 'ASC',
    'number' => 5
]);

// echo "<pre>";
// var_dump($categories);
// echo "</pre>";

$category_slug = 'detective';

$args = array(
    'post_type' => BK5\Inc\Init::get_instance()->cpt_name,
    'posts_per_page' => 5,
    'tax_query' => array(
        array(
            'taxonomy' => BK5\Inc\Init::get_instance()->cpt_tax,
            'field' => 'slug',
            'terms' => $category_slug,
        ),
    ),
);

$query = new WP_Query( $args );

if ( $query->have_posts() ) {
    echo '<ul>';
    while ( $query->have_posts() ) {
        $query->the_post();
        echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
    }
    echo '</ul>';
    wp_reset_postdata();
}