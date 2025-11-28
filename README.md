#  Hotel Management System – PHP + MySQL

This is a **complete hotel management system** built using **Core PHP, MySQL & HTML**.  
It manages hotel operations such as room bookings, guest registration, employee login, services, payments, and room maintenance.  
It also implements a **multi-role employee system** for realistic hotel management workflows.

---
##  Author

Developed by **Pranav**  
---
##  Features

###  User Login & Signup
- Guest signup with **SHA-256 hashed passwords**
- Unique username validation
- Secure session handling
- Redirects to user home page after successful signup/login

###  Employee Roles
The system has three types of employee logins:

1. **Manager**
   - View all employees
   - See all bookings and payment details
   - View customer feedback and reviews

2. **Receptionist**
   - Book rooms for guests
   - Check-in and check-out guests
   - Cancel bookings
   - Access basic employee information (like email IDs)

3. **Housekeeping**
   - View rooms marked as "Under Maintenance"
   - Update room status to "Available" after cleaning

### 🛏 Room Booking Module
- Guests can view available rooms
- Select room type, number of guests, and stay duration
- Optional paid services (laundry, food, etc.)
- Auto-calculated total payment
- Reservation ID generated after booking
- Rooms automatically marked as booked

###  Payments & Services
- Stores room charges and services cost
- Calculates final bill
- Non-refundable warning displayed to users

###  Security
- Passwords hashed with SHA-256
- SQL injection protection using `mysqli_real_escape_string` and prepared statements
- Session validation on restricted pages

---

## 🛠 Tech Stack

| Component | Technology |
|-----------|------------|
| Frontend  | HTML       |
| Backend   | PHP (Core) |
| Database  | MySQL      |
| Security  | SHA-256 password hashing |
| Session Handling | PHP Sessions |

---

## 📂 Database Structure

| Table | Purpose |
|-------|---------|
| `guests` | Stores user profiles & login credentials |
| `employees` | Employee login details & roles |
| `rooms` | Room details, type, and status (Available/Booked/Maintenance) |
| `room_type` | Room categories & capacities |
| `reservations` | Guest booking records |
| `services` | Optional paid services |
| `guest_services` | Records purchased services |
| `payments` | Billing details, payment method, date |
| `feedback` | Customer ratings and reviews |

> SQL export file included in `SQL Data/` folder.

---

## 🚀 How to Run

1. Install **XAMPP/WAMP/MAMP**  
2. Start **Apache + MySQL**  
3. Copy the php files in Hotel_website to htdocs/HotelManagementSystem/ in your XAMPP folder in local file system
4. Create database:
```sql
CREATE DATABASE hotel_management;
'''
5. Import SQL file /SQL Data/Hotel_Management_SQL.sql in your created database
6. Update database credentials in db_conn.php
7. Open in browser:
http://localhost/HotelManagementSystem/Home_page.php
