<?= $this->extend('layouts\dashboard') ?>
<?= $this->section('contenido') ?>

<body>
    <?php foreach ($categoria as $key => $value): ?>
        <h2> <?= $key ?></h2>
        <p> <?= $value ?></p>
    <?php endforeach ?>
</body>
<?= $this->endSection() ?>