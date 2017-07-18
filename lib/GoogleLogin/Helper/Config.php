<?php
/**
 * @category    Pimcore Plugin
 * @date        13/06/2017 15:49
 * @author      Jakub Płaskonka <jplaskonka@divante.pl>
 * @copyright   Copyright (c) 2017 Divante Ltd. (https://divante.co)
 */

namespace GoogleLogin\Helper;

/**
 * Class Config
 *
 * @package GoogleLogin\Helper
 */
class Config
{

    /**
     * Let's be sure it's unique
     */
    const CONFIG_FILENAME = "googlelogin.php";

    /**
     * Gets config from file
     * @return \Zend_Config
     */
    public function getConfig()
    {
        if (file_exists($this->getConfigFilePath())) {
            $config = new \Zend_Config(include($this->getConfigFilePath()), true);
        } else {
            $config = new \Zend_Config(array(
                "clientId" => "",
                "clientSecret" => "",
                "redirectUri" => "",
                "hostedDomain" => ""
            ), true);
        }

        return $config;
    }

    /**
     * Saves config to file
     * @param \Zend_Config $config
     * @return \Zend_Config
     */
    public function saveConfig(\Zend_Config $config)
    {
        \Pimcore\File::putPhpFile($this->getConfigFilePath(), to_php_data_file_format($config->toArray()));

        return $config;
    }

    /**
     * Is config ok?
     * @return bool
     */
    public function verifyConfig()
    {
        if (!file_exists($this->getConfigFilePath())) {
            return false;
        }

        if (!$this->getConfig()) {
            return false;
        }

        return true;
    }

    /**
     * Deletes config file
     * @return bool
     */
    public function deleteConfig()
    {
        unlink($this->getConfigFilePath());
        return true;
    }

    /**
     * Full path for config file
     * @return string
     */
    protected function getConfigFilePath()
    {
        return PIMCORE_CUSTOM_CONFIGURATION_DIRECTORY . "/" . self::CONFIG_FILENAME;
    }
}