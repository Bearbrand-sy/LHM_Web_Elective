# LHM_Web_Elective
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Image Carousel</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="carousel">
  <div class="slides">
    <img src="https://via.placeholder.com/800x400?text=Slide+1" alt="Slide 1">
    <img src="https://via.placeholder.com/800x400?text=Slide+2" alt="Slide 2">
    <img src="https://via.placeholder.com/800x400?text=Slide+3" alt="Slide 3">
    <img src="https://via.placeholder.com/800x400?text=Slide+4" alt="Slide 4">
    <img src="https://via.placeholder.com/800x400?text=Slide+5" alt="Slide 5">
  </div>
</div>

<script src="script.js"></script>
</body>
</html>

body {
  margin: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #111;
}

.carousel {
  width: 800px;
  height: 400px;
  overflow: hidden;
  border-radius: 10px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.3);
}

.slides {
  display: flex;
  width: calc(800px * 5);
  transition: transform 0.8s ease-in-out;
}

.slides img {
  width: 800px;
  height: 400px;
  object-fit: cover;
}

const slides = document.querySelector('.slides');
const totalSlides = 5;
let index = 0;

setInterval(() => {
  index = (index + 1) % totalSlides;
  slides.style.transform = `translateX(-${index * 800}px)`;
}, 3000);
