# VueJS Frontend for CakePHP Blog

## Overview
This is a full-stack blog application built using CakePHP 4.x for the backend and Vue.js for the frontend. It includes:
- JWT-based user authentication
- Article creation and viewing
- Dockerized backend setup

## Features

### Backend (CakePHP 4.x)
- JWT login and authentication
- REST-style API for articles
- CORS middleware support
- Auth-protected endpoints
- MySQL database + PhpMyAdmin

### Frontend (Vue 3 + Vite)
- Login and token handling with `localStorage`
- View all articles
- View article details
- Create new articles (auth required)
- Frontend route protection based on login state

## Project Structure
cakephp-proj/
├── app/ # CakePHP backend
├── config/ # Backend configuration
├── docker-compose.yml # Docker setup
├── vue-frontend/ # Vue 3 frontend (Vite)

## Setup

### Backend (CakePHP)
1. Clone this repository:
   ```bash
   git clone https://github.com/alexvarivo/vue-cake-blog.git
   cd vue-cake-blog
2. Copy the environment config:
   cp .env.example .env
3. Start the containers:
   docker compose up -d
4. Enter the app container and install dependencies:
   docker compose exec app bash
   composer install
   bin/cake migrations migrate
5. Add a test user manually through PhpMyAdmin (http://localhost:8082):
   - username: admin
   - password hash: $2y$10$KHBtkVQGuvuNsafxqmUNH.MHNLU6xK36RhS.m8xZbYLuZbzqn63cS (for password admin123)
   
### Frontend (Vue.js)
1. Navigate to the frontend:
   cd vue-frontend
2. Install dependencies:
   npm install
3. Start the dev server:
   npm run dev

### Usage
- Frontend: http://localhost:5173
- Backend API: http://localhost:8081
- PhpMyAdmin: http://localhost:8082

### Routes
- GET /login — User login
- GET /articles — View all articles
- GET /view/:id — View article details
- POST /add — Add article (auth required)
