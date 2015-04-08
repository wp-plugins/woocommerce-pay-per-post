<ul>
<?php foreach ($data as $posts): ?>
    <li><a href="<?php echo get_permalink( $posts->ID ); ?>"><?php echo $posts->post_title; ?></a></li>   
<?php endforeach; ?>
</ul>