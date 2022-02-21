<?php

function bbb_block(){
    wp_register_script('custom-bbb-js', get_template_directory_uri() . '/build/index.js', array('wp-blocks'));

    register_block_type('bbb/custom-b', array(
        'editor_script' => 'custom-bbb-js'
    ));
}
add_action('init','bbb_block');