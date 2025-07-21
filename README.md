# family_tree_php

# 👨‍👩‍👧‍👦 Family Tree Builder - PHP & MySQL

This is a dynamic **Family Tree Application** built using **Core PHP**, **MySQL**, **PDO**, **AJAX**, and **jQuery**. It allows you to **add members**, assign **parent-child relationships**, and dynamically **view the hierarchical family structure** in a visually nested format.

---

## 🚀 Features

- Add and edit family members via a popup modal.
- Select parent for each member from a dropdown.
- Real-time tree view generation using recursion.
- Prevents invalid parent-child assignment loops.
- Clean separation of concerns using OOP (Object-Oriented PHP).
- AJAX-based save and load (no full page reload).
- Uses jQuery and PHP PDO securely.

---

## 🧠 How it Works

1. The `index.php` loads existing family members and renders them as a tree.
2. When a user clicks “Add Member”:
   - A modal appears.
   - Parent selection is optional (root-level if none).
3. Upon clicking “Save changes”:
   - AJAX sends the data to `ajax/add_member.php`.
   - PHP validates and inserts the data.
   - Updated tree is returned and displayed instantly.

---

## 🧬 Database Schema

Run the following SQL to set up your database and table:

```sql
CREATE DATABASE family_tree;

USE family_tree;

CREATE TABLE `members` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `parent_id` INT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## 📁 Project Structure

family_tree_php/
├── ajax/
│ └── add_member.php # Handles AJAX saving logic
│ └── get_parents.php # Handles AJAX get parent logic
│ └── get_tree.php # Handles AJAX to create tree logic
├── classes/
│ └── Member.php # Contains DB logic, tree recursion
├── config/
│ └── Database.php # DB connection using PDO
├── assets/
│ └── js/
│ └── script.js # Handles UI & AJAX logic
├── index.php # Main front-end
├── README.md # This file

---

## 🛠️ Tech Stack

Frontend: HTML, CSS, JavaScript (jQuery)
Backend: Core PHP (OOP), PDO
Database: MySQL

---

## 🧑‍💻 Setup Instructions

1. Clone the repository

```
git clone https://github.com/CHANDAN605/family_tree_php.git
cd family_tree_php

```

2. Create MySQL database and table

Use the provided SQL script above to create the family_tree database and members table.

3. Configure DB connection
   Edit config/Database.php:

```
private $host = "localhost";
private $db_name = "family_tree";
private $username = "root";
private $password = ""; // your password

```

4. Run the project

Place the project inside your local server (e.g., XAMPP’s/htdocs/family_tree_php).
Start Apache and MySQL from XAMPP or similar.
Open in browser:

```
http://localhost/family_tree_php/index.php

```

## 🙋‍♂️ Author

Chandan Yadav
📧 cy2001435@gmail.com
🌐 [GitHub Profile](https://github.com/CHANDAN605)
