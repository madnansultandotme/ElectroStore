# Troubleshooting Guide

## SSL Errors in Local Development

If you're experiencing SSL/TLS errors, here are the solutions:

### 1. Environment Configuration
The `.env` file has been configured with:
```
APP_URL=http://localhost:8000
SSL_VERIFY_HOST=false
SSL_VERIFY_PEER=false
SANCTUM_STATEFUL_DOMAINS=localhost,localhost:8000,127.0.0.1,127.0.0.1:8000
```

### 2. Starting the Application
1. **Start the server:**
   ```bash
   php artisan serve --host=0.0.0.0 --port=8000
   ```

2. **Access the application:**
   - Web Interface: `http://localhost:8000`
   - API Endpoints: `http://localhost:8000/api/v1/`

### 3. Common SSL Issues and Fixes

#### Issue: "SSL certificate problem: unable to get local issuer certificate"
**Solution:**
1. Update `.env` with SSL bypass settings (already done)
2. For Windows with XAMPP, update `php.ini`:
   ```ini
   curl.cainfo = "C:\xampp\apache\bin\curl-ca-bundle.crt"
   openssl.cafile = "C:\xampp\apache\bin\curl-ca-bundle.crt"
   ```

#### Issue: "SSL: certificate subject name does not match target host name"
**Solution:**
- Use HTTP instead of HTTPS for local development
- Set `APP_URL=http://localhost:8000` (already configured)

#### Issue: Email notifications not working
**Solution:**
1. **For testing:** Use log driver (configured in `.env`)
   ```
   MAIL_MAILER=log
   ```
   Check logs in `storage/logs/laravel.log`

2. **For production:** Configure real SMTP settings:
   ```
   MAIL_MAILER=smtp
   MAIL_HOST=your-smtp-host
   MAIL_PORT=587
   MAIL_USERNAME=your-email@domain.com
   MAIL_PASSWORD=your-password
   MAIL_ENCRYPTION=tls
   ```

### 4. Database Issues

#### Issue: Database not found
**Solution:**
```bash
# Create database file
New-Item -ItemType File -Path "database\database.sqlite" -Force

# Run migrations
php artisan migrate:fresh --seed
```

### 5. Testing the Application

#### Test Web Interface:
- Navigate to: `http://localhost:8000`
- Admin login: Use the seeded admin user

#### Test API Endpoints:
Using PowerShell:
```powershell
# Test public endpoint
Invoke-WebRequest -Uri "http://localhost:8000/api/v1/products" -Headers @{"Accept"="application/json"}

# Register new user
$body = @{
    name = "Test User"
    email = "test@example.com"
    password = "password123"
    password_confirmation = "password123"
} | ConvertTo-Json

Invoke-WebRequest -Uri "http://localhost:8000/api/v1/register" -Method POST -Headers @{"Content-Type"="application/json"; "Accept"="application/json"} -Body $body
```

### 6. Background Jobs (Email Queue)

For email notifications to work properly, run the queue worker:
```bash
php artisan queue:work
```

### 7. Clearing Caches

If you encounter issues after configuration changes:
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### 8. Logs and Debugging

Check application logs for detailed error information:
```bash
tail -f storage/logs/laravel.log
```

## Features Ready to Use

### ✅ Working Features:
1. **Product Reviews and Ratings** - Fully functional
2. **Email Notifications** - Configured (check logs for local testing)
3. **Advanced Inventory Management** - Ready
4. **REST API for Mobile Apps** - Fully implemented
5. **Admin Reports and Analytics** - Available

### 🔗 Important URLs:
- **Web App:** http://localhost:8000
- **API Base:** http://localhost:8000/api/v1
- **Admin Panel:** http://localhost:8000/admin (requires admin login)

## Next Steps
1. Test the web interface at `http://localhost:8000`
2. Test API endpoints using Postman or the provided guide
3. Configure real SMTP settings for production email notifications
4. Customize the frontend UI as needed

The application is now fully functional with all requested features implemented!
