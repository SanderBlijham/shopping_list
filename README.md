## Shopping List API
This project provides a RESTful API for managing shopping lists. You can create shopping lists, add or remove products, and update product quantities.


1. Install Dependencies
Install the project dependencies using Composer:

```bash
composer install
```

2. Open the .env file and set up your database connection:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

4. Run Migrations
Run the migrations to create the necessary database tables:

```bash
php artisan migrate
```

5. Seed the Database 
If you want to seed the database with sample data, run:

```bash
php artisan db:seed
```

6. Start the Development Server
Start the Laravel development server:
```
php artisan serve
```
The application will be available at http://localhost:8000.

## API Endpoints
Create a Shopping List.

Endpoint: 

```bash
POST /api/shopping-lists
```

Add a Product to a Shopping List
```bash
POST /api/shopping-lists/{id}/add-product

{
  "product_catalog_id": 1,
  "quantity": 1
}
```

Change quantity of a Product on a Shopping List
```bash
POST /api/shopping-lists/{id}/change-product-quantity

{
  "product_catalog_id": 1,
  "quantity": 1
}
```

Remove a Product from a Shopping List.
```bash
POST /api/shopping-lists/{id}/remove-product

{
  "product_catalog_id": 1
}
```

Retrieve a Single Shopping List with groceries.

```bash
GET /api/shopping-lists/{id}
```

# Testing
To run the tests, use:
```bash
php artisan test
```