<?php
require_once __DIR__ . '/../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}
$payload = json_decode(file_get_contents('php://input'), true);
$id = isset($payload['id']) ? (int) $payload['id'] : 0;
if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID inválido']);
    exit;
}

$ok = $movieController->delete($id);

echo json_encode([
    'success' => $ok,
    'message' => $ok ? 'Película eliminada correctamente' : 'No se pudo eliminar la película',
]);