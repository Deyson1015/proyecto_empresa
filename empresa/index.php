<?php
require_once 'Usuario.php';

$usuario = new Usuario();

function mostrarMenu(): void
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
            $datos = [];
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

            echo $usuario->crearUsuario($datos) ? "Usuario creado correctamente.\n" : "Error al crear el usuario.\n";
            break;

        case 2:
            $usuarios = $usuario->listarUsuarios();
            if (empty($usuarios)) {
                echo "No hay usuarios registrados.\n";
            } else {
                foreach ($usuarios as $u) {
                    echo "ID: {$u['id']} | Nombre: {$u['primer_nombre']} {$u['segundo_nombre']} {$u['primer_apellido']} {$u['segundo_apellido']} | Edad: {$u['edad']} años | Teléfono: {$u['telefono']}\n";
                }
            }
            break;

        case 3:
            echo "Ingrese el ID del usuario: ";
            $id = trim(fgets(STDIN));
            if (ctype_digit($id)) {
                $res = $usuario->obtenerUsuario((int)$id);
                if ($res) {
                    foreach ($res as $key => $value) {
                        echo ucfirst($key) . ": $value\n";
                    }
                } else {
                    echo "No se encontró ningún usuario con ese ID.\n";
                }
            } else {
                echo "ID inválido.\n";
            }
            break;

        case 4:
            $usuarios = $usuario->listarUsuarios();
            if (empty($usuarios)) {
                echo "No hay usuarios registrados.\n";
                break;
            }
            foreach ($usuarios as $u) {
                echo "ID: {$u['id']} | Nombre: {$u['primer_nombre']} {$u['primer_apellido']}\n";
            }

            echo "Ingrese el ID del usuario a actualizar: ";
            $id = trim(fgets(STDIN));
            if (!ctype_digit($id)) {
                echo "ID inválido.\n";
                break;
            }

            $datos = [];
            echo "Nuevo primer nombre: ";
            $datos['primer_nombre'] = trim(fgets(STDIN));
            echo "Nuevo segundo nombre: ";
            $datos['segundo_nombre'] = trim(fgets(STDIN));
            echo "Nuevo primer apellido: ";
            $datos['primer_apellido'] = trim(fgets(STDIN));
            echo "Nuevo segundo apellido: ";
            $datos['segundo_apellido'] = trim(fgets(STDIN));
            echo "Nuevo teléfono: ";
            $datos['telefono'] = trim(fgets(STDIN));
            echo "Nuevo correo: ";
            $datos['correo'] = trim(fgets(STDIN));
            echo "Nueva fecha de nacimiento (YYYY-MM-DD): ";
            $datos['fecha_nacimiento'] = trim(fgets(STDIN));
            echo "Nueva dirección: ";
            $datos['direccion'] = trim(fgets(STDIN));

            echo $usuario->actualizarUsuario((int)$id, $datos) . "\n";
            break;

        case 5:
            $usuarios = $usuario->listarUsuarios();
            if (empty($usuarios)) {
                echo "No hay usuarios para eliminar.\n";
                break;
            }
            foreach ($usuarios as $u) {
                echo "ID: {$u['id']} | Nombre: {$u['primer_nombre']} {$u['primer_apellido']}\n";
            }
            echo "Ingrese el ID del usuario a eliminar: ";
            $id = trim(fgets(STDIN));
            if (ctype_digit($id)) {
                echo $usuario->eliminarUsuario((int)$id) . "\n";
            } else {
                echo "ID inválido.\n";
            }
            break;

        case 6:
            echo "Saliendo...\n";
            exit;

        default:
            echo "Opción inválida. Intente de nuevo.\n";
    }
} while (true);
