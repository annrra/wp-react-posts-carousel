# React Posts Carousel
React Posts Carousel WordPress Plugin built with <a href="https://facebook.github.io/react/" rel="nofollow">React</a> and allows to show posts from specific category as a carousel.

# Installation

Upload the files of the plugin inside a reactposts-carousel folder to the /wp-content/plugins/ directory.
Activate the plugin through the 'Plugins' menu in WordPress.

You will find 'CarouselPosts' submenu in your WordPress > Settings admin panel.
In the plugin settings page you should specify the category name, the number of post shown and the number of posts to show in one frame.

# How to Use

To insert the ReactPosts Carousel content into your post or page, copy the shortcode [posts-carousel] and paste it into the post/page content.
To embed the plugin into template file you will need to pass the shortcode into do_shortcode() function and display its output like this: <?php echo do_shortcode('[posts-carousel]'); ?>

The shortcode will load posts from custom category specified in the plugin settings page.
