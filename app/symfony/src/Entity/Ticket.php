<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $completed_date = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $technician_user_id = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Priority $priority_id = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Status $status_id = null;

    #[ORM\ManyToMany(targetEntity: Label::class, inversedBy: 'tickets')]
    private Collection $labels;

    #[ORM\ManyToOne(inversedBy: 'adminTickets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $admin_user_id = null;

    public function __construct()
    {
        $this->labels = new ArrayCollection();
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

    public function getTechnicianUserId(): ?user
    {
        return $this->technician_user_id;
    }

    public function setTechnicianUserId(?user $technician_user_id): self
    {
        $this->technician_user_id = $technician_user_id;

        return $this;
    }

    public function getPriorityId(): ?priority
    {
        return $this->priority_id;
    }

    public function setPriorityId(?priority $priority_id): self
    {
        $this->priority_id = $priority_id;

        return $this;
    }

    public function getStatusId(): ?status
    {
        return $this->status_id;
    }

    public function setStatusId(?status $status_id): self
    {
        $this->status_id = $status_id;

        return $this;
    }

    /**
     * @return Collection<int, label>
     */
    public function getLabels(): Collection
    {
        return $this->labels;
    }

    public function addLabel(label $label): self
    {
        if (!$this->labels->contains($label)) {
            $this->labels[] = $label;
        }

        return $this;
    }

    public function removeLabel(label $label): self
    {
        $this->labels->removeElement($label);

        return $this;
    }

    public function getAdminUserId(): ?user
    {
        return $this->admin_user_id;
    }

    public function setAdminUserId(?user $admin_user_id): self
    {
        $this->admin_user_id = $admin_user_id;

        return $this;
    }
}
