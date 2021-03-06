<?php
namespace Rakuten\Api;

use Rakuten\Api\ApiInterface;
/**
 * This file is part of Rakuten Web Service SDK
 *
 * (c) Rakuten, Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with source code.
 */

/**
 * API base class
 *
 * @package RakutenRws
 * @subpackage Api
 */
abstract class Base implements ApiInterface
{
    protected
        $version         = null,
        $versionMap      = array(),
        $client          = null,
        $autoSetIterator = false,
        $options         = array();

    public function __construct(\Rakuten\Client $client, $options = array())
    {
        $this->options = $options;
        $this->client  = $client;
        $this->version = $this->getLatestVersion();
    }

    public function getAvailableVersions()
    {
        return array_keys($this->versionMap);
    }

    public function getOperationName()
    {
        $className = explode('_', get_class($this));
        return end($className);
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getLatestVersion()
    {
        foreach ($this->versionMap as $version => $versionValue) {
            return $version;
        }

        throw new \Rakuten\Exception('There is no version definition in this API.');
    }

    public function setVersion($version)
    {
        if (!in_array($version, $this->getAvailableVersions())) {
            throw new \Rakuten\Exception(sprintf('version %s is not defined.', $version));
        }

        $this->version = $version;
    }
}
