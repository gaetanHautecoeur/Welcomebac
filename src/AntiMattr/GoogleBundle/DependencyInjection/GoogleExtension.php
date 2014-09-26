<?php

namespace AntiMattr\GoogleBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class GoogleExtension extends Extension
{
    /**
     * @see Symfony\Component\DependencyInjection\Extension.ExtensionInterface::load()
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $modules = array(
            'adwords' => array(),
            'analytics' => array(),
            'maps' => array(),
        );

        foreach ($configs as $config) {
            foreach (array_keys($modules) as $module) {
                if (array_key_exists($module, $config)) {
                    $modules[$module][] = isset($config[$module]) ? $config[$module] : array();
                }
            }
        }

        foreach (array_keys($modules) as $module) {
            if (!empty($modules[$module])) {
                call_user_func(array($this, $module . 'Load'), $modules[$module], $container);
            }
        }
    }

    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    private function adwordsLoad(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('adwords.xml');

        foreach ($configs as $config) {
            if (isset($config['conversions'])) {
                $container->setParameter('google.adwords.conversions', $config['conversions']);
            }
        }
    }

    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    private function analyticsLoad(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('analytics.xml');

        foreach ($configs as $config) {
            if (isset($config['trackers'])) {
                $container->setParameter('google.analytics.trackers', $config['trackers']);
            }
            if (isset($config['debug'])) {
                $container->setParameter('google.analytics.debug', $config['debug']);
            }
        }
    }

    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    private function mapsLoad(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('maps.xml');

        foreach ($configs as $config) {
            if (isset($config['config'])) {
                $container->setParameter('google.maps.config', $config['config']);
            }
        }
    }

    /**
     * @see Symfony\Component\DependencyInjection\Extension.ExtensionInterface::getAlias()
     * @codeCoverageIgnore
     */
    public function getAlias()
    {
        return 'google';
    }
}
