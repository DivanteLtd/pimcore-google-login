<?php
/**
 * @category    Pimcore Plugin
 * @date        13/06/2017 12:07
 * @author      Jakub Płaskonka <jplaskonka@divante.pl>
 * @copyright   Copyright (c) 2017 Divante Ltd. (https://divante.co)
 */

namespace GoogleLogin;

use GoogleLogin\Helper\Config;
use Pimcore\API\Plugin as PluginLib;

/**
 * Class Plugin
 *
 * @package GoogleLogin
 */
class Plugin extends PluginLib\AbstractPlugin implements PluginLib\PluginInterface
{
    /**
     * Plugin init
     */
    public function init()
    {
        parent::init();

        \Pimcore::getEventManager()->attach(
            "admin.login.index.authenticate",
            function ($event) {
                $uri = $event->getTarget()->getRequest()->getRequestUri();

                if ($uri == '/admin/login' || $uri == '/admin') {
                    $frontController = \Zend_Controller_Front::getInstance();
                    $frontController->getResponse()->setRedirect('/plugin/GoogleLogin/index/login');
                }
            }
        );
    }

    /**
     * @return bool
     */
    public static function install()
    {
        $configHelper = new Config();
        if (!$configHelper->verifyConfig()) {
            return "This plugin is not yet configured!";
        }

        return true;
    }

    /**
     * Deletes config
     * @return bool
     */
    public static function uninstall()
    {
        $configHelper = new Config();
        $configHelper->deleteConfig();
        return "Google Login Plugin has been uninstalled.";
    }

    /**
     * @return bool
     */
    public static function isInstalled()
    {
        $configHelper = new Config();
        if (!$configHelper->verifyConfig()) {
            return false;
        }

        return true;
    }
}
