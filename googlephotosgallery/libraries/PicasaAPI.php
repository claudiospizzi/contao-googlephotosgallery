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
 * Class PicasaAPI
 *
 * Provide methods to access the Picasa Gallery Feed.
 *
 * @copyright  Claudio Spizzi 2011
 * @author     Claudio Spizzi <http://www.spizzi.net>
 * @package    Picasa
 */
abstract class PicasaAPI
{
    /**
     * Picasa Gallery Base Feed
     * @const FEED
     */
    const FEED = 'http://picasaweb.google.com/data/feed/api/';
    
    /**
     * Picasa Gallery Thumbnail Size
     * @const IMAGE
     */
    const THUMB = '160';

    /**
     * Picasa Gallery Image Size
     * @const IMAGE
     */
    const IMAGE = '1600';

    /**
     * Fetch the Albums from Picasa Gallery Feed
     * @param string $username
     */
    public static function fetchAlbums($username)
    {
        // get feed from google
        $sxmlObject = @simplexml_load_file(PicasaAPI::FEED . 'user/' . $username . '?kind=album&thumbsize=' . PicasaAPI::THUMB . 'c&imgmax=' . PicasaAPI::IMAGE);

        // check error
        if($sxmlObject === false)
        {
            // exit from method
            return false;
        }
        
        // album value
        $albums = array();

        // get the feed namespaces
        $sxmlNamespaces = $sxmlObject->getDocNamespaces();

        // set the album data
        foreach($sxmlObject->entry as $item)
        {
            // get children
            $sxmlNamespacesGPhoto = $item->children($sxmlNamespaces['gphoto']);
            $sxmlNamespacesMedia = $item->children($sxmlNamespaces['media']);

            // get attributes (thumbnail & content)
            $albumThumbnail = $sxmlNamespacesMedia->group->thumbnail->attributes();
            $albumContent = $sxmlNamespacesMedia->group->content->attributes();

            // set album array
            $albums[] = array
            (
                'sid'         => (string) $sxmlNamespacesGPhoto->id,
                'name'        => (string) $sxmlNamespacesGPhoto->name,
                'title'       => (string) $sxmlNamespacesMedia->group->title,
                'timestamp'   => (string) $sxmlNamespacesGPhoto->timestamp / 1000,
                'imagePrefix' => (string) substr($albumContent['url'], 0, strpos($albumContent['url'], '/s' . PicasaAPI::IMAGE . '/') + 2),
                'imageSuffix' => (string) substr($albumContent['url'], strpos($albumContent['url'], '/s' . PicasaAPI::IMAGE . '/') + 2 + strlen(PicasaAPI::IMAGE)),
                'numPhotos'   => (string) $sxmlNamespacesGPhoto->numphotos
            );
        }

        // return
        return($albums);
    }
    
    /**
     * Fetch the Photos from Picasa Gallery Feed
     * @param string $username
     * @param integer $albumid
     */
    public static function fetchPhotos($username, $albumid)
    {
        // get feed from google
        $sxmlObject = simplexml_load_file(PicasaAPI::FEED . 'user/' . $username . '/albumid/' . $albumid . '?kind=photo&thumbsize=' . PicasaAPI::THUMB . 'c&imgmax=' . PicasaAPI::IMAGE);

        // check error
        if($sxmlObject === false)
        {
            // exit from method
            return false;
        }
        
        // album value
        $photos = array();

        // get the feed namespaces
        $sxmlNamespaces = $sxmlObject->getDocNamespaces();

        // set the album data
        foreach($sxmlObject->entry as $item)
        {
            // get children
            $sxmlNamespacesGPhoto = $item->children($sxmlNamespaces['gphoto']);
            $sxmlNamespacesMedia = $item->children($sxmlNamespaces['media']);

            // get attributes (thumbnail & content)
            $albumThumbnail = $sxmlNamespacesMedia->group->thumbnail->attributes();
            $albumContent = $sxmlNamespacesMedia->group->content->attributes();

            // set album array
            $photos[] = array
            (
                'sid'         => (string) $sxmlNamespacesGPhoto->id,
                'name'        => (string) $sxmlNamespacesGPhoto->name,
                'title'       => (string) $sxmlNamespacesMedia->group->title,
                'timestamp'   => (string) $sxmlNamespacesGPhoto->timestamp / 1000,
                'imagePrefix' => (string) substr($albumContent['url'], 0, strpos($albumContent['url'], '/s' . PicasaAPI::IMAGE . '/') + 2),
                'imageSuffix' => (string) substr($albumContent['url'], strpos($albumContent['url'], '/s' . PicasaAPI::IMAGE . '/') + 2 + strlen(PicasaAPI::IMAGE)),
                'numPosition' => (string) ((int)$sxmlNamespacesGPhoto->position)
            );
        }

        // return
        return($photos);
    }
}

?>