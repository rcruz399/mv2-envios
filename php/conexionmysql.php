<?php
class Mysqldb
{
    //archivo para establecer la coneccion con la base de datos MYSQL
    public function conexmysql()
    {
        try{
            $enlace = mysqli_connect("192.168.100.117","userinfra","Infrest0ct0ch0","Infraestructura");
            return $enlace; 
          }catch(Exception $ex){
              die($ex->getMessage());
          }
    }

    public function conexmysql2()
    {
        try{
            $enlace = mysqli_connect("localhost","root","","seguimiento_moviles");
            return $enlace; 
          }catch(Exception $ex){
              die($ex->getMessage());
          }
    }
}

