<?php
/*** Conexion LDAP ****/
class Conexion{
	var $ldap_server = "192.168.120.120";
	var $ldap_server_backup = "ladapbackup.tpitic.com.mx";
	var $dn = "cn=feria,dc=transportespitic,dc=com";
	var $password = "sistemaspitic";
	
	function __contruct(){
	
	}
	
	function conectarLDAP(){
		$con = ldap_connect('192.168.120.120');
		$anon = @ldap_bind($con);
		if(!$anon){
			$con=ldap_connect('ldapbackup.tpitic.com.mx');
		}
		
		if ($con) {
		   $bind=ldap_bind($con, $this->dn, $this->password)or die("No hay conexion a Server LDAP");
		   return $con;
		}else{
			$ds=ldap_connect($this->ldap_server_backup)or die("No hay conexion a Server LDAP BACKUP");;
			if(!$con){
				echo ldap_error($con);
				return null;
			}
		}
	}
} 

/***********/
$objCon = new Conexion();

$user = isset($_POST['usuario']) ? $_POST['usuario'] : null;
$pass = isset($_POST['clave']) ? $_POST['clave'] : null;
//$infra=$_POST['infra'];

$con = $objCon->conectarLDAP();
if($con && isset($_POST['ldap'])){ 
	$bind=ldap_bind( $con, $objCon->dn, $objCon->password )or die("Can't bind to server.");
	$srch =ldap_search($con, "ou=People,dc=transportespitic,dc=com","uid=".$infra);// se cambio de $user a $infra
	$numero=ldap_count_entries($con, $srch);
	$info = ldap_get_entries($con, $srch);		   			   
	if ($numero != 0){
		$passsaved = $info[0]["userpassword"][0];// asignamos el valor del password asignado en ldap a la variable $passsaved
		//$logstate = validatePassword($pass,$passsaved);
		//if($logstate){
			if($info[0]["nivelscup"][0] == 1){
				session_start();
				$_SESSION['user'] = $info[0]["uid"][0]; //$_SESSION['scup_user']
				header('Location: index.php');
			}else{
				echo "<script>alert('No tiene permisos para accesar a SCUP');history.back(-1);</script>";
			}
		//}else{
		//	echo "<script>alert('Password Incorrecto, Intente de nuevo.');history.back(-1);</script>";
			//Hacer algo cuando el password no es correcto
	//	}			
	}else{
		echo "<script>alert('el usuario no existe');history.back(-1);</script>";
		//echo "{success: false, errors: { reason: 'No existe el usuario ".$user.".' }}";
		//hacer algo cuando no existe el usuario
	}
}elseif($con && isset($_POST['submit'])){
	$bind=ldap_bind( $con, $objCon->dn, $objCon->password )or die("Can't bind to server.");
	$srch =ldap_search($con, "ou=People,dc=transportespitic,dc=com","uid=".$user);
	$numero=ldap_count_entries($con, $srch);
	$info = ldap_get_entries($con, $srch);		   			   
	if ($numero != 0){
		$passsaved = $info[0]["userpassword"][0];// asignamos el valor del password asignado en ldap a la variable $passsaved
		$logstate = validatePassword($pass,$passsaved);
		if($logstate){
			if($info[0]["nivelscup"][0] == 1){
				session_start();
				$_SESSION['user'] = $info[0]["uid"][0]; //$_SESSION['scup_user']
				header('Location: index.php');
			}else{
				echo "<script>alert('No tiene permisos para accesar a SCUP');history.back(-1);</script>";
			}
		}else{
			echo "<script>alert('Password Incorrecto, Intente de nuevo.');history.back(-1);</script>";
			//Hacer algo cuando el password no es correcto
		}			
	}else{
		echo "<script>alert('el usuario no existe');history.back(-1);</script>";
		//echo "{success: false, errors: { reason: 'No existe el usuario ".$user.".' }}";
		//hacer algo cuando no existe el usuario
	}
}
else{
	echo "<script>alert('No hay conexion con el LDAP.');history.back(-1);</script>";
}


function ValidatePassword($password, $hash) {
	$algoritmo = substr($hash, 1, 3);
	if($algoritmo == 'SSH'){
		$hash = base64_decode(substr($hash, 6));
		$original_hash = substr($hash, 0, 20);
		$salt = substr($hash, 20);
		$new_hash = mhash(MHASH_SHA1, $password . $salt);
		if(strcmp($original_hash, $new_hash) == 0){
			$status=true;	
		}else{
			$status=false;
		}
	   
	}else{
		$newPass = "{SHA}".base64_encode(sha1($password, TRUE));
		if(strcmp($hash, $newPass) == 0){
			$status = true;
		}else{
			$status = false;
		}
	}
	return $status;
	
}
