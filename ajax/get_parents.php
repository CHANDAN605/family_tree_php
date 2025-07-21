<?php
header('Content-Type: application/json');
require_once '../classes/Member.php';

$member = new Member();
$parents = $member->getPotentialParents();

echo json_encode(['success' => true, 'parents' => $parents]);
?>
