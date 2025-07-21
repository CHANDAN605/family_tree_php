-- Create database and table for family tree
CREATE DATABASE IF NOT EXISTS family_tree;
USE family_tree;

CREATE TABLE IF NOT EXISTS members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    parent_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES members(id) ON DELETE CASCADE
);

-- Insert sample data
INSERT INTO members (name, parent_id) VALUES
('Abhijeet', NULL),
('Albrito', 1),
('Bala', 2),
('Sadashiv', 2),
('Sid', 1),
('Raghven', 5),
('Arwind', 6),
('david', 7),
('sarves', 7),
('anup', 7),
('Manjiri', 6),
('Vasim Kudle', 6),
('Sanel', NULL),
('Mohit', 13),
('Kapil', NULL),
('Adam', NULL),
('Test User 1', NULL),
('Test User 2', 17),
('Test User 3', 18);
