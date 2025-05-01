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