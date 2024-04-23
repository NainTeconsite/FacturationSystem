<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('contenido') ?>
<?= view('partials/_form-errors') ?>
<form action="/dashboard/categories/update/<?= $tag->tagyid?>" method="POST">
    <?= view('partials/_formcategories', ['action' => 'Editar', 'name'=> $tag->name]) ?>
</form>
<?= $this->endSection() ?>

