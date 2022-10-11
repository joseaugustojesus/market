<?php $this->layout('shared/template-dashboard', [
    'css' => ['/sales/index.css'],
    'js' => ['/index.js', '/menu.js']
]); ?>



<main>
    <h1>Vendas</h1>

    <?php if ($devolution = getSession('devolution')) { ?>
        <div class="alert">
            <p>A venda foi realizada com sucesso e o troco é de <strong>R$ <?= $devolution ?></strong></p>
        </div>
    <?php } ?>

    <form action="<?= route('sales/store') ?>" method="POST" id="form" onsubmit="return event.preventDefault();">
        <div class="card">
            <?= csrf(); ?>

            <div class="form-group w-sm-12">
                <label for="name">Código do produto <span>*</span></label>
                <input type="text" placeholder="Leia o código de barras" autofocus='true' name="code" id="code" onchange="findProduct(this.value)">
            </div>

            <div class="w-sm-12 sale-finish">
                <button type="button" class="button button-success" onclick="payment()">Finalizar venda</button>
            </div>
        </div>


        <div class="card">
            <table id="products">
                <!-- <caption>Lista de produtos cadastrados</caption> -->
                <thead>
                    <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Produto</th>
                        <th scope="col">Quantidade</th>
                        <th scope="col">Preço</th>
                        <th scope="col">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aqui será renderizado os itens -->

                </tbody>
            </table>
        </div>

        <input type="hidden" name="client_payment" id="clientPayment">
    </form>
</main>


<script>
    function findProduct(barcode) {
        if (!barcode || barcode === '') {
            toast('🔔 O código de barras é obrigatório', '#FF1E1E');
            return;
        }

        let inputBarcode = document.getElementById('code');
        let endpoint = `${APP__BASE__URL}/products/find/${barcode}`;
        let table = document.getElementById('products');
        fetch(endpoint)
            .then(response => response.json())
            .then(data => {
                inputBarcode.value = '';
                if (data.status !== 200) toast(data.message, '#FF1E1E');
                else {
                    table.querySelector('tbody').innerHTML += `<tr class="cursor-pointer product-in-list">
                    <td data-label="Código"> <input type="text" class="t-center w-sm-12 code" readonly name="codes[]" value="${data.product.code}"> </td>
                    <td data-label="Produto"> <input type="text" class="t-center w-sm-12 product" readonly name="products[]" value="${data.product.name}"> </td>
                    <td data-label="Quantidade"> <input type="text" class="t-center w-sm-12 quantity" name="quantities[]" value="${1}" onchange="setQuantity(this)"> </td>
                    <td data-label="Preço"> <input type="text" class="t-center w-sm-12 price" name="prices[]" value="${data.product.price}" onchange="setPrice(this)"> </td>
                    <td data-label="Subtotal"> <input type="text" class="t-center w-sm-12 subtotal" readonly name="subtotals[]" value="${data.product.price}"> </td>
                </tr>`;
                }
                setTotal();
            });
    }

    function setQuantity(inputElement) {

        let quantity = (inputElement.value).replaceAll('.', '').replaceAll(',', '.');
        let line = inputElement.parentNode.parentNode;
        let inputPrice = line.querySelector('.price');
        let inputSubtotal = line.querySelector('.subtotal');
        let price = (((inputPrice.value).replaceAll('R$ ', '')).replaceAll('.', '')).replaceAll(',', '.');
        inputSubtotal.value = 'R$ ' + number_format((price * quantity), 2, ',', '.');

        setTotal();
    }

    function setPrice(inputElement) {

        let price = (inputElement.value).replaceAll('.', '').replaceAll(',', '.');
        let quantity = ((inputElement.parentNode.parentNode).querySelector('.quantity').value).replaceAll('.', '').replaceAll(',', '.');
        (inputElement.parentNode.parentNode).querySelector('.subtotal').value = `R$ ${number_format(price * quantity, 2, ',', '.')}`;
        setTotal();
    }


    function setTotal() {
        let lineTotal = document.getElementById('line-total');
        if (lineTotal) lineTotal.remove();


        let products = document.querySelectorAll('.product-in-list');
        let total = 0;
        for (const product of products) {
            let inputQuantity = product.querySelector('.quantity').value.replaceAll('.', '').replaceAll(',', '.');
            let inputPrice = product.querySelector('.price').value;

            let price = (((inputPrice).replaceAll('R$ ', '')).replaceAll('.', '')).replaceAll(',', '.');
            total += (inputQuantity) * price;
        }

        total = 'R$ ' + number_format(total, 2, ',', '.');
        let list = document.querySelector('#products tbody');
        let lineTotalHTML = `<tr class="cursor-pointer" id="line-total">
                    <td data-label="Código"></td>
                    <td data-label="Produto"></td>
                    <td data-label="Quantidade"></td>
                    <td data-label="Preço"></td>
                    <td data-label="Total"> <input type="text" class="t-center w-sm-12 total_price" readonly name="total_price" value="${total}" id="total_price"> </td>
                </tr>`;
        list.insertAdjacentHTML('beforebegin', lineTotalHTML);

        let inputCode = document.getElementById('code');
        inputCode.focus();
    }


    async function payment() {
        const {
            value: clientPayment
        } = await Swal.fire({
            title: 'Valor recebido',
            input: 'text',
            inputLabel: 'Qual o valor recebido do cliente?',
            inputPlaceholder: 'R$ 0,00 (Somente números)',
            confirmButtonText: 'Prosseguir com a venda',
        })

        if (clientPayment) {
            document.getElementById('clientPayment').value = clientPayment;
            document.querySelector('form').submit();
        }
    }
</script>