# 🏢 Corporate Sites Management System

A comprehensive web-based management system built with Laravel for managing corporate projects, vendors, delivery specialists, and business operations.

## ✨ Features

### 📊 **Dashboard & Analytics**

- Real-time project statistics and KPIs
- Interactive charts and data visualizations
- Performance metrics and reporting

### 🎯 **Project Management**

- Complete project lifecycle management
- Task assignment and tracking
- Project status monitoring
- File attachments and documentation
- Milestone tracking and progress reports

### 👥 **Team Management**

- **Delivery Specialists (DS)** - Manage delivery team contacts and details
- **Vendors** - Comprehensive vendor information and account manager details
- **Project Managers (PMs)** - Team lead assignments and responsibilities
- **Account Managers (AMs)** - Client relationship management

### 📋 **Advanced Features**

- **Export Capabilities** - PDF, Excel, CSV export for all data tables
- **Print Functionality** - Professional printing layouts
- **File Management** - Secure file upload and storage system
- **User Permissions** - Role-based access control with Laravel Spatie
- **Responsive Design** - Mobile-friendly interface
- **Multi-language Support** - Arabic and English localization

### 🔧 **Technical Features**

- **DataTables Integration** - Advanced table sorting, filtering, and pagination
- **Modal Forms** - Smooth AJAX-powered forms for CRUD operations
- **Image Galleries** - Lightbox integration for project images
- **Drag & Drop** - File upload with drag and drop functionality
- **Real-time Validation** - Client and server-side form validation

## 🚀 Tech Stack

- **Backend**: Laravel 10.x PHP Framework
- **Frontend**: Bootstrap 4, jQuery, DataTables
- **Database**: MySQL
- **Authentication**: Laravel Sanctum
- **Permissions**: Spatie Laravel Permission
- **File Storage**: Laravel File System
- **Export Libraries**:
  - PDF: PDFMake
  - Excel: DataTables Excel Export
  - CSV: Native DataTables CSV

## 📦 Installation

### Prerequisites

- PHP 8.1 or higher
- Composer
- MySQL 5.7+ or MariaDB
- Node.js & NPM

### Setup Instructions

1. **Clone the repository**

   ```bash
   git clone https://github.com/mazensabry2712/Corporate-Sites-Management-System.git
   cd Corporate-Sites-Management-System
   ```

2. **Install PHP dependencies**

   ```bash
   composer install
   ```

3. **Install NPM dependencies**

   ```bash
   npm install
   npm run dev
   ```

4. **Environment Configuration**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database Setup**

   ```bash
   # Configure your database in .env file
   php artisan migrate
   php artisan db:seed
   ```

6. **Storage Link**

   ```bash
   php artisan storage:link
   ```

7. **Serve the application**

   ```bash
   php artisan serve
   ```

## 🔧 Configuration

### Database Configuration

Update your `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=corporate_sites_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### File Storage Configuration

The system supports multiple storage drivers. Configure in `config/filesystems.php`:

```php
'default' => env('FILESYSTEM_DISK', 'local'),
```

## 👤 Default User Credentials

After seeding the database, you can login with:

- **Email**: admin@example.com
- **Password**: password

## 📱 Screenshots

### Dashboard Overview

![Dashboard](public/assets/img/screenshots/dashboard.png)

### Project Management

![Projects](public/assets/img/screenshots/projects.png)

### Vendor Management

![Vendors](public/assets/img/screenshots/vendors.png)

## 🤝 Contributing

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

For support and questions:

- 📧 Email: mazensabry2712@gmail.com
- 🐛 Issues: [GitHub Issues](https://github.com/mazensabry2712/Corporate-Sites-Management-System/issues)

## 🎯 Roadmap

- [ ] API Integration for mobile apps
- [ ] Advanced reporting and analytics
- [ ] Email notifications system
- [ ] Calendar integration
- [ ] Real-time chat system
- [ ] Advanced file versioning

## 🙏 Acknowledgments

- Laravel Framework Team
- Bootstrap Team
- DataTables Contributors
- FontAwesome Icons
- All open source contributors

---

<div align="center">
  <h3>🌟 If you find this project helpful, please give it a star! 🌟</h3>
  
  [![GitHub stars](https://img.shields.io/github/stars/mazensabry2712/Corporate-Sites-Management-System.svg?style=social&label=Star)](https://github.com/mazensabry2712/Corporate-Sites-Management-System)
  [![GitHub forks](https://img.shields.io/github/forks/mazensabry2712/Corporate-Sites-Management-System.svg?style=social&label=Fork)](https://github.com/mazensabry2712/Corporate-Sites-Management-System/fork)
</div>
