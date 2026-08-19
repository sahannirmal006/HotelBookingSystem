# 🏨 Online Hotel Management System

An **Online Hotel Management System** developed using PHP and MySQL. The system allows customers to browse hotels, view available rooms, make bookings, and manage their profiles. Administrators can manage hotels, rooms, customers, and bookings through an administration panel.

## 📌 Project Overview

The Online Hotel Management System is designed to simplify hotel reservation and management processes by providing a centralized web-based platform.

The system has separate functionalities for:

* 👤 Customers
* 👨‍💼 Administrators
* 🏨 Hotel Owners

## ✨ Features

### 👤 Customer

* Customer registration and login
* Browse available hotels
* View hotel details
* View available rooms
* Make hotel reservations
* Manage customer profile
* View booking information

### 👨‍💼 Administrator

* Secure admin login
* Admin dashboard
* Manage hotels
* Manage rooms
* Manage customers
* Manage bookings
* View system information

### 🏨 Hotel Owner

* Owner login
* Owner dashboard
* Manage hotel information
* Manage rooms
* View and manage bookings

## 🛠️ Technologies Used

| Technology   | Purpose                   |
| ------------ | ------------------------- |
| PHP          | Backend development       |
| MySQL        | Database management       |
| HTML5        | Web page structure        |
| CSS3         | Styling                   |
| Bootstrap    | Responsive user interface |
| JavaScript   | Client-side functionality |
| XAMPP        | Local development server  |
| phpMyAdmin   | Database management       |
| Git & GitHub | Version control           |

## 📂 Project Structure

```text
HotelBookingSystem/
│
├── admin/
│   ├── bookings.php
│   ├── customers.php
│   ├── dashboard.php
│   ├── hotels.php
│   ├── login.php
│   └── rooms.php
│
├── customer/
│   ├── booking.php
│   ├── hotels.php
│   ├── index.php
│   ├── login.php
│   ├── profile.php
│   └── register.php
│
├── config/
│   ├── database.php
│   └── db.php
│
├── includes/
│
├── assets/
│
├── uploads/
│
├── database/
│   └── hotel_booking_system.sql
│
├── index.php
├── database_test.php
└── README.md
```

## ⚙️ Installation

### 1. Install XAMPP

Download and install XAMPP with:

* Apache
* MySQL
* PHP
* phpMyAdmin

### 2. Clone the Repository

Open PowerShell or Command Prompt:

```bash
cd C:\xampp\htdocs
git clone https://github.com/sahannirmal006/HotelBookingSystem.git
```

### 3. Start XAMPP

Open the XAMPP Control Panel and start:

```text
Apache
MySQL
```

### 4. Create the Database

Open phpMyAdmin:

```text
http://localhost/phpmyadmin
```

Create a database named:

```text
hotel_booking_system
```

### 5. Import the Database

1. Open `hotel_booking_system` in phpMyAdmin.
2. Select **Import**.
3. Choose:

```text
database/hotel_booking_system.sql
```

4. Click **Import**.

### 6. Configure Database Connection

Check the database configuration files inside:

```text
config/
```

Make sure the database settings match your XAMPP MySQL configuration.

Example:

```php
$host = "localhost";
$username = "root";
$password = "";
$database = "hotel_booking_system";
```

### 7. Run the Project

Open your browser and visit:

```text
http://localhost/HotelBookingSystem/
```

## 🔐 User Roles

### Customer

Customers can:

```text
Register
   ↓
Login
   ↓
Browse Hotels
   ↓
View Rooms
   ↓
Make Booking
   ↓
Manage Profile
```

### Administrator

Administrators can manage:

```text
Hotels
Rooms
Customers
Bookings
```

### Hotel Owner

Hotel owners can manage their hotel-related information and bookings.

## 🗄️ Database

The system uses **MySQL** as the database management system.

The database contains tables for major system entities such as:

* Customers
* Hotels
* Rooms
* Bookings
* Users/Administrators
* Hotel-related information

The database SQL file is located at:

```text
database/hotel_booking_system.sql
```

## 🔒 Security

The system includes basic security practices such as:

* User authentication
* Password verification
* Session-based access control
* Database validation
* Role-based access

> **Note:** For production deployment, additional security measures such as password hashing, prepared statements, CSRF protection, input sanitization, and secure session configuration should be implemented where required.

## 🎯 Project Objectives

The main objectives of this project are:

1. To develop an online hotel reservation platform.
2. To simplify the hotel booking process.
3. To provide an easy-to-use customer interface.
4. To provide an administration management panel.
5. To manage hotel rooms and bookings efficiently.
6. To store hotel and customer information in a centralized database.

## 🚀 Future Improvements

Possible future enhancements include:

* Online payment integration
* Email booking confirmation
* Hotel reviews and ratings
* Advanced hotel search and filtering
* Google Maps integration
* Booking cancellation and refund management
* Improved security
* Mobile-responsive improvements
* Hotel owner analytics dashboard
* Automated booking notifications

## 👨‍💻 Developer

**Sahan Nirmal**

GitHub:

https://github.com/sahannirmal006

## 📄 License

This project was developed for educational and academic purposes.

---

⭐ If you find this project useful, consider giving the repository a star!
