<?php
	
	if( empty( $_GET['id'] ) ){
		wp_die( print_r( 'Nie znaleziono użytkownika.' ) );
		return;
	}

	$ids = explode( ',', $_GET['id'] );

	$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
	$user_query = new WP_User_Query(array(
		'number' => 8,
		'meta_key' => 'public_id',
		'meta_value' => $ids,
		'orderby' => 'public_id',
		'order' => 'DESC',
		'fields' => array( 'ID', 'user_login', 'user_registered' )
	));

	$users = $user_query->get_results();

	if( empty( $users ) ){
		wp_die( print_r( 'Nie znaleziono użytkownika.' ) );
	}

?>
<div class="row">

<?php
	foreach ( $users as $key => $user):

	$first_name = get_user_meta( $user->ID, 'first_name' )[0];
	$last_name = get_user_meta( $user->ID, 'last_name' )[0];

	$offset = ( ( ($key + 1) % 2 ) === 0 ) ? 'offset-2' : '';
?>


	<div class="col-5 mb-5 <?php echo $offset; ?>" style="padding:40px;border: 1px solid #aaa;">
		<div class="p-2" style="border-radius:3px;">
			<div style="text-align:center;width:100%;">
				<?php echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($ids[$key], $generator::TYPE_EAN_8, 30, 400)) . '">'; ?>
				<p style="font-size: 18px;margin-top: 10px;">
					<?php echo $first_name . ' ' . $last_name . ' ' . $ids[$key]; ?>
				</p>
				<div class="mt-3">
					<p style="margin-bottom: 0;">Login: <?php echo $user->user_login; ?></p>
				</div>
			</div>
		</div>
	</div>

<?php endforeach; ?>

</div>
