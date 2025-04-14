<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['name']) || !isset($data['content'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid input data']);
    exit;
}

$layoutName = $data['name'];
$layoutContent = $data['content'];

// Load existing layouts from the JSON file
$layouts = [];
if (file_exists('layouts.json')) {
    $layouts = json_decode(file_get_contents('layouts.json'), true);
}

// Add or update the layout
$layouts[$layoutName] = $layoutContent;

// Save the layouts back to the JSON file
file_put_contents('layouts.json', json_encode($layouts));

echo json_encode(['success' => true]);
?>