<?php
namespace Rakuten\Api\Definition;

use Rakuten\Api\AppRakutenApi;

/**
 * This file is part of Rakuten Web Service SDK
 *
 * (c) Rakuten, Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with source code.
 */

/**
 * KoboEbookSearch
 *
 * @package RakutenRws
 * @subpackage Api_Definition
 */
class KoboEbookSearch extends AppRakutenApi
{
    protected
        $autoSetIterator = true,
        $isRequiredAccessToken = false,
        $versionMap = array(
            '2014-08-11' => '20140811',
            '2013-10-10' => '20131010'
        );

    public function getService()
    {
        return 'Kobo';
    }

    public function getOperation()
    {
        return 'EbookSearch';
    }
}
