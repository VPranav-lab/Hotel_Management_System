-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Database: hotel_management_system
-- ------------------------------------------------------
-- Server version	8.0.40

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employees` (
  `employee_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(40) DEFAULT NULL,
  `last_name` varchar(40) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `salary` decimal(10,2) NOT NULL,
  `email` varchar(30) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`employee_id`),
  CONSTRAINT `employees_chk_1` CHECK ((`salary` > 0))
) ENGINE=InnoDB AUTO_INCREMENT=3084 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO employees (first_name, last_name, password, position, salary, email, mobile)
VALUES
    ('Giovanni', 'Rossi', SHA2('Giovanni@123', 256), 'General Manager', 70000.00, 'giovanni.rossi@gmail.com', '+39 320 123 4567'),
    
    ('Alessandro', 'Bianchi', SHA2('Alessandro@123', 256), 'Receptionist', 30000.00, 'alessandro.bianchi@gmail.com', '+39 321 234 5678'),
    ('Francesca', 'Romano', SHA2('Francesca@123', 256), 'Receptionist', 30000.00, 'francesca.romano@gmail.com', '+39 322 345 6789'),
    ('Luca', 'Moretti', SHA2('Luca@123', 256), 'Receptionist', 30000.00, 'luca.moretti@gmail.com', '+39 323 456 7890'),
    ('Martina', 'Ricci', SHA2('Martina@123', 256), 'Receptionist', 30000.00, 'martina.ricci@gmail.com', '+39 324 567 8901'),

    ('Stefano', 'Conti', SHA2('Stefano@123', 256), 'Housekeeping', 25000.00, 'stefano.conti@gmail.com', '+39 325 678 9012'),
    ('Giulia', 'Gallo', SHA2('Giulia@123', 256), 'Housekeeping', 25000.00, 'giulia.gallo@gmail.com', '+39 326 789 0123'),
    ('Marco', 'Ferrari', SHA2('Marco@123', 256), 'Housekeeping', 25000.00, 'marco.ferrari@gmail.com', '+39 327 890 1234'),

    ('Elena', 'Marino', SHA2('Elena@123', 256), 'Housekeeping Supervisor', 32000.00, 'elena.marino@gmail.com', '+39 328 901 2345'),

    ('Davide', 'Lombardi', SHA2('Davide@123', 256), 'Chef', 40000.00, 'davide.lombardi@gmail.com', '+39 329 012 3456'),
    ('Roberta', 'Barbieri', SHA2('Roberta@123', 256), 'Chef', 40000.00, 'roberta.barbieri@gmail.com', '+39 330 123 4567'),

    ('Simone', 'De Luca', SHA2('Simone@123', 256), 'Room service attedant', 28000.00, 'simone.deluca@gmail.com', '+39 331 234 5678'),
    ('Valentina', 'Greco', SHA2('Valentina@123', 256), 'Room service attedant', 28000.00, 'valentina.greco@gmail.com', '+39 332 345 6789'),
    ('Antonio', 'Rizzo', SHA2('Antonio@123', 256), 'Room service attedant', 28000.00, 'antonio.rizzo@gmail.com', '+39 333 456 7890');/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `feedback` (
  `first_name` varchar(40) DEFAULT NULL,
  `last_name` varchar(40) DEFAULT NULL,
  `room_num` int DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `suggestions` text,
  KEY `room_num` (`room_num`),
  CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`room_num`) REFERENCES `rooms` (`room_num`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `guest_services`
--

DROP TABLE IF EXISTS `guest_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guest_services` (
  `guest_id` int NOT NULL,
  `service_id` int NOT NULL,
  `quantity` int NOT NULL,
  `total_price` int DEFAULT NULL,
  KEY `guest_id` (`guest_id`),
  KEY `service_id` (`service_id`),
  CONSTRAINT `guest_services_ibfk_1` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`guest_id`) ON DELETE CASCADE,
  CONSTRAINT `guest_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`) ON DELETE CASCADE,
  CONSTRAINT `guest_services_chk_1` CHECK ((`quantity` > 0))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `guests`
--

DROP TABLE IF EXISTS `guests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guests` (
  `guest_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(40) DEFAULT NULL,
  `last_name` varchar(40) DEFAULT NULL,
  `username` varchar(40) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `age` int NOT NULL,
  `doc_type` varchar(20) DEFAULT NULL,
  `doc_number` varchar(25) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `address` text,
  PRIMARY KEY (`guest_id`),
  UNIQUE KEY `doc_number` (`doc_number`),
  UNIQUE KEY `username` (`username`),
  CONSTRAINT `guests_chk_1` CHECK ((`age` > 18))
) ENGINE=InnoDB AUTO_INCREMENT=1029 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `res_id` int DEFAULT NULL,
  `room_amount` int DEFAULT NULL,
  `services_amount` int DEFAULT NULL,
  `total_amount` int DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `pay_method` enum('Cash','Credit Card','Debit Card') DEFAULT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `res_id` (`res_id`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`res_id`) REFERENCES `reservations` (`res_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `payments_chk_1` CHECK ((`room_amount` >= 0)),
  CONSTRAINT `payments_chk_2` CHECK ((`services_amount` >= 0))
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservations` (
  `res_id` int NOT NULL AUTO_INCREMENT,
  `guest_id` int DEFAULT NULL,
  `room_num` int DEFAULT NULL,
  `check_in` date DEFAULT NULL,
  `check_out` date DEFAULT NULL,
  `res_type` enum('Online','At Hotel') DEFAULT NULL,
  `res_status` enum('Pending','Confirmed','Checked-In','Checked-Out','Cancelled') DEFAULT 'Pending',
  PRIMARY KEY (`res_id`),
  KEY `guest_id` (`guest_id`),
  KEY `room_num` (`room_num`),
  CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`guest_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`room_num`) REFERENCES `rooms` (`room_num`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `room_type`
--

DROP TABLE IF EXISTS `room_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `room_type` (
  `room_type_id` int NOT NULL AUTO_INCREMENT,
  `type_name` varchar(50) DEFAULT NULL,
  `room_description` text,
  `capacity` int DEFAULT NULL,
  PRIMARY KEY (`room_type_id`),
  CONSTRAINT `room_type_chk_1` CHECK ((`capacity` > 0))
) ENGINE=InnoDB AUTO_INCREMENT=2012 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_type`
--

LOCK TABLES `room_type` WRITE;
/*!40000 ALTER TABLE `room_type` DISABLE KEYS */;
INSERT INTO `room_type` VALUES (2008,'Single','A cozy room for one person with a comfortable bed, free WiFi, air conditioning, flat-screen TV, and a private bathroom.',1),(2009,'Deluxe','A stylish room for two people featuring a king-size bed, minibar, coffee maker, air conditioning, free WiFi, flat-screen TV, and a spacious bathroom with a bathtub.',2),(2010,'Double Deluxe','A premium room for up to four guests with two queen-size beds, a seating area, work desk, minibar, air conditioning, free WiFi, smart TV with streaming subscriptions, and an en-suite bathroom with luxury toiletries.',4),(2011,'Family','A large family-friendly room accommodating up to seven people, featuring multiple beds, a living area, dining table, kitchenette, air conditioning, free WiFi, smart TV, and a spacious bathroom.',7);
/*!40000 ALTER TABLE `room_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rooms` (
  `room_num` int NOT NULL AUTO_INCREMENT,
  `room_type_id` int DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('Available','Booked','Under Maintenance') NOT NULL DEFAULT 'Available',
  PRIMARY KEY (`room_num`),
  KEY `room_type_id` (`room_type_id`),
  CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`room_type_id`) REFERENCES `room_type` (`room_type_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `rooms_chk_1` CHECK ((`price` > 0))
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES (151,2008,20.00,'Available'),(152,2008,20.00,'Available'),(153,2008,20.00,'Available'),(154,2008,20.00,'Available'),(155,2008,20.00,'Available'),(156,2008,20.00,'Available'),(157,2008,20.00,'Available'),(158,2008,20.00,'Available'),(159,2008,20.00,'Available'),(160,2008,20.00,'Available'),(161,2009,35.00,'Booked'),(162,2009,35.00,'Available'),(163,2009,35.00,'Available'),(164,2009,35.00,'Available'),(165,2009,35.00,'Available'),(166,2009,35.00,'Available'),(167,2009,35.00,'Available'),(168,2009,35.00,'Available'),(169,2009,35.00,'Available'),(170,2009,35.00,'Available'),(171,2009,35.00,'Available'),(172,2009,35.00,'Available'),(173,2009,35.00,'Available'),(174,2009,35.00,'Available'),(175,2009,35.00,'Available'),(176,2009,35.00,'Available'),(177,2009,35.00,'Available'),(178,2009,35.00,'Available'),(179,2009,35.00,'Available'),(180,2009,35.00,'Available'),(181,2010,55.00,'Booked'),(182,2010,55.00,'Available'),(183,2010,55.00,'Available'),(184,2010,55.00,'Available'),(185,2010,55.00,'Available'),(186,2010,55.00,'Available'),(187,2010,55.00,'Available'),(188,2010,55.00,'Available'),(189,2010,55.00,'Available'),(190,2010,55.00,'Available'),(191,2010,55.00,'Available'),(192,2010,55.00,'Available'),(193,2010,55.00,'Available'),(194,2010,55.00,'Available'),(195,2010,55.00,'Available'),(196,2011,90.00,'Available'),(197,2011,90.00,'Available'),(198,2011,90.00,'Available'),(199,2011,90.00,'Available'),(200,2011,90.00,'Available');
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `service_id` int NOT NULL AUTO_INCREMENT,
  `service_name` varchar(40) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`service_id`),
  UNIQUE KEY `service_name` (`service_name`),
  CONSTRAINT `services_chk_1` CHECK ((`price` >= 0))
) ENGINE=InnoDB AUTO_INCREMENT=4011 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (4000,'Room Service','Food and beverage service delivered to the room',25.00),(4001,'Spa and Massage','Relaxing spa treatments and massages',60.00),(4002,'Laundry Service','Washing and ironing of clothes',15.00),(4003,'airport shuttle','Transportation service to and from the nearest airport. Can be used for both arrival and departure, as well as multiple times if needed.',40.00),(4004,'Car Rentals','Rent a car for easy and convenient travel around the city and nearby areas',50.00),(4005,'Conference Room Rental','Rental for meetings and conferences',100.00),(4007,'BBQ Party','Outdoor BBQ with seating for groups, includes food and drinks',120.00),(4008,'Babysitting Service','Professional babysitters for family guests',30.00),(4009,'Pet Care','Services for guests traveling with pets, including pet sitting and walking',20.00),(4010,'Extra Towels','Providing extra towels on request for guests in their room. Can be requested multiple times during the stay.',5.00);
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-28 15:44:16
