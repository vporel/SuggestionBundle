<?php
namespace SuggestionBundle;

use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

/**
 * @author Vivian NKOUANANG (https://github.com/vporel) <dev.vporel@gmail.com>
 */
class SuggestionBundle extends AbstractBundle{

    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->rootNode()
        ->children()
            ->scalarNode("file_path")->isRequired()->end() //The file that stores the suggestions
        ->end();
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import(dirname(__DIR__)."/config/services.yaml");
        $container->parameters()->set("suggestion", $config);
    }
    
}