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
 * RecipeCategoryList
 *
 * @package RakutenRws
 * @subpackage Api_Definition
 */
class RecipeCategoryList extends AppRakutenApi
{
    protected
        $isRequiredAccessToken = false,
        $versionMap = array(
            '2012-11-21' => '20121121'
        );

    public function getService()
    {
        return 'Recipe';
    }

    public function getOperation()
    {
        return 'CategoryList';
    }
}
