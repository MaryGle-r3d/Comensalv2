<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../modelo/Comensal.php';

$comensal = new Comensal();
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'listar':
        echo json_encode($comensal->listar());
        break;

    case 'obtener':
        $cedula = $_GET['cedula'] ?? '';
        if (!empty($cedula)) {
            $dato = $comensal->obtener($cedula);
            echo json_encode($dato ?: new stdClass());
        } else {
            echo json_encode(new stdClass());
        }
        break;

    case 'guardar':
        $data = $_POST;

        // Delega completamente la validación al modelo
        $resultado = $comensal->guardar($data);

        // $resultado puede ser ['success' => true] o ['success' => false, 'error' => 'mensaje']
        echo json_encode($resultado);
        break;

    case 'eliminar':
        $cedula = $_POST['cedula'] ?? '';
        if (!empty($cedula)) {
            $resultado = $comensal->eliminar($cedula);
            if ($resultado) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Error al eliminar en la base de datos']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Cédula inválida']);
        }
        break;

    default:
        echo json_encode(['success' => false, 'error' => 'Acción no válida']);
        break;
}
