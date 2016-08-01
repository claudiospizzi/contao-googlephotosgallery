<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
    // Libraries
    'PicasaImage'          => 'system/modules/googlephotosgallery/libraries/PicasaImage.php',
    'PicasaPhoto'          => 'system/modules/googlephotosgallery/libraries/PicasaPhoto.php',
    'PicasaAlbum'          => 'system/modules/googlephotosgallery/libraries/PicasaAlbum.php',
    'PicasaGallery'        => 'system/modules/googlephotosgallery/libraries/PicasaGallery.php',
    'PicasaAPI'            => 'system/modules/googlephotosgallery/libraries/PicasaAPI.php',

    // Modules
    'ModulePicasaOverview' => 'system/modules/googlephotosgallery/modules/ModulePicasaOverview.php',
    'ModulePicasaLatest'   => 'system/modules/googlephotosgallery/modules/ModulePicasaLatest.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
    'mod_googlephotos_latest'                => 'system/modules/googlephotosgallery/templates',
    'mod_googlephotos_latest_image'          => 'system/modules/googlephotosgallery/templates',
    'mod_googlephotos_overview_albums'       => 'system/modules/googlephotosgallery/templates',
    'mod_googlephotos_overview_albums_image' => 'system/modules/googlephotosgallery/templates',
    'mod_googlephotos_overview_photos'       => 'system/modules/googlephotosgallery/templates',
    'mod_googlephotos_overview_photos_image' => 'system/modules/googlephotosgallery/templates',
));
