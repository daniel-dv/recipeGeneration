<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <title>Receta</title>
  <?php 
  function agregarIngredienteBBDD($pdo, $ingrediente, $detectado, $id) {
      $nombreIngrediente = $ingrediente->getNombre(); //preprocesamiento, todo uppercase y eliminar espacios
      $consultaSQL= "select id from ingrediente where nombreIngrediente = ?";
      $stmt = $pdo->prepare ($consultaSQL);
      $stmt->execute (array($nombreIngrediente));
      if ($stmt->rowCount()>0){
          $fila = $stmt->fetch(PDO::FETCH_ASSOC);
          $idIngrediente = $fila['id'];
          $consultaSQL= "insert into logxingrediente (idLog, idIngrediente, detectado) values (?,?,?)";
          $stmt = $pdo->prepare ($consultaSQL);
          $stmt->execute (array($id, $idIngrediente, $detectado));
      }
      else{
          $consultaSQL= "insert into ingrediente (nombreIngrediente) values (?)";
          $stmt = $pdo->prepare ($consultaSQL);
          $stmt->execute (array($nombreIngrediente));
          $idIngrediente = $pdo->lastInsertId();
          
          $consultaSQL= "insert into logxingrediente (idLog, idIngrediente, detectado) values (?,?,?)";
          $stmt = $pdo->prepare ($consultaSQL);
          $stmt->execute (array($id, $idIngrediente, $detectado));
      }
  }
  ?>
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
      	include 'Receta.php';
      	include 'Ingrediente.php';
      	if(isset($_POST)){
      	    $receta = new Receta();
      	    

      	    //Ingreso en bbdd
      	    
      	    $datosBBDD = "mysql:host=127.0.0.1;dbname=recipegenerationlog";
      	    $username="usuario1";
      	    $password="123456";
      	    $pdo = new PDO($datosBBDD, $username, $password);
      	    
      	    $consultaSQL= "insert into log (nombreImagen) values (?)";
      	    $stmt = $pdo->prepare ($consultaSQL);
      	    $stmt->execute (array($_POST['nombreDeArchivo']));
      	    
      	    $idLog = $pdo->lastInsertId();
      	    //fin bbdd
      	    
      	    
          	
          	
          	
          	foreach ($_POST as $clave=>$valor)
          	    if($clave != "otro" && $clave != "otroDescripcion" && $clave != "nombreDeArchivo"){
          	        $ingredienteAAgregar = new Ingrediente(str_replace(' ', '', $clave));
          	        $receta->agregarIngrediente($ingredienteAAgregar);
          	        agregarIngredienteBBDD($pdo, $ingredienteAAgregar, true, $idLog);
          	    }
          	        
  	        if (isset($_POST["otro"]) && isset($_POST["otroDescripcion"]) && $_POST["otroDescripcion"] != ""){
  	            foreach (explode(",",$_POST["otroDescripcion"]) as $otroIngrediente){
  	                $ingredienteAAgregar = new Ingrediente(str_replace(' ', '', $otroIngrediente));
  	                $receta->agregarIngrediente($ingredienteAAgregar);
  	                agregarIngredienteBBDD($pdo, $ingredienteAAgregar, false, $idLog);
  	            }
  	        }
          	

  	        
  	        
          	foreach ($receta->getIngredientes() as $ingrediente){
          	    echo "<tr>";
          	    echo "<td scope=\"row\">".ucfirst($ingrediente)."</td>";
          	    echo "</tr>";
          	}
      	}
        ?>
        
        <?php 
        $api_url = 'http://127.0.0.1:5001/generate';
//         $ingredientesAEnviar = $ingredientes[0];
//         for ($i=1; $i<count($ingredientes); $i++)
//             $ingredientesAEnviar .= ", ".$ingredientes[$i];

        $data = [
        'texto' => $receta->getStringIngredientes(),
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
        $pasos = ucfirst(substr($pasos,3));
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