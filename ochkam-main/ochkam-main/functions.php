<?php 


function content_wrapper(callable $func){
    return function(...$args) use ($func){
        // echo '<section id="site-content">';
        get_header();
        $res = $func(...$args);
        get_footer();
        return $res;
    };


}



function run_loop(callable $format_post=NULL){
    // global $content_formatter;
    
     if(!isset($format_post)){
        $format_post = function(){
            get_template_part("/parts/post","defualt_format");
        };
    //     $format_post = $content_formatter[get_post_type()];
     }
    if(have_posts()){
        while(have_posts()){
            the_post();
            $format_post();
        } 
    }else{
        get_template_part("/parts/404","no_resources");
    }


}



function hook_actions(){
    add_action('wp_enqueue_scripts',function(){
        wp_enqueue_script('ockham-index-script',get_theme_file_uri('/build/index.js'),NULL,wp_get_theme()->get('Version'),true);
        wp_enqueue_style('ockham-index-styles', get_theme_file_uri('/build/index.css'));
    });
}

hook_actions();


function htmlElement($element_tag, $element_content, $props=NULL){
	echo "<".$element_tag;
    
    	 foreach($props as $p_name=>$p_value){
    		printf(' %s="%s"',$p_name,$p_value);
    }
    
    echo ">";
    
    if(gettype($element_content)=='array'){
    
    	if(gettype($element_content[0])=='array'){
        	foreach($element_content as $innerEL){
            	htmlElement(...$innerEL);
            }
        }else{
        	htmlElement(...$element_content);
        }
    
      
    }
    else{
    	echo $element_content;
    
    }
    
    
    printf('</%s>',$element_tag);

}


htmlElement("h1", "my first php script!");

htmlElement("div", array("p","inner element"), array("style"=>"color:red; border: solid;"));







?>