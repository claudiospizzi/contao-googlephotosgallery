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
 * Table tl_googlephotosgallery
 */
$GLOBALS['TL_DCA']['tl_googlephotosgallery'] = array
(
    // Config
    'config' => array
    (
        'dataContainer'                 => 'Table',
        'ctable'                        => array('tl_googlephotosgallery_album'),
        'switchToEdit'                  => true,
        'enableVersioning'              => false,
        'onload_callback' => array
        (
            array('tl_googlephotosgallery', 'checkAction'),
            array('tl_googlephotosgallery', 'checkPermission')
        ),
        'onsubmit_callback' => array
        (
            array('tl_googlephotosgallery', 'updateGallery')
        ),
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary'
            )
        )
    ),
     // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                          => 1,
            'fields'                        => array('title'),
            'flag'                          => 1,
            'panelLayout'                   => 'search,limit'
        ),
        'label' => array
        (
            'fields'                        => array('title', 'username', 'numAlbums'),
            'format'                        => '%s<span style="color:#b3b3b3; padding-left:5px;">[%s / %s ' . $GLOBALS['TL_LANG']['tl_googlephotosgallery']['textAlbums'] . ']</span>'
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'                         => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'                          => 'act=select',
                'class'                         => 'header_edit_all',
                'attributes'                    => 'onclick="Backend.getScrollOffset();"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'                         => &$GLOBALS['TL_LANG']['tl_googlephotosgallery']['edit'],
                'href'                          => 'table=tl_googlephotosgallery_album',
                'icon'                          => 'edit.gif',
            ),
            'header' => array
            (
                'label'                         => &$GLOBALS['TL_LANG']['tl_googlephotosgallery']['header'],
                'href'                          => 'act=edit',
                'icon'                          => 'header.gif',
            ),
            'copy' => array
            (
                'label'                         => &$GLOBALS['TL_LANG']['tl_googlephotosgallery']['copy'],
                'href'                          => 'act=copy',
                'icon'                          => 'copy.gif'
            ),
            'delete' => array
            (
                'label'                         => &$GLOBALS['TL_LANG']['tl_googlephotosgallery']['delete'],
                'href'                          => 'act=delete',
                'icon'                          => 'delete.gif',
                'attributes'                    => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
            ),
            'update' => array
            (
                'label'                         => &$GLOBALS['TL_LANG']['tl_googlephotosgallery']['update'],
                'icon'                          => 'system/modules/googlephotosgallery/assets/update.png',
                'attributes'                    => 'onclick="Backend.getScrollOffset();"',
                'button_callback'               => array('tl_googlephotosgallery', 'showUpdateIcon')
            ),
            'show' => array
            (
                'label'                         => &$GLOBALS['TL_LANG']['tl_googlephotosgallery']['show'],
                'href'                          => 'act=show',
                'icon'                          => 'show.gif'
            )
        )
    ),
    // Palettes
    'palettes' => array
    (
        'default'                       => '{title_legend},title,username'
    ),
    // Subpalettes
    'subpalettes' => array
    (

    ),
    // Fields
    'fields' => array
    (
        'id' => array
        (
            'sql'                           => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array
        (
            'sql'                           => "int(10) unsigned NOT NULL default '0'"
        ),
        'title' => array
        (
            'label'                         => &$GLOBALS['TL_LANG']['tl_googlephotosgallery']['title'],
            'exclude'                       => false,
            'search'                        => true,
            'sorting'                       => true,
            'inputType'                     => 'text',
            'eval'                          => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'),
            'sql'                           => "varchar(255) NOT NULL default ''"
        ),
        'username' => array
        (
            'label'                         => &$GLOBALS['TL_LANG']['tl_googlephotosgallery']['username'],
            'exclude'                       => false,
            'search'                        => true,
            'sorting'                       => true,
            'inputType'                     => 'text',
            'eval'                          => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'),
            'sql'                           => "varchar(255) NOT NULL default ''"
        ),
        'numAlbums' => array
        (
            'sql'                           => "int(10) unsigned NOT NULL default '0'"
        )
    )
);


/**
 * Class tl_googlephotosgallery
 */
class tl_googlephotosgallery extends Backend
{
    // Construct
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }

    // showUpdateIcon
    public function showUpdateIcon($row, $href, $label, $title, $icon, $attributes)
    {
        $href = '&amp;act=update&amp;tid='.$row['id'];

        return '<a href="'.$this->addToUrl($href).'" title="' . specialchars($title) . '" ' . $attributes. '>' . $this->generateImage($icon, $label) . '</a> ';
    }

    // checkAction
    public function checkAction(DataContainer $dc)
    {
        // check input
        if($this->Input->get('act') == 'update')
        {
            // get actual record
            $dc->activeRecord = $this->Database->prepare("SELECT * FROM tl_googlephotosgallery WHERE id=?")->limit(1)->execute($this->Input->get('tid'));

            // run update
            $this->updateGallery($dc);

            // redirect
            $this->redirect('contao/main.php?do=googlephotosgallery');
        }
    }

    // updateGallery
    public function updateGallery(DataContainer $dc)
    {
        // check active record
        if(!$dc->activeRecord)
        {
            return;
        }

        // create object
        $gallery = new PicasaGallery($dc->activeRecord->id);

        // update gallery
        $gallery->update();
    }

    // checkPermission
    public function checkPermission()
    {
        // check admins
        if($this->User->isAdmin)
        {
            // no limitations
            return;
        }
        else
        {
            // disable new gallery function
            $GLOBALS['TL_DCA']['tl_googlephotosgallery']['config']['closed'] = true;

            // disable buttons
            unset($GLOBALS['TL_DCA']['tl_googlephotosgallery']['list']['operations']['copy']);
            unset($GLOBALS['TL_DCA']['tl_googlephotosgallery']['list']['operations']['delete']);

            // fields readonly
            $GLOBALS['TL_DCA']['tl_googlephotosgallery']['fields']['title']['eval']['readonly'] = true;
            $GLOBALS['TL_DCA']['tl_googlephotosgallery']['fields']['title']['eval']['style'] = 'background-color: #E0E0E0';
            $GLOBALS['TL_DCA']['tl_googlephotosgallery']['fields']['username']['eval']['readonly'] = true;
            $GLOBALS['TL_DCA']['tl_googlephotosgallery']['fields']['username']['eval']['style'] = 'background-color: #E0E0E0';
        }
    }
}
