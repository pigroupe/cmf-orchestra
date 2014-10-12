<?php
/**
 * This file is part of the <Encrypt> project.
 *
 * @subpackage   Encrypt
 * @package    Configuration
 * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>
 * @since 2012-01-11
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Sfynx\EncryptBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 * 
 * @subpackage   Encrypt
 * @package    Configuration
 * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sfynx_encrypt');
        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.
        $this->addEncryptConfig($rootNode);

        return $treeBuilder;
    }
    
    /**
     * Encrypt config
     *
     * @param $rootNode \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition
     * @return void
     * @access protected
     * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>
     */
    protected function addEncryptConfig(ArrayNodeDefinition $rootNode) {
    	$rootNode
    	->children()
            ->arrayNode('encrypters')
                ->prototype('array')
        	        ->children()
        	            ->scalarNode('encryptor_annotation_name')->isRequired()->end()
        	            ->scalarNode('encryptor_class')->isRequired()->end()
        	            ->arrayNode('encryptor_options')->prototype('scalar')->end()->end()                	            
        	        ->end()
            	->end()
            ->end()   
        ->end();
    }
       
}
