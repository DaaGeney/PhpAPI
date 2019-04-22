<?php 

$conn = new mysqli("localhost", "root", "123!\"·QWE", "software");
if ($conn->connect_error) {
	die("Database connection established Failed..");
} 
$res = array('error' => false);



$action = 'read';

if (isset($_GET['action'])) {
	$action = $_GET['action'];
}

if ($action == 'read') {
	$result = $conn->query("SELECT * FROM `usuarios` where `estado`='activo'");
	$users = array();
	while ($row = $result->fetch_assoc()){
		array_push($users, $row);
	}
	$res['users'] = $users;
	
}

if ($action == 'create') {

	$id = $_POST['id'];
	$nombre = $_POST['nombre'];
	$apellido = $_POST['apellido'];
	$correo = $_POST['correo'];
	$clave = $_POST['clave'];
	$credencial = $_POST['credencial'];
	$idlista = $_POST['idlista'];
	$idprograma = $_POST['idprograma'];


	$result = $conn->query("INSERT INTO `usuarios` (`id`, `nombre`, `apellido`,`correo`,`clave`,`credencial`,`idlista`,`idprograma`,`estado`) VALUES (	'$id','$nombre', '$apellido','$correo','$clave','$credencial','$idlista','$idprograma', 'activo') ");
	if ($result) {
		$res['message'] = "User Added successfully";
	} else{
		$res['error'] = true;
		$res['message'] = "Insert User fail";
	}
}


if ($action == 'update') {
	$id = $_POST['id'];
	$nombre = $_POST['nombre'];
	$apellido = $_POST['apellido'];
	$correo = $_POST['correo'];
	$clave = $_POST['clave'];
	$credencial = $_POST['credencial'];
	$idlista = $_POST['idlista'];
	$idprograma = $_POST['idprograma'];


	$result = $conn->query("UPDATE `usuarios` SET `nombre` = '$nombre',`apellido`='$apellido' ,
	 `correo`='$correo', `credencial` = '$credencial',`idlista` = '$idlista', `idprograma` = '$idprograma', `estado` = 'activo'
	   WHERE `id` = '$id'");
	if ($result) {
		$res['message'] = "User Updated successfully";
	} else{
		$res['error'] = true;
		$res['message'] = "User Update failed";
	}
}





if ($action == 'delete') {
	$id = $_POST['id'];


	
	$result = $conn->query("UPDATE `usuarios` SET `estado` = 'inactivo' WHERE `id` = '$id'");	
	if ($result) {
		$res['message'] = "User deleted successfully";
	} else{
		$res['error'] = true;
		$res['message'] = "User delete failed";
	}
}









$conn -> close();
header("Content-type: application/json");
echo json_encode($res);
die();

 ?>