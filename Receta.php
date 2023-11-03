<?php
class Receta {
    private $ingredientes;
    private $pasos;
    
    // Constructor
    public function __construct() {
        $this->ingredientes = array();
    }
    
    // Método para agregar un ingrediente a la receta
    public function agregarIngrediente(Ingrediente $ingrediente) {
        array_push($this->ingredientes, $ingrediente);
    }
    
    // Método para agregar un paso de preparación a la receta
    public function setPreparacion($steps) {
        $this->pasos = steps;
    }
    

    public function getIngredientes() {
        return $this->ingredientes;
    }
    
    public function getIngrediente ($idx){
        return $this->ingredientes[$idx];
    }
    
    public function getCantidadIngredientes(){
        return count($this->ingredientes);
    }
    
    public function getPasos() {
        return $this->pasos;
    }
    
    public function __toString() {
        $informacion = "Receta:\n\nIngredientes:\n";
        foreach ($this->ingredientes as $ingrediente) {
            $informacion .= "- " . $ingrediente->mostrarInformacion() . "\n";
        }
        
        $informacion .= "\nPasos de preparación:\n";
        $informacion .= $this->pasos;
        
        return $informacion;
    }
}