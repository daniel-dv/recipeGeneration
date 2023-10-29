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
            <p class="lead">
      			Generador de recetas
    		</p>
    		
			<div class="row">
				<div class="col-md-6">
                    <!-- Mostrar la imagen subida -->
                    <?php
                    if(isset($_POST['submit'])){
                        if(isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK){
                            $file = $_FILES['file'];
                            if($file['type'] == 'image/jpeg' || $file['type'] == 'image/png' || $file['type'] == 'image/jpg'){
                                $targetDirectory = "uploads/";
                                $targetFile = $targetDirectory . basename($file['name']);
                                if(move_uploaded_file($file['tmp_name'], $targetFile)){
                                    echo '<h2 class="mt-4">Imagen Subida:</h2>';
                                    echo '<img src="' . $targetFile . '" class="img-fluid" width="400" >';
                                }
                                
                            }
                        }
                    }
                    ?>
                    
                </div> 
                <div class="col-md-6">
                	<?php 
                    //llamar a API de reconocimiento de imagenes
                	$ingredientes =array("tomato","lechuga","huevo","milanesa");
                	?>
            
        			<form action="prediccion.php" method="post">
        				<?php
        				for($i=0; $i<count($ingredientes); $i++){
        				    echo "<div class=\"form-check\">";
        				    echo "<input class=\"form-check-input\" type=\"checkbox\" checked name=\"".$ingredientes[$i]."\">";
        				    echo "<label class=\"form-check-label\">" . $ingredientes[$i]. "</label>";
        				    echo "</div>";
        				}
        				        
        				?>
        				<div class="form-check">
                          <input class="form-check-input" type="checkbox" name="otro">
                          <input type="text" class="form-check-label" name="otroDescripcion" placeholder="Separados por coma">
                        </div>
                        <button type="submit" class="btn btn-primary">Generar receta</button>
        			</form>
				</div>
			</div>
    	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
	</body>
</html>