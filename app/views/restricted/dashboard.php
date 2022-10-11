<?php $this->layout('shared/template-dashboard', [
    'css' => [],
    'js' => ['/index.js', '/menu.js'],
    'lastSales' => $lastSales
]); ?>



<main>
    <h1>Dashboard</h1>
    

    <div class="relatorios">

        <div class="vendas">
            <span class="material-icons-sharp">analytics</span>
            <div class="meio">
                <div class="esquerda">
                    <h3>Total de Vendas</h3>
                    <h1>R$ 0,00</h1>
                </div>
            </div>
            <small class="legendas">Valor referente as últimas <b>24 horas</b></small>
        </div>


        <div class="gastos">
            <span class="material-icons-sharp">
                bar_chart
            </span>
            <div class="meio">
                <div class="esquerda">
                    <h3>Valor de produtos disponíveis</h3>
                    <h1>R$ 0,00</h1>
                </div>
            </div>
            <small class="legendas">Este valor é a somatória referente ao <b>estoque x preço</b> de cada produto</small>
        </div>


        <div class="receita">
            <span class="material-icons-sharp">
                stacked_line_chart
            </span>
            <div class="meio">
                <div class="esquerda">
                    <h3>Receita Total</h3>
                    <h1>R$ 0,00</h1>
                </div>
            </div>
            <small class="legendas">Valor referente de todas as vendas</small>
        </div>


    </div>
    <div class="pedidos-recentes">
        <h2>Produtos em menor estoque</h2>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Produto</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($products) and count($products)) { ?>
                    <?php foreach($products as $index => $product) { ?>
                        <tr>
                            <td><?= $product->code ?></td>
                            <td><?= $product->name ?></td>
                            <td>R$ <?= numberBR($product->price) ?></td>
                            <td><?= $product->inventory ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
        <a href="<?= route('products') ?>">Visualizar todos os produtos</a>
    </div>
</main>