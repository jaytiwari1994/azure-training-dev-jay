<?php
// ============================
// Read Environment Variables
// ============================
$accountName = getenv('STORAGE_ACCOUNT_NAME');
$container   = getenv('STORAGE_CONTAINER');
$blobPath    = getenv('STORAGE_BLOB_PATH');
$sasToken    = getenv('STORAGE_SAS_TOKEN');

$imageUrl = "";
$error = "";

// ============================
// Button Click Handling
// ============================
if (isset($_POST['load_image'])) {

    if (!$accountName || !$container || !$blobPath || !$sasToken) {
        $error = "Storage configuration missing";
    } else {
        $imageUrl = sprintf(
            "https://%s.blob.core.windows.net/%s/%s?%s",
            $accountName,
            $container,
            $blobPath,
            $sasToken
        );
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Azure Blob Image Loader</title>
</head>
<body>

<h2>Load Image from Azure Blob Storage Training</h2>

<form method="post">
    <button type="submit" name="load_image">
        Load Image
    </button>
</form>

<br>

<?php if ($error): ?>
    <p style="color:red;"><strong><?= htmlspecialchars($error) ?></strong></p>
<?php endif; ?>

<?php if ($imageUrl): ?>
    <img src="<?= htmlspecialchars($imageUrl) ?>" width="400" alt="Azure Image">
<?php endif; ?>

</body>
</html>
