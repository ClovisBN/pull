<?php
namespace App\Utility;
use \PDO;

class DataBase {
    
    private $dsn;
    private static $_instance;

    protected function __construct() 
    {
        $callBd = parse_ini_file(__DIR__ . '/../Utility/config.ini');
        
        try {
            $this->dsn = new PDO(
                "mysql:host={$callBd['DB_HOST']};dbname={$callBd['DB_NAME']};charset=utf8",
                $callBd['DB_USERNAME'],
                $callBd['DB_PASSWORD'],
            );
        } 
        catch (\Exception $e) {
            echo $e->getMessage();
        } 
    }
    
    public static function connectPDO() { 
        // on vérifie si une instance existe déjà, sinon on la créé 
        
        if (empty(self::$_instance)) 
        { 
            self::$_instance = new Database(); 
        } 
        return self::$_instance->dsn; 
    }
}

?>