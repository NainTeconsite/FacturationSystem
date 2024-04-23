
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
