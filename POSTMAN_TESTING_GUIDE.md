# Postman Testing Guide for Electronic Store API

This guide provides step-by-step instructions for testing the Electronic Store API using Postman.

## Setup

1. **Base URL**: Set your base URL as an environment variable in Postman:
   - Variable name: `base_url`
   - Value: `http://localhost:8000/api/v1` (adjust port as needed)

2. **Authorization Token**: After login, save the access token:
   - Variable name: `access_token`
   - Value: The token received from login response

## Test Sequence

### 1. User Registration
- **Method**: POST
- **URL**: `{{base_url}}/register`
- **Headers**: 
  ```
  Content-Type: application/json
  Accept: application/json
  ```
- **Body** (raw JSON):
  ```json
  {
      "name": "Test User",
      "email": "test@example.com",
      "password": "password123",
      "password_confirmation": "password123"
  }
  ```
- **Expected Response**: 201 with user data and access_token

### 2. User Login
- **Method**: POST
- **URL**: `{{base_url}}/login`
- **Headers**: 
  ```
  Content-Type: application/json
  Accept: application/json
  ```
- **Body** (raw JSON):
  ```json
  {
      "email": "test@example.com",
      "password": "password123"
  }
  ```
- **Expected Response**: 200 with user data and access_token
- **Post-response Script**: Save the token
  ```javascript
  if (pm.response.code === 200) {
      const response = pm.response.json();
      pm.environment.set("access_token", response.data.access_token);
  }
  ```

### 3. Get Products (Public)
- **Method**: GET
- **URL**: `{{base_url}}/products`
- **Headers**: 
  ```
  Accept: application/json
  ```
- **Expected Response**: 200 with products list

### 4. Get User Profile (Protected)
- **Method**: GET
- **URL**: `{{base_url}}/user`
- **Headers**: 
  ```
  Accept: application/json
  Authorization: Bearer {{access_token}}
  ```
- **Expected Response**: 200 with user data

### 5. Add Product to Cart
- **Method**: POST
- **URL**: `{{base_url}}/cart`
- **Headers**: 
  ```
  Content-Type: application/json
  Accept: application/json
  Authorization: Bearer {{access_token}}
  ```
- **Body** (raw JSON):
  ```json
  {
      "product_id": 1,
      "quantity": 2
  }
  ```
- **Expected Response**: 201 with cart item data

### 6. View Cart
- **Method**: GET
- **URL**: `{{base_url}}/cart`
- **Headers**: 
  ```
  Accept: application/json
  Authorization: Bearer {{access_token}}
  ```
- **Expected Response**: 200 with cart items and totals

### 7. Create Order
- **Method**: POST
- **URL**: `{{base_url}}/orders`
- **Headers**: 
  ```
  Content-Type: application/json
  Accept: application/json
  Authorization: Bearer {{access_token}}
  ```
- **Body** (raw JSON):
  ```json
  {
      "address": "123 Main St, City, State 12345",
      "phone": "+1234567890"
  }
  ```
- **Expected Response**: 201 with order data

### 8. View Orders
- **Method**: GET
- **URL**: `{{base_url}}/orders`
- **Headers**: 
  ```
  Accept: application/json
  Authorization: Bearer {{access_token}}
  ```
- **Expected Response**: 200 with orders list

### 9. Create Review
- **Method**: POST
- **URL**: `{{base_url}}/reviews`
- **Headers**: 
  ```
  Content-Type: application/json
  Accept: application/json
  Authorization: Bearer {{access_token}}
  ```
- **Body** (raw JSON):
  ```json
  {
      "product_id": 1,
      "rating": 5,
      "comment": "Great product!"
  }
  ```
- **Expected Response**: 201 with review data

### 10. Get My Reviews
- **Method**: GET
- **URL**: `{{base_url}}/reviews/my-reviews`
- **Headers**: 
  ```
  Accept: application/json
  Authorization: Bearer {{access_token}}
  ```
- **Expected Response**: 200 with user's reviews

### 11. Logout
- **Method**: POST
- **URL**: `{{base_url}}/logout`
- **Headers**: 
  ```
  Accept: application/json
  Authorization: Bearer {{access_token}}
  ```
- **Expected Response**: 200 with success message

## Error Testing

### Test Invalid Login
- **Method**: POST
- **URL**: `{{base_url}}/login`
- **Body**: Invalid credentials
- **Expected Response**: 401 Unauthorized

### Test Protected Route Without Token
- **Method**: GET
- **URL**: `{{base_url}}/user`
- **Headers**: No Authorization header
- **Expected Response**: 401 Unauthorized

### Test Adding Non-existent Product to Cart
- **Method**: POST
- **URL**: `{{base_url}}/cart`
- **Body**: 
  ```json
  {
      "product_id": 99999,
      "quantity": 1
  }
  ```
- **Expected Response**: 422 Validation Error

## Environment Variables Setup

Create a Postman environment with these variables:

```
base_url: http://localhost:8000/api/v1
access_token: (will be set automatically after login)
```

## Tips

1. **Start Laravel Server**: Make sure your Laravel development server is running:
   ```bash
   php artisan serve
   ```

2. **Database Setup**: Ensure your database is migrated and seeded with sample data:
   ```bash
   php artisan migrate --seed
   ```

3. **Queue Worker**: For email notifications, run the queue worker:
   ```bash
   php artisan queue:work
   ```

4. **Check Logs**: Monitor Laravel logs for any errors:
   ```bash
   tail -f storage/logs/laravel.log
   ```

## Expected Status Codes
- 200: Success
- 201: Created
- 400: Bad Request
- 401: Unauthorized
- 403: Forbidden
- 404: Not Found
- 422: Validation Error

This testing sequence will verify all major API functionalities including authentication, cart management, order processing, and review system.
