=== Plugin Name ===
Contributors: dlgoodchild, paultgoodchild
Donate link: http://worpit.com/
Tags: CSS, WordPress Admin, Twitter Bootstrap, Twitter Bootstrap Javascript, Bootstrap CSS, WordPress Bootstrap, normalize, reset, YUI
Requires at least: 3.2.0
Tested up to: 3.4.1
Stable tag: 2.1.1.0

WordPress Twitter Bootstrap CSS lets you include the latest Twitter Bootstrap CSS and Javascript libraries in your WordPress site.

== Description ==

What is Twitter Bootstrap?
It's a CSS and Javascript framework that helps boost your site design and functionality quickly.

We love Twitter Bootstrap on our [WordPress sites at Worpit](http://worpit.com/ "Worpit: Manage WordPress Better").
And we wanted a way to quickly link the latest Bootstrap CSS and Javascript to all pages, regardless of the WordPress Theme.

With this plugin, now you can!

*	Works with *any* Wordpress Theme without ever editing Theme files and NO programming needed.
*	Now fully customizable with built-in LESS Compiler.
*	Handy WordPress [SHORTCODES] to add Twitter Bootstrap elements to your site quickly
*	Add your own custom CSS reset file
*	Option to add JavaScript to the [HEAD] (defaults to end of [BODY] as is good practice)
*	and more..

To get the latest news and support go here: [WordPress Twitter Bootstrap CSS plugin](http://worpit.com/wordpress-twitter-bootstrap-css-plugin-home/ "WordPress Twitter Bootstrap CSS Plugin Home") to see the release article on our site.

**Why use Twitter Bootstrap?** 
It's good practice to have a core, underlying CSS definition so that your website appears and acts consistently across all
browsers as far as possible.

Twitter Bootstrap does this extremely well.

From Twitter Bootstrap:
*Bootstrap is a toolkit from Twitter designed to kickstart development of webapps and sites.
It includes base CSS and HTML for typography, forms, buttons, tables, grids, navigation, and more*

The problem?
Many themes do not allow you to add custom CSS files easily. Even the Thesis Framework! So we take
another approach and inject the CSS as one of the FIRST items in the HTML HEAD section. This way, no
other CSS interferes first so you can be sure these bootstrap file can be used as a foundation/reset CSS.

The CSS is only part of the solution. Twitter Bootstrap also have Javascript libraries
to complement their Bootstrap CSS. These may also be added to your site with the option to
add them to the HEAD of your site - by default they are added to the end of the BODY.

We also wanted the option to alternatively include YUI "reset.css" and "normalize.css".  These both form related roles to bootstrap, but are lighter.

You could look at the difference between the styles as:

*	reset.css - used to *strip/remove* the differences and reduce browser inconsistencies. It is typically generic and
will not be any use alone. It is to be treated as a starting point for your styling.
*	normalize.css - aims to make built-in browser styling consistent across browsers and adds *basic* styles for modern
expectations of certain elements. E.g. H1-6 will all appear bold.
*	bootstrap.css - is a level above normalize where it adds much more styling but retains consistency across modern
browsers. It makes site and web application development much faster.

**Some References**:

Bootstrap, from Twitter: http://twitter.github.com/bootstrap/

Yahoo Reset CSS, YUI 2: http://developer.yahoo.com/yui/2/

Normalize CSS: http://necolas.github.com/normalize.css/

== Frequently Asked Questions ==

= How can I install the plugin? =

This plugin should install as any other WordPress.org respository plugin.

1.	Browse to Plugins -> Add Plugin
1.	Search: Wordpress Bootstrap CSS
1.	Click Install
1.	Click to Activate.

Alternatively using FTP:

1.	Download the zip file using the download link to the right.
1.	Extract the contents of the file and locate the folder called 'wordpress-bootstrap-css' containing the plugin files.
1.	Upload this whole folder to your '/wp-content/plugins/' directory
1.	From the plugins page within Wordpress locate the plugin 'Wordpress Bootstrap CSS' and click Activate

A new menu item will appear on the left-hand side called 'Worpit'.  Click this menu and select
Bootstrap CSS.

Select the CSS file as desired.

= How can I use the WordPress Twitter Bootstrap Shortcodes? =

I've put a full demo page of all the fully support shortcodes in this plugin:
[Complete WordPress Twitter Bootstrap Shortcodes demo page](http://bit.ly/OFYCh8 "Complete WordPress Twitter Bootstrap Shortcodes demo page")

= What are all the parameters for all the shortcodes? =

For all the shortcodes simply type help="y" and preview your post - it will print a box for you showing all parameters, their default values
and an explanation where appropriate.

= The WordPress Shortcodes aren't getting processed properly - why? =

You need to enable the shortcodes feature in the options page. This is a performance optimization so that people who don't need
it don't have to process it.  Also, some require the Bootstrap Javascript library to be loaded so enable that also if you require it. 

= Why was Twitter ("Legacy") Bootstrap v1.4.0 support dropped from the plugin in v2.0.3? =

Time and resources. The work to maintain it and ensure it's bug-free was getting too great.

I've explained a bit more in this [support forum post here](http://wordpress.org/support/topic/plugin-wordpress-twitter-bootstrap-css-legacy-support-removed).

= Can I link more than one CSS? =

No. There's no point in doing that and serves only to add a performance penalty to your page loads.

With version 0.4+, you can now add your own custom reset CSS that will follow the standard reset/Twittter Bootstrap CSS. 

= What happens if uninstall this plugin after I design a site with it installed? =

In all likelihood your site design/layout will change. How much so depends on which CSS you used and how much of
your own customizations you have done.

= Why does my site not look any different? =

There are severals reasons for this, most likely it is that you or your Wordpress Theme has defined all the styles
already in such a manner that the CSS applied with this plugin is overwritten.

CSS is hierarchical. This means that any styles defined that apply to an element that *already* has
styles applied to it will take precedence over any previous styles.

= Is WordPress Twitter Bootstrap CSS compatible with caching plugins? =

The only caching plugin that Worpit recommends, and has decent experience with, is W3
Total Cache.

This plugin will automatically flush your W3TC cache when you save changes on this plugin (assuming you have
the other plugin installed).

Otherwise, consult your caching program's documentation.

= Do you make any other plugins? =

We also created the [Worpit Multiple WordPress Site Manager](http://worpit.com/?src=wtb_readme) for people with more than one WordPress site to manage.

Yes, we created [Custom Content By Country](http://wordpress.org/extend/plugins/custom-content-by-country/ "Custom Content By Country WordPress Plugin")
plugin that lets you display content to users in specific regions.

= Is the CSS "minified"? =

Yes, but only in the case of Yahoo! YUI 2/3, and Twitter Bootstrap CSS.

You now have the option to enable minified CSS or not.

= My Popover/Tooltip doesn't seem to work and it's generating Javascript errors in the console =

This is likely due to you not linking to the latest version of JQuery. Twitter Bootstrap requires the latest
version (v1.7.2 at the time of writing). There is now ( plugin v2.0.3.1+ ) an option to replace the
JQuery of your WordPress installation with the latest version served from Google CDN. Try this if you're
having issues with Popovers etc., or better yet upgrade your WordPress to the latest version.

= What's the reason for the Worpit menu? =

We're planning on releasing more plugins in the future and they'll use much of the same code base. In this way
we hope to minimize extra and unnecessary code and give your website a far superior browsing experience without
the typical performance penalty that comes with too many plugins.

Our plugin interface will be consistent and grouped together where possible so you don't have to hunt down the
settings page each time (as is the case with most plugins out there).

== Screenshots ==

1. Here you select which CSS to use.

2. If you prefer you can specifiy your own custom reset CSS file. You could use this if you wanted to use a Twitter Bootstrap
CSS library that you have created yourself (useful until we implement a LESS compiler into the plugin).

3. Assuming you select Twitter Bootstrap CSS, you may now select which Twitter Bootstrap Javascript libraries to include

4. You have the option of including any selected Javascript libraries in the HEAD of your WordPress document. This is not recommended
for various performance reason.  You can also selected to enable our WordPress Shortcode library.

5. A new feature as of version 2.0.2.1. Plugin/Theme Developers can now include Twitter Bootstrap CSS in the WordPress Admin screen.
Don't select this unless you know you need it - no harm if you do, but no point otherwise.

6. As of version 2.0.2.1, we've included a news feed on the Dashboard. If you don't want it displayed, select this to hide it.

== Changelog ==

= TODO =
* Provide better upgrade support for customized Variable.less files. Currently if you've customized your Variables.less file manually
you'll need to back it up before you upgrade your Bootstrap plugin.

= 2.1.1.0 =
* UPDATED: Twitter Bootstrap library to latest release v2.1.1
* ADDED: option to Popover to allow you to set the activation 'trigger' and defaulted it to pre-Bootstrap 2.1.0 behaviour - i.e. on hover!
* ADDED: option to Tooltip to allow you to set the activation 'trigger' and defaulted it to pre-Bootstrap 2.1.0 behaviour - i.e. on hover!
* ADDED: btn-block to the shortcode help for buttons.
* FIX: RSS Feed Widget urls

= 2.1.0.0 =
* UPDATED: Twitter Bootstrap library to latest release of 2.1.0
* UPDATED: Normalize CSS upgraded to version 2.0.1
* FIX: Valid XHMTL http://wordpress.org/support/topic/plugin-wordpress-twitter-bootstrap-css-xhtml-validation

= 2.0.4.8 =
* ADDED: Shortcode [TBS_PROGRESS_BAR] for Twitter Bootstrap Progress Bars (http://twitter.github.com/bootstrap/components.html#progress)
* ADDED: MUCH more verbose help on ALL shortcodes. Simply type: help="y" and it will print the help box on your post.
* ADDED: 'target' parameter to the TBS_BUTTON shortcode so you can open in new window if you want. i.e. target="_blank"

= 2.0.4.7 =
* ADDED: Shortcode for Twitter Bootstrap accordions - collapsable blocks (http://twitter.github.com/bootstrap/javascript.html#collapse)
The shortcodes are: [TBS_COLLAPSE] (parent) and {TBS_COLLAPSE_GROUP]. You need to nest the "GROUPS" within the parent.
* ADDED: "help=y" parameter to all shortcodes so you can quickly print out all available shortcode parameters.
* ADDED: : [Complete WordPress Twitter Bootstrap Shortcodes demo page](http://bit.ly/OFYCh8 "Complete WordPress Twitter Bootstrap Shortcodes demo page")

= 2.0.4.6 =
* FIXED: (again) Fatal error reported- http://wordpress.org/support/topic/plugin-wordpress-twitter-bootstrap-css-cant-activate-the-plugin-because-of-fatal-error
* FIXED: a few minor plugin interface bugs.
* UPDATED: Normalize.css to latest version (2012-07-07) at time of release
* ADDED: Shortcode TBS_SPAN - this is just an alias for TBS_COLUMN added previously.
* ADDED: offset parameter to the TBS_SPAN (and TBS_COLUMN) to reflect offset option in Twitter Bootstrap.
* ADDED: Responsive CSS is automatically recompiled when CSS is recompiled (regardless of whether responsive is enabled or not)

= 2.0.4.5 =
* ADDED: NONCE to form submissions to improve the security of the plugin.
* ADDED: A new compile button - compile CSS from Original or customized Variable.less an option (http://wordpress.org/support/topic/plugin-wordpress-twitter-bootstrap-css-make-compile-variablesless-from-original-an-option)
* FIXED: Fatal error reported- http://wordpress.org/support/topic/plugin-wordpress-twitter-bootstrap-css-cant-activate-the-plugin-because-of-fatal-error

= 2.0.4.4 =
* FIXED: Further attempt to fix string escape issues (thanks Troy!).
* FIXED: Bug with Grid Columns field being appended with 'px' in LESS compiler.
* UPDATED: LESS PHP compiler to latest release (v0.3.5)

= 2.0.4.3 =
* FIXED: An attempt to fix problems some people have with the LESS compiler and escaping double-quoted fonts.
** IF you have had problems, do a RESET first, then attempt to compile your customizations. **

= 2.0.4.2 =

* FIXED: Wasn't properly linking to Google Prettify CSS and JS files when the option was enabled.
* UPDATED: Yahoo! YUI v3 to version 3.5.1.
* UPDATED: Uses serialized data for the LESS CSS plugin options - greatly reducing database calls on the admin section and database usage.
* UPDATED: Plugin now uses Worpit's standard plugin structure for dynamically creating plugin options pages. The whole plugin is more stable and more reliable.
* UPDATED: Now flushes W3 Total Cache (if installed) when you update your LESS CSS options also.
* ADDED: Worpit feed to the news feed.

= 2.0.4.1 =

* FIXED: Reported Bug (thanks Claudio!) with Responsive CSS includes - there was a typo in the code and the CSS wasn't linked to correctly.

= 2.0.4 =
* UPDATED: Twitter Bootstrap version 2.0.4
* ADDED: Option - to replace WordPress JQuery library with the latest (at the time of plugin release) as served from Google CDN
This is useful if your WordPress version isn't the latest and has an incompatible JQuery library.
* IMPROVED much of the plugin code.
* IMPROVED variable.less integrity. Now always uses the original copy for LESS compilation in case it becomes corrupted.
* IMPROVED Upgrade handling in terms of LESS compiled CSS. Now automatically recompiles CSS upon upgrade where applicable.
* IMPROVED [TBS_ROW] shortcode to allow fluid rows/containers and also to allow option of creating a container or not. Default to NOT creating container.
* FIXED: A few reported bugs.

= 2.0.3 =
* ADDED: LESS Compiler for some of the most common Bootstrap style options! ( [thanks to LESSCPHP for PHP LESS compiler](http://leafo.net/lessphp/) )
* ADDED: Option - toggle use of minimized or non-minized Bootstrap CSS
* ADDED: Option - toggle delete all plugin settings upon plugin deactivation
* ADDED: Option - enable LESS compiler and include less-compiled CSS
* ADDED: Now enqueues native WordPress JQuery Javascript when Bootstrap Javascript is enabled.
* ADDED: Yahoo YUI! reset.css v3.4.1
* UPDATED: Plugin upgrade handling is much improved
* UPDATED: Normalize CSS updated to the latest version
* REMOVED: support Twitter Bootstrap v1.4.0 ("legacy") !
* REMOVED: support for Individual Twitter Bootstrap Javascript Libraries !
* REMOVED: support for shortcodes [TBS_BLOCK] and [TBS_TWIPSY] !

= 2.0.2.3 =
* FIX: Fixed a bug where the plugin would error and WordPress may deactivate the plugin.
* UPDATED: By default when the plugin deactivates, all plugin settings are removed from the database. I have stopped this
for now (so all settings remain upon deactivation). Version 2.0.3 will have the option for the user to toggle this setting.
* ADDED: A notice in the dashboard about removal of Javascript library changes coming in version 2.0.3

= 2.0.2.2 =
Skipped.

= 2.0.2.1 =
* ADDED: *Ability to include Twitter Bootstrap CSS in WP Admin (along with some CSS fixes to accomodate)*
* ADDED: WordPress Admin notices for upgrades and success settings operations.
* ADDED: New Shortcode: TBS_BADGE
* ADDED: Host Like Toast RSS News feed on Dashboard + option to hide (hlt-rssfeed-widget.php)
* UPDATED: Settings page now uses a new Twitter Bootstrap layout/design
* UPDATED: The screenshots for the docs
* STARTED: The process of Internationalisation (I18n) for the plugin. Anyone who wants to help out, please get in touch.

= 2.0.2 =
* UPDATED: Updated Twitter Bootstrap library to v2.0.2
* ADDED: Ability to include Responsive CSS stylesheet that comes with Twitter Bootstrap version 2.0+
* ADDED: Reorg'd some of the interface to be a little more logical
* FIXED: serious oversight with including individual Javascript libraries.

= 2.0.1c =
* ADDED: Ability to add the "disabled" option to Twitter Bootstrap button components.
* FIXED: a couple of bugs in the shortcodes

= 2.0.1b =
* ADDED: New shortcode [TBS_ICON](http://bit.ly/zmGUeD "Twitter Bootstrap Glyph Icon WordPress Shortcode") to allow you to easily make use of [Twitter Bootstrap Glyphicons](http://bit.ly/AxCdQj)
* ADDED: New shortcode [TBS_BUTTONGROUP] to allow you to easily make use of [Twitter Bootstrap Button Groups](http://bit.ly/z13ICu)
* CHANGED: Rewrote [TBS_BUTTON]. Now you can add "toggle" option, and specify the exact html element type, eg [a], [button], [input]
* CHANGED: Rewrote [TBS_ALERT]. Now you can add the Alert Heading using the parameter: heading="my lovely heading"
* With [TBS_ALERT], parameter "type" is no longer supported - use parameter "class" instead
* CHANGED: Added inline Javascript for activating Popover and Tooltips - nice page-loading optimization and also only execute JS code necessary
* Throughout, attempted to retain support for Twitter Bootstrap 1.4.0. But no guarantees - you should upgrade and convert asap.
* TODO: necessary javascript snippet to enable button toggling - couldn't get it working.

= 2.0.1a =
* Skipped due to missing elements in [TBS_ICON] shortcode.

= 2.0.1 =
* Twitter Bootstrap library upgraded to v2.0.1

= 2.0.0 =
* Added the options for Twitter Bootstrap Library 2.0.0
* Maintained compatibility with Twitter Bootstrap Library 1.4.0
* Removed option to HotLink to resources
* Added more Javascript libraries for 1.4.0 and 2.0.0
* Fixed several bugs.
* Keeping plugin version numbering in-line with Twitter Bootstrap versioning.
* References to "Twipsy" renamed to "Tooltips" to be inline with version 2.0.0
* Most SHORTCODES work between both versions. [Latest Notes](http://bit.ly/wLkYjf "Host Like Toast WordPress Twitter Bootstrap plugin release notes v2.0")

= 0.9.1 =
* Restructured and centralized CSS on admin side.
* Revamped the Host Like Toast Developer Channel subscription box - the previous one wasn't working so well.

= 0.9 =
* Fixed bug where styles were being reapplied when HTML [HEADER] element was defined (thanks to Matt Sims!) 
* Improved compatibility with WordPress 3.3 with more correct enqueue of scripts/stylesheets.

= 0.8.6 =
* [TBS_TWIPSY] and [TBS_POPOVER] are now by default SPAN elements (There may be an option at a later date to specify the element)

= 0.8.5 =
* Made some functional improvements to [TBS_TWIPSY]
* Fixed [TBS_POPOVER]

= 0.8.4 =
* Fixed a quoting bug in [TBS_BLOCK]
* Added [TBS_ALERT] shortcode (see guide below for TBS_BLOCK)

= 0.8.3 =
* Added option to inline "style" labels, blocks, and code.
* Added Shortcode [TBS_BLOCKQUOTE] : produces a Twitter Bootstrap styled BLOCKQUOTE with parameter "source" for citing source 
[Guide on Blockquote shortcode here](http://www.hostliketoast.com/2011/12/master-twitter-bootstrap-using-wordpress-shortcodes-part-3-blockquotes/ "Master Twitter Bootstrap Blockquotes using WordPress Shortcodes")

= 0.8.2 =
* Added option to "style" buttons inline.
* Some bug fixes with shortcodes.

= 0.8 =
* This is a huge release. We have implemented some of the major Twitter Bootstrap feature through [Wordpress Shortcodes](http://www.hostliketoast.com/2011/12/how-extend-wordpress-powerful-shortcodes/ "What are WordPress Shortcodes?").
* Shortcode [TBS_BUTTON] : produces a Twitter Bootstrap styled BUTTON [Guide on Button shortcode here](http://www.hostliketoast.com/2011/12/master-twitter-bootstrap-using-wordpress-shortcodes-part-1-buttons/ "Master Twitter Bootstrap Buttons using WordPress Shortcodes")
* Shortcode [TBS_LABEL] : produces a Twitter Bootstrap styled LABEL [Guide on Label shortcode here](http://www.hostliketoast.com/2011/12/master-twitter-bootstrap-using-wordpress-shortcodes-part-2-labels/ "Master Twitter Bootstrap Labels using WordPress Shortcodes")
* Shortcode [TBS_BLOCK] : produces a Twitter Bootstrap styled BLOCK Messages [Guide on Blockquote shortcode here](http://www.hostliketoast.com/2011/12/master-twitter-bootstrap-using-wordpress-shortcodes-part-4-alerts-and-block-messages/ "Master Twitter Bootstrap Labels using WordPress Shortcodes")
* Shortcode [TBS_CODE] : produces a Twitter Bootstrap styled CODE BLOCK
* Shortcode [TBS_TWIPSY] : produces a Twitter Bootstrap TWIPSY mouse over effect [Guide on Twipsy shortcode here](http://www.hostliketoast.com/2011/12/master-twitter-bootstrap-using-wordpress-shortcodes-part-5-twipsy-rollovers/ "Master Twitter Bootstrap Labels using WordPress Shortcodes")
* Shortcode [TBS_POPOVER] : produces a Twitter Bootstrap POPOVER window
* Shortcode [TBS_DROPDOWN] + [TBS_DROPDOWN_OPTION] : produces a Twitter Bootstrap styled DROPDOWN MENU
* Shortcode [TBS_TABGROUP] + [TAB] : produces a Twitter Bootstrap TAB! Now you can create TAB'd content in your posts!
* More documentation will be forthcoming in the [Worpit WordPress Plugins Page](http://worpit.com/wordpress-twitter-bootstrap-css-plugin-home/ "Worpit WordPress Twitter Bootstrap Plugin").

= 0.7 =
* Quick fix for Login and Register pages - for now there is no Bootstrap added to the login/register pages whatsoever.

= 0.6 =
* Updated to account for the latest version of Twitter Bootsrap version 1.4.0

= 0.5 =
* Re-added the attempt utilize W3 Total Cache "flush all" if the plugin is active (compatible with W3 Total Cache v0.9.2.4)
* Added some more screenshots to the docs

= 0.4 =
* Added the ability to include your own custom CSS file using a URL for the source. This custom CSS
file will be linked immediately after the bootstrap CSS (if you add it).

= 0.3 =
* Added support for 'Bootstrap, from Twitter' Javascript libraries. You can now select which of the invididual JS libraries to include.
* Inclusion of Javascript libraries is dependent upon selection of Twitter Bootstrap CSS. If this is not selected, no Javascript is added.
* Option to load Javascript files in the "HEAD" (using wp_head). The default, and recommended, is just before the closing html "BODY" (using wp_footer).

= 0.2 =
* Updated Twitter Bootstrap CSS link to version 1.3.0.

= 0.1.2 =
* Removed support for automatic W3 Total Cache flushing as the author of the other plugin has altered his code. This
is temporary until we fix.

= 0.1.1 =
* bugfix for 'None' option. Update recommended.

= 0.1 =
* First public release
* Allows you to select 1 of 3 possible styles: YUI 2 Reset; normalize CSS; or Twitter Bootstrap CSS.
* YUI 2 version 2.9.0
* Normalize CSS version 2011-08-31
* Twitter Bootstrap version 1.2.0

== Upgrade Notice ==

= 2.1.0.0 =
* UPDATED: Twitter Bootstrap library to latest release of 2.1.0

= 2.0.4.8 =
* New Shortcode!
* New Shortcode Help.

= 2.0.4.6 =
* FIXED: (again) Fatal error reported- http://wordpress.org/support/topic/plugin-wordpress-twitter-bootstrap-css-cant-activate-the-plugin-because-of-fatal-error
* UPDATED: Normalize.css to latest version (2012-07-07) at time of release
* ADDED: Shortcode TBS_SPAN - this is just an alias for TBS_COLUMN added previously.
* ADDED: offset parameter to the TBS_SPAN (and TBS_COLUMN) to reflect offset option in Twitter Bootstrap.
* ADDED: Responsive CSS is automatically recompiled when CSS is recompiled (regardless of whether responsive is enabled or not)

= 2.0.4.5 = 
* ADDED: NONCE to form submissions to improve the security of the plugin.
* ADDED: A new compile button - compile CSS from Original or customized Variable.less an option (http://wordpress.org/support/topic/plugin-wordpress-twitter-bootstrap-css-make-compile-variablesless-from-original-an-option)
* FIXED: Fatal error reported- http://wordpress.org/support/topic/plugin-wordpress-twitter-bootstrap-css-cant-activate-the-plugin-because-of-fatal-error

= 2.0.4.4 =

* FIXED: Further attempt to fix string escape issues (thanks Troy!).
* FIXED: Bug with Grid Columns field being appended with 'px' in LESS compiler.
* UPDATED: LESS PHP compiler to latest release (v0.3.5)

= 2.0.4.3 =

* FIXED: An attempt to fix problems some people have with the LESS compiler and escaping double-quoted fonts.

= 2.0.4.2 =

* FIXED: Wasn't properly linking to Google Prettify CSS and JS files when the option was enabled.
* UPDATED: Uses serialized data for the LESS CSS plugin options - greatly reducing database calls on the admin section and database usage.
* UPDATED: Plugin now uses Worpit's standard plugin structure for dynamically creating plugin options pages. The whole plugin is more stable and more reliable.
* UPDATED: Now flushes W3 Total Cache (if installed) when you update your LESS CSS options also.
* ADDED: Worpit feed to the news feed.

= 2.0.4.1 =

* FIXED: Reported Bug (thanks Claudio!) with Responsive CSS includes - there was a typo in the code and the CSS wasn't linked to correctly.

= 2.0.4 =
* UPDATED: Twitter Bootstrap version 2.0.4
* ADDED: Option - to replace WordPress JQuery library with the latest (at the time of plugin release) as served from Google CDN
* IMPROVED much of the plugin code.
* IMPROVED variable.less integrity. Now always uses the original copy for LESS compilation in case it becomes corrupted.
* IMPROVED Upgrade handling in terms of LESS compiled CSS. Now automatically recompiles CSS upon upgrade where applicable.
* IMPROVED [TBS_ROW] shortcode to allow fluid rows/containers and also to allow option of creating a container or not. Default to NOT creating container.
* FIXED: A few reported bugs.

= 2.0.3 =
* ADDED: LESS Compiler for some of the most common Bootstrap style options! ( [thanks to LESSCPHP](http://leafo.net/lessphp/) )
* ADDED: Option - toggle use of minimized or non-minized Bootstrap CSS
* ADDED: Option - toggle delete all plugin settings upon plugin deactivation
* ADDED: Option - enable LESS compiler and include less-compiled CSS
* ADDED: Now enqueues native WordPress JQuery Javascript when Bootstrap Javascript is enabled.
* ADDED: Yahoo YUI! reset.css v3.4.1
* UPDATED: Plugin upgrade handling is much improved
* UPDATED: Normalize CSS updated to the latest version
* REMOVED: Support Twitter Bootstrap v1.4.0 ("legacy") !
* REMOVED: Support for Individual Twitter Bootstrap Javascript Libraries !

= 2.0.2.3 =
* ADDED: LESS Compiler for some of the most common Bootstrap style options ( [thanks to LESSCPHP](http://leafo.net/lessphp/) )
* ADDED: Option - use minimized or non-minized Bootstrap CSS
* ADDED: Option - delete all plugin settings upon deactivation
* ADDED: Option - enable LESS compiler and include less-compiled CSS
* ADDED: Now enqueues native WordPress JQuery Javascript when Bootstrap Javascript is enabled.
* ADDED: Yahoo YUI! reset to version v3.4.1
* UPDATED: Plugin upgrade handling is much improved
* UPDATED: Normalize CSS to the latest version
* REMOVED: Support Twitter Bootstrap v1.4.0 ("legacy")
* REMOVED: Support for Individual Twitter Bootstrap Javascript Libraries.

= 2.0.2.2 =
Skipped.

= 2.0.2.1 =
* ADDED: *Ability to include Twitter Bootstrap CSS in WP Admin (along with some CSS fixes to accomodate)*
* ADDED: WordPress Admin notices for upgrades and success settings operations.
* ADDED: New Shortcode: TBS_BADGE
* ADDED: Host Like Toast RSS News feed on Dashboard + option to hide (hlt-rssfeed-widget.php)
* UPDATED: Settings page now uses a new Twitter Bootstrap layout/design
* UPDATED: The screenshots for the docs
* STARTED: The process of Internationalisation (I18n) for the plugin. Anyone who wants to help out, please get in touch.

= 2.0.2 =
* UPDATED: Updated Twitter Bootstrap library to v2.0.2
* ADDED: Ability to include Responsive CSS stylesheet that comes with Twitter Bootstrap version 2.0+
* ADDED: Reorg'd some of the interface to be a little more logical
* FIXED: serious oversight with including individual Javascript libraries.

= 2.0.1c =
* ADDED: Ability to add the "disabled" option to Twitter Bootstrap button components.
* FIXED: a couple of bugs in the shortcodes

= 2.0.1b =
* ADDED: New shortcode [TBS_ICON](http://bit.ly/zmGUeD "Twitter Bootstrap Glyph Icon WordPress Shortcode") to allow you to easily make use of [Twitter Bootstrap Glyphicons](http://bit.ly/AxCdQj)
* ADDED: New shortcode [TBS_BUTTONGROUP] to allow you to easily make use of [Twitter Bootstrap Button Groups](http://bit.ly/z13ICu)
* CHANGED: Rewrote [TBS_BUTTON]. Now you can add "toggle" option, and specify the exact html element type, eg [a], [button], [input]
* CHANGED: Rewrote [TBS_ALERT]. Now you can add the Alert Heading using the parameter: heading="my lovely heading"
* With [TBS_ALERT], parameter "type" is no longer supported - use parameter "class" instead
* CHANGED: Added inline Javascript for activating Popover and Tooltips - nice page-loading optimization and also only execute JS code necessary
* Throughout, attempted to retain support for Twitter Bootstrap 1.4.0. But no guarantees - you should upgrade and convert asap.
* TODO: necessary javascript snippet to enable button toggling - couldn't get it working.

= 2.0.1 =
* Twitter Bootstrap library upgraded to v2.0.1

= 2.0.0 =
* Added the options for Twitter Bootstrap Library 2.0.0
* Maintained compatibility with Twitter Bootstrap Library 1.4.0
* Removed option to HotLink to resources
* Added more Javascript libraries for 1.4.0 and 2.0.0
* Fixed several bugs.
* Keeping plugin version numbering in-line with Twitter Bootstrap versioning.
* References to "Twipsy" renamed to "Tooltips" to be inline with version 2.0.0
* Most SHORTCODES work between both versions. [Latest Notes](http://bit.ly/wLkYjf "Host Like Toast WordPress Twitter Bootstrap plugin release notes v2.0")

= 0.9.1 =
* Restructured and centralized CSS on admin side.

= 0.9 =
* Improved compatibility with WordPress 3.3 and some bug fixes.

= 0.8.6 =
* [TBS_TWIPSY] and [TBS_POPOVER] are by default <SPAN> tags (There may be an option at a later date to specify the element)

= 0.8.5 =
* Made some functional improvements to [TBS_TWIPSY]
* Fixed [TBS_POPOVER].

= 0.8.4 =
* Fixed a quoting bug in [TBS_BLOCK]
* Added [TBS_ALERT] shortcode

= 0.8.3 =
* Added option to inline "style" labels, blocks, and code.
* Added [TBS_BLOCKQUOTE] shortcode with parameter "source" for citing source.

= 0.8.2 =
* Added option to "style" buttons inline.
* Some bug fixes with shortcodes.

= 0.8 =
* This is a huge release. We have implemented some of the major Twitter Bootstrap feature through [Wordpress Shortcodes](http://www.hostliketoast.com/2011/12/how-extend-wordpress-powerful-shortcodes/ "What are WordPress Shortcodes?").

= 0.7 =
* Quick fix for Login and Register pages - for now there is no Bootstrap added to the login/register pages whatsoever.

= 0.6 =
* Updated to account for the latest version of Twitter Bootsrap version 1.4.0

= 0.5 =
* Re-added the attempt utilize W3 Total Cache "flush all" if the plugin is active (compatible with W3 Total Cache v0.9.2.4)

= 0.4 =
* Added the ability to include your own custom CSS file using a URL for the source. This custom CSS
file will be linked immediately after the bootstrap CSS (if you add one).

= 0.3 =
* Added support for 'Bootstrap, from Twitter' Javascript libraries. You can now select which of the invididual JS libraries to include.

= 0.2 =
* Updated Twitter Bootstrap CSS link to version 1.3.0.

= 0.1.2 =
* Removed support for automatic W3 Total Cache flushing as the author of the other plugin has altered his code. This
is temporary until we fix.

= 0.1.1 =
* bugfix for 'None' option. Update recommended.

= 0.1 =
* First public release