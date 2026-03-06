/* define functions here */

function calculateTotal(quantity, price) {
    return quantity * price;
}

function calculateTax(subtotal, rate) {
    return subtotal * rate;
}

function calculateShipping(subtotal, threshold) {
    if (subtotal > threshold) {
        return 0;
    } else {
        return 40;
    }
}

function calculateGrandTotal(subtotal, tax, shipping) {
    return subtotal + tax + shipping;
}

function outputCurrency(num) {
    document.write('$' + num.toFixed(2));
}

function outputCartRow(file, title, quantity, price, total) {
    document.write('<tr>');
    document.write('  <td><img src="images/' + file + '"></td>');
    document.write('  <td>' + title + '</td>');
    document.write('  <td>' + quantity + '</td>');
    document.write('  <td>');
    outputCurrency(price);
    document.write('</td>');
    document.write('  <td>');
    outputCurrency(total);
    document.write('</td>');
    document.write('</tr>');
}


        
