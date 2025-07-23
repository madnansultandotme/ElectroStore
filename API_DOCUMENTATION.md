# Electronic Store API Documentation

This REST API provides endpoints for mobile applications to interact with the Electronic Store backend.

## Base URL
```
http://your-domain.com/api/v1
```

## Authentication
The API uses Laravel Sanctum for authentication. Include the bearer token in the Authorization header:
```
Authorization: Bearer {your-access-token}
```

## API Endpoints

### Authentication

#### Register User
- **POST** `/register`
- **Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```
- **Response:** User data with access token

#### Login
- **POST** `/login`
- **Body:**
```json
{
    "email": "john@example.com",
    "password": "password123"
}
```
- **Response:** User data with access token

#### Logout
- **POST** `/logout` (Requires authentication)
- **Response:** Success message

### User Profile

#### Get User Info
- **GET** `/user` (Requires authentication)
- **Response:** Current user data

#### Update Profile
- **PUT** `/profile` (Requires authentication)
- **Body:**
```json
{
    "name": "John Doe Updated",
    "email": "john.updated@example.com"
}
```

#### Update Password
- **PUT** `/password` (Requires authentication)
- **Body:**
```json
{
    "current_password": "oldpassword",
    "password": "newpassword",
    "password_confirmation": "newpassword"
}
```

### Products

#### Get All Products
- **GET** `/products`
- **Query Parameters:**
  - `search`: Search by name or description
  - `category_id`: Filter by category
  - `sort`: Sort by `price_low`, `price_high`, `rating`, or `newest`
  - `per_page`: Items per page (default: 15)

#### Get Product Details
- **GET** `/products/{product_id}`
- **Response:** Product details with reviews and ratings

#### Get Featured Products
- **GET** `/products/featured`
- **Response:** Top 10 featured products

#### Get Categories
- **GET** `/categories`
- **Response:** All product categories with product counts

### Shopping Cart (Requires authentication)

#### Get Cart Items
- **GET** `/cart`
- **Response:** Cart items with total price and item count

#### Add to Cart
- **POST** `/cart`
- **Body:**
```json
{
    "product_id": 1,
    "quantity": 2
}
```

#### Update Cart Item
- **PUT** `/cart/{cart_item_id}`
- **Body:**
```json
{
    "quantity": 3
}
```

#### Remove from Cart
- **DELETE** `/cart/{cart_item_id}`

#### Clear Cart
- **DELETE** `/cart`

### Orders (Requires authentication)

#### Get User Orders
- **GET** `/orders`
- **Response:** List of user's orders with items

#### Create Order
- **POST** `/orders`
- **Body:**
```json
{
    "address": "123 Main St, City, State 12345",
    "phone": "+1234567890"
}
```

#### Get Order Details
- **GET** `/orders/{order_id}`
- **Response:** Order details with items

### Reviews (Requires authentication)

#### Create Review
- **POST** `/reviews`
- **Body:**
```json
{
    "product_id": 1,
    "rating": 5,
    "comment": "Great product!"
}
```

#### Update Review
- **PUT** `/reviews/{review_id}`
- **Body:**
```json
{
    "rating": 4,
    "comment": "Updated review"
}
```

#### Delete Review
- **DELETE** `/reviews/{review_id}`

#### Get My Reviews
- **GET** `/reviews/my-reviews`
- **Response:** User's reviews

## Response Format

All API responses follow this format:

### Success Response
```json
{
    "success": true,
    "message": "Operation successful",
    "data": {
        // Response data
    }
}
```

### Error Response
```json
{
    "success": false,
    "message": "Error message",
    "errors": {
        // Validation errors (if applicable)
    }
}
```

## Status Codes
- `200`: Success
- `201`: Created
- `400`: Bad Request
- `401`: Unauthorized
- `403`: Forbidden
- `404`: Not Found
- `422`: Validation Error
- `500`: Server Error

## Features Included
- ✅ User authentication (register, login, logout)
- ✅ Product browsing with search and filtering
- ✅ Shopping cart management
- ✅ Order creation and tracking
- ✅ Product reviews and ratings
- ✅ User profile management
- ✅ Email notifications for order status changes
- ✅ Advanced inventory management
- ✅ Admin reports and analytics

## Example Usage (JavaScript)

```javascript
// Login
const loginResponse = await fetch('/api/v1/login', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        email: 'user@example.com',
        password: 'password'
    })
});

const { data } = await loginResponse.json();
const token = data.access_token;

// Get products with authentication
const productsResponse = await fetch('/api/v1/products', {
    headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json',
    }
});

const products = await productsResponse.json();
```

## Testing the API

You can test the API endpoints using tools like:
- Postman
- Insomnia
- cURL
- Thunder Client (VS Code extension)

Make sure to include the `Accept: application/json` header in all requests.
