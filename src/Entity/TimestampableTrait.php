<?php
namespace App\Entity;

trait TimestampableTrait
{
    private \DateTimeInterface $createdAt;
    private \DateTimeInterface $updatedAt;

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function initializeTimestamps(): void
    {
        $now = new \DateTimeImmutable();
        if (empty($this->createdAt)) {
            $this->createdAt = $now;
        }
        $this->updatedAt = $now;
    }
}
