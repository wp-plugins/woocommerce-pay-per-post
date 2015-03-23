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

This plugin creates a custom field which you simply need to fill in the product id number which is needed to be purchased in order view the post. 

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

= 1.2.2 =
* Removed the pagination from the products listed out on the purchased page. *
= 1.2.1 =
* Fixed error displaying when debug mode is enabled for Missing argument 2 on get() function *
= 1.2 =
* Initial Release