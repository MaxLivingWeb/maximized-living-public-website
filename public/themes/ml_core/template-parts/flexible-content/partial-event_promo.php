<?php if(get_field('show_section','event_promo')): ?>
<section class="flexible-eventPromo flexibleContentItem">
    <div class="container bg-image" style="background-image: url('<?php the_field('background_image','event_promo'); ?>');">
        <span class="heroBackgroundOverlay"></span>
        <div class="contentContainer container container-md">
            <?php if(get_field('icon','event_promo')) : ?>
                <div class="iconContainer">
                    <span class="icon bg-image" style="background-image: url('<?php the_field('icon','event_promo'); ?>');"></span>
                </div>
            <?php endif; ?>
            <div class="content">
                <h2 class="title">
                    <span class="titleHeader">Join us at</span>
                    <?php the_field('title','event_promo'); ?>
                </h2>
                <div class="description">
                    <?php the_field('description','event_promo'); ?>
                </div>
                <a class="button" href="<?php the_field('button_link','event_promo'); ?>" title="<?php the_field('button_text','event_promo'); ?>"><?php the_field('button_text','event_promo'); ?>
                </a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
