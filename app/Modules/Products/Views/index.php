<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('contenido') ?>

<h1>Products</h1>
<a class="btn btn-primary" href="new">Crear</a>
<div id="blockSelectUser" style="display:none">
    <select class="user">
        <?php foreach ($users as $key): ?>
            <option value="<?= $key->userid ?>"><?= $key->username ?></option>
        <?php endforeach ?>
    </select>
    <label for="" class="errorDirection"></label>
    <textarea class="direction" cols="15" rows="5" placeholder="Direction"></textarea>
    <label for="" class="errorDescription"></label>
    <textarea class="description" cols="15" rows="5" placeholder="Description"></textarea>
    <button data-input="" class="user">Enviar</button>
</div>
<form method="get">
    <label for="">Categoria</label>
    <select name="categoryid" id="categoryid">
        <option value="">Default</option>
        <?php foreach ($categories as $key): ?>
            <option <?= $category == $key->categoryid ? 'selected' : '' ?> value=" <?= $key->categoryid ?>"> <?= $key->name ?>
            </option>
        <?php endforeach ?>
    </select>
    <label for="">Etiqueta</label>
    <select multiple name="tagid[]" id="tagid">
        <option value="">Default</option>
        <?php foreach ($tags as $key): ?>
            <option <?= in_array($key->tagid, $tag)? 'selected' : '' ?> value="<?= $key->tagid ?>"> <?= $key->name ?>
            </option>
        <?php endforeach ?>
    </select>
    <button type="submit">Enviar</button>
</form>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Code</th>
        <th>Category</th>
        <th>Entry</th>
        <th>Exit</th>
        <th>Stock</th>
        <th>Price</th>
        <th>Options</th>
    </tr>
    <?php foreach ($products as $key): ?>
        <tr>
            <th> <?= $key->productid ?></th>
            <th> <?= $key->name ?></th>
            <th> <?= $key->code ?></th>
            <th> <?= $key->categoryid ?></th>
            <th> <input type="number" data-id="<?= $key->productid ?>" class="entry" value="<?= $key->entry ?>"></th>
            <th> <input type="number" data-id="<?= $key->productid ?>" class="exit" value="<?= $key->exit ?>"></th>
            <th id="stock_<?= $key->productid ?>"> <?= $key->stock ?></th>
            <th> <?= $key->price ?></th>
            <th>
                <a href="show/<?= $key->productid ?>">SHOW</a>
                <a href="edit/<?= $key->productid ?>">EDIT</a>
                <form action="delete/<?= $key->productid ?>" method="POST"><button class="btn btn-danger"
                        type="submit">DELETE</button></form>
                <a href="<?= route_to('product.trace', $key->productid) ?>">TRACE</a>
            </th>
        </tr>

    <?php endforeach ?>
</table>
<script>
    let button_user = document.querySelector('button.user')
    let description = document.querySelector('#blockSelectUser .description')
    let direction = document.querySelector('#blockSelectUser .direction')
    let errorDirection = document.querySelector('#blockSelectUser .errorDirection')
    let errorDescription = document.querySelector('#blockSelectUser .errorDescription')
    let blockSelectUser = document.querySelector('#blockSelectUser')
    let id = 0
    let typeUser = ''
    let userEntry = []
    let userExit = []
    let select_user = document.querySelector('select.user')

    function getUsers() {
        fetch('/dashboard/getUsers/' + typeUser)

            .then(res => {
                if (!res.ok) {

                }
                return res.json();
            })
            .then(res => {
                // console.log(res)
                if (typeUser == 'provider') {
                    userEntry = res
                } else {
                    userExit = res
                }
                populateSelectUser()
            })
    }
    function populateSelectUser() {
        select_user.options.length = 0
        let dataArray = typeUser == 'customer' ? userExit : userEntry
        // console.log(typeUser)
        // console.log('data array', dataArray)
        for (index in dataArray) {
            select_user.options[select_user.options.length] = new Option(dataArray[index].username, dataArray[index].userid)
        }
    }


    let entry_value = 0
    let entries = document.querySelectorAll('.entry')
    entries.forEach((entry) => {
        entry.addEventListener('keyup', (event) => {
            id = entry.getAttribute('data-id')
            if (event.keyCode === 13) {
                button_user.setAttribute('data-input', 'entry');
                entry_value = entry.value
                blockSelectUser.style.display = "block"
                typeUser = 'provider'
                if (userEntry.length == 0) {
                    getUsers()
                } else {
                    populateSelectUser()
                }
            }

        })
    })

    let exits = document.querySelectorAll('.exit')
    let exit_value = 0
    exits.forEach((exit) => {
        exit.addEventListener('keyup', (event) => {
            id = exit.getAttribute('data-id')
            if (event.keyCode === 13) {
                button_user.setAttribute('data-input', 'exit');
                exit_value = exit.value
                blockSelectUser.style.display = "block"
                typeUser = 'customer'

                if (userExit.length == 0) {
                    getUsers()
                } else {
                    populateSelectUser()
                }
            }

        })
    })


    button_user.addEventListener('click', () => {
        if (button_user.getAttribute('data-input') == 'entry') {
            // console.log(select_user.value)
            const formData = new FormData();
            formData.append('id', id);
            formData.append('entry', entry_value);
            formData.append('userid', select_user.value);
            formData.append('direction', direction.value);
            formData.append('description', description.value);
            // console.log(select_user.value)
            fetch(`/addStock`, {
                method: 'POST',
                body: formData
            })
                .then(res => {
                    if (!res.ok) {
                        return res.json().then(data => Promise.reject(data));
                    }
                    return res.json()
                })
                .then(res => {
                    blockSelectUser.style.display = "none"
                    resetForm()
                    document.querySelector(`#stock_${res['productid']}`).innerHTML = res['stock']
                    // console.log(res['stock'])
                }).catch((err) => {
                    // console.error(err.messages.description)
                    errorDirection.innerHTML = err.messages.direction
                    errorDescription.innerHTML = err.messages.description
                    // console.error(err.messages.direction)
                })
        }
        if (button_user.getAttribute('data-input') == 'exit') {
            // console.log(select_user.value)
            const formData = new FormData();
            formData.append('id', id);
            formData.append('exit', exit_value);
            formData.append('userid', select_user.value);
            formData.append('direction', direction.value);
            formData.append('description', description.value);
            // console.log(select_user.value)
            fetch(`/removeStock`, {
                method: 'POST',
                body: formData
            })
                .then(res => {
                    if (!res.ok) {
                        return res.json().then(data => Promise.reject(data));
                    }
                    return res.json()
                })
                .then(res => {
                    blockSelectUser.style.display = "none"
                    resetForm()
                    document.querySelector(`#stock_${res['productid']}`).innerHTML = res['stock']
                    // console.log(res['stock'])
                }).catch((err) => {
                    // console.error(err.messages.description)
                    errorDirection.innerHTML = err.messages.direction
                    errorDescription.innerHTML = err.messages.description
                    // console.error(err.messages.direction)
                })
        }

    })

    function resetForm() {
        errorDirection.innerHTML = ''
        errorDescription.innerHTML = ''
        direction.value = ''
        description.value = ''
    }
</script>

<style>
    input[type=number] {
        -moz-appearance: textfield;
        /* Firefox */
        appearance: textfield;
        /* text-align: right; */
        /* Otros navegadores */
    }
</style>
<?= $pager->links() ?>
<?= $this->endSection() ?>