=== Yet Another Glossary ===
Contributors: Will Haley with AtlanticBT @ www.atlanticbt.com
Tags: glossary, tooltip, definition
Requires at least: 3.0
Tested up to: 3.4
Stable tag: 1.0.3
License: GPLv3 or later

== Description ==
This plugin allows for the creation of a dictionary via an admin screen.  When the words in that dictionary are 
found in the content of the post and/or pages, the word has the ability to provide the definition in a hover.  The
plugin allows for a glossary page to be created via a tag.

== Installation ==
Upload the plugin to your blog, Activate it, Enter words via the admin.
1, 2, 3: YAG!? You're done!

== Changelog ==
1.0.0 Initial release.
1.0.1 Updates a bug that failed to have the app load the qtip js lib
1.0.2 
  - Corrects an issue the over escapes the definitions
  - Add stripslash to the display of the definitions
  - Updates the init of the qtip to work properly 
1.0.3
  - Updates the code to also remove slashes with in the rest of the blog
  - Updates a small bug in the update function within the admin
2.0.0
  - Full WYSIWYG functionality for the definitions.
  - Pick which pages the glossary words will be applied to.
  - Limited customization of the tooltip's look and feel
  - Enhanced support for definitions of phrases
 2.0.1
  - Bug Fix:  "Match / Replace Type" setting wasn't properly showing the correct state.  
 2.0.2
  - Bug Fix:  Returns shortcode functionality.  