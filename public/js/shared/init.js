// const APP__BASE__URL = `${window.location.protocol}//${window.location.host}/${window.location.pathname.split('/')[1]}/${window.location.pathname.split('/')[2]}`;
const APP__BASE__URL = `${window.location.protocol}//${window.location.host}`;


const alertList = document.querySelectorAll('.alert');
const alerts = [...alertList].map(element => new bootstrap.Alert(element));
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))



function toast(text, background) {
    Toastify({
        text: text,
        gravity: 'bottom',
        style: {
            background: background,
        },
        close: true,
    }).showToast();
}

function exportToExcel(tableId) {
    TableToExcel.convert(document.getElementById(tableId));
}

function valueToInput(id, value) {
    document.getElementById(id).value = value;
}


function findItem(elm) {
    let value = elm.value;

    let url = `${APP__BASE__URL}/api/items/findInLogix`;
    fetch(url, {
            method: 'POST',
            body: JSON.stringify({
                codeItem: value
            }),
            headers: {
                'Content-type': 'application/json; charset=UTF-8',
            }
        })
        .then(response => response.json())
        .then(data => {
            let status = data.status;
            if (status !== 200) {
                toast(`🔔 ${data.message}`, '#FF1E00');
                elm.value = '';
                valueToInput('description', '');
            } else {
                // FV30987
                toast('🔔 Item encontrado com sucesso', '#59CE8F');
                valueToInput('description', data.description);
            }
        });
}

function number_format(number, decimals, dec_point, thousands_point) {

    if (number == null || !isFinite(number)) {
        throw new TypeError("number is not valid");
    }

    if (!decimals) {
        var len = number.toString().split('.').length;
        decimals = len > 1 ? len : 0;
    }

    if (!dec_point) {
        dec_point = '.';
    }

    if (!thousands_point) {
        thousands_point = ',';
    }

    console.log(number);
    number = parseFloat(number).toFixed(decimals);
    console.log(number);

    number = number.replace(".", dec_point);

    var splitNum = number.split(dec_point);
    splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
    number = splitNum.join(dec_point);

    return number;
}