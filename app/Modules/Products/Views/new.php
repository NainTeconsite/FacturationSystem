<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('contenido') ?>
<?= view('partials/_form-errors') ?>
<form action="create" method="POST">
<?= view('partials/_form-products', ['action' => 'Crear', 'name'=> '','code'=> '','description'=>'','entry'=> '','exit'=> '','stock'=> '','price'=> '', 'category'=>'', 'tag' => '']) ?>
</form>
<?= $this->endSection() ?>

