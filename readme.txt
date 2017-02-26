=== Current Planetary Positions ===
Contributors: isabel104
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=me%40isabelcastillo%2ecom
Tags: current planets, planetary, positions, astrology, zodiac, planets positions, ephemeris
Requires at least: 3.7
Tested up to: 4.7.2
Stable tag: 2.1.1
License: GNU GPL Version 2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Astrology widget which displays the current positions of the planets in the zodiac signs.

== Description ==

Current Planetary Positions is a WordPress plugin that adds a widget which displays the positions of the sun, the moon, Mercury, Venus, Mars, Jupiter, Saturn, Uranus, Neptune, Pluto, Chiron, and the North Node in the zodiac signs. From left to right, the columns display the planet's name, the degree of zodiac sign, zodiac sign symbol, zodiac sign text, the minute of degree, the second of degree, and retrograde motion (when indicated). If there appears an 'R' in the last column, then that planet is in apparent retrograde motion. The sun and moon are never retrograde. Please note: astrologers refer to all 11 of these celestial bodies and points as "planets" for the sake of convenience.

The zodiac sign symbols are color coded according to their element: red for fire signs, green for earth, yellow for air, and blue for water. The widget also displays the current local date and time of the viewer, as given by the viewer's browser. 

Current Planetary Positions uses the Swiss Ephemeris to get the longitude of the planets/celestial bodies.

**Languages**

These languages are included in the plugin:

- English (default)
- Arabic
- French
- Hindi
- Spanish

This plugin is translation-ready, and includes a `.pot` file to make it easy for you to translate it into other languages.

For more info, see the FAQ, the Installation instructions (links above), or the [plugin web page](https://isabelcastillo.com/docs/about-current-planetary-positions) which includes documentation and troubleshooting help.

For Support or suggestions, please use the official Support Forum (link above).

Fork or contribute [on GitHub](https://github.com/isabelc/current-planetary-positions).

== Installation ==

**Install and Activate**

1. Install and activate the plugin in your WordPress dashboard by going to Plugins –> Add New. 
2. Search for "Current Planetary Positions" to find the plugin.
3. When you see it, click “Install Now” to install the plugin.
4. Click “Activate” to activate the plugin.

**Quick Setup**

1. The Current Planetary Positions widget will be available in `Appearance -> Widgets`. To use the widget, drag the widget to a sidebar widget area like you would any other widget.

**If your website uses Windows hosting**

If your website is running on a Windows operating system (i.e. using Windows hosting), then you’ll need to use the [ZodiacPress Windows Server](https://cosmicplugins.com/downloads/zodiacpress-windows-server/) plugin to make the Ephemeris work on your server. This is because the Ephemeris included in Current Planetary Positions will not run on Windows, by default. Just install and activate the “ZodiacPress Windows Server” plugin, and it will automatically solve this problem.

== Frequently Asked Questions ==

= Why are all positions stuck on Aries? =

There are 3 possible reasons for all positions to be stuck on Aries.

**1.**  If your website is running on a Windows operating system (i.e. using Windows hosting), then you’ll need to use the [ZodiacPress Windows Server](https://cosmicplugins.com/downloads/zodiacpress-windows-server/) plugin to make the Ephemeris work on your server. This is because the Ephemeris included in Current Planetary Positions will not run on Windows, by default. Just install and activate the “ZodiacPress Windows Server” plugin, and it will automatically solve this problem. Note that ZP Windows Server only works with Current Planetary Positions version 2.0+, not with earlier versions of Current Planetary Positions.


**2.**  This plugin uses the PHP exec() function. Some hosting providers disable the exec() function. If this function is disabled, the plugin will not work. If your host has disabled this function, contact them as they may have a way for you to enable it. (Check their support pages.)

**3.**  It may be that your server did not allow the plugin to set the proper file permissions for the Swiss Ephemeris. [See this](https://isabelcastillo.com/docs/about-current-planetary-positions#docs-swetest) for help.

= How can I enable exec() on Namecheap host? = 

[See this](https://www.namecheap.com/support/knowledgebase/article.aspx/9396/2219/how-to-enable-exec) to enable the exec() function on Namecheap host.

= How can I change the CSS style of the widget? =

1. To style the entire widget, use this selector:

`.widget_cpp_widget`

2. To style the widget title, use this selector:

`.widget_cpp_widget h3`

3. To style the everything except the title, use this selector:

`#current-planets`

4. To style just the date, use this selector:

`#current-planets #localtime`

5. To style just the table of positions, use this selector:

`#current-planets table`

**CSS Style Suggestions**

To center the widget title and the date and time, add this to `cpp.css`:

`.widget_cpp_widget h3, #current-planets #localtime  {
	text-align:center;
}`

== Screenshots ==
1. Current Planetary Positions widget
2. Zoomed in - Current Planetary Positions widget

== Changelog ==

= 2.1.1 =
* Tweak - The plugin textdomain should be loaded on the init action rather than the plugins_loaded action.
* Tweak - Updated links to plugin URI and plugin documentation.

= 2.1 =
* New - Renamed the plugin stylesheet style.css to cpp.css.
* Tweak - Updated swetest to accommodate web servers that cannot read files compiled with GLibc 2.7+.

= 2.0 =
* New - Added North Node (true Node) to the widget.
* Fix - Added a solution for sites using Windows hosting. Previously, the ephemeris would not work on sites using Windows hosting.
* Fix - File permissions were not being checked properly which was causing ephemeris not to work on some sites.
* Fix - Fixed links in the readme file which were linking to the wrong plugin.

= 1.3.1 =
* Maintenance:  Updated the sweph binary files. The old ones may have been unreadable on some servers, and caused all planets set to 0 degrees Aries.

= 1.3 =
* Maintenance - Updated widget to work with the WordPress 4.0 live widget customizer.
* Maintenance - Compresses sprites for increased page speed.
* Maintenance - Minify the inline js for increased page speed.
* Maintenance - Removed unused icon.
* Maintenance - Removed one PHP warning.

= 1.2.6 =
* New: changed textdomain to be same as plugin slug. Updated all .pot, .mo, .po translation filenames accordingly.
* New: option to show UTC/GMT time instead of viewer's local time.
* New: singleton class.
* Maintenance: removed PHP warning for using undefined constants and for localized_full_sec.

= 1.2.5 = 
* Maintenance: Fixed typo in description.

= 1.2.4 = 
* New: removed Software Licensing plugin updater class.
* Maintenance: updated .pot file and all translation files.
* Maintenance: Tested and passed for WP 3.9 compatibility

= 1.2.3 = 
* New: plugin updates will now be available in WordPress dashboard.
* New: localized numbers.
* New: added French and Hindi language translations.
* Maintenance: updated .pot file and all translation files.

= 1.2.2 = 
* New: added Spanish language and Arabic language translations.
* New: added better support for rtl languages.
* Tweak: added background transparency to icons.
* Tweak: dynamic icons sizes to fit into thinner-width sidebars.
* Maintenance: added CSS for Twenty Fourteen theme compatibility.
* Maintenance: CSS tweaks: removed font color for compatibility with more themes.
* Maintenance: updated .pot file.

= 1.2.1 = 
* Maintenance: removed _vti_ files.

= 1.2 = 
* New: use sprite map for icons.

= 1.1 = 
* New: set chmod automatically.

= 1.0 =
* Initial release of the WP plugin version.

== Upgrade Notice ==

= 2.1 =
Updated to accommodate web servers that cannot read files compiled with GLibc 2.7+

= 2.0 =
Important fix for ALL sites, especially for sites using Windows hosting.
