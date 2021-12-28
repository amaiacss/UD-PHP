<?php

Class ControladorBlog{
    /********************************
     * Mostrar contenido tabla blog * 
     ********************************/
    static public function ctrMostrarBlog() {
        
        $tabla = "blog";
        //Solicita una respuesta al ModeloBlog
        $respuesta = ModeloBlog::mdlMostrarBlog($tabla);
        // retornamos la resouesta a la vista
        return $respuesta;
    }

}