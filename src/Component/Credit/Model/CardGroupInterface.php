<?php

namespace Kiboko\Component\Credit\Model;

use Doctrine\Common\Collections\Collection;
use Kiboko\Component\DataModel\Model\NamedInterface;
use Kiboko\Component\Pricing\Model\CustomerSegmentSubjectInterface;

interface CardGroupInterface extends NamedInterface, CustomerSegmentSubjectInterface
{
    /**
     * @return Collection|CardInterface[]
     */
    public function getCards() : Collection;

    /**
     * @param CardInterface $cards
     *
     * @return CardGroupInterface
     */
    public function addCard(CardInterface $cards);

    /**
     * @param CardInterface $cards
     *
     * @return CardGroupInterface
     */
    public function removeCard(CardInterface $cards);

    /**
     * @param Collection|CardInterface[] $cards
     *
     * @return CardGroupInterface
     */
    public function setCards(Collection $cards);
}
