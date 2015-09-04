<?php
/**
 * Theme related functions. 
 *
 */
 
/**
 * Get title for the webpage by concatenating page specific title with site-wide title.
 *
 * @param string $title for this page.
 * @return string/null wether the title_append is defined or not.
 */
function get_title($title) 
{
  global $urbax;
  return $title . (isset($urbax['title_append']) ? $urbax['title_append'] : null);
}