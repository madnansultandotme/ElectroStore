# SSL Error Investigation & Fix Guide

## Root Cause Analysis

The "Invalid request (Unsupported SSL request)" errors occur when:

1. **Browser HTTPS Upgrades**: Modern browsers automatically upgrade HTTP to HTTPS
2. **HSTS Cache**: Browser has cached HTTPS-only instructions for localhost
3. **Chrome HTTPS-Only Mode**: Browser security features forcing HTTPS
4. **Cached Redirects**: Previous HTTPS redirects are cached

## Immediate Fixes

### 1. Clear Browser Data
**Chrome/Edge:**
1. Open `chrome://settings/clearBrowserData`
2. Select "All time"
3. Check "Cookies and other site data" and "Cached images and files"
4. Clear data

**Firefox:**
1. Open `about:preferences#privacy`
2. Click "Clear Data" under Cookies and Site Data
3. Check both options and clear

### 2. Disable HTTPS-Only Mode
**Chrome:**
1. Go to `chrome://flags/#https-only-mode-setting`
2. Set to "Disabled"
3. Restart Chrome

**Firefox:**
1. Go to `about:config`
2. Search for `dom.security.https_only_mode`
3. Set to `false`

### 3. Clear HSTS Settings
**Chrome:**
1. Go to `chrome://net-internals/#hsts`
2. In "Delete domain security policies", enter `localhost`
3. Click "Delete"

### 4. Use Incognito/Private Mode
- Open an incognito/private browsing window
- This bypasses cached HTTPS settings

## Application-Level Fixes (Applied)

### ✅ Environment Configuration
```env
APP_URL=http://localhost:8000
SESSION_SECURE_COOKIE=false
SESSION_DOMAIN=localhost
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax
```

### ✅ ForceHttp Middleware (Created)
- Prevents HTTPS enforcement in local development
- Removes HSTS headers
- Forces HTTP scheme

## Testing Steps

### 1. Start Clean Server
```bash
# Kill any existing PHP processes
Get-Process -Name php -ErrorAction SilentlyContinue | Stop-Process -Force

# Start fresh server
php artisan serve --host=127.0.0.1 --port=8000
```

### 2. Test with Different Methods

**A. Direct IP Access:**
```
http://127.0.0.1:8000
```

**B. Curl (PowerShell):**
```powershell
Invoke-WebRequest -Uri "http://127.0.0.1:8000" -Method GET
```

**C. Different Port:**
```bash
php artisan serve --host=127.0.0.1 --port=9000
```
Then test: `http://127.0.0.1:9000`

## Advanced Debugging

### Check What's Making SSL Requests
```powershell
# Monitor network connections
netstat -ano | findstr :8000

# Check if it's browser processes
Get-Process | Where-Object { $_.ProcessName -match "chrome|firefox|edge" }
```

### PHP Server Logs Analysis
The logs show:
```
127.0.0.1:51411 Invalid request (Unsupported SSL request)
```

This confirms something is trying HTTPS on the HTTP port 8000.

## Alternative Solutions

### 1. Use Different Port
```bash
php artisan serve --host=127.0.0.1 --port=9000
```

### 2. Use 127.0.0.1 Instead of localhost
```env
APP_URL=http://127.0.0.1:8000
```

### 3. Disable Browser Security (Temporary)
**Chrome:**
```bash
chrome.exe --disable-web-security --disable-features=VizDisplayCompositor --user-data-dir=C:\temp\chrome_dev
```

## Final Test Commands

```powershell
# 1. Clear everything
php artisan config:clear
php artisan route:clear
php artisan cache:clear

# 2. Start server on different IP/port
php artisan serve --host=127.0.0.1 --port=9000

# 3. Test with curl (no browser cache)
Invoke-WebRequest -Uri "http://127.0.0.1:9000/api/v1/products" -Headers @{"Accept"="application/json"}

# 4. Test web interface
Start-Process "http://127.0.0.1:9000"
```

## Prevention for Future

1. Always use `127.0.0.1` for local development
2. Use non-standard ports (9000, 3000, 5000)
3. Clear browser data regularly during development
4. Use different browser profiles for development

This should completely resolve the SSL request issues!
