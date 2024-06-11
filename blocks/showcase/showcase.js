document.addEventListener("DOMContentLoaded", () => {

    const showcases = document.querySelectorAll(".showcase__items-grid");

    showcases.forEach(showcase => {
        const images = showcase.querySelectorAll(".showcase-item__image");
        const listItems = showcase.querySelectorAll(".showcase__items-list li");

        images[0].classList.add('active');
        listItems[0].classList.add("active");

        function handleListItemHover(event) {
            const postId = event.currentTarget.getAttribute("data-post-id");

            // Remove 'active' class from all list items and images
            listItems.forEach((item) => item.classList.remove("active"));
            images.forEach((image) => image.classList.remove("active"));

            // Add 'active' class to the hovered list item
            event.target.classList.add("active");

            // Find the image with the matching data-post-id and add 'active' class
            const matchingImage = showcase.querySelector(`img[data-post-id="${postId}"]`);
            //console.log(matchingImage);
            
            if (matchingImage) {
                matchingImage.classList.add("active");
            }
        }

        listItems.forEach( item => {
            item.addEventListener("mouseover", handleListItemHover);
        })
    })

});