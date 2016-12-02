<?php
/**
 * NodeTreeEngineExtension
 *
 * @package   node-tree-engine
 * @author    Xavier Arnaus <xavier@arnaus.net>
 * @since     2016-12-02
 */

namespace NodeTreeEngine\Bundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class NodeTreeEngineExtension extends Extension
{
	public function load(array $config, ContainerBuilder $container)
	{
		$loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
		$loader->load('services.xml');
	}
}
