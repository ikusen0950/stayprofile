# Islanders Finolhu - Myth Auth Integration

This CodeIgniter 4 application has been successfully integrated with Myth Auth for user authentication and authorization.

## What's Included

✅ **Myth Auth Package** - Installed via Composer  
✅ **Database Tables** - User authentication tables created  
✅ **Configuration Files** - Auth config, filters, and routes set up  
✅ **Sample Views** - Login, registration, and dashboard pages  
✅ **Protected Routes** - Example of protected dashboard route  
✅ **Helper Functions** - Access to `logged_in()`, `user()`, etc.  

## Available Routes

- **Home Page**: `/` - Shows welcome page with auth links
- **Login**: `/auth/login` - User login form  
- **Register**: `/auth/register` - User registration form  
- **Logout**: `/auth/logout` - Logout and redirect  
- **Dashboard**: `/dashboard` - Protected page (requires login)  
- **Forgot Password**: `/auth/forgot` - Password reset request  
- **Reset Password**: `/auth/reset/{token}` - Password reset form  

## Quick Start

1. **Start the Development Server**:
   ```bash
   php spark serve --port 8080
   ```

2. **Visit the Application**:
   - Open http://localhost:8080 in your browser
   - Click "Register" to create a new account
   - Login with your credentials
   - Try accessing the protected dashboard

## Database Configuration

The application is configured to use:
- **Database**: `aislanderapp`
- **Host**: `localhost`
- **Username**: `root`
- **Password**: (empty)
- **Port**: `3306`

Make sure your MySQL/MariaDB server is running with these settings.

## Authentication Tables Created

- `users` - User accounts and profile information
- `auth_logins` - Login attempt tracking
- `auth_tokens` - Password reset and activation tokens
- `auth_users_permissions` - User-specific permissions
- `auth_groups` - User groups/roles
- `auth_groups_permissions` - Group permissions
- `auth_groups_users` - User-group relationships
- `auth_permissions` - Available permissions

## Helper Functions Available

- `logged_in()` - Check if user is logged in
- `user()` - Get current user object
- `user_id()` - Get current user ID
- `in_groups($groups, $user_id = null)` - Check if user is in specific groups
- `has_permission($permission, $user_id = null)` - Check user permissions

## Configuration Files

- `app/Config/Auth.php` - Main auth configuration
- `app/Config/Filters.php` - Authentication filters
- `app/Config/Routes.php` - Auth routes
- `app/Config/Services.php` - Auth services

## Example Usage in Controllers

```php
<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        // This route is protected by 'login' filter
        $data = [
            'user' => user(),
            'title' => 'Dashboard'
        ];
        
        return view('dashboard', $data);
    }
}
```

## Protecting Routes

Add the `login` filter to routes that require authentication:

```php
$routes->get('admin', 'Admin::index', ['filter' => 'login']);
$routes->group('api', ['filter' => 'login'], function($routes) {
    $routes->get('users', 'Api::users');
});
```

## Next Steps

1. Customize the auth views in `app/Views/Auth/`
2. Configure email settings for password reset functionality
3. Set up user groups and permissions as needed
4. Customize the user registration fields
5. Add additional user profile fields

## Troubleshooting

- If you see database connection errors, check your `.env` file settings
- If auth views look unstyled, you can customize them in `app/Views/Auth/`
- For production, make sure to set `CI_ENVIRONMENT = production` in `.env`

## Documentation

- [Myth Auth Documentation](https://github.com/lonnieezell/myth-auth)
- [CodeIgniter 4 User Guide](https://codeigniter.com/user_guide/)