=== WooCommerce Pay Per Post ===
Contributors: mattpramschufer
Tags: woocommerce, payperpost, pay-per-post, pay per post, woo commerce, sell posts, sell pages
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=mattpram%40gmail%2ecom
Requires at least: 3.8
Tested up to: 4.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Sell Pages/Posts through WooCommerce 2.xx quickly and easily.

== Description ==
I looked everywhere and I couldn't find a plugin already out there, free or premium, that would do the simple fact of selling access to a particular page or post through WooCommerce.  So I decided to write my own.

This plugin creates a custom field which you simply need to fill in the product id number, or multiple product id numbers, which are needed to be purchased in order view the post.

It checks to make sure the user is logged in, AND has purchased that particular product before.  If they have, they see the general post content.  If they have NOT purchased they are then displayed a Oops page with a buy now button for the product.

= Shortcodes =
We also have 2 shortcodes for displaying ALL of the posts/pages that are available for purchase, along with a shortcode to show only all the pages/posts that a user has purchased.

`[woocommerce-payperpost template='purchased']`
This outputs an unordered list of the posts that have been purchased by the current user logged in.

`[woocommerce-payperpost template='all']`
This outputs an unordered list of the posts that can be purchased by a user.

= Requirements =
This plugin DOES require WooCommerce to be installed and active.  I have tested this with the latest version to date version 2.1.9

== Installation ==
1. Activate the plugin through the `Plugins` menu in WordPress
1. In Settings->WooCommerce Pay Per Post settings, update the content which you would like to display when user has not purchased content.
1. In WooCommerce->Products find the product ID of your product that you would like to associate with a post/page and copy it.
1. Go to Page or Post and you should see a field to enter in your product ID.


== Frequently Asked Questions ==

**Question:** I am logged in as an Admin I still only see the Oops screen.
**Answer:** If you want to view what the page looks like if you have purchased it all you need to do is simply create an order in WooCommerce and add yourself and the product to the order and save.

**Question:** Can this plugin work with custom post types?
**Answer:** Yes and No.  Out of the box it only works with regular posts or pages, but you can easily edit the code to include your custom post type.  You can look in the file woocommerce-payperpost.php and find the following code
`public static function add_custom_meta_box() {
     add_meta_box('woocommerce-payperpost-meta-box', __('WooCommerce Pay Per Post', 'textdomain'), __CLASS__ . '::output_meta_box', 'post', 'normal', 'high');
     add_meta_box('woocommerce-payperpost-meta-box', __('WooCommerce Pay Per Post', 'textdomain'), __CLASS__ . '::output_meta_box', 'page', 'normal', 'high’);
     add_meta_box('woocommerce-payperpost-meta-box', __('WooCommerce Pay Per Post', 'textdomain'), __CLASS__ . '::output_meta_box', ‘YOUR-CUSTOM-POST-TYPE-GOES-HERE', 'normal', 'high');

 }`

**Question:** How do you link to your post after an order has been placed.
**Answer:** What I have done in the past is use the Order Notes for the product in WooCommerce. So what will happen is after they purchase, on the Payment Received page they will see the order notes, and they will get sent in the receipt also.
So for instance, I have a Vimeo video that I embed in a page, on the Vimeo Product in WooCommerce I add the Password and notes on how to view the video, they gets transmitted via email and on the thank you page for the user.



If you have any questions please feel free to reach out to me at mattpram@gmail.com or submit a ticket on the support board.

As of right now, there is no questions posed.

== Screenshots ==

1. Settings Screen
2. How to find product id
3. Where to put product id
4. Admin view of Pay Per Post
5. Frontend view of Pay Per Post NOT Purchased
6. Frontend view of Pay Per Post PURCHASED
7. Shortcode view Admin
8. Shortcode view Frontend


== Changelog ==

= 1.3 =
* Added in the ability for multiple product IDs per post/page *
* Updated FAQ Section *
= 1.2.2 =
* Removed the pagination from the products listed out on the purchased page. *
= 1.2.1 =
* Fixed error displaying when debug mode is enabled for Missing argument 2 on get() function *
= 1.2 =
* Initial Release