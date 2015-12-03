<?php

/*
 * Gobline
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gobline\Logger\Writer;

use Psr\Log\AbstractLogger;
use Swift_Mailer;
use Swift_Message;

/**
 * Writes log information out as mail messages.
 *
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class MailLogWriter extends AbstractLogger
{
    use GetStackTraceTrait;

    private $mailer;
    private $from;
    private $to;

    /**
     * @param Swift_Mailer $mailer
     * @param string|array $from
     * @param string|array $to
     */
    public function __construct(Swift_Mailer $mailer, $from, $to)
    {
        $this->mailer = $mailer;
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @param string $level
     * @param string $message
     * @param array  $context
     */
    public function log($level, $message, array $context = [])
    {
        $message = '['.strtoupper($level).'] '.$message;

        $messageInstance = Swift_Message::newInstance()
            ->setSubject(substr($message, 0, 255))
            ->setFrom($this->from)
            ->setTo($this->to);

        if (isset($context['exception']) && $context['exception'] instanceof \Exception) {
            $messageInstance->setBody($message.$this->getExceptionStackTrace($context['exception']), 'text/html')
                            ->addPart($message.$this->getExceptionStackTrace($context['exception'], false), 'text/plain');
        } else {
            $messageInstance->setBody($message, 'text/html')
                            ->addPart($message, 'text/plain');
        }

        $this->mailer->send($messageInstance);
    }
}
