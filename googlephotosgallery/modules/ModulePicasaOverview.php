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
 * Class ModulePicasaOverview
 */
class ModulePicasaOverview extends Module
{
    /**
     * Module Template
     * @var string
     */
    protected $strTemplate = '';

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
            $objTemplate->wildcard = '### GOOGLE PHOTOS GALLERY (' . $this->id . ': ' . $this->name . ') ###';

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
        // create gallery object
        $gallery = new PicasaGallery($this->googlephotos_overview_id);

        // check input
        if($this->Input->get('album') == '')
        {
            // set template
            $this->strTemplate = 'mod_googlephotos_overview_albums';

            // create template
            $this->Template = new FrontendTemplate($this->strTemplate);

            // init articles
            $categories = array();

            // get albums
            $albums = $gallery->getAlbums();

            // check category
            if($this->googlephotos_overview_category_option == true)
            {
                // iterating albums
                foreach($albums as $album)
                {
                    // check published album
                    if($album->getPublished() == true)
                    {
                        // set year for the date
                        $year = (int)date('Y', $album->getTimestamp());

                        // check seperator date
                        if(((int)date('n', $album->getTimestamp()) < (int)date('n', $this->googlephotos_overview_category_date)) || (((int)date('n', $album->getTimestamp()) == (int)date('n', $this->googlephotos_overview_category_date)) && ((int)date('j', $album->getTimestamp()) < (int)date('j', $this->googlephotos_overview_category_date))))
                        {
                            $year--;
                        }

                        // set headline
                        if(!isset($categories[(string)$year]['headline']))
                        {
                            if(((int)date('n', $album->getTimestamp()) == 1) && ((int)date('j', $album->getTimestamp()) == 1))
                            {
                                $categories[(string)$year]['headline'] = 'Jahr ' . (string)$year;
                            }
                            else
                            {
                                $categories[(string)$year]['headline'] = 'Saison ' . (string)$year . '/' . substr((string)($year + 1), -2);
                            }
                        }

                        // add to categories
                        $categories[(string)$year]['articles'][] = $this->compileAlbum($album);
                    }
                }
            }
            else
            {
                // empty articles array
                $articles = array();

                // set headline
                $categories[0]['headline'] = '&Uuml;bersicht';

                // iterating albums
                foreach($albums as $album)
                {
                    // check published album
                    if($album->getPublished() == true)
                    {
                        // set articles
                        $categories[0]['articles'][] = $this->compileAlbum($album);
                    }
                }
            }

            // set articles
            $this->Template->categories = $categories;
        }
        else
        {
            // set template
            $this->strTemplate = 'mod_googlephotos_overview_photos';

            // create template
            $this->Template = new FrontendTemplate($this->strTemplate);

            // get album
            $album = $gallery->getAlbum($this->Input->get('album'));

            // get photos
            $photos = $album->getPhotos();

            // set headline
            $this->Template->headline = $album->getTitle();
            $this->Template->backlink = $this->addToUrl(null, true);

            // iterating photos
            foreach($photos as $photo)
            {
                $articles[] = $this->compilePhoto($album, $photo);
            }

            // set articles
            $this->Template->articles = $articles;
        }
    }

    /**
     * Compile the Frontend Module (album)
     */
    protected function compileAlbum($album)
    {
        // get image
        $image = $this->convertAlbumToImage($album);

        // create template
        //$objTemplate = new FrontendTemplate($this->googlephotos_overview_album_template);
        $objTemplate = new FrontendTemplate('mod_googlephotos_overview_albums_image');

        // set template data
        $objTemplate->title     = $album->getTitle();
        $objTemplate->image     = $image->getImg();
        $objTemplate->link      = $image->getLink();
        $objTemplate->numphotos = $album->getNumPhotos();
        $objTemplate->date      = $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $album->getTimestamp());
        $objTemplate->timestamp = $album->getTimestamp();
        $objTemplate->datetime  = date('Y-m-d\TH:i:sP', $album->getTimestamp());

        // parse and return
        return $objTemplate->parse();
    }

    /**
     * Compile the Frontend Module (photo)
     */
    protected function compilePhoto($album, $photo)
    {
        // get image
        $image = $this->convertPhotoToImage($album, $photo);

        // create template
        $objTemplate = new FrontendTemplate('mod_googlephotos_overview_photos_image');

        // set template data
        $objTemplate->title     = $album->getTitle();
        $objTemplate->image     = $image->getImg();
        $objTemplate->link      = $image->getLink();
        $objTemplate->numphotos = $album->getNumPhotos();
        $objTemplate->date      = $this->parseDate($GLOBALS['TL_CONFIG']['datimFormat'], $album->getTimestamp());
        $objTemplate->timestamp = $album->getTimestamp();
        $objTemplate->datetime  = date('Y-m-d\TH:i:sP', $album->getTimestamp());

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
        $image = new PicasaImage($album->getImageUrl($this->googlephotos_overview_thumb_size, true), $album->getTitle(), $this->googlephotos_overview_thumb_size, $this->googlephotos_overview_thumb_size, 0);
        $image->setLink($this->addToUrl('album=' . $album->getId()));
        $image->setTitle($album->getTitle());
        $image->setCaption(date($GLOBALS['TL_CONFIG']['dateFormat'], $album->getTimestamp()) . ' / ' . $album->getNumPhotos() . ' Photos');

        // set image
        return $image;
    }

    /**
     * Convert a PicasaPhoto to a PicasaImage
     * @param PicasaImage $album
     */
    protected function convertPhotoToImage($album, $photo)
    {
        // create image
        $image = new PicasaImage($photo->getImageUrl($this->googlephotos_overview_image_size, true), $photo->getTitle(), $this->googlephotos_overview_image_size, $this->googlephotos_overview_image_size, 0);
        $image->setLink($photo->getImageUrl($this->googlephotos_overview_photo_size));
        $image->setTitle($album->getTitle());
        $image->setCaption('Image ' . $photo->getId() . ' of ' . $album->getNumPhotos());

        // set image
        return $image;
    }
}

?>