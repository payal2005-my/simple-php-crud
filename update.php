
<?php
session_start();

require_once __DIR__ . '/db.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    http_response_code(400);
    exit('Invalid user ID.');
}

$stmt = $pdo->prepare(
    'SELECT id, name, email, phone FROM users WHERE id = :id'
);
$stmt->execute(['id' => $id]);
$user = $stmt->fetch();

if (!$user) {
    http_response_code(404);
    exit('User not found.');
}

$errors = [];
$name = $user['name'];
$email = $user['email'];
$phone = $user['phone'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';

    if (!is_string($token) ||
        !hash_equals($_SESSION['csrf_token'], $token)) {
        $errors[] = 'Invalid request. Please refresh and try again.';
    }

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if ($name === '' || strlen($name) > 100) {
        $errors[] = 'Name is required and must not exceed 100 characters.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) ||
        strlen($email) > 150) {
        $errors[] = 'Please enter a valid email address.';
    }

    if (strlen($phone) > 20) {
        $errors[] = 'Phone number must not exceed 20 characters.';
    }

    if (!$errors) {
        try {
            $stmt = $pdo->prepare(
                'UPDATE users
                 SET name = :name, email = :email, phone = :phone
                 WHERE id = :id'
            );

            $stmt->execute([
                'name' => $name,
                'email' => $email,
                'phone' => $phone !== '' ? $phone : null,
                'id' => $id,
            ]);

            header('Location: index.php?status=updated');
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                $errors[] = 'This email address is already in use.';
            } else {
                error_log('Update user error: ' . $e->getMessage());
                $errors[] = 'Unable to update the user. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User | Simple PHP CRUD</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <style>
        body {
            background: #f4f7fb;
        }
        .form-card {
            border: 0;
            border-radius: 16px;
            box-shadow: 0 8px 28px rgba(15, 23, 42, .07);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">
            Simple PHP CRUD
        </a>
    </div>
</nav>

<main class="container py-5" style="max-width: 720px;">
    <div class="card form-card">
        <div class="card-body p-4 p-md-5">
            <h1 class="h3 fw-bold mb-4">Edit User #<?= (int) $id ?></h1>

            <?php if ($errors): ?>
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= escape($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post" action="edit.php?id=<?= (int) $id ?>">
                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= escape($_SESSION['csrf_token']) ?>"
                >

                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input
                        class="form-control"
                        id="name"
                        name="name"
                        maxlength="100"
                        value="<?= escape($name) ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        maxlength="150"
                        value="<?= escape($email) ?>"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input
                        type="tel"
                        class="form-control"
                        id="phone"
                        name="phone"
                        maxlength="20"
                        value="<?= escape($phone) ?>"
                    >
                </div>

                <button type="submit" class="btn btn-primary">
                    Update User
                </button>
                <a href="index.php" class="btn btn-outline-secondary ms-2">
                    Cancel
                </a>
            </form>
        </div>
    </div>
</main>

</body>
</html>
