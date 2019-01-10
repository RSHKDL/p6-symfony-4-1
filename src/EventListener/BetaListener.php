<?php

namespace App\EventListener;

use App\Service\AddBetaHtml;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class BetaListener
{
    /**
     * @var AddBetaHtml
     */
    protected $betaHtml;

    protected $endDate;

    public function __construct(AddBetaHtml $betaHtml, $endDate)
    {
        $this->betaHtml = $betaHtml;
        $this->endDate = new \DateTime($endDate);
    }

    public function processBeta(FilterResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $remainingDays = $this->endDate->diff(new \DateTime('now'))->days;
        if (new \DateTime('now') > $this->endDate) {
            $response = $this->betaHtml->addBeta($event->getResponse(), 0);
        } else {
            $response = $this->betaHtml->addBeta($event->getResponse(), $remainingDays);
        }

        $event->setResponse($response);
    }
}
