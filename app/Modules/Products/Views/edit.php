<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('contenido') ?>
<?= view('partials/_form-errors') ?>
<form action="/dashboard/products/update/<?= $product->productid?>" method="POST">
    <?= view('partials/_form-products', ['action' => 'Editar', 'name'=> $product->name,'code'=> $product->code,'description'=> $product->description,'entry'=> $product->entry,'exit'=> $product->exit,'stock'=> $product->stock,'price'=> $product->price, 'category' => $product->categoryid, 'tag' =>'']) ?>
</form>
<?= $this->endSection() ?>

