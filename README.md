# 🚗 Moonlit Detailing - Booking & Management System

A comprehensive car detailing booking platform with customer booking interface and admin dashboard, containerized with Docker for easy deployment.

## 📋 Table of Contents

- [Features](#features)
- [System Architecture](#system-architecture)
- [Prerequisites](#prerequisites)
- [Quick Start](#quick-start)
- [Development Setup](#development-setup)
- [Production Deployment](#production-deployment)
- [Application Structure](#application-structure)
- [Environment Variables](#environment-variables)
- [Troubleshooting](#troubleshooting)

## ✨ Features

### Customer Booking Interface
- 🏠 Location selection (customer location or business hub)
- 🚙 Car type selection
- 📋 Service plan selection with pricing
- 📅 Date and time booking with availability checking
- 💳 Multiple payment methods (Bank Transfer, Cash)
- 📍 Distance-based pricing with callout fees
- 📧 Booking confirmation with unique booking ID

### Admin Dashboard
- 📊 Dashboard with booking statistics
- 👥 Customer management
- 📦 Product/Service management
- 🚗 Car type management
- 💰 Pricing management
- 📅 Working hours configuration
- 🧾 Invoice generation
- 🔔 Booking notifications

### API Features
- RESTful API for booking operations
- CORS enabled for cross-origin requests
- Automated slot availability calculation
- Distance-based pricing calculation using Haversine formula
- Receipt upload handling

## 🏗️ System Architecture

```
┌─────────────────────────────────────────────┐
│           Docker Environment                │
├─────────────────────────────────────────────┤
│  ┌────────────┐  ┌──────────────────────┐  │
│  │  MySQL DB  │  │   PHP Apache Server  │  │
│  │            │  │                      │  │
│  │  Port 3306 │◄─┤  - Booking Frontend  │  │
│  │            │  │  - Admin Dashboard   │  │
│  └────────────┘  │  - API Endpoint      │  │
│                  │                      │  │
│                  │  Port 80 → Host:8080 │  │
│                  └──────────────────────┘  │
└─────────────────────────────────────────────┘
```

## 📦 Prerequisites

- **Docker** (v20.10+)
- **Docker Compose** (v2.0+)
- **Git**
- Port 8080 and 3307 available on your machine

## 🚀 Quick Start

### 1. Clone the Repository

```bash
git clone <your-repository-url>
cd MoonlitDetailing
```

### 2. Review Environment Variables

The `.env` file has been created with default development settings. Review and modify if needed:

```bash
nano .env
```

### 3. Start Docker Containers

```bash
docker-compose up -d
```

This will:
- Create and start the MySQL database container
- Initialize the database with `moonlit.sql`
- Create and start the PHP Apache web server
- Map ports to your local machine

### 4. Verify Installation

- **Booking Interface:** http://localhost:8080
- **Admin Dashboard:** http://localhost:8080/dashboard
- **API Endpoint:** http://localhost:8080/dashboard/api.php

### 5. Default Admin Login

Check the database for existing admin credentials or create one through the admin interface.

## 💻 Development Setup

### File Structure

```
MoonlitDetailing/
├── docker/                  # Docker configuration
│   ├── php/                # PHP Dockerfile & config
│   ├── apache/             # Apache virtual host config
│   └── mysql/              # MySQL initialization scripts
├── public/                 # Web-accessible files
│   ├── index.php          # Booking homepage
│   ├── select-*.php       # Booking flow pages
│   ├── assets/            # Frontend assets (CSS, JS, images)
│   ├── dashboard/         # Admin dashboard
│   │   ├── api.php       # API endpoint
│   │   ├── process/      # Backend processing scripts
│   │   └── assets/       # Dashboard assets
│   └── uploads/          # User-uploaded files
├── src/                   # Backend code (not web-accessible)
│   ├── config/           # Configuration files
│   │   ├── init.php     # Central bootstrap
│   │   ├── database.php # Database connection
│   │   ├── app.php      # App configuration
│   │   └── session.php  # Authentication handler
│   ├── functions/        # Business logic
│   └── views/           # Reusable view components
├── .env                  # Environment variables (not in git)
├── .env.example         # Environment template
└── docker-compose.yml   # Development Docker config
```

### Making Changes

1. **Edit Files:** All application files are mounted as volumes, so changes reflect immediately
2. **Restart Services:** If you modify PHP configuration:
   ```bash
   docker-compose restart web
   ```
3. **View Logs:**
   ```bash
   docker-compose logs -f web
   docker-compose logs -f db
   ```

### Database Access

Access MySQL from your local machine:

```bash
mysql -h 127.0.0.1 -P 3307 -u moonlit_user -p
# Password: moonlit_secure_2025 (from .env)
```

Or use a GUI client:
- **Host:** 127.0.0.1
- **Port:** 3307
- **Username:** moonlit_user
- **Password:** moonlit_secure_2025
- **Database:** moonlit

## 🚀 Production Deployment

### 1. Update Environment Variables

Copy `.env.example` to `.env.prod` and update with production values:

```bash
cp .env.example .env.prod
nano .env.prod
```

Update these critical values:
- `APP_ENV=production`
- `APP_DEBUG=false`
- `DB_PASSWORD` (use strong password)
- `DB_ROOT_PASSWORD` (use strong password)
- `APP_URL` (your production domain)
- `API_BASE_URL` (your production API URL)

### 2. Deploy with Production Overrides

```bash
docker-compose -f docker-compose.yml -f docker-compose.prod.yml --env-file .env.prod up -d
```

### 3. Security Checklist

- ✅ Change all default passwords
- ✅ Enable HTTPS (uncomment HTTPS redirect in `.htaccess`)
- ✅ Set `APP_DEBUG=false`
- ✅ Restrict database port (don't expose 3306 externally)
- ✅ Configure proper firewall rules
- ✅ Regular database backups
- ✅ Keep Docker images updated

## 📂 Application Structure

### Key Files

| File | Purpose |
|------|---------|
| `src/config/init.php` | Central bootstrap - loads all dependencies |
| `src/config/database.php` | Database connection with environment variables |
| `src/config/app.php` | Application settings and helper functions |
| `src/config/session.php` | Authentication handler for dashboard |
| `public/dashboard/api.php` | RESTful API endpoint |
| `docker-compose.yml` | Development Docker configuration |
| `docker-compose.prod.yml` | Production overrides |

### API Endpoints

Base URL: `http://localhost:8080/dashboard/api.php`

| Endpoint | Method | Description |
|----------|--------|-------------|
| `?action=get_site_info` | GET | Get site configuration |
| `?action=get_cars` | GET | Get all car types |
| `?action=get_products` | GET | Get service plans |
| `?action=get_available_slots` | GET | Get available time slots |
| `?action=get_price` | GET | Calculate pricing with callout fee |
| `?action=create_booking` | POST | Create new booking |
| `?action=get_booking` | GET | Get booking details |

## 🔧 Environment Variables

### Database

| Variable | Description | Default |
|----------|-------------|---------|
| `DB_HOST` | Database hostname | `db` (container name) |
| `DB_NAME` | Database name | `moonlit` |
| `DB_USER` | Database user | `moonlit_user` |
| `DB_PASSWORD` | Database password | `moonlit_secure_2025` |
| `DB_ROOT_PASSWORD` | MySQL root password | `root_secure_2025` |
| `DB_PORT` | Internal database port | `3306` |
| `DB_EXTERNAL_PORT` | External database port | `3307` |

### Application

| Variable | Description | Default |
|----------|-------------|---------|
| `APP_ENV` | Environment (development/production) | `development` |
| `APP_DEBUG` | Enable debug mode | `true` |
| `APP_URL` | Application URL | `http://localhost:8080` |
| `API_BASE_URL` | API endpoint URL | `http://localhost:8080/dashboard/api.php` |
| `WEB_PORT` | External web port | `8080` |

### PHP

| Variable | Description | Default |
|----------|-------------|---------|
| `PHP_VERSION` | PHP version | `8.3` |
| `PHP_MEMORY_LIMIT` | Memory limit | `256M` |
| `PHP_UPLOAD_MAX_FILESIZE` | Max upload size | `20M` |
| `PHP_POST_MAX_SIZE` | Max POST size | `20M` |

## 🐛 Troubleshooting

### Port Already in Use

If port 8080 or 3307 is already in use, change them in `.env`:

```env
WEB_PORT=8081
DB_EXTERNAL_PORT=3308
```

Then restart containers:

```bash
docker-compose down
docker-compose up -d
```

### Database Connection Failed

1. Check if database container is running:
   ```bash
   docker-compose ps
   ```

2. Check database logs:
   ```bash
   docker-compose logs db
   ```

3. Verify credentials in `.env` match the application

### Permission Denied on Uploads

Fix upload directory permissions:

```bash
docker-compose exec web chown -R www-data:www-data /var/www/html/uploads
docker-compose exec web chmod -R 775 /var/www/html/uploads
```

### Clear and Rebuild Containers

If you encounter persistent issues:

```bash
# Stop and remove containers
docker-compose down

# Remove volumes (WARNING: This will delete database data!)
docker-compose down -v

# Rebuild and start fresh
docker-compose up -d --build
```

### View Application Logs

```bash
# Web server logs
docker-compose logs -f web

# Database logs
docker-compose logs -f db

# All logs
docker-compose logs -f
```

## 🔄 Common Commands

```bash
# Start containers
docker-compose up -d

# Stop containers
docker-compose down

# Restart containers
docker-compose restart

# View logs
docker-compose logs -f

# Rebuild containers
docker-compose up -d --build

# Access web container shell
docker-compose exec web bash

# Access database
docker-compose exec db mysql -u root -p

# Backup database
docker-compose exec db mysqldump -u root -p moonlit > backup.sql

# Restore database
docker-compose exec -T db mysql -u root -p moonlit < backup.sql
```

## 📝 License

Proprietary - All rights reserved

## 🤝 Support

For support, please contact: admin@moonlit.local

---

**Built with ❤️ for Moonlit Detailing**

