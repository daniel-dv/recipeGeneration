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
      </tbody>
    </table>
    <form>
      <div class="mb-3">
        <label for="receta" class="form-label">Receta:</label>
        <textarea class="form-control" id="receta" name="receta" rows="10" readonly></textarea>
      </div>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>