<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }
        h1 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f5f5f5;
        }
        .btn {
            display: inline-block;
            padding: 5px 10px;
            margin-right: 5px;
            border: none;
            border-radius: 3px;
            font-size: 14px;
            cursor: pointer;
        }
        .btn-primary {
            background-color: #007bff;
            color: #fff;
        }
        .btn-warning {
            background-color: #ffc107;
            color: #333;
        }
        .btn-danger {
            background-color: #dc3545;
            color: #fff;
        }
    </style>
</head>
<body>
    <?= view('partials/_sessionmessages') ?>
    <a href="/dashboard/categories/">Categories</a>
    <a href="/dashboard/tags/">Tags</a>
    <a href="/dashboard/products/">Products</a>
    <?php $this->renderSection('contenido') ?>
</body>
</html>