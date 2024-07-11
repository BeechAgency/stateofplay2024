<?php
/**
 * Header Block
 *
 * @param array $block The block settings and attributes.
 */


// Load values and assign defaults.
$do_a_think        = get_field( 'do_a_thing' );
$quote_attribution = '';

$image = false;

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = esc_attr( $block['anchor'] );
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = '';

if ( !empty($block['alignContent']) ) {
    $class_name .= ' align-content-'.$block['alignContent'];
}

$style = '';
$featured_image_url = get_the_post_thumbnail_url( null, 'full');

// Switch on the style
if(!empty($block['className'])):
    switch (true) {
        case strpos($block['className'], 'home') !== false:
            $style = 'home';
            break;
        case strpos($block['className'], 'article-image') !== false:
            $style = 'article-image';
            break;
        case strpos($block['className'], 'article') !== false:
            $style = 'article';
            break;
        case strpos($block['className'], 'project') !== false:
            $style = 'project';
            break;
        case strpos($block['className'], 'side-dude') !== false:
            $style = 'side-dude';
            break;

        case strpos($block['className'], 'contact') !== false:
            $style = 'contact';
            break;

        default:
            $style = '';
    }
endif;



$allowed_blocks = array( 'core/heading', 'core/paragraph', 'beech/eyebrow','core/button', 'core/buttons', 'gravityforms/form', 'beech/contact', 'beech/date-category', 'beech/reading-time' );

$template = array(
	array('core/heading', array(
		'level' => 1,
		'placeholder' => get_the_title(),
	))
);

if($style === 'article-image') {
    $template = array(
        array('beech/date-category', array()),
        array('core/heading', array(
            'level' => 1,
            'placeholder' => get_the_title(),
        )),
        array('beech/reading-time', array())
    );
}

?>

<header <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>


    <?php if($style === 'home'): ?>
    <div class="header__marquee-wrap">
        <div class="header__marquee-track">
            <div class="header__marquee-group">
                <h1 class="header__marquee-text"><?= get_field('marquee_text'); ?></h1>
            </div>
            <div class="header__marquee-group">
                <h1 class="header__marquee-text"><?= get_field('marquee_text'); ?></h1>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="header__inner<?= $style ==='article-image' ? ' has-bg-image' : '' ?>" <?= $style ==='article-image' ? 'style="--_bg-image: url('.$featured_image_url.');" ' : '' ?>>
        <?php if($style === 'project'): 
            $project_id = get_the_ID();
            $year = get_field('year', $project_id );
            $team = get_field('team', $project_id );

            $post_tags = wp_get_post_tags($project_id); 
            $industry_terms = wp_get_post_terms($project_id, 'industry');
        ?>
        <div class="header__project-content">
            <?php 
                if(!empty($post_tags)):
            ?>
            <div>
                <h6>Disciplines</h6>
                <ul>
                <?php  foreach ($post_tags as $tag) {
                    echo '<li>'. $tag->name . '</li>';
                } ?>
                </ul>
            </div>
            <?php
                endif; 
                if(!empty($team)): ?>
            <div>
                <h6>Team</h6>
                <ul>
                <?php foreach($team as $member) {
                    echo "<li>$member</li>";
                } ?>
                </ul>
            </div>
            <?php endif; 
                if(!empty($industry_terms)):
            ?>
            <div>
                <h6>Industry</h6>
                <ul>
                <?php  foreach ($industry_terms as $term) {
                    //echo '<li><a href="' . get_tag_link($term->term_id) . '">' . $term->name . '</a></li>';
                    echo '<li>' . $term->name . '</li>';
                } ?>
                </ul>
            </div>
            <?php 
                endif;
                if(!empty($year)): ?>
            <div>
                <h6>Year</h6>
                <ul><li><?= $year ?></li></ul>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if($style !== 'home'): ?>
        <?php if($style === 'article-image'): ?><div class="header__inner-wrap"><?php endif; ?>
        <InnerBlocks 
            allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" 
            template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
            className="header__inner-blocks" />
        <?php endif; ?>
        <?php if($style === 'article-image'): ?></div><?php endif; ?>
        <?php if($style === 'home'): ?>
        <div class="header__inner-blocks">
            <h2 class="header__byline"><?= get_field('byline');?></h2>
        </div>
        <?php endif; ?>

        <?php if($style === 'home'): ?>
        <div class="header__links">
            <?php 
            if(have_rows('links')): 
                foreach(get_field('links') as $link_obj) :
                    $link = $link_obj['link'];
                ?>
                <a href="<?= $link['url'] ?>" target="_blank" title="<?= $link['title'] ?>">
                    <?= $link['title']; ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="57.482" height="57.482" viewBox="0 0 57.482 57.482">
                        <path id="Path_580" data-name="Path 580" d="M55.545,26.045l-1.931-2.558L35.909,0H28.172L47.417,25.528H0v6.179H47.417L27.994,57.482h7.731L53.613,33.753l1.931-2.569,1.937-2.558Z" fill="currentColor"></path>
                    </svg>
                </a>
            <?php 
                endforeach;
            endif; 
            
            if(get_field('display_work_button')) { 
                $count_posts = wp_count_posts('project');
                $work_count = $count_posts->publish;
                ?>

                <a href="/work" class="button-with-count">
                    View our work
                    <span class="count"><?= $work_count ?></a>
                </a>

            <?php }
            ?>
        </div>
        <?php endif; ?>

        <?php 
        if($style === 'home' || $style === 'side-dude'): 
            $boiz_class = $style === 'home' ? '' : 'vertical'; 
            //beech_color_boiz($boiz_class);
        endif; ?>
    </div>

    <?php if($style === 'home'): ?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', (e) => {
            const header = document.querySelector('header.is-style-home');

            // Define an array of color names
            const colors = ['yellow', 'rorange', 'pink', 'green', 'blue'];

            // Shuffle the array to randomize the order
            function shuffleArray(array) {
                for (let i = array.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [array[i], array[j]] = [array[j], array[i]];
                }
            }
            shuffleArray(colors);

            // Iterate through the array and apply the corresponding background color class
            colors.forEach((color, index) => {
                const backgroundClass = `is-${color}-background`;
                setTimeout(() => {
                    header.classList.add(backgroundClass);
                    setTimeout(() => {
                    header.classList.remove(backgroundClass);
                    }, 15000); // Change color every 2 seconds
                }, index * 15000); // Delay each color change
            });

            if(header) {
                const boiz = header.querySelectorAll('.color-boiz > div');


                boiz.forEach( boy => {
                    boy.addEventListener( 'mouseover', (e)=> {
                        const el = e.currentTarget;
                        const color = el.dataset.color;

                        header.classList.add(`is-${color}-background`);
                        setTimeout(()=> {
                            header.classList.remove(`is-${color}-background`);
                        },1500)
                    })
                    /*
                    boy.addEventListener( 'mouseout', (e)=> {
                        const el = e.currentTarget;
                        const color = el.dataset.color;

                        header.classList.remove(`is-${color}-background`);
                    })*/
                })
            }

            
        });
    </script>
    <?php endif; ?>
</header>