<?php
/*
Template Name: Courses list
*/

/**
 * Make empty page with this template 
 * and put it into menu
 * to display all Learndash Courses as streampage
 */

trueman_storage_set('blog_filters', 'learndash');

get_template_part('blog');
?>