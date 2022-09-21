<?php

namespace UIIGateway\Castle\Publishing\Publishers;

use Psr\Log\LoggerInterface;

class LogPublisher extends Publisher
{
    /**
     * The logger implementation.
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Create a new publisher instance.
     *
     * @param  \Psr\Log\LoggerInterface  $logger
     * @return void
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function publish($event, array $payload = [], array $channels = [])
    {
        $channels = implode(', ', $this->formatChannels($channels));

        $payload = json_encode($payload, JSON_PRETTY_PRINT);

        if (empty($channels)) {
            $this->logger->info('Publishing [' . $event . '] with payload:' . PHP_EOL . $payload);
        } else {
            $this->logger->info(
                'Publishing and broadcasting [' . $event . '] on channels [' . $channels . '] with payload:' .
                PHP_EOL . $payload
            );
        }
    }
}
