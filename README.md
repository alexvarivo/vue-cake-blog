# Vue + CakePHP Blog

Full-stack blog app with a CakePHP 4 backend and Vue 3 frontend.

## Features
- JWT login
- Create, edit, and delete articles
- Auth-protected routes on both frontend and backend
- Dockerized backend with MariaDB

## Setup

### Backend
1. Clone the repo and copy the config files:
   ```bash
   cp .env.example .env
   cp app/config/app_local.example.php app/config/app_local.php
   ```
2. Start Docker:
   ```bash
   docker compose up -d
   ```
3. Run migrations:
   ```bash
   docker compose exec app bin/cake migrations migrate
   ```
4. Create a user through PhpMyAdmin at http://localhost:8083

### Frontend
```bash
cd vue-frontend
npm install
npm run dev
```

## URLs
- Frontend: http://localhost:5173
- Backend API: http://localhost:8081
- PhpMyAdmin: http://localhost:8083

## API Routes
- `POST /users/login` — login
- `GET /articles` — get all articles
- `POST /articles/add` — create article (auth required)
- `PUT /articles/edit/:id` — edit article (auth required)
- `DELETE /articles/delete/:id` — delete article (auth required)
