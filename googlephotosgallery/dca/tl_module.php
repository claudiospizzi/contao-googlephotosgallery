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
 * Add palettes to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'googlephotos_overview_category_option';
$GLOBALS['TL_DCA']['tl_module']['palettes']['googlephotos_overview'] = '{title_legend},name,headline,type;{googlephotos_overview_legend},googlephotos_overview_id,googlephotos_overview_thumb_size,googlephotos_overview_image_size,googlephotos_overview_photo_size,googlephotos_overview_album_template,googlephotos_overview_photo_template,googlephotos_overview_category_option;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['googlephotos_latest']  = '{title_legend},name,headline,type;{googlephotos_latest_legend},googlephotos_latest_id,googlephotos_latest_thumb_size,googlephotos_latest_thumb_num,googlephotos_latest_template;{redirect_legend},jumpTo;{expert_legend:hide},guests,cssID,space';


/**
 * Add subpalettes to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['googlephotos_overview_category_option'] = 'googlephotos_overview_category_date';


/**
 * Add fields to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['googlephotos_overview_id'] = array
(
    'label'                     => &$GLOBALS['TL_LANG']['tl_module']['googlephotos_overview_id'],
    'exclude'                   => true,
    'inputType'                 => 'select',
    'options_callback'          => array('tl_module_googlephotos_overview', 'getAlbums'),
    'eval'                      => array('multiple' => false, 'mandatory' => true, 'fieldType' => 'radio'),
    'sql'                       => "int(10) unsigned NOT NULL default '0'"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['googlephotos_overview_thumb_size'] = array
(
    'label'                     => &$GLOBALS['TL_LANG']['tl_module']['googlephotos_overview_thumb_size'],
    'exclude'                   => true,
    'inputType'                 => 'text',
    'eval'                      => array('mandatory' => true, 'rgxp' => 'digit', 'tl_class' => 'w50'),
    'sql'                       => "int(10) unsigned NOT NULL default '50'"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['googlephotos_overview_image_size'] = array
(
    'label'                     => &$GLOBALS['TL_LANG']['tl_module']['googlephotos_overview_image_size'],
    'default'                   => 150,
    'exclude'                   => true,
    'inputType'                 => 'text',
    'eval'                      => array('mandatory' => true, 'rgxp' => 'digit', 'tl_class' => 'w50'),
    'sql'                       => "int(10) unsigned NOT NULL default '150'"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['googlephotos_overview_photo_size'] = array
(
    'label'                     => &$GLOBALS['TL_LANG']['tl_module']['googlephotos_overview_photo_size'],
    'default'                   => 150,
    'exclude'                   => true,
    'inputType'                 => 'text',
    'eval'                      => array('mandatory' => true, 'rgxp' => 'digit', 'tl_class' => 'w50'),
    'sql'                       => "int(10) unsigned NOT NULL default '800'"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['googlephotos_overview_category_option'] = array
(
    'label'                     => &$GLOBALS['TL_LANG']['tl_module']['googlephotos_overview_category_option'],
    'exclude'                   => true,
    'inputType'                 => 'checkbox',
    'eval'                      => array('submitOnChange' => true, 'tl_class' => 'w50'),
    'sql'                       => "char(1) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['googlephotos_overview_category_date'] = array
(
    'label'                     => &$GLOBALS['TL_LANG']['tl_module']['googlephotos_overview_category_date'],
    'exclude'                   => true,
    'inputType'                 => 'text',
    'eval'                      => array('submitOnChange' => true, 'rgxp' => 'date', 'tl_class' => 'clr w50 wizard', 'datepicker' => true),
    'sql'                       => "int(10) unsigned NULL"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['googlephotos_overview_album_template'] = array
(
    'label'                     => &$GLOBALS['TL_LANG']['tl_module']['googlephotos_overview_album_template'],
    'exclude'                   => true,
    'inputType'                 => 'select',
    'options_callback'          => array('tl_module_googlephotos_overview', 'getPicasaTemplates'),
    'eval'                      => array('tl_class' => 'clr w50'),
    'sql'                       => "varchar(32) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['googlephotos_overview_photo_template'] = array
(
    'label'                     => &$GLOBALS['TL_LANG']['tl_module']['googlephotos_overview_photo_template'],
    'exclude'                   => true,
    'inputType'                 => 'select',
    'options_callback'          => array('tl_module_googlephotos_overview', 'getPicasaTemplates'),
    'eval'                      => array('tl_class' => 'w50'),
    'sql'                       => "varchar(32) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['googlephotos_latest_id'] = array
(
    'label'                     => &$GLOBALS['TL_LANG']['tl_module']['googlephotos_latest_id'],
    'default'                   => 800,
    'exclude'                   => true,
    'inputType'                 => 'select',
    'options_callback'          => array('tl_module_googlephotos_latest', 'getAlbums'),
    'eval'                      => array('multiple' => false, 'mandatory' => true, 'fieldType' => 'radio'),
    'sql'                       => "int(10) unsigned NOT NULL default '0'"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['googlephotos_latest_thumb_size'] = array
(
    'label'                     => &$GLOBALS['TL_LANG']['tl_module']['googlephotos_latest_thumb_size'],
    'default'                   => 150,
    'exclude'                   => true,
    'inputType'                 => 'text',
    'eval'                      => array('mandatory' => true, 'rgxp' => 'digit', 'tl_class' => 'w50'),
    'sql'                       => "int(10) unsigned NOT NULL default '150'"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['googlephotos_latest_thumb_num'] = array
(
    'label'                     => &$GLOBALS['TL_LANG']['tl_module']['googlephotos_latest_thumb_num'],
    'default'                   => 4,
    'exclude'                   => true,
    'inputType'                 => 'text',
    'eval'                      => array('mandatory' => true, 'rgxp' => 'digit', 'tl_class' => 'w50'),
    'sql'                       => "int(10) unsigned NOT NULL default '4'"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['googlephotos_latest_template'] = array
(
    'label'                     => &$GLOBALS['TL_LANG']['tl_module']['googlephotos_latest_template'],
    'exclude'                   => true,
    'inputType'                 => 'select',
    'options_callback'          => array('tl_module_googlephotos_overview', 'getPicasaTemplates'),
    'eval'                      => array('tl_class' => 'w50'),
    'sql'                       => "varchar(32) NOT NULL default ''"
);


/**
 * Class tl_module_googlephotos_overview
 */
class tl_module_googlephotos_overview extends Backend
{
    // Construct
    public function __construct()
    {
        parent::__construct();
    }

    // getAlbums
    public function getAlbums()
    {
        // create return array
        $return = array();

        // fetch from database
        $result = $this->Database->prepare('SELECT id, title, username FROM tl_googlephotosgallery')->execute();

        while($result->next())
        {
            $return[$result->id] = $result->title . ' (' . $result->username . ')';
        }

        return $return;
    }

    // getPicasaTemplates
    public function getPicasaTemplates(DataContainer $dc)
    {
        $intPid = $dc->activeRecord->pid;

        return $this->getTemplateGroup('mod_googlephotos_', $intPid);
    }
}


/**
 * Class tl_module_googlephotos_latest
 */
class tl_module_googlephotos_latest extends Backend
{
    // Construct
    public function __construct()
    {
        parent::__construct();
    }

    // getAlbums
    public function getAlbums()
    {
        // create return array
        $return = array();

        // fetch from database
        $result = $this->Database->prepare('SELECT id, title, username FROM tl_googlephotosgallery')->execute();

        while($result->next())
        {
            $return[$result->id] = $result->title . ' (' . $result->username . ')';
        }

        return $return;
    }
}
