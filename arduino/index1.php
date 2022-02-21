<!DOCTYPE html>
<html lang="pl">
   <head>
	  <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	  <meta http-equiv="Access-Control-Allow-Origin" content="*">
	  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
     
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
	  

   <title>ESP 8266 Node MCU Web APP LED Control</title>
      
   </head>
   <body style="padding-top: 50px;padding-bottom: 50px;">
abc
   	<div class="msg"></div>
    </body>
    <script type="text/javascript">
    	(function($){

			$.ajax({
			    url: "http://10.0.0.10/postplain/",
			    data: {"hello": "world"},
			    type: 'POST',
			    crossDomain: true,
			    dataType: 'json',
			    success: function(e) { $('.msg').html(e.success) },
			    error: function() { alert('Failed!'); },
			});


    	})(jQuery);
    </script>
    
<!-- 	<script>
		document.getElementById('D1-on').addEventListener('click', function() {
				var url = "https://monker.000webhostapp.com/api/led/update.php?id=1&status=on";
				$.getJSON(url, function(data) {
					console.log(data);
				});
		});
		
		document.getElementById('D1-off').addEventListener('click', function() {
				var url = "https://monker.000webhostapp.com/api/led/update.php?id=1&status=off";
				$.getJSON(url, function(data) {
					console.log(data);
				});
		});
		
		
		document.getElementById('D2-on').addEventListener('click', function() {
				var url = "https://monker.000webhostapp.com/api/led/update.php?id=2&status=on";
				$.getJSON(url, function(data) {
					console.log(data);
				});
		});
		
		document.getElementById('D2-off').addEventListener('click', function() {
				var url = "https://monker.000webhostapp.com/api/led/update.php?id=2&status=off";
				$.getJSON(url, function(data) {
					console.log(data);
				});
		});
		
		
		document.getElementById('D3-on').addEventListener('click', function() {
				var url = "https://monker.000webhostapp.com/api/led/update.php?id=3&status=on";
				$.getJSON(url, function(data) {
					console.log(data);
				});
		});
		
		document.getElementById('D3-off').addEventListener('click', function() {
				var url = "https://monker.000webhostapp.com/api/led/update.php?id=3&status=off";
				$.getJSON(url, function(data) {
					console.log(data);
				});
		});

		
	</script> -->
</html>