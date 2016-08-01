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
 * Class PicasaImage
 *
 * Provide methods to handle a Picasa Photo.
 *
 * @copyright  Claudio Spizzi 2011
 * @author     Claudio Spizzi <http://www.spizzi.net>
 * @package    Picasa
 */
class PicasaImage
{
    /**
     * Picasa Image Src Tag
     * @var string
     */
    private $strImgSrc;

    /**
     * Picasa Image Alt Tag
     * @var string
     */
    private $strImgAlt;

    /**
     * Picasa Image Width Tag
     * @var string
     */
    private $strImgWidth;

    /**
     * Picasa Image Height Tag
     * @var string
     */
    private $strImgHeight;

    /**
     * Picasa Image Border Tag
     * @var string
     */
    private $strImgBorder;

    /**
     * Picasa Image Link
     * @var string
     */
    private $strLink;

    /**
     * Picasa Image Title
     * @var string
     */
    private $strTitle;

    /**
     * Picasa Image Caption
     * @var string
     */
    private $strCaption;
    
    /**
     * Create a new Picasa Photo object.
     * @param integer $indId
     */
    public function __construct($strImgSrc, $strImgAlt, $strImgWidth, $strImgHeight, $strImgBorder)
    {
        // set properties
        $this->strImgSrc    = $strImgSrc;
        $this->strImgAlt    = $strImgAlt;
        $this->strImgWidth  = $strImgWidth;
        $this->strImgHeight = $strImgHeight;
        $this->strImgBorder = $strImgBorder;
    }

    /**
     * Set the property link
     * @param string $strLink
     */
    public function setLink($strLink)
    {
        // set
        $this->strLink = $strLink;
    }

    /**
     * Set the property title
     * @param string $strTitle
     */
    public function setTitle($strTitle)
    {
        // set
        $this->strTitle = $strTitle;
    }

    /**
     * Set the property caption
     * @param string $strCaption
     */
    public function setCaption($strCaption)
    {
        // set
        $this->strCaption = $strCaption;
    }

    /**
     * Get the Picasa Image Img Tag
     * @var string
     */
    public function getImg()
    {
        return '<img src="' . $this->getImgSrc() . '" alt="' . $this->getImgAlt() . '" width="' . $this->getImgWidth() . '" height="' . $this->getImgHeight() . '" border="' . $this->getImgBorder() . '" />';
    }

    /**
     * Get the Picasa Image Src Tag
     * @var string
     */
    public function getImgSrc()
    {
        return $this->strImgSrc;
    }

    /**
     * Get the Picasa Image Alt Tag
     * @var string
     */
    public function getImgAlt()
    {
        return $this->strImgAlt;
    }

    /**
     * Get the Picasa Image Width Tag
     * @var string
     */
    public function getImgWidth()
    {
        return $this->strImgWidth;
    }

    /**
     * Get the Picasa Image Height Tag
     * @var string
     */
    public function getImgHeight()
    {
        return $this->strImgHeight;
    }

    /**
     * Get the Picasa Image Border Tag
     * @var string
     */
    public function getImgBorder()
    {
        return $this->strImgBorder;
    }

    /**
     * Get the Picasa Image Link
     * @var string
     */
    public function getLink()
    {
        return $this->strLink;
    }

    /**
     * Get the Picasa Image Title
     * @var string
     */
    public function getTitle()
    {
        return $this->strTitle;
    }

    /**
     * Get the Picasa Image Caption
     * @var string
     */
    public function getCaption()
    {
        return $this->strCaption;
    }

}

?>