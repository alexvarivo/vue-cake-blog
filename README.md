# CakePHP Blog CMS with Authentication

## Overview
This is a simple CMS-style blog application built using **CakePHP 4.x**, containerized with **Docker**. It supports:
- User authentication (login/logout)
- Article CRUD (create, read, update, delete)
- Tagging system with many-to-many relations

## Features
-  User login/logout  
-  Restrict actions to authenticated users  
-  Articles with tags (many-to-many)  
-  Full CRUD for Users, Articles, and Tags  
-  Protected routes using CakePHP Authentication plugin  
-  Built-in Flash messages and form validation  
-  Uses Docker and Docker Compose for setup

## Setup

### Prerequisites
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

### Installation
1. Clone this repository:
   ```bash
   git clone https://github.com/alexvarivo/cakephp-proj
   cd cakephp-proj
2. Copy the environment config:
   cp .env.example .env
3. Start the containers:
   docker compose up -d
4. Enter the container:
   docker compose exec app bash
5. Install dependencies:
   composer install
6. Run database migrations:
   bin/cake migrations migrate
7. Insert user through PhpMyAdmin (http://localhost:8082)
   Use the users table and insert a new row with:
      username: admin
      password: (hashed using Authentication\PasswordHasher\DefaultPasswordHasher)
      
      Example hash for admin123:
         $2y$10$KHBtkVQGuvuNsafxqmUNH.MHNLU6xK36RhS.m8xZbYLuZbzqn63cS

## Usage
- App URL: http://localhost:8081
- PhpMyAdmin: http://localhost:8082
- Login route: /users/login
- Logout route: /users/logout
- Articles: /articles
- Tags: /tags

## Testing
- Login with valid/invalid credentials
-  Add/edit/delete articles when logged in
-  Verify you cannot access add/edit/delete without login
-  Tags can be assigned to articles
-  Logout redirects to login page

## Structure
app/
├── src/                # Application code (Controllers, Models, etc.)
├── templates/          # View files (HTML/PHP)
├── config/             # Database and app config
├── docker-compose.yml  # Docker container setup
├── .env                # Environment configuration
├── README.md           # This file





