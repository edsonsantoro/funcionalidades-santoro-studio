=== Funcionalidades - Santoro Studio ===
Donate link: https://santoro.studio
Tags: woocommerce, wordpress
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Plugin that adds some functionalities to woocommerce stores, like holding products for customers that did not pay for the order yet, automatically remove itens from cancelled orders and others.

== Description ==

This plugin does mainly two things fo Woocommerce store owners: 

* Hold a product ordered but not yet paid for the given customer, until payment is done or order cancelled.
* Take itens of cancelled orders back to store automatically (only for cancelled order, not reinbursed or failed)

Also, functions that may be useful for stores that handles orders in name of customers (like, shop workers creating the order manually and sending it to payment). In this scenario, when a shop worker, admin etc creates an order for the customer using the front-end, Woocommerce locks the payment page visibility to that account only. So, if you make an order in front-end for your customer using a shop worker account, normally, you should edit that order and set the customer manually, and send the payment link to them. With this plugins, it happens 'automagically'.

== Installation ==

1. Upload `funcionalidades-santoro-studio.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Does this plugins works with X plugin? =

Until now, no compatibility problem.

== Changelog ==

= 1.0 =
* First release
