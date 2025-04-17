# Blogitee (https://blogitee.42web.io/)
Full-stack Blog application for both clients and administrators
Blogitee is a full-stack Blog application with content management system designed for both clients and administrators. This project aims to deliver a responsive and scalable blogging platform with efficient client-server interaction and a secure backend system. 

<img width="1512" alt="Screenshot 2025-04-16 at 9 40 04 PM" src="https://github.com/user-attachments/assets/69fa2cc3-6189-4d03-b811-3224324f6fe3" />


## ✨ Features

- **User Management**: Supports user registration, login, and role-based access (Admins and Authors).
- **Post Management**: Create, edit, delete, and display posts with categories, thumbnails, and featured post options.
- **Search Functionality**: Real-time search with keywords in titles and categories.
- **Responsive Design**: Fully responsive across devices, ensuring a smooth user experience.
- **Dynamic Dashboard**: Admin dashboard for managing users, posts, and categories.
- **Secure Communication**: Configured with HTTPS and SSL/TLS certificates for encrypted and secure connections.
- **Interactive UI**: Float labels for inputs, confirmation modals, and custom design elements.

## 🌐 Deployment

The Blogitee Web App is deployed using **InfinityFree** with SSL/TLS certificates enabled for secure communication.


## 📢 Note for Best Experience

For the best user experience with all built-in features, please use the administrator account:
- **Username**: `admin`
- **Password**: `123123123`

## 🚀 Technologies Used

- **Frontend**: HTML, CSS, JavaScript (interactive UI elements)
- **Backend**: PHP
- **Database**: MySQL
- **Version Control**: Git, GitHub
- **Hosting**: InfinityFree (deployed with HTTPS and SSL/TLS certificates)


## 🔧 Setup Instructions to run with your own database 

1. Clone the repository from GitHub:
   ```bash
   git clone https://github.com/StephenNg25/Blogitee.git
2. Navigate to the project directory:
   ```bash
   cd your-own-saved-filename
3. Download and install XAMPP:
- Visit the XAMPP website and install XAMPP for your operating system.
4. Set up the MySQL database:
- Start the Apache and MySQL services in the XAMPP Control Panel.
- Open phpMyAdmin in your browser (http://localhost/phpmyadmin/)
- Create a new database, for example, blogitee.
- Import the provided SQL file (if available) to set up the database schema and initial data.
5. Configure your project:

- Place the entire your-own-saved-filename folder into the htdocs directory located in your XAMPP installation directory (XAMPP/htdocs/).
- Update the config/constants.php file with your database details:
  ```bash
  define('DB_HOST', 'localhost');
  define('DB_USER', 'your-database-username');
  define('DB_PASS', 'your-database-password');
  define('DB_DATABASE', 'blogitee'); // or your chosen database name
- Update the config/database.php file with your database details:
  ```bash
  $connection = mysqli_connect(DB_HOST,DB_USER, DB_PASS, DB_DATABASE);
  
6. Run the application:

- Open your browser and navigate to http://localhost/your-own-saved-filename/ to view the project.
- Access specific files or features via their respective routes, e.g., http://localhost/your-own-saved-filename/filename.php.
  

