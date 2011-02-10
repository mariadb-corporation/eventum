<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 encoding=utf-8: */
// +----------------------------------------------------------------------+
// | Eventum - Issue Tracking System                                      |
// +----------------------------------------------------------------------+
// | Copyright 2011, Elan Ruusamäe <glen@delfi.ee>                        |
// +----------------------------------------------------------------------+
// |                                                                      |
// | This program is free software; you can redistribute it and/or modify |
// | it under the terms of the GNU General Public License as published by |
// | the Free Software Foundation; either version 2 of the License, or    |
// | (at your option) any later version.                                  |
// |                                                                      |
// | This program is distributed in the hope that it will be useful,      |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the        |
// | GNU General Public License for more details.                         |
// |                                                                      |
// | You should have received a copy of the GNU General Public License    |
// | along with this program; if not, write to:                           |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+

require_once 'PHPUnit/Framework.php';
require_once 'TestSetup.php';

/**
 * Test class for Mime_Helper.
 * Generated by PHPUnit on 2011-01-18 at 22:58:58.
 */
class Mime_HelperTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Mime_Helper
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Mime_Helper;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    public function testEncodeQuotedPrintable()
    {
        $string = "61.jpg";
        $exp = '=?utf-8?B?NjEuanBn?=';
        $res = $this->object->encodeQuotedPrintable($string);
        $this->assertEquals($exp, $res, 'do not overflow');

/*
        // avoid any wrapping by specifying line length long enough
        // test = 4
        // : =?ISO-8859-1?B?dGVzdA==?=
        // 3 +2 +10      +3 +7     + 3
        $line_length = strlen($string) * 4 + strlen(APP_CHARSET) + 11;
        echo "ll=$line_length\n";

        #	=?ISO-8859-1?B?a2FtbWliw7xsZXBlYQ==?=glen@wintersunset
        $params = array(
            "scheme" => "Q",
            "input-charset" => APP_CHARSET,
            "output-charset" => APP_CHARSET,
        );
        $string = iconv_mime_encode("", $string, $params);
        echo "HIERO\n";
        #echo $string, "\n";
        echo substr($string, 2), "\n";
        echo "Klaar\n";
*/
    }
     
    public function testDecodeQuotedPrintable()
    {
        // iconv test from php manual
        $string = '=?UTF-8?B?UHLDvGZ1bmcgUHLDvGZ1bmc=?=';
        $exp = 'Prüfung Prüfung';
        $res = $this->object->decodeQuotedPrintable($string);
        $this->assertEquals($exp, $res);

        // test that result is returned to APP_CHARSET
        $string = '=?ISO-8859-1?B?SuTkZ2VybWVpc3Rlcg==?=';
        $exp = 'Jäägermeister';
        $res = $this->object->decodeQuotedPrintable($string);
        $this->assertEquals($exp, $res);

        // different charsets inside one string
        $string = '=?ISO-8859-1?q?M=FCller=2C?= ACME =?US-ASCII?q?Corp=2E?=';
        $exp = 'Müller, ACME Corp.';
        $res = $this->object->decodeQuotedPrintable($string);
        $this->assertEquals($exp, $res);
    }
}
