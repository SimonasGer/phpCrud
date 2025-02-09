<?php
require_once "classes/User.php";

$user = new User();
$users = $user->getUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="rendering/index.css">
</head>
<body>

    <?php include "components/header.php";?>

    <div class="container">
        <h2>User List</h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= $u["id"] ?></td>
                        <td><?= htmlspecialchars($u["name"]) ?></td>
                        <td><?= htmlspecialchars($u["email"]) ?></td>
                        <td class="buttons">
                            <a href="update.php?id=<?= $u['id'] ?>" class="btn edit">Edit</a>
                            <a href="delete.php?id=<?= $u['id'] ?>" class="btn delete" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="create.php" class="btn add">Add New User</a>
    </div>

    <?php include "components/footer.php";  ?>

</body>
</html>

