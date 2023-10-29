<html lang="es">
	<head>
		<meta charset="utf-8">
   		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
		<script>
            function validateForm() {
                const fileInput = document.getElementById('file');
                const fileName = fileInput.value;
                const allowedExtensions = /(\.jpg|\.png|\.jpeg)$/i;
    
                if (!allowedExtensions.exec(fileName)) {
                    alert('Por favor, selecciona un archivo .jpg o .png válido.');
                    return false;
                }
                return true;
            }
        </script>
	</head>

	<body>
		
        <div class="container">    
            <h2>Generador de recetas</h2>

            <h4 class="mt-4">Subir Imagen</h4>
                <form action="reconocimiento.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                    <div class="form-group">
                        <label for="file">Seleccionar una imagen: </label>
                        <input type="file" class="form-control-file" name="file" id="file">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Subir Imagen</button>
                </form>
<!--            <button type="button" class="btn btn-primary tooltip-test" title="Con camara" >Sacar foto</button> -->
<!-- 			<a href="https://repuestosmr.ar/tomarFoto.php" class="btn btn-primary" title="Con camara">Sacar foto</a> -->
        </div>
	</body>
</html>