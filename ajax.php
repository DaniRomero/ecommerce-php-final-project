<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<?php 
	
		function guardar_canvas(){
			$link = @mysql_connect('localhost', 'dacero', '23624323dani')
			or die('No se pudo conectar: ' . mysql_error());
			//echo 'Connected successfully';
			mysql_select_db('db_comercio');
			//$query = "INSERT INTO canvas VALUES("
		}	

	?>

    <canvas id="canvas" width=300 height=300></canvas>
    <button onclick="guardar_canvas()"> Guardar </button>

    <script src="http://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.5.0/fabric.min.js"></script>
    <script>
        var canvas = new fabric.Canvas('canvas');

        var rect = new fabric.Rect({
            top : 100,
            left : 100,
            width : 60,
            height : 70,
            fill : 'red'
        });

        canvas.add(rect);

	var dataURL = canvas.toDataURL();
	alert(dataURL)

	function guardar_canvas(){
		$.ajax({
			type: "POST",
			url: 'ajax.php',
			data: dataURL,
			success: function(){
				alert("added")
			},
			error: function(err){
				alert(err)
			}
		});
	}

    </script>
</body>
</html>