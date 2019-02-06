<?php
function  destinos_endpoint( $request_data ) {
    $args = array(
        'post_type' => 'destinos',
        'posts_per_page'=>-1, 
        'numberposts'=>-1
    );
    $posts = get_posts($args);
    foreach ($posts as $key => $post) {
        $posts[$key]->acf = get_fields($post->ID);
    }
    return  $posts;
}
add_action( 'rest_api_init', function () {
    register_rest_route( 'sections/v1', '/destinos/', array(
        'methods' => 'GET',
        'callback' => 'destinos_endpoint'
    ));
});
