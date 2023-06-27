// Optional: Pause the slideshow on hover
const slideshow = document.querySelector('.slideshow');
slideshow.addEventListener('mouseover', function() {
  this.style.animationPlayState = 'paused';
});

slideshow.addEventListener('mouseout', function() {
  this.style.animationPlayState = 'running';
});