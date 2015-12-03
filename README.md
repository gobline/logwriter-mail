# Mail Log Writer component

```Gobline\Logger\Writer\MailLogWriter``` writes log information out as mail messages.

## Usage

```php
$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
    ->setUsername('sender@example.com')
    ->setPassword('qwerty');

$mailer = Swift_Mailer::newInstance($transport);

$logger = new Gobline\Logger\Writer\MailLogWriter($mailer, 'sender@example.com', 'recipient@example.com');

$logger->debug('hello world');
```

## Installation

You can install the Mail Log Writer using the dependency management tool [Composer](https://getcomposer.org/).
Run the *require* command to resolve and download the dependencies:

```
composer require gobline/logwriter-mail
```