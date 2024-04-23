<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('contenido') ?>
<h1>Tags</h1>

<a href="new">Create</a>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Options</th>
    </tr>
    <?php foreach ($tags as $key): ?>
        <tr>
            <th> <?= $key->tagid ?></th>
            <th> <?= $key->name ?></th>
            <th>
                <a href="show/<?= $key->tagid ?>">SHOW</a>
                <a href="edit/<?= $key->tagid ?>">EDIT</a>
                <form action="delete/<?= $key->tagid ?>" method="POST"><button type="submit">DELETE</button></form>
            </th>
        </tr>

    <?php endforeach ?>
</table>

<?= $pager->links() ?>
<?= $this->endSection() ?>