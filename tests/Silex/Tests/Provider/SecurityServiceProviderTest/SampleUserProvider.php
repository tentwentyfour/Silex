<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silex\Tests\Provider\SecurityServiceProviderTest;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

/**
 * @author David Raison <david@tentwentyfour.lu>
 */
class SampleUserProvider implements UserProviderInterface
{

    public function loadUserByApiKey($apiKey)
    {
        switch($apiKey) {
            case 'foobar':
                return new User('admin', 'foo', array('ROLE_ADMIN'));
            break;
            case 'barfoo':
                return new User('david', 'foo', array('ROLE_USER'));
            break;
        }
    }

    public function loadUserByUsername($username)
    {
        switch($username) {
            case 'david':
                return new User('david', 'foo', array('ROLE_USER'));
            break;
            case 'admin':
                return new User('admin', 'foo', array('ROLE_ADMIN'));
            break;
        }
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf(
                    'Instances of "%s" are not supported.',
                    get_class($user)
                )
            );
        }
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'StdClass';
    }
}
