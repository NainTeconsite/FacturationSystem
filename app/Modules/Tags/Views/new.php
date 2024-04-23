<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('contenido') ?>
<?= view('partials/_form-errors') ?>
<form action="create" method="POST">
    <?= view('partials/_formcategories', ['action' => 'Nuevo']) ?>
</form>
<?= $this->endSection() ?>

