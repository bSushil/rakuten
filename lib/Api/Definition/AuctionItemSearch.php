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
 * AuctionItemSearch2
 *
 * @package RakutenRws
 * @subpackage Api_Definition
 */
class AuctionItemSearch extends AppRakutenApi
{
    protected
        $autoSetIterator = true,
        $isRequiredAccessToken = false,
        $versionMap = array(
            '2013-09-05' => '20130905',
            '2013-01-10' => '20130110',
            '2013-10-10' => '20131010'
        );

    public function getService()
    {
        return 'AuctionItem';
    }

    public function getOperation()
    {
        return 'Search';
    }
}
