<?php
/**
 * Copyright (c) 2008 Endeavor Systems, Inc.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author    Mark E. Haase <mhaase@endeavorsystems.com>
 * @copyright (c) Endeavor Systems, Inc. 2008 (http://www.endeavorsystems.com)
 * @license   http://www.openfisma.org/mw/index.php?title=License
 * @version   $Id$
 */

require_once(realpath(dirname(__FILE__) . '/../FismaUnitTest.php'));

/**
 * Unit tests for the System model
 *
 * @package Test
 */
class Test_Model_System extends Test_FismaUnitTest
{
    /**
     * Test that the threat likelihood calculations are correct. There are only 9 possible outcomes, so test all of
     * them.
     */
    public function testThreatLikelihoodCalculations()
    {
        $s = new System();
        
        $this->assertEquals($s->calculateThreatLikelihood('HIGH', 'LOW'),      'HIGH');
        $this->assertEquals($s->calculateThreatLikelihood('HIGH', 'MODERATE'), 'MODERATE');
        $this->assertEquals($s->calculateThreatLikelihood('HIGH', 'HIGH'),     'LOW');
        
        $this->assertEquals($s->calculateThreatLikelihood('MODERATE', 'LOW'),      'MODERATE');
        $this->assertEquals($s->calculateThreatLikelihood('MODERATE', 'MODERATE'), 'MODERATE');
        $this->assertEquals($s->calculateThreatLikelihood('MODERATE', 'HIGH'),     'LOW');
        
        $this->assertEquals($s->calculateThreatLikelihood('LOW', 'LOW'),      'LOW');
        $this->assertEquals($s->calculateThreatLikelihood('LOW', 'MODERATE'), 'LOW');
        $this->assertEquals($s->calculateThreatLikelihood('LOW', 'HIGH'),     'LOW');
    }
}