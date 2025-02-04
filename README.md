# Symfony Product Manager Application

This Symfony application implements a product manager with CRUD functionality and a product parser that extracts product data (name, photo, price) from the website [alza.cz](https://www.alza.cz). The application is containerized with Docker and uses PHP 8.3, PostgreSQL, and Nginx.

## Features

1. **CRUD Operations**: Manage products with fields like name, price, photo, and description.
2. **Product Parser**: Automatically extract product details from a given Alza URL.
3. **Unit Test**: Ensures the parser correctly retrieves product information.

## GitHub Repository

The source code for this project is available at: [https://github.com/AIEnEss12/slotegrator-test-task](https://github.com/AIEnEss12/slotegrator-test-task)

## Prerequisites

- **Docker** (version 20.10 or higher)
- **Docker Compose** (version 1.29 or higher)

## Installation and Setup

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/AIEnEss12/slotegrator-test-task.git
   cd slotegrator-test-task
  docker-compose up --build
  Access the Application: Once the containers are up, open your browser and visit:

  http://localhost:8180

2. **Run Database Migrations: In a separate terminal, execute the following command to run migrations:**
docker-compose exec php-8.3-fpm php bin/console doctrine:migrations:migrate
3. **Run Tests: Execute the following command in the container:**
docker-compose exec php-8.3-fpm php bin/phpunit


