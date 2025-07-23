<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

// Check if admin user already exists
$existingAdmin = User::where('email', 'admin@example.com')->first();

if ($existingAdmin) {
    $existingAdmin->is_admin = true;
    $existingAdmin->save();
    echo "Updated existing user to admin: admin@example.com\n";
} else {
    // Create new admin user
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
        'is_admin' => true,
    ]);
    
    echo "Admin user created successfully!\n";
    echo "Email: admin@example.com\n";
    echo "Password: password\n";
    echo "Please change the password after first login.\n";
}
