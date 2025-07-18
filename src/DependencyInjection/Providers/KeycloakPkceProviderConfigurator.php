<?php

/*
 * OAuth2 Client Bundle
 * Copyright (c) KnpUniversity <http://knpuniversity.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KnpU\OAuth2ClientBundle\DependencyInjection\Providers;

use KnpU\OAuth2ClientBundle\Client\Provider\Pkce\KeycloakPkceClient;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;

class KeycloakPkceProviderConfigurator implements ProviderConfiguratorInterface
{
    public function buildConfiguration(NodeBuilder $node)
    {
        $node
            ->scalarNode('auth_server_url')
                ->isRequired()
                ->info('Keycloak server URL')
            ->end()
            ->scalarNode('realm')
                ->isRequired()
                ->info('Keycloak realm')
            ->end()
            ->scalarNode('encryption_algorithm')
                ->defaultNull()
                ->info('Optional: Encryption algorithm, i.e. RS256')
            ->end()
            ->scalarNode('encryption_key_path')
                ->defaultNull()
                ->info('Optional: Encryption key path, i.e. ../key.pem')
            ->end()
            ->scalarNode('encryption_key')
                ->defaultNull()
                ->info('Optional: Encryption key, i.e. contents of key or certificate')
            ->end()
            ->scalarNode('version')
                ->defaultNull()
                ->info('Optional: The keycloak version to run against')
                ->example("version: '20.0.1'")
            ->end()
        ;
    }

    public function getProviderClass(array $config)
    {
        return 'Stevenmaguire\OAuth2\Client\Provider\Keycloak';
    }

    public function getProviderOptions(array $config)
    {
        return [
            'clientId' => $config['client_id'],
            'clientSecret' => $config['client_secret'],
            'authServerUrl' => $config['auth_server_url'],
            'realm' => $config['realm'],
            'version' => $config['version'],
            'encryptionAlgorithm' => $config['encryption_algorithm'],
            'encryptionKeyPath' => $config['encryption_key_path'],
            'encryptionKey' => $config['encryption_key'],
        ];
    }

    public function getPackagistName()
    {
        return 'stevenmaguire/oauth2-keycloak';
    }

    public function getLibraryHomepage()
    {
        return 'https://github.com/stevenmaguire/oauth2-keycloak';
    }

    public function getProviderDisplayName()
    {
        return 'KeycloakPkce';
    }

    public function getClientClass(array $config)
    {
        return KeycloakPkceClient::class;
    }
}
