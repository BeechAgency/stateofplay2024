
<?php
/**
 * Epic Carousel Type Thing
 *
 * @param array $block The block settings and attributes.
 */



// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = esc_attr( $block['anchor'] );
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = '';
$items = get_field('items');
$duration = empty(get_field('duration')) ? 0.5 : (int) get_field('duration');

$item_count = count($items);
?>

<header <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>> 
    <div class="epic-carousel__showcase--wrapper">
        <div class="epic-carousel__track" data-slide-duration="<?= $duration ?>">
            <?php 
            if($items && $item_count > 0): 
                $i = 0;
                foreach($items as $item) :  
                    $video_url = get_field('featured_video', $item);
                ?>
            <div class="epic-slide<?= $i === 0 ? ' epic-slide--active' : '' ?>" data-slide-index="<?= $i ?>">
                <div class="epic-slide__title">
                    <span class="client"><?= get_field('client', $item) ?></span> <br />
                    <span class="tagline"><?= get_field('tagline', $item) ?></span>
                </div>
                <div class="epic-slide__image">
                    <?php  if( !empty($video_url)) :?>
                        <video width="100%" height="auto" playsinline="" loop="" muted="" autoplay="" class="bb-post-card-video lozad" data-placeholder-background="hsla(0, 0.00%, 0.00%, 1.00)" data-loaded="false">
                        <source data-src="<?= $video_url ?>" src="">
                        Your browser does not support the video tag.
                    </video>
                    <img data-src="<?= get_the_post_thumbnail_url($item); ?>" data-placeholder-background="hsla(0, 0.00%, 0.00%, 1.00)" class="post-card video-poster lozad" style="background: rgb(0, 0, 0);" data-loaded="false">
                    <?php else: 
                        echo get_the_post_thumbnail( $item, 'full', null );
                     endif; ?>
                </div>
            </div>
            <?php
                $i++; 
                endforeach; 
            endif; ?>
        </div>
        <div class="epic-carousel__controls--wrapper">
            <div><span id="epic-carousel__controls--current">01</span> / <span id="epic-carousel__controls--total"><?= sprintf('%02d', $item_count); ?></span></div>
            <div class="epic-carousel__controls--circle">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                    <circle opacity="0.5" cx="11" cy="11" r="9" stroke="white" stroke-width="3"/>
                    <circle class="progress-circle"  cx="11" cy="11" r="9" stroke-width="3" fill="none" />
                    <!--<path d="M20 11C20 6.02944 15.9706 2 11 2" stroke="white" stroke-width="3"/>-->
                </svg>
            </div>
            <div class="epic-carousel__controls--arrows">
                <button id="epic-carousel__controls--prev">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 15 24" fill="none">
                        <path d="M13 22L3 12L13 2" stroke="white" stroke-width="3"/>
                    </svg>
                </button>
                <button id="epic-carousel__controls--next">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 15 24" fill="none">
                        <path d="M2 2L12 12L2 22" stroke="white" stroke-width="3"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        let currentIndex = 0;
        const track = document.querySelector('.epic-carousel__track');
        const duration = track.dataset.slideDuration * 1000;
        const slides = document.querySelectorAll('.epic-carousel__track .epic-slide');
        const totalSlides = slides.length;
        const prevButton = document.getElementById('epic-carousel__controls--prev');
        const nextButton = document.getElementById('epic-carousel__controls--next');
        const currentNumber = document.getElementById('epic-carousel__controls--current');
        const progressCircle = document.querySelector('.progress-circle');

        let slideInterval;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                if (i === index) {
                    slide.classList.add('display');

                    setTimeout(() => {
                        slide.classList.add('epic-slide--active');
                        currentNumber.textContent = (i + 1).toString().padStart(2, '0');
                    }, 10);

                } else {
                    slide.classList.remove('epic-slide--active');
                    setTimeout(() => slide.classList.remove('display'), 1000); // Match this timeout with the CSS transition duration
                }
            });

            resetProgressCircle();
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % totalSlides;
            showSlide(currentIndex);
            resetSlideInterval();
        }

        function prevSlide() {
            currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
            showSlide(currentIndex);
            resetSlideInterval();
        }

        function resetSlideInterval() {
            clearInterval(slideInterval);
            slideInterval = setInterval(nextSlide, duration);
        }

        function resetProgressCircle() {
            progressCircle.style.transition = 'none';
            progressCircle.style.strokeDashoffset = 283;
            setTimeout(() => {
                progressCircle.style.transition = `stroke-dashoffset ${duration*5}ms linear`;
                progressCircle.style.strokeDashoffset = 0;
            }, 50); // Slight delay to ensure transition is applied
        }

        resetProgressCircle();

        nextButton.addEventListener('click', nextSlide);
        prevButton.addEventListener('click', prevSlide);

        // Initialize auto-slide interval
        slideInterval = setInterval(nextSlide, duration);
    });
</script>