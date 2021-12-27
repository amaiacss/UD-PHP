<?php

require_once "../controladores/formularios.controlador.php";
require_once "../modelos/formularios.modelo.php";

/*=============================================
Clase de AJAX
=============================================*/

class AjaxFormularios{

	/*=============================================
	VALIDAR EMAIL EXISTENTE
	=============================================*/	
	public $validarEmail;

	public function ajaxValidarEmail(){
		// columna DB email
		$item = "email";
		// el email que introduce el usuario
		$valor = $this->validarEmail;

		// Compara el email que está guardado cno el email que introduce el usuario
		$respuesta = ControladorFormularios::ctrSeleccionarRegistros($item, $valor);
		
		// Para imprimir un array o un objeto la forma mas correcta es mediante json_encode
		echo json_encode($respuesta);
	}

	/*=============================================
	VALIDAR TOKEN EXISTENTE
	=============================================*/	
	public $validarToken;

	public function ajaxValidarToken(){

		$item = "token";
		$valor = $this->validarToken;

		$respuesta = ControladorFormularios::ctrSeleccionarRegistros($item, $valor);
		
		echo json_encode($respuesta);
	}

}

/*=============================================
Objeto de AJAX que recibe la variable POST
=============================================*/

if(isset($_POST["validarEmail"])){

	$valEmail = new AjaxFormularios();
	// Le asgina a validarEmial el valor
	$valEmail -> validarEmail = $_POST["validarEmail"];
	// Ejecuta el metodo
	$valEmail -> ajaxValidarEmail();

}

/*=============================================
Objeto de AJAX que recibe la variable POST
=============================================*/

if(isset($_POST["validarToken"])){

	$valToken = new AjaxFormularios();
	$valToken -> validarToken = $_POST["validarToken"];
	$valToken -> ajaxValidarToken();

}