<?php

/**
 * @file
 * For document catlog list page used by ctools.
 */
$page = new stdClass;
$page->disabled = FALSE; /* Edit this to true to make a default page disabled initially */
$page->api_version = 1;
$page->name = 'catalog_document';
$page->task = 'page';
$page->admin_title = 'document catalog';
$page->admin_description = '';
$page->path = 'covidien/admin/document';
$page->access = array();
$page->menu = array(
  'type' => 'none',
  'title' => '',
  'name' => 'navigation',
  'weight' => '0',
  'parent' => array(
    'type' => 'tab',
    'title' => '',
    'name' => 'navigation',
    'weight' => '0',
  ),
);
$page->arguments = array();
$page->conf = array();
$page->default_handlers = array();
$handler = new stdClass;
$handler->disabled = FALSE; /* Edit this to true to make a default handler disabled initially */
$handler->api_version = 1;
$handler->name = 'page_catalog_document_panel_context';
$handler->task = 'page';
$handler->subtask = 'catalog_document';
$handler->handler = 'panel_context';
$handler->weight = 0;
$handler->conf = array(
  'title' => 'Panel',
  'no_blocks' => 0,
  'pipeline' => 'standard',
  'css_id' => '',
  'css' => '',
  'contexts' => array(),
  'relationships' => array(),
);
$display = new panels_display;
$display->layout = 'flexible';
$display->layout_settings = array();
$display->panel_settings = array(
  'style_settings' => array(
    'default' => NULL,
    'center' => NULL,
  ),
);
$display->cache = array();
$display->title = '';
$display->content = array();
$display->panels = array();
$pane = new stdClass;
$pane->pid = 'new-1';
$pane->panel = 'center';
$pane->type = 'block';
$pane->subtype = 'views--exp-documentlist-page_1';
$pane->shown = TRUE;
$pane->access = array();
$pane->configuration = array(
  'inherit_path' => 1,
  'override_title' => 0,
  'override_title_text' => '',
);
$pane->cache = array();
$pane->style = array(
  'settings' => NULL,
);
$pane->css = array();
$pane->extras = array();
$pane->position = 0;
$display->content['new-1'] = $pane;
$display->panels['center'][0] = 'new-1';
$pane = new stdClass;
$pane->pid = 'new-2';
$pane->panel = 'center';
$pane->type = 'views';
$pane->subtype = 'documentlist';
$pane->shown = TRUE;
$pane->access = array();
$pane->configuration = array(
  'override_pager_settings' => 0,
  'use_pager' => 1,
  'nodes_per_page' => '10',
  'pager_id' => '',
  'offset' => '0',
  'more_link' => 0,
  'feed_icons' => 0,
  'panel_args' => 0,
  'link_to_view' => 0,
  'args' => '',
  'url' => '',
  'display' => 'page_1',
  'override_title' => 1,
  'override_title_text' => '<none>',
);
$pane->cache = array();
$pane->style = array(
  'settings' => NULL,
);
$pane->css = array();
$pane->extras = array();
$pane->position = 1;
$display->content['new-2'] = $pane;
$display->panels['center'][1] = 'new-2';
$display->hide_title = PANELS_TITLE_FIXED;
$display->title_pane = '0';
$handler->conf['display'] = $display;
$page->default_handlers[$handler->name] = $handler;
