<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/bootstrap/css/bootstrap.min.css">
    <script src="<?= base_url() ?>/bootstrap/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="navbar navbar-dark bg-dark navbar-expand-lg mb-5">
        <div class="container-fluid">
            <a href="#" class="navbar-brand">
                Inventario
            </a>
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav">
                    <li class="navbar-item">
                        <a class="nav-link" href="/dashboard/categories/">Categories</a>
                    </li>
                    <li class="navbar-item">
                        <a class="nav-link" href="/dashboard/tags/">Tags</a>
                    </li>
                    <li class="navbar-item">
                        <a class="nav-link" href="/dashboard/products/">Products</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <?= view('partials/_sessionmessages') ?>
        <?= view('partials/_form-errors') ?>        

        <?php $this->renderSection('contenido') ?>
    </div>

</body>

</html>