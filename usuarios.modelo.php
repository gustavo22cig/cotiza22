<?php 

require_once "conexion.php";

class ModeloUsuarios{

	// MOSTRAR USUARIOS
	static public function mdlMostrarUsuarios($tabla, $item, $valor){

		if ($item != null) {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ");

			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();// devolvemos una fila como respuesta
		}else{


			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt->execute();

			return $stmt->fetchAll();// devolvemos una fila como respuesta

		}

		$stmt -> close();
		$stmt=null;
	}

	//REGISTRAR USUARIO
	static public function mdlRegistrarUsuario($tabla, $datos){

		 $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(ci_usuario, nombre, ap_paterno, ap_materno, telefono, email, f_agregado, estado, rol, usuario_login, password, foto) VALUES (:ci_usuario, :nombre, :ap_paterno, :ap_materno, :telefono, :email, :f_agregado, :estado, :rol, :usuario_login, :password, :foto)");

		 $stmt->bindParam(":ci_usuario", $datos["carnet"], PDO::PARAM_STR);
		 $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		 $stmt->bindParam(":ap_paterno", $datos["paterno"], PDO::PARAM_STR);
		 $stmt->bindParam(":ap_materno", $datos["materno"], PDO::PARAM_STR);
		 $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		 $stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		 $stmt->bindParam(":f_agregado", $datos["f_agregado"], PDO::PARAM_STR);
		 $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		 $stmt->bindParam(":rol", $datos["rol"], PDO::PARAM_STR);
		 $stmt->bindParam(":usuario_login", $datos["usuario_login"], PDO::PARAM_STR);
		 $stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
		 $stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
 			
		 if ($stmt->execute()) {
		 	return "ok";
		 }else{
		 	return "error";
		 }

		 $stmt -> close();
		$stmt=null;
	}

	// EDITAR USUARIO
	static public function mdlEditarUsuario($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre=:nombre, ap_paterno=:ap_paterno, ap_materno=:ap_materno, telefono=:telefono, email=:email, rol=:rol, usuario_login=:usuario_login, password=:password, foto=:foto WHERE ci_usuario=:ci_usuario");

		$stmt->bindParam(":ci_usuario", $datos["carnet"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":ap_paterno", $datos["paterno"], PDO::PARAM_STR);
		$stmt->bindParam(":ap_materno", $datos["materno"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":rol", $datos["rol"], PDO::PARAM_STR);
		$stmt->bindParam(":usuario_login", $datos["usuario_login"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
				
		if ($stmt->execute()) {
			return "ok";
		}else{
		 	return "error";
		}

		$stmt -> close();
		$stmt=null;
		
	}

	// ACTUALIZAR ESTADO DE USUARIO

	static public function mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2){



		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2=:$item2");

		

		$stmt->bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt->bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		if ($stmt->execute()) {
			return "ok";
		}else{
		 	return "error";
		}

		$stmt -> close();
		$stmt=null;

	}

	static public function mdlBorrarUsuario($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla  WHERE ci_usuario=:ci_usuario");

		$stmt->bindParam(":ci_usuario", $datos, PDO::PARAM_STR);

		if ($stmt->execute()) {
			return "ok";
		}else{
		 	return "error";
		}

		$stmt -> close();
		$stmt=null;
	}

}