<?php
class Database {
    
    private static $host = "localhost";
    private static $db_name = "inventariov";
    private static $username = "root";
    private static $password = "";
    private static $conn;

    public static function getConnection() {
    if (self::$conn === null) {
        try {
           
            $dsn = "mysql:host=localhost;port=3306;dbname=inventariov;charset=utf8";
            self::$conn = new PDO($dsn, "root", "");
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            
            die("Error: El servidor de Base de Datos está apagado. Revisa XAMPP.");
        }
    }
    return self::$conn;
}
}
?>