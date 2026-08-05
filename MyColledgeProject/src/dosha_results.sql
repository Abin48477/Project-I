CREATE TABLE IF NOT EXISTS dosha_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    vata_percentage DECIMAL(5,2) DEFAULT 0,
    pitta_percentage DECIMAL(5,2) DEFAULT 0,
    kapha_percentage DECIMAL(5,2) DEFAULT 0,
    dominant_dosha VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
