<?php 

$conn = new mysqli("localhost", "root", "", "software2");
if ($conn->connect_error) {
	die("Database connection established Failed..");
} 
$res = array('error' => false);



$action = 'readusers';
$action = 'readrol';

if (isset($_GET['action'])) {
	$action = $_GET['action'];
}

if($action=='search'){
	$id = $_GET['id'];
$result = $conn->query("SELECT * FROM `usuarios` where `id`='$id' and `estado`='activo'");
	$users = array();
	while ($row = $result->fetch_assoc()){
		array_push($users, $row);
	}
	$res['users'] = $users;
}

if($action=='getProgramasFacultad'){
	$facultad = $_GET['facultad'];
$result = $conn->query("SELECT `programa`.`id` as id,`programa`.`nombre` as nombre,`facultad`.`nombre` as facultad FROM `programa`,`facultad` WHERE `programa`.`idFacultad`= `facultad`.`idFacultad` and `facultad`.`nombre`='$facultad'");
	$users = array();
	while ($row = $result->fetch_assoc()){
		array_push($users, $row);
	}
	$res['users'] = $users;
}

if($action=='getFacultad'){
	$facultad = $_GET['facultad'];
$result = $conn->query("SELECT * FROM `usuarios` where `idPrograma`=any(select `id` from `programa` where `idFacultad` = any(select  `idFacultad` from `facultad` where `nombre` = '$facultad')  )  and `estado`='activo'");
	$users = array();
	while ($row = $result->fetch_assoc()){
		array_push($users, $row);
	}
	$res['users'] = $users;
}
if($action=='getPrograma'){
	$programa = $_GET['programa'];
$result = $conn->query("SELECT * FROM `usuarios` where `idPrograma`=any(select `id` from `programa` where `nombre` = '$programa' )  and `estado`='activo'");
	$users = array();
	while ($row = $result->fetch_assoc()){
		array_push($users, $row);
	}
	$res['users'] = $users;
}


if ($action == 'readusers') {
	$result = $conn->query("INSERT INTO `rol` (`id`, `nombre`, `descripcion`) values('999','Administrador del Sistema', 'Administrador del Sistema')");
	$result = $conn->query("INSERT INTO `rol` (`id`, `nombre`, `descripcion`) values('998','Personal Administrativo', 'Personal Administrativo')");
	$result = $conn->query("INSERT INTO `rol` (`id`, `nombre`, `descripcion`) values('997','Decano', 'Decano')");
	$result = $conn->query("INSERT INTO `rol` (`id`, `nombre`, `descripcion`) values('996','Jefe de Programa', 'Jefe de Programa')");
	$result = $conn->query("INSERT INTO `rol` (`id`, `nombre`, `descripcion`) values('995','Coordinador de Posgrado', 'Coordinador de Posgrado')");
	$result = $conn->query("INSERT INTO `rol` (`id`, `nombre`, `descripcion`) values('994',', Coordinador de UOC', ', Coordinador de UOC')");
	$result = $conn->query("INSERT INTO `rol` (`id`, `nombre`, `descripcion`) values('993','Docente', 'Docente')");
	$result = $conn->query("INSERT INTO `rol` (`id`, `nombre`, `descripcion`) values('992','Alumno ', 'Alumno ')");
	$result = $conn->query("INSERT INTO `rol` (`id`, `nombre`, `descripcion`) values('991','Monitor', 'Monitor')");
	$result = $conn->query("SELECT usuarios.id as id, usuarios.nombre as nombre,usuarios.apellido as apellido, usuarios.correo as correo,usuarios.clave as clave,usuarios.credencial as credencial, lista.nombre as idlista,programa.nombre as idprograma from usuarios,lista,programa where usuarios.codigoLista=lista.id and usuarios.idprograma=programa.id and usuarios.estado='activo'");
	$users = array();
	while ($row = $result->fetch_assoc()){
		array_push($users, $row);
	}
	$res['users'] = $users;
	
}

if ($action == 'readrol') {
	$result = $conn->query("SELECT * FROM `rol`");
	$rol = array();
	while ($row = $result->fetch_assoc()){
		array_push($rol, $row);
	}
	$res['rol'] = $rol;
	
}

if ($action == 'createuser') {

	$id = $_POST['id'];
	$nombre = $_POST['nombre'];
	$apellido = $_POST['apellido'];
	$correo = $_POST['correo'];
	$clave = $_POST['clave'];
	$credencial = $_POST['credencial'];
	$idlista = $_POST['idlista'];
	$idprograma = $_POST['idprograma'];


	$result = $conn->query("INSERT INTO `usuarios` (`id`, `nombre`, `apellido`,`correo`,`clave`,`credencial`,`codigoLista`,`idprograma`,`estado`) VALUES (	'$id','$nombre', '$apellido','$correo','$clave','$credencial',(select id from lista where nombre='$idlista'),(select id from programa where nombre='$idprograma'), 'activo') ");
	if ($result) {
		$res['message'] = "Usuario creado correctamente";
	} else{
		$res['error'] = true;
		$res['message'] = "No se ha podido crear el usuario";
	}
}

if ($action == 'createrol') {

	$id = $_POST['id'];
	$nombre = $_POST['nombre'];
	$descripcion = $_POST['descripcion'];


	$result = $conn->query("INSERT INTO `rol` (`id`, `nombre`, `descripcion`) VALUES ('$id', '$nombre', '$descripcion')");
	if ($result) {
		$res['message'] = "Rol creado correctamente";
	} else{
		$res['error'] = true;
		$res['message'] = "No se ha podido crear el rol";
	}
}

if ($action == 'updateuser') {
	$id = $_POST['id'];
	$nombre = $_POST['nombre'];
	$apellido = $_POST['apellido'];
	$correo = $_POST['correo'];
	$clave = $_POST['clave'];
	$credencial = $_POST['credencial'];
	$idlista = $_POST['idlista'];
	$idprograma = $_POST['idprograma'];


	$result = $conn->query("UPDATE usuarios SET nombre = '$nombre',apellido='$apellido' ,
	correo='$correo', credencial = '$credencial',
	codigoLista = (select id from lista where nombre = '$idlista'), idprograma= (select id from programa where nombre =  '$idprograma') ,
	 estado = 'activo'
	  WHERE id = '$id'");
	if ($result) {
		$res['message'] = "Usuario actualizado correctamente!";
	} else{
		$res['error'] = true;
		$res['message'] = "No se ha podido actualizar el usuario";
	}
}

if ($action == 'updaterol') {
	$id = $_POST['id'];
	$nombre = $_POST['nombre'];
	$descripcion = $_POST['descripcion'];


	$result = $conn->query("UPDATE `rol` SET `nombre` = '$nombre',`descripcion`='$descripcion' WHERE `id` = '$id'");
	if ($result) {
		$res['message'] = "Rol actualizado correctamente!";
	} else{
		$res['error'] = true;
		$res['message'] = "No se ha podido actualizar el rol";
	}
}

if ($action == 'deleteuser') {
	$id = $_POST['id'];
	$result = $conn->query("UPDATE `usuarios` SET `estado` = 'inactivo' WHERE `id` = '$id'");	
	if ($result) {
		$res['message'] = "Usuario ha pasado a inactivo";
	} else{
		$res['error'] = true;
		$res['message'] = "No se ha podido cambiar el estado del usuario";
	}
}

if ($action == 'deleterol') {
	$id = $_POST['id'];
	$result = $conn->query("DELETE FROM `rol` WHERE `id` = '$id'");	
	if ($result) {
		$res['message'] = "Rol eliminado!";
	} else{
		$res['error'] = true;
		$res['message'] = "No se ha podido eliminar el Rol";
	}
}

$conn -> close();
header("Content-type: application/json");
echo json_encode($res);
die();

 ?>