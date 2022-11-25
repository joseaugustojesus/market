<?php $this->layout('shared/template-dashboard', [
    'css' => ['/sales/interface_sales.css'],
    'js' => ['/index.js', '/menu.js']
]); ?>



<main>
    <h1>Registros de vendas</h1>



    <form action="<?= route('sales/store') ?>" method="POST" id="form" onsubmit="return event.preventDefault();">
        <?= csrf(); ?>
        <div class="card" id="resume-left">
            <h2 class="total">Total <br> R$ <span style="color: green;">0,00</span></h2>

            <div class="form-group w-sm-12">
                <label for="name">Valor recebido <span>*</span></label>
                <input type="text" placeholder="R$ 0,00" onblur="calculateReturn(this.value)" id="inputReturn">
            </div>

            <h2 class="return">Troco <br> R$ <span style="color: red;">0,00</span></h2>

            <button type="button" class="button button-success w-sm-12" style="margin-top: 1rem;" onclick="payment();">Finalizar venda</button>
        </div>

        <div class="card" id="resume-right">
            <div class="form-group w-sm-12">
                <label for="name">Código <span>*</span></label>
                <input type="text" placeholder="Leia o código de barras" autofocus="true" name="code" id="code" value="" onblur="findProduct(this.value)" onkeypress="enterInput(this.value, event)">
            </div>


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

    </form>
</main>


<script>
    window.onload = function() {
        document.querySelector('.direita').remove();
    }


    /* A function that is called when the user presses the enter key. */
    function enterInput(barcode, e) {
        if (e.keyCode == 13) findProduct(barcode);
    }


    /**
     * It finds a product by its barcode and adds it to the table
     * 
     * @return The product information.
     */
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

    /**
     * It takes the quantity of a product, multiplies it by the price of the product and sets the
     * subtotal of the product
     */
    function setQuantity(inputElement) {

        let quantity = (inputElement.value).replaceAll('.', '').replaceAll(',', '.');
        let line = inputElement.parentNode.parentNode;
        let inputPrice = line.querySelector('.price');
        let inputSubtotal = line.querySelector('.subtotal');
        let price = (((inputPrice.value).replaceAll('R$ ', '')).replaceAll('.', '')).replaceAll(',', '.');
        inputSubtotal.value = 'R$ ' + number_format((price * quantity), 2, ',', '.');

        setTotal();
    }

    /* It takes the price of a product, multiplies it by the quantity of the product and sets the
    subtotal of the product. */
    function setPrice(inputElement) {

        let price = (inputElement.value).replaceAll('.', '').replaceAll(',', '.');
        let quantity = ((inputElement.parentNode.parentNode).querySelector('.quantity').value).replaceAll('.', '').replaceAll(',', '.');
        (inputElement.parentNode.parentNode).querySelector('.subtotal').value = `R$ ${number_format(price * quantity, 2, ',', '.')}`;
        setTotal();
    }


    /* Calculating the total of the sale. */
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

        total = number_format(total, 2, ',', '.');
        let list = document.querySelector('#products tbody');
        let lineTotalHTML = `<tr class="cursor-pointer" id="line-total">
                    <td data-label="Código"></td>
                    <td data-label="Produto"></td>
                    <td data-label="Quantidade"></td>
                    <td data-label="Preço"></td>
                    <td data-label="Total"> <input type="text" class="t-center w-sm-12 total_price" readonly name="total_price" value="${total}" id="total_price"> </td>
                </tr>`;
        list.insertAdjacentHTML('beforebegin', lineTotalHTML);

        document.querySelector('#resume-left .total span').innerText = total;

        let inputCode = document.getElementById('code');
        inputCode.focus();
    }


    /* A function that is called when the user clicks on the button to proceed with the sale. It asks
    the user for the amount received from the customer and then submits the form. */
    function payment() {

        let paymentPlain = document.getElementById('inputReturn').value;
        let total = document.querySelector('#resume-left .total span').innerText.replaceAll('.', '').replaceAll(',', '.');

        if (!paymentPlain || paymentPlain === '') {
            Swal.fire({
                icon: 'error',
                title: 'Necessário informar o valor do pagamento',
                showConfirmButton: false,
                timer: 1500
            });
        } else {
            let payment = paymentPlain.replaceAll('.', '').replaceAll(',', '.');
            if (payment < total) {
                Swal.fire({
                    icon: 'error',
                    title: 'O pagamento é insuficiente',
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                document.querySelector('form').submit();
            }
        }
    }


    function calculateReturn(valuePlain) {
        let value = valuePlain.replaceAll('.', '').replaceAll(',', '.');
        let total = document.querySelector('#resume-left .total span').innerText.replaceAll('.', '').replaceAll(',', '.');
        document.querySelector('#resume-left .return span').innerText = number_format(value - total, 2, ',', '.');
    }
</script>