# Production Bundle Management System
## Apparel Manufacturing ERP

A full-featured Production Bundle Management module built with **Laravel 12**, **MySQL 8**, **Bootstrap 5**, and **AJAX**. Includes REST APIs, dashboard analytics, Excel/CSV export, print slips, activity logging, and Sanctum authentication.

---

## 📋 Features

### Core Features
- **CRUD Operations** — Create, Read, Update, Delete (soft delete) production bundles
- **AJAX Form Submission** — Save/update without page refresh
- **Real-Time Calculations** — Balance Qty, Efficiency %, Rejection % calculated in real time
- **Client + Server Validation** — All business rules enforced both sides
- **Dependent Dropdowns** — Style dropdown loads based on selected Buyer via AJAX
- **Dashboard** — Summary cards, 7-day trend chart, top buyers by efficiency

### Search, Filter, Sort & Pagination
- **Search**: Bundle No, Buyer, Style, Operator, Color
- **Filters**: Buyer, Style, Sewing Line, Date From/To
- **Sortable Columns**: Bundle No, Buyer, Style, Quantity, Efficiency, Production Date
- **Server-Side Pagination**: 20, 50, 100 records per page

### Bonus Features
- **Export to Excel/CSV** (Maatwebsite/Excel)
- **Print Bundle Slip** — Print-optimized layout with signature lines
- **Activity Log** (Spatie Activity Log) — Tracks all bundle CRUD operations
- **JWT/Sanctum Authentication** — Web session auth + API token auth
- **Performance Optimized** — DB indexes, eager loading, query scopes

### REST APIs
| Method | Endpoint | Description |
|--------|----------|-------------|
| `POST` | `/api/v1/login` | Get auth token |
| `POST` | `/api/v1/logout` | Revoke token |
| `GET` | `/api/v1/me` | Current user info |
| `GET` | `/api/v1/bundles` | List bundles (paginated, filterable) |
| `POST` | `/api/v1/bundles` | Create bundle |
| `GET` | `/api/v1/bundles/{id}` | Get bundle details |
| `PUT` | `/api/v1/bundles/{id}` | Update bundle |
| `DELETE` | `/api/v1/bundles/{id}` | Soft delete bundle |
| `GET` | `/api/v1/dashboard` | Dashboard summary stats |

---

## 🚀 Setup Instructions

### Prerequisites
- PHP 8.2+
- Composer 2.x
- MySQL 8.0
- Node.js & NPM (for Breeze frontend assets)

### Step 1: Clone the repository
```bash
git clone <repository-url>
cd bundle-erp
```

### Step 2: Install PHP dependencies
```bash
composer install
```

### Step 3: Configure environment
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and set your MySQL credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bundle_erp
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Step 4: Create the database
```sql
CREATE DATABASE IF NOT EXISTS bundle_erp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Or import the provided SQL dump:
```bash
mysql -u root -p bundle_erp < database/dump.sql
```

### Step 5: Run migrations & seed
```bash
php artisan migrate --seed
```

This creates:
- 1 Admin user: `admin@bundle-erp.com` / `password`
- 10 Buyers, 100 Styles, 8 Sewing Lines
- 1,000 sample production bundles

### Step 6: Build frontend assets
```bash
npm install
npm run build
```

### Step 7: Start the server
```bash
php artisan serve
```

Visit: **http://localhost:8000**

### Login Credentials
| Email | Password |
|-------|----------|
| `admin@bundle-erp.com` | `password` |

---

## 📊 Business Rules

1. Bundle Number must be unique
2. Quantity must be greater than zero
3. Completed Quantity ≤ Quantity
4. Rejected Quantity ≤ Quantity
5. Completed + Rejected ≤ Quantity
6. Production Date cannot be a future date

### Real-Time Calculations
```
Balance Quantity = Quantity − Completed − Rejected
Efficiency %    = (Completed / Quantity) × 100
Rejection %     = (Rejected / Quantity) × 100
```

---

## 🗂 Project Structure

```
bundle-erp/
├── app/
│   ├── Exports/BundlesExport.php          # Excel/CSV export
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── AuthController.php     # API auth (Sanctum)
│   │   │   │   ├── BundleController.php   # API CRUD
│   │   │   │   └── DashboardController.php
│   │   │   ├── DashboardController.php    # Web dashboard
│   │   │   └── ProductionBundleController.php  # Web CRUD
│   │   └── Requests/
│   │       ├── StoreBundleRequest.php     # Create validation
│   │       └── UpdateBundleRequest.php    # Update validation
│   └── Models/
│       ├── Buyer.php
│       ├── ProductionBundle.php           # Soft deletes, scopes, accessors
│       ├── SewingLine.php
│       └── Style.php
├── database/
│   ├── migrations/                        # All table migrations
│   ├── seeders/                           # Sample data seeders
│   └── dump.sql                           # Full database dump
├── resources/views/
│   ├── auth/login.blade.php              # Custom login page
│   ├── bundles/
│   │   ├── index.blade.php               # Listing with search/filter/sort
│   │   ├── create.blade.php              # Entry form with real-time calc
│   │   ├── edit.blade.php                # Edit form
│   │   ├── show.blade.php                # Bundle detail view
│   │   └── print.blade.php              # Print-optimized slip
│   ├── dashboard/index.blade.php         # Dashboard with Chart.js
│   └── layouts/app.blade.php             # Main layout (sidebar)
├── routes/
│   ├── api.php                           # REST API routes
│   ├── auth.php                          # Auth routes (Breeze)
│   └── web.php                           # Web routes
├── postman_collection.json               # Postman API collection
└── README.md
```

---

## 📦 Database Schema

### Buyers
| Column | Type |
|--------|------|
| id | bigint (PK) |
| buyer_name | varchar(150) UNIQUE |

### Styles
| Column | Type |
|--------|------|
| id | bigint (PK) |
| buyer_id | bigint (FK → buyers) |
| style_no | varchar(100) |

### Sewing Lines
| Column | Type |
|--------|------|
| id | bigint (PK) |
| line_name | varchar(100) UNIQUE |

### Production Bundles
| Column | Type |
|--------|------|
| id | bigint (PK) |
| bundle_no | varchar(50) UNIQUE |
| buyer_id | bigint (FK) |
| style_id | bigint (FK) |
| color | varchar(100) |
| size | varchar(50) |
| line_id | bigint (FK) |
| quantity | int unsigned |
| completed_qty | int unsigned |
| rejected_qty | int unsigned |
| operator_name | varchar(150) |
| production_date | date |
| remarks | text |
| deleted_at | timestamp (soft delete) |
| created_at | timestamp |
| updated_at | timestamp |

### Indexes
- `bundle_no` (unique)
- `buyer_id`, `style_id`, `line_id` (FK indexes)
- `production_date`, `operator_name`, `color`
- Composite: `(buyer_id, style_id, production_date)`

---

## 🧪 API Testing (Postman)

Import `postman_collection.json` into Postman.

### Authentication Flow
1. **POST** `/api/v1/login` with `email` + `password`
2. Copy the returned `token`
3. Set header: `Authorization: Bearer <token>`
4. Use the token for all subsequent requests

### API Query Parameters
```
GET /api/v1/bundles?search=BND-001&buyer_id=1&date_from=2025-01-01&sort=quantity&direction=desc&per_page=50
```

---

## 📝 Performance Notes

- Database indexes cover all search, filter, and sort columns
- Eager loading (`with()`) used on all relationship queries
- Query scopes avoid N+1 issues
- Pagination on server side (not client-loaded)
- Tested with 1,000+ records; designed to support 50,000+

---

## License
MIT
