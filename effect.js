
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
