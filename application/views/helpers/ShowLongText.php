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
 */

/**
 * @see Zend_Controller_Action_Helper_Abstract
 */
require_once 'Zend/View/Helper/Abstract.php';

/**
 * Helper for determining if the content is more than 120 character. 
 *
 */
class View_Helper_ShowLongText extends Zend_View_Helper_Abstract
{
    /**
     * A helper which intercept 120 characters from a long text
     * 
     * If the text contain keywords, then target the keywords
     * and output the words around the keywords.
     *
     * @param string $text
     * @param string $keywords split with ',' only deal the first keywords
     * @return string $result the text intercepted
     */
    public function ShowLongText($text, $keywords = null)
    {
        $limitLength = 120;
        // filter the words with HTML encode
        // so as to use 'substr' method to deal easily later
        $text = html_entity_decode($text);
        $text = trim($text);
        // if the text's length over the limitation,
        // than output the text with the specify length
        if (strlen($text) > $limitLength) {
            if (!empty($keywords)) {
                // get the first keywords
                $keywords = array_shift(explode(',', $keywords));
                $pos = stripos($text, $keywords);
                // if the keywords is in the middle of the text
                // then cut the words around the keywords to output
                if ($pos > ($limitLength - strlen($keywords))) {
                    $result = '...' . substr($text, $pos - $limitLength/2, $limitLength) . '...';
                } else {
                    $result = substr($text, 0, $limitLength) . '...';
                }
            } else {
                $result = substr($text, 0, $limitLength) . '...';
            }
        } else {
            $result = $text;
        }
        $result = htmlentities($result);
        return $result;
    }
}
