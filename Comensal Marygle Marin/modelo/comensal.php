<?php
require_once 'Conexion.php';

class Comensal {
    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function listar() {
        $stmt = $this->db->query("SELECT * FROM comensal ORDER BY cedula ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($cedula) {
        $stmt = $this->db->prepare("SELECT * FROM comensal WHERE cedula = ?");
        $stmt->execute([$cedula]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function guardar($data) {
        // Validación de campos requeridos
        $requeridos = ['cedula', 'nombre', 'apellido', 'tipo', 'direccion', 'telefono', 'departamento'];
        foreach ($requeridos as $campo) {
            if (empty($data[$campo])) {
                return ['success' => false, 'error' => "El campo '$campo' es obligatorio"];
            }
        }

        // Validar que la cédula y el teléfono sean numéricos
        if (!ctype_digit($data['cedula'])) {
            return ['success' => false, 'error' => "La cédula debe contener solo números"];
        }

        if (!ctype_digit($data['telefono'])) {
            return ['success' => false, 'error' => "El teléfono debe contener solo números"];
        }

        // Validar que nombre y apellido contengan solo letras y espacios
        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u', $data['nombre'])) {
            return ['success' => false, 'error' => "El nombre solo debe contener letras"];
        }

        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u', $data['apellido'])) {
            return ['success' => false, 'error' => "El apellido solo debe contener letras"];
        }

        // Validar que el tipo sea uno de los valores permitidos
        $tiposValidos = ['Estudiante', 'Docente', 'Administrativo', 'Obrero'];
        if (!in_array($data['tipo'], $tiposValidos)) {
            return ['success' => false, 'error' => "Tipo inválido"];
        }

        // Verificar si ya existe
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM comensal WHERE cedula = ?");
        $stmt->execute([$data['cedula']]);
        $existe = $stmt->fetchColumn();

        if ($existe) {
            // Actualizar si ya existe
            $stmt = $this->db->prepare("UPDATE comensal SET nombre = ?, apellido = ?, tipo = ?, direccion = ?, telefono = ?, departamento = ? WHERE cedula = ?");
            $resultado = $stmt->execute([
                $data['nombre'],
                $data['apellido'],
                $data['tipo'],
                $data['direccion'],
                $data['telefono'],
                $data['departamento'],
                $data['cedula']
            ]);
        } else {
            // Insertar si no existe
            $stmt = $this->db->prepare("INSERT INTO comensal (cedula, nombre, apellido, tipo, direccion, telefono, departamento) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $resultado = $stmt->execute([
                $data['cedula'],
                $data['nombre'],
                $data['apellido'],
                $data['tipo'],
                $data['direccion'],
                $data['telefono'],
                $data['departamento']
            ]);
        }

        return $resultado
            ? ['success' => true]
            : ['success' => false, 'error' => 'Error al guardar en la base de datos'];
    }

    public function eliminar($cedula) {
        $stmt = $this->db->prepare("DELETE FROM comensal WHERE cedula = ?");
        return $stmt->execute([$cedula]);
    }
}
