<?php
	/*esta es la clase para hacer la conexion a ldap*/
	class Conexion{
		var $server_ldap = "192.168.120.120";
		var $dn = "cn=feria,dc=transportespitic,dc=com";
		var $password = "sistemaspitic";

		function __contruct(){
		
		}
		
		function conectarLDAP(){
			$con = ldap_connect($this->server_ldap);
			$anon = ldap_bind( $con );
			if(!$anon){
				$con=ldap_connect('ldapbackup.tpitic.com.mx');
			}
			if ($con) {
			$bind=ldap_bind($con, $this->dn, $this->password)or die("Can't bind to server.");
			return $con;
			}else{
				return null;
			}
		}
	} 
?>