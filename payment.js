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

// Initialize modal element
const confirmationModalEl = document.getElementById('confirmationModal');
const confirmationMessageEl = document.getElementById('confirmationMessage');
const modalConfirmBtn = document.getElementById('confirmPaymentButtonInModal');
const triggerBtn = document.getElementById('confirmPaymentButton');

// Initialize the modal with Bootstrap
const confirmationModal = new bootstrap.Modal(confirmationModalEl);

// Show confirmation modal on button click
function showConfirmationModal() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];

    if (cart.length === 0) {
        alert('Your cart is empty. Please add items to your cart before proceeding.');
        return;
    }

    // Calculate total amount
    const totalAmount = cart.reduce((sum, item) => {
        return sum + parseFloat(item.price.replace(/[^0-9.-]+/g, ""));
    }, 0).toFixed(2); // Calculate total price

    // Set the confirmation message dynamically
    confirmationMessageEl.innerText = `Are you sure you want to proceed with the payment of ₱${totalAmount}?`;

    // Show the modal
    confirmationModal.show();

    // Attach a one-time handler for "Confirm Payment" button inside modal
    modalConfirmBtn.addEventListener('click', onModalConfirm, { once: true });
}

// Handle the confirm payment logic inside the modal
function onModalConfirm() {
    // Proceed with payment (this is just a placeholder alert)
    alert('Your payment has been confirmed. Thank you for your purchase!');

    // Clear the cart
    localStorage.removeItem('cart');

    // Clear the form fields
    const paymentForm = document.getElementById('paymentForm');
    paymentForm.reset();

    // Optionally, clear dynamic input containers (like shipping address, postal code)
    document.getElementById('cardInputContainer').classList.add('d-none');
    document.getElementById('gcashInputContainer').classList.add('d-none');
    document.getElementById('codInputContainer').classList.add('d-none');
    document.getElementById('addressContainer').classList.add('d-none');
    document.getElementById('postalCodeContainer').classList.add('d-none');

    // Hide the modal after payment confirmation
    confirmationModal.hide();

    // Optionally, reload the page (if you want to reset everything and reload the UI)
    // location.reload(); // Uncomment this if you want to reload the page after confirmation
}

// Prevent the form from submitting (reload page) and trigger the modal
triggerBtn.addEventListener('click', function(event) {
    event.preventDefault();
    showConfirmationModal();
});

const orderSummary = JSON.parse(localStorage.getItem('orderSummary'));

if (orderSummary) {
    // Set the product details in the payment page
    document.getElementById('paymentImg').src = orderSummary.image;
    document.getElementById('paymentName').innerText = orderSummary.name;
    document.getElementById('paymentPrice').innerText = orderSummary.price;
} else {
    // Handle the case where the order summary is not found in localStorage
    document.getElementById('orderSummary').innerHTML = '<p>No order details found. Please add an item to the cart.</p>';
}