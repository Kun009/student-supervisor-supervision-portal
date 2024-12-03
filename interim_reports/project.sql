-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 09, 2024 at 09:21 PM
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
(7, 5, 'Adam', 'Hutchinson', '', 0, 'adam', '', '');

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
(14, 55, 68, 'Steven Deere', 'Amelia Anderson');

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
(15, 68, 'Steven', 'Deere', 's.deere@greenwich.ac.uk', 443456789, 'deere', '', 'Computing and mathematical sciences', 'Computer and Information systems', 0, '');

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
(0, 0, 0, 'tfnmjhdjksd', 67, '0000-00-00 00:00:00', 54, 97, 0, 0, '', '');

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
(123, 'steel making', 'read', 890, '2023-07-25', '', '../ongoing_reports/proj.png', '', 5, '', ''),
(123, 'steel making', 'read', 890, '2023-07-25', '', '../ongoing_reports/message.png', '', 6, '', ''),
(123, 'steel making', 'read', 890, '2023-07-25', '', '../ongoing_reports/dashboard.png', '', 7, '', ''),
(0, 'juty', '', 0, '', '', '', '../final_reportsafrica check3.docx', 9, '', ''),
(0, 'Usefulness', '', 0, '', '', '', '../final_reportsfinal_reportsPerceived Usefulness, Perceived Ease of Use, and User Acceptance of Information Technology.pdf', 10, '', ''),
(0, 'Effect', '', 0, '', '', '', '../final_reportsfinal_reportsThe Effect of Culture on User Acceptance of.pdf', 11, '', ''),
(0, 'Challenges in Development of eLearning Systems in Higher Education of the Developing Countries', '', 0, '', '', '', '../final_reports142_Challenges-in-Development-of-eLearning-Systems-in-Higher-Education-of the Developing Countries.pdf', 12, '', ''),
(0, 'Design and Development of ELearning  University System ', '', 0, '', '', '', '../final_reportsDesign and Development of ELearning University System.pdf', 13, '', '');

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
(1, 890, 'Moodle built with Python', 'Create a customized Learning Management System (LMS) similar to Moodle but built entirely with Python, offering a scalable and efficient platform for educational institutions to manage courses, assessments, and student engagement.', '\"Python\"\n\"Learning Management System (LMS)\"\n\"Education Technology\"\n\"Open Source\"\n\"Scalable\"\n\"Student Engagement\"\n\"Course Management\"\n\"Assessments\"\n\"Modular Architecture\"', 'M.Sc Computer Science', 'The project aims to develop a feature-rich and user-friendly Learning Management System, PyMoodle, entirely written in Python using the Django framework. PyMoodle will enable educational institutions to seamlessly manage courses, assessments, and student interactions while providing a customizable and scalable solution.', '1. Develop a modular LMS architecture using Python for flexibility and scalability.\n2. Implement user-friendly interfaces for both educators and students.\n3. Integrate features such as course creation, assignment management, discussion forums, and grade tracking.\n4. Ensure robust security measures to safeguard user data and maintain privacy.\n5. Provide easy customization options for institutions to tailor PyMoodle according to their unique requirements.'),
(20, 68, 'Design and Development of eLearning University System', 'E-Learning management software systems refer to\r\nany application that enables delivering courses and\r\ninstruction electronically either over the Internet or via\r\ndownload of software on individual desktop using CD’s\r\nor DVD’s. Essentially, any learning that is not delivered\r\ninto the classroom but via electronic media can be\r\ncategorized as E-Learning software. There are many\r\ncategories of software available in the market that fell\r\nin the category of E-Learning software. These range\r\nfrom course authoring tools that allow instructional\r\ndesigners to create E-learning courses to learning\r\nmanagement systems that allow users to access eLearning courses over the internet.', 'E-learning; Moodle; education; classroom', 'Computer technology', 'The \"Design and Development of eLearning University System\" project aims to create a comprehensive online platform for higher education. It integrates courses, assignments, forums, and multimedia resources for remote learning. Emphasizing user-friendly interfaces and robust backend infrastructure, it ensures an interactive and efficient educational experience for students and instructors alike.', 'Project Aim:\r\nTo design and develop an eLearning University System that provides a comprehensive and interactive platform for remote higher education, enhancing accessibility and flexibility for students and instructors.\r\n\r\nObjectives:\r\n\r\nDevelop a user-friendly interface for seamless navigation and interaction within the eLearning platform.\r\nIntegrate diverse multimedia resources, including videos, simulations, and interactive modules, to enhance learning experiences.\r\nImplement robust backend infrastructure to ensure scalability, security, and reliability of the eLearning system.\r\nFacilitate effective communication and collaboration among students and instructors through discussion forums, chat features, and virtual classrooms within the platform.\r\n\r\n\r\n\r\n'),
(21, 68, 'AI-Powered Personalized Learning Assistant', 'Utilizing artificial intelligence (AI) algorithms to develop a personalized learning assistant that adapts to individual student needs.', 'Artificial Intelligence, Personalized Learning, Educational Technology, Machine Learning, Data Analysis', 'Machine Learning, Educational Technology, Data Science', 'This project involves creating an AI-powered platform that analyzes students\' learning patterns, preferences, and performance to deliver customized learning materials, recommendations, and feedback. It utilizes machine learning algorithms to continuously improve and tailor the learning experience for each student.', 'Develop AI algorithms capable of analyzing and interpreting student data to understand their learning needs.\r\nDesign an intuitive and user-friendly interface for students and instructors to interact with the personalized learning assistant.\r\nImplement a recommendation system that suggests relevant learning resources, exercises, and activities based on individual student profiles.\r\nEvaluate the effectiveness of the personalized learning assistant through user feedback and performance metrics to refine the algorithms and improve learning outcomes.\r\n'),
(22, 68, 'Blockchain-Based Academic Credential Verification System', 'Leveraging blockchain technology to create a secure and decentralized system for verifying academic credentials and certifications.', 'Blockchain, Decentralized Systems, Cryptography, Academic Credentials, Verification', 'Blockchain Technology, Cryptography, Information Security, Distributed Systems', 'This project aims to develop a blockchain-based platform where academic institutions can securely store and verify students\' academic records and certifications. Using cryptographic techniques and decentralized consensus mechanisms, it ensures tamper-proof verification of credentials, reducing fraud and streamlining the verification process.', 'Design and implement a blockchain network capable of securely storing academic credentials and certifications.\r\nDevelop smart contracts to govern the verification process and ensure the integrity of data stored on the blockchain.\r\nCreate an intuitive user interface for academic institutions, employers, and students to access and verify credentials.\r\nConduct thorough testing and validation to ensure the security, scalability, and reliability of the blockchain-based credential verification system.\r\n'),
(23, 68, 'Development of Stand-alone Software Tool for Defining Circulation in EXODUS Evacuation Model', 'Creating a standalone software tool to enhance the EXODUS evacuation model by incorporating advanced features for defining and simulating crowd circulation dynamics in evacuation scenarios.', 'Evacuation Modeling, Crowd Simulation, Software Development, Circulation Dynamics, EXODUS Model', 'Computer Science, Simulation and Modeling, Human Factors Engineering, Software Engineering', 'This project aims to extend the capabilities of the EXODUS evacuation model by developing a specialized software tool that allows users to define and simulate crowd circulation patterns more accurately. By integrating algorithms for crowd behavior and flow dynamics, the tool enhances the realism and effectiveness of evacuation simulations.', 'Design and implement a user-friendly interface for defining circulation parameters and scenarios within the EXODUS evacuation model.\r\nDevelop algorithms to simulate crowd movement and circulation dynamics based on factors such as pedestrian density, speed, and environmental constraints.\r\nIncorporate visualization tools to represent circulation patterns and identify potential bottlenecks or congestion points in evacuation scenarios.\r\nValidate the software tool through rigorous testing and comparison with real-world evacuation data to ensure accuracy and reliability.'),
(24, 67, 'Development of Student Tutorial Center Online', 'Establishing an online platform to provide academic support and tutoring services for students, offering interactive tutorials, study resources, and personalized assistance.', 'Online Learning, Academic Support, Tutoring Services, Student Engagement, Educational Resources', 'Educational Technology, Online Learning Environments, User Experience Design, Instructional Design', 'This project involves creating a virtual tutorial center where students can access a range of educational resources and receive personalized support from tutors. The platform offers interactive tutorials, study guides, practice exercises, and virtual office hours to enhance students\' learning experience and academic success.', 'Design and develop an intuitive and accessible online platform for students to access tutorial services and resources.\r\nRecruit and train qualified tutors to provide academic support and guidance through virtual tutoring sessions and discussion forums.\r\nImplement features for tracking student progress, scheduling appointments, and providing feedback to optimize learning outcomes.\r\nEvaluate the effectiveness of the online tutorial center through user feedback and performance metrics, iterating and improving the platform based on insights gathered.\r\n\r\n\r\n\r\n'),
(25, 67, 'Development of Virtual Reality Laboratory Simulations', 'Creating immersive virtual reality (VR) simulations for laboratory experiments and scientific demonstrations, providing an engaging and interactive learning experience for students.', 'Virtual Reality, Laboratory Simulations, STEM Education, Immersive Learning, Educational Technology', 'Virtual Reality Development, STEM Education, Educational Technology, Computer Graphics', 'This project focuses on developing VR simulations that replicate real-world laboratory environments, allowing students to conduct experiments and explore scientific concepts in a safe and immersive virtual setting. It leverages VR technology to enhance student engagement, comprehension, and retention of scientific principles.', 'Design and create high-fidelity virtual environments that accurately represent laboratory equipment and experimental procedures.\r\nDevelop interactive interfaces and controls that enable students to manipulate virtual objects and perform hands-on experiments.\r\nIntegrate instructional guidance and feedback mechanisms to support student learning and mastery of scientific concepts.\r\nEvaluate the educational effectiveness of the VR laboratory simulations through user testing and assessment of learning outcomes, refining the simulations based on feedback from students and instructors.'),
(26, 67, 'Development of Web-Enabled System to Replace Existing Student Project Systems', 'Creating a comprehensive web-based platform to replace outdated systems for managing student projects, facilitating collaboration, tracking progress, and showcasing project outcomes.', 'Web Development, Project Management, Collaboration Tools, Student Projects, System Upgrade', 'Software Engineering, Web Development, Project Management, Information Systems', 'This project aims to modernize the management of student projects by developing a web-enabled system that centralizes project documentation, communication, and progress tracking. It provides students, instructors, and administrators with intuitive tools for managing project workflows, scheduling milestones, and evaluating outcomes.', 'Design and implement a user-friendly web interface for accessing and managing student projects, incorporating features for document sharing, task assignment, and communication.\r\nDevelop a database backend to store project data securely and facilitate efficient retrieval and updating of project information.\r\nIntegrate collaboration tools such as discussion forums, chat rooms, and version control systems to support teamwork and communication among project stakeholders.\r\nEnable project evaluation and assessment through features such as progress tracking, milestone completion, and feedback collection to ensure the quality and success of student projects.\r\n\r\n\r\n\r\n\r\n');

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
(123, 'steel making', '../proposal_docs/64be524ec4ee9_steelmaking metallurgy.docx', 'Rejected', '', 890, '1', 0),
(234, 'gfhj', '../proposal_docs/65c957d21667e_Doc1.docx', 'Rejected', 'etfghjn,', 890, '1', 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `assign`
--
ALTER TABLE `assign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `complaint_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lecturer`
--
ALTER TABLE `lecturer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `project_ideas`
--
ALTER TABLE `project_ideas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
