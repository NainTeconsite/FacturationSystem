<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
<div class="card">
    <div class="card-header">
        <h2>Creación de Productos</h2>
    </div>
    <div class="card-body">
        <label class="mt-2" for="name">Nombre</label>
        <input class="form-control" type="text" name="name" id="name" value="<?= old('name', $name) ?>">

        <label class="mt-2" for="code">Código</label>
        <input class="form-control" type="text" name="code" id="code" value="<?= old('code', $code) ?>">

        <label for="description">Description</label>
        <textarea type="text" name="description" id="description">
    <?= old('description', $description) ?>
</textarea>
        <label class="mt-2" for="entry">Entrada</label>
        <input class="form-control" type="number" name="entry" id="entry" value="<?= old('entry', $entry) ?>">

        <label class="mt-2" for="exit">Salida</label>
        <input class="form-control" type="number" name="exit" id="exit" value="<?= old('exit', $exit) ?>">

        <label class="mt-2" for="stock">Stock</label>
        <input class="form-control" type="number" name="stock" id="stock" value="<?= old('stock', $stock) ?>">

        <label class="mt-2" for="price">Precio</label>
        <input class="form-control" type="decimal" name="price" id="price" value="<?= old('price', $price) ?>">

        <label class="mt-2" for="">Categoria</label>
        <select class="form-control" name="categoryid" id="categoryid">
            <?php foreach ($categories as $key): ?>
                <option <?= $category == $key->categoryid ? 'selected' : '' ?> value="<?= $key->categoryid ?>">
                    <?= $key->name ?>
                </option>
            <?php endforeach ?>
        </select>
        <label class="mt-2" for="">Etiqueta</label>
        <select class="form-control" multiple name="tagid[]" id="tagid">
            <?php foreach ($tags as $key): ?>
                <option <?= in_array($key->tagid, old('tagid', $productTags)) ? 'selected' : '' ?>
                    value="<?= $key->tagid ?>">
                    <?= $key->name ?>
                </option>
            <?php endforeach ?>
        </select>
        <button class="btn btn-success mt-2" type="submit"> <?= $action ?></button>

    </div>
</div>
<script>
    ClassicEditor.create(document.querySelector("#description"))
</script>