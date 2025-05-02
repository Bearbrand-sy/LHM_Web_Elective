
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
  { "name": "3-colored Beads Bracelet", "type": "bracelet", "image": "brace1.png", "price": "₱50" },
  { "name": "Necklace 1", "type": "necklace", "image": "neck1.png", "description": "Some quick example text for necklace 1.", "price": "₱100" },
  { "name": "Earring 1", "type": "earring", "image": "ear1.png", "description": "Some quick example text for earring 1.", "price": "₱30" },
  { "name": "Black Bracelet", "type": "bracelet", "image": "brace2.png", "price": "₱60" },
  { "name": "Necklace 2", "type": "necklace", "image": "necklace2.png", "description": "Some quick example text for necklace 2.", "price": "₱120" },
  { "name": "Earring 2", "type": "earring", "image": "earring2.png", "description": "Some quick example text for earring 2.", "price": "₱40" },
  { "name": "Earring 3", "type": "earring", "image": "earring3.png", "description": "Some quick example text for earring 3.", "price": "₱50" },
  { "name": "Earring 4", "type": "earring", "image": "earring4.png", "description": "Some quick example text for earring 4.", "price": "₱80" },
  { "name": "Flower Bead Bracelet ", "type": "bracelet", "image": "brace3.png",  "price": "₱100" },
  { "name": "Necklace 3", "type": "necklace", "image": "necklace3.png", "description": "Some quick example text for necklace 3.", "price": "₱120" },
  { "name": "Necklace 4", "type": "necklace", "image": "necklace4.png", "description": "Some quick example text for necklace 4.", "price": "₱140" },
  { "name": "Heart Black Bracelet", "type": "bracelet", "image": "brace4.png", "description": "Some quick example text for bracelet 4.", "price": "₱90" }
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
      <div class="col-md-6 mb-6 card-item" data-type="${item.type}">
        <div class="card h-50" style="border: 1px solid #ce5641; border-radius: 5px; background-color:rgb(255, 255, 255);">
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


// Cart
let cart = [];

function renderCards(data) {
  const cardContainer = document.getElementById('cardContainer');
  cardContainer.innerHTML = data.length ? '' : '<p>No items found.</p>';

  data.forEach((item, index) => {
    cardContainer.innerHTML += `
      <div class="col-md-4 mb-3 card-item" data-type="${item.type}">
        <div class="card h-100" style="border: 1px solid #ce5641; border-radius: 5px; background-color: rgb(238, 238, 224);">
          <img src="${item.image}" class="card-img-top" alt="${item.name}" style="height: 10rem; object-fit: contain;">
          <div class="card-body">
            <h5 class="card-title" style="font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif ;">${item.name}</h5>
            <p  style="font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif ;"><strong>Price:</strong> ${item.price}</p>
            <button class="btn add-to-cart-btn" data-name="${item.name}" data-price="${item.price}" data-img="${item.image}" 
                    style="background-color:rgb(238, 156, 131); color: white; border: none; padding: 10px 20px; font-size: 12px; 
                    border-radius: 5px; cursor: pointer; transition: background-color 0.3s, transform 0.3s;">
              Add to Cart
            </button>
            <a href="#" class="btn float-end buy-now-btn" style="background-color:rgb(51, 161, 43); color:rgb(255, 255, 255)" data-index="${index}">Buy Now</a>
          </div>
        </div>
      </div>`;
  });



  document.querySelectorAll('.buy-now-btn').forEach(btn => {
    btn.addEventListener('click', e => {
      e.preventDefault();
      const product = data[btn.getAttribute('data-index')];
      showModal(product, () => addItemToCartAndGoToCheckout(product));
    });
  });
}

function showModal(product, callback = null) {
  document.getElementById('modalName').textContent = product.name;
  document.getElementById('modalDescription').textContent = product.description;
  document.getElementById('modalPrice').textContent = product.price;
  document.getElementById('modalImage').src = product.image;
  document.getElementById('modalImage').alt = product.name;

  const modal = new bootstrap.Modal(document.getElementById('buyNowModal'));
  modal.show();

  if (callback) {
    setTimeout(() => {
      modal.hide();
      callback();
    }, 3000);
  }
}

function addItemToCartAndGoToCheckout(product) {
  const existing = cart.find(item => item.name === product.name);
  if (existing) existing.quantity += 1;
  else cart.push({ name: product.name, price: product.price, image: product.image, quantity: 1 });

  saveCart();
  updateCartCount();
  alert(`${product.name} added to cart!`);
  window.location.href = "payment.html";
}

// Cart utilities
function updateCartCount() {
  document.getElementById('cartCount').innerText = cart.length;
}

function saveCart() {
  localStorage.setItem('cart', JSON.stringify(cart));
}

function loadCart() {
  const stored = localStorage.getItem('cart');
  if (stored) {
    cart = JSON.parse(stored);
    updateCartCount();
    renderCartModal();
  }
}

function renderCartModal() {
  const container = document.getElementById('cartItemsContainer');
  const totalPriceContainer = document.getElementById('totalPrice');

  if (!cart.length) {
    container.innerHTML = '<p class="text-muted">Your cart is empty.</p>';
    totalPriceContainer.innerHTML = 'Total: ₱0.00';
    return;
  }

  let total = 0;
  const itemsHTML = cart.map((item, index) => {
    const price = parseFloat(item.price.replace(/[^\d.-]+/g, ""));
    total += price * item.quantity;
    return `
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
          <img src="${item.image}" alt="${item.name}" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
          <div>
            <div>${item.name}</div>
            <small>${item.price} × ${item.quantity}</small>
          </div>
        </div>
        <button class="btn btn-sm btn-outline-danger remove-item-btn" data-index="${index}">×</button>
      </li>`;
  }).join("");

  container.innerHTML = `<ul class="list-group">${itemsHTML}</ul>`;
  totalPriceContainer.innerHTML = `Total: ₱${total.toFixed(2)}`;
}

// Event delegation for cart actions
document.addEventListener('click', function (e) {
  // Add to cart
  if (e.target.classList.contains('add-to-cart-btn')) {
    const name = e.target.getAttribute('data-name');
    const price = e.target.getAttribute('data-price');
    const img = e.target.getAttribute('data-img');

    const existing = cart.find(item => item.name === name);
    if (existing) existing.quantity += 1;
    else cart.push({ name, price, image: img, quantity: 1 });

    saveCart();
    updateCartCount();
    alert(`${name} added to cart!`);
    renderCartModal();
  }

  // Remove from cart
  if (e.target.classList.contains('remove-item-btn')) {
    const idx = parseInt(e.target.getAttribute('data-index'), 10);
    cart.splice(idx, 1);
    saveCart();
    updateCartCount();
    renderCartModal();
  }
});

// Proceed to Payment
document.getElementById('proceedToPaymentBtn')?.addEventListener('click', () => {
  const selectedProduct = {
    name: document.getElementById('modalName').textContent,
    price: document.getElementById('modalPrice').textContent,
    image: document.getElementById('modalImage').src
  };
  localStorage.setItem('selectedProduct', JSON.stringify(selectedProduct));
});

document.getElementById('checkoutButton')?.addEventListener('click', function () {
  const cart = JSON.parse(localStorage.getItem('cart')) || [];

  if (cart.length === 0) {
    alert('Your cart is empty. Please add items before checking out.');
  } else {
    window.location.href = 'payment.html';
  }
});




// Sign-up form submission handler
document.getElementById('signupForm').addEventListener('submit', function(event) {
  event.preventDefault();

  // Get the form input values
  const username = document.getElementById('usernameInput').value;
  const email = document.getElementById('emailInput').value;  // Optional, if you want to save email too
  const password = document.getElementById('passwordInput').value;

  // Save the user data in localStorage
  localStorage.setItem('user', JSON.stringify({
    username: username,
    email: email,
    password: password
  }));

  alert('Account created successfully!');
  
  // Close the sign-up modal
  var signupModal = new bootstrap.Modal(document.getElementById('signupModal'));
  signupModal.hide();

  // Optionally, auto-open login modal after sign-up
  var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
  loginModal.show();
});

// Login form submission handler
document.getElementById('loginForm').addEventListener('submit', function(event) {
  event.preventDefault();

  // Get the login input values
  const loginUsername = document.getElementById('loginUsernameInput').value;
  const loginPassword = document.getElementById('loginPasswordInput').value;

  // Retrieve user data from localStorage
  const userData = JSON.parse(localStorage.getItem('user'));

  // Check if the credentials match
  if (userData && userData.username === loginUsername && userData.password === loginPassword) {
    alert('Login successful!');
  } else {
    alert('Invalid username or password.');
  }
});


// Sign-up form submission handler
document.getElementById('signupForm').addEventListener('submit', function(event) {
  event.preventDefault();

  // Get the form input values
  const username = document.getElementById('usernameInput').value;
  const email = document.getElementById('emailInput').value;
  const password = document.getElementById('passwordInput').value;

  // Save the user data in localStorage
  localStorage.setItem('user', JSON.stringify({
    username: username,
    email: email,
    password: password
  }));

  // Close the sign-up modal
  var signupModal = new bootstrap.Modal(document.getElementById('signupModal'));
  signupModal.hide();

  // Show an alert to inform the user that the account was created
  alert('Your account has been created successfully! You can now log in.');
});



// Utility to update account icon dropdown with username
function updateAccountUI(username) {
  document.getElementById('loginIcon').style.display = 'none';
  document.getElementById('accountDropdown').style.display = 'block';
  document.getElementById('accountUsername').textContent = username;
}

// Load user data from localStorage on page load
function loadUser() {
  const user = JSON.parse(localStorage.getItem('user'));
  if (user && user.username) {
    updateAccountUI(user.username);
  } else {
    document.getElementById('loginIcon').style.display = 'block';
    document.getElementById('accountDropdown').style.display = 'none';
  }
}

// Logout function
document.getElementById('logoutBtn').addEventListener('click', function () {
  localStorage.removeItem('user');
  location.reload(); // Reload to reset UI
});

// Run on page load
window.onload = loadUser;


