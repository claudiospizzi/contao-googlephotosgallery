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
 * Class PicasaGallery
 *
 * Provide methods to handle a Picasa Gallery.
 * 
 * @copyright  Claudio Spizzi 2011
 * @author     Claudio Spizzi <http://www.spizzi.net>
 * @package    Picasa
 */
class PicasaGallery extends System
{
    /**
     * Picasa Gallery id
     * @var integer
     */
    private $intId;

    /**
     * Picasa Gallery title
     * @var string
     */
    private $strTitle;

    /**
     * Picasa Gallery username
     * @var string
     */
    private $strUsername;

    /**
     * Picasa Gallery albums
     * @var array
     */
    private $arrAlbums;

    /**
     * Picasa Gallery number of albums
     * @var integer
     */
    private $intAlbums;

    /**
     * Create new Picasa Gallery object and initialise the properties.
     * @param integer $intId
     * @return boolean
     */
    public function __construct($intId)
    {
        // inport database
        $this->import('Database');

        // set id
        $this->intId = $intId;

        // try to load properties from database
        return $this->loadGallery();
    }

    /**
     * Get a Picasa Gallery album.
     * @return PicasaAlbum
     */
    public function getAlbum($intId)
    {
        // check albums
        if(!isset($this->arrAlbums))
        {
            // load albums
            $this->loadAlbums();
        }

        // check if album exist
        if(isset($this->arrAlbums[$intId]))
        {
            // return album
            return $this->arrAlbums[$intId];
        }
        else
        {
            // album does not exist
            return false;
        }
    }

    /**
     * Get the Picasa Gallery albums.
     * @return array of PicasaAlbum
     */
    public function getAlbums()
    {
        // check albums
        if(!isset($this->arrAlbums))
        {
            // load albums
            $this->loadAlbums();
        }

        // return
        return $this->arrAlbums;
    }

    /**
     * Get the Picasa Gallery number of albums.
     * @return integer
     */
    public function getNumAlbums()
    {
        // check albums
        if(!isset($this->intAlbums))
        {
            // load albums
            $this->loadAlbums();
        }
        
        // return
        return $this->intAlbums;
    }

    /**
     * Update the Picasa Gallery from Google and save to database.
     * @return boolean
     */
    public function update()
    {
        // init sid array
        $arrSid = array();

        // init album counter
        $numAlbums = 0;

        // set sid array
        foreach($this->getAlbums() as $album)
        {
            $arrSid[] = $album->getSid();
        }
        
        // fetch albums from google
        $albums = PicasaAPI::fetchAlbums($this->strUsername);

        // check albums
        if($albums !== false)
        {
            // iterating albums
            foreach($albums as $album)
            {
                // check if the picasa album entry exist
                if(in_array($album['sid'], $arrSid))
                {
                    // update database record
                    $this->Database->prepare('UPDATE tl_googlephotosgallery_album SET name=?, title=?, timestamp=?, imagePrefix=?, imageSuffix=?, numPhotos=? WHERE sid=?')->execute(
                        $album['name'],
                        $album['title'],
                        $album['timestamp'],
                        $album['imagePrefix'],
                        $album['imageSuffix'],
                        $album['numPhotos'],
                        $album['sid']
                    );
                }
                else
                {
                    // insert record into database
                    $this->Database->prepare('INSERT INTO tl_googlephotosgallery_album (pid, tstamp, sid, name, title, timestamp, imagePrefix, imageSuffix, numPhotos, published) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)')->execute(
                        $this->intId,
                        time(),
                        $album['sid'],
                        $album['name'],
                        $album['title'],
                        $album['timestamp'],
                        $album['imagePrefix'],
                        $album['imageSuffix'],
                        $album['numPhotos'],
                        false
                    );
                }

                // count albums
                $numAlbums++;
            }

            // update database record
            $this->Database->prepare('UPDATE tl_googlephotosgallery SET numAlbums=? WHERE id=?')->execute(
                $numAlbums,
                $this->intId
            );
            
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
     * Load the Picasa Gallery from the database.
     * @return boolean
     */
    private function loadGallery()
    {
        // database query (gallery)
        $result = $this->Database->prepare('SELECT title, username FROM tl_googlephotosgallery WHERE id=?')->limit(1)->execute($this->intId);
        
        // check result
        if($result->numRows > 0)
        {
            // get first
            $result = $result->first();

            // set properties
            $this->strTitle    = $result->title;
            $this->strUsername = $result->username;
            
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
     * Load the Picasa Gallery albums from the database
     * @return boolean
     */
    private function loadAlbums()
    {
        if(!isset($this->arrAlbums) && !isset($this->intAlbums))
        {
            // init variables
            $this->arrAlbums = array();
            $this->intAlbums = 0;
            
            // database query (albums)
            $result = $this->Database->prepare('SELECT id FROM tl_googlephotosgallery_album WHERE pid=? ORDER BY timestamp DESC')->execute($this->intId);

            // check rows
            if($result->numRows > 0)
            {
                // iterating albums
                while($result->next())
                {
                    // create albums
                    $this->arrAlbums[$result->id] = new PicasaAlbum($result->id, $this->strUsername);

                    // count albums
                    $this->intAlbums++;
                }

                // return
                return true;
            }
            else
            {
                // return
                return false;
            }
        }
    }
}

?>