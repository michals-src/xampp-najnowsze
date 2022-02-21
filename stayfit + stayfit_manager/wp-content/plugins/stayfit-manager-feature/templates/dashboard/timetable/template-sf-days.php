<?php 

if( ! defined( "ABSPATH" ) ){
    exit;
}

foreach( sf_manager_timetable_days() as $day => $props ): ?>
<li id="sf-dashboard-settings-item" class="sf-dashboard-settings-item-<?php echo $day; ?> list-group-item list-group-item-action p-0" 
    data-item='<?php echo json_encode(sf_manager_timetable_day_data( $day, $props["status"], $props['schedule'], 'sf_manager_timetable_get_day_content', 'sf_manager_timetable_day_content_nonce' )); ?>'>
    <a href="#" class="sf-dashboard-settings-item-view d-flex justify-content-between align-items-center px-4 py-2">
        <?php echo ucfirst($day); ?> 
        <span>
            <?php if( false === $props["status"] ): ?>
                <div class="spinner-grow spinner-grow-sm text-danger" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            <?php endif; ?>
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
<?php endforeach;?>