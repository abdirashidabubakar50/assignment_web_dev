Here’s the corrected and properly formatted README.md:

``
# Contact Form Submission Project

This is a simple contact form web project built using **HTML**, **CSS**, **JavaScript (AJAX)**, **PHP**, and **MySQL**.  
It allows users to submit their contact details and a message, which gets saved to a MySQL database and can be viewed in a basic HTML table.

---

## 🗂️ Files Structure

```
assignment_web_dev/
├── Contacts.html     # Form UI (HTML)
├── Contacts.css      # Form styling (CSS)
├── script.js         # AJAX form submission logic
├── Contacts.php      # Handles form POST data (server-side)
├── view.php          # Displays submitted messages from the database
└── README.md         # Project documentation
```

---

## ✅ Features

- Input validation and sanitization using PHP
- AJAX-based form submission (no page reload)
- MySQL database to store submissions
- Display all messages in an HTML table (`view.php`)
- Simple and clean CSS styling

---

## � PHP Code Overview

### 📩 `Contacts.php`

Handles AJAX POST requests. It:
1. Connects to the MySQL database using `mysqli`.
2. Validates and sanitizes input using `filter_var()`.
3. Inserts the form data into the `contacts` table.

```php
<?php
$conn = new mysqli("localhost", "root", "", "contact_form");

// Sanitize inputs
$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
// ... similar for other fields

$stmt = $conn->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $subject, $message);
$stmt->execute();
?>
```

---

### 📄 `view.php`

Connects to the database and displays all form submissions in an HTML table.

```php
<?php
$conn = new mysqli("localhost", "root", "", "contact_form");
$result = $conn->query("SELECT * FROM contacts ORDER BY created_at DESC");

while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['name']}</td><td>{$row['email']}</td>...</tr>";
}
?>
```

---

## 🚀 How to Run Locally

### 🖥️ Option 1: Using XAMPP or WAMP

1. Start **Apache** and **MySQL** from XAMPP/WAMP control panel.
2. Move the `assignment_web_dev/` folder to:
   - `htdocs/` for XAMPP  
   - `www/` for WAMP
3. Open `http://localhost/phpmyadmin` in your browser.
4. Create the database and table:

```sql
CREATE DATABASE contact_form;

USE contact_form;

CREATE TABLE contacts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100),
  subject VARCHAR(255),
  message TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

5. Visit the form page in your browser:
```url
http://localhost/assignment_web_dev/Contacts.html
```

---

### 🧑💻 Option 2: Using Command Line (CLI / WSL / Linux / Mac)

1. Navigate to the project directory:
```bash
cd /path/to/assignment_web_dev
```

2. Start a local PHP server:
```bash
php -S localhost:8000
```

3. Start MySQL server (if not running):
```bash
sudo service mysql start
```

4. Login to MySQL and create the database:
```bash
mysql -u root -p
```

Then run:
```sql
CREATE DATABASE contact_form;
USE contact_form;
CREATE TABLE contacts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100),
  subject VARCHAR(255),
  message TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

5. Open the form in your browser:
```url
http://localhost:8000/Contacts.html
```

---

## 🔧 Troubleshooting

- **"mysqli not found"** – Make sure PHP's `mysqli` extension is enabled.
- **"Access denied for user 'root'"** – Check your DB username/password in `Contacts.php`.
- **"Method Not Allowed (405)"** – Ensure AJAX points to the correct file path and uses the POST method.
- **Form submissions not saving** – Verify the MySQL table structure matches the code.
```