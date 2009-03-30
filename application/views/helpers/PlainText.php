<?php
/**
 * Copyright (c) 2008 Endeavor Systems, Inc.
 *
 * This file is part of OpenFISMA.
 *
 * OpenFISMA is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OpenFISMA is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OpenFISMA.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author    Woody Lee <woody712@users.sourceforge.net>
 * @copyright (c) Endeavor Systems, Inc. 2008 (http://www.endeavorsystems.com)
 * @license   http://www.openfisma.org/mw/index.php?title=License
 * @version   $Id$
 * @package Zend_View
 */

/**
 * @see Zend_View_Helper_Abstract
 */
require_once 'Zend/View/Helper/Abstract.php';

/**
 * Helper for rendering HTML to plain text.
 */
class View_Helper_PlainText extends Zend_View_Helper_Abstract
{
    /**
     * To render HTML to plain text. 
     * Return the HTML code which has been dealt.
     *
     * @param string $html HTML code
     * @param boolean $entityDecode whether decode
     * @param boolean $stripTags whether remove HTML tags
     * @param boolean $lineFeed whether replace the tags like 'p','br' with line feed code
     * @return string HTML code which has been dealt
     */
    public function PlainText($html, $entityDecode = true, $stripTags = true, $lineFeed = true)
    {
        if (empty($html)) {
            return $html;
        }
        // fix and remove extra space
        $html = preg_replace('/('.chr(32).')+/', ' ', $html);
        if ($lineFeed) {
            // find the end of 'P' tag and use line feed (ASII code 10) to replace it
            $html = str_ireplace('</p>', chr(10), $html);
            // remove the head of 'P' tag.
            $html = str_ireplace('<p>', '', $html);
            // replace 'br' tag ('<br>', '<br/>', '<br >', '<br />' case-insensitive) with line feed.
            $html = preg_replace('/(<br)(.?)(>|\/>)/i', chr(10), $html);
        }
        if ($stripTags) {
            $html = strip_tags($html);
        }
        if ($entityDecode) {
            $html = html_entity_decode($html);
        }
        return $html;
    } 
}
