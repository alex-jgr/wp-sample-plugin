# WordPress plugin template

Because many customers that I worked for prefer to have WordPress websites for their start ups, during the last two years I often got through the same routine code and practices when starting to build a wordpress plugin. In time I developed a template for use with every new plugin that I make and then I improved uppon it. It at least has a structure, as opposed to the bulks of hairy code that many other plugins out there are made of.

I decided to share it with whoever feels that working with WordPress is too chaotic.

I'll be updating this repository with code and explanations as I work on other projects.

For now this template is at the base of a RESTful client plugin for a third party API, so I haven't decided yet if I'm going to use the mustache.php library further, or use handlebars.js and move the visualisation concerns entirely to the front end.

Do whatever you may with the vendor folder and the autoloader.php. I don't have the time to look into every possible situation and I want to keep it lightweight.

## Placeholders

First look into the sample-plugin.php file. Change the header there with respect to the values that describe your plugin. Read this for more details:

[https://developer.wordpress.org/plugins/the-basics/header-requirements/]()

Throughout the files you will find the following words that you may need to replace in all files and matching cases:

| Word                    | Explanation |
|:------------------------|:------------|
| SamplePlugin            | The namespace for your plugin. Most files contain it. Replace it everywhere|
| sample-plugin-domain    | You can see it in the plugin file header. Change it to the value you need there, but be careful to what happens in */Services/Wizard.php* on line 18. You see on plugin activation the page "Sample Plugin Domain" is created if it did not exist. That page holds a shortcode for most of the plugin's functionality, so when you name that page make sure that you replace all the occurences of "sample-plugin-domain" with the resulting page slug in all the template files.  You can add more pages and shortcodes if you change the */Services/Router.php* accordingly (see methods: *rewriteRules()* and *parseRequest()*. |
| sample_plugin_page      | More suitable would be if I named it "sample_plugin_controller" - a query var for wp_rewrite. |
| sample_plugin_query     | Arguments for the controller. Should contain the "action", but override it if needed by defining the *setParams($params)* method inside the controller. |
| sample-plugin           | This is the name of some of the less and css files. It's also the name of the plugin. Rename them files in */Service/Wizard.php* on line 39 and rename the plugin folder in */Core/Controller.php* on the lines 70 and 73 |


All the best! :)