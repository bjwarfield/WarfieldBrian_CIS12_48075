USE `48075`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: test
-- ------------------------------------------------------
-- Server version	5.6.20

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bw1780661_entity_assignments`
--

DROP TABLE IF EXISTS `bw1780661_entity_assignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bw1780661_entity_assignments` (
  `ass_id` int(10) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `points_possible` tinyint(3) DEFAULT NULL,
  `weight` tinyint(3) DEFAULT NULL,
  `description` longtext,
  `start_date` date DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  PRIMARY KEY (`ass_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bw1780661_entity_assignments`
--

INSERT INTO `bw1780661_entity_assignments` VALUES (1,'Homework 1',100,20,'Chapter 1','2014-09-01','2014-09-08 14:00:00'),(2,'Quiz 1',100,30,'Chapter 1','2014-09-08','2014-09-08 15:00:00'),(3,'Homework 2',100,20,'Chapter 2','2014-09-08','2014-09-15 14:00:00'),(4,'Quiz 2',100,30,'Chapter 2','2014-09-15','2014-09-15 15:00:00'),(5,'Homework 3',100,20,'Chapter 3','2014-09-15','2014-09-22 14:00:00'),(6,'Quiz 3',100,30,'Chapter 3','2014-09-22','2014-09-22 15:00:00'),(7,'Homework 1',100,20,'Chapter 1','2014-09-01','2014-09-08 15:10:00'),(8,'Quiz 1',100,30,'Chapter 1','2014-09-08','2014-09-08 17:00:00'),(9,'Homework 2',100,20,'Chapter 2','2014-09-08','2014-09-15 15:10:00'),(10,'Quiz 2',100,30,'Chapter 2','2014-09-15','2014-09-15 17:00:00'),(11,'Homework 3',100,20,'Chapter 3','2014-09-15','2014-09-22 15:10:00'),(12,'Quiz 3',100,30,'Chapter 3','2014-09-22','2014-09-22 17:00:00');
/*!40000 ALTER TABLE `bw1780661_entity_assignments` ENABLE KEYS */;

--
-- Table structure for table `bw1780661_entity_class`
--

DROP TABLE IF EXISTS `bw1780661_entity_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bw1780661_entity_class` (
  `section_id` int(10) NOT NULL,
  `time` time DEFAULT NULL,
  `bldg` tinyint(3) DEFAULT NULL,
  `day_of_Week` tinyint(3) DEFAULT NULL,
  `room` smallint(5) DEFAULT NULL,
  `semester` int(4) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bw1780661_entity_class`
--

/*!40000 ALTER TABLE `bw1780661_entity_class` DISABLE KEYS */;
INSERT INTO `bw1780661_entity_class` VALUES (48075,'08:00:00',4,3,200,320,'2014-08-25','2014-12-12'),(48076,'09:30:00',4,3,200,320,'2014-08-25','2014-12-12'),(48112,'23:10:00',4,45,203,320,'2014-10-22','2014-12-10');
/*!40000 ALTER TABLE `bw1780661_entity_class` ENABLE KEYS */;

--
-- Table structure for table `bw1780661_entity_course`
--

DROP TABLE IF EXISTS `bw1780661_entity_course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bw1780661_entity_course` (
  `course_id` int(10) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `number` tinyint(3) DEFAULT NULL,
  `series_letter` char(1) DEFAULT NULL,
  `short_description` text,
  `description` mediumtext,
  `discipline_id` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bw1780661_entity_course`
--

/*!40000 ALTER TABLE `bw1780661_entity_course` DISABLE KEYS */;
INSERT INTO `bw1780661_entity_course` VALUES (1,'PHP ',12,NULL,'PHP Dynamic Web Site Programming','PHP for Dynamic Web Design',1),(2,'Javascript',14,'A','Web Programming: Javascript','Javascript Programming',1),(3,'Inter. Web Design',72,'B','Intermediate Web Page Creation','Intermediate Web Page Creation',1);
/*!40000 ALTER TABLE `bw1780661_entity_course` ENABLE KEYS */;

--
-- Table structure for table `bw1780661_entity_instructor`
--

DROP TABLE IF EXISTS `bw1780661_entity_instructor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bw1780661_entity_instructor` (
  `instructor_id` int(10) NOT NULL COMMENT 'Primary Key',
  `first_name` varchar(15) DEFAULT NULL,
  `middle_initial` char(1) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `email_address` varchar(30) DEFAULT NULL,
  `area_code` smallint(5) DEFAULT NULL,
  `phone_number` int(10) DEFAULT NULL,
  `office_bldg_id` tinyint(3) DEFAULT NULL,
  `office_number` smallint(5) DEFAULT NULL,
  `department_id` tinyint(3) DEFAULT NULL,
  `discipline_id` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`instructor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bw1780661_entity_instructor`
--

/*!40000 ALTER TABLE `bw1780661_entity_instructor` DISABLE KEYS */;
INSERT INTO `bw1780661_entity_instructor` VALUES (1123456,'James','J','Jones','jim.jones@rcc.edu',555,5555555,1,123,3,3),(1123457,'George','R','James','george.james@rcc.edu',555,5555556,3,111,1,5),(1150258,'Mark','E','Lehr','mark.lehr@rcc.edu',951,2228260,4,222,1,1),(1196421,'Peter','J','Piper','peter.piper@rcc.edu',555,5555557,5,308,12,11);
/*!40000 ALTER TABLE `bw1780661_entity_instructor` ENABLE KEYS */;

--
-- Table structure for table `bw1780661_entity_student`
--

DROP TABLE IF EXISTS `bw1780661_entity_student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bw1780661_entity_student` (
  `student_id` int(10) NOT NULL COMMENT 'Primary Key',
  `first_name` varchar(15) DEFAULT NULL,
  `middle_initial` char(1) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `email_address` varchar(30) DEFAULT NULL,
  `area_code` smallint(5) DEFAULT NULL,
  `phone_number` int(10) DEFAULT NULL,
  `discipline_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bw1780661_entity_student`
--

/*!40000 ALTER TABLE `bw1780661_entity_student` DISABLE KEYS */;
INSERT INTO `bw1780661_entity_student` VALUES (1545123,'Billy','M','Jean','bjean@student.rcc.edu',555,5554561,'3'),(1780661,'Brian','J','Warfield','bwarfield@student.rcc.edu',770,9908109,'1'),(4451562,'Thomas','E','Cat','tcat5@student.rcc.edu',555,5557494,'11'),(4651845,'Hellen','E','Joyce','hjoyce1@student.rcc.edu',555,5557462,'8'),(7412151,'Jerome','M','Mouse','tmouse@student.rcc.edu',555,5551234,'11');
/*!40000 ALTER TABLE `bw1780661_entity_student` ENABLE KEYS */;

--
-- Table structure for table `bw1780661_enum_bldg_class`
--

DROP TABLE IF EXISTS `bw1780661_enum_bldg_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bw1780661_enum_bldg_class` (
  `bldg_id` tinyint(3) NOT NULL,
  `building` varchar(50) DEFAULT NULL,
  `mneumonic` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`bldg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bw1780661_enum_bldg_class`
--

/*!40000 ALTER TABLE `bw1780661_enum_bldg_class` DISABLE KEYS */;
INSERT INTO `bw1780661_enum_bldg_class` VALUES (1,'Digital Library & Learning Resource Center','DL/LRC'),(2,'Administration (O.W. Noble)','ADMIN'),(3,'Quadrangle (Arthur G. Paul)','QUAD'),(4,'Business Education','BUS'),(5,'Music','MUS'),(6,'Music Hall','MUSHALL'),(7,'Landis Performing Arts Center','LPAC'),(8,'Martin Luther King Jr. High Tech Center','MLK'),(9,'Assessment Center','AC'),(10,'Planetarium (Robert T. Dixon)','PLTRM'),(11,'School of Nursing','NURSE'),(12,'Math and Science','MAT/SCI'),(13,'Student Center','STUDENT'),(14,'Student Financial Services','SFS'),(15,'Admissions & Counseling (Cesar V. Chavez)','AD/CO');
/*!40000 ALTER TABLE `bw1780661_enum_bldg_class` ENABLE KEYS */;

--
-- Table structure for table `bw1780661_enum_bldg_instr`
--

DROP TABLE IF EXISTS `bw1780661_enum_bldg_instr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bw1780661_enum_bldg_instr` (
  `bldg_id` tinyint(3) NOT NULL,
  `building` varchar(50) DEFAULT NULL,
  `mneumonic` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`bldg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bw1780661_enum_bldg_instr`
--

/*!40000 ALTER TABLE `bw1780661_enum_bldg_instr` DISABLE KEYS */;
INSERT INTO `bw1780661_enum_bldg_instr` VALUES (1,'Digital Library & Learning Resource Center','DL/LRC'),(2,'Administration (O.W. Noble)','ADMIN'),(3,'Quadrangle (Arthur G. Paul)','QUAD'),(4,'Business Education','BUS'),(5,'Music','MUS'),(6,'Music Hall','MUSHALL'),(7,'Landis Performing Arts Center','LPAC'),(8,'Martin Luther King Jr. High Tech Center','MLK'),(9,'Assessment Center','AC'),(10,'Planetarium (Robert T. Dixon)','PLTRM'),(11,'School of Nursing','NURSE'),(12,'Math and Science','MAT/SCI'),(13,'Student Center','STUDENT'),(14,'Student Financial Services','SFS'),(15,'Admissions & Counseling (Cesar V. Chavez)','AD/CO');
/*!40000 ALTER TABLE `bw1780661_enum_bldg_instr` ENABLE KEYS */;

--
-- Table structure for table `bw1780661_enum_daysofweek`
--

DROP TABLE IF EXISTS `bw1780661_enum_daysofweek`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bw1780661_enum_daysofweek` (
  `day_id` tinyint(3) NOT NULL,
  `days_of_week` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`day_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bw1780661_enum_daysofweek`
--

/*!40000 ALTER TABLE `bw1780661_enum_daysofweek` DISABLE KEYS */;
INSERT INTO `bw1780661_enum_daysofweek` VALUES (1,'Mo'),(2,'MoTu'),(3,'MoWe'),(4,'MoTh'),(5,'MoFr'),(6,'MoSa'),(7,'MoTuWe'),(8,'MoTuTh'),(9,'MoTuFr'),(10,'MoTuSa'),(11,'MoWeTh'),(12,'MoWeFr'),(13,'MoWeSa'),(14,'MoThFr'),(15,'MoThSa'),(16,'MoFrSa'),(17,'MoTuWeTh'),(18,'MoTuWeFr'),(19,'MoTuWeSa'),(20,'MoWeThFr'),(21,'MoWeThSa'),(22,'MoThFrSa'),(23,'MoTuWeThFr'),(24,'MoTuWeThSa'),(25,'MoTuWeFrSa'),(26,'MoTuThFrSa'),(27,'MoWeThFrSa'),(28,'MoTuWeThFrSa'),(29,'Tu'),(30,'TuWe'),(31,'TuTh'),(32,'TuFr'),(33,'TuSa'),(34,'TuWeTh'),(35,'TuWeFr'),(36,'TuWeSa'),(37,'TuThFr'),(38,'TuThSa'),(39,'TuFrSa'),(40,'TuWeThFr'),(41,'TuWeThSa'),(42,'TuWeFrSa'),(43,'TuThFrSa'),(44,'TuWeThFrSa'),(45,'We'),(46,'WeTh'),(47,'WeFr'),(48,'WeSa'),(49,'WeThFr'),(50,'WeThSa'),(51,'WeFrSa'),(52,'WeThFrSa'),(53,'Th'),(54,'ThFr'),(55,'ThSa'),(56,'ThFrSa'),(57,'Fr'),(58,'FrSa'),(59,'Sa');
/*!40000 ALTER TABLE `bw1780661_enum_daysofweek` ENABLE KEYS */;

--
-- Table structure for table `bw1780661_enum_department`
--

DROP TABLE IF EXISTS `bw1780661_enum_department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bw1780661_enum_department` (
  `dept_id` tinyint(3) NOT NULL,
  `department` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`dept_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bw1780661_enum_department`
--

/*!40000 ALTER TABLE `bw1780661_enum_department` DISABLE KEYS */;
INSERT INTO `bw1780661_enum_department` VALUES (1,'Business Information Systems'),(2,'English'),(3,'Art'),(4,'Applied Tech'),(5,'Behavioral Science'),(6,'Chemistry'),(7,'Cosmology'),(8,'Early Childhood Education'),(9,'Economics & Political Science'),(10,'Mathematics'),(11,'Nursing'),(12,'Performing Arts'),(13,'History'),(14,'Communications'),(15,'Physical Sciences');
/*!40000 ALTER TABLE `bw1780661_enum_department` ENABLE KEYS */;

--
-- Table structure for table `bw1780661_enum_discipline`
--

DROP TABLE IF EXISTS `bw1780661_enum_discipline`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bw1780661_enum_discipline` (
  `disc_id` tinyint(3) NOT NULL,
  `discipline` varchar(40) DEFAULT NULL,
  `menumonic` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`disc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bw1780661_enum_discipline`
--

/*!40000 ALTER TABLE `bw1780661_enum_discipline` DISABLE KEYS */;
INSERT INTO `bw1780661_enum_discipline` VALUES (1,'Computer Information Systems','CIS'),(2,'American Sign Language','ASL'),(3,'Art','ART'),(4,'Biology','BIO'),(5,'Business Administration','BUS'),(6,'Economics','ECO'),(7,'English','ENG'),(8,'Geography','GEO'),(9,'Mathematics','MAT'),(10,'History','HIS'),(11,'Music','MUS'),(12,'Psycology','PSY'),(13,'Philosophy','PHI'),(14,'Reading','REA'),(15,'Culinary','CUL');
/*!40000 ALTER TABLE `bw1780661_enum_discipline` ENABLE KEYS */;

--
-- Table structure for table `bw1780661_enum_semester`
--

DROP TABLE IF EXISTS `bw1780661_enum_semester`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bw1780661_enum_semester` (
  `sem_id` int(3) NOT NULL,
  `semester` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`sem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bw1780661_enum_semester`
--

/*!40000 ALTER TABLE `bw1780661_enum_semester` DISABLE KEYS */;
INSERT INTO `bw1780661_enum_semester` VALUES (316,'FALL2013'),(317,'WIN2013'),(318,'SPR2014'),(319,'SUM2014'),(320,'FALL2014'),(321,'WIN2014'),(322,'SPR2015'),(323,'SUM2015'),(324,'FALL2015');
/*!40000 ALTER TABLE `bw1780661_enum_semester` ENABLE KEYS */;

--
-- Table structure for table `bw1780661_xref_class_assignments`
--

DROP TABLE IF EXISTS `bw1780661_xref_class_assignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bw1780661_xref_class_assignments` (
  `xref_class_ass_id` int(10) NOT NULL,
  `class_id` int(10) DEFAULT NULL,
  `assignment_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`xref_class_ass_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bw1780661_xref_class_assignments`
--

/*!40000 ALTER TABLE `bw1780661_xref_class_assignments` DISABLE KEYS */;
INSERT INTO `bw1780661_xref_class_assignments` VALUES (1,48075,1),(2,48075,2),(3,48075,3),(4,48075,4),(5,48075,5),(6,48075,6),(7,48076,7),(8,48076,8),(9,48076,9),(10,48076,10),(11,48076,11),(12,48076,12);
/*!40000 ALTER TABLE `bw1780661_xref_class_assignments` ENABLE KEYS */;

--
-- Table structure for table `bw1780661_xref_class_course`
--

DROP TABLE IF EXISTS `bw1780661_xref_class_course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bw1780661_xref_class_course` (
  `xref_class_course` int(10) NOT NULL,
  `class_id` int(10) DEFAULT NULL,
  `course_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`xref_class_course`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bw1780661_xref_class_course`
--

/*!40000 ALTER TABLE `bw1780661_xref_class_course` DISABLE KEYS */;
INSERT INTO `bw1780661_xref_class_course` VALUES (1,48075,1),(2,48076,2),(3,48112,3);
/*!40000 ALTER TABLE `bw1780661_xref_class_course` ENABLE KEYS */;

--
-- Table structure for table `bw1780661_xref_instr_class`
--

DROP TABLE IF EXISTS `bw1780661_xref_instr_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bw1780661_xref_instr_class` (
  `xref_instr_class` int(10) NOT NULL,
  `instructor_id` int(10) DEFAULT NULL,
  `class_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`xref_instr_class`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bw1780661_xref_instr_class`
--

/*!40000 ALTER TABLE `bw1780661_xref_instr_class` DISABLE KEYS */;
INSERT INTO `bw1780661_xref_instr_class` VALUES (1,1150258,48075),(2,1150258,48076),(3,1123457,48112);
/*!40000 ALTER TABLE `bw1780661_xref_instr_class` ENABLE KEYS */;

--
-- Table structure for table `bw1780661_xref_student_assignments`
--

DROP TABLE IF EXISTS `bw1780661_xref_student_assignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bw1780661_xref_student_assignments` (
  `xref_stu_ass` int(10) NOT NULL,
  `student_id` int(10) DEFAULT NULL,
  `assignment_id` int(10) DEFAULT NULL,
  `score` tinyint(3) DEFAULT NULL,
  `grade` char(2) DEFAULT NULL,
  `comments` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`xref_stu_ass`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bw1780661_xref_student_assignments`
--

/*!40000 ALTER TABLE `bw1780661_xref_student_assignments` DISABLE KEYS */;
INSERT INTO `bw1780661_xref_student_assignments` VALUES (1,1780661,1,100,'A',NULL),(2,1780661,2,100,'A',NULL);
/*!40000 ALTER TABLE `bw1780661_xref_student_assignments` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-10-20  8:45:09
