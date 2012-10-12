=== Janolaw AGB Hosting ===
Tags: legal documents, shop, imprint, disclaimer
Requires at least: 3.0
Tested up to: 3.4.2
Stable tag: 3.0

This plugin get legal documents provided by Janolaw AG (commercial service) like AGB, Imprint etc. for Webshops and Pages. (German Service only)

== Description ==

This plugin get legal documents provided by Janolaw AG (commercial service) like AGB, Imprint etc. for Webshops and Pages.
For more Informations visit: http://www.janolaw.de/internetrecht/agb/agb-hosting-service/
The service only provide german documents!

== Installation ==

1. Upload the folder `janolaw_agb` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Enter your personal IDs provided by Janolaw AG at `Settings -> Janolaw AGB Service` (UserID / ShopID)
4. Enter a path writeable for the Webserver to cache documents (should be by default: /tmp on most linux/unix systems)
5. Use the following tags at the desired pages [janolaw_agb], [janolaw_impressum], [janolaw_widerrufsbelehrung], [janolaw_datenschutzerklaerung]
6. Done !

== Frequently Asked Questions ==

= What if i have a question? =

Write your question at wordpress@code-worx.de !

= Howto style the documents?

Use this CSS !

#janolaw-body ol li {
	list-style: upper-roman;
	margin-left: 40px;
}
#janolaw-paragraph {
	color: #555;
	font-size: 14px;
	font-weight: bold;
	margin: 10px 0 10px;
	padding: 0 0 5px;
	}
#janolaw-absatz {

	}
.janolaw-text {
	font-size: 12px;
	margin-left: 40px;
	}

== Screenshots ==

1. Janolaw Settings

== Changelog ==

= 2.2 =
* added multilanguage files for English + German

= 2.1 =
* fixed privacy page

= 2.0 =
* tmp folder predefined default
* checkboxes for automatic page creation to makes it even simpler for users to install

= 1.0 =
* Initial Version

