# SmartCampus 🎓

SmartCampus is a web-based academic management system developed using **PHP, MySQL, Bootstrap 5, HTML, CSS, and JavaScript**.
The platform is designed to digitize and streamline university academic operations through role-based access for **Admin**, **Teacher**, and **Student** users.

---

# 🚀 Features

## 👨‍💼 Admin Panel

Admins have complete control over the system.

### Functionalities

* Manage Students (Add, Edit, Delete, View)
* Manage Teachers
* Manage Departments
* Manage Subjects
* Assign Subjects to Teachers
* Post Notices
* Generate Roll Number Slips

### Advanced Feature

#### Bulk Roll Slip Generation

Admins can:

* Select Department
* Select Semester
* Add Subject-wise Exam Dates

The system automatically generates roll number slips for all students of the selected department and semester.

---

## 👨‍🏫 Teacher Panel

Teachers can manage academic activities for assigned subjects.

### Functionalities

* View Assigned Subjects
* Mark Attendance
* View Attendance Records
* Upload Course Materials
* Add Student Marks
* View Student Results

### Smart Attendance System

Teachers first select a subject, then:

* Students are filtered automatically
* Only students from the relevant:

  * Department
  * Semester
    are displayed.

---

## 👨‍🎓 Student Panel

Students can access their academic information.

### Functionalities

* View Dashboard
* View Attendance Percentage
* View Marks / Results
* Download Course Materials
* View Notices
* View & Download Roll Number Slip (PDF)

### Roll Slip Feature

Generated roll slips include:

* Student Information
* Department
* Semester
* Subject-wise Exam Schedule

---

# 🔐 Authentication & Security

The system includes:

* Secure Login System
* Session-based Authentication
* Password Hashing using `password_hash()`
* Role-based Access Control
* Unauthorized Access Protection
* PDO Prepared Statements (SQL Injection Protection)

---

# 📚 Core Modules

## Student Management

* Add/Edit/Delete Students
* Student linked with user account
* Department & semester management

## Teacher Management

* Teacher account creation
* Subject assignment
* Department linking

## Department Management

* Create/Delete departments
* Shared across all modules

## Subject Management

Subjects are linked with:

* Teachers
* Departments
* Semesters

Used in:

* Attendance
* Marks
* Roll Slips

## Attendance System

Attendance is stored with:

* Student ID
* Subject ID
* Date

Students can view attendance percentages from their dashboard.

## Marks Management

Teachers can:

* Assign marks
* Update marks

Students can:

* View results

## Materials System

Teachers upload:

* PDFs
* Notes
* Study material files

Students can:

* View
* Download materials

## Notice System

Admins can post notices visible to all students.

---

# 🧾 Roll Number Slip System

## Features

* Bulk roll slip generation
* Department & semester based
* Subject-wise exam schedule
* PDF download support
* Latest slip visibility

### Data Handling

Roll slip data is stored as structured JSON in the database.

---

# 🗄️ Database Design

The project uses a normalized relational database with:

* Primary Keys
* Foreign Key Relationships
* InnoDB Engine
* UTF8MB4 Charset

## Main Tables

* users
* students
* teachers
* departments
* subjects
* attendance
* marks
* materials
* notices
* roll_slips

---

# 🎨 User Interface

Built with **Bootstrap 5** featuring:

* Responsive Layout
* Sidebar Navigation
* Dashboard Cards
* Data Tables
* Alerts & Notifications

---

# 🛠️ Tech Stack

## Frontend

* HTML5
* CSS3
* JavaScript
* Bootstrap 5

## Backend

* PHP

## Database

* MySQL

---

# 🌟 Key Highlights

* Role-based Academic System
* Real-world University Workflow Simulation
* Dynamic Roll Slip Generation
* Subject-based Attendance Filtering
* Secure Authentication System
* Clean & Modular Structure
* Responsive UI Design

---

# 📌 Project Objective

The goal of SmartCampus is to:

* Digitize academic workflows
* Reduce manual work
* Centralize academic data
* Improve efficiency
* Simulate a real-world university management system

---

# ✅ Conclusion

SmartCampus demonstrates a complete academic management workflow with secure backend operations, modular architecture, and a user-friendly interface.

The project is suitable for:

* Academic Management System Demonstrations
* PHP/MySQL Learning Projects

---
