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
 * Class PicasaAlbum
 *
 * Provide methods to handle a Picasa Album.
 *
 * @copyright  Claudio Spizzi 2011
 * @author     Claudio Spizzi <http://www.spizzi.net>
 * @package    Picasa
 */
class PicasaAlbum extends System
{
    /**
     * Picasa Album id
     * @var integer
     */
    private $intId;

    /**
     * Picasa Album sid
     * @var integer
     */
    private $intSid;

    /**
     * Picasa Album name
     * @var string
     */
    private $strName;

    /**
     * Picasa Album title
     * @var string
     */
    private $strTitle;

    /**
     * Picasa Album username
     * @var string
     */
    private $strUsername;

    /**
     * Picasa Album timestamp
     * @var integer
     */
    private $intTimestamp;

    /**
     * Picasa Album photos
     * @var array
     */
    private $arrPhotos;

    /**
     * Picasa Album number of photos
     * @var integer
     */
    private $intPhotos;

    /**
     * Picasa Album published
     * @var boolean
     */
    private $bolPublished;

    /**
     * Picasa Album image prefix
     * @var string
     */
    private $strImagePrefix;

    /**
     * Picasa Album image suffix
     * @var string
     */
    private $strImageSuffix;

    /**
     * Create new Picasa Album object and initialise the properties.
     * @param integer $indId
     * @param string $strUsername
     * @return boolean
     */
    public function __construct($intId, $strUsername)
    {
        // inport database
        $this->import('Database');

        // set id
        $this->intId       = $intId;
        $this->strUsername = $strUsername;

        // try to load properties from database
        return $this->loadAlbum();
    }

    /**
     * Return the Picasa Album id
     * @return integer
     */
    public function getId()
    {
        // return
        return $this->intId;
    }

    /**
     * Return the Picasa Album sid
     * @return integer
     */
    public function getSid()
    {
        // return
        return $this->intSid;
    }

    /**
     * Return the Picasa Album name
     * @return string
     */
    public function getName()
    {
        // return
        return $this->strName;
    }

    /**
     * Return the Picasa Album title
     * @return string
     */
    public function getTitle()
    {
        // return
        return $this->strTitle;
    }

    /**
     * Return the Picasa Album timestamp
     * @return string
     */
    public function getTimestamp()
    {
        // return
        return $this->intTimestamp;
    }

    /**
     * Get the Picasa Album photos.
     * @return array oh PicasaPhoto
     */
    public function getPhotos()
    {
        // check photos
        if(!isset($this->arrPhotos))
        {
            // load photos
            $this->loadPhotos();
        }

        // return
        return $this->arrPhotos;
    }

    /**
     * Get the Picasa Album number of photos.
     * @return integer
     */
    public function getNumPhotos()
    {
        // return
        return $this->intPhotos;
    }

    /**
     * Get the Picasa Album published
     * @return boolean
     */
    public function getPublished()
    {
        // return
        return $this->bolPublished;
    }

    /**
     * Get the property imageUrl
     * @return string
     */
    public function getImageUrl($intImageSize, $bolSquare = false)
    {
        // check square
        if($bolSquare == true)
        {
            // set square
            $strSquare = '-c';
        }
        else
        {
            // set empty
            $strSquare = '';
        }

        // return
        return $this->strImagePrefix . $intImageSize . $strSquare . $this->strImageSuffix;
    }

    /**
     * Load the Picasa Album from the database.
     * @return boolean
     */
    private function loadAlbum()
    {
        // database query (album)
        $result = $this->Database->prepare('SELECT sid, name, title, timestamp, imagePrefix, imageSuffix, numPhotos, published FROM tl_googlephotosgallery_album WHERE id=?')->limit(1)->execute($this->intId);
        $result = $result->first();

        // check result
        if($result->numRows > 0)
        {
            // set properties
            $this->intSid         = $result->sid;
            $this->strName        = $result->name;
            $this->strTitle       = $result->title;
            $this->intTimestamp   = $result->timestamp;
            $this->strImagePrefix = $result->imagePrefix;
            $this->strImageSuffix = $result->imageSuffix;
            $this->intPhotos      = $result->numPhotos;
            $this->bolPublished   = $result->published;

            // return
            return true;
        }
        else
        {
            // return
            return false;
        }
    }

    /**
     * Load the Picasa Album photos from Google
     * @return boolean
     */
    private function loadPhotos()
    {
        // check photos
        if(!isset($this->arrPhotos))
        {
            // get photos from google
            $photos = PicasaAPI::fetchPhotos($this->strUsername, $this->intSid);

            // check albums
            if($photos !== false)
            {
                // iterating albums
                foreach($photos as $photo)
                {
                    $this->arrPhotos[$photo['numPosition']] = new PicasaPhoto();
                    $this->arrPhotos[$photo['numPosition']]->setSid($photo['sid']);
                    $this->arrPhotos[$photo['numPosition']]->setName($photo['name']);
                    $this->arrPhotos[$photo['numPosition']]->setTitle($photo['title']);
                    $this->arrPhotos[$photo['numPosition']]->setTimestamp($photo['timestamp']);
                    $this->arrPhotos[$photo['numPosition']]->setImagePrefix($photo['imagePrefix']);
                    $this->arrPhotos[$photo['numPosition']]->setImageSuffix($photo['imageSuffix']);
                }
            }
            else
            {
                // set return array
                $this->arrPhotos = false;
            }
        }

        // return
        return $this->arrPhotos;
    }
}

?>