<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['name'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid input data']);
    exit;
}

$layoutName = $data['name'];

// Load layouts from the JSON file
if (!file_exists('layouts.json')) {
    echo json_encode(['success' => false, 'error' => 'No layouts found.']);
    exit;
}

$layouts = json_decode(file_get_contents('layouts.json'), true);

if (isset($layouts[$layoutName])) {
    echo json_encode(['success' => true, 'content' => $layouts[$layoutName]]);
} else {
    echo json_encode(['success' => false, 'error' => 'Layout not found.']);
}
?>