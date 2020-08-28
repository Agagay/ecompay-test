<?php

namespace App\Entity;

use App\Repository\PaymentStatusLogRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaymentStatusLogRepository::class)
 */
class PaymentStatusLog
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Payment::class, inversedBy="paymentStatusLogs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_transaction;

    /**
     * @ORM\ManyToOne(targetEntity=PaymentStatus::class, inversedBy="paymentStatusLogs")
     */
    private $id_status;

    /**
     * @ORM\ManyToOne(targetEntity=PaymentStatus::class, inversedBy="paymentStatusLogs")
     */
    private $id_prev_status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdTransaction(): ?Payment
    {
        return $this->id_transaction;
    }

    public function setIdTransaction(?Payment $id_transaction): self
    {
        $this->id_transaction = $id_transaction;

        return $this;
    }

    public function getIdStatus(): ?PaymentStatus
    {
        return $this->id_status;
    }

    public function setIdStatus(?PaymentStatus $id_status): self
    {
        $this->id_status = $id_status;

        return $this;
    }

    public function getIdPrevStatus(): ?PaymentStatus
    {
        return $this->id_prev_status;
    }

    public function setIdPrevStatus(?PaymentStatus $id_prev_status): self
    {
        $this->id_prev_status = $id_prev_status;

        return $this;
    }
}
