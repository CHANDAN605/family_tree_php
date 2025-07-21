<?php
require_once '../config/Database.php';

class Member {
    private $db;
    private $pdo;

    public function __construct() {
        $this->db = new Database();
        $this->pdo = $this->db->getConnection();
    }

    // Get all members from the database
    public function getAllMembers() {
        $stmt = $this->pdo->query("SELECT * FROM members ORDER BY name");
        return $stmt->fetchAll();
    }

    // Get children by their parent ID (or top-level if parentId is null)
    public function getChildrenByParentId($parentId) {
        if ($parentId === null) {
            $stmt = $this->pdo->query("SELECT * FROM members WHERE parent_id IS NULL ORDER BY name");
        } else {
            $stmt = $this->pdo->prepare("SELECT * FROM members WHERE parent_id = ? ORDER BY name");
            $stmt->execute([$parentId]);
        }
        return $stmt->fetchAll();
    }

    // Get all members that can be selected as a parent (excluding self & descendants)
    public function getPotentialParents($excludeId = null) {
        if ($excludeId) {
            $descendants = $this->getAllDescendants($excludeId);
            $excludeIds = array_merge([$excludeId], $descendants);
            $placeholders = rtrim(str_repeat('?,', count($excludeIds)), ',');
            $stmt = $this->pdo->prepare("SELECT * FROM members WHERE id NOT IN ($placeholders) ORDER BY name");
            $stmt->execute($excludeIds);
        } else {
            $stmt = $this->pdo->query("SELECT * FROM members ORDER BY name");
        }
        return $stmt->fetchAll();
    }

    // Recursively get all descendants (children, grandchildren, etc.)
    private function getAllDescendants($memberId) {
        $descendants = [];
        $stmt = $this->pdo->prepare("SELECT id FROM members WHERE parent_id = ?");
        $stmt->execute([$memberId]);
        $children = $stmt->fetchAll();

        foreach ($children as $child) {
            $descendants[] = $child['id'];
            $descendants = array_merge($descendants, $this->getAllDescendants($child['id']));
        }

        return $descendants;
    }

    // Add a new member to the tree
    public function addMember($name, $parentId = null) {
        // Prevent circular relationship
        if ($parentId && $this->wouldCreateCircularRelationship($parentId, null)) {
            return ['success' => false, 'message' => 'Cannot add member: would create circular relationship'];
        }

        try {
            $stmt = $this->pdo->prepare("INSERT INTO members (name, parent_id) VALUES (?, ?)");
            $result = $stmt->execute([$name, $parentId ?: null]);

            if ($result) {
                return ['success' => true, 'message' => 'Member added successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to add member'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    // Check if adding a parent would create a circular reference
    private function wouldCreateCircularRelationship($newParentId, $memberId) {
        if (!$newParentId || !$memberId) return false;
        $descendants = $this->getAllDescendants($memberId);
        return in_array($newParentId, $descendants);
    }

    // Build the visual tree HTML recursively
    public function buildFamilyTree($parentId = null, $level = 0) {
        $children = $this->getChildrenByParentId($parentId);
        $tree = '';

        foreach ($children as $child) {
            $indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level);
            $bullet = $level > 0 ? '○ ' : '● ';

            $tree .= '<div class="tree-item" data-id="' . $child['id'] . '" data-level="' . $level . '">';
            $tree .= $indent . $bullet . htmlspecialchars($child['name']);
            $tree .= '</div>';

            // Recursively render child members
            $tree .= $this->buildFamilyTree($child['id'], $level + 1);
        }

        return $tree;
    }
}
?>
