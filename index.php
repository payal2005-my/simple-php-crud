```php
<?php
require_once __DIR__ . '/db.php';

$pageTitle = 'Simple PHP CRUD';

$users = $pdo->query(
    'SELECT id, name, email, phone, created_at
     FROM users
     ORDER BY id DESC'
)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            background: #f4f7fb;
            font-family: Arial, sans-serif;
        }

        .navbar-brand {
            font-weight: 700;
        }

        .hero {
            padding: 55px 0 35px;
        }

        .hero h1 {
            color: #172554;
            font-weight: 700;
        }

        .content-card {
            border: 0;
            border-radius: 16px;
            box-shadow: 0 8px 28px rgba(15, 23, 42, .07);
        }

        .table th {
            white-space: nowrap;
        }

        .action-buttons form {
            display: inline;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Simple PHP CRUD</a>
        <span class="navbar-text text-light">Demo Project</span>
    </div>
</nav>

<main class="container pb-5">

    <section class="hero text-center">
        <span class="badge text-bg-primary mb-3">PHP + MySQL</span>
        <h1>User Management System</h1>
        <p class="text-secondary mt-3">
            Create and manage user records in one place.
        </p>
    </section>

    <section class="card content-card">
        <div class="card-body p-4 p-md-5">

            <div class="d-flex flex-column flex-md-row
                        justify-content-between align-items-md-center
                        gap-3 mb-4">
                <div>
                    <h2 class="h4 fw-bold mb-1">Users</h2>
                    <p class="text-secondary mb-0">
                        Total records: <?= count($users) ?>
                    </p>
                </div>

                <a href="create.php" class="btn btn-primary">
                    + Add User
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="6"
                                class="text-center py-5 text-secondary">
                                No users found.
                                Click Add User to create your first record.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td>
                                    <?= (int) $user['id'] ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $user['name'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $user['email'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $user['phone'] ?? '',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $user['created_at'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </td>

                                <td>
                                    <div class="action-buttons d-flex gap-2">
                                        <a
                                            href="update.php?id=<?= (int) $user['id'] ?>"
                                            class="btn btn-sm btn-outline-primary"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            action="delete.php"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this user?');"
                                        >
                                            <input
                                                type="hidden"
                                                name="id"
                                                value="<?= (int) $user['id'] ?>"
                                            >

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                            >
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </section>

</main>

<footer class="text-center text-secondary py-4">
    <small>Simple PHP CRUD &copy; <?= date('Y') ?></small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
```
