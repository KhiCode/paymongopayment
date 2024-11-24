<?php include('orderpagestyle.php');
include('includes/header.php');
?>
<div class="container-1">
    <form action="orderconn.php" method="POST">
        <div class="mb-3">
            <label class="form-label-price">Price: 200</label>
        </div>
        <div class="mb-3">
            <label for="quantity">Quantity</label>
            <div class="quantity-input">
                <button type="button" onclick="decrementQuantity()">-</button>
                <input type="number" id="quantity" name="quantity" value="1" min="1" oninput="updateTotal()">
                <button type="button" onclick="incrementQuantity()">+</button>
            </div>
        </div>
        <div class="mb-3">
            <label for="totalAmount" class="form-label">Total Amount</label>
            <input type="text" class="form-control" id="totalAmount" name="totalAmount" readonly>
        </div>
        <!-- Add name="order" to the submit button -->
        <button type="submit" name="order" class="btn btn-primary">Place Order</button>
    </form>
</div>


<script>
    const price = 200; // Fixed price

    // Function to increment quantity
    function incrementQuantity() {
        const quantityInput = document.getElementById("quantity");
        let currentValue = parseInt(quantityInput.value, 10);
        if (!isNaN(currentValue)) {
            quantityInput.value = currentValue + 1;
            updateTotal();
        }
    }

    // Function to decrement quantity
    function decrementQuantity() {
        const quantityInput = document.getElementById("quantity");
        let currentValue = parseInt(quantityInput.value, 10);
        if (!isNaN(currentValue) && currentValue > 1) {
            quantityInput.value = currentValue - 1;
            updateTotal();
        }
    }

    // Function to update the total amount
    function updateTotal() {
        const quantityInput = document.getElementById("quantity");
        const totalAmountInput = document.getElementById("totalAmount");
        let quantity = parseInt(quantityInput.value, 10);

        if (!isNaN(quantity) && quantity >= 1) {
            totalAmountInput.value = quantity * price;
        } else {
            totalAmountInput.value = 0;
        }
    }

    // Initialize the total amount on page load
    document.addEventListener("DOMContentLoaded", updateTotal);
</script>
