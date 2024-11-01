=== WP Tags to Technorati ===
Contributors: midrangeman
Donate link: http://www.geekyramblings.org/plugins/donate/
Tags: tags,technorati
Requires at least: 2.3.0
Tested up to: 3.0
Stable tag: Trunk

This plugin will create technorati tags from native Wordpress tags

== Installation ==

1. Upload the full directory into your wp-content/plugins directory
2. Activate it in the Plugin options

(pretty simple, eh?)

== Options ==

1. Text that appears to the left of the tags can be adjusted by 
   changing the "Technorati Tags label" field.

2. Enabling the "Open Technorati Link in new window?" option will cause
   the generated links to open in a new window.

3. Enabling the 'Add rel="nofollow" to generated links?' option will
   cause the geenerated links to have nofollow added to the rel 
   attribute on the technorati links (they already have a 'tag' 
   attribute).

== Advanced Usage ==

If you wish to include the technorati tags in a different place on a page,
you can disable the "Include tags in post footer?" option and modify your
blogs theme to echo the output of the 'tags2tech_get_tags_links()' 
function inside the wordpress 'loop'.

NOTE: In previous versions of the plug-in the tags2tech_get_tags_links() 
call needed to be echo'ed.  This is no longer required, although the old
functionality will still work.

== Changelog ==

= 0.1 =
* Initital version        

= 0.2 =
* Added comment markups

= 0.3 =
* Added class's to generated links and fixed problem with single tag.

= 0.4 =
* Properly encode the generated tag url.

= 0.5 =
* Added setting so user can change the prefix label

= 0.6 =
* Added the ability to not include the tags in the footer, so they could be manually put in a theme.

= 0.7 =
* Added a control to allow technorati tags to open in a new window. 
* Added version identifier to comment.

= 0.8 =
* Reformatted setup panel.
* tags2tech_get_tags_links() no longer needs to be echo'ed.  When invoked directly, it will output the links directly.  It will still work with the echo method though.

= 0.9 = 
* Fixed the positioning of the tags.
* tags2tech_get_tags_links() output must once again be echoed.
* Fixed a problem where this plug-in broke the visual editor.

= 0.95 =
* Links can now be tagged with 'rel=nofollow'.

= 1.0 = 
* Add option to control if tags show up in RSS feed.

= 1.01 = 
* Add option to control if tags show up on main page.

= 1.02 =
* Externalized text so it could be translated.

== Frequently Asked Questions == 

= Works it with all WordPress versions? =

This version works with WordPress 2.3.0 and better.  It's dependent on the new
Wordpress tagging feature.

== Credits ==

As I am not a professional PHP programmer, I relied heavily on the plug-in 
work of a few others ...

1. John Godley's Google Ad Wrap (http://www.urbangiraffe.com/plugins/google_ad_wrap)
2. Artur Ortega's SimpleTags (http://www.broobles.com/scripts/simpletags)

== License ==

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

