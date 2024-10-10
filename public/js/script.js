document.addEventListener('DOMContentLoaded', function() {
    const quantityInputs = document.querySelectorAll('.input-text.qty');
    const overallTotalElement = document.querySelector('#overallTotal');

    // Update the total price based on the quantity
    function updateTotalPrice(quantityInput) {
        const productPrice = parseFloat(quantityInput.dataset.price);
        const quantity = parseInt(quantityInput.value);
        const totalPriceElement = quantityInput.closest('tr') ? 
            quantityInput.closest('tr').querySelector('.item-total') : 
            document.querySelector('#totalPrice');
        const totalPrice = (quantity * productPrice).toFixed(2);
        totalPriceElement.textContent = totalPrice;
        updateOverallTotal();
    }

    function updateOverallTotal() {
        let overallTotal = 0;
        document.querySelectorAll('.item-total').forEach(item => {
            overallTotal += parseFloat(item.textContent) || 0;
        });
        if (overallTotalElement) {
            overallTotalElement.textContent = overallTotal.toFixed(2);
        }
    }

    // Attach event listeners to each quantity input and button
    quantityInputs.forEach(quantityInput => {
        const minusButton = quantityInput.closest('tr') ? 
            quantityInput.closest('tr').querySelector('.minus') : 
            document.querySelector('.minus');
        const plusButton = quantityInput.closest('tr') ? 
            quantityInput.closest('tr').querySelector('.plus') : 
            document.querySelector('.plus');

        // Decrement quantity
        minusButton.addEventListener('click', function() {
            let quantity = parseInt(quantityInput.value);
            if (quantity > 1) {
                quantityInput.value = quantity - 1;
                updateTotalPrice(quantityInput);
            }
        });

        // Increment quantity
        plusButton.addEventListener('click', function() {
            let quantity = parseInt(quantityInput.value);
            if (!isNaN(quantity) && quantity < parseInt(quantityInput.max)) {
                quantityInput.value = quantity + 1;
                updateTotalPrice(quantityInput);
            }
        });

        // Trigger price update when quantity changes manually
        quantityInput.addEventListener('change', function() {
            let quantity = parseInt(quantityInput.value);
            if (isNaN(quantity) || quantity < 1) {
                quantityInput.value = 1;
            } else if (quantity > parseInt(quantityInput.max)) {
                quantityInput.value = quantityInput.max;
            }
            updateTotalPrice(quantityInput);
        });
    });
});

