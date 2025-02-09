<?php
require_once "classes/User.php";

$user = new User();
$id = $_GET["id"];
$currentUser = $user->getUserById($id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $error = "";

    $result = $user->updateUser($id, $email, $email);
    if ($result["status"] === "error") {
        $error = $result["message"];
    } else {
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
    <link rel="stylesheet" href="rendering/form.css">
</head>
<body>

    <?php include "components/header.php";?>

    <form method="POST">
        <input name="name" value="<?= htmlspecialchars($currentUser['name']) ?>">
        <input name="email" value="<?= htmlspecialchars($currentUser['email']) ?>">
        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <button type="submit">Update</button>
    </form>

    <?php include "components/footer.php";?>

</body>
</html>