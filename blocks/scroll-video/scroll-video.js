const parent = document.querySelector('.parent');
const child = document.querySelector('.child');
const windowHeight = window.innerHeight;

function updateAnimation() {
  const parentRect = parent.getBoundingClientRect();
  const animationProgress = Math.min(1, Math.max(0, (windowHeight - parentRect.top) / windowHeight));
  
  // Apply animation progress to the custom property
  child.style.setProperty('--animation-progress', animationProgress);
}

// Listen for scroll events
window.addEventListener('scroll', updateAnimation);

// Initial update
updateAnimation();