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
        $sql = "SELECT 
        u.id,
        u.primer_nombre,
        u.segundo_nombre,
        u.primer_apellido,
        u.segundo_apellido,
        u.telefono,
        TRUNCATE(DATEDIFF(CURRENT_DATE, STR_TO_DATE(u.fecha_nacimiento, '%Y-%m-%d')) / 365.25, 0) AS edad
        FROM usuarios AS u";

        try {

                $resultado = $this->conn->prepare($sql);
                $resultado->execute();
                if ($resultado->rowCount() === 0) {
                    $mensajeError = "No hay usuarios registrados.\n";
                    return $mensajeError;
                } else {
                    $usuarios = $resultado->fetchAll(PDO::FETCH_ASSOC);
                    return $usuarios;
                }

                foreach ($usuarios as $usuario) {
                    $id = $usuario["id"];
                    $nombre_completo = $usuario["primer_nombre"] ." ". $usuario["segundo_nombre"] ." ". $usuario["primer_apellido"] ." ". $usuario["segundo_apellido"];
                    $edad = $usuario["edad"];
                    $telefono = $usuario["telefono"];
                
                    echo "ID: $id | Nombre: $nombre_completo | Edad: $edad años | Teléfono: $telefono\n";
                }    
            }catch (PDOException $e) {
                echo "Error al listar usuarios: " . $e->getMessage() . "\n";
            }
    }

    public function obtenerUsuario($id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':id', $id, PDO::PARAM_INT); 

        $resultado->execute();
        if ($resultado->rowCount() === 0) {
            $mensajeError = "No hay usuarios registrados.\n";
            return $mensajeError;
        } else {
            $usuario = $resultado->fetch(PDO::FETCH_ASSOC);
            return $usuario;
        }
    }

    public function crearUsuario($datos)
    {
        foreach (['primer_nombre', 'primer_apellido', 'telefono', 'correo', 'fecha_nacimiento', 'direccion'] as $campo) {
            if (empty($datos[$campo])) {
                echo "El campo '$campo' es obligatorio.\n";
                return false;
            }
        }

        $sql = "INSERT INTO usuarios (primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, telefono, correo, fecha_nacimiento, direccion)
        VALUES (:primer_nombre, :segundo_nombre, :primer_apellido, :segundo_apellido, :telefono, :correo, :fecha_nacimiento, :direccion)";

        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':primer_nombre', $datos['primer_nombre']);
        $resultado->bindParam(':segundo_nombre', $datos['segundo_nombre']);
        $resultado->bindParam(':primer_apellido', $datos['primer_apellido']);
        $resultado->bindParam(':segundo_apellido', $datos['segundo_apellido']);
        $resultado->bindParam(':telefono', $datos['telefono']);
        $resultado->bindParam(':correo', $datos['correo']);
        $resultado->bindParam(':fecha_nacimiento', $datos['fecha_nacimiento']);
        $resultado->bindParam(':direccion', $datos['direccion']);

        return $resultado->execute();
    }

    public function actualizarUsuario(
        $id,
        $primer_nombre,
        $primer_apellido,
        $segundo_apellido,
        $telefono,
        $correo,
        $fecha_nacimiento,
        $direccion
    ) {
        $sql = "UPDATE usuarios SET 
                    primer_nombre = :primer_nombre,
                    primer_apellido = :primer_apellido,
                    segundo_apellido = :segundo_apellido,
                    telefono = :telefono,
                    correo = :correo,
                    fecha_nacimiento = :fecha_nacimiento,
                    direccion = :direccion
                WHERE id = :id";
    
        $resultado = $this->conn->prepare($sql);
    
        $resultado->bindParam(':primer_nombre', $primer_nombre);
        $resultado->bindParam(':primer_apellido', $primer_apellido);
        $resultado->bindParam(':segundo_apellido', $segundo_apellido);
        $resultado->bindParam(':telefono', $telefono);
        $resultado->bindParam(':correo', $correo);
        $resultado->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $resultado->bindParam(':direccion', $direccion);
        $resultado->bindParam(':id', $id, PDO::PARAM_INT);
    
        if ($resultado->execute()) {
            if ($resultado->rowCount() === 0) {
                $mensajeError = "No hay usuarios registrados.\n";
                return $mensajeError;
            } else {
                return "Usuario actualizado correctamente.";
            }
        } else {
            return "Error al actualizar el usuario.";
        }
    }

    public function eliminarUsuario($id)
    {
    $sql = "DELETE FROM usuarios WHERE id = :id";
    $resultado = $this->conn->prepare($sql);
    $resultado->bindParam(':id', $id, PDO::PARAM_INT);

        if ($resultado->execute()) {
            if ($resultado->rowCount() === 0) {
                $mensajeError = "No hay usuarios registrados.\n";
                return $mensajeError;
            } else {
                return "Usuario Eliminado correctamente..";
            }    
        } else {
            return "Error: al eliminar el usuario";
        }
    }   
}

