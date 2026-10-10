
<?php
$pageTitle = "Simple PHP CRUD";
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
            background-color: #f4f7fb;
            font-family: Arial, sans-serif;
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .hero {
            padding: 70px 0 45px;
        }

        .hero h1 {
            font-size: clamp(2rem, 5vw, 3.2rem);
            font-weight: 700;
            color: #172554;
        }

        .hero p {
            color: #64748b;
            font-size: 1.1rem;
        }

        .content-card {
            border: 0;
            border-radius: 16px;
            box-shadow: 0 8px 28px rgba(15, 23, 42, 0.07);
        }

        .status-dot {
            display: inline-block;
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: #16a34a;
            margin-right: 7px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            Simple PHP CRUD
        </a>
        <span class="navbar-text text-light">
            Demo Project
        </span>
    </div>
</nav>

<main class="container pb-5">

    <section class="hero text-center">
        <span class="badge text-bg-primary mb-3">
            PHP + MySQL
        </span>

        <h1>User Management System</h1>

        <p class="mt-3 mb-0">
            A simple application to create, view, update, and delete users.
        </p>
    </section>

    <section class="card content-card">
        <div class="card-body p-4 p-md-5">

            <div class="d-flex flex-column flex-md-row
                        justify-content-between align-items-md-center gap-3 mb-4">

                <div>
                    <h2 class="h4 fw-bold mb-1">Manage Users</h2>
                    <p class="text-secondary mb-0">
                        Your user records will appear here.
                    </p>
                </div>

                <button class="btn btn-primary" type="button" disabled>
                    + Add User
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td colspan="4"
                                class="text-center py-5 text-secondary">
                                No users yet. Database functionality
                                will be added in the next steps.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="small text-secondary mt-3">
                <span class="status-dot"></span>
                Website homepage created
            </div>

        </div>
    </section>

</main>

<footer class="text-center text-secondary py-4">
    <small>Simple PHP CRUD &copy; <?= date('Y') ?></small>
</footer>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>

</body>
</html>
