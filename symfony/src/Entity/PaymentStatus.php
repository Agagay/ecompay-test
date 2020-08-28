<?php

namespace App\Entity;

use App\Repository\PaymentStatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaymentStatusRepository::class)
 */
class PaymentStatus
{
    const STATUS_INIT = 'init';
    const STATUS_EXTERNAL = 'external';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CALLBACK = 'awaiting_callback';
    const STATUS_RECEIVED = 'received';
    const STATUS_DECLINE = 'decline';
    const STATUS_SUCCESS = 'success';
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity=PaymentStatusLog::class, mappedBy="id_status")
     */
    private $paymentStatusLogs;

    public function __construct()
    {
        $this->paymentStatusLogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

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
            $paymentStatusLog->setIdStatus($this);
        }

        return $this;
    }

    public function removePaymentStatusLog(PaymentStatusLog $paymentStatusLog): self
    {
        if ($this->paymentStatusLogs->contains($paymentStatusLog)) {
            $this->paymentStatusLogs->removeElement($paymentStatusLog);
            // set the owning side to null (unless already changed)
            if ($paymentStatusLog->getIdStatus() === $this) {
                $paymentStatusLog->setIdStatus(null);
            }
        }

        return $this;
    }
}
