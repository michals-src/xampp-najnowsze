<!DOCTYPE html>
<html lang="pl">
   <head>
	  <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	  <meta http-equiv="Access-Control-Allow-Origin" content="*">
	  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" href="style.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

      <!-- If you are opening this page from local machine, uncomment belwo line 
       
	  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script> 
	  -->
	 
	 <!-- If you are opening this page from a web hosting server machine, uncomment belwo line -->
	 
	 <!-- <script type="text/javascript">
		document.write([
			"\<script src='",
			("https:" == document.location.protocol) ? "https://" : "http://",
			"ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js' type='text/javascript'>\<\/script>" 
		].join(''));
	  </script> -->


   <title>LED Controller</title>
    
   </head>
   <body>

   <div class="container">

   <?php 

   require_once 'db.class.php';

   if( ! class_exists("dbh") ){
   		echo "<h2>Błąd ładowania<0></h2>";
   		return;
   }


   	$db = new dbh();
   	$dbh = $db->getConnection();

   	if( $db->Exception() === true ){
   		echo "<h2>Błąd ładowania<1></h2>";
   		return;
   	}

   	function rgb2hex( $color ){
   		$color = str_replace( array( "R", "G", "B" ), array( "", ",", ","), $color );
   		$rgbarr = explode(",",$color,3);
		return sprintf("#%02x%02x%02x", $rgbarr[0], $rgbarr[1], $rgbarr[2]);
   	}

   	if( ! empty( $_POST['refresh'] ) ){
   		$new_time_settings = $_POST["time_settings"];
   		if( ! empty( $new_time_settings[0] ) && 
	   		! empty( $new_time_settings[1] ) && 
	   		! empty( $new_time_settings[2] ) ){

	   		$query = "UPDATE `oswietlenie` SET `time`=?";
	   		$time_refresh = $dbh->prepare( $query );
	   		$time_refresh->execute(array(
	   			strtotime( date("Y-m-d H:i:s", strtotime($new_time_settings[0]) ) )
	   		));
   		}	
   	}

   	$data = $dbh->query("SELECT * FROM oswietlenie");

   	if( ! $data->rowCount() ){
   		$query = "INSERT INTO `oswietlenie` (`availability`, `mode`, `color_settings`, `time_settings`, `time`) VALUES (?,?,?,?)";
   		$create = $dbh->prepare( $query );
   		$create->execute(array(
   			true, 
   			1, 
   			"R0G0B255",
   			json_encode(array("18:00", "02:00")),
   			date("Y-m-d H:i:s")
   		));
   	}


   	$properties = $data->fetch();
   	$availability = $properties["availability"];
   	$type = $properties["mode"];
   	$color_settings = $properties["color_settings"];
   	$time_settings = json_decode($properties["time_settings"]);


   	$colors = array( "R0G0B100", "R0G0B255", "R150G200B0", "R255G50B0", "R50G100B60", "R128G064B0" );


   ?>

   <div class="colors-container" id="colors">
   	   <div class="row">
   	   	<?php 

   	   		for( $x = 0; $x < count($colors); $x++ ):

   	   		$r = substr( $colors[$x], 1, strpos($colors[$x], 'G') - 1 );
   	   		$g = substr($colors[$x], strpos($colors[$x], 'G') + 1, (strpos($colors[$x], 'B') - strpos($colors[$x], 'G') )-1 );
   	   		$b = substr($colors[$x], strpos($colors[$x], 'B') + 1, (strlen($colors[$x]) - strpos($colors[$x], 'B')) );

   	   	?>
	   		<div class="col-2 text-center">
	   			<button class="btn-color <?php echo ($color_settings === $colors[$x]) ? 'active' : ''; ?>" style="background: rgba(<?php echo $r; ?>,<?php echo $g; ?>,<?php echo $b; ?>,1);" data-item="<?php echo $colors[$x]; ?>">Color</button>
	   		</div>
	   	<?php endfor; ?>
	   </div>
   </div>

   <div class="settings-container" id="settings">
   	<form method="post">
   		<div class="form-group row">
   			<div class="col-4">
   				<label>Status</label>
	   			<div class="custom-control custom-switch">
				  <input type="checkbox" class="custom-control-input" id="availability" class="availability"  <?php echo ($availability) ? "checked" : ""; ?>>
				  <label class="custom-control-label" for="availability">Włącz/Wyłącz</label>
				</div>
   			</div>
   			<div class="col-8">
   				<label>Tryb</label>
		   		<select name="type" class="form-control" id="mode">
		   			<option value="1" <?php echo ($type === '1') ? "selected" : ""; ?>>Własny kolor</option>
		   			<option value="2" <?php echo ($type === '2') ? "selected" : ""; ?>>Tęcza</option>
		   		</select>
   			</div>
	   	</div>
   		<div class="form-group row">
   			<div class="col-6">
   				<label>Godzina auto. włączenia</label>
   				<input type='time' name="time_settings[0]" class="form-control" value='<?php echo $time_settings[0]; ?>'>
   			</div>
   			<div class="col-6">
   				<label>Godzina auto. wyłączenia</label>
   				<input type='time' name="time_settings[1]" class="form-control" value='<?php echo $time_settings[1]; ?>'>
   			</div>
   		</div>
   		<button name="refresh" type="submit" class="btn btn-warning mt-3" value="true" style="width:100%;">Odśwież czas</button>
   	</form>   	
   </div>
   

   </div>


    </body>
    <script type="text/javascript">
    	(function($){
			
			var server = "esp8266.local";

			function hex2rgb(hex,opacity){
			    hex = hex.replace('#','');
			    r = parseInt(hex.substring(0,2), 16);
			    g = parseInt(hex.substring(2,4), 16);
			    b = parseInt(hex.substring(4,6), 16);

			    result = 'R'+r+'G'+g+'B'+b;
			    return result;
			}

    		var availability = "#availability";
    		var mode = "#mode";

    		//var colors = {};
    		var time = {};

    		$(".btn-color").on( "click", function(e){

    			e.preventDefault();

    			var current_color = $(this).attr('data-item');
    			var $this = $(this);

    			$.post( 'http://' + server + '/src_color/', {"color": current_color})
    				.done(function(e){
    					if(e.success == "true"){
    						$(".btn-color").removeClass('active');
    						$this.addClass('active');
    						$.get( '/update.php', {"switch":"colors","color": current_color});
    					}
    			});

    		});

    		// colors[0] = 'input[name="type_settings[0]"]';
    		// colors[1] = 'input[name="type_settings[1]"]';
    		// colors[2] = 'input[name="type_settings[2]"]';
    		// colors[3] = 'input[name="type_settings[3]"]';

    		time[0] = 'input[name="time_settings[0]"]';
    		time[1] = 'input[name="time_settings[1]"]';

    		$(availability).on( "change", function(e){

    			e.preventDefault();
    			var value = this.checked;
    			$.post( 'http://' + server + '/src_status/', {"availability":value})
    				.done(function(e){
    					if(e.success == "true"){
    						$.get( '/update.php', {"switch":"availability","value":value});
    					}
    			});

    		});

    		$(mode).on( "change", function(e){

    			e.preventDefault();
    			var value = $(this).val();

    			$.post( 'http://' + server + '/src_mode/', {"mode":value})
    				.done(function(e){
    					if(e.success == "true"){
    						$.get( '/update.php', {"switch":"mode","value":value});
    					}
    			});


    		});

    		// for( var x = 0 in colors ){
    		// 	$(colors[x]).on( "change", function(e){

	    	// 		e.preventDefault();
	    	// 		var index = $(this).attr("name").replace(/type_settings\[+(.*?)\]+/g,"$1");
	    			
	    	// 		var value0 = $(colors[0]).val();
	    	// 		var value1 = $(colors[1]).val();
	    	// 		var value2 = $(colors[2]).val();
	    	// 		var value3 = $(colors[3]).val();

	    	// 		$.post( 'http://10.0.0.10/src_color/', {"color1":hex2rgb(value0),"color2":hex2rgb(value1),"color3":hex2rgb(value2),"color4":hex2rgb(value3)})
	    	// 			.done(function(e){
	    	// 				if(e.success == "true"){
	    	// 					$.get( '/update.php', {"switch":"colors","color0":value0,"color1":value1,"color2":value2,"color3":value3});
	    	// 				}
	    	// 		});


	    	// 	});
    		// }

    		for( var x = 0 in time ){
    			$(time[x]).on( "change", function(e){

	    			e.preventDefault();
	    			//var index = $(this).attr("name").replace(/type_settings\[+(.*?)\]+/g,"$1");
	    			
	    			var value0 = $(time[0]).val();
	    			var value1 = $(time[1]).val();

	    			$.get( '/update.php', { "switch":"time"," time0":value0, "time1":value1 });

	    		});
    		}

    	})(jQuery);
    </script>
</html>