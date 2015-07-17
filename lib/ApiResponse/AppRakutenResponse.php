<?php
namespace Rakuten\Response;
/**
 * This file is part of Rakuten Web Service SDK
 *
 * (c) Rakuten, Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with source code.
 */

use Rakuten\ApiResponse;
/**
 * API Response for app.rakuten.co.jp
 *
 * @package RakutenRws
 * @subpackage ApiResponse
 */
class AppRakutenResponse extends ApiResponse
{
    protected function handleResponse()
    {
        if ($this->httpResponse->getCode() != 200) {
            $this->isOk = false;

            $errorData = json_decode($this->httpResponse->getContents(), true);
            if (isset($errorData['error']) && isset($errorData['error_description'])) {
                $this->message = $errorData['error'].': '.$errorData['error_description'];
            }
        }

        $rawData = json_decode($this->httpResponse->getContents(), true);

        if (null === $rawData)
        {
            throw new \Rakuten\Exception();
        }

        $this->data = $rawData;
    }
}
