<?php
require 'vendor/autoload.php';
use Cake\Auth\DefaultPasswordHasher;

echo "Hashing password...\n";
$hasher = new DefaultPasswordHasher();
$hash = $hasher->hash('admin123');
echo "Hashed password: $hash\n";
