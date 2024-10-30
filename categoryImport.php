<?php
/*
Plugin Name: Category Import	
Plugin URI: http://wordpress.org/extend/plugins/category-import/
Version: v1.0.2
Author: Jiayu (James) Ji
Author URI: https://sites.google.com/site/jiayuji/
Description: This is a plug-in allowed user to bulk create categories with certain input format. Meanwhile, the plugin forces the category display by id.
*/

/*  
	Copyright 2011  Category Import  (email : Jiayu.ji@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


if(!class_exists("CategoryImport")){
	class CategoryImport{
	   function CategoryImport(){
	   }
	   
	   function form(){
	   
	   function create_category($catname,$catslug,$parent_id){
           
    	   $cat= get_term_by('slug', $catslug, 'category');
	   
           if(!empty($cat->term_id)) 
		return $cat->term_id;

           if(empty($cat->term_id)){	
		$catarr = array(
		'description'=> '',
		'slug' => $catslug,
		'parent'=> $parent_id );
		
		$ids = wp_insert_term($catname,'category',$catarr);
		
		$parent_id = $ids['term_taxonomy_id'];
		
		return $parent_id;
		}
	   }
		
		if(isset($_POST['submit'])){
		    $delimiter = strlen(trim($_POST['delimiter'])) != 0?$_POST['delimiter']:"$";
		    $lines = explode(PHP_EOL,$_POST['bulkCategoryList']);
		    foreach($lines as $line){
			$split_line = explode('/',$line);
				foreach($split_line as $new_line){
				  if(strlen(trim($new_line)) == 0)
				  break;
				  if(strpos($new_line, $delimiter) !== false){
					$cat_name_slug = explode($delimiter,$new_line);
					$cat_name = $cat_name_slug[0];
					$cat_slug = $cat_name_slug[1];
				  }else{
					$cat_name = $new_line;
					$cat_slug = $new_line;
				  }
				  
			 	  $parent_id = create_category($cat_name,$cat_slug,$parent_id);
				  if($parent_id == 0){
				  	$error = true;
				  	break 2;
				  }
				}
				$parent_id = '';
			}
			if($error)
			echo '<div id="message" class="updated fade"><p><strong>Exception happened !! Please check your input data !! </strong></p></div>';
			else
			echo '<div id="message" class="updated fade"><p><strong>Import successully finished!! </strong></p></div>';
		}
		wp_enqueue_script(�jquery�);
	   	?>
	<link rel="stylesheet" href="<?php echo WP_PLUGIN_URL; ?>/category-import/css/style.css" type="text/css"/>
	<script type="text/javascript" src="<?php echo WP_PLUGIN_URL; ?>/category-import/treeview.js"></script>
	<div id="formLayer">
	<h2>Category Import</h2>
	<form name="bulk_categories" action="" method="post">
	<span class="description">Enter the category you want to add.</span>
        <br/>
	<span class="description">If you want to make a hierarchy, put a slash between the category and the sub-category in one line.</span>
        <br/>
        <span class="example">Example : Level A/Level B/Level C</span>
	<br/>
	<br/>
	<span class="description">Define a delimiter here to split the category name and slug. (default: $)</span><input type="text" id="delimiter" name="delimiter" maxlength="2" size="2" onchange="validation(this);"/>
	<br/>
	<span class="example">Example : Level A / Level B$level-b1 / Level C$level-c1</span>
        <textarea id="bulkCategoryList" name="bulkCategoryList" rows="20" style="width: 80%;"></textarea>
        <br/>
	<div id="displayTreeView" name="displayTreeView" style="display:none;">
		<ul id="treeView" name="treeView" class="tree"></ul>
	</div>
        <p class="submit">
		<input type="button" id="preview" name="preview" value="Preview" onclick="treeView();"/>
		<input type="button" id="closePreview" name="closePreview" value="Close Preview" style="display:none;" onclick="hideTreeView();"/>
		<input type="submit" id="submit" name="submit" value="Add categories"/>
	</p>
         </form>
	</div>
	
		 <?php
	   }
	   
	   
	}
}


function admin_import_menu() {
    require_once ABSPATH . '/wp-admin/admin-functions.php';
    if(class_exists("CategoryImport")){
	$dl_categoryImport = new CategoryImport();
	}	
	add_submenu_page("edit.php", 'Category Import', 'Category Import', 'manage_options', __FILE__, array($dl_categoryImport, 'form'));
	
}

add_action('admin_menu', 'admin_import_menu');

add_filter('get_terms', 'order_category_by_id', 10, 3);

function order_category_by_id($terms, $taxonomies, $args){
	if($taxonomies[0] == "category" && $args['orderby'] == 'name')
	 $terms = get_categories(array('hide_empty' => 0,'orderby' => 'id'));
	 return $terms;
}

?>