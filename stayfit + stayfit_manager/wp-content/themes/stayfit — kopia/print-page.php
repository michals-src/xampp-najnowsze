<?php
/**
* Template Name: Full Width Page
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/

?>

<!DOCTYPE html>
<html>
<head>
	<?php wp_head(); ?>
	<style type="text/css">
		body,html{
			height:297mm;
    		width:210mm;
			background: #fff;
			background-color: #fff;
			font-family: "Times New Roman", sans-serif;
			padding: 15px;
		}
	</style>
</head>
<body>

	<?php
		while ( have_posts() ) : the_post();

			the_content();

		endwhile; // End of the loop.
	?>

<?php wp_footer(); ?>
</body>
</html>

