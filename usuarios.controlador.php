<?php 
class ControladorUsuarios{

	// INGRESO USUARIOS

	static public function ctrIngresoUsuario(){

		if (isset($_POST["ingUsuario"])) {	
			
			if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) && preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])) {

				$encriptar = crypt($_POST["ingPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
				
				$tabla = "usuario";

				//campo de la tabla usuario
				$item = "usuario_login"; 
				//valor para consultar en la tabla
				$valor = $_POST['ingUsuario'];

				$respuesta = ModeloUsuarios:: mdlMostrarUsuarios($tabla,$item,$valor);

				if (is_array($respuesta)) {

					if ($respuesta["usuario_login"] == $_POST['ingUsuario']) {
						
						if ($respuesta["password"] == $encriptar) {

							if ($respuesta["estado"]=="1") {

								// Iniciamos session en caso de estar ACTIVADO
								$_SESSION['iniciarSesion'] = "ok";

								$_SESSION['id_usuario'] = $respuesta["ci_usuario"];
								$_SESSION['nombreUsuario'] = $respuesta["nombre"];
								$_SESSION['paternoUsuario'] = $respuesta["ap_paterno"];
								$_SESSION['maternoUsuario'] = $respuesta["ap_materno"];
								$_SESSION['fotoUsuario'] = $respuesta["foto"];
								$_SESSION['rolUsuario'] = $respuesta["rol"];


								// REGISTRAR HORA FECHA ULTIMO LOGIN

								date_default_timezone_set('America/La_Paz');

								$fecha = date("Y-m-d");
								$hora = date("H:i:s");

								$fechaActual = $fecha." ".$hora;

								$item1 = "ultimo_ingreso";
								$valor1 = $fechaActual;

								$item2 = "ci_usuario";
								$valor2 = $respuesta["ci_usuario"];

								$ultimoIngreso = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);

								if ($ultimoIngreso == "ok") {

									echo '<div class="alert alert-success alert-dismissible fade show mt-3 p-2" role="alert"><small>
										Usuario y contraseña correctos.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button> </small>
									</div>';

								 	echo '<script>

											window.location = "inicio";
										</script>';
								 } 

								//------------------------------
							
								
							}else{
								echo '<div class="alert alert-warning alert-dismissible fade show mt-3 p-2" role="alert"><small>
									El usuario aún no esta ACTIVADO.
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button> </small>
								</div>';
							}
							
							
						}else{
							echo '<div class="alert alert-danger alert-dismissible fade show mt-3 p-2" role="alert"><small>
								<strong>Error al ingresar!</strong>, la contraseña es incorrecta.
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button> </small>
							</div>';

						}

					}else{
						echo '<div class="alert alert-danger alert-dismissible fade show mt-3 p-2" role="alert"><small>
								<strong>Error al ingresar!</strong>, el usuario es incorrecto.
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button> </small>
							</div>';
					}

				}else{
					echo '<div class="alert alert-danger alert-dismissible fade show mt-3 p-2" role="alert"><small>
								<strong>Error al ingresar!</strong>, el usuario es incorrecto.
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button> </small>
							</div>';

					
				}
			}

		}
	}

	//CREAR REGISTRO USUARIO
	static public function ctrCrearUsuario(){

		if (isset($_POST["nuevoCarnet"])) {
			
			if (preg_match('/^[a-zA-Z0-9áéíúóÁÉÍÓÚñÑ ]+$/', $_POST["nuevoNombre"]) &&
				 preg_match('/^[a-zA-Z0-9áéíúóÁÉÍÓÚñÑ ]+$/', $_POST["nuevoPaterno"]) &&
				 preg_match('/^[a-zA-Z0-9áéíúóÁÉÍÓÚñÑ ]+$/', $_POST["nuevoMaterno"]) &&
				 preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoUsuarioLogin"]) &&
				 preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoPassword"])) {

				// VAlidar Imagen

				$ruta = "";


				if (is_uploaded_file($_FILES['nuevaFoto']['tmp_name'])) {
					
					list($ancho, $alto) = getimagesize($_FILES['nuevaFoto']['tmp_name']);

					$nuevoAncho = 500;
					$nuevoAlto = 500;

					//directorio de las imagenes
					$directorio = "vistas/img/usuarios/".$_POST["nuevoCarnet"];

					mkdir($directorio, 0777, true);

					// subir JPG
					if ($_FILES['nuevaFoto']["type"] == "image/jpeg") {
						
						$aleatorio = mt_rand(100,999);
						$ruta = "vistas/img/usuarios/".$_POST["nuevoCarnet"]."/".$aleatorio.".jpg";

						$origen = imagecreatefromjpeg($_FILES['nuevaFoto']["tmp_name"]);

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}

					// subir PNG
					if ($_FILES['nuevaFoto']["type"] == "image/png") {
						
						$aleatorio = mt_rand(100,999);
						$ruta = "vistas/img/usuarios/".$_POST["nuevoCarnet"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES['nuevaFoto']["tmp_name"]);

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}
				}

				$tabla = "usuario";

				// CRYPT BLOWFISH
				$encriptar = crypt($_POST["nuevoPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				// Fecha y Hora de creacion de usuario 

				date_default_timezone_set('America/La_Paz');

								$fecha = date("Y-m-d");
								$hora = date("H:i:s");

								$fechaAgregado = $fecha." ".$hora;

				// Enviando datos al modelo
				
				$datos = array("carnet"=>$_POST["nuevoCarnet"],
									"nombre"=>$_POST["nuevoNombre"],
			                 "paterno"=>$_POST["nuevoPaterno"],
			                 "materno"=>$_POST["nuevoMaterno"],
			                 "telefono"=>$_POST["nuevoTelefono"],
			                 "email"=>$_POST["nuevoEmail"],
			                 "usuario_login"=>$_POST["nuevoUsuarioLogin"],
			                 "password"=>$encriptar,
			                 "rol"=>$_POST["nuevoRol"],
			                 "estado"=>"0",
			                 "f_agregado"=>$fechaAgregado,
			              	  "foto"=>$ruta);

				
				$respuesta = ModeloUsuarios::mdlRegistrarUsuario($tabla, $datos); 

				if ($respuesta == "ok") {
					
					echo '<script>
					Swal.fire({
						
						icon: "success",
						title: "¡Ususario registrado!",
						text: "El usuario fué registrado correctamente.",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false

						}).then((result)=>{
							if(result.value){
								window.location = "usuarios";
							}
						}); 
				 	</script>';
				}else{
					echo '<script>
					Swal.fire({
						
						icon: "error",
						title: "¡Error al registrar usuario!",
						text: "El usuario no puede ir vacío o llevar carácteres especiales.",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false

						}).then((result)=>{
							if(result.value){
								window.location = "usuarios";
							}
						}); 
				 </script>';
				}

			}else{

				echo '<script>
					Swal.fire({
						
						icon: "error",
						title: "¡Error al registrar usuario!",
						text: "Los campos requeridos no pueden ir vacíos o llevar carácteres especiales.",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false

						}).then((result)=>{
							if(result.value){
								window.location = "usuarios";
							}
						}); 
				 </script>';
			}
		}
	}

	//MOSTRAR USUARIOS
	static public function ctrMostrarUsuarios($item, $valor){

		$tabla = "usuario";

		$respuesta = ModeloUsuarios:: mdlMostrarUsuarios($tabla,$item,$valor);

		return $respuesta;
	}

	//EDITAR USUARIO
	static public function ctrEditarUsuario(){

		if (isset($_POST['editarCarnet'])) {

			if (preg_match('/^[a-zA-Z0-9áéíúóÁÉÍÓÚñÑ ]+$/', $_POST["editarNombre"]) &&
				 preg_match('/^[a-zA-Z0-9áéíúóÁÉÍÓÚñÑ ]+$/', $_POST["editarPaterno"]) &&
				 preg_match('/^[a-zA-Z0-9áéíúóÁÉÍÓÚñÑ ]+$/', $_POST["editarMaterno"])) {

				// Validar Imagen
				$ruta = $_POST['fotoActual'];

				if (is_uploaded_file($_FILES['editarFoto']['tmp_name'])) {
					
					list($ancho, $alto) = getimagesize($_FILES['editarFoto']['tmp_name']);

					$nuevoAncho = 500;
					$nuevoAlto = 500;

					//directorio de las imagenes
					$directorio = "vistas/img/usuarios/".$_POST["editarCarnet"];

					if (!empty($_POST["fotoActual"])) {
						
						unlink($_POST['fotoActual']);

					}else{
						mkdir($directorio, 0777, true);
					}

					


					// subir JPG
					if ($_FILES['editarFoto']["type"] == "image/jpeg") {
						
						$aleatorio = mt_rand(100,999);
						$ruta = "vistas/img/usuarios/".$_POST["editarCarnet"]."/".$aleatorio.".jpg";

						$origen = imagecreatefromjpeg($_FILES['editarFoto']["tmp_name"]);

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}

					// subir PNG
					if ($_FILES['editarFoto']["type"] == "image/png") {
						
						$aleatorio = mt_rand(100,999);
						$ruta = "vistas/img/usuarios/".$_POST["editarCarnet"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES['editarFoto']["tmp_name"]);

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}
				}

				$tabla = "usuario";

				if ($_POST['editarPassword'] != "") {

					if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarPassword"])) {

						$encriptar = crypt($_POST["editarPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
					}else{
						echo '<script>
								Swal.fire({
									
									icon: "error",
									title: "¡La contraseña no puede ir vacía o llevar carateres especiales!",
									
									showConfirmButton: true,
									confirmButtonText: "Cerrar",
									closeOnConfirm: false

									}).then((result)=>{
										if(result.value){
											window.location = "usuarios";
										}
									}); 
							 </script>';
					}

				}else{

					$encriptar = $_POST['passwordActual'];		
				}

				$datos = array("carnet"=>$_POST["editarCarnet"],
									"nombre"=>$_POST["editarNombre"],
			                 "paterno"=>$_POST["editarPaterno"],
			                 "materno"=>$_POST["editarMaterno"],
			                 "telefono"=>$_POST["editarTelefono"],
			                 "email"=>$_POST["editarEmail"],
			                 "usuario_login"=>$_POST["editarUsuario"],
			                 "password"=>$encriptar,
			                 "rol"=>$_POST["editarRol"],
			              	  "foto"=>$ruta);

				$respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos); 

				if ($respuesta == "ok") {
					
					echo '<script>
					Swal.fire({
						
						icon: "success",
						title: "¡Ususario modificado!",
						text: "El usuario fué modificado correctamente.",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false

						}).then((result)=>{
							if(result.value){
								window.location = "usuarios";
							}
						}); 
				 	</script>';
				}else{
					echo '<script>
					Swal.fire({
						
						icon: "error",
						title: "¡Error al registrar usuario!",
						text: "El usuario no puede ir vacío o llevar carácteres especiales.",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false

						}).then((result)=>{
							if(result.value){
								window.location = "usuarios";
							}
						}); 
				 </script>';
				}


			}else{

				echo '<script>
					Swal.fire({
						
						icon: "error",
						title: "¡Error al modificar usuario!",
						text: "Los campos requeridos no pueden ir vacíos o llevar carácteres especiales.",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false

						}).then((result)=>{
							if(result.value){
								window.location = "usuarios";
							}
						}); 
				 </script>';
			}
			
		}
	}

	//ELIMINAR USUARIO
	static public function ctrEliminarUsuario(){

		if (isset($_GET['idUsuario'])) {
			$tabla = "usuario";
			$datos = $_GET['idUsuario'];

			if ($_GET['fotoUsuario'] != "") {
				
				unlink($_GET['fotoUsuario']);
				rmdir('vistas/img/usuarios/'.$_GET['idUsuario']);

			}

			$respuesta = ModeloUsuarios::mdlBorrarUsuario($tabla,$datos);

			if ($respuesta == "ok") {
					
					echo '<script>
					Swal.fire({
						
						icon: "success",
						title: "¡Ususario eliminado!",
						text: "El usuario fué eliminado correctamente.",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false

						}).then((result)=>{
							if(result.value){
								window.location = "usuarios";
							}
						}); 
				 	</script>';
				}else{
					echo '<script>
					Swal.fire({
						
						icon: "error",
						title: "¡Error al eliminar usuario!",
						text: "El usuario no se pudo eliminar, intentelo mas tarde.",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false

						}).then((result)=>{
							if(result.value){
								window.location = "usuarios";
							}
						}); 
				 </script>';
				}


		}

	}

}
