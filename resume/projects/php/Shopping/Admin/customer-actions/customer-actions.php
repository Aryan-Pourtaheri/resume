<?php
include('../config/connection.php');

$response = ['success' => false, 'message' => 'Invalid request'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_customer_id'])) {
        // Delete customer
        $delete_customer_id = $_POST['delete_customer_id'];

        // Fetch the user_id linked to the customer
        $user_query = "SELECT user_id FROM customers WHERE id = $delete_customer_id";
        $user_result = $conn->query($user_query);
        $user = $user_result->fetch_assoc();
        $user_id = $user['user_id'];

        // Delete the customer
        $delete_customer_query = "DELETE FROM customers WHERE id = $delete_customer_id";
        $conn->query($delete_customer_query);

        // Delete the user
        $delete_user_query = "DELETE FROM users WHERE id = $user_id";
        $conn->query($delete_user_query);

        $response = ['success' => true, 'message' => 'Customer deleted successfully'];
    } elseif (isset($_POST['customer_id']) && !empty($_POST['customer_id'])) {
        // Update customer
        $customer_id = $_POST['customer_id'];
        $first_name = $conn->real_escape_string($_POST['first_name']);
        $last_name = $conn->real_escape_string($_POST['last_name']);
        $email = $conn->real_escape_string($_POST['email']);
        $phone = $conn->real_escape_string($_POST['phone']);
        $city = $conn->real_escape_string($_POST['city']);

        // Fetch the user_id linked to the customer
        $user_query = "SELECT user_id FROM customers WHERE id = $customer_id";
        $user_result = $conn->query($user_query);
        $user = $user_result->fetch_assoc();
        $user_id = $user['user_id'];

        // Update the users table
        $update_user_query = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', email = '$email' WHERE id = $user_id";
        $conn->query($update_user_query);

        // Update the customers table
        $update_customer_query = "UPDATE customers SET phone = '$phone', city = '$city' WHERE id = $customer_id";
        $conn->query($update_customer_query);

        $response = ['success' => true, 'message' => 'Customer updated successfully'];
    }
}

echo json_encode($response);
?>