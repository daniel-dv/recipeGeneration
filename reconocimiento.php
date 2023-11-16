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
        <script>
            var checkbox = document.getElementById('checkboxOtro');
            var inputTexto = document.getElementById('descripcionOtro');
        
            inputTexto.addEventListener('input', function() {
                if (inputTexto.value.length > 0) {
                    checkbox.checked = true;
                } else {
                    // Desmarca el checkbox si el texto se borra
                    checkbox.checked = false;
                }
            });
        </script>
	</head>

	<body>
		
        <div class="container">    
            <h2>Generador de recetas</h2>
    		
			<div class="row">
				<div class="col-md-6">
                    <?php
                    $targetFile ="";
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
                    // URL de API
                    $api_url = 'http://127.0.0.1:5000/detect';
                    
                    // Path al archivo 
                    $image_path = $targetFile;
                    
                    // Inicializar cURL
                    $curl = curl_init();
                    
                    // Configurar las opciones de cURL para la solicitud POST
                    curl_setopt($curl, CURLOPT_URL, $api_url);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); //solo en desarrollo
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //solo en desarrollo
                    
                    // Adjuntar el archivo con el tipo de campo 'file'
                    $cfile = curl_file_create($image_path);
                    $data = array('file' => $cfile);
                    
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    
                    // Ejecutar la solicitud cURL
                    $response = curl_exec($curl);


                    // Cerrar la sesión cURL
                    curl_close($curl);
                    
                    // Decodificar la respuesta JSON
                    $responseData = json_decode($response, true);
                    
                    ?>
                    
                </div> 
                <div class="col-md-6">
                	<?php 
                	if ($responseData == null)
                	    $ingredientes = [];
                	else
                	    $ingredientes = array_values(array_unique($responseData));
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
                          <input class="form-check-input" id="checkboxOtro" type="checkbox" name="otro">
                          <input type="text" class="form-check-label" id="descripcionOtro" name="otroDescripcion" placeholder="Separados por coma">
                        </div>
                        <button type="submit" class="btn btn-primary">Generar receta</button>
        			</form>
				</div>
			</div>
    	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
		        <script>
            var checkbox = document.getElementById('checkboxOtro');
            var inputTexto = document.getElementById('descripcionOtro');
        
            inputTexto.addEventListener('input', function() {
                if (inputTexto.value.length > 0) {
                    checkbox.checked = true;
                } else {
                    // Desmarca el checkbox si el texto se borra
                    checkbox.checked = false;
                }
            });
        </script>
	</body>
</html>