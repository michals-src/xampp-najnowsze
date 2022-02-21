<div id="p-0">

    <div class="mb-3"><h5><strong>Skaner</strong></h5></div>
    <div id="sf-dashboard-settings" class="list-group">
	
	<div class="row">
	  <div class="form-group col-7">
	    <label>Data zapisu</label>
	    <div>
	    	<?php $current_date = date("Y-m-d"); ?>
		    <input class="form-control form-control-sm" type="date" name="sf_scanner_date" value="<?php echo $current_date; ?>">
		    <small class="form-text text-muted">Data z którą najnowsza aktywność ( np. wejście klienta) będzie zarejestrowana w systemie.</small>	
	    </div>
	  </div>	  
	  <div class="form-group col-5">
	    <label>Godzina</label>
	    <div>
		    <input class="form-control form-control-sm" type="time" name="sf_scanner_time" value="<?php echo date("H:i:s"); ?>">
	    </div>
	  </div>
	  <input type="hidden" name="scanning-data" data-item='<?php echo json_encode(sf_manager_ajax_data( 'client_manager_monitor_add_nonce', 'sf_manager_client_manager_monitor_add' ))?>' >
	</div>

	  <div class="mt-3" style="width: 100%">

	  	<div class="row">
	  		<div class="col-3"><p>Ostatnia akcja</p></div>
	  		<div class="col-9"><div class="monitor-last-messages"><p>Brak</p></div></div>
	  	</div>

	  	<div class="mt-4 mb-4">
	  		<div id="interactive" class="viewport"></div>
	  	</div>

	  	<div class="card border-dark mb-3">
		  <div class="card-header">Logi</div>
		  <div class="card-body text-dark">
		    <div class="monitor-messages-container mb-3 overflow-auto p-3" style="height: 150px;background-color: #eee;">
		    	<div class="monitor-messages-list"></div>
			</div>
		  </div>
		</div>
	  	<button id="fake-scanning" role="submit" class="btn btn-primary" style="width:inherit;">
			Fałszywe skanowanie
		</button>

	  </div>
	</div>

</div>