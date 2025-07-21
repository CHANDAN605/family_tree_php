<?php
header('Content-Type: application/json');
require_once '../classes/Member.php';

$member = new Member();
$tree = $member->buildFamilyTree();

echo json_encode(['success' => true, 'tree' => $tree]);
?>
