function addToCart(name, price, image) {
    const product = { name, price, image };

    // Retrieve existing cart or initialize empty array
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.push(product);

    // Save updated cart to localStorage
    localStorage.setItem('cart', JSON.stringify(cart));

    updateCartCount();
    alert(`${name} has been added to your cart.`);
}


window.addEventListener('DOMContentLoaded', () => {
    const cartItemsContainer = document.getElementById('cartItems');
    const totalPriceContainer = document.getElementById('totalPrice');
    
    const cart = JSON.parse(localStorage.getItem('cart')) || [];

    let total = 0;
    let output = '';

    if (cart.length === 0) {
      output = '<p>Your cart is empty.</p>';
    } else {
      cart.forEach(item => {
        const price = parseFloat(item.price.replace(/[^0-9.-]+/g,"")); // remove currency symbols
        total += price;

        output += `
          <div class="item d-flex mb-3">
            <img src="${item.image}" alt="${item.name}" style="width: 60px; height: 60px; border-radius: 5px;">
            <div class="item-details ms-3">
              <p class="mb-1"><strong>${item.name}</strong></p>
              <p>${item.price}</p>
            </div>
          </div>
        `;
      });
    }

    cartItemsContainer.innerHTML = output;
    totalPriceContainer.innerHTML = `Total: $${total.toFixed(2)}`;
  });


  localStorage.removeItem('cart');