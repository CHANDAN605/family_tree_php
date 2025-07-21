<?php
header('Content-Type: application/json');
require_once '../classes/Member.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $parentId = trim($_POST['parent_id'] ?? '');
    
    if (empty($name)) {
        echo json_encode(['success' => false, 'message' => 'Name is required']);
        exit;
    }
    
    $member = new Member();
    $result = $member->addMember($name, $parentId === '' ? null : $parentId);
    
    echo json_encode($result);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
