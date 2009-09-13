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

class JOJO_Plugin_jojo_zmaps extends JOJO_Plugin
{
    function mapfilter($content)
    {
        global $smarty;

        /* Find all [[zmap:map name]] tags */
        preg_match_all('/\[\[zmap:([^\]]*)\]\]/', $content, $matches);
        foreach($matches[1] as $id => $match) {

            /* Find the map in the database */
            $res = Jojo::selectQuery('SELECT * FROM {map} WHERE mp_name = ?', trim($match));
            if (!isset($res[0])) {
                $content = str_replace($matches[0][$id], "Map '$match' not found", $content);
                continue;
            }
            $map = $res[0];

            /* Get points on the map */
            $mapLocations = Jojo::selectQuery('SELECT * FROM {maplocation} WHERE mapid = ?', $map['mapid']);
            foreach($mapLocations as $k => $v) {
                $parts = split(',', $v['ml_geoloc']);
                $mapLocations[$k]['lat'] = $parts[0];
                $mapLocations[$k]['long'] = $parts[1];
            }
            $smarty->assign('map', $map);
            $smarty->assign('mapid', $map['mapid']);
            $smarty->assign('mapLocations', $mapLocations);

            /* Get the map html */
            $html = $smarty->fetch('jojo_zmap.tpl');

            if (!class_exists('JOJO_Plugin_jojo_gmaps_kml')) {
                $html .= "The Zoomin plugin requires the google maps plugin to be installed too.";
            }
            $content = str_replace($matches[0][$id], $html, $content);
        }
        return $content;
    }
}