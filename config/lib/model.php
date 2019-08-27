<?php
namespace config\lib;

use lss\mysql\lssMySql;

class model extends lssMySql {

    public function __construct(){
        $option = conf::get('database','config');
        parent::__construct($option);
    }
}