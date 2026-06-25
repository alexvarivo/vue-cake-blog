# Vue + CakePHP Blog

Full-stack blog app with a CakePHP 4 backend and Vue 3 frontend.

## Features
- JWT login
- Create, edit, and delete articles
- Auth-protected routes on both frontend and backend
- Dockerized backend with MariaDB

## Setup

### Backend
1. Clone the repo and copy the env file:
   ```bash
   cp .env.example .env
   ```
2. Start Docker:
   ```bash
   docker compose up -d
   ```
3. Run migrations:
   ```bash
   docker compose exec app bash
   bin/cake migrations migrate
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
