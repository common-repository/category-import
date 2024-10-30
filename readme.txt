=== Plugin Name ===
Contributors: Jamc
Tags:category, categories, bulk, import,
Requires at least: 3.0.0
Tested up to: 3.0.4
Stable tag: 1.0.2

== Description ==

This is a plug-in allowed user to bulk create categories with certain input format. Meanwhile, the plugin forces the category to display by id.

== Installation ==

1.Download the plugin and expand it if necessary.

2.Create a folder named 'CategoryImport'under the plugin folder(wp-content/plugins/) and copy the file 'category-order.php' into it.

3.Login into the WordPress administration area and go to the plugin page.

4.Click the activate link of the 'Category Import' plugin.

5.You can go to Posts -> Category Import and import the categories.

6.This plugin also force the category to be displayed ordered by id. In other word, it may cause other plugin which allows you to reorder the category ineffective. 


== Frequently Asked Questions ==

= 1.How can I import categories? =

You can put one category per line.eg: 

Chapter One

Chapter Two

Chapter Three

You can also create a hierarchy by placing a slash between categories in one line.
eg: Level A / Level B / Level C

If you have a hierarchy like this

Level A - Level B - (Level C/Level D) (level C and level D are both the sub-cateogries of level B)

You can put it either in this way

Level A / Level B / Level C

Level A / Level B / Level D

or this way

Level A / Level B / Level C

Level B / Level D

According to the plugin, the second one will be more efficient.

= 2.How to import subcats with the same name =
From version 1.0.2, between each slash, you are allowed to put a delimiter to separate the category name and slug.
The plugin will then use the slug to identify different category. Be notice that if the slug is not given, name will also be used as slug.
By default, the delimiter is dollar("$"), but you can change it to any character you want, except slash("/"). 

eg:

input

Level A1 / Level B$level-b1 / Level C$level-c1

Level A2 / Level B$level-b2 / Level C$level-c2

output

Level A1 
      - Level B 
              - Level C

Level A2
      - Level B
              - Level C


= 3.Can I remove the order by id feature? =

At the version 1.0, I didn't provide a switch for this feature.
But if you want to do this, simply open the 'categoryImport.php' file with your notepad.
Find the line 100, you should see a line of code like this:

add_filter('get_terms', 'order_category_by_id', 10, 3);

If you find that, put two slash at the beginning of this line:

//add_filter('get_terms', 'order_category_by_id', 10, 3);

Save and close the file. That's it.

== Changelog ==

= 1.0.2 =
* slug editing allowed. This feature is made to support importing subcats with the same name under different categories. 

= 1.0.1 =
* Preview was added. Now you can have a preview after you paste the category data into the textarea to see whether your format is appropirate.

== Screenshots ==

1.Sample input

2.Sample preview
