# To-Do List Application

## Overview

The To-Do List application is a simple project built using PHP, MySQL, and Bootstrap. It allows users to add, update, and delete tasks. The application demonstrates basic CRUD (Create, Read, Update, Delete) operations, form handling, and interaction with a MySQL database.

## Features

- **Add Task**: Users can add new tasks to their to-do list.
- **Update Task**: Users can update existing tasks.
- **Delete Task**: Users can delete tasks from their list.
- **View Tasks**: Users can view all tasks in a tabular format.

## Technologies Used

- **PHP**: Server-side scripting language for processing requests and interacting with the database.
- **MySQL**: Database system for storing tasks.
- **Bootstrap**: CSS framework for styling the application.
- **cURL**: PHP library for making API requests.

## Installation

### Prerequisites

- XAMPP or any other PHP server with MySQL support
- A web browser

### Setup

1. **Clone the Repository**

   ```bash
   git clone https://github.com/DataGeek404/To-Do-List.git

2. **Set Up the Database**

Import the provided SQL script to create the necessary tables in your MySQL database.
Adjust the database connection settings in includes/db.php.
Configure the Project

Ensure that your project directory is within the htdocs folder of XAMPP or another accessible directory of your PHP server.
Start the Server

Start Apache and MySQL from the XAMPP control panel or equivalent service management tool.
Access the Application

Open your web browser and navigate to http://localhost/To-Do-List/index.php.
Usage
Adding a Task
Enter the task description in the input field and click Add Task.
Updating a Task
Click the Edit button next to a task. The task description will appear in the input field for editing. Click Update Task to save changes.
Deleting a Task
Click the Delete button next to a task to remove it from the list.

```bash

API Endpoints
Add Task: POST http://localhost/To-Do-List/api/add_task.php
Update Task: PUT http://localhost/To-Do-List/api/update_task.php
Delete Task: DELETE http://localhost/To-Do-List/api/delete_task.php
Get Tasks: GET http://localhost/To-Do-List/api/get_tasks.php

3. **File Structure**

```bash
To-Do-List/
├── api/
│   ├── add_task.php
│   ├── delete_task.php
│   ├── get_tasks.php
│   └── update_task.php
├── css/
│   └── styles.css
├── includes/
│   ├── db.php
│   └── index.php
├── index.php
└── README.md
