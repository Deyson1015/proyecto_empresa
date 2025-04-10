<?php

require_once 'Usuario.php';

$usuario = new Usuario();

function mostrarMenu()
{
    echo "\n--- MENÚ DE USUARIOS ---\n";
    echo "1. Crear usuario\n";
    echo "2. Listar usuarios\n";
    echo "3. Obtener usuario por ID\n";
    echo "4. Actualizar usuario\n";
    echo "5. Eliminar usuario\n";
    echo "6. Salir\n";
    echo "Seleccione una opción: ";
}

do {
    mostrarMenu();
    $opcion = trim(fgets(STDIN));

    switch ($opcion) {
        case 1:
            echo "Ingrese el primer nombre: ";
            $datos['primer_nombre'] = trim(fgets(STDIN));
            echo "Ingrese el segundo nombre: ";
            $datos['segundo_nombre'] = trim(fgets(STDIN));
            echo "Ingrese el primer apellido: ";
            $datos['primer_apellido'] = trim(fgets(STDIN));
            echo "Ingrese el segundo apellido: ";
            $datos['segundo_apellido'] = trim(fgets(STDIN));
            echo "Ingrese el teléfono: ";
            $datos['telefono'] = trim(fgets(STDIN));
            echo "Ingrese el correo: ";
            $datos['correo'] = trim(fgets(STDIN));
            echo "Ingrese la fecha de nacimiento (YYYY-MM-DD): ";
            $datos['fecha_nacimiento'] = trim(fgets(STDIN));
            echo "Ingrese la dirección: ";
            $datos['direccion'] = trim(fgets(STDIN));

            if ($usuario->crearUsuario($datos)) {
                echo "Usuario creado correctamente.\n";
            } else {
                echo "Error al crear el usuario.\n";
            }
            break;

        case 2:
            echo "--- Lista de Usuarios ---\n";
            $usuarios = $usuario->listarUsuarios();
            
            if (empty($usuarios)) {
                echo "No hay usuarios registrados.\n";
            }
            break;

        case 3:
            $usuario->listarUsuarios();
            if (empty($usuarios)) {
                echo "No hay usuarios para actualizar.\n";
                break;
            }

            echo "Ingrese el ID del usuario: ";
            $id = trim(fgets(STDIN));

            if (!ctype_digit($id)) {
                echo "El ID debe ser un número entero positivo.\n";
            } else {
                $id = (int)$id; 

                $resultado = $usuario->obtenerUsuario($id);
                if ($resultado) {
                    echo " Usuario encontrado:\n";
                    foreach ($resultado as $key => $value) {
                        echo ucfirst($key) . ": $value\n";
                    }
                } else {
                    echo "No se encontró ningún usuario con ese ID.\n";
                }
            }
            break;

        case 4:
            $usuario->listarUsuarios();
            if (empty($usuarios)) {
                echo "No hay usuarios Registrados.\n";
                break;
            }
            echo "Ingrese el ID del usuario a actualizar: ";
            $id = trim(fgets(STDIN));
            
            if (!ctype_digit($id)) {
                echo "El ID debe ser un número entero positivo.\n";
            } else {
                $id = (int)$id; 
            
                echo "Nuevo Primer nombre: ";
                $primer_nombre = trim(fgets(STDIN));
                echo "Nuevo Segundo nombre: ";
                $segundo_nombre = trim(fgets(STDIN));
                echo "Nuevo Primer apellido: ";
                $primer_apellido = trim(fgets(STDIN));
                echo "Nuevo segundo apellido: ";
                $segundo_apellido = trim(fgets(STDIN));
                echo "Nuevo teléfono: ";
                $telefono = trim(fgets(STDIN));
                echo "Nuevo correo: ";
                $correo = trim(fgets(STDIN));
                echo "Nueva fecha de nacimiento (YYYY-MM-DD): ";
                $fecha_nacimiento = trim(fgets(STDIN));
                echo "Nueva dirección: ";
                $direccion = trim(fgets(STDIN));
            
                $mensaje = $usuario->actualizarUsuario(
                    $id,
                    $primer_nombre,
                    $segundo_nombre,
                    $primer_apellido,
                    $segundo_apellido,
                    $telefono,
                    $correo,
                    $fecha_nacimiento,
                    $direccion
                );
                echo $mensaje . "\n";
            }
            break;
            
        case 5:
            
            $usuario->listarUsuarios();
            if (empty($usuarios)) {
                echo "No hay usuarios para eliminar. \n";
                break;
            }
            echo "Ingrese el ID del usuario a eliminar: ";
            $id = trim(fgets(STDIN));
            
            if (!ctype_digit($id)) {
                echo "El ID debe ser un número entero positivo.\n";
            } else {
                    $id = (int)$id;
                if ($usuario->eliminarUsuario($id)) {
                    echo "Usuario eliminado correctamente.\n";
                } else {
                    echo "No se pudo eliminar el usuario.\n";
                }
            }
            break;

        case 6:
            echo "Saliendo del programa.\n";
            exit;

        default:
            echo "Opción inválida. Intente de nuevo.\n";
    }

} while (true);
