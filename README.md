# Project Setup (Laravel Backend + Vue Frontend)

This repository contains two apps in one repo:
- `backend/` → Laravel API
- `frontend/` → Vue.js SPA

## Requirements
- PHP 8.2+ (recommended)
- Composer
- Node.js 18+ (recommended) + npm
- MySQL (or any supported DB)

---

## 1) Clone & Enter
```bash
git clone <REPO_URL>
cd <REPO_FOLDER>

cd backend
composer install
cp .env.example .env
php artisan key:generate

APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_pass

php artisan migrate

php artisan db:seed

php artisan storage:link

cd ../frontend
npm install

Create frontend/.env (Vite):

VITE_API_BASE_URL=http://127.0.0.1:8000/api

Run Both (2 Terminals)

Terminal 1

cd backend
php artisan serve --port=8000

Terminal 2

cd frontend
npm run dev

Laravel cache clear
php artisan config:clear
php artisan cache:clear
php artisan route:clear

Node reinstall
rm -rf node_modules package-lock.json
npm install


**AI Job Portal – short description (copy-ready):**  
An AI-powered job portal that matches candidates with the right jobs using smart recommendations, skill-based filtering, and personalized alerts. Employers can post jobs, manage applications, and shortlist candidates faster, while applicants build profiles, upload CVs, and track application status in one place.
