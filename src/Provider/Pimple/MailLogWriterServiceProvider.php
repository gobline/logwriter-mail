<?php

/*
 * Mendo Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mendo\Logger\Writer\Provider\Pimple;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class MailLogWriterServiceProvider implements ServiceProviderInterface
{
    private $reference;

    public function __construct($reference = 'logwriter.mail')
    {
        $this->reference = $reference;
    }

    public function register(Container $container)
    {
        $container[$this->reference] = function ($c) {
            if (empty($c[$this->reference.'.mailer'])) {
                throw new \Exception('mailer not specified');
            }
            if (empty($c[$c[$this->reference.'.mailer']])) {
                throw new \Exception('mailer not found');
            }
            if (empty($c[$this->reference.'.from'])) {
                throw new \Exception('sender not specified');
            }
            if (empty($c[$this->reference.'.to'])) {
                throw new \Exception('recipient(s) not specified');
            }

            return new SwiftMailer(
                $c[$c[$this->reference.'.mailer']],
                $c[$this->reference.'.from'],
                $c[$this->reference.'.to']
            );
        };
    }
}
