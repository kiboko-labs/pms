<?php

namespace Kiboko\Component\TFTConnector\Command;

use Akeneo\Bundle\BatchBundle\Entity\JobExecution;
use Akeneo\Bundle\BatchBundle\Entity\StepExecution;
use Akeneo\Bundle\BatchBundle\Job\Job;
use Akeneo\Bundle\BatchBundle\Job\JobInterface;
use Akeneo\Bundle\BatchBundle\Job\JobRepositoryInterface;
use Oro\Bundle\BatchBundle\Step\ItemStep;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\PDOMySql\Driver as PDOMySqlDriver;
use Kiboko\Component\TFTConnector\EventListener\StepExecutionSubscriber;
use Kiboko\Component\TFTConnector\Reader\ApiReader;
use Kiboko\Component\TFTConnector\Job\JobRepository;
use Kiboko\Component\TFTConnector\Processor\PricesStocksProcessor;
use Kiboko\Component\TFTConnector\Step\ApiCacheCleanup;
use Kiboko\Component\TFTConnector\Step\ApiCacheFetching;
use Kiboko\Component\TFTConnector\Writer\MagentoPricesWriter;
use Kiboko\Component\TFTConnector\Writer\MagentoPromotionCategoryWriter;
use Kiboko\Component\TFTConnector\Writer\MagentoStocksWriter;
use Oro\Bundle\ImportExportBundle\Context\ContextRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class PricesStocksCommand extends Command
{
    /**
     * @var JobInterface
     */
    private $batchJob;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var JobRepositoryInterface
     */
    private $jobRepository;

    /**
     * @var Connection
     */
    private $connection;

    protected function configure()
    {
        $this->setName('prices-stocks');
    }

    /**
     * @param Connection $connection
     *
     * @return $this
     */
    public function setConnection(Connection $connection)
    {
        $this->connection = $connection;

        return $this;
    }

    /**
     * @param string $configFile
     *
     * @return array
     */
    private function loadConfig(string $configFile)
    {
        return json_decode(
            file_get_contents($configFile),
            JSON_OBJECT_AS_ARRAY
        );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->eventDispatcher = new EventDispatcher();
        $this->jobRepository = new JobRepository();

        $config = $this->loadConfig($input->getArgument('config'));
        if ($this->connection === null) {
            $this->connection = new Connection(
                [
                    'dbname'   => $config['dbname'],
                    'user'     => $config['username'],
                    'password' => $config['password'],
                    'host'     => $config['host'],
                    'driver'   => 'mysqli',
                ],
                new PDOMySqlDriver()
            );
        }

        $contextRegistry = new ContextRegistry();

        $this->batchJob = new Job(
            'luni_product_prices_stocks',
            $this->eventDispatcher,
            new JobRepository(),
            [
                new ApiCacheFetching(
                    'luni_api_cache',
                    $this->eventDispatcher,
                    $this->jobRepository
                ),
                new ItemStep(
                    'luni_product_prices',
                    $this->eventDispatcher,
                    $this->jobRepository,
                    new ApiReader($contextRegistry),
                    new PricesStocksProcessor(),
                    new MagentoPricesWriter($this->connection)
                ),
                new ItemStep(
                    'luni_product_stocks',
                    $this->eventDispatcher,
                    $this->jobRepository,
                    new ApiReader($contextRegistry),
                    new PricesStocksProcessor(),
                    new MagentoStocksWriter($this->connection)
                ),
                new ItemStep(
                    'luni_product_promotion_category',
                    $this->eventDispatcher,
                    $this->jobRepository,
                    new ApiReader($contextRegistry),
                    new PricesStocksProcessor(),
                    new MagentoPromotionCategoryWriter($this->connection)
                ),
                new ApiCacheCleanup(
                    'luni_api_cleanup',
                    $this->eventDispatcher,
                    $this->jobRepository
                ),
            ]
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);
        $this->eventDispatcher->addSubscriber(new StepExecutionSubscriber($style));

        $style->title('Prices and stocks updates from TFT');

        $filename = tempnam(sys_get_temp_dir(), 'tft-prices-stocks');

        $style->note(sprintf('Writing into temporary file %s', $filename));

        $execution = new JobExecution();
        $execution->setJobParameters(
            new JobParameters(
                [
                    'filePath' => $filename,
                    'storeId' => 1,
                    'promotionCategory' => 917
                ]
            )
        );
        $this->batchJob->execute($execution);

        $rows = [];
        /** @var StepExecution $stepExecution */
        foreach ($execution->getStepExecutions() as $stepExecution) {
            $rows[] = [
                $this->batchJob->getName(),
                $stepExecution->getStepName(),
                $stepExecution->getStatus(),
                $stepExecution->getReadCount(),
                $stepExecution->getWriteCount(),
                $stepExecution->getFilterCount(),
                $stepExecution->getStartTime()->format('c'),
                $stepExecution->getEndTime()->format('c'),
            ];
        }

        $style->table(
            [ 'Job', 'Step', 'Status', 'Read count', 'Write count', 'Filter count', 'Start time', 'End time' ],
            $rows
        );
    }
}
