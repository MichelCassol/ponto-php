<main class="content">
    <?php 
        renderTitle(
            'Cadastro de usuários',
            'Mantenha os dados dos usuários atualizados',
            'icofont-users'
        );

        include(TEMPLATE_PATH . "/messages.php");
    ?>

    <a class="btn btn-lg btn-primary mt-3 mb-3" href="save_user.php">Novo Usuário</a>

    <table class="table table-bordered table-striped table-hover">
        <thead>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Data de Admissão</th>
            <th>Data de Desligamento</th>
            <th>Ações</th>
        </thead>
        <tbody>
            <?php foreach($users as $user) : ?>
                <tr>
                    <td><?= $user->name ?></td>
                    <td><?= $user->email ?></td>
                    <td><?= $user->start_date ?></td>
                    <td><?= $user->end_date ?></td>
                    <td>
                        <a href="save_user.php?update=<?= $user->id ?>" class="btn btn-warning rounded-circle mr-2">
                            <i class="icofont-edit"></i>
                        </a>
                        <a href="users.php?delete=<?= $user->id ?>" class="btn btn-danger rounded-circle" onclick="confirmarExclusao(event, '<?= $user->id ?>')">
                            <i class="icofont-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</main>