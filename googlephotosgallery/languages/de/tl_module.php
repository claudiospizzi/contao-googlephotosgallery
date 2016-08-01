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
$GLOBALS['TL_LANG']['tl_module']['googlephotos_overview_legend'] = 'Google Photos Galerie (Overview)';
$GLOBALS['TL_LANG']['tl_module']['googlephotos_latest_legend']   = 'Google Photos Galerie (Latest)';


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_module']['googlephotos_overview_id']              = array('Google Photos Galerie', 'Bitte wählen Sie die Google Photos Galerie aus.');
$GLOBALS['TL_LANG']['tl_module']['googlephotos_overview_thumb_size']      = array('Album Miniaturansicht', 'Bitte geben Sie die Höhe und Breite der Miniaturansicht ein.');
$GLOBALS['TL_LANG']['tl_module']['googlephotos_overview_image_size']      = array('Album Foto', 'Bitte geben Sie die Breite der Fotos ein.');
$GLOBALS['TL_LANG']['tl_module']['googlephotos_overview_photo_size']      = array('Album Foto (Lightbox)', 'Bitte geben Sie die Breite der Fotos ein. (Lightbox)');
$GLOBALS['TL_LANG']['tl_module']['googlephotos_overview_album_template']  = array('Album Template', 'Wählen Sie das Album Tempalte aus.');
$GLOBALS['TL_LANG']['tl_module']['googlephotos_overview_photo_template']  = array('Photo Template', 'Wählen Sie das Photo Tempalte aus.');
$GLOBALS['TL_LANG']['tl_module']['googlephotos_overview_category_option'] = array('Album Kategorie aktivierung', 'Aktivieren oder deaktivieren der Album Kategorien');
$GLOBALS['TL_LANG']['tl_module']['googlephotos_overview_category_date']   = array('Album Kategorie Separator', 'Bitte geben Sie das Kategorie Seperator Datum an.');
$GLOBALS['TL_LANG']['tl_module']['googlephotos_latest_id']                = array('Google Photos Galerie', 'Bitte wählen Sie die Google Photos Galerie aus.');
$GLOBALS['TL_LANG']['tl_module']['googlephotos_latest_thumb_size']        = array('Album Miniaturansicht', 'Bitte geben Sie die Höhe und Breite der Miniaturansicht ein.');
$GLOBALS['TL_LANG']['tl_module']['googlephotos_latest_thumb_num']         = array('Anzahl Alben', 'Bitte geben Sie die Anzahl der Alben an, die angezeigt werden.');
$GLOBALS['TL_LANG']['tl_module']['googlephotos_latest_template']          = array('Latest Template', 'Wählen Sie das Latest Tempalte aus.');


/**
 * Text
 */
$GLOBALS['TL_LANG']['tl_module']['picasa_textPhoto']   = 'Bild';
$GLOBALS['TL_LANG']['tl_module']['picasa_textPhotoOf'] = 'von';


?>