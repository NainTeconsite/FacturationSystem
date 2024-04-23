<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('contenido') ?>
<?= view('partials/_form-errors') ?>
<form action="/dashboard/categories/update/<?= $categoria->categoryid?>" method="POST">
    <?= view('partials/_formcategories', ['action' => 'Editar', 'name'=> $categoria->name]) ?>
</form>
<?= $this->endSection() ?>

