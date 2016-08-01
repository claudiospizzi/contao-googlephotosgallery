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
 * Class PicasaPhoto
 *
 * Provide methods to handle a Picasa Photo.
 *
 * @copyright  Claudio Spizzi 2011
 * @author     Claudio Spizzi <http://www.spizzi.net>
 * @package    Picasa
 */
class PicasaPhoto extends System
{
    /**
     * Picasa Photo id
     * @var integer
     */
    private static $intCounter = 1;

    /**
     * Picasa Photo id
     * @var integer
     */
    private $intId;

    /**
     * Picasa Photo sid
     * @var integer
     */
    private $intSid;

    /**
     * Picasa Photo name
     * @var string
     */
    private $strName;

    /**
     * Picasa Photo title
     * @var string
     */
    private $strTitle;

    /**
     * Picasa Photo timestamp
     * @var integer
     */
    private $intTimestamp;

    /**
     * Picasa Photo imagePrefix
     * @var string
     */
    private $strImagePrefix;

    /**
     * Picasa Photo imageSuffix
     * @var string
     */
    private $strImageSuffix;

    /**
     * Create a new Picasa Photo object.
     * @param integer $indId
     */
    public function __construct()
    {
        // set id
        $this->intId = PicasaPhoto::$intCounter;

        // count
        PicasaPhoto::$intCounter++;
    }

    /**
     * Set the property sid
     * @param integer $intSid
     */
    public function setSid($intSid)
    {
        // set sid
        $this->intSid = $intSid;
    }

    /**
     * Set the property name
     * @param integer $strName
     */
    public function setName($strName)
    {
        // set name
        $this->strName = $strName;
    }

    /**
     * Set the property title
     * @param integer $strTitle
     */
    public function setTitle($strTitle)
    {
        // set title
        $this->strTitle = $strTitle;
    }

    /**
     * Set the property timestamp
     * @param integer $intTimestamp
     */
    public function setTimestamp($intTimestamp)
    {
        // set timestamp
        $this->intTimestamp = $intTimestamp;
    }

    /**
     * Set the property imagePrefix
     * @param string $strImagePrefix
     */
    public function setImagePrefix($strImagePrefix)
    {
        // set imagePrefix
        $this->strImagePrefix = $strImagePrefix;
    }

    /**
     * Set the property imageSuffix
     * @param string $strImageSuffix
     */
    public function setImageSuffix($strImageSuffix)
    {
        // set imageSuffix
        $this->strImageSuffix = $strImageSuffix;
    }

    /**
     * Get the property id
     * @return integer
     */
    public function getId()
    {
        // return
        return $this->intId;
    }

    /**
     * Get the property sid
     * @return integer
     */
    public function getSid()
    {
        // return
        return $this->intSid;
    }

    /**
     * Get the property name
     * @return string
     */
    public function getName()
    {
        // return
        return $this->strName;
    }

    /**
     * Get the property title
     * @return string
     */
    public function getTitle()
    {
        // return
        return $this->strTitle;
    }

    /**
     * Get the property timestamp
     * @return integer
     */
    public function getTimestamp()
    {
        // return
        return $this->intTimestamp;
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
}

?>