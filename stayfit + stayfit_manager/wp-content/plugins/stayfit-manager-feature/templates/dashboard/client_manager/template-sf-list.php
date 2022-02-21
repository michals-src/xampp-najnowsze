<div id="p-0">

    <div id="sf-dashboard-settings" class="list-group">

    		<?php

    			$no = 8;
    			$paged = (get_query_var('sf_paged')) ? (int)get_query_var('sf_paged') : 1;
			    if($paged==1){
			      $offset=0;  
			    }else {
			       $offset= ($paged-1)*$no;
			    }

			    $query = array(
			    	'orderby' => 'user_registered',
			    	'order' => 'DESC',
    				'role' => 'subscriber',
    				'fields' => array( 'ID' ),
    				'number' => $no,
    				'offset' => $offset
    			);

    			if( ! empty( $_GET['search'] ) ){

    				$name_explode = explode( " ", $_GET['search'] );
    				$first_name = $name_explode[0];
    				$last_name = $name_explode[1];

	    			$query["meta_query"] = array(
					    'relation' => 'AND',
					     array(
					        'key' => 'first_name',
					        'value' => $first_name,
					        'compare' => 'LIKE'
					     ),
					     array(
					        'key' => 'last_name',
					        'value' => $last_name,
					        'compare' => 'LIKE'
					    )
					);
    			}


    			$user_query = new WP_User_Query( $query );

    			$users = $user_query->get_results();

    			if( empty( $users ) ){
    				echo 'Brak użytkowników.';
    			}

    			$ids = array_map(function($user){
    				return get_user_meta( $user->ID, 'public_id' )[0];
    			}, $users);

    		?>


    	<div>
    		<h6><strong>Wyszukiwanie osoby</strong></h6>
    	</div>
		<form action="<?php echo get_home_url(); ?>/panel/klienci/lista" method="GET">
			<input type="hidden" name="page" value="client_manager.lista">
			<div class="input-group">
			  <input type="text" name="search" class="form-control" placeholder="Imię nazwisko lub numer karnetu">
			  <div class="input-group-append">
			    <button role="submit" type="submit" class="btn btn-primary">Szukaj</button>
			  </div>
			</div>
			<div class="text-muted mb-2">
		    </div>
		</form>

<!-- 		<div class="mt-2 mb-2">
	        <div class="alert alert-primary" style="border-radius:5px">
	        	<a href="<?php echo get_home_url(); ?>/print?id=<?php echo join(',', $ids); ?>" target="_blank">
                    <span style="display: inline-table;vertical-align: middle;font-size:20px;margin-right: 8px;padding-top: 2px;"><ion-icon name="print"></ion-icon></span>
                    Informacje do druku
                </a>
	        </div>
		</div> -->

		<div><h3><strong>Lista klientów</strong></h3></div>
		<div class="mb-2">
			<p>W celu edycji danych osobowych klienta należy kliknąć na wybraną osobę z listy.</p>
		</div>
		<form action="<?php echo get_home_url(); ?>/panel/klienci/lista" method="GET">
			<!-- <input type="hidden" name="page" value="client_manager.lista"> -->
			<div class="row">
				<div class="col-3 d-flex align-items-center"><label class="m-0">Sortuj według</label></div>
				<div class="col-9">
					<select class="custom-select" name="sort">
					  <option value="alphbetic">Alfabetycznie</option>
					  <option value="create_newest">Daty założenia (najnowsze)</option>
					  <option value="create_oldest">Daty założenia (najstarsze)</option>
					  <option value="entry_newest">Najnowszych wejśc</option>
					  <option value="entry_oldest">Najstarszych wejść</option>
					</select>
				</div>
			</div>
		</form>
    	<div class="row">
    		<?php foreach( $users as $user ): 

		    	$first_name = get_user_meta( $user->ID, 'first_name' );
		    	$last_name = get_user_meta( $user->ID, 'last_name' );
		    	//$public_id = get_user_meta( $user->ID, 'public_id' );

    		?>
    			<div class="col-6" style="margin-bottom: 15px;">
	    			<a href="<?php echo get_permalink(); ?>?p=client_manager.person&id=<?php echo $user->ID; ?>" style="text-decoration: none;">
		    			<div class="card" style="margin-bottom: -1px;">
		  					<div class="card-body row">
		  						<div class="col-1">
		  							<span><ion-icon name="contact" style="margin-bottom:-5px;margin-right:8px;font-size:22px;"></ion-icon></span>
		  						</div>
			  					<div class="col-8">
			    					<strong><?php echo $first_name[0] . ' ' . $last_name[0]; ?></strong>
			  					</div>
			    				<div class="col-3 text-right">
			    					<ion-icon name="create" style="font-size: 20px;"></ion-icon>
			    				</div>
			    				<div class="col-12 offset-1">
			    					<p class="m-0" style="font-size:14px;">Ostanie wejście
			    						<span>x dni temu</span>
			    					</p>
			    				</div>
			    			</div>
			    		</div>
			    	</a>
			    </div>
    		<?php endforeach; ?>

    		<?php
	            $total_user = $user_query->total_users;  
	            $total_pages=ceil($total_user/$no);

	            $pages = paginate_links(array(  
						'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
						'format'       => '?sf_paged=%#%',
						'current'      => max( 1, (int) get_query_var( 'sf_paged' ) ),
						'total'        => $total_pages,
						'type'         => 'array',
						'show_all'     => false,
						'end_size'     => 3,
						'mid_size'     => 1,
						'prev_next'    => false,
						'add_args'     => false,
						'add_fragment' => ''
	                ));

	            if( empty( $pages ) ){
	            	$pages = array();
	            }

			?>

    	</div>

<nav aria-label="Page navigation example" style="margin-top: 25px;">
  <ul class="pagination justify-content-center">
				
				<?php 

				foreach ($pages as $page) {
                        echo '<li class="page-item' . (strpos($page, 'current') !== false ? ' active' : '') . '"> ' . str_replace('page-numbers', 'page-link', $page) . '</li>';
                }

				?>

  </ul>
</nav>

	</div>

</div>