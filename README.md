# Task Management Application
This is a simple Laravel web application for task management with the ability to create, edit, delete, and reorder tasks using drag-and-drop functionality. Tasks are associated with projects, and users can filter tasks by selecting a project from a dropdown.

## Features

- **Create Task**: 
  - Add a task with the following details:
   - Task name
  - Priority (automatically set based on order)
  - Timestamps (created_at and updated_at)
- **Edit Task**: You can update the task name by clicking the "Edit" button next to any task.

- **Delete Task**: Delete tasks easily with a delete button.

- **Reorder Tasks**: Drag-and-drop tasks to reorder them within a project. The priority is automatically updated based on the new order (priority #1 is at the top, #2 next down, etc.).

- **Project Functionality (BONUS)**:
  - Tasks are grouped by projects.
  - Users can create new projects.
  - Users can select a project from a dropdown to view and manage tasks       associated with that project

## Demo
If you'd like to see the application in action, check the demo here: <a href="https://task.henoktesfu.me/"> Demo </a>
repository link <a href="https://task.henoktesfu.me/"> Demo </a>
## Setup Instructions
**Prerequisites**

Before setting up the application, ensure you have the following installed on your machine:

- PHP >= 8.0
- Composer
- Node.js & npm
- MySQL

**Step-by-Step Setup Guide**
<ol>
  <li> <strong> Clone the Repository </strong> </li>
      If you're using Git to clone the repository, run:

       git clone <repository-url>
       cd task-management-app
  <li> <strong> Install Composer Dependencies </strong> </li>
      Install the necessary PHP dependencies:

      composer install
<li> <strong> Install Node Dependencies </strong> </li>
      Install the necessary JavaScript and CSS dependencies using npm:

      npm install
<li> <strong> Set Up Environment File </strong> </li>
      Copy the .env.example file to create the .env file:

      cp .env.example .env

  Install the necessary PHP dependencies:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database
    DB_USERNAME=your_user
    DB_PASSWORD=your_password
<li> <strong> Generate Application Key </strong> </li>
      Run the following command to generate the application key:

      php artisan key:generate
<li> <strong> Run Migrations </strong> </li>
      Run the database migrations to create the necessary tables:

      php artisan migrate
<li> <strong> Compile Frontend Assets </strong> </li>
      Compile the CSS and JavaScript assets using Vite:

      npm run dev
<li> <strong> Serve the Application </strong> </li>
      Serve the application using the built-in Laravel development server:

      php artisan serve

  The application should now be accessible at **http://127.0.0.1:8000.**
</ol>

