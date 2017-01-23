<?php

namespace Kiboko\Component\TFTConnector\EventListener;

use Akeneo\Bundle\BatchBundle\Entity\Warning;
use Akeneo\Bundle\BatchBundle\Event\InvalidItemEvent;
use Akeneo\Bundle\BatchBundle\Event\JobExecutionEvent;
use Akeneo\Bundle\BatchBundle\Event\StepExecutionEvent;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StepExecutionSubscriber implements EventSubscriberInterface
{
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;

    /**
     * StepExecutionListener constructor.
     * @param SymfonyStyle $symfonyStyle
     */
    public function __construct(SymfonyStyle $symfonyStyle)
    {
        $this->symfonyStyle = $symfonyStyle;
    }

    public static function getSubscribedEvents()
    {
        return [
            /** Job execution events */
            JobExecutionEvent::BEFORE_JOB_EXECUTION      => 'beforeJobExecution',
            JobExecutionEvent::JOB_EXECUTION_STOPPED     => 'jobExecutionStopped',
            JobExecutionEvent::JOB_EXECUTION_INTERRUPTED => 'jobExecutionInterrupted',
            JobExecutionEvent::JOB_EXECUTION_FATAL_ERROR => 'jobExecutionFatalError',
            JobExecutionEvent::BEFORE_JOB_STATUS_UPGRADE => 'beforeJobStatusUpgrade',
            JobExecutionEvent::AFTER_JOB_EXECUTION       => 'afterJobExecution',

            /** Step execution events */
            JobExecutionEvent::BEFORE_STEP_EXECUTION      => 'beforeStepExecution',
            JobExecutionEvent::STEP_EXECUTION_SUCCEEDED   => 'stepExecutionSucceeded',
            JobExecutionEvent::STEP_EXECUTION_INTERRUPTED => 'stepExecutionInterrupted',
            JobExecutionEvent::STEP_EXECUTION_ERRORED     => 'stepExecutionErrored',
            JobExecutionEvent::STEP_EXECUTION_COMPLETED   => 'stepExecutionCompleted',
            JobExecutionEvent::INVALID_ITEM               => 'invalidItem',
        ];
    }

    public function beforeJobExecution(JobExecutionEvent $event)
    {
    }

    public function jobExecutionStopped(JobExecutionEvent $event)
    {
        $this->symfonyStyle->warning(__METHOD__);
        $this->symfonyStyle->block(sprintf(
            'Job execution stopped for job %s',
            $event->getJobExecution()->getJobInstance()->getJobName()
        ));
    }

    public function jobExecutionInterrupted(JobExecutionEvent $event)
    {
        $this->symfonyStyle->warning(__METHOD__);
        $this->symfonyStyle->block(sprintf(
            'Job execution was interrupted for job %s',
            $event->getJobExecution()->getJobInstance()->getJobName()
        ));
    }

    public function jobExecutionFatalError(JobExecutionEvent $event)
    {
        $this->symfonyStyle->warning(__METHOD__);
        $this->symfonyStyle->block(sprintf(
            'Job execution encountered an error for job %s',
            $event->getJobExecution()->getJobInstance()->getJobName()
        ));
    }

    public function beforeJobStatusUpgrade(JobExecutionEvent $event)
    {
    }

    public function afterJobExecution(JobExecutionEvent $event)
    {
    }

    public function beforeStepExecution(StepExecutionEvent $event)
    {
        $this->symfonyStyle->block(sprintf(
            'Starting step %s',
            $event->getStepExecution()->getStepName()
        ));
    }

    public function stepExecutionSucceeded(StepExecutionEvent $event)
    {
    }

    public function stepExecutionInterrupted(StepExecutionEvent $event)
    {
        foreach ($event->getStepExecution()->getErrors() as $error) {
            $this->symfonyStyle->error(
                $error
            );
        }
        /** @var Warning $warning */
        foreach ($event->getStepExecution()->getWarnings() as $warning) {
            $this->symfonyStyle->note(
                strtr($warning->getReason(), $warning->getReasonParameters())
            );
        }
    }

    public function stepExecutionErrored(StepExecutionEvent $event)
    {
        $this->symfonyStyle->warning($event->getStepExecution()->getFailureExceptionMessages());
    }

    public function stepExecutionCompleted(StepExecutionEvent $event)
    {
        foreach ($event->getStepExecution()->getErrors() as $error) {
            $this->symfonyStyle->error(
                $error
            );
        }
        /** @var Warning $warning */
        foreach ($event->getStepExecution()->getWarnings() as $warning) {
            $this->symfonyStyle->note(
                strtr($warning->getReason(), $warning->getReasonParameters())
            );
        }
    }

    public function invalidItem(InvalidItemEvent $event)
    {
        $this->symfonyStyle->warning(
            strtr($event->getReason(), $event->getReasonParameters())
        );
    }
}
