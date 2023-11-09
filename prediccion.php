<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <title>Receta</title>
</head>
<body>
  <div class="container">
    <h2>Receta generada</h2>
    <table class="table mb-3">
      <thead>
        <tr>
          <th scope="col">Ingredientes</th>
        </tr>
      </thead>
      <tbody>
      	<?php 
      	if(isset($_POST)){
          	$ingredientes=array();
          	
          	foreach ($_POST as $clave=>$valor)
          	    if($clave != "otro" && $clave != "otroDescripcion")
          	        array_push($ingredientes, str_replace(' ', '', $clave));
          	        
          	        if (isset($_POST["otro"]) && isset($_POST["otroDescripcion"]) && $_POST["otroDescripcion"] != ""){
          	            foreach (explode(",",$_POST["otroDescripcion"]) as $otroIngrediente)
          	                array_push($ingredientes, str_replace(' ','', $otroIngrediente));
          	        }
          	        
          	foreach ($ingredientes as $ingrediente){
          	    echo "<tr>";
          	    echo "<td scope=\"row\">".ucfirst($ingrediente)."</td>";
          	    echo "</tr>";
          	}
      	}
        ?>
        
        <?php 
        $api_url = 'http://127.0.0.1:5001/generate';
        $ingredientesAEnviar = $ingredientes[0];
        for ($i=1; $i<count($ingredientes); $i++)
            $ingredientesAEnviar .= ", ".$ingredientes[$i];

        $data = [
        'texto' => $ingredientesAEnviar,
        'max_length' => 150
        ];
        
        // Iniciar cURL
        $ch = curl_init($api_url);
        
        // Configurar la solicitud POST
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        
        // Ejecutar la solicitud y obtener la respuesta
        $response = curl_exec($ch);
        
        // Cerrar cURL
        curl_close($ch);
        
        // Decodificar la respuesta JSON
        $responseData = json_decode($response, true);
        

        $respuesta = $responseData['generated_text'];

        $partes = explode("steps", $respuesta);

        $pasos = $partes[1] ?? 'No se han encontrado pasos.'; // El operador ?? maneja el caso de que no se encuentre " steps: "
        $pasos = ucfirst(substr($pasos,4));
        ?>
      </tbody>
    </table>
    <form>
      <div class="mb-3">
        <label for="receta" class="form-label">Receta:</label>
        <textarea class="form-control" id="receta" name="receta" rows="10" readonly ><?php echo $pasos;?></textarea>
      </div>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>