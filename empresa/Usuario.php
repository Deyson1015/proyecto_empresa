<?php
require_once 'database.php';

class Usuario
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function listarUsuarios(): array
    {
        $sql = "SELECT 
            u.id,
            u.primer_nombre,
            u.segundo_nombre,
            u.primer_apellido,
            u.segundo_apellido,
            u.telefono,
            TRUNCATE(DATEDIFF(CURRENT_DATE, STR_TO_DATE(u.fecha_nacimiento, '%Y-%m-%d')) / 365.25, 0) AS edad
            FROM usuarios AS u";

        $resultado = $this->conn->prepare($sql);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerUsuario($id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':id', $id, PDO::PARAM_INT);
        $resultado->execute();
        return $resultado->fetch(PDO::FETCH_ASSOC);
    }

    public function crearUsuario($datos): bool
    {
        foreach (['primer_nombre', 'primer_apellido', 'telefono', 'correo', 'fecha_nacimiento', 'direccion'] as $campo) {
            if (empty($datos[$campo])) {
                echo "El campo '$campo' es obligatorio.\n";
                return false;
            }
        }

        $sql = "INSERT INTO usuarios 
            (primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, telefono, correo, fecha_nacimiento, direccion)
            VALUES 
            (:primer_nombre, :segundo_nombre, :primer_apellido, :segundo_apellido, :telefono, :correo, :fecha_nacimiento, :direccion)";
        
        $resultado = $this->conn->prepare($sql);
        return $resultado->execute($datos);
    }

    public function actualizarUsuario($id, $datos): string
    {
        $sql = "UPDATE usuarios SET 
            primer_nombre = :primer_nombre,
            segundo_nombre = :segundo_nombre,
            primer_apellido = :primer_apellido,
            segundo_apellido = :segundo_apellido,
            telefono = :telefono,
            correo = :correo,
            fecha_nacimiento = :fecha_nacimiento,
            direccion = :direccion
            WHERE id = :id";
        
        $resultado = $this->conn->prepare($sql);
        $datos['id'] = $id;

        $resultado->execute($datos);
        return $resultado->rowCount() > 0 ? "Usuario actualizado correctamente." : "No se encontró el usuario para actualizar.";
    }

    public function eliminarUsuario($id): string
    {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':id', $id, PDO::PARAM_INT);
        $resultado->execute();

        return $resultado->rowCount() > 0 ? "Usuario eliminado correctamente." : "El usuario con ID $id no existe.";
    }
}