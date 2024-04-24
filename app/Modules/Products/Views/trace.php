<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('contenido') ?>
<h1 class="text-center">Ventas y compras de <?= $product->name ?></h1>
<div class="card mt-3 mb-3" style="width:200px;">
    <div class="card-header">
        Características
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            Precio <?= $product->price ?>
        </li>
        <li class="list-group-item">
            Última entrada <?= $product->entry ?>
        </li>
        <li class="list-group-item">
            Última salida <?= $product->exit ?>
        </li>
    </ul>


</div>
<div class="card mb-3">
    <div class="card-header">
        <h3>Filtro</h3>
    </div>
    <div class="card-body border-bottom">
        <form method="get" id="formFilter">
            <h3>Búsqueda</h3>

            <div class="p-2">
                <input class="form-control mb-2" type="text" value="<?= $search ? $search : '' ?>" name="search"
                    placeholder="Buscar">
                <div class="row">
                    <div class="col">
                        <select class="form-control" name="type">
                            <option value="">Tipo</option>
                            <option <?= $type == 'exit' ? 'selected' : '' ?> value="exit">Salida</option>
                            <option <?= $type == 'entry' ? 'selected' : '' ?> value="entry">Entrada</option>
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-control" name="user_id">
                            <option value="">Usuario</option>
                            <?php foreach ($users as $key => $value): ?>
                                <option <?= $user == $value->userid ? 'selected' : '' ?> value="<?= $value->userid ?>">
                                    <?= $value->username ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
    </div>
    <div class="card-body">

        <h3>Cantidades</h3>
        <label for="">
            Activar
            <input type="checkbox" checked name="check_can">
        </label>
        <label class="can" style="display:block" for="min_can">
            Mínimo <span><?= $min ? $min : '' ?></span> :
            <input type="range" name="min_can" value="<?= $min ? $min : 0 ?>" min="0" max="100" step="1">
        </label>
        <label class="can" style="display:block" for="max_can">
            Máximo <span><?= $max ? $max : '' ?></span> :
            <input type="range" name="max_can" value="<?= $max ? $max : 110 ?>" min="10" max="110" step="1">
        </label>

    </div>
    <div class="card-footer ">
        <button class="btn btn-primary btn-sm" type="submit">Filtrar</button>
        <a class="btn btn-primary btn-sm" href="<?= route_to('product.trace', $product->productid) ?>">
            Limpiar filtro
        </a>
        </form>
        <a class="btn btn-success float-end" href="<?= route_to('demopdf', $product->productid) ?>">Descargar en pdf</a>
    </div>
</div>
<table class="table">
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
            <td colspan="8">
                <span class="fw-bold">TOTAL</span>

            </td>
            <td>
                <span class="fw-bold text-success"><?= $total ?></span>

            </td>
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