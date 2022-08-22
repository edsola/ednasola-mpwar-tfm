<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Ticket
{
    private ?int $id = null;
    private ?string $title = null;
    private ?string $description = null;
    private ?\DateTimeInterface $created_date = null;
    private ?\DateTimeInterface $completed_date = null;
    private ?User $technician_user_id = null;
    private ?Priority $priority_id = null;
    private ?Status $status_id = null;
    private Collection $labels;
    private ?User $admin_user_id = null;
    private Collection $comments;

    public function __construct()
    {
        $this->labels = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->created_date;
    }

    public function setCreatedDate(\DateTimeInterface $created_date): self
    {
        $this->created_date = $created_date;

        return $this;
    }

    public function getCompletedDate(): ?\DateTimeInterface
    {
        return $this->completed_date;
    }

    public function setCompletedDate(\DateTimeInterface $completed_date): self
    {
        $this->completed_date = $completed_date;

        return $this;
    }

    public function getTechnicianUserId(): ?User
    {
        return $this->technician_user_id;
    }

    public function setTechnicianUserId(?User $technician_user_id): self
    {
        $this->technician_user_id = $technician_user_id;

        return $this;
    }

    public function getPriorityId(): ?Priority
    {
        return $this->priority_id;
    }

    public function setPriorityId(?Priority $priority_id): self
    {
        $this->priority_id = $priority_id;

        return $this;
    }

    public function getStatusId(): ?Status
    {
        return $this->status_id;
    }

    public function setStatusId(?Status $status_id): self
    {
        $this->status_id = $status_id;

        return $this;
    }

    /**
     * @return Collection<int, Label>
     */
    public function getLabels(): Collection
    {
        return $this->labels;
    }

    public function addLabel(Label $label): self
    {
        if (!$this->labels->contains($label)) {
            $this->labels[] = $label;
        }

        return $this;
    }

    public function removeLabel(Label $label): self
    {
        $this->labels->removeElement($label);

        return $this;
    }

    public function getAdminUserId(): ?User
    {
        return $this->admin_user_id;
    }

    public function setAdminUserId(?User $admin_user_id): self
    {
        $this->admin_user_id = $admin_user_id;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setTicket($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTicket() === $this) {
                $comment->setTicket(null);
            }
        }

        return $this;
    }

    public static function CreateTicket(int $id, string $title, string $description, \DateTimeInterface $created_date, \DateTimeInterface $completed_date, User $technician_user, Priority $priority, Status $status, array $labels, User $admin_user, array $comments): Ticket
    {
        $ticket = new self($id, $title, $description, $created_date, $completed_date, $technician_user, $priority, $status, $labels, $admin_user, $comments);
        return $ticket;
    }

}
