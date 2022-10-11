<?php $this->layout('shared/template-dashboard', [
    'css' => ['/sales/all.css'],
    'js' => ['/index.js', '/menu.js']
]); ?>



<main>
    <h1>LISTA DE VENDAS GERAIS</h1>

    <div class="card">
        <table id="sales">
            <thead>
                <tr>
                    <th scope="col">N° Venda</th>
                    <th scope="col">Subtotal</th>
                    <th scope="col">Desconto</th>
                    <th scope="col">Total</th>
                    <th scope="col">Responsável</th>
                </tr>
            </thead>
            <tbody>

                <?php if (isset($sales) and count($sales)) { ?>
                    <?php foreach ($sales as $index => $sale) { ?>
                        <tr class="cursor-pointer" onclick="handleForm(this, 'edit')">
                            <td data-label="Código"><?= $sale->id ?></td>
                            <td data-label="Produto">R$ <?= numberBR($sale->subtotal) ?></td>
                            <td data-label="Estoque">R$ <?= numberBR($sale->discount) ?></td>
                            <td data-label="Unidade Medida">R$ <?= numberBR($sale->total) ?></td>
                            <td data-label="Preço"><?= $sale->user_name ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="5" class="f-bold">Escaneie o código de barras do produto para adicionar</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?= $pagination->links(); ?>
    </div>
</main>