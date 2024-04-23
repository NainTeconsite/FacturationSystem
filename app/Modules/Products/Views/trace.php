<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('contenido') ?>
<p>Ventas y compras de <?= $product->name ?></p>
<ul>
    <li>
        Precio <?= $product->price ?>
    </li>
    <li>
        Última entrada <?= $product->entry ?>
    </li>
    <li>
        Última salida <?= $product->exit ?>
    </li>
</ul>
<h3>Filtro</h3>
<form method="get" id="formFilter">
    <select name="type">
        <option value=""></option>
        <option <?= $type == 'exit' ? 'selected' : '' ?> value="exit">Salida</option>
        <option <?= $type == 'entry' ? 'selected' : '' ?> value="entry">Entrada</option>
    </select>
    <select name="user_id">
        <option value=""></option>
        <?php foreach ($users as $key => $value): ?>
            <option <?= $user == $value->userid ? 'selected' : '' ?> value="<?= $value->userid ?>"><?= $value->username ?>
            </option>
        <?php endforeach ?>
    </select>
    <h3>Búsqueda</h3>
    <input type="text" value="<?= $search ? $search : '' ?>" name="search" placeholder="Buscar">
    <h3>Cantidades</h3>
    <label for="">
        Activar
        <input type="checkbox" checked name="check_can">
    </label>
    <br>
    <label class="can" style="display:block" for="min_can">
        Mínimo <span><?= $min ? $min : '' ?></span> :
        <input type="range" name="min_can" value="<?= $min ? $min : 0 ?>" min="0" max="100" step="1">
    </label>
    <br>
    <label class="can" style="display:block" for="max_can">
        Máximo <span><?= $max ? $max : '' ?></span> :
        <input type="range" name="max_can" value="<?= $max ? $max : 110 ?>" min="10" max="110" step="1">
    </label>
    <br>
    <button type="submit">Filtrar</button>
    <a href="<?= route_to('product.trace', $product->productid) ?>"><button>
            Limpiar filtro
        </button></a>

</form>
<a href="<?= route_to('demopdf', $product->productid)?>"><button>Descargar en pdf</button></a>
<table>
    <thead>
        <tr>
            <th>
                ID
            </th>
            <th>
                FECHA
            </th>
            <th>
                TIPO
            </th>
            <th>
                CANTIDAD
            </th>
            <th>
                USUARIO
            </th>
            <th>
                DESCRIPTION
            </th>
            <th>
                DIRECTION
            </th>
            <th>
                PRECIO
            </th>
            <th>
                TOTAL
            </th>
        </tr>
    </thead>
    <tbody>
        <?php $total = 0 ?>
        <?php foreach ($trace as $key => $value): ?>

            <tr>
                <td>
                    <?= $value->products_controlid ?>
                </td>
                <td>
                    <?= $value->created_at ?>
                </td>
                <td>
                    <?= $value->type ?>
                </td>
                <td>
                    <?= $value->count ?>
                </td>
                <td>
                    <?= $value->email ?>
                </td>
                <td>
                    <?= $value->description ?>
                </td>
                <td>
                    <?= $value->direction ?>
                </td>
                <td>
                    <?= $product->price ?>
                </td>
                <td>
                    <?php $total += $product->price * $value->count ?>
                    <?= $product->price * $value->count ?>
                </td>
            </tr>
        <?php endforeach ?>
        <tr>
            <td colspan="8">TOTAL</td>
            <td><?= $total ?></td>
        </tr>
    </tbody>
</table>

<script>
    let formFilter = document.getElementById('formFilter')
    let min_can = document.querySelector('[name = min_can]')
    let max_can = document.querySelector('[name = max_can]')

    formFilter.addEventListener('submit', (event) => {
        event.preventDefault()

        if (parseInt(min_can.value) > parseInt(max_can.value)) {
            console.log(min_can + " " + max_can)
            return "";
        }
        formFilter.submit()
    })

    let check_can = document.querySelector('[name="check_can"]');
    let can = document.querySelectorAll('.can');

    check_can.addEventListener('click', () => {
        if (check_can.checked) {
            can.forEach(element => {
                element.style.display = 'block';
            });
            // console.log('checked');
        } else {
            can.forEach(element => {
                element.style.display = 'none';
            });
            // console.log('unchecked');
        }
    });

    let for_min_can = document.querySelector('[for = min_can]');
    min_can.addEventListener('change', () => {
        for_min_can.querySelector('span').innerText = min_can.value
    })
    let for_max_can = document.querySelector('[for = max_can]');
    max_can.addEventListener('change', () => {
        for_max_can.querySelector('span').innerText = max_can.value
    })
</script>
<?= $this->endSection() ?>