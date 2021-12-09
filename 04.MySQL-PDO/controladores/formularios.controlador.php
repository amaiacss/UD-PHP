<?php

class ControladorFormularios{

	/*=============================================
	Registro
	=============================================*/

	static public function ctrRegistro(){

		if(isset($_POST["registroNombre"])){

			$tabla = "registros";

			$datos = array("nombre" => $_POST["registroNombre"],
				           "email" => $_POST["registroEmail"],
				           "password" => $_POST["registroPassword"]);

			// Instancia del método estatico del Modelo, si es correcto se guarda en $respuesta = "ok"
			$respuesta = ModeloFormularios::mdlRegistro($tabla, $datos);
			// Devolvemos la respuesta a la vista registro
			return $respuesta;

		}

	}

	/*=============================================
	Seleccionar Registros
	=============================================*/
	// Método que envia al modelo el nombre de la tabla 
	static public function ctrSeleccionarRegistros($item, $valor){

		$tabla = "registros";
		// llama al class ModeloFormularios::función
		$respuesta = ModeloFormularios::mdlSeleccionarRegistros($tabla, $item, $valor);
		// devuelve la respuesta a la vista iniicio.php
		return $respuesta;

	}

	/*=============================================
	Ingreso
	=============================================*/
	// NO es un método estatico, se usa en ingreso.php
	public function ctrIngreso(){

		if(isset($_POST["ingresoEmail"])){

			$tabla = "registros";
			$item = "email";
			$valor = $_POST["ingresoEmail"];

			$respuesta = ModeloFormularios::mdlSeleccionarRegistros($tabla, $item, $valor);

			if($respuesta["email"] == $_POST["ingresoEmail"] && $respuesta["password"] == $_POST["ingresoPassword"]){

				$_SESSION["validarIngreso"] = "ok";

				echo '<script>

					if ( window.history.replaceState ) {

						window.history.replaceState( null, null, window.location.href );

					}
					
					window.location = "index.php?pagina=inicio";

				</script>';

			}else{


				echo '<script>

					if ( window.history.replaceState ) {

						window.history.replaceState( null, null, window.location.href );

					}

				</script>';

				echo '<div class="alert alert-danger">Error al ingresar al sistema, el email o la contraseña no coinciden</div>';
			}
			
			

		}

	}

	/*=============================================
	Actualizar Registro
	=============================================*/
	static public function ctrActualizarRegistro(){

		if(isset($_POST["actualizarNombre"])){

			if($_POST["actualizarPassword"] != ""){			

				$password = $_POST["actualizarPassword"];

			}else{

				$password = $_POST["passwordActual"];
			}

			$tabla = "registros";

			$datos = array("id" => $_POST["idUsuario"],
							"nombre" => $_POST["actualizarNombre"],
				           "email" => $_POST["actualizarEmail"],
				           "password" => $password);

			$respuesta = ModeloFormularios::mdlActualizarRegistro($tabla, $datos);

			return $respuesta;

		}


	}

	/*=============================================
	Eliminar Registro
	=============================================*/
	public function ctrEliminarRegistro(){

		if(isset($_POST["eliminarRegistro"])){

			$tabla = "registros";
			$valor = $_POST["eliminarRegistro"];

			$respuesta = ModeloFormularios::mdlEliminarRegistro($tabla, $valor);

			if($respuesta == "ok"){

				echo '<script>

					if ( window.history.replaceState ) {

						window.history.replaceState( null, null, window.location.href );

					}

					window.location = "index.php?pagina=inicio";

				</script>';

			}

		}

	}


}