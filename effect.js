
// Intersection Observer to add the fade-in-visible class when sections are in view
document.addEventListener("DOMContentLoaded", function() {
    const sections = document.querySelectorAll(".fade-in");
  
    const observer = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add("fade-in-visible");
          observer.unobserve(entry.target); // Stop observing once it has been seen
        }
      });
    }, {
      threshold: 0.2  // Trigger when 20% of the section is visible
    });
  
    sections.forEach(section => {
      observer.observe(section);
    });
  });
  
  document.querySelectorAll('.buy-btn').forEach(button => {
    button.addEventListener('click', function() {
        const productName = this.getAttribute('data-name');
        const productPrice = this.getAttribute('data-price');
        const productImg = this.getAttribute('data-img');

        document.getElementById('modalName').innerText = productName;
        document.getElementById('modalPrice').innerText = productPrice;
        document.getElementById('modalImg').src = productImg;
    });
});

const products = [
  { "name": "Bracelet 1", "type": "bracelet", "image": "bracelet1.png", "description": "Some quick example text for bracelet 1.", "price": "₱50" },
  { "name": "Necklace 1", "type": "necklace", "image": "necklace1.png", "description": "Some quick example text for necklace 1.", "price": "₱100" },
  { "name": "Earring 1", "type": "earring", "image": "earring1.png", "description": "Some quick example text for earring 1.", "price": "₱30" },
  { "name": "Bracelet 2", "type": "bracelet", "image": "bracelet2.png", "description": "Some quick example text for bracelet 2.", "price": "₱60" },
  { "name": "Necklace 2", "type": "necklace", "image": "necklace2.png", "description": "Some quick example text for necklace 2.", "price": "₱120" },
  { "name": "Earring 2", "type": "earring", "image": "earring2.png", "description": "Some quick example text for earring 2.", "price": "₱40" },
  { "name": "Earring 3", "type": "earring", "image": "earring3.png", "description": "Some quick example text for earring 3.", "price": "₱50" },
  { "name": "Earring 4", "type": "earring", "image": "earring4.png", "description": "Some quick example text for earring 4.", "price": "₱80" },
  { "name": "Bracelet 3", "type": "bracelet", "image": "bracelet3.png", "description": "Some quick example text for bracelet 3.", "price": "₱100" },
  { "name": "Necklace 3", "type": "necklace", "image": "necklace3.png", "description": "Some quick example text for necklace 3.", "price": "₱120" },
  { "name": "Necklace 4", "type": "necklace", "image": "necklace4.png", "description": "Some quick example text for necklace 4.", "price": "₱140" },
  { "name": "Bracelet 4", "type": "bracelet", "image": "bracelet4.png", "description": "Some quick example text for bracelet 4.", "price": "₱90" }
];

const cardContainer = document.getElementById('cardContainer');
const searchInput = document.querySelector('.search__input');
const searchButton = document.querySelector('.search__button');

// Render products to card container
function renderCards(data) {
  cardContainer.innerHTML = '';
  if (data.length === 0) {
    cardContainer.innerHTML = '<p>No items found.</p>';
    return;
  }
  data.forEach((item, index) => {
    cardContainer.innerHTML += `
      <div class="col-md-3 mb-3 card-item" data-type="${item.type}">
        <div class="card h-100" style="border: 1px solid #ce5641; border-radius: 5px; background-color:rgb(255, 255, 255);">
          <img src="${item.image}" class="card-img-top" alt="${item.name}">
          <div class="card-body">
            <h5 class="card-title">${item.name}</h5>
            <p class="card-text">${item.description}</p>
            <p><strong>Price:</strong> ${item.price}</p>
            <button class="btn btn-success add-to-cart-btn" 
                    data-name="${item.name}" 
                    data-price="${item.price}" 
                    data-img="${item.image}">
              Add to Cart
            </button>
            <a href="#" class="btn float-end buy-now-btn" 
               style="background-color:rgb(89, 136, 86); color:rgb(255, 255, 255)" 
               data-index="${index}">
              Buy Now
            </a>
          </div>
        </div>
      </div>
    `;
  });

  // Attach modal event listeners
  const buttons = document.querySelectorAll('.buy-now-btn');
  buttons.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const index = btn.getAttribute('data-index');
      const product = data[index];
      showModal(product);
    });
  });
}

// Initial render
renderCards(products);

// Filter by category
function filterCards(category) {
  if (category === 'all') {
    renderCards(products);
  } else {
    const filtered = products.filter(p => p.type === category);
    renderCards(filtered);
  }
}

// Search by name
searchButton.addEventListener('click', () => {
  const term = searchInput.value.toLowerCase();
  const result = products.filter(item => item.name.toLowerCase().includes(term));
  renderCards(result);
});

// Optional: trigger search on enter key
searchInput.addEventListener('keyup', (e) => {
  if (e.key === 'Enter') searchButton.click();
});

function showModal(product) {
  document.getElementById('modalName').textContent = product.name;
  document.getElementById('modalDescription').textContent = product.description;
  document.getElementById('modalPrice').textContent = product.price;
  document.getElementById('modalImage').src = product.image;
  document.getElementById('modalImage').alt = product.name;

  const modal = new bootstrap.Modal(document.getElementById('buyNowModal'));
  modal.show();
}

let cart = [];

// Function to update cart count
function updateCartCount() {
  document.getElementById('cartCount').innerText = cart.length;
}

// Function to save the cart to localStorage
function saveCart() {
  localStorage.setItem('cart', JSON.stringify(cart));
}

// Function to load the cart from localStorage
function loadCart() {
  const stored = localStorage.getItem('cart');
  if (stored) {
    cart = JSON.parse(stored);
    updateCartCount();
    renderCartModal(); // Re-render the cart modal with the saved items
  }
}

// Load the cart when the page is loaded
document.addEventListener('DOMContentLoaded', loadCart);

// Event listener for dynamically added "Add to Cart" buttons
document.addEventListener('click', function (e) {
  if (e.target.classList.contains('add-to-cart-btn')) {
    const name = e.target.getAttribute('data-name');
    const price = e.target.getAttribute('data-price');
    const img = e.target.getAttribute('data-img');

    // Check if the item already exists in the cart
    const existingProductIndex = cart.findIndex(item => item.name === name);

    if (existingProductIndex !== -1) {
      // If it exists, increase the quantity
      cart[existingProductIndex].quantity += 1;
    } else {
      // If it's a new item, add it to the cart
      cart.push({ name, price, image: img, quantity: 1 });
    }

    // Update cart count, save cart data, and render cart modal
    updateCartCount();
    saveCart();

    // Optionally: You can show a confirmation toast or message here that the item was added
    alert(`${name} added to cart!`);

    // Show the cart modal after adding the item to the cart
    renderCartModal();
  }
});

// Function to show the modal when the "Buy Now" button or icon is clicked
document.addEventListener('click', function (e) {
  // Only trigger the modal for the "Buy Now" button or icon
  if (e.target.classList.contains('buy-now-btn') || e.target.closest('.buy-now-btn')) {
    e.preventDefault(); // Prevent default anchor link behavior
    const index = e.target.getAttribute('data-index') || e.target.closest('.buy-now-btn').getAttribute('data-index');
    const product = products[index];

    // Show the product details modal first, then proceed to checkout
    showModal(product, () => addItemToCartAndGoToCheckout(product));
  }
});

// Function to show the modal with product details
function showModal(product, callback) {
  // Populate the modal with product details
  document.getElementById('modalName').textContent = product.name;
  document.getElementById('modalDescription').textContent = product.description;
  document.getElementById('modalPrice').textContent = product.price;
  document.getElementById('modalImage').src = product.image;
  document.getElementById('modalImage').alt = product.name;

  // Show the modal using Bootstrap
  const modal = new bootstrap.Modal(document.getElementById('buyNowModal'));
  modal.show();

  // Close the modal and proceed after a delay (or use a button click to close manually)
  setTimeout(() => {
    modal.hide();
    if (callback) callback(); // Call the callback to add to cart and proceed to checkout
  }, 3000); // Auto-close the modal after 3 seconds (you can change this duration)
}

// Function to add the item to the cart and redirect to the payment page
function addItemToCartAndGoToCheckout(product) {
  // Check if the product already exists in the cart
  const existingProductIndex = cart.findIndex(item => item.name === product.name);

  if (existingProductIndex !== -1) {
    // If it exists, increase the quantity
    cart[existingProductIndex].quantity += 1;
  } else {
    // If it's a new item, add it to the cart
    cart.push({ name: product.name, price: product.price, image: product.image, quantity: 1 });
  }

  // Save cart and update the count
  saveCart();
  updateCartCount();

  // Optionally: You can show a confirmation toast or message here that the item was added
  alert(`${product.name} added to cart!`);

  // Redirect to payment page after adding the item
  window.location.href = "payment.html"; // Redirect to payment page
}

// Function to render the cart modal
function renderCartModal() {
  const container = document.getElementById('cartItemsContainer');
  const totalPriceContainer = document.getElementById('totalPrice');

  let total = 0;
  let output = '';

  if (cart.length === 0) {
    output = '<p class="text-muted">Your cart is empty.</p>';
    totalPriceContainer.innerHTML = 'Total: ₱0.00';
  } else {
    cart.forEach((item, index) => {
      const price = parseFloat(item.price.replace(/[^0-9.-]+/g, ""));
      total += price * item.quantity;

      output += `
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div class="d-flex align-items-center">
            <img src="${item.image}" alt="${item.name}"
                 style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
            <div>
              <div>${item.name}</div>
              <small>${item.price} × ${item.quantity}</small>
            </div>
          </div>
          <button class="btn btn-sm btn-outline-danger remove-item-btn"
                  data-index="${index}">×</button>
        </li>
      `;
    });

    totalPriceContainer.innerHTML = `Total: ₱${total.toFixed(2)}`;
  }

  container.innerHTML = `<ul class="list-group">${output}</ul>`;
}

// Remove item when its "×" is clicked
document.addEventListener('click', function(e) {
  if (e.target.classList.contains('remove-item-btn')) {
    const idx = parseInt(e.target.getAttribute('data-index'), 10);

    // Remove from cart array
    cart.splice(idx, 1);

    // Persist & re-render everything
    saveCart();
    updateCartCount();
    renderCartModal();
  }
});


// Function to update cart count and save to localStorage
function updateCartCount() {
  document.getElementById('cartCount').innerText = cart.length;
}

// Function to save cart to localStorage
function saveCart() {
  localStorage.setItem('cart', JSON.stringify(cart));
}

// Function to calculate total price
function calculateTotal() {
  let total = 0;
  cart.forEach(item => {
    const price = parseFloat(item.price.replace(/[^0-9.-]+/g, "")); // Remove any non-numeric characters
    total += price * item.quantity;
  });
  return total.toFixed(2); // Return total rounded to 2 decimal places
}

// Event listener for "Buy Now" button
document.addEventListener('click', function (e) {
  if (e.target.classList.contains('buy-now-btn')) {
    // Save the cart and total to localStorage
    const totalAmount = calculateTotal();
    localStorage.setItem('cart', JSON.stringify(cart));
    localStorage.setItem('totalAmount', totalAmount);

    // Redirect to the payment page
    window.location.href = 'payment.html';
  }
});
