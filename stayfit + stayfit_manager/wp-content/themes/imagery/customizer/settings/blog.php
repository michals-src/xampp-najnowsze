<?php
/**
 * @package Imagery
 */
function imagery_customizer_blog_posts( $options ) {
	/**
	 *	Add Section.
	 *--------------------------------------------------------------*/
	$options[] = array(
		  'slug'        => 'blog_post_settings',
		  'opt_type'    => 'section',
		  'name'        => esc_html__( 'Blog Posts', 'imagery' ),
		  'description' => esc_html__( 'Here the view of posts options at the home / archives blog page.', 'imagery' ),
		  'priority'    => 109,
	);

	/**
	 * Options
	 *--------------------------------------------------------------*/

	# Blog Page Title.
	$options[] = array(
		  'slug'        => 'blog_page_title',
		  'opt_type'    => 'text',
		  'name'        => esc_html__( 'Posts page Title', 'imagery' ),
		  'default'     => '',
		  'section'     => 'blog_post_settings',
		  'transport'   => 'refresh',
	);

	# Blog Intro text.
	$options[] = array(
		  'slug'        => 'blog_page_description',
		  'opt_type'    => 'textarea',
		  'name'        => esc_html__( 'Posts page Description', 'imagery' ),
		  'default'     => '',
		  'section'     => 'blog_post_settings',
		  'transport'   => 'refresh',
	);
	
	# Blog grid.
	$options[] = array(
		  'slug'        => 'home_posts_columns',
		  'opt_type'    => 'radio',
		  'section'     => 'blog_post_settings',
		  'default'     => 'two',
		  'name'        => esc_html__( 'Home Posts Grid', 'imagery' ),
		  'choices'     => array(
			  'two'     => esc_html__( '2 Columns', 'imagery' ),
			  'three'   => esc_html__( '3 Columns', 'imagery' ),
		)
	);
	
	# Archives grid.
	$options[] = array(
		  'slug'        => 'archive_posts_columns',
		  'opt_type'    => 'radio',
		  'section'     => 'blog_post_settings',
		  'default'     => 'two',
		  'name'        => esc_html__( 'Archive Posts Grid', 'imagery' ),
		  'choices'     => array(
			  'two'     => esc_html__( '2 Columns', 'imagery' ),
			  'three'   => esc_html__( '3 Columns', 'imagery' ),
		)
	);

	# Notice about post preview meta options.
	$options[] = array(
		  'slug'        => 'post_preview_notice',
		  'opt_type'    => 'simple_notice',
		  'name'        => esc_html__( 'Meta info of a Post Preview', 'imagery' ),
		  'description' => esc_html__( 'Applied to preview posts on the blog page.', 'imagery' ),
		  'section'     => 'blog_post_settings',
		  'sanitize_cb' => 'imagery_text_sanitization',
	);

	# Meta info Options.
	$post_settings = array(
		  'hide_post_preview_date'      => esc_html__( 'Hide Date', 'imagery' ),
		  'hide_post_preview_author'	=> esc_html__( 'Hide Author', 'imagery' ),	);
	foreach( $post_settings as $key => $name ) {
		$options[] = array(
			  'slug'        => $key,
			  'opt_type'    => 'checkbox',
			  'name'        => $name,
			  'default'     => 0,
			  'section'     => 'blog_post_settings',
		);
	}
	
	# Preview Titles.
	$options[] = array(
		  'slug'        => 'preview_titles',
		  'opt_type'    => 'text_radio_button',
		  'choices'		=> array(
							'display' => esc_html__( 'Yes', 'imagery' ),
							'hidden' => esc_html__( 'No', 'imagery' )
						),
		  'name'        => esc_html__( 'Does the title of a post preview always show?', 'imagery' ),
		  'default'     => 'hidden',
		  'section'     => 'blog_post_settings',
		  'transport'   => 'refresh',
		  'sanitize_cb' => 'imagery_text_sanitization',
	);
	
	return $options;
}
add_filter( 'imagery_settings_input', 'imagery_customizer_blog_posts' );