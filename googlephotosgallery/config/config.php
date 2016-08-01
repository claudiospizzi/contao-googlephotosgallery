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
 * Load libraries
 */
include_once(TL_ROOT . '/system/modules/googlephotosgallery/libraries/PicasaAPI.php');
include_once(TL_ROOT . '/system/modules/googlephotosgallery/libraries/PicasaGallery.php');
include_once(TL_ROOT . '/system/modules/googlephotosgallery/libraries/PicasaAlbum.php');
include_once(TL_ROOT . '/system/modules/googlephotosgallery/libraries/PicasaPhoto.php');
include_once(TL_ROOT . '/system/modules/googlephotosgallery/libraries/PicasaImage.php');


/**
 * Backend module
 */
array_insert($GLOBALS['BE_MOD'], 2, array
(
    'content' => array
    (
        'googlephotosgallery' => array
        (
            'tables' => array('tl_googlephotosgallery', 'tl_googlephotosgallery_album'),
            'icon'   => 'system/modules/googlephotosgallery/assets/googlephotos.png'
        )
    )
));


/**
 * Frontend module
 */
$GLOBALS['FE_MOD']['googlephotosgallery'] = array
(
    'googlephotos_overview' => 'ModulePicasaOverview',
    'googlephotos_latest'   => 'ModulePicasaLatest'
);


?>