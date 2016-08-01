<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Module PicasaGallery
 * Copyright (C) 2011 Claudio Spizzi
 *
 * This Contao module integrates the Picasa Web Albums
 * as a frontend module inclusive backend management.
 *
 * PHP version 5
 * @copyright  Claudio Spizzi 2011
 * @author     Claudio Spizzi <http://www.spizzi.net>
 * @package    Picasa
 * @license    LGPL
 * @filesource
 */


/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_module']['googlephotos_overview_legend'] = 'Google Photos Gallery (Overview)';
$GLOBALS['TL_LANG']['tl_module']['googlephotos_latest_legend']   = 'Google Photos Gallery (Latest)';


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_module']['googlephotos_overview_id']              = array('Google Photos Gallery', 'Please choose a Google Photos Gallery.');
$GLOBALS['TL_LANG']['tl_module']['googlephotos_overview_thumb_size']      = array('Album Thumbnail', 'Please enter the album thumbnail height and width.');
$GLOBALS['TL_LANG']['tl_module']['googlephotos_overview_image_size']      = array('Album Image', 'Please enter the album image width.');
$GLOBALS['TL_LANG']['tl_module']['googlephotos_overview_photo_size']      = array('Album Image (Lightbox)', 'Please enter the album image width (Lightbox).');
$GLOBALS['TL_LANG']['tl_module']['googlephotos_overview_album_template']  = array('Album Template', 'Please choose the album tempalte.');
$GLOBALS['TL_LANG']['tl_module']['googlephotos_overview_photo_template']  = array('Photo Template', 'Please choose the photo tempalte.');
$GLOBALS['TL_LANG']['tl_module']['googlephotos_overview_category_option'] = array('Album category activation', 'Activate oder disable album categories.');
$GLOBALS['TL_LANG']['tl_module']['googlephotos_overview_category_date']   = array('Album category seperator', 'Please enter the category seperator date');
$GLOBALS['TL_LANG']['tl_module']['googlephotos_latest_id']                = array('Google Photos Gallery', 'Please choose a Google Photos Gallery.');
$GLOBALS['TL_LANG']['tl_module']['googlephotos_latest_thumb_size']        = array('Album Thumbnail', 'Please enter the album thumbnail height and width.');
$GLOBALS['TL_LANG']['tl_module']['googlephotos_latest_thumb_num']         = array('Album Number', 'Please enter the number of albums to display.');
$GLOBALS['TL_LANG']['tl_module']['googlephotos_latest_template']          = array('Latest Template', 'Please choose the latest tempalte.');


/**
 * Text
 */
$GLOBALS['TL_LANG']['tl_module']['picasa_textPhoto']   = 'Photo';
$GLOBALS['TL_LANG']['tl_module']['picasa_textPhotoOf'] = 'of';


?>