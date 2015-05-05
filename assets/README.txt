=== Plugin Name ===
Contributors: josiahmann
Donate link: http://josiahmann.com/
Tags: related posts, related articles, related posts slider, simple related posts, related, simple related posts slider, related post thumbnails, related article thumbnails, wordpress related posts plugin
Requires at least: 3.0.1
Tested up to: 4.2
Stable tag: 1.21
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Simple Related Posts Slider is a very simple plugin that adds a slider containing related articles to the bottom of your wordpress posts.

== Description ==

Simple Related Posts Slider automatically adds a slider containing related articles to the bottom of your Wordpress single posts. Depending on how many related articles it finds, it will cycle through up to 12 articles, with a maximum of three articles visible at once. 

View a working demo at http://simple-related-posts.com/demo .

It is built to work with the "Featured Image" feature of Wordpress and only displays related posts that have a featured image set. The title is displayed below the featured image.

The slider is fully responsive and the height and width are automatically determined based on the width of your site.

Simple Related Posts Slider finds related posts by first checking to see if your posts are using the tags feature of Wordpress. If you're not using tags, it then looks through related categories and uses categories instead. 


Developer Option

If you do not want the slider to be automatically added, there is a menu option in Settings -> Simple Related Posts Slider to disable it and manually insert this code yourself into the appropriate template file `<?php srps()?>`.




== Installation ==


1. Upload `simple-related-posts-slider.zip` to the `/wp-content/plugins/` directory or through the Wordpress menu using Plugins -> Add New -> Upload
2. Activate the plugin through the 'Plugins' menu in WordPress
3. That's all! (Optional) If you'd like to manually insert the plugin, go to Settings -> Simple Related Posts Slider, check the box, and save. Now you can insert the plugin wherever you want using the snippet `<?php srps();?>`.

== Frequently Asked Questions ==

= None yet =


== Screenshots ==

1. A screenshot of the plugin in action.
2. This is a screenshot of the plugin menu.

== Changelog ==

= 1.21 =

* Fixed bug when no posts loaded.

= 1.2 =

* Added title option. Fixed bug where title displayed when no posts loaded.

= 1.1 =
* Fixed bug causing Captions to display improperly. 

= 1.0 =
* Initial Release.

== Upgrade Notice ==

= 1.1 =

Fixed bug causing Captions to display improperly. Please upgrade to avoid this issue.

= 1.2 =

Added title option. Fixed bug where title displayed when no posts loaded.

== View demo ==

View a working demo at http://simple-related-posts.com/demo