<?php 
    $post_id = $args['post_id'] ?? get_the_ID();

    $author_id = get_the_author_ID($post_id);

    $author_image_id = get_field('display_image', "user_{$author_id}");
    $author_title = get_field('title', "user_{$author_id}");
?>

<div class="author-profile">
    <div class="author-profile__inner">
        <?php if($author_image_id): ?>
        <div class="author-profile__image">
            <?= the_image($author_image_id,  array(
                    'classes' => 'author-profile__image-image',
                    'alt' => get_the_author()
                )); ?>
        </div>
        <?php endif; ?>
        <div class="author-profile__text">
            <div class="author-profile__name"><?= get_the_author() ?></div>
            <?php if($author_title): ?>
            <div class="author-profile__title"><?= $author_title ?></div>
            <?php endif; ?>
        </div>
    </div>
</div>