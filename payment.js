// Function to add item to the cart
function addToCart(name, price, image) {
    const product = { name, price, image };

    // Retrieve existing cart or initialize empty array
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.push(product);

    // Save updated cart to localStorage
    localStorage.setItem('cart', JSON.stringify(cart));
}

// Function to render cart items and total on the cart page
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
        const price = parseFloat(item.price.replace(/[^0-9.-]+/g,"")); // Remove currency symbols
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
    totalPriceContainer.innerHTML = `Total: ₱${total.toFixed(2)}`;
});

// Function to render cart items and total on payment page
function renderCartForPayment() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const totalAmount = cart.reduce((sum, item) => {
        return sum + parseFloat(item.price.replace(/[^0-9.-]+/g, "")); // Add item prices
    }, 0).toFixed(2); // Calculate total price

    const cartItemsContainer = document.getElementById('cartItems');
    const totalPriceContainer = document.getElementById('totalPrice');

    // Render cart items
    let output = '';
    if (cart.length === 0) {
        output = '<p class="text-muted">Your cart is empty.</p>';
    } else {
        cart.forEach(item => {
            output += `
                <div class="item d-flex mb-3">
                    <img src="${item.image}" alt="${item.name}" style="width: 60px; height: 60px; object-fit: cover;">
                    <div class="item-details ms-3">
                        <p class="mb-1"><strong>${item.name}</strong></p>
                        <p>${item.price}</p>
                    </div>
                </div>
            `;
        });
    }

    // Set the cart items in the container
    cartItemsContainer.innerHTML = output;

    // Set the total price
    totalPriceContainer.innerHTML = `Total: ₱${totalAmount}`;
}


const paymentMethod = document.getElementById('paymentMethod');
const cardInputContainer = document.getElementById('cardInputContainer');
const gcashInputContainer = document.getElementById('gcashInputContainer');
const codInputContainer = document.getElementById('codInputContainer');
const addressContainer = document.getElementById('addressContainer');
const postalCodeContainer = document.getElementById('postalCodeContainer');

paymentMethod.addEventListener('change', function () {
  // Hide all method-specific fields by default
  cardInputContainer.classList.add('d-none');
  gcashInputContainer.classList.add('d-none');
  codInputContainer.classList.add('d-none');

  // Show address and postal code for all methods
  addressContainer.classList.remove('d-none');
  postalCodeContainer.classList.remove('d-none');

  // Show fields depending on selected method
  if (this.value === 'credit') {
    cardInputContainer.classList.remove('d-none');
  } else if (this.value === 'gcash') {
    gcashInputContainer.classList.remove('d-none');
  } else if (this.value === 'cod') {
    codInputContainer.classList.remove('d-none');
  }
});


