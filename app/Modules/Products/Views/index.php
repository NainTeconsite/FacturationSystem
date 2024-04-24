<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('contenido') ?>
<h1>Products</h1>
<a class="btn btn-primary mt-3" href="new">Crear</a>

<div class="modal fade" id="blockSelectUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gestión ventas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <select class="form-control user mb-3">
                    <?php foreach ($users as $key): ?>
                        <option value="<?= $key->userid ?>"><?= $key->username ?></option>
                    <?php endforeach ?>
                </select>
                <div for="" class="errorDirection alert alert-danger mb3" style="display:none"></div>
                <textarea class="direction form-control mb-3" cols="15" rows="5" placeholder="Direction"></textarea>
                <label for="" class="errorDescription alert alert-danger mb-3" style="display:none"></label>
                <textarea class="description form-control" cols="15" rows="5" placeholder="Description"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button data-input="" class="user btn btn-success">Enviar</button>
            </div>
        </div>
    </div>
</div>





<div class="card mt-3 mb-3">
    <div class="card-header">
        <button data-bs-toggle="collapse" data-bs-target="#filters" class="btn btn-flat float-end">Show</button>
        <h4>Filtros</h4>
    </div>
    <div class="card-body collapse" id="filters">

        <form method="get">
            <div class="row">
                <div class="col-6">
                    <label for="">Categoria</label>
                    <select class="form-select mb-3" name="categoryid" id="categoryid">
                        <option value="">Default</option>
                        <?php foreach ($categories as $key): ?>
                            <option <?= $category == $key->categoryid ? 'selected' : '' ?> value=" <?= $key->categoryid ?>">
                                <?= $key->name ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="col-6">
                    <label for="">Etiqueta</label>
                    <select class="form-select mb-3 overflow-auto" multiple name="tagid[]" id="tagid">
                        <option value="">Default</option>
                        <?php foreach ($tags as $key): ?>
                            <option <?= in_array($key->tagid, $tag) ? 'selected' : '' ?> value="<?= $key->tagid ?>">
                                <?= $key->name ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>

            <button class="btn btn-success btn-sm" type="submit">Enviar</button>
        </form>

    </div>
</div>

<table class="table">
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
                <a class="btn btn-primary btn-sm mb-1 d-block d-block" href="show/<?= $key->productid ?>">SHOW</a>
                <a class="btn btn-primary btn-sm mb-1 d-block" href="edit/<?= $key->productid ?>">EDIT</a>
                <form action="delete/<?= $key->productid ?>" method="POST"><button
                        class="btn btn-danger btn-sm mb-1 d-block" type="submit">DELETE</button></form>
                <a class="btn btn-secondary btn-sm mb-3 d-block"
                    href="<?= route_to('product.trace', $key->productid) ?>">TRACE</a>
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
    let modal = new bootstrap.Modal(document.getElementById('blockSelectUser'));

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
                modal.toggle()
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
                modal.toggle()
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
                    modal.toggle()
                    errorDirection.style.display = "none"
                    errorDescription.style.display = "none"
                    blockSelectUser.style.display = "none"
                    resetForm()
                    document.querySelector(`#stock_${res['productid']}`).innerHTML = res['stock']
                    // console.log(res['stock'])
                }).catch((err) => {
                    // console.error(err.messages.description)
                    if (err.messages.direction == "") {
                        errorDirection.style.display = "none"

                    } else {
                        errorDirection.style.display = "block"
                        errorDirection.innerHTML = err.messages.direction
                    }
                    if (err.messages.description == "") {
                        errorDescription.style.display = "none"
                    } else {
                        errorDescription.style.display = "block"
                        errorDescription.innerHTML = err.messages.description
                    }
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
                    modal.toggle()

                    blockSelectUser.style.display = "none"
                    errorDirection.style.display = "none"
                    errorDescription.style.display = "none"
                    resetForm()
                    document.querySelector(`#stock_${res['productid']}`).innerHTML = res['stock']
                    // console.log(res['stock'])
                }).catch((err) => {

                    if (err.messages.direction == "") {
                        errorDirection.style.display = "none"

                    } else {
                        errorDirection.style.display = "block"
                        errorDirection.innerHTML = err.messages.direction
                    }
                    if (err.messages.description == "") {
                        errorDescription.style.display = "none"
                    } else {
                        errorDescription.style.display = "block"
                        errorDescription.innerHTML = err.messages.description
                    }
                    // console.error(err.messages.direction)
                    // console.error(err.messages.description)


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