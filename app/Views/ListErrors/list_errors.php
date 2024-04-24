<?php if (isset($errors) && $errors !== []): ?>
    <div class="errors" role="alert">
        <ul>
            <?php foreach ($errors as $error): ?>
                <div class="alert alert-danger" role="alert">
                    <?= esc($error) ?>
                </div>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>