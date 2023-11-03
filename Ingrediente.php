<?php
class Ingrediente {
   
    private $nombre;
    
    // Constructor
    public function __construct($nombre) {
        $this->nombre = $nombre;
    }

    public function getNombre() {
        return $this->nombre;
    }
    
    
    // M�todos para establecer las propiedades (setters)
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function __toString() {
        return $this->nombre;
    }
}

?>