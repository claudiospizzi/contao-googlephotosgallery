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
 * Table tl_googlephotosgallery_album
 */
$GLOBALS['TL_DCA']['tl_googlephotosgallery_album'] = array
(
    // Config
    'config' => array
    (
        'dataContainer'                 => 'Table',
        'ptable'                        => 'tl_googlephotosgallery',
        'closed'                        => true,
        'enableVersioning'              => false,
        'onload_callback'               => array
        (
            array('tl_googlephotosgallery_album', 'checkAction'),
            array('tl_googlephotosgallery_album', 'checkPermission')
        ),
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary',
                'sid' => 'unique'
            )
        )
    ),
     // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                          => 4,
            'fields'                        => array('timestamp DESC'),
            'headerFields'                  => array('title', 'username'),
            'panelLayout'                   => 'search,limit',
            'child_record_callback'         => array('tl_googlephotosgallery_album', 'listItems')
        ),
        'global_operations' => array
        (
            'update' => array
            (
                'label'                         => &$GLOBALS['TL_LANG']['tl_googlephotosgallery_album']['update'],
                'href'                          => 'act=update',
                'class'                         => 'header_rss',
                'attributes'                    => 'onclick="Backend.getScrollOffset();" style="background: url(system/modules/googlephotosgallery/assets/update.png) no-repeat scroll left center transparent; padding: 2px 0 3px 20px;"'
            ),
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
                'label'                         => &$GLOBALS['TL_LANG']['tl_googlephotosgallery_album']['edit'],
                'href'                          => 'act=edit',
                'icon'                          => 'edit.gif',
                'attributes'                    => 'class="contextmenu"'
            ),
            'toggle' => array
            (
                'label'                         => &$GLOBALS['TL_LANG']['tl_googlephotosgallery_album']['toggle'],
                'icon'                          => 'visible.gif',
                'attributes'                    => 'onclick="Backend.getScrollOffset(); return AjaxRequest.toggleVisibility(this, %s);"',
                'button_callback'               => array('tl_googlephotosgallery_album', 'toggleIcon')
            ),
            'delete' => array
            (
                'label'                         => &$GLOBALS['TL_LANG']['tl_googlephotosgallery_album']['delete'],
                'href'                          => 'act=delete',
                'icon'                          => 'delete.gif',
                'attributes'                    => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
            ),
            'show' => array
            (
                'label'                         => &$GLOBALS['TL_LANG']['tl_googlephotosgallery_album']['show'],
                'href'                          => 'act=show',
                'icon'                          => 'show.gif'
            )
        )
    ),
    // Palettes
    'palettes' => array
    (
        'default'                       => '{title_legend},title;{settings_legend},name,sid,timestamp,numPhotos,imagePrefix,imageSuffix;{published_legend},published'
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
        'pid' => array
        (
            'foreignKey'                    => 'tl_googlephotosgallery.id',
            'sql'                           => "int(10) unsigned NOT NULL default '0'",
            'relation'                      => array('type'=>'belongsTo', 'load'=>'eager')
        ),
        'tstamp' => array
        (
            'sql'                           => "int(10) unsigned NOT NULL default '0'"
        ),
        'sid' => array
        (
            'label'                         => &$GLOBALS['TL_LANG']['tl_googlephotosgallery_album']['sid'],
            'exclude'                       => false,
            'search'                        => false,
            'inputType'                     => 'text',
            'eval'                          => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50', 'readonly' => true, 'style' => 'background-color: #E0E0E0;'),
            'sql'                           => "varchar(255) NOT NULL default ''"
        ),
        'name' => array
        (
            'label'                         => &$GLOBALS['TL_LANG']['tl_googlephotosgallery_album']['name'],
            'exclude'                       => false,
            'search'                        => true,
            'inputType'                     => 'text',
            'eval'                          => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50', 'readonly' => true, 'style' => 'background-color: #E0E0E0;'),
            'sql'                           => "varchar(255) NOT NULL default ''"
        ),
        'title' => array
        (
            'label'                         => &$GLOBALS['TL_LANG']['tl_googlephotosgallery_album']['title'],
            'exclude'                       => false,
            'search'                        => true,
            'inputType'                     => 'text',
            'eval'                          => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50', 'readonly' => true, 'style' => 'background-color: #E0E0E0;'),
            'sql'                           => "varchar(255) NOT NULL default ''"
        ),
        'timestamp' => array
        (
            'label'                         => &$GLOBALS['TL_LANG']['tl_googlephotosgallery_album']['timestamp'],
            'exclude'                       => false,
            'search'                        => false,
            'inputType'                     => 'text',
            'eval'                          => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50', 'readonly' => true, 'style' => 'background-color: #E0E0E0;', 'rgxp' => 'date'),
            'sorting'                       => true,
            'flag'                          => 8,
            'sql'                           => "varchar(255) NOT NULL default ''"
        ),
        'imagePrefix' => array
        (
            'label'                         => &$GLOBALS['TL_LANG']['tl_googlephotosgallery_album']['imagePrefix'],
            'exclude'                       => false,
            'search'                        => false,
            'inputType'                     => 'text',
            'eval'                          => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'clr long', 'readonly' => true, 'style' => 'background-color: #E0E0E0;'),
            'sql'                           => "varchar(255) NOT NULL default ''"
        ),
        'imageSuffix' => array
        (
            'label'                         => &$GLOBALS['TL_LANG']['tl_googlephotosgallery_album']['imageSuffix'],
            'exclude'                       => false,
            'search'                        => false,
            'inputType'                     => 'text',
            'eval'                          => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'long', 'readonly' => true, 'style' => 'background-color: #E0E0E0;'),
            'sql'                           => "varchar(255) NOT NULL default ''"
        ),
        'numPhotos' => array
        (
            'label'                         => &$GLOBALS['TL_LANG']['tl_googlephotosgallery_album']['numPhotos'],
            'exclude'                       => false,
            'search'                        => false,
            'inputType'                     => 'text',
            'eval'                          => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50', 'readonly' => true, 'style' => 'background-color: #E0E0E0;'),
            'sql'                           => "varchar(255) NOT NULL default ''"
        ),
        'published' => array
        (
            'label'                         => &$GLOBALS['TL_LANG']['tl_googlephotosgallery_album']['published'],
            'exclude'                       => false,
            'search'                        => false,
            'inputType'                     => 'checkbox',
            'eval'                          => array('doNotCopy' => true, 'tl_class' => 'm12'),
            'sql'                           => "char(1) NOT NULL default ''"
        )
    )
);


/**
 * Class tl_googlephotosgallery_album
 */
class tl_googlephotosgallery_album extends Backend
{
    // Construct
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }

    // listItems
    public function listItems($arrRow)
    {
        $return = $arrRow['title'] . '<span style="color:#b3b3b3; padding-left:5px;">[' . date($GLOBALS['TL_CONFIG']['dateFormat'], $arrRow['timestamp']) . ' / ' . $arrRow['numPhotos'] . ' ' . $GLOBALS['TL_LANG']['tl_googlephotosgallery_album']['textPhotos'] . ']</span>';

        return $return;
    }

    // toggleIcon
    public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
    {
        if (strlen($this->Input->get('tid')))
        {
            $this->toggleVisibility($this->Input->get('tid'), ($this->Input->get('state') == 1));
            $this->redirect($this->getReferer());
        }

        $href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);

        if (!$row['published'])
        {
            $icon = 'invisible.gif';
        }

        return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
    }

    // toggleVisibility
    public function toggleVisibility($intId, $blnVisible)
    {
        // set input parameter
        $this->Input->setGet('id', $intId);
        $this->Input->setGet('act', 'toggle');

        // update database
        $this->Database->prepare("UPDATE tl_googlephotosgallery_album SET tstamp=" . time() . ", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")->execute($intId);
    }

    // checkAction
    public function checkAction(DataContainer $dc)
    {
        // check input
        if($this->Input->get('act') == 'update')
        {
            // get actual record
            $dc->activeRecord = $this->Database->prepare("SELECT * FROM tl_googlephotosgallery WHERE id=?")->limit(1)->execute($this->Input->get('id'))->first();

            // run update
            $this->updateGallery($dc);
        }
    }

    // checkAction
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

        // redirect
        $this->redirect('contao/main.php?do=googlephotosgallery&table=tl_googlephotosgallery_album&id=' . $dc->activeRecord->id);
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
            // limitations
        }
    }
}
