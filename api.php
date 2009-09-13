<?php
/**
 *
 * Copyright 2007 Michael Cochrane <code@gardyneholt.co.nz>
 *
 * See the enclosed file license.txt for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @author  Michael Cochrane <code@gardyneholt.co.nz>
 * @license http://www.fsf.org/copyleft/lgpl.html GNU Lesser General Public License
 * @link    http://www.jojocms.org JojoCMS
 */

/* Map filter */
Jojo::addFilter('content', 'mapfilter', 'jojo_zmaps');

$_options[] = array(
    'id' => 'zmapskey',
    'category' => 'Geo Location',
    'label' => 'ZoomIn Maping System API key',
    'description' => 'ZoomIn Maping System API key recieved from: http://developer.zoomin.co.nz/forms/request_key',
    'type' => 'text',
    'default' => '',
    'options' => ''
);