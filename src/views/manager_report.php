<main class="content">
    <?php 
        renderTitle(
            'Relatório Gernecial',
            'Resumo das horas trabalhadas dos funcionários',
            'icofont-chart-histogram'
        );
    ?>
    <div class="summary-boxes">
        <div class="summary-box bg-primary">
            <id class="icofont-users"></id>
            <p class="title">Qtde de Funcionários</p>
            <h3 class="value"><?= $activeUsersCount ?></h3>
        </div>
        <div class="summary-box bg-danger">
            <id class="icofont-patient-bed"></id>
            <p class="title">Faltas</p>
            <h3 class="value"><?= count($absentUsers) ?></h3>
        </div>
        <div class="summary-box bg-success">
            <id class="icofont-sand-clock"></id>
            <p class="title">Horas Trabalhadas no Mês</p>
            <h3 class="value"><?= $hoursInMonth ?></h3>
        </div>
    </div>

    <?php if(count($absentUsers) > 0) : ?>
        <div class="card mt-4">
            <div class="card-header">
                <h4 class="card-title">Faltosos do dia</h4>
                <p class="card-category">Relação dos funcionários que ainda não bateram o ponto</p>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <th>Nome</th>
                    </thead>
                    <tbody>
                        <?php foreach ($absentUsers as $name) : ?>
                            <tr>
                                <td><?= $name ?></td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif?>
</main>