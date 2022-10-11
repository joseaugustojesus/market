function makePdf(tableId, columnsWidth = []) {
    let body_ = getBody(tableId);

    //dd = document defition
    let dd = {
        content: [{
            layout: 'lightHorizontalLines',
            table: {
                // headers are automatically repeated if the table spans over multiple pages
                // you can declare how many rows should be treated as headers
                headerRows: 1,
                widths: columnsWidth,
                body: body_
            }
        }],
        defaultStyle: {
            fontSize: 10,
            // bold: true
        }
    };
    pdfMake.createPdf(dd).download();
}


function getHeader(tableId) {
    let ths = document.querySelectorAll(`#${tableId} thead tr th`);
    let header = [];
    ths.forEach(th => {
        if (!th.dataset.exclude) {
            header.push(th.innerText);
        }
    });
    return header;
}


function getBody(tableId) {
    let rows = document.querySelectorAll(`#${tableId} tbody tr`);
    let body = [];
    rows.forEach(row => {
        let tds = row.querySelectorAll('td');
        let data = [];
        tds.forEach(td => {
            if (!td.dataset.exclude) {
                data.push(td.innerText);
            }
        });
        body.push(data);
    });
    body.unshift(getHeader(tableId));
    return body;
}