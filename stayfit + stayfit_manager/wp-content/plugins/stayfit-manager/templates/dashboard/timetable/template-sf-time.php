<?php 

if( ! defined( "ABSPATH" ) ){
    exit;
}

?>
<div id="sf-dashboard-settings" class="list-group">
<?php if( taxonomy_exists( 'timetable-time' ) ): ?>
<?php if( ! empty( sf_manager_timetable_get_time() ) ): 
    foreach( sf_manager_timetable_get_time() as $time_key => $props ): ?>    
		
        <li id="sf-dashboard-settings-item" class="sf-dashboard-settings-item-<?php echo $props->term_id; ?> list-group-item list-group-item-action p-0" 
            data-item='<?php echo json_encode(sf_manager_timetable_time_data( $props->term_id, "sf_manager_timetable_get_time_content", "sf_manager_timetable_time_get_content_nonce" )); ?>'>
            <a href="#" class="sf-dashboard-settings-item-view d-flex justify-content-between align-items-center px-4 py-2">
                <?php echo $props->name; ?> 
                <span>
                    <span class="badge badge-primary badge-pill">Edytuj</span>
                </span>

            </a>
            <div class="sf-dashboard-settings-item-container px-4 py-3" style="display:none;">
                <div id="status-icon" class="d-flex justify-content-center">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="sf-dashboard-settings-item-content px-4 py-3" style="display:none;">
                </div>
            </div>
        </li>

<?php endforeach; ?>
<?php else: ?>
		<li class="list-group-item">
            <p>Obecnie nie dodano godzin zajęć.</p>
        </li>
<?php endif; ?>       
		<li class="list-group-item pb-4">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-4">Nowa godzina zajęć</h5>
            </div>
            <?php echo sf_manager_timetable_time_create_form(); ?>
        </li>
<?php else: ?>
	<p>Kreator dodawania zajęć jest obecnie niedostępny. <strong>Error: Taxonomy not exists.</strong></p>
<?php endif; ?>
</div>
