<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaymentRepository::class)
 */
class Payment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $currency;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $id_external_transaction;

    /**
     * @ORM\OneToMany(targetEntity=PaymentStatusLog::class, mappedBy="id_transaction", cascade={"persist"})
     */
    private $paymentStatusLogs;

    public function __construct()
    {
        $this->paymentStatusLogs = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getIdExternalTransaction(): ?string
    {
        return $this->id_external_transaction;
    }

    public function setIdExternalTransaction(string $id_external_transaction): self
    {
        $this->id_external_transaction = $id_external_transaction;

        return $this;
    }

    /**
     * @return Collection|PaymentStatusLog[]
     */
    public function getPaymentStatusLogs(): Collection
    {
        return $this->paymentStatusLogs;
    }

    public function addPaymentStatusLog(PaymentStatusLog $paymentStatusLog): self
    {
        if (!$this->paymentStatusLogs->contains($paymentStatusLog)) {
            $this->paymentStatusLogs[] = $paymentStatusLog;
            $paymentStatusLog->setIdTransaction($this);
        }

        return $this;
    }

    public function removePaymentStatusLog(PaymentStatusLog $paymentStatusLog): self
    {
        if ($this->paymentStatusLogs->contains($paymentStatusLog)) {
            $this->paymentStatusLogs->removeElement($paymentStatusLog);
            // set the owning side to null (unless already changed)
            if ($paymentStatusLog->getIdTransaction() === $this) {
                $paymentStatusLog->setIdTransaction(null);
            }
        }

        return $this;
    }
}
