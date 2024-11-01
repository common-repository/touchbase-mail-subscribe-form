=== TouchBase Mail Subscribe Form ===
Contributors:       tomkoole, touchbasedacotah
Plugin Name:        TouchBase Mail Subscribe Form
Plugin URI:         https://touchbasemail.com
Tags:               shortcode, subscribe, form, subscribe form, touchbase, touch base, subscription, AJAX
Requires at least:  3.1.0
Tested up to:       4.9.8
Stable tag:         1.0
License:            GPLv2 or later
License URI:        http://www.gnu.org/licenses/gpl-2.0.html

Use shortcode to place a subscribe form in any page, post, or html widget.

== Description ==

The [TouchBase Mail](https://touchbasemail.com) Subscribe Form plugin provides an easy way to get more subscribers by allowing you to place a
one-click subscribe form on any page, post, or html widget using a shortcode.

This form allows your followers to subscribe to your email lists.
It allows you to specify form defaults in the WordPress admin settings and provides shortcode attributes to override
 those values for a specific page or post. This plugin is based off of the
 [Remote Subscription Form](https://clients.touchbasemail.net/help/6-remote-subscription-form) help article.

Two form styles are available, **wide** and **vertical**, see the **Additional Configuration** section for more details.

== Installation ==

This section describes how to install the plugin and get it working. To retrieve the necessary information for the plugin,
login to [TouchBase Mail](https://touchbasemail.com).

Retrieving your **Public Token**:

1. Go to your Sender Profile page ( Briefcase in the lower left > Sender Profile )
1. Go to API settings (in the top right)
1. Copy your **Public Token** value

Retrieving your **List ID**:

1. Go to the Lists page
1. Browse, search, or create your desired list
1. Copy the ID value

Installing and configuring the plugin in WordPress:

1. Upload the plugin files to the `/wp-content/plugins/touchbasemail-subscribe-form` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Use the Settings->TouchBase Mail screen to configure the plugin using the information you retrieved
1. Edit your theme, page, or post, to add the **[touchbase_subscribe_form]** shortcode

== Frequently Asked Questions ==

= Are there different styles available? =

We tried to keep the form as simple as possible so that it will fit into as many themes as necessary. There are two
formats available as described in **Additional Configuration**, however if you want the form to match your theme's colors,
currently you'll need to edit the CSS.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 1.0.2 =
* Drop source attribute

= 1.0 =
* Added two style formats
* Added admin settings for shortcode defaults
* Added shortcode overrides to admin settings

== Upgrade Notice ==

= 1.0 =
This is the first publicly available version.

== Additional Configuration ==

After you have the plugin up and running you may want to configure how each shortcode instance behaves. To change the
behavior there are several shortcode attributes available.

= Format =

There are two styles available for changing the look of the form:

* **wide**: a one horizontal line input form that matches the width of its container and has a fixed-width submit button.
* **vertical**: a two line input form that matches the width of its container but places the submit button below the email address input.

The default style is the **wide** format. To change to the **vertical** format you can use the following:

`[touchbase_subscribe_form format=vertical]`

= Settings Overrides =

For each of the settings you've defined in the admin panel, you can override them for each shortcode instance. The attributes
are as follows:

* **list**: Change the list that this form will add the subscriber to. You may want to use this if a particular post relates to one of your offers that will have its own email campaign.
* **public_token**: It's not likely that you'll need to change this, however if you manage multiple Sender Profiles in TouchBase you can change the public token value as needed.

These can be specified the same as other shortcode attributes:

`[touchbase_subscribe_form format=vertical list=123]`
