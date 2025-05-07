# {Project} Backend API

This repository contains the backend API for the {Project} project. The project is containerized using Docker and Docker Compose, making it easy to set up and deploy.

## Prerequisites

Ensure you have the following installed on your system:
- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Environment Setup

Before starting the project, ensure you have the necessary environment files:

1. Create a `.env` file from the provided `.env.example` template:
   ```sh
   cp .env.example .env
   ```
2. The project includes an admin panel using Laravel Nova, which is installed from a private repository. Before launching the project, you need to create an `auth.json` file with authentication credentials:
   ```json
   {
       "http-basic": {
           "nova.laravel.com": {
               "username": "ng@empat.tech",
               "password": "password" 
           }
       }
   }
   ```

## Getting Started

### 1. Build the API Container

Before starting the project, build the API container:
```sh
docker-compose build api
```

### 2. Start the API Container

Run the following command to start the API container and install dependencies:
```sh
docker-compose up api
```
Wait for the container to complete the installation of dependencies.

### 3. Stop the API Container

Once dependencies are installed, stop the API container:
```sh
docker-compose down
```

### 4. Start All Containers

Now, start all services in detached mode:
```sh
docker-compose up -d
```

### 5. Enter the API Container

To install dependencies, run database migrations and set up the application, access the API container:
```sh
docker-compose exec api bash
```

### 6. Install dependencies
```sh
composer i
```

### 7. Run Migrations

Inside the container, run the database migrations:
```sh
php artisan migrate
```

For seeding database run:
```sh
php artisan db:seed
```

## Services Overview

This project consists of multiple services:

- **nginx**: The web server, serving API
- **api**: The main backend service.
- **horizon**: Laravel Horizon for queue management.
- **scheduler**: Runs scheduled tasks.
- **mysql**: MySQL database.
- **redis**: Redis caching server.
- **mailpit**: Mail testing tool.
- **phpmyadmin**: MySQL management interface.
- **phpredisadmin**: Redis administration tool.

## Useful Commands

- Stop all services:
  ```sh
  docker-compose down
  ```
- Restart all services:
  ```sh
  docker-compose up -d --build
  ```
- View logs:
  ```sh
  docker-compose logs -f api
  ```
- Access MySQL via phpMyAdmin: `http://localhost:8080` (default credentials are set in `.env`).
- Access Redis Admin: `http://localhost:8081`.

## Conclusion

Your {Project} backend API should now be running successfully. If you encounter any issues, check the logs and ensure all services are properly running.
