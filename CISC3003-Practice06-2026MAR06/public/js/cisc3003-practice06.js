/* add loop and other code here ... in this simple exercise we are not
   going to concern ourselves with minimizing globals, etc */

   var subtotal = 0;

   // 1. Loop through the arrays and output each cart row
   for (var i = 0; i < filenames.length; i++) {
       var total = calculateTotal(quantities[i], prices[i]);
       subtotal += total;
       outputCartRow(filenames[i], titles[i], quantities[i], prices[i], total);
   }

   // 2. Calculate tax, shipping, and grand total
   // Tax rate is 10% (0.10), Shipping threshold is $1000
   var tax = calculateTax(subtotal, 0.10);
   var shipping = calculateShipping(subtotal, 1000);
   var grandTotal = calculateGrandTotal(subtotal, tax, shipping);

   // 3. Output the totals rows
   document.write('<tr class="totals">');
   document.write('  <td colspan="4">Subtotal</td>');
   document.write('  <td>');
   outputCurrency(subtotal);
   document.write('</td>');
   document.write('</tr>');

   document.write('<tr class="totals">');
   document.write('  <td colspan="4">Tax</td>');
   document.write('  <td>');
   outputCurrency(tax);
   document.write('</td>');
   document.write('</tr>');

   document.write('<tr class="totals">');
   document.write('  <td colspan="4">Shipping</td>');
   document.write('  <td>');
   outputCurrency(shipping);
   document.write('</td>');
   document.write('</tr>');

   document.write('<tr class="totals focus">');
   document.write('  <td colspan="4">Grand Total</td>');
   document.write('  <td>');
   outputCurrency(grandTotal);
   document.write('</td>');
   document.write('</tr>');

