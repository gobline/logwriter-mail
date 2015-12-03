<?php

/*
 * Gobline
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Gobline\Logger\Writer\MailLogWriter;
use \Swift_Mailer;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class MailLogWriterTest extends PHPUnit_Framework_TestCase
{
    public function testLoggerMail()
    {
        $config = __DIR__.'./resources/conf.php';

        if (!is_file($config)) {
            return;
        }
        $config = include $config;

        $host = $config['host'];
        $port = $config['port'];
        $user = $config['user'];
        $password = $config['password'];
        $security = $config['security'];
        $recipient = $config['recipient'];
        $sender = $config['sender'];

        $transport = Swift_SmtpTransport::newInstance($host, $port, $security)
            ->setUsername($user)
            ->setPassword($password);

        $mailer = Swift_Mailer::newInstance($transport);

        $logger = new MailLogWriter($mailer, $sender, $recipient);

        $logger->debug('hello world');

        $this->assertTrue(true);
    }
}
