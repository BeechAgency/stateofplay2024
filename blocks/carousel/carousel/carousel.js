//console.log('It is I, the script of the caorusel?!');
if(typeof AnalyticsHandler !== 'function') {
	function AnalyticsHandler( event_name = 'ga_event', event_params = {}, user_props = {} ) {
		if(typeof window.dataLayer !== 'object' ) return false;

		let event = { 'event' : 'gtm.ga4.event', 'event_name' : event_name, event_params, user_props }

		dataLayer.push(event);

		return true;
	}
}


( function() {

    document.addEventListener('DOMContentLoaded', ()=> {

        const caros = document.querySelectorAll('.carousel__target');

        function handleChangeEvent( title = 'Carousel', index = 0 ) {
            AnalyticsHandler('carousel', { carousel_slide_item : index, carousel_title : title })
        }

        caros.forEach( caro => { 
            const options = {
                // options
                prevNextButtons: false,
                pageDots: false,
                wrapAround: false,
                cellAlign: 'left',
                contain: true,
                autoPlay : 1800,
                wrapAround : true,
            }

            if ( matchMedia('screen and (max-width: 768px)').matches ) {
                options.freeScroll = true;
                options.wrapAround = true;
                
            }

            var flkty = new Flickity( caro, options );

            flkty.on('change', function(index) {
                const caroTitle = caro.parentElement.parentElement.previousElementSibling.innerText;
                handleChangeEvent(index, caroTitle)
            })
        })

        //doTheFollower();
    });
}());

/*
 * Follow Cursor Element
 */
function createCursorFollower() {
	const leFollower = document.createElement('div');
	
	leFollower.classList.add('cursor-follower');
	leFollower.textContent = 'DRAGON BIATCH';
	document.body.appendChild(leFollower);

	document.addEventListener("mousemove", (e) => {

	var x = e.clientX;
	var y = e.clientY;

	leFollower.style.left = `${x}px`;
	leFollower.style.top = `${y}px`;
	
	})
}

/** 
 * Do the follower
 */
function doTheFollower() {
    const carousels = document.querySelectorAll(
      ".carousel"
    );
    let follower = null;

    carousels.forEach( carousel => {

        carousel.addEventListener('mouseenter', createFollower);
        carousel.addEventListener('mouseleave', destroyFollower);

        function destroyFollower() {
            if (follower) {
                console.log('KILL IT!')
                // Remove the follower element and remove event listeners
                follower.classList.add('fade');
                
                setTimeout(() => {
                    carousel.removeEventListener('mousemove', moveFollower);
                    follower.remove();
                    follower = null;
                }, '150')
            }
        }

        function createFollower(e) {
            console.log('CREATE LIFE')
            // Create a new element for following the cursor
            follower = document.createElement('div');
            follower.className = 'cursor-follower fade';
            const leftArrow = '<svg xmlns="http://www.w3.org/2000/svg" width="6.969" height="11.816" viewBox="0 0 6.969 11.816"><path id="Path_11" data-name="Path 11" d="M7883.7,5413.5l5.378,5.378-5.378,5.378" transform="translate(7890.134 5424.781) rotate(180)" fill="none" stroke="#fff" stroke-width="1.5"/></svg>'
            const rightArrow = '<svg xmlns="http://www.w3.org/2000/svg" width="6.969" height="11.816" viewBox="0 0 6.969 11.816"><path id="Path_10" data-name="Path 10" d="M7883.7,5413.5l5.378,5.378-5.378,5.378" transform="translate(-7883.166 -5412.965)" fill="none" stroke="#fff" stroke-width="1.5"/></svg>'
            
            
            follower.innerHTML = leftArrow + 'DRAG' + rightArrow;
            document.body.appendChild(follower);
            setTimeout(() => {
                follower.classList.remove('fade');
            }, '150')
            //moveFollower(e);
            carousel.addEventListener('mousemove', moveFollower);
        }

    })

    
    function moveFollower(e) {
        
        if (follower) {
            // Update the position of the follower element
            const x = e.clientX;
            const y = e.clientY;
            //follower.style.left = x + 'px';
            //follower.style.top = y + 'px';

            follower.animate({
                left: `${x}px`,
                top: `${y}px`
              }, { duration: 300, fill: "forwards" })
        }
    }    
}