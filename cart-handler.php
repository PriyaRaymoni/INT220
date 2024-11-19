<?php
include 'config.php';

if (isset($_POST['id']) && isset($_POST['add-To-Cart'])) {
    addToCart($_POST['id']);
    echo 'success';
}
?>