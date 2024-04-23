<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
<label for="name">Nombre</label>
<input type="text" name="name" id="name" value="<?= old('name', $name) ?>">

<label for="code">Código</label>
<input type="text" name="code" id="code" value="<?= old('code', $code) ?>">

<label for="description">Description</label>
<textarea type="text" name="description" id="description">
    <?= old('description', $description) ?>
</textarea>

<label for="entry">Entrada</label>
<input type="number" name="entry" id="entry" value="<?= old('entry', $entry) ?>">

<label for="exit">Salida</label>
<input type="number" name="exit" id="exit" value="<?= old('exit', $exit) ?>">

<label for="stock">Stock</label>
<input type="number" name="stock" id="stock" value="<?= old('stock', $stock) ?>">

<label for="price">Precio</label>
<input type="decimal" name="price" id="price" value="<?= old('price', $price) ?>">

<label for="">Categoria</label>
<select name="categoryid" id="categoryid">
    <option value=""></option>
    <?php foreach ($categories as $key): ?>
        <option <?= $category == $key->categoryid ? 'selected' : '' ?> value="<?= $key->categoryid ?>"> <?= $key->name ?>
        </option>
    <?php endforeach ?>
</select>
<label for="">Etiqueta</label>
<select multiple name="tagid[]" id="tagid">
    <option value=""></option>
    <?php foreach ($tags as $key): ?>
        <option <?= in_array($key->tagid, old('tagid', $productTags)) ? 'selected' : '' ?> value="<?= $key->tagid ?>">
            <?= $key->name ?></option>
    <?php endforeach ?>
</select>
<button type="submit"> <?= $action ?></button>

<script>
    ClassicEditor.create(document.querySelector("#description"))
</script>