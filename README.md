# E-Commerce Project

## Project Overview

This is a full-stack e-commerce application built with **Laravel 11**. The project features two interfaces: an **admin side** and a **user side**. The user side accommodates both authenticated and non-authenticated users. The project can function as a complete full-stack application with views or can serve as an API for client-side use.

## Features

### Admin Side
Admins can:
- Perform **CRUD operations** on **categories**.
- Perform **CRUD operations** on **products**.

### User Side

#### Non-Authenticated Users
- **View products** and **categories** without restrictions.

#### Authenticated Users
Authenticated users have access to additional features:
- **Add to Cart**: Users can add products to their cart.
- **Edit/Delete from Cart**: Users can manage their cart items.
- **Add to Favourites**: Users can mark products as favourites.
- **Edit/Delete from Favourites**: Users can manage their favourite products.
- **Place Orders**: Users can proceed to checkout and place orders.

### APIs

The project includes API endpoints that mirror the functionality available in the front-end views. This allows the application to function both as a web app and as an API for other front-end frameworks or mobile apps.

## Technologies Used

- **Laravel 11**: Backend framework.
- **Jetstream**: For user authentication, including features like profile management, two-factor authentication, etc.
- **Blade**: Templating engine for the front-end views.
- **MySQL**: Database for storing application data.
- **API Controllers**: For API support and RESTful communication.

## Installation

To run this project locally, follow these steps:

1. **Clone the repository:**
    ```bash
    git clone https://github.com/aldriny/e-commerce.git
    cd e-commerce
    ```

2. **Install Dependencies:**
    ```bash
    composer install
    npm install
    ```

3. **Environment Setup:**
    - Copy the `.env.example` file to `.env` and configure your environment variables, particularly database credentials:
      ```bash
      cp .env.example .env
      ```
    - Generate the application key:
      ```bash
      php artisan key:generate
      ```

4. **Database Migration and Seeding:**
    Run migrations to create the database structure and seed it with some initial data (if necessary):
    ```bash
    php artisan migrate --seed
    ```

5. **Storage Linking:**
    To serve uploaded files (like product images), link the storage folder:
    ```bash
    php artisan storage:link
    ```

6. **Run the Development Server:**
    ```bash
    php artisan serve
    ```

## API Documentation

API routes are defined for interaction with both the admin and user sides of the application. You can use the API for operations such as managing products, viewing categories, and more.

To explore the available API endpoints, you can check the following:

- `routes/api.php`: Contains the routes for API endpoints.


## Admin Dashboard

To access the admin dashboard, you need to log in with an admin account. The admin panel provides access to the following features:

- **Manage Categories**: Create, update, delete, and view categories.
- **Manage Products**: Add, update, delete, and view products.


## Contributing

Contributions are welcome! If you encounter issues or have suggestions, feel free to open a pull request or submit an issue in the [Issues](https://github.com/aldriny/e-commerce/issues) tab.

---

