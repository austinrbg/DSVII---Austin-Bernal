<?php

require 'vendor/autoload.php';

use App\User;
use Database\Models\ProductModel;

$user = new User();
echo "Usuario: " . $user->getName() . "\n";

$product = new ProductModel();
echo "ID del Producto: " . $product->getId() . "\n";

?>