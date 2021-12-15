<?php

class ControladorFormularios{

	/*=============================================
	Registro
	=============================================*/

	static public function ctrRegistro(){

		if(isset($_POST["registroNombre"])){
			// Para prevenir ataques se utiliza preg_match, que nos permite comparar los caracteres que se estan escribiendo en los input con unos patrones o unas expresiones regualares, donde podemos especifica rque patrones permitimos en esas entradas.
			// Lo primero que se coloca es la expresión regular con la que se revisa los caracteres que se escriben en el input
			// En la siguiente expresión sólo se admiten letras, en la siguiente es para el email y el siguiente es el password
			if(preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["registroNombre"]) &&
			   preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["registroEmail"]) &&
			   preg_match('/^[0-9a-zA-Z]+$/', $_POST["registroPassword"])){

				$tabla = "registros";

				// Para evitar que la informacion pueda ser manipulada desde el inspector, se encripta la info
				// ejemplo --> amaia+amaia#gmail.com
				// creando este token se puede usar como el id, para el input hidden, en vez del id númerico
				$token = md5($_POST["registroNombre"]."+".$_POST["registroEmail"]);

				$encriptarPassword = crypt($_POST["registroPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				$datos = array("token" => $token,
								"nombre" => $_POST["registroNombre"],
					           "email" => $_POST["registroEmail"],
					           "password" => $encriptarPassword);

				$respuesta = ModeloFormularios::mdlRegistro($tabla, $datos);

				return $respuesta;

			}else{

				$respuesta = "error";

				return $respuesta;

			}

		}

	}

	/*=============================================
	Seleccionar Registros
	=============================================*/

	static public function ctrSeleccionarRegistros($item, $valor){

		$tabla = "registros";

		$respuesta = ModeloFormularios::mdlSeleccionarRegistros($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	Ingreso
	=============================================*/

	public function ctrIngreso(){

		if(isset($_POST["ingresoEmail"])){

			$tabla = "registros";
			$item = "email";
			$valor = $_POST["ingresoEmail"];

			$respuesta = ModeloFormularios::mdlSeleccionarRegistros($tabla, $item, $valor);

			$encriptarPassword = crypt($_POST["ingresoPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

			if($respuesta["email"] == $_POST["ingresoEmail"] && $respuesta["password"] == $encriptarPassword){

				ModeloFormularios::mdlActualizarIntentosFallidos($tabla, 0, $respuesta["token"]);

				$_SESSION["validarIngreso"] = "ok";

				echo '<script>

					if ( window.history.replaceState ) {

						window.history.replaceState( null, null, window.location.href );

					}

					window.location = "inicio";

				</script>';

			}else{

				if($respuesta["intentos_fallidos"] < 3){

					$tabla = "registros";

					$intentos_fallidos = $respuesta["intentos_fallidos"]+1;
					
					ModeloFormularios::mdlActualizarIntentosFallidos($tabla, $intentos_fallidos, $respuesta["token"]);

				}else{

					echo '<div class="alert alert-warning">RECAPTCHA Debes validar que no eres un robot</div>';

				}
			
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

			if(preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["actualizarNombre"]) &&
			   preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["actualizarEmail"])){

				// Consulta en la BD de ese usuario que quiere actualizar su registro
				$usuario = ModeloFormularios::mdlSeleccionarRegistros("registros", "token", $_POST["tokenUsuario"]);
				// #SEGURIDAD : Genero un nuevo token para comparar con el que está en la BD
				$compararToken = md5($usuario["nombre"]."+".$usuario["email"]);
				// Si los token coinciden entonces se permite acceder y actualizar
				if($compararToken == $_POST["tokenUsuario"] && $_POST["idUsuario"] == $usuario["id"]){

					if($_POST["actualizarPassword"] != ""){

						if(preg_match('/^[0-9a-zA-Z]+$/', $_POST["actualizarPassword"])){

							$password = crypt($_POST["actualizarPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
						}

					}else{

						$password = $_POST["passwordActual"];
					}

					$tabla = "registros";

				$actualizarToken = md5($_POST["actualizarNombre"]."+".$_POST["actualizarEmail"]);

					$datos = array( "id" => $_POST["idUsuario"],
									"token" => $actualizarToken,
									"nombre" => $_POST["actualizarNombre"],
						           "email" => $_POST["actualizarEmail"],
						           "password" => $password);

					$respuesta = ModeloFormularios::mdlActualizarRegistro($tabla, $datos);

					return $respuesta;

				}else{

					$respuesta = "error";

					return $respuesta;

				}

			}else{

				$respuesta = "error";

				return $respuesta;

			}
	

		}


	}

	/*=============================================
	Eliminar Registro
	=============================================*/
	public function ctrEliminarRegistro(){

		if(isset($_POST["eliminarRegistro"])){
			// Consulta en la BD de ese usuario que quiere eliminar su registro
			$usuario = ModeloFormularios::mdlSeleccionarRegistros("registros", "token",  $_POST["eliminarRegistro"]);

			// Genero un nuevo token para compara con el que está en la BD
			$compararToken = md5($usuario["nombre"]."+".$usuario["email"]);

			// Si los token coinciden entonces se permite acceder y eliminar
			if($compararToken == $_POST["eliminarRegistro"]){

				$tabla = "registros";
				$valor = $_POST["eliminarRegistro"];

				$respuesta = ModeloFormularios::mdlEliminarRegistro($tabla, $valor);

				if($respuesta == "ok"){

					echo '<script>

						if ( window.history.replaceState ) {

							window.history.replaceState( null, null, window.location.href );

						}

						window.location = "inicio";

					</script>';

				}

			}
		

		}

	}


}