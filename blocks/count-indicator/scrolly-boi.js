

document.addEventListener("DOMContentLoaded", () => {
  // Get all elements with the class .wp-block-beech-count-indicator
  const indicatorElements = document.querySelectorAll(
    ".wp-block-beech-count-indicator"
  );

  // Get the .scrolly-boi element
  const scrollyBoi = document.querySelector(".scrolly-boi");

  // Options for the Intersection Observer
  const options = {
    threshold: 0.75, // Adjust threshold as needed
  };

  let previousElement = null;
  let scrollyBoiActive = false;

  
  // Intersection Observer callback function
  const handleIntersection = (entries, observer) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        // Update text and add/remove 'active' class based on the entry's attributes
        const sectionText = entry.target.getAttribute("data-section-text");
        scrollyBoi.textContent = sectionText;

        if (entry.target.classList.contains("is-style-start")) {
          scrollyBoi.classList.add("active");
          scrollyBoiActive = true;

        } else if (entry.target.classList.contains("is-style-end")) {
          scrollyBoi.classList.remove("active");
          scrollyBoiActive = false;
        }

        previousElement = entry.target;
      }

      if(entry.target.classList.contains('is-style-start')) {        
        if (
          entry.target === previousElement &&
          entry.isVisible === false &&
          entry.isIntersecting === false &&
          entry.boundingClientRect.top > 0
        ) {
          scrollyBoi.classList.remove("active");
        }
      }

      if(entry.target.classList.contains('is-style-end')) {
        if (
          entry.isVisible === false &&
          entry.isIntersecting === false &&
          entry.boundingClientRect.top > 0
        ) {
          scrollyBoi.classList.add("active");
        }
      }
    });
  };
  
  // Create Intersection Observer
  const observer = new IntersectionObserver(handleIntersection, options);

  // Observe each .wp-block-beech-count-indicator element
  indicatorElements.forEach((element) => {
    observer.observe(element);
  });

});
