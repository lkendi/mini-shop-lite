# MiniShop Lite

A simple, modern e-commerce application built with Laravel.

## Demo

Access the hosted site using [this link](https://mini-shop-lite-production.up.railway.app/)

Watch the demo video using [this link](https://drive.google.com/file/d/1zvAvicWbkPdMKdPsWSFZX6nP-HHPZuYp/view?usp=sharing)

## Features

-   **User Authentication:** Secure login, registration, and profile management for customers and admins.
-   **Role-Based Access:** Different experiences for guests, authenticated customers, and admins.
-   **Product Catalog:** Browse, search, and view product details.
-   **Shopping Cart:** Add, remove, update quantities, and clear items from your cart with real-time stock validation.
-   **Simulated Ordering:** Place orders without actual payment processing, including stock decrement.
-   **Customer Order History:** View past and current orders with detailed summaries.
-   **Admin Panel:** Management for products, customers, and orders.
-   **Responsive Design:** Optimized for various screen sizes.
-   **Theme Toggle:** Light and dark mode support.

## Technologies Used

-   **PHP:** ^8.3
-   **Laravel Framework:** ^11.31
-   **Laravel Breeze:** ^2.3
-   **Blade UI Kit (Heroicons):** ^2.6
-   **Blade UI Kit (Icons):** ^1.8
-   **Tailwind CSS:** ^3.1.0
-   **Vite:** ^6.0.11
-   **Blade:** (Included with Laravel)
-   **Eloquent:** (Included with Laravel)
-   **Composer:** (PHP Package Manager)
-   **NPM:** (Node.js Package Manager)

## Setup Steps

To setup the project on a local machine:

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/lkendi/mini-shop-lite.git
    cd mini-shop-lite
    ```

2.  **Install PHP Dependencies:**
    ```bash
    composer install
    ```

3.  **Install JavaScript Dependencies:**
    ```bash
    npm install
    ```

4.  **Environment Configuration:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    Edit the `.env` file and configure your database connection (e.g., `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

5.  **Run Database Migrations:**
    ```bash
    php artisan migrate
    ```

6.  **Seed the Database (Optional, but recommended for demo data):**
    ```bash
    php artisan db:seed
    ```
    This will create default admin and customer users (`admin@demo.com`/`password`, `customer@demo.com`/`password`), sample products, and sample orders.

7.  **Start Vite Development Server:**
    ```bash
    npm run dev
    ```

8.  **Serve the Application:**
    ```bash
    php artisan serve
    ```

    The application will typically be available at `http://127.0.0.1:8000`.

## Usage

-   **Admin Login:** `admin@demo.com` / `password`
-   **Customer Login:** `customer@demo.com` / `password`
- Feel free to register with custom credentials as well

Explore the product catalog, add items to your cart, and simulate the ordering process. As an admin, you can manage all aspects of the store from the admin dashboard.

--

Image Credits: [Pexels](https://www.pexels.com/)