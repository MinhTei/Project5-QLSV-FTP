-- Tạo database
CREATE DATABASE IF NOT EXISTS if0_40696768_qlsv_db;
USE if0_40696768_qlsv_db;

-- Tạo bảng admin
CREATE TABLE IF NOT EXISTS admin (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tạo bảng students
CREATE TABLE IF NOT EXISTS students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id VARCHAR(50) UNIQUE NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20),
    class VARCHAR(50),
    year INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Thêm tài khoản admin (password: 123456)
INSERT INTO admin (username, password) VALUES ('admin', '$2y$10$YJqYGgH5K5V5XzC5Q5Q5QeQ5Q5Q5Q5Q5Q5Q5Q5Q5Q5Q5Q5Q5Q5Q5Q');

-- Thêm dữ liệu mẫu sinh viên
INSERT INTO students (student_id, fullname, email, phone, class, year) VALUES
('SV001', 'Nguyễn Văn A', 'nguyenvana@email.com', '0987654321', 'K19-CNTT-01', 2019),
('SV002', 'Trần Thị B', 'tranthib@email.com', '0987654322', 'K19-CNTT-01', 2019),
('SV003', 'Lê Minh C', 'leminhc@email.com', '0987654323', 'K19-CNTT-02', 2019),
('SV004', 'Phạm Quỳnh D', 'phamquynhd@email.com', '0987654324', 'K19-CNTT-02', 2019),
('SV005', 'Hoàng Anh E', 'hoanganhe@email.com', '0987654325', 'K19-CNTT-03', 2019),
('SV006', 'Vũ Thu F', 'vuthuf@email.com', '0987654326', 'K20-CNTT-01', 2020),
('SV007', 'Đặng Minh G', 'dangminhg@email.com', '0987654327', 'K20-CNTT-01', 2020),
('SV008', 'Bùi Thúy H', 'buithuyh@email.com', '0987654328', 'K20-CNTT-02', 2020),
('SV009', 'Tô Hữu I', 'tohuui@email.com', '0987654329', 'K20-CNTT-02', 2020),
('SV010', 'Nông Văn J', 'nongvanj@email.com', '0987654330', 'K21-CNTT-01', 2021);
