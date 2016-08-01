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
 * Class ModulePicasaLatest
 */
class ModulePicasaLatest extends Module
{
    /**
     * Module Template
     * @var string
     */
    protected $strTemplate = 'mod_googlephotos_latest';

    /**
     * Generate the Backend Module Description
     * @return unknown
     */
    public function generate()
    {
        // check backend mode
        if(TL_MODE == 'BE')
        {
            $objTemplate = new backendTemplate('be_wildcard');
            $objTemplate->wildcard = '### PICASA LATEST (' . $this->id . ': ' . $this->name . ') ###';

            return $objTemplate->parse();
        }

        // return
        return parent::generate();
    }

    /**
     * Compile the Frontend Module
     */
    protected function compile()
    {
        // init articles
        $articles = array();

        // create gallery object
        $gallery = new PicasaGallery($this->googlephotos_latest_id);

        // get albums
        $albums = $gallery->getAlbums();

        // iterating albums
        for($c = 0; $c < $this->googlephotos_latest_thumb_num; $c++)
        {
            // set album
            $album = current($albums);

            // check published album
            if($album->getPublished() == true)
            {
                // parse and add
                $articles[] = $this->compileAlbum($album);
            }

            // goto next album
            next($albums);
        }

        // set articles
        $this->Template->articles = $articles;
    }

    /**
     * Compile the Frontend Module (album)
     */
    protected function compileAlbum($album)
    {
        // get image
        $image = $this->convertAlbumToImage($album);

        // create template
        $objTemplate = new FrontendTemplate('mod_googlephotos_latest_image');

        // set template data
        $objTemplate->title = $album->getTitle();
        $objTemplate->image = $image->getImg();
        $objTemplate->link = $image->getLink();
        $objTemplate->numphotos = $album->getNumPhotos();
        $objTemplate->date = $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $album->getTimestamp());
        $objTemplate->timestamp = $album->getTimestamp();
        $objTemplate->datetime = date('Y-m-d\TH:i:sP', $album->getTimestamp());

        // parse and return
        return $objTemplate->parse();
    }

    /**
     * Convert a PicasaAlbum to a PicasaImage
     * @param PicasaImage $album
     */
    protected function convertAlbumToImage($album)
    {
        // create image
        $image = new PicasaImage($album->getImageUrl($this->googlephotos_latest_thumb_size, true), $album->getTitle(), $this->googlephotos_latest_thumb_size, $this->googlephotos_latest_thumb_size, 0);
        $image->setTitle($album->getTitle());
        $image->setCaption(date($GLOBALS['TL_CONFIG']['dateFormat'], $album->getTimestamp()) . ' / ' . $album->getNumPhotos() . ' Photos');

        // get current "jumpTo" page and set link
        $objPage = $this->Database->prepare("SELECT * FROM tl_page WHERE id=?")->limit(1)->execute($this->jumpTo);
        // print_r($objPage->row()); exit;
        $image->setLink($this->generateFrontendUrl($objPage->row(), '/album/' . $album->getId()));
        // $image->setLink = $this->generateFrontendUrl($objPage->row(), 'album=' . $album->getId());
        // $image->setLink($this->addToUrl());

        // set image
        return $image;
    }
}

?>