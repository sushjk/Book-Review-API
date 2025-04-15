Laravel Book Review API

A RESTful API built with Laravel 12 for managing books and user reviews. Supports admin/user roles, authentication via Laravel Sanctum, and features like book listing, filtering, pagination, and review system with rating and comments.

---
Features

- Sanctum Authentication (admin/user roles)
- Book Management (CRUD by admin)
- User Reviews (rating & comment per book)
- Average Rating Display
- Filter Books by Author & Genre
- Paginated Book Listings
- Edit/Delete Reviews (by owner only)

---

Installation Instructions

1. Clone the Repository

```bash
git clone https://github.com/your-username/book-review-api.git
cd book-review-api
```

2. Install Dependencies

```bash
composer install
```

3. Create `.env` File

Copy '.env.example' and configure your database credentials:

```bash
cp .env.example .env
```

4. Generate App Key

```bash
php artisan key:generate
```

5. Run Migrations

```bash
php artisan migrate
```

6. (Optional) Seed Admin/User Roles & Sample Data

```bash
php artisan db:seed
```

You can create an admin and a few users manually or through seeds.

7. Start the Server

```bash
php artisan serve
```

API will run at `http://127.0.0.1:8000`

---

Authentication

This app uses **Laravel Sanctum**. To get a token:

#Register

```bash
POST /api/register
{
  "name": "John",
  "email": "john@example.com",
  "password": "password",
  "role": "user" // or "admin"
}
```

#Login

```bash
POST /api/login
{
  "email": "john@example.com",
  "password": "password"
}
```

Response will include an `access_token`.

#Logout

```bash
POST /api/logout
Authorization: Bearer {access_token}
```

---

#API Overview

#Book Routes

| Method | Endpoint                 | Description             | Auth       |
|--------|--------------------------|-------------------------|------------|
| GET    | /api/books               | List + filter + paginate| Public     |
| GET    | /api/books/{id}          | Book details with reviews| Public    |
| POST   | /api/admin/books         | Create book             | Admin only |
| PUT    | /api/admin/books/{id}    | Update book             | Admin only |
| DELETE | /api/admin/books/{id}    | Delete book             | Admin only |

#Review Routes

| Method | Endpoint                     | Description             | Auth     |
|--------|------------------------------|-------------------------|----------|
| POST   | /api/books/{id}/reviews      | Add a review            | User     |
| PUT    | /api/reviews/{id}            | Edit user's own review  | User     |
| DELETE | /api/reviews/{id}            | Delete user's review    | User     |

---

#Postman Collection

(You can export and add a link to your Postman collection or instructions on how to test.)

---
