<?php
/**
 * PDO connection class
 * 
 * @package 
 * @author  Sboniso Nzimande
 */
class PDO_Conn {
    public $last_sql;

    protected $host     = "localhost";
    protected $port 	= 3306;
    protected $user 	= "root";
    protected $pass 	= "";
    protected $dbname  	= "person_management";
    protected $secure  	= FALSE;
    protected $link;
}