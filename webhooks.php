<?php
include('dbconnection.php');

// The payload sent by PayMongo
$payload = file_get_contents('php://input');  // Get raw POST data
$signature = $_SERVER['HTTP_X_PAYMONGO_SIGNATURE'];  // Signature sent by PayMongo

// The secret key for validating the signature
$secret = 'your_webhook_secret';  // Replace with your actual webhook secret key

// Validate the signature (ensure the request is from PayMongo)
if (hash_hmac('sha256', $payload, $secret) !== $signature) {
    die('Invalid signature');
}

// Decode the JSON payload
$data = json_decode($payload, true);

// Handle the payment event
if ($data && isset($data['data']['attributes']['status'])) {
    $status = $data['data']['attributes']['status'];  // Status of the payment (paid, failed, etc.)
    $paymentReference = $data['data']['attributes']['reference_number'];  // Reference number

    // Update the order status in the database
    if ($status == 'paid') {
        // Payment is successful, update the order in the database
        $stmt = $conn->prepare("UPDATE `order` SET status = 'paid' WHERE reference_number = ?");
        $stmt->bind_param("s", $paymentReference);
        if ($stmt->execute()) {
            echo "Payment processed successfully!";
        } else {
            echo "Failed to update order status.";
        }
        $stmt->close();
    } else {
        echo "Payment failed or pending.";
    }
} else {
    echo "Invalid or empty data.";
}

$conn->close();
?>
