# Full-Stack To-Do List Application

**Project Date:** August 21, 2025
**Technologies:** HTML5, CSS3, JavaScript (ES6+), PHP, MySQL

## 1. Project Overview

This is a dynamic, single-page to-do list application that demonstrates a solid understanding of full-stack web development principles. The application allows users to add, view, and delete tasks in real-time without page reloads.

The front-end is built with standard, semantic **HTML**, styled with modern **CSS**, and made interactive with client-side **JavaScript**. The back-end consists of a **PHP** script that acts as a RESTful API, communicating with a **MySQL** database to persist task data. This project showcases the seamless interaction between a client-side interface and a server-side backend.

## 2. Core Features

* **Add Tasks:** Users can add new tasks through a simple input form.
* **View Tasks:** All current tasks are fetched from the database and displayed on page load.
* **Delete Tasks:** Users can remove tasks, with changes reflected instantly.
* **Real-Time Interaction:** The front-end updates dynamically using asynchronous JavaScript (AJAX), providing a smooth, single-page application (SPA) experience.
* **Data Persistence:** Tasks are stored in a MySQL database, ensuring data is saved between sessions.

## 3. Technical Architecture

The application follows a classic client-server model. The front-end (client) is completely decoupled from the back-end (server), communicating only through API requests.

### **Front-End (Client-Side)**

The client-side code is responsible for the user interface and user interactions.

* #### HTML (`index.html`)
    The structure of the application is built with semantic HTML5. It contains the main container, a form (`<form>`) for user input, and an unordered list (`<ul>`) which serves as a placeholder for the tasks that will be dynamically loaded by JavaScript.

* #### CSS (`style.css`)
    The application is styled using modern CSS3 techniques. Key features include:
    * **Flexbox:** Used for layout and alignment of components, ensuring a responsive and clean design.
    * **Custom Properties:** CSS variables are used for theme colors, making the design easy to maintain and update.
    * **Transitions:** Subtle hover effects and transitions are used to provide a better user experience.

* #### JavaScript (`script.js`)
    The core of the front-end interactivity is handled by vanilla JavaScript (ES6+).
    * **DOM Manipulation:** The script dynamically creates, updates, and deletes list items in the DOM to reflect the current state of the to-do list.
    * **Event Handling:** Event listeners are used to capture form submissions (`submit`) and button clicks (`click`) to trigger application logic.
    * **Asynchronous API Calls (AJAX):** The `fetch()` API is used to communicate asynchronously with the PHP backend. This is the key to the single-page experience, as it allows the front-end to send and receive data (like adding or deleting a task) without a full page refresh.

### **Back-End (Server-Side)**

The back-end is responsible for all business logic and database interactions.

* #### PHP (`api.php`)
    This file serves as a simple, single-endpoint RESTful API. It handles all incoming requests from the front-end.
    * **Request Routing:** It checks the HTTP request method (`GET`, `POST`) to determine the requested action.
        * A `GET` request fetches all tasks.
        * A `POST` request handles both adding and deleting tasks, determined by an `action` parameter in the JSON payload.
    * **Database Interaction:** It connects to the MySQL database, executes SQL queries, and processes the results.
    * **JSON Response:** All data sent back to the front-end is encoded in JSON format (`application/json`), which is the standard for modern APIs.

* #### MySQL (Database)
    The database provides data persistence.
    * **Schema:** A single table named `tasks` is used. It includes columns for `id` (Primary Key, Auto Increment), `task` (the text of the to-do item), and `created_at` (a timestamp). This simple schema is efficient for the application's needs.

## 4. Full-Stack Data Flow (Example: Adding a Task)

Understanding the data flow is key to understanding the application.

1.  **User Action:** The user types a new task into the input field and clicks the "Add Task" button.
2.  **JavaScript Event:** The `submit` event listener on the form is triggered. It prevents the default form submission, captures the input value, and calls the `addTask()` function.
3.  **Fetch API Call:** The `addTask()` function makes an asynchronous `POST` request to `api.php` using `fetch()`. The task text is sent in the request body as a JSON object (e.g., `{ "action": "add", "task": "Buy milk" }`).
4.  **PHP Processing:** The `api.php` script receives the `POST` request. It decodes the JSON body, sees the action is `'add'`, and connects to the database.
5.  **SQL Execution:** The script executes a prepared `INSERT` statement to securely add the new task to the `tasks` table in the MySQL database.
6.  **PHP Response:** Upon successful insertion, the PHP script sends a JSON response back to the front-end (e.g., `{ "success": true }`).
7.  **JavaScript Updates UI:** The `fetch()` call in `script.js` receives the success response. It then calls the `fetchTasks()` function, which makes a new `GET` request to the API to get the updated list of all tasks.
8.  **DOM Manipulation:** The `fetchTasks()` function clears the current list in the HTML and re-renders it with the new, complete list from the database, so the user instantly sees their newly added task.

## 5. Security Considerations

Even in a simple application, security is important. The primary security measure implemented is the use of **PHP Prepared Statements** (`$stmt->prepare()` and `$stmt->bind_param()`). This prevents **SQL Injection** attacks by separating the SQL query logic from the user-provided data, ensuring that user input cannot be maliciously executed as a database command.