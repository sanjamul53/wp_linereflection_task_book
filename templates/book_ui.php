<?php

$filter_key = 'book_category';
$current_term = null;

// category list
$categories = get_terms([
    'taxonomy' => 'book_category',
    'orderby' => 'name',
    'order' => 'ASC',
    'number' => 5
]);

// get the current slug
if(isset($_GET[$filter_key]) && $_GET[$filter_key]) {
    $current_term = $_GET[$filter_key];
}



$args = array(
    'post_type' => BK5\Inc\Init::get_instance()->cpt_name,
    'posts_per_page' => 5
);

if($current_term) {

    $args['tax_query'] = array(
        array(
            'taxonomy' => BK5\Inc\Init::get_instance()->cpt_tax,
            'field' => 'slug',
            'terms' => $current_term,
        ),
    );
}


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


?>

<?php get_header(); ?>

<div id="main_content">

    <h1 class="title" > Design Sample </h1>

    <?php if(!empty( $categories ) && ! is_wp_error( $categories )): ?>

        <div class="cat_list">

            <div class="cat_item"
                onclick="cat_click_all_handler()"
            >
                All
            </div>

            <?php foreach($categories as $cat): ?>

                <div class="cat_item" termid="<?php echo $cat->slug; ?>"
                    onclick="cat_click_handler(this)"
                >
                    <?php echo $cat->name; ?>
                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

    <div class="book_list">

        <?php if( $query->have_posts()): 
        while( $query->have_posts()){
            $query->the_post();
        ?>

            <div class="book_item">
                <?php 
                    if (has_post_thumbnail() ) {
                        echo '<a href="' . get_permalink() . '">' . 
                            get_the_post_thumbnail( get_the_ID(), 'thumbnail', array( 'class' => 'book_item_img' ) ) . 
                        '</a>';
                    }
                ?>
            </div>

        <?php
            }
        endif; 
        ?>

    </div>

</div>

<?php get_footer(); ?>

