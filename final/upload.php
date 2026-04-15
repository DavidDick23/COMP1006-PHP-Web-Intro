<?php
//=========================================================================
// #region Auth Guard and Connection
//-------------------------------------------------------------------------
require "./includes/auth.php";    // session + auth helpers
requireLogin();                   // redirect to login.php if not logged in
require "./includes/connect.php"; // $pdo — kept open for the full page lifecycle

$user    = getCurrentUser();
$errors  = [];
$success = "";
//-------------------------------------------------------------------------
// #endregion Auth Guard and Connection
//=========================================================================

//=========================================================================
// #region File Variables
//-------------------------------------------------------------------------
// Allowed MIME types: common image types
$allowedMimeTypes = [
    'image/jpeg',
    'image/png',
    'image/gif',
    'image/webp',
];

$maxFileSizeBytes = 5 * 1024 * 1024; //5 MB
$uploadDir        = __DIR__ . '/uploads/'; //physical path on server
//-------------------------------------------------------------------------
// #endregion File Variables
//=========================================================================

//=========================================================================
// #region Handle POST (Upload)
//-------------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['upload_file']))
{
    $file = $_FILES['upload_file'];

    //=========================================================================
    // #region Validate File
    //-------------------------------------------------------------------------

    //Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK)
    {
        $errors[] = "File upload failed with error code: " . $file['error'];
    }
    else
    {
        //Check file size
        if ($file['size'] > $maxFileSizeBytes)
            $errors[] = "File exceeds the 5 MB size limit.";

        //Validate MIME type using finfo (more reliable than $_FILES['type'])
        $finfo    = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);

        if (!in_array($mimeType, $allowedMimeTypes))
            $errors[] = "File type '" . htmlspecialchars($mimeType) . "' is not allowed.";
    }
    //-------------------------------------------------------------------------
    // #endregion Validate File
    //=========================================================================

    //=========================================================================
    // #region Move File & Save Record
    //-------------------------------------------------------------------------
    if (empty($errors))
    {
        // Generate a unique stored filename to prevent collisions and hide original name
        $extension  = pathinfo($file['name'], PATHINFO_EXTENSION);
        $storedName = uniqid('upload_', true) . '.' . strtolower($extension);
        $destPath   = $uploadDir . $storedName;

        if (!move_uploaded_file($file['tmp_name'], $destPath))
        {
            $errors[] = "Failed to save the uploaded file. Check server folder permissions.";
        }
        else
        {
            //Record the upload in the database
            $originalName = basename($file['name']);
            $fileSize     = $file['size'];

            $sql  = "INSERT INTO file_uploads (user_id, original_name, stored_name, file_type, file_size)
                     VALUES (:user_id, :original_name, :stored_name, :file_type, :file_size)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':user_id',       $user['id']);
            $stmt->bindParam(':original_name', $originalName);
            $stmt->bindParam(':stored_name',   $storedName);
            $stmt->bindParam(':file_type',     $mimeType);
            $stmt->bindParam(':file_size',     $fileSize);
            $stmt->execute();

            $success = "File '" . htmlspecialchars($originalName) . "' uploaded successfully.";
        }
    }
    //-------------------------------------------------------------------------
    // #endregion Move File & Save Record
    //=========================================================================
}
//-------------------------------------------------------------------------
// #endregion Handle POST
//=========================================================================
?>

<!DOCTYPE html>
<html lang="en">
<?php require "./includes/head.php"; ?>
<body>
<div class="container">
    <?php include "./includes/header.php"; ?>

    <main class="mt-4">
        <h2>File Uploads</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <!-- Upload Form -->
        <form action="upload.php" method="post" enctype="multipart/form-data" class="mb-4">
            <div class="form-group mb-3">
                <label for="upload_file" class="form-label">Choose a file to upload</label>
                <input type="file" class="form-control" id="upload_file" name="upload_file" required>
                <div class="form-text">Max 5 MB. Allowed: JPG, PNG, GIF, WEBP</div>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </main>

    <?php include "./includes/footer.php"; ?>
</div>
</body>
</html>