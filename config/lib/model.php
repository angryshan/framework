<?php
namespace config\lib;

use \config\lib\lssMySql;

class model extends lssMySql {

    public function __construct(){
        $option = conf::get('database','config');
        parent::__construct($option);
    }
}