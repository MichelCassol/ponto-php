<main class="content">
    <?php 
        renderTitle(
            'Cadastro de Usuário',
            'Crie e atualize o usuário',
            'icofont-user'
        );

        include(TEMPLATE_PATH . '/messages.php');
    ?>

    <form method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">Nome</label>
                <input type="text" name="name" id="name" placeholder="Informe o nome" class="form-control <?= $errors['name'] ? 'is-invalid' : ''?>">
                <div class="invalid-feedback">
                    <?= $errors['name'] ?>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="email"></label>
                <input type="text" name="email" id="email" placeholder="Informe o e-mail" class="form-control <?= $errors['email'] ? 'is-invalid' : ''?>">
                <div class="invalid-feedback">
                    <?= $errors['email'] ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">Nome</label>
                <input type="text" name="name" id="name" placeholder="Informe o nome" class="form-control <?= $errors['name'] ? 'is-invalid' : ''?>">
                <div class="invalid-feedback">
                    <?= $errors['name'] ?>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for=""></label>
                <input type="text" name="" id="" placeholder="" class="form-control <?= $errors[''] ? 'is-invalid' : ''?>">
                <div class="invalid-feedback">
                    <?= $errors[''] ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">Nome</label>
                <input type="text" name="name" id="name" placeholder="Informe o nome" class="form-control <?= $errors['name'] ? 'is-invalid' : ''?>">
                <div class="invalid-feedback">
                    <?= $errors['name'] ?>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for=""></label>
                <input type="text" name="" id="" placeholder="" class="form-control <?= $errors[''] ? 'is-invalid' : ''?>">
                <div class="invalid-feedback">
                    <?= $errors[''] ?>
                </div>
            </div>
        </div>
    </form>
</main>