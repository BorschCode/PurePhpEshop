# Pure PHP 8.4 E-Commerce Catalog

A modern, framework-free e-commerce catalog built with pure PHP 8.4, featuring strict typing, PSR-4 autoloading, and Docker containerization.

## 🚀 Features

### Core Requirements
- **No CMS or Frameworks** - Pure PHP implementation
- **Multiple Categories** - Products can belong to multiple categories
- **Image Sizes** - Auto-generates 110x110, 250x250, 450x450 images
- **SEO Ready** - Microformat breadcrumbs and meta tags
- **Admin Panel** - Complete category and product management
- **Custom Routing** - `/alias/c<id>` for categories, `/alias/p<id>` for products

### Modern PHP 8.4
- Strict typing with `declare(strict_types=1)`
- PSR-4 autoloading
- Typed properties and return types
- Modern OOP architecture
- Docker containerization

## 🐳 Quick Start with Docker

```bash
# Clone and start
git clone <repository>
cd purePhpMarket-new

# Start containers
./docker-start.sh
# or
docker-compose up --build
```

**Access:**
- Web: http://localhost:8080
- Admin: http://localhost:8080/admin
- Database: localhost:3306

**Admin Login:**
- Email: test@test.com
- Password: 222222

## 📁 Project Structure

```
├── controllers/     # MVC Controllers
├── models/         # Data Models
├── views/          # View Templates
├── function/       # Core Functions (Router, DB, etc.)
├── config/         # Configuration Files
├── assets/         # CSS, JS, Images
├── upload/         # Product Images
└── catalog.sql     # Database Schema
```

## ⚙️ Configuration

### Environment Variables (.env)
```env
WEB_PORT=8080
DB_PORT=3306
DB_HOST=db
DB_NAME=catalog
DB_USER=webuser
DB_PASSWORD=123
```

### Database Setup
The database is automatically initialized with sample data when using Docker.

## 🛠️ Development

### Live Development
With Docker volumes mounted, all code changes are reflected immediately without rebuilding:

```bash
# Edit files locally - changes appear instantly
# Only restart when needed:
docker-compose restart web
```

### Manual Setup (without Docker)
1. PHP 8.4+ with PDO MySQL extension
2. Apache with mod_rewrite
3. MySQL/MariaDB
4. Import `catalog.sql`
5. Configure `config/db_params.php`

## 📋 Key Features

### Product Management
- Multiple category assignment
- Automatic image resizing
- Regular and promotional pricing
- Stock management
- Brand categorization

### Image Processing
- Upload single image
- Auto-generates three sizes
- Optimized for web display
- Handled by `simpleImage.php` class

### Routing System
- Custom router in `function/router.php`
- Routes defined in `config/routes.php`
- SEO-friendly URLs
- Breadcrumb generation

### Admin Features
- Category CRUD operations
- Product CRUD operations
- Image upload management
- Order management
- User role management

## 🔧 Technical Details

### Autoloading
```php
// PSR-4 autoloading via Composer
"autoload": {
    "psr-4": {
        "App\\Models\\": "models/",
        "App\\Controllers\\": "controllers/",
        "App\\Functions\\": "function/"
    }
}
```

### Database Connection
```php
// Automatic Docker/local environment detection
$paramsPath = file_exists(ROOT . '/config/db_params_docker.php') && getenv('DB_HOST') 
    ? ROOT . '/config/db_params_docker.php'
    : ROOT . '/config/db_params.php';
```

## 📊 Database Schema

- `category` - Product categories
- `products` - Product catalog
- `user` - User accounts
- `product_order` - Order management

## 🎯 Usage Examples

### Adding Products
1. Access `/admin`
2. Navigate to Products
3. Click "Add Product"
4. Upload image (auto-resizes)
5. Assign to multiple categories

### Custom Routing
```php
// config/routes.php
'^alias/c([0-9]+)$' => 'catalog/category/$1',
'^alias/p([0-9]+)$' => 'product/view/$1',
```

## 🚀 Performance

- Optimized autoloader
- Minimal dependencies
- Efficient image processing
- Clean database queries
- Docker optimization

## 📝 License

MIT License - Feel free to use for learning and commercial projects.

## 🤝 Contributing

Contributions welcome! Please ensure:
- PHP 8.4 compatibility
- Strict typing
- PSR-4 compliance
- Docker testing