-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 31, 2024 at 11:15 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phoneno` int(17) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `aid`, `firstname`, `lastname`, `email`, `phoneno`, `password`, `photo`, `address`) VALUES
(1, 3, 'Ayodeji', 'Boyede', 'asb@gre.ac.uk', 446239230, 'boyede', '', 'London'),
(7, 12, 'Tom', 'Steve', 'tom@gre.ac.uk', 2147483647, '$2y$10$kuESjqARQ3QqpGgGHOMQKOmd603aV0JJGDmIOhBK0GNsuLstxP46a', '', 'London'),
(8, 14, 'Potter', 'Henry', '', 0, 'potter', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `assign`
--

CREATE TABLE `assign` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `lid` int(11) NOT NULL,
  `lecturer_name` varchar(255) NOT NULL,
  `student_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assign`
--

INSERT INTO `assign` (`id`, `sid`, `lid`, `lecturer_name`, `student_name`) VALUES
(13, 54, 67, 'Darren Blackshields', 'Benjamin Fletcher'),
(14, 36, 13, 'Ayoz Sadiq', 'Ayodeji Boyede'),
(15, 55, 68, 'Steven Deere', 'Amelia Anderson');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `sid` int(11) NOT NULL,
  `complaint_type` varchar(255) NOT NULL,
  `complaint_message` varchar(255) NOT NULL,
  `lid` int(11) NOT NULL,
  `complaint_reply` varchar(255) NOT NULL,
  `complaint_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`sid`, `complaint_type`, `complaint_message`, `lid`, `complaint_reply`, `complaint_id`) VALUES
(0, 'Technical', 'df', 0, '', 1),
(123, 'tec', 'gf', 0, 'df', 2),
(123, 'et', 'dfh', 0, '', 3),
(0, 'trdv', 'xbcv', 890, '', 4);

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

CREATE TABLE `lecturer` (
  `id` int(11) NOT NULL,
  `lid` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phoneno` int(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `faculty` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `sid` int(11) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lecturer`
--

INSERT INTO `lecturer` (`id`, `lid`, `firstname`, `lastname`, `email`, `phoneno`, `password`, `photo`, `faculty`, `department`, `sid`, `address`) VALUES
(14, 67, 'Darren', 'Blackshields', 'd.blackshields@greenwich.ac.uk', 2147483647, 'darren', '', 'Computing and mathematicalsciences', 'Computer and Information systems', 0, ''),
(15, 68, 'Steven', 'Deere', 's.deere@greenwich.ac.uk', 443456789, 'deere', '', 'Computing and mathematical sciences', 'Computer and Information systems', 0, ''),
(16, 13, 'Ayoz', 'Sadiq', 'sadiq@gre.ac.uk', 2147483647, 'sadiq', '', 'Computer Engineering', 'Computer science', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `sid` int(11) NOT NULL,
  `lid` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `date_sent` datetime NOT NULL,
  `sender_id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `unReadcount` int(11) NOT NULL,
  `is_read` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `sender_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`sid`, `lid`, `aid`, `message`, `recipient_id`, `date_sent`, `sender_id`, `message_id`, `unReadcount`, `is_read`, `subject`, `sender_name`) VALUES
(123, 0, 0, 'trttr', 123, '2023-07-24 18:31:52', 890, 64, 0, 0, '', 'Lammy Lammy'),
(123, 0, 0, 'fer', 123, '2023-07-24 20:27:14', 890, 65, 0, 1, '', 'Lammy Lammy'),
(0, 0, 0, 'dgh', 890, '0000-00-00 00:00:00', 123, 85, 0, 1, '', ''),
(0, 0, 0, 'tfrs', 0, '2023-07-25 01:43:37', 890, 87, 0, 0, '', 'Lammy Lammy'),
(123, 0, 0, 'ewre', 123, '2023-07-25 01:56:17', 890, 88, 0, 1, '', 'Lammy Lammy'),
(0, 0, 0, 'hjgjh', 890, '0000-00-00 00:00:00', 123, 90, 0, 1, '', ''),
(0, 0, 0, 'ghnghn', 890, '0000-00-00 00:00:00', 123, 91, 0, 1, '', 'adejumo adewale'),
(0, 0, 0, 'How are you', 98, '0000-00-00 00:00:00', 234, 92, 0, 0, '', ''),
(0, 0, 0, 'whats up bro', 98, '0000-00-00 00:00:00', 234, 93, 0, 0, '', 'Hammed Adegunju'),
(0, 0, 0, 'Dear Prof, I want to remind you concerning my project.', 98, '0000-00-00 00:00:00', 234, 94, 0, 0, '', 'Hammed Adegunju'),
(0, 0, 0, 'hey', 890, '0000-00-00 00:00:00', 234, 95, 0, 0, '', 'Hammed Adegunju'),
(0, 0, 0, 'Dear Prof, pls find attached my reports for review and corrections.', 68, '0000-00-00 00:00:00', 55, 98, 0, 1, '', ''),
(54, 0, 0, 'Good work, you can proceed to writing the chapter one of the project. Also, ensure you submit your initial report on time.', 54, '2024-03-31 19:02:56', 67, 99, 0, 1, '', 'Darren Blackshields'),
(0, 0, 0, 'Find attached my final project report for review and correction.', 67, '0000-00-00 00:00:00', 54, 102, 0, 1, '', ''),
(54, 0, 0, 'Your proposal is accepted, you can proceed to writing initial report.', 54, '2024-03-31 22:55:16', 67, 103, 0, 1, '', 'Darren Blackshields'),
(54, 0, 0, '', 54, '2024-03-31 23:08:06', 67, 104, 0, 1, '', 'Darren Blackshields'),
(54, 0, 0, 'egdfdfsdfsdfdfd', 54, '2024-03-31 23:10:19', 67, 105, 0, 1, '', 'Darren Blackshields'),
(54, 0, 0, 'Bayo is a boy', 54, '2024-03-31 23:10:34', 67, 106, 0, 1, '', 'Darren Blackshields');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `sid` int(11) NOT NULL,
  `project_title` varchar(255) NOT NULL,
  `project_status` varchar(255) NOT NULL,
  `lid` int(11) NOT NULL,
  `start_date` varchar(255) NOT NULL,
  `submission_deadline` varchar(255) NOT NULL,
  `ongoing_report` varchar(255) NOT NULL,
  `final_report` varchar(255) NOT NULL,
  `project_id` int(11) NOT NULL,
  `is_read` varchar(255) NOT NULL,
  `interim_report` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`sid`, `project_title`, `project_status`, `lid`, `start_date`, `submission_deadline`, `ongoing_report`, `final_report`, `project_id`, `is_read`, `interim_report`) VALUES
(55, '', '', 0, '', '', '', '../final_reports/research method.docx', 13, '', ''),
(55, '', '', 0, '', '', '', '../final_reports/proposal IT security.docx', 14, '', ''),
(55, 'Student web enable project system proposal', 'read', 68, '2024-03-31', '', '../ongoing_reports/Chapter one (Manchester).docx', '', 15, '', ''),
(55, 'Student web enable project system proposal', 'unread', 68, '2024-03-31', '', '../ongoing_reports/Chapter one (Manchester).docx', '', 16, '', ''),
(55, '', '', 0, '', '', '', '../final_reports/framework work.docx', 17, '', ''),
(55, '', '', 0, '', '', '', '../final_reports/Chinese and Finnish undergraduates online shopping behaviour.pdf', 18, '', ''),
(54, 'Development of a Web Enabled System to Replace the Existing Student Project Systems', 'unread', 67, '2024-03-31', '', '../ongoing_reports/initial report web-enabled system.docx', '', 19, '', ''),
(54, 'Development of a Web Enabled System to Replace the Existing Student Project Systems', 'unread', 67, '2024-03-31', '', '', '', 20, '', '../interim_reports/interim report project system.docx'),
(54, 'Development of a Web Enabled System to Replace the Existing Student Project Systems', 'unread', 67, '2024-03-31', '', '', '../final_reports/student web enable project system (project).docx', 21, '', ''),
(54, 'Development of a Web Enabled System to Replace the Existing Student Project Systems', 'unread', 67, '2024-03-31', '', '', '', 22, '', '../interim_reports/interim report project system.docx');

-- --------------------------------------------------------

--
-- Table structure for table `project_ideas`
--

CREATE TABLE `project_ideas` (
  `id` int(11) NOT NULL,
  `lid` int(11) NOT NULL,
  `project_title` varchar(255) NOT NULL,
  `description` varchar(5096) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `programmes` varchar(255) NOT NULL,
  `overview` varchar(5096) NOT NULL,
  `objectives` varchar(5096) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project_ideas`
--

INSERT INTO `project_ideas` (`id`, `lid`, `project_title`, `description`, `keywords`, `programmes`, `overview`, `objectives`) VALUES
(1, 68, 'Moodle built with Python', 'Create a customized Learning Management System (LMS) similar to Moodle but built entirely with Python, offering a scalable and efficient platform for educational institutions to manage courses, assessments, and student engagement.', '\"Python\"\n\"Learning Management System (LMS)\"\n\"Education Technology\"\n\"Open Source\"\n\"Scalable\"\n\"Student Engagement\"\n\"Course Management\"\n\"Assessments\"\n\"Modular Architecture\"', 'M.Sc Computer Science', 'The project aims to develop a feature-rich and user-friendly Learning Management System, PyMoodle, entirely written in Python using the Django framework. PyMoodle will enable educational institutions to seamlessly manage courses, assessments, and student interactions while providing a customizable and scalable solution.', '1. Develop a modular LMS architecture using Python for flexibility and scalability.\n2. Implement user-friendly interfaces for both educators and students.\n3. Integrate features such as course creation, assignment management, discussion forums, and grade tracking.\n4. Ensure robust security measures to safeguard user data and maintain privacy.\n5. Provide easy customization options for institutions to tailor PyMoodle according to their unique requirements.'),
(20, 67, 'Enhancing Children\'s Cognitive Development and Learning', 'This project focuses on exploring various factors that influence children\'s cognitive development and learning processes. It delves into the realms of psychology, education, and neuroscience to understand how children acquire knowledge, skills, and attitudes.', 'Children, cognitive development, learning, psychology, education, neuroscience', 'This project aligns well with MSc programs or courses in Child Psychology, Educational Neuroscience, Cognitive Development, and Learning Sciences.', 'The project aims to investigate the intricate interplay between environmental, social, and biological factors in shaping children\'s cognitive development and learning experiences. It employs a multidisciplinary approach, integrating theories and methodologies from psychology, education, and neuroscience to provide a comprehensive understanding.', 'Project Aims/Objectives:\r\n\r\nTo identify key factors influencing children\'s cognitive development and learning.\r\nTo examine the role of the environment, social interactions, and biological factors in shaping children\'s learning processes.\r\nTo explore effective strategies for promoting optimal cognitive development and learning outcomes in children.\r\nTo contribute to the existing body of knowledge in child psychology, education, and neuroscience through empirical research and theoretical analysis.'),
(21, 67, 'Developing an Adaptive E-Learning Portal in Higher Education', 'This project revolves around the development and implementation of an adaptive e-learning portal tailored for higher education settings. It encompasses the integration of technology, instructional design principles, and adaptive learning techniques to enhance the effectiveness and efficiency of online education delivery.', 'Adaptive e-learning, higher education, technology integration, instructional design, online education, learning effectiveness', 'This project aligns with MSc programs or courses in Educational Technology, Instructional Design, E-Learning, Computer Science, and Higher Education Administration.', 'The project aims to design, develop, and implement an adaptive e-learning portal specifically catered to the needs of higher education institutions. It involves the creation of a dynamic online platform that adjusts learning content, activities, and assessments based on individual student needs, preferences, and performance metrics.', 'To analyze current trends and technologies in adaptive e-learning and their applicability to higher education.\r\nTo design and develop an intuitive and user-friendly e-learning portal interface for students, instructors, and administrators.\r\nTo implement adaptive learning algorithms and techniques to personalize the learning experience for individual students.\r\nTo evaluate the effectiveness and efficiency of the adaptive e-learning portal through empirical studies and user feedback.\r\nTo provide recommendations for the continuous improvement and refinement of the adaptive e-learning portal based on research findings and best practices.');

-- --------------------------------------------------------

--
-- Table structure for table `proposal`
--

CREATE TABLE `proposal` (
  `sid` int(11) NOT NULL,
  `project_title` varchar(255) NOT NULL,
  `proposal_docs` varchar(255) NOT NULL,
  `proposal_status` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `lid` int(11) NOT NULL,
  `is_read` varchar(255) NOT NULL,
  `proposal_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `proposal`
--

INSERT INTO `proposal` (`sid`, `project_title`, `proposal_docs`, `proposal_status`, `message`, `lid`, `is_read`, `proposal_id`) VALUES
(54, 'Development of a Web Enabled System to Replace the Existing Student Project Systems', '../proposal_docs/6609d1c2da79f_1612 Sunkanmi.docx', 'Accepted', 'gdfdfsdfsfsdfsfASFS', 67, '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `sid` int(11) NOT NULL,
  `firstname` varchar(150) NOT NULL,
  `lastname` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phoneno` int(15) NOT NULL,
  `address` varchar(150) NOT NULL,
  `faculty` varchar(150) NOT NULL,
  `department` varchar(150) NOT NULL,
  `lid` int(11) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `password` varchar(150) NOT NULL,
  `username` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`sid`, `firstname`, `lastname`, `email`, `phoneno`, `address`, `faculty`, `department`, `lid`, `photo`, `password`, `username`) VALUES
(36, 'Ayodeji', 'Boyede', 'ayodeji@gre.ac.uk', 2147483647, 'London', 'Computer mathematics', 'Computer Technology', 0, '', 'ayo', ''),
(54, 'Benjamin', 'Fletcher', 'fletcher@gre.ac.uk', 2147483647, 'London', 'Computing and mathmatical sciences', 'Computer & Information Systems', 0, '', 'anderson', ''),
(55, 'Amelia', 'Anderson', 'anderson@gre.ac.uk', 2147483647, 'London', 'Computing and mathematical sciences', 'Computer & Information Systems', 0, '', 'anderson', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assign`
--
ALTER TABLE `assign`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`complaint_id`);

--
-- Indexes for table `lecturer`
--
ALTER TABLE `lecturer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `project_ideas`
--
ALTER TABLE `project_ideas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`sid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `assign`
--
ALTER TABLE `assign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `complaint_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lecturer`
--
ALTER TABLE `lecturer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `project_ideas`
--
ALTER TABLE `project_ideas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
