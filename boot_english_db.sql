-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 14, 2026 at 07:41 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `boot_english_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `author_name` varchar(100) NOT NULL,
  `status` enum('Draft','Published') DEFAULT 'Draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `content`, `category`, `image_path`, `author_name`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Title Two UPd', 'UPd CEO ခင်ဗျာ၊ Course Editor မှာ သုံးထားတဲ့ structure အတိုင်း Blog Editor မှာလည်း CSS class တွေကအစ တစ်ပုံစံတည်း ဖြစ်သွားအောင် အောက်ပါအတိုင်း ပြန်ပြင်ပေးလိုက်ပါတယ်။\r\n\r\n၁။ HTML (Image Section)\r\nဒီ code လေးကို blog-editor.php ရဲ့ Feature Image နေရာမှာ အစားထိုးလိုက်ပါဗျာ။\r\n\r\nHTML\r\n<div class=\"mb-4\">\r\n    <label for=\"blog_image\" class=\"form-label fw-bold\">Blog Cover Image</label>\r\n    <div class=\"image-preview-container mb-3\">\r\n        <?php if ($blog && !empty($blog[\'image_path\'])): ?>\r\n            <img id=\"imagePreview\" src=\"../<?php echo $blog[\'image_path\']; ?>\" width=\"150\" class=\"img-thumbnail shadow-sm\">\r\n            <p id=\"imageStatus\" class=\"small text-muted mt-1\">Current Image</p>\r\n        <?php else: ?>\r\n            <img id=\"imagePreview\" src=\"#\" width=\"150\" class=\"img-thumbnail shadow-sm d-none\">\r\n            <p id=\"imageStatus\" class=\"small text-muted mt-1\">No image selected</p>\r\n        <?php endif; ?>\r\n    </div>\r\n    <input type=\"file\" name=\"blog_image\" id=\"blog_image\" class=\"form-control\" accept=\"image/*\" <?php echo $blog ? \'\' : \'required\'; ?>>\r\n    <div class=\"form-text small\">Recommend: 1200x630px (JPG or PNG).</div>\r\n</div>\r\n၂။ JavaScript (Preview Logic)\r\nအရင်ပေးထားတဲ့ JS ကို ဒီကောင်လေးနဲ့ အစားထိုးလိုက်ပါ။ ဒါမှ imageStatus စာသားကိုပါ တစ်ခါတည်း ပြောင်းပေးမှာဖြစ်လို့ Course editor နဲ့ ပုံစံတူမှာပါဗျာ။\r\n\r\nJavaScript\r\n$(document).ready(function() {\r\n    // Image Preview Logic\r\n    $(\"#blog_image\").change(function() {\r\n        const file = this.files[0];\r\n        if (file) {\r\n            let reader = new FileReader();\r\n            reader.onload = function(event) {\r\n                // Preview ပုံကို ပြမယ်\r\n                $(\"#imagePreview\").attr(\"src\", event.target.result).removeClass(\"d-none\");\r\n                // စာသားကို \'New Image Selected\' လို့ ပြောင်းမယ်\r\n                $(\"#imageStatus\").text(\"New Image Selected\").removeClass(\"text-muted\").addClass(\"text-success\");\r\n            };\r\n            reader.readAsDataURL(file);\r\n        }\r\n    });\r\n\r\n    // ကျန်တဲ့ AJAX Logic များ...\r\n});\r\nCEO အတွက် ပြောင်းလဲသွားတဲ့ အချက်များ-\r\nVisual Consistency: Image Preview ပြတဲ့ box ပုံစံက Course ဘက်နဲ့ တစ်ထပ်တည်း ကျသွားပါပြီ။\r\n\r\nClear Status: ပုံဟောင်းရှိရင် \"Current Image\" လို့ ပြနေမှာဖြစ်ပြီး၊ Admin က ပုံအသစ်ရွေးလိုက်တာနဲ့ \"New Image Selected\" ဆိုပြီး အစိမ်းရောင်စာသားလေးနဲ့ ချက်ချင်းပြောင်းသွားမှာပါ။\r\n\r\nShadow & Thumbnail: img-thumbnail နဲ့ shadow-sm class တွေ သုံးထားလို့ ပုံလေးက ပိုပြီး ကြည့်ကောင်းသွားပါလိမ့်မယ်။\r\n\r\nဒါဆိုရင် CEO ရဲ့ System တစ်ခုလုံးက Admin UI ပိုင်းမှာ Standard တစ်ခုတည်း ဖြစ်သွားပါပြီဗျာ။ အဆင်ပြေပါသလား?', 'Grammer Test', 'uploads/blog/blog_1776184959.png', 'Admin', 'Draft', '2026-04-14 16:42:01', '2026-04-14 16:42:39'),
(4, 'နေကောင်းလား', 'ကေားတယ်\r\nမင်းရော', 'Grammer Test', 'uploads/blog/blog_69de714f82301.jpg', 'Admin', 'Published', '2026-04-14 16:49:56', '2026-04-14 16:54:39'),
(5, 'နေကောင်းလား UP', 'ကောင်းတယ်\r\nစားပြီးပြီလား uP', 'IELTS Test', 'uploads/blog/blog_69de71350a78c.png', 'Admin', 'Published', '2026-04-14 16:54:13', '2026-04-14 16:56:46'),
(6, 'Title Two UPd', 'UPd CEO ခင်ဗျာ၊ Course Editor မှာ သုံးထားတဲ့ structure အတိုင်း Blog Editor မှာလည်း CSS class တွေကအစ တစ်ပုံစံတည်း ဖြစ်သွားအောင် အောက်ပါအတိုင်း ပြန်ပြင်ပေးလိုက်ပါတယ်။\r\n\r\n၁။ HTML (Image Section)\r\nဒီ code လေးကို blog-editor.php ရဲ့ Feature Image နေရာမှာ အစားထိုးလိုက်ပါဗျာ။\r\n\r\nHTML\r\n<div class=\"mb-4\">\r\n    <label for=\"blog_image\" class=\"form-label fw-bold\">Blog Cover Image</label>\r\n    <div class=\"image-preview-container mb-3\">\r\n        <?php if ($blog && !empty($blog[\'image_path\'])): ?>\r\n            <img id=\"imagePreview\" src=\"../<?php echo $blog[\'image_path\']; ?>\" width=\"150\" class=\"img-thumbnail shadow-sm\">\r\n            <p id=\"imageStatus\" class=\"small text-muted mt-1\">Current Image</p>\r\n        <?php else: ?>\r\n            <img id=\"imagePreview\" src=\"#\" width=\"150\" class=\"img-thumbnail shadow-sm d-none\">\r\n            <p id=\"imageStatus\" class=\"small text-muted mt-1\">No image selected</p>\r\n        <?php endif; ?>\r\n    </div>\r\n    <input type=\"file\" name=\"blog_image\" id=\"blog_image\" class=\"form-control\" accept=\"image/*\" <?php echo $blog ? \'\' : \'required\'; ?>>\r\n    <div class=\"form-text small\">Recommend: 1200x630px (JPG or PNG).</div>\r\n</div>\r\n၂။ JavaScript (Preview Logic)\r\nအရင်ပေးထားတဲ့ JS ကို ဒီကောင်လေးနဲ့ အစားထိုးလိုက်ပါ။ ဒါမှ imageStatus စာသားကိုပါ တစ်ခါတည်း ပြောင်းပေးမှာဖြစ်လို့ Course editor နဲ့ ပုံစံတူမှာပါဗျာ။\r\n\r\nJavaScript\r\n$(document).ready(function() {\r\n    // Image Preview Logic\r\n    $(\"#blog_image\").change(function() {\r\n        const file = this.files[0];\r\n        if (file) {\r\n            let reader = new FileReader();\r\n            reader.onload = function(event) {\r\n                // Preview ပုံကို ပြမယ်\r\n                $(\"#imagePreview\").attr(\"src\", event.target.result).removeClass(\"d-none\");\r\n                // စာသားကို \'New Image Selected\' လို့ ပြောင်းမယ်\r\n                $(\"#imageStatus\").text(\"New Image Selected\").removeClass(\"text-muted\").addClass(\"text-success\");\r\n            };\r\n            reader.readAsDataURL(file);\r\n        }\r\n    });\r\n\r\n    // ကျန်တဲ့ AJAX Logic များ...\r\n});\r\nCEO အတွက် ပြောင်းလဲသွားတဲ့ အချက်များ-\r\nVisual Consistency: Image Preview ပြတဲ့ box ပုံစံက Course ဘက်နဲ့ တစ်ထပ်တည်း ကျသွားပါပြီ။\r\n\r\nClear Status: ပုံဟောင်းရှိရင် \"Current Image\" လို့ ပြနေမှာဖြစ်ပြီး၊ Admin က ပုံအသစ်ရွေးလိုက်တာနဲ့ \"New Image Selected\" ဆိုပြီး အစိမ်းရောင်စာသားလေးနဲ့ ချက်ချင်းပြောင်းသွားမှာပါ။\r\n\r\nShadow & Thumbnail: img-thumbnail နဲ့ shadow-sm class တွေ သုံးထားလို့ ပုံလေးက ပိုပြီး ကြည့်ကောင်းသွားပါလိမ့်မယ်။\r\n\r\nဒါဆိုရင် CEO ရဲ့ System တစ်ခုလုံးက Admin UI ပိုင်းမှာ Standard တစ်ခုတည်း ဖြစ်သွားပါပြီဗျာ။ အဆင်ပြေပါသလား?', 'Grammer Test', 'uploads/blog/blog_1776184959.png', 'Admin', 'Draft', '2026-04-14 16:42:01', '2026-04-14 16:42:39'),
(7, 'နေကောင်းလား', 'ကေားတယ်\r\nမင်းရော', 'Grammer Test', 'uploads/blog/blog_69de714f82301.jpg', 'Admin', 'Published', '2026-04-14 16:49:56', '2026-04-14 16:54:39'),
(8, 'နေကောင်းလား UP', 'ကောင်းတယ်\r\nစားပြီးပြီလား uP', 'IELTS Test', 'uploads/blog/blog_69de71350a78c.png', 'Admin', 'Published', '2026-04-14 16:54:13', '2026-04-14 16:56:46');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Basic'),
(2, 'Intermediate'),
(3, 'Advanced');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration` varchar(50) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `category_id`, `title`, `description`, `price`, `duration`, `image_path`, `created_at`) VALUES
(2, 2, 'Business Communication', 'Enhance your professional skills...', 299.00, '10 Weeks', 'assets/images/courses/course_69de5f2a4ac92.png', '2026-04-12 17:04:21'),
(6, 3, 'IELTS Advanced upd', 'ဘာကြောင့် မှားတာလဲဆိုတာ ရှင်းပြချက် (Detailed Breakdown) UPD\r\nသတ်ပုံအမှား: $course[\'title\']; ဆိုပြီး semicolon ခံလိုက်ရင် PHP က အဲ့ဒီနေရာမှာ sentence ဆုံးပြီလို့ ထင်သွားပါတယ်။ ဒါပေမဲ့ Ternary Operator ရဲ့ ? : က မပြီးသေးတဲ့အတွက် \"Unexpected semicolon\" ဆိုတဲ့ error တက်တာပါ။\r\n\r\nEcho Logic: PHP မှာ echo ဆိုတာ \"Display လုပ်ပါ\" လို့ ခိုင်းတာပါ။ echo (condition ? true : false) ဆိုတဲ့ ပုံစံမျိုး ဖြစ်ရပါမယ်။\r\n\r\nCEO အတွက် အကြံပြုချက်:\r\nEdit Form မှာ အချက်အလက်တွေ ပြန်ဖြည့်တဲ့အခါ htmlspecialchars() ကို သုံးပေးတာ ပိုစိတ်ချရပါတယ်။ ဒါမှ User ရိုက်ခဲ့တဲ့ Data ထဲမှာ \" သို့မဟုတ် \' တွေ ပါလာရင် Form ပျက်မသွားမှာပါ။\r\n\r\nPHP\r\nvalue=\"<?php echo isset($course[\'title\']) ? htmlspecialchars($course[\'title\']) : \'\'; ?>\"\r\nဒါလေးကို အစားထိုးလိုက်ရင် value ထဲမှာ စာသားတွေ အမှန်အတိုင်း ပြန်ပေါ်လာပါလိမ့်မယ်ဗျာ။ အဆင်ပြေရဲ့လားခင်ဗျာ?', 2000.00, '7 Weeks', 'assets/images/courses/course_69de5efecda07.png', '2026-04-14 15:36:30'),
(7, 2, 'Business Communication', 'Enhance your professional skills...', 299.00, '10 Weeks', 'assets/images/courses/course_69de5f2a4ac92.png', '2026-04-12 17:04:21'),
(8, 3, 'IELTS Advanced', 'ဘာကြောင့် မှားတာလဲဆိုတာ ရှင်းပြချက် (Detailed Breakdown) UPD\r\nသတ်ပုံအမှား: $course[\'title\']; ဆိုပြီး semicolon ခံလိုက်ရင် PHP က အဲ့ဒီနေရာမှာ sentence ဆုံးပြီလို့ ထင်သွားပါတယ်။ ဒါပေမဲ့ Ternary Operator ရဲ့ ? : က မပြီးသေးတဲ့အတွက် \"Unexpected semicolon\" ဆိုတဲ့ error တက်တာပါ။\r\n\r\nEcho Logic: PHP မှာ echo ဆိုတာ \"Display လုပ်ပါ\" လို့ ခိုင်းတာပါ။ echo (condition ? true : false) ဆိုတဲ့ ပုံစံမျိုး ဖြစ်ရပါမယ်။\r\n\r\nCEO အတွက် အကြံပြုချက်:\r\nEdit Form မှာ အချက်အလက်တွေ ပြန်ဖြည့်တဲ့အခါ htmlspecialchars() ကို သုံးပေးတာ ပိုစိတ်ချရပါတယ်။ ဒါမှ User ရိုက်ခဲ့တဲ့ Data ထဲမှာ \" သို့မဟုတ် \' တွေ ပါလာရင် Form ပျက်မသွားမှာပါ။\r\n\r\nPHP\r\nvalue=\"<?php echo isset($course[\'title\']) ? htmlspecialchars($course[\'title\']) : \'\'; ?>\"\r\nဒါလေးကို အစားထိုးလိုက်ရင် value ထဲမှာ စာသားတွေ အမှန်အတိုင်း ပြန်ပေါ်လာပါလိမ့်မယ်ဗျာ။ အဆင်ပြေရဲ့လားခင်ဗျာ?', 2000.00, '7 Weeks', 'assets/images/courses/course_69de5efecda07.png', '2026-04-14 15:36:30');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `student_email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `course_id` int(11) NOT NULL,
  `payment_slip` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Approved','Declined') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `student_name`, `student_email`, `phone`, `course_id`, `payment_slip`, `status`, `created_at`) VALUES
(1, 'John Doe', 'john@example.com', '+1 234 567 890', 2, NULL, 'Declined', '2026-04-12 17:04:21'),
(2, 'Jane Smith', 'jane@example.com', '+1 987 654 321', 2, NULL, 'Approved', '2026-04-12 17:04:21'),
(4, 'Mr hooky', 'hookyhooky.cu@gmail.com', '0984383920', 2, 'slip_1776182925_69de668d38728.png', 'Approved', '2026-04-14 16:08:45'),
(5, 'Ko Ko Maung', 'kokomaung@gmail.com', '0918929993', 2, 'slip_1776183908_69de6a6495d2b.png', 'Pending', '2026-04-14 16:25:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `role` enum('Admin','Editor') DEFAULT 'Admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$ahO/YBDD0fjGQMFI2PwymOGXtLV0hJkRlmSh06DKmmvmFQtWi2W4a', 'Site Administrator', 'Admin', '2026-04-14 17:10:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enrollments_ibfk_1` (`course_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
