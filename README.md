# Portfolio Website

A modern, responsive portfolio website built with Laravel (backend) and Vue.js (frontend).

## Features

- 🎨 Beautiful and modern UI with Tailwind CSS
- 📱 Fully responsive design
- 🚀 Fast and optimized performance
- 🔐 Admin dashboard for content management
- 📧 Contact form with email notifications
- 🎯 Project showcase with images
- 💼 Skills and services display
- 📄 Resume download functionality

## Tech Stack

### Backend
- Laravel 11
- PHP 8.2+
- MySQL
- Laravel Sanctum (Authentication)

### Frontend
- Vue.js 3
- Tailwind CSS
- Vite
- Axios

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js and npm
- MySQL
- XAMPP (optional, for local development)

### Backend Setup

1. Navigate to the backend directory:
```bash
cd backend
```

2. Install PHP dependencies:
```bash
composer install
```

3. Copy the environment file:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Configure your `.env` file with database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=
```

6. Run migrations and seeders:
```bash
php artisan migrate --seed
```

7. Create storage symlink:
```bash
php artisan storage:link
```

8. Start the development server:
```bash
php artisan serve
```

The backend will be available at `http://localhost:8000`

### Frontend Setup

1. Navigate to the frontend directory:
```bash
cd frontend
```

2. Install npm dependencies:
```bash
npm install
```

3. Start the development server:
```bash
npm run dev
```

The frontend will be available at `http://localhost:5173`

## Admin Access

- **Login URL**: `/admin/login`
- **Default Credentials**: Check `backend/database/seeders/AdminUserSeeder.php`

## Project Structure

```
.
├── backend/          # Laravel backend API
│   ├── app/
│   ├── config/
│   ├── database/
│   ├── routes/
│   └── storage/
└── frontend/         # Vue.js frontend
    ├── src/
    ├── public/
    └── package.json
```

## Features

### Admin Dashboard
- Manage profile information
- Add/Edit/Delete projects
- Manage services and skills
- View and manage contact messages
- Upload project images and avatar

### Public Portfolio
- Hero section with profile information
- Services showcase
- Projects gallery with pagination
- Skills display
- Contact form

## API Endpoints

### Public
- `GET /api/profile` - Get profile information
- `GET /api/projects` - Get all projects
- `GET /api/services` - Get all services
- `GET /api/skills` - Get all skills
- `POST /api/contact` - Send contact message

### Admin (Requires Authentication)
- `GET /api/admin/profile` - Get admin profile
- `PUT /api/admin/profile` - Update profile
- `POST /api/admin/profile/avatar` - Upload avatar
- `POST /api/admin/profile/resume` - Upload resume
- `GET /api/admin/projects` - Get all projects
- `POST /api/admin/projects` - Create project
- `PUT /api/admin/projects/{id}` - Update project
- `DELETE /api/admin/projects/{id}` - Delete project
- `POST /api/admin/projects/images` - Upload project images

## Development

### Export Projects to Seeder
To sync your current projects from the database to the seeder file:
```bash
php artisan projects:export-seeder
```

## License

This project is open-source and available under the MIT License.

