<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('contenido') ?>
<h1>Categories</h1>

<a href="new">Create</a>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Options</th>
    </tr>
    <?php foreach ($categorias as $key): ?>
        <tr>
            <th> <?= $key->categoryid ?></th>
            <th> <?= $key->name ?></th>
            <th>
                <a href="show/<?= $key->categoryid ?>">SHOW</a>
                <a href="edit/<?= $key->categoryid ?>">EDIT</a>
                <form action="delete/<?= $key->categoryid ?>" method="POST"><button type="submit">DELETE</button></form>
            </th>
        </tr>

    <?php endforeach ?>
</table>

<?= $pager->links() ?>
<?= $this->endSection() ?>