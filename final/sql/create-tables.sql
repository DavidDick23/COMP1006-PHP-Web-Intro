-- =========================================================================
-- Users Table
-- =========================================================================
CREATE TABLE users
(
    id           INT AUTO_INCREMENT PRIMARY KEY,
    username     VARCHAR(50)  NOT NULL UNIQUE,
    email        VARCHAR(150) NOT NULL UNIQUE,
    password     VARCHAR(255) NOT NULL,          
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================================================================
-- File Uploads Table
-- =========================================================================
CREATE TABLE file_uploads
(
    id            INT AUTO_INCREMENT PRIMARY KEY,
    user_id       INT          NOT NULL,
    original_name VARCHAR(255) NOT NULL,
    stored_name   VARCHAR(255) NOT NULL,          
    file_type     VARCHAR(100) NOT NULL,
    file_size     INT          NOT NULL,          
    uploaded_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);