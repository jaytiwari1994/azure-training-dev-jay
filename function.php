	<?php
	$resultMessage = "";
	$statusClass = "";

	// Check if the form was submitted
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$qty = $_POST['quantity'];
		$orderId = $_POST['generatedOrderId']; // Captured from JS via hidden input

		// 1. Prepare the API URL
		$apiUrl = "https://fa-order-process-function-app.azurewebsites.net/api/OrderStatusFunction?orderId=" . urlencode($orderId) . "&quantity=" . urlencode($qty);

		// 2. Call the API (using file_get_contents)
		// We use @ to avoid displaying errors on the page if the API is down
		$apiResponse = @file_get_contents($apiUrl);

		// 3. Perform the validation logic
		if (is_numeric($qty) && $qty >= 0 && $qty <= 5) {
			$resultMessage = "Order placed successfully! <br><strong>Order ID: $orderId</strong>";
			$statusClass = "success";
		} else {
			$resultMessage = "Order not successful. <br>Quantity was <strong>$qty</strong>, which is not between 0 and 5.";
			$statusClass = "error";
		}
	}
	?>

	<!DOCTYPE html>
	<html>
	<head>
		<title>Order System</title>
		<style>
			body { font-family: Arial, sans-serif; display: flex; justify-content: center; padding: 50px; background: #f0f2f5; }
			.box { background: white; padding: 30px; border-radius: 10px; shadow: 0 2px 10px rgba(0,0,0,0.1); width: 550px; text-align: center; border: 1px solid #ddd; }
			input[type="number"] { width: 80%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px; }
			button { padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
			.success { margin-top: 20px; padding: 15px; background: #d4edda; color: #155724; border-radius: 5px; border: 1px solid #c3e6cb; }
			.error { margin-top: 20px; padding: 15px; background: #f8d7da; color: #721c24; border-radius: 5px; border: 1px solid #f5c6cb; }
		</style>
	</head>
	<body>

	<div class="box">
		<h1>Place Order for silver coins*</h1>
		<h3>*each coin is of 10 gram</h3>
		<h3>*ordered quantity should be between 0 to 5</h3>
		<form id="orderForm" method="POST" onsubmit="generateID()">
			<input type="hidden" name="generatedOrderId" id="generatedOrderId">
			
			<label>Quantity:</label><br>
			<input type="number" name="quantity" required placeholder="Enter amount">
			<br>
			<button type="submit">Submit Order</button>
		</form>

		<?php if ($resultMessage): ?>
			<div class="<?php echo $statusClass; ?>">
				<?php echo $resultMessage; ?>
			</div>
		<?php endif; ?>
	</div>

	<script>
		function generateID() {
			const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
			let result = '';
			for (let i = 0; i < 12; i++) {
				result += chars.charAt(Math.floor(Math.random() * chars.length));
			}
			// Put the generated ID into the hidden input before the form sends to PHP
			document.getElementById('generatedOrderId').value = result;
		}
	</script>

	</body>
	</html>
