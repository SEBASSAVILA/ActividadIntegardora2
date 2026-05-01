<?php
class Database {
    // 1. Las propiedades deben ser estáticas también
    private static $host = "localhost";
    private static $db_name = "inventariov";
    private static $username = "root";
    private static $password = "";
    private static $conn;

    public static function getConnection() {
        self::$conn = null; // Usamos self:: en lugar de $this->
        try {
            // 2. Aquí también cambiamos $this por self::
            $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db_name;
            self::$conn = new PDO($dsn, self::$username, self::$password);
            
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "¡Error de conexión!: " . $exception->getMessage();
        }
        return self::$conn;
    }
}
?>