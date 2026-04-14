-- SQL to create the blog_posts table
CREATE TABLE IF NOT EXISTS blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content LONGTEXT NOT NULL,
    category VARCHAR(100),
    image_path VARCHAR(255),
    author_name VARCHAR(100) NOT NULL,
    status ENUM('Draft', 'Published') DEFAULT 'Draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- SQL to create categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- SQL to create courses table
CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    duration VARCHAR(50) NOT NULL,
    image_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- SQL to create enrollments table
CREATE TABLE IF NOT EXISTS enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(255) NOT NULL,
    student_email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    course_id INT NOT NULL,
    payment_slip VARCHAR(255),
    status ENUM('Pending', 'Approved', 'Declined') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id)
);

-- Sample Data for Categories
INSERT INTO categories (name) VALUES ('Basic'), ('Intermediate'), ('Advanced');

-- Sample Data for Courses
INSERT INTO courses (category_id, title, description, price, duration, image_path) VALUES 
(1, 'English for Beginners', 'Start your journey with the fundamentals...', 199.00, '8 Weeks', 'assets/images/courses/basic.jpg'),
(2, 'Business Communication', 'Enhance your professional skills...', 299.00, '10 Weeks', 'assets/images/courses/business.jpg'),
(3, 'IELTS Preparation', 'Intensive training for the IELTS exam...', 399.00, '12 Weeks', 'assets/images/courses/ielts.jpg');

-- Sample Data for Enrollments
INSERT INTO enrollments (student_name, student_email, phone, course_id, status) VALUES 
('John Doe', 'john@example.com', '+1 234 567 890', 3, 'Pending'),
('Jane Smith', 'jane@example.com', '+1 987 654 321', 2, 'Approved'),
('Michael Brown', 'michael@example.com', '+1 555 444 333', 1, 'Pending');
