-- Категории туров
CREATE TABLE categories (
                            id BIGINT AUTO_INCREMENT PRIMARY KEY,
                            name VARCHAR(255) NOT NULL,
                            slug VARCHAR(255) UNIQUE NOT NULL,
                            description TEXT,
                            image_url VARCHAR(255),
                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Туры
CREATE TABLE tours (
                       id BIGINT AUTO_INCREMENT PRIMARY KEY,
                       category_id BIGINT NOT NULL,
                       name VARCHAR(255) NOT NULL,
                       slug VARCHAR(255) UNIQUE NOT NULL,
                       description LONGTEXT,
                       price DECIMAL(10,2) NOT NULL,
                       duration_days INT,
                       start_date DATE,
                       end_date DATE,
                       max_participants INT,
                       is_active BOOLEAN DEFAULT TRUE,
                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                       updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                       FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- Бронирования
CREATE TABLE bookings (
                          id BIGINT AUTO_INCREMENT PRIMARY KEY,
                          user_id BIGINT NOT NULL,
                          tour_id BIGINT NOT NULL,
                          booking_date DATE NOT NULL,
                          participants INT NOT NULL,
                          status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
                          total_price DECIMAL(10,2),
                          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                          updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                          FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                          FOREIGN KEY (tour_id) REFERENCES tours(id) ON DELETE CASCADE
);

-- Отзывы
CREATE TABLE reviews (
                         id BIGINT AUTO_INCREMENT PRIMARY KEY,
                         user_id BIGINT NOT NULL,
                         tour_id BIGINT NOT NULL,
                         rating TINYINT CHECK (rating BETWEEN 1 AND 5),
                         comment TEXT,
                         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                         FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                         FOREIGN KEY (tour_id) REFERENCES tours(id) ON DELETE CASCADE
);

-- Медиа (изображения для тура/категории)
CREATE TABLE media (
                       id BIGINT AUTO_INCREMENT PRIMARY KEY,
                       model_type VARCHAR(255) NOT NULL, -- 'App\Models\Tour' или 'App\Models\Category'
                       model_id BIGINT NOT NULL,
                       file_path VARCHAR(255) NOT NULL,
                       file_name VARCHAR(255),
                       mime_type VARCHAR(100),
                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                       INDEX idx_model (model_type, model_id)
);

-- Платежи (если нужна история оплат)
CREATE TABLE payments (
                          id BIGINT AUTO_INCREMENT PRIMARY KEY,
                          booking_id BIGINT NOT NULL,
                          amount DECIMAL(10,2) NOT NULL,
                          status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
                          payment_method VARCHAR(100),
                          transaction_id VARCHAR(255),
                          paid_at TIMESTAMP NULL,
                          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                          FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE
);
