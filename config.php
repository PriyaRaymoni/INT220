<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rollacaf_ecommerce";
// $servername = "localhost";
// $username = "rollacaf_Abhishek";
// $password = "Abhishek6649";
// $dbname = "rollacaf_ecommerce";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to execute a SELECT query and return the results
function select($query)
{
    global $conn;
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

// Function to execute an INSERT, UPDATE, or DELETE query
function execute($query)
{
    global $conn;
    if ($conn->query($query) === TRUE) {
        return true;
    } else {
        return "Error: " . $query . "<br>" . $conn->error;
    }
}

// auth
if (isset($_POST['login'])) {
    // check if user already logged in
    if (isset($_SESSION['user'])) {
        header('Location: index.php');
    }

    $email = $_POST['email'];
    $password = $_POST['password'];
    // Check if any of the fields are empty
    if (empty($email) || empty($password)) {
        echo "All fields are required";
        return;
    }

    // check if admin
    if ($email == 'admin' && $password == 'admin') {
        $_SESSION['user'] = ['name' => 'Admin', 'email' => 'admin'];
        header('Location: dashboard.php');
    }

    // Check if the user exists in the database and log them in
    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = select($query);
    if (count($result) == 1) {
        $_SESSION['user'] = ['name' => $result[0]['name'], 'email' => $result[0]['email']];
        header('Location: index.php');
    } else {
        echo "Invalid email or password";
    }
}
if (isset($_POST['signup'])) {
    // check if user already logged in
    if (isset($_SESSION['user'])) {
        header('Location: index.php');
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    // Check if any of the fields are empty
    if (empty($name) || empty($email) || empty($password)) {
        echo "All fields are required";
        return;
    }
    $query = "CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        password VARCHAR(100) NOT NULL
    )";
    $result = execute($query);
    // Check if the user already exists
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = select($query);
    if (count($result) > 0) {
        echo "User already exists";
        return;
    }

    // Insert the user into the database and log them in
    $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    $result = execute($query);
    if ($result === true) {
        $_SESSION['user'] = ['name' => $name, 'email' => $email];
        header('Location: index.php');
    } else {
        echo $result;
    }
}
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: auth.php');
}
function isLoggedIn()
{
    return isset($_SESSION['user']);
}

$searchItems = [];
function searchItem($name)
{
    if (empty($name)) {
        return [];
    }
    $query = 'SELECT * FROM products WHERE name LIKE "%' . $name . '%"';
    $searchItems = select($query);
    if (count($searchItems) > 0) {
        return $searchItems;
    } else {
        $searchItems = [];
        return [];
    }
}
// dashboard
if (isset($_POST['addProduct'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image = $_POST['image'];
    // Check if any of the fields are empty
    if (empty($name) || empty($price) || empty($category) || empty($image)) {
        echo "All fields are required";
        return;
    }

    // Insert the product into the database
    $table = "CREATE TABLE IF NOT EXISTS products (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        price FLOAT NOT NULL,
        category VARCHAR(30) NOT NULL,
        image VARCHAR(400) NOT NULL
    )";
    $result = execute($table);
    $query = "INSERT INTO products (name, price, category, image) VALUES ('$name', '$price', '$category', '$image')";
    $result = execute($query);
    if ($result === true) {
        header('Location: dashboard.php');
    } else {
        echo $result;
    }
}

if (isset($_POST['deleteProduct'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    // Check if any of the fields are empty
    if (empty($name) || empty($price) || empty($category)) {
        echo "All fields are required";
        return;
    }

    // Delete the product from the database
    $query = "DELETE FROM products WHERE name = '$name' AND price = '$price' AND category = '$category'";
    $result = execute($query);
    if ($result === true) {
        header('Location: dashboard.php');
    } else {
        echo $result;
    }
}

if (isset($_POST['updateProduct'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image = $_POST['image'];
    // Check if any of the fields are empty
    if (empty($name) || empty($price) || empty($category) || empty($image)) {
        echo "All fields are required";
        return;
    }

    // Update the product in the database
    $query = "UPDATE products SET price = '$price', category = '$category', image = '$image', name = '$name' WHERE name = '$name'";
    $result = execute($query);
    if ($result === true) {
        header('Location: dashboard.php');
    } else {
        echo $result;
    }
}

function listOrders() {
    $query = "SELECT * FROM orders";
    $result = select($query);
    if(count($result) > 0) {
        return $result;
    }
    else return [];
}
function cancelOrder($id) {
    $query = "
    DELETE FROM orders WHERE id = $id";
    $result = execute($query);
    return $result;
}

// home
function getProducts($x)
{
    $products = [];
    if ($x == "All") {
        $query = "SELECT * FROM products";
    } else {
        $query = "SELECT * FROM products WHERE category = '$x'";
    }
    $result = select($query);
    foreach ($result as $product) {
        $products[] = [
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => $product['price'],
            'category' => $product['category'],
            'image' => $product['image'],
        ];
    }
    return $products;
}

function getCategorys()
{
    $categorys = [];
    $query = "SELECT DISTINCT category FROM products";
    $result = select($query);
    foreach ($result as $category) {
        $categorys[] = $category['category'];
    }
    return $categorys;
}

function addToCart($id)
{
    // Check if the cart session variable is set, if not, initialize it as an empty array
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Create an array to store the IDs of items currently in the cart
    $ids = [];
    foreach ($_SESSION['cart'] as $cartId) {
        $ids[] = $cartId['id'];
    }

    // If the item ID is not already in the cart, add it to the cart
    if (!in_array($id, $ids)) {
        $_SESSION['cart'][] = ['id' => $id, 'quantity' => 1];
    }
}

function getCart()
{
    $cart = [];
    if (!isset($_SESSION['cart'])) {
        return $cart;
    }
    foreach ($_SESSION['cart'] as $x) {
        $id = $x['id'];
        $query = "SELECT * FROM products WHERE id = $id";
        $result = select($query);
        if (count($result) == 1) {
            $cart[] = [
                'id' => $result[0]['id'],
                'name' => $result[0]['name'],
                'price' => $result[0]['price'],
                'category' => $result[0]['category'],
                'image' => $result[0]['image'],
                'quantity' => $x['quantity'],
            ];
        }
    }
    return $cart;
}

function getCartTotal()
{
    $total = 0;
    $cart = getCart();
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}
if(isset(($_POST['total-cart-value']))) {
    $total = getCartTotal();
    echo $total;
}

function removeFromCart($id)
{
    if (!isset($_SESSION['cart'])) {
        return;
    }
    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value['id'] == $id) {
            unset($_SESSION['cart'][$key]);
        }
    }
}

function incrementItem($id)
{
    if (!isset($_SESSION['cart'])) {
        return;
    }
    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value['id'] == $id) {
            $_SESSION['cart'][$key]['quantity']++;
        }
    }
}
if (isset($_POST['increment-From-Cart'])) {
    incrementItem($_POST['id']);
}
function decrementItem($id)
{
    if (!isset($_SESSION['cart'])) {
        return;
    }
    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value['id'] == $id) {
            $_SESSION['cart'][$key]['quantity']--;
            if ($_SESSION['cart'][$key]['quantity'] == 0) {
                unset($_SESSION['cart'][$key]);
            }
        }
    }
}
if (isset($_POST['decrement-From-Cart'])) {
    decrementItem($_POST['id']);
}

?>