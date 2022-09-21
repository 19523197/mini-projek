<?php

namespace UIIGateway\Castle\Console;

use Exception;
use Illuminate\Console\Command;
use RdKafka;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

#[AsCommand(name: 'kafka:view-topic-records')]
class ViewKafkaTopicRecordsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'kafka:view-topic-records {topic : The Kafka topic to view}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'View records from specific Kafka topic';

    public function handle()
    {
        $topic = $this->argument('topic');

        $conf = new RdKafka\Conf();
        $conf->set('group.id', config('app.name') . date('Ymdhis'));

        $consumer = new RdKafka\Consumer($conf);
        $consumer->addBrokers(config('kafka.brokers'));

        $topicConf = new RdKafka\TopicConf();
        $topicConf->set('auto.commit.interval.ms', 100);
        $topicConf->set('offset.store.method', 'broker');
        $topicConf->set('auto.offset.reset', 'earliest');

        $topicConsumer = $consumer->newTopic($topic, $topicConf);
        $topicConsumer->consumeStart(0, RD_KAFKA_OFFSET_BEGINNING);

        $style = new OutputFormatterStyle('yellow');
        $this->output->getFormatter()->setStyle('warning', $style);

        $this->output->writeln("<info>Retrieving records from topic:</info> <warning>$topic</warning>");
        $this->info('It may take some time.');

        while (true) {
            $message = $topicConsumer->consume(0, 2 * 10000);

            if (! is_null($message)) {
                switch ($message->err) {
                    case RD_KAFKA_RESP_ERR_NO_ERROR:
                        // phpcs:disable Generic.PHP.ForbiddenFunctions
                        var_dump([
                            'payload' => $message->payload,
                            'offset' => $message->offset,
                        ]);
                        // phpcs:enable
                        break;
                    case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                        break 2;
                    case RD_KAFKA_RESP_ERR__TIMED_OUT:
                        echo "Timed out\n";
                        break;
                    default:
                        throw new Exception($message->errstr(), $message->err);
                }
            } else {
                break;
            }
        }
    }
}
