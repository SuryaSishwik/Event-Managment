# EventPro - Event Management System

## Project Setup

1. Database Setup:
   ```bash
   # Import the database schema
   mysql -u root -p < sql/database.sql
   ```

2. Configure Apache:
   - Place the project in your Apache web root (e.g., htdocs for XAMPP)
   - Make sure mod_rewrite is enabled
   - The .htaccess file will handle routing

3. Update Database Configuration:
   - Open `config/database.php`
   - Update the database credentials if needed:
     ```php
     private $host = "localhost";
     private $db_name = "eventpro_db";
     private $username = "root";
     private $password = "";
     ```

4. File Structure:
   ```
   /frontend/         # Frontend HTML files and assets
     /js/            # JavaScript files
     *.html          # HTML pages
   /api/             # PHP API endpoints
     /auth/          # Authentication endpoints
     /events/        # Event management endpoints
     /tickets/       # Ticket management endpoints
   /config/          # Configuration files
   /sql/            # Database schema
   ```

5. Available Pages:
   - Home: index.html
   - Login: login.html
   - Signup: signup.html
   - Create Event: createEvent.html
   - Smart Ticketing: smart-ticketing.html
   - Analytics: analytics.html
   - Contact: contact.html

6. API Endpoints:
   - Authentication:
     - POST /api/auth/login.php
     - POST /api/auth/signup.php
   - Events:
     - POST /api/events/create.php
     - GET /api/events/list.php
   - Tickets:
     - POST /api/tickets/purchase.php
     - GET /api/tickets/list.php
   - Analytics:
     - GET /api/analytics/stats.php

## Usage

1. Start your Apache and MySQL servers (e.g., using XAMPP)
2. Access the site at: http://localhost/your-project-folder/
3. Create an account or login
4. Start managing events and tickets!

## Features

- User Authentication
- Event Creation and Management
- Ticket Purchase System
- Event Analytics
- Responsive Design
- Real-time Updates
