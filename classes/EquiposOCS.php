<?php
namespace App;
class EquiposOCS extends ActiveRecord {
   
    protected static $ocsAttributes = [
        'ID',
        'deviceid',
        'name',
        'osname',
        'winprodkey',
        'smanufacturer',
        'smodel',
        'ssn',
        'type',
        'archive',
        'hardware_id',
        'result'
    ];

    public function __construct($args = []){
        foreach (static::$ocsAttributes as $attribute) {
            $this->$attribute = $args[$attribute] ?? "";
        }
    }
}