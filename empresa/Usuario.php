<?php

require_once 'database.php';

class Usuario
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function listarUsuarios()
    {
        // Lógica para obtener todos los usuarios
    }

    public function obtenerUsuario($id)
    {
        // Lógica para obtener un usuario por ID
    }

    public function crearUsuario($datos)
    {
        $sql = "INSERT INTO usuarios (primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, documento, telefono, correo, fecha_nacimiento, direccion)
        VALUES (:primer_nombre, :segundo_nombre, :primer_apellido, :segundo_apellido, :documento, :telefono, :correo, :fecha_nacimiento, :direccion)";

        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':primer_nombre', $datos['primer_nombre']);
        $resultado->bindParam(':segundo_nombre', $datos['segundo_nombre']);
        $resultado->bindParam(':primer_apellido', $datos['primer_apellido']);
        $resultado->bindParam(':segundo_apellido', $datos['segundo_apellido']);
        $resultado->bindParam(':documento', $datos['documento']);
        $resultado->bindParam(':telefono', $datos['telefono']);
        $resultado->bindParam(':correo', $datos['correo']);
        $resultado->bindParam(':fecha_nacimiento', $datos['fecha_nacimiento']);
        $resultado->bindParam(':direccion', $datos['direccion']);

        return $resultado->execute();
    }

    public function actualizarUsuario()
    {
        // Lógica para actualizar un usuario
    }

    public function eliminarUsuario($id)
    {
        // Lógica para eliminar un usuario
    }
}
