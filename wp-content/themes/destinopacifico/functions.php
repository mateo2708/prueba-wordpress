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
function featured_images_endpoint() {
    $cat = get_category_by_slug('slider');
    $args =array(
        'post_type' => 'post',
        'category' => $cat->cat_ID
    );
    $posts = get_posts($args);
    foreach ($posts as $key => $post){
        $posts[$key] = get_the_post_thumbnail_url($post->ID);
    }
    return $posts;
}
function get_image_src( $object, $field_name, $request ) {
    if($object[ 'featured_media' ] == 0) {
        return $object[ 'featured_media' ];
    }
     $feat_img_array = wp_get_attachment_image_src( $object[ 'featured_media' ], 'thumbnail', true );
    return $feat_img_array[0];
}
add_action( 'rest_api_init', function () {
    register_rest_route( 'sections/v1', '/destinos/', array(
        'methods' => 'GET',
        'callback' => 'destinos_endpoint'
    ));
    register_rest_route('featured/v1','/images/',array(
        'methods' => 'GET',
        'callback' => 'featured_images_endpoint'
    ));
    register_rest_field('post',"featured_image_src", array(
        'get_callback'      => 'get_image_src',
        'update_callback'   => null,
        'schema'            => null
    ));
});

add_theme_support('post-thumbnails');

function my_acf_init() {
	
	acf_update_setting('google_api_key', 'AIzaSyDz-YNyHAeFHxgymnA_oSjzbaMA2RTCl04');
}

add_action('acf/init', 'my_acf_init');