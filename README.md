# Product Management Web Application

## Overview
This is a simple web application for managing products, built with Laravel for the backend and HTML, CSS, and JavaScript for the frontend. The application provides the following functionalities:

- Create a product
- Edit a product
- View a product
- Delete a product
- List products with pagination *(Pagination was added for learning purposes)*  

## Technologies Used
- **Backend:** Laravel
- **Frontend:** HTML, CSS, JavaScript
- **Database:** MySQL
- **API Testing:** Postman *(Postman collection file: **ProductAPI.postman_collection.json**)*

## Installation

### Prerequisites
Ensure you have the following installed:
- PHP (>= 8.0)
- Composer
- Laravel
- MySQL

### Backend Setup
1. Clone the repository:
   ```bash
   git clone https://github.com/PHPDev0101/ProductManagement.git
   cd ProductManagement
   ```
2. Install dependencies:
   ```bash
   composer install
   ```
3. Create the `.env` file:
   ```bash
   cp .env.example .env
   ```
4. Configure the `.env` file with your database settings:
   ```ini
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_db_user
   DB_PASSWORD=your_db_password
   ```
5. Generate application key:
   ```bash
   php artisan key:generate
   ```
6. Run migrations:
   ```bash
   php artisan migrate
   ```
7. Start the development server:
   ```bash
   php artisan serve
   ```

### Frontend Setup
1. Ensure your API is running (`php artisan serve`)
2. Access http://127.0.0.1:8000/index.html in a browser to start interacting with the application.

## API Routes

| Method | Endpoint               | Description            |
|--------|------------------------|------------------------|
| GET    | `/api/products`        | Get all products       |
| GET    | `/api/products/{id}`   | Get a specific product |
| POST   | `/api/products`        | Create a new product   |
| PUT    | `/api/products/{id}`   | Update a product       |
| DELETE | `/api/products/{id}`   | Delete a product       |
