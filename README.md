# 🛒 Online Electronics Store

A comprehensive e-commerce platform built with Laravel 12 and Tailwind CSS, designed for selling electronic components like microcontrollers, sensors, and development boards.

## 🚀 Features

### User Features
- ✅ User registration/login with email verification
- ✅ Product browsing with categories and search
- ✅ Shopping cart management
- ✅ Cash on Delivery (COD) checkout
- ✅ Order history and tracking
- ✅ Order status updates (Pending → Processing → Shipped → Delivered)
- ✅ Email notifications for orders

### Admin Features
- ✅ Admin dashboard with overview
- ✅ Product management (CRUD)
- ✅ Category management
- ✅ Order management and status updates
- ✅ Admin-only access control

## 🛠 Tech Stack

- **Backend**: Laravel 12, PHP 8.1+
- **Frontend**: Blade Templates, Tailwind CSS
- **Database**: MySQL/SQLite
- **Authentication**: Laravel Breeze
- **Build Tool**: Vite
- **Styling**: Tailwind CSS with custom color palette

## 🎨 Design System

### Color Palette
- **Primary**: `#2C3E50` (Dark Blue-Gray)
- **Accent**: `#2980B9` (Blue)
- **Success**: `#27AE60` (Green)
- **Warning**: `#F39C12` (Orange)
- **Danger**: `#C0392B` (Red)
- **Background**: `#ECF0F1` (Light Gray)

## 📋 Requirements

- PHP 8.1 or higher
- Composer
- Node.js & NPM
- MySQL/SQLite
- Web server (Apache/Nginx or Laravel's built-in server)

## 🔧 Installation

1. **Install PHP dependencies**
   ```bash
   composer install
   ```

2. **Install Node.js dependencies**
   ```bash
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   - Update `.env` with your database credentials
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Build assets**
   ```bash
   npm run build
   # For development
   npm run dev
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

## 📊 Database Schema

### Core Tables
- **users** - User accounts with admin flag
- **categories** - Product categories
- **products** - Electronic products with pricing and stock
- **cart_items** - User shopping cart items
- **orders** - Customer orders with COD payment
- **order_items** - Individual items within orders

## 🗺 Application Routes

### Public Routes
- `/` - Product catalog homepage
- `/products/{product}` - Individual product details

### Authenticated User Routes
- `/cart` - Shopping cart management
- `/checkout` - Order placement
- `/orders` - Order history
- `/orders/{order}` - Order details
- `/profile` - User profile management

### Admin Routes (Protected)
- `/admin` - Admin dashboard
- `/admin/products` - Product management
- `/admin/categories` - Category management
- `/admin/orders` - Order management

## 👤 Default Admin Account

After running the seeders, you can log in as admin with:
- **Email**: admin@electronics.com
- **Password**: password

## 📦 Sample Data

The seeders will create:
- Categories: Microcontrollers, Sensors, Development Boards, Components
- Sample products with realistic pricing
- Admin user account

## 🔐 Security Features

- Password hashing using Laravel's built-in hashing
- Admin middleware protection
- Email verification for new users
- CSRF protection on forms
- SQL injection protection via Eloquent ORM

## 🎯 Usage

1. **For Customers**:
   - Register and verify email
   - Browse products by category
   - Add items to cart
   - Checkout with shipping details
   - Track order status

2. **For Admins**:
   - Login with admin credentials
   - Manage product catalog
   - Process and update orders
   - View dashboard analytics

## 🚀 Future Enhancements

- [ ] Online payment gateway integration
- [ ] Product reviews and ratings
- [ ] Inventory low-stock alerts
- [ ] Advanced search filters
- [ ] REST API for mobile apps
- [ ] Wishlist functionality
- [ ] Order export to CSV/PDF

## 📄 License

This project is open-source and available under the [MIT License](LICENSE).

---

**Built with ❤️ for electronics enthusiasts**
