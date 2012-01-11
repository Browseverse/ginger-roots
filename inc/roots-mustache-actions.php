<?php

/* 
 * Before a template is rendered, a call to $context->update() is made.
 * The call will trigger the roots_mustache_context_update action
 *
 * This file includes some actions used primarily to add data to the context
 * for rendering within mustache templates.
 *
 * This allows updates to the context so it can be used in any mustache template
 * or partials
 *
 */
add_action('roots_mustache_context_update', 'roots_page_breadcrumb');

function roots_page_breadcrumb() {
  global $context;
  if (function_exists('yoast_breadcrumb')) {
    if ($context->is_page && $context->post_parent) {
      yoast_breadcrumb('<p id="breadcrumbs">','</p>');
      $context->yoast_breadcrumb = yoast_breadcrumb('','', false);
    }
  }
}

?>
