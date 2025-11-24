CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    phone VARCHAR(20),
    dob DATE NULL,
    gender ENUM('Male', 'Female', 'Other') NULL,
    address TEXT NULL,
    country VARCHAR(100) NULL,
    security_question VARCHAR(255) NOT NULL,
    security_answer VARCHAR(255) NOT NULL,
    referral_code VARCHAR(50) NULL,
    subscribe_newsletter TINYINT(1) DEFAULT 0,
    receive_updates TINYINT(1) DEFAULT 0,
    promotional_offers TINYINT(1) DEFAULT 0,
    account_type ENUM('Personal', 'Business') DEFAULT 'Personal',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;