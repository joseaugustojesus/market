<?php $this->layout('shared/template-dashboard', [
    'css' => ['/products/index.css'],
    'js' => ['/index.js', '/menu.js']
]); ?>



<main>
    <h1>Produtos</h1>

    <form class="card" action="<?= route('products/store') ?>" method="POST">
        <?= csrf(); ?>

        <div class="form-group w-sm-12 w-md-6">
            <label for="name">Código <span>*</span></label>
            <input type="text" placeholder="Leia o código de barras" autofocus='true' name="code" id="code" value="<?= old('code') ?>">
        </div>

        <div class="form-group w-sm-12 w-md-6">
            <label for="name">Nome <span>*</span></label>
            <input type="text" placeholder="Exemplo: Coca-Cola 2L (PET)" name="name" id="name" value="<?= old('name') ?>">
        </div>

        <div class="form-group w-sm-12 w-md-4">
            <label for="name">Quantidade <span>*</span></label>
            <input type="text" placeholder="Exemplo: 5 ou 10,2" name="inventory" id="inventory" value="<?= old('inventory') ?>">
        </div>

        <div class="form-group w-sm-12 w-md-4">
            <label for="name">Unid. Medida <span>*</span></label>
            <select name="unit" id="unit">
                <option value="un" <?= old('unit') === 'un' ? 'selected' : '' ?>>Unidade</option>
                <option value="kg" <?= old('unit') === 'kg' ? 'selected' : '' ?>>Kilo</option>
            </select>
        </div>


        <div class="form-group w-sm-12 w-md-4">
            <label for="name">Valor <span>*</span></label>
            <input type="text" placeholder="R$ 0,00" name="price" id="price" value="<?= old('price') ?>">
        </div>

        <div class="w-sm-12">
            <button type="button" class="button button-danger margin-top-6 display-none" id="buttonDelete">Deletar</button>
            <button type="button" class="button button-primary margin-top-6 display-none" id="buttonUpdate" onclick="window.location.reload()">Cancelar</button>
            <button type="submit" class="button button-success margin-top-6" id="buttonSave">Salvar produto</button>
        </div>
    </form>



    <div class="card">
        <table>
            <!-- <caption>Lista de produtos cadastrados</caption> -->
            <thead>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Produto</th>
                    <th scope="col">Estoque</th>
                    <th scope="col">Unidade Medida</th>
                    <th scope="col">Preço</th>
                </tr>
            </thead>
            <tbody>

                <?php if (isset($products) and count($products)) { ?>
                    <?php foreach ($products as $index => $product) { ?>
                        <tr class="cursor-pointer" onclick="handleForm(this, 'edit')">
                            <td data-label="Código" class="code"><?= $product->code ?></td>
                            <td data-label="Produto" class="product"><?= $product->name ?></td>
                            <td data-label="Estoque" class="inventory"><?= numberBR($product->inventory) ?></td>
                            <td data-label="Unidade Medida" class="unit"><?= $product->unit ?></td>
                            <td data-label="Preço" class="price">R$ <?= numberBR($product->price) ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>

            </tbody>
        </table>

        <?php if (isset($pagination)) { ?>
            <?= $pagination->links(); ?>
        <?php } ?>
    </div>
</main>


<script>
    function handleForm(element, type) {
        const form = document.querySelector('form');
        if (type === 'edit') {
            let data = {
                code: element.querySelector('.code').innerText,
                product: element.querySelector('.product').innerText,
                inventory: element.querySelector('.inventory').innerText,
                unit: element.querySelector('.unit').innerText,
                price: (element.querySelector('.price').innerText).replace('R$ ', '')
            };
            const inputs = form.elements;
            inputs['code'].value = data.code;
            inputs['name'].value = data.product;
            inputs['inventory'].value = data.inventory;
            inputs['unit'].value = data.unit;
            inputs['price'].value = data.price;
            handleAction('edit', data.code);
        }
    }

    function handleAction(type, productCode) {
        if (type === 'edit') {
            let buttonDelete = document.getElementById('buttonDelete');
            document.getElementById('buttonSave').innerText = "Editar";
            document.getElementById('buttonUpdate').classList.remove('display-none');
            buttonDelete.classList.remove('display-none');
            buttonDelete.setAttribute('onclick', `productDelete(${productCode})`);
            document.querySelector('form').setAttribute('action', `/products/update/${productCode}`);
        }
    }


    function productDelete(productCode) {
        Swal.fire({
            title: 'Deseja remover o produto?',
            text: "Caso delete, não será possível adicionar em alguma venda",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, remover produto',
            confirmButtonColor: '#3CCF4E',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = `/products/delete/${productCode}`;
            }
        })
    }
</script>

<?php if (getSession('validateUpdate')) {
    $productCode = old('code');
    echo "<script>handleAction('edit', {$productCode})</script>";
} ?>

<?php forgetSessions(['validateUpdate']); ?>