<?php
class Conexion
{
    private $connection;
    private $host;
    private $username;
    private $password;
    private $db;
    private $port;

    public function __construct()
    {
        $this->connection = null;
        $this->host = 'localhost';
        $this->port = 3306;
        $this->db = 'BD-betrayal';
        $this->username = 'root';
        $this->password = '';
    }

    public function getConnection()
    {
        try {
            $this->connection = mysqli_connect($this->host, $this->username, $this->password, $this->db, $this->port);
            mysqli_set_charset($this->connection, 'utf8');
            if (!$this->connection) {
                throw new Exception("Error en la conexión: " . mysqli_connect_error());
            }
            return $this->connection;
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Error al conectar a la base de datos.']);
            exit;
        }
    }

    public function closeConnection()
    {
        if ($this->connection) {
            mysqli_close($this->connection);
        }
    }
}
?>