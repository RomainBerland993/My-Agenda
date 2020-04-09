<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\AgendaRepository")
 */
class Agenda
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="agendas")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="time")
     */
    private $heure;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AgendaComment", mappedBy="agenda")
     */
    private $agendaComments;

    public function __construct()
    {
        $this->agendaComments = new ArrayCollection();
    }

    public function __tostring()
    {
        return $this->titre;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->heure;
    }

    public function setHeure(\DateTimeInterface $heure): self
    {
        $this->heure = $heure;

        return $this;
    }

    /**
     * @return Collection|AgendaComment[]
     */
    public function getAgendaComments(): Collection
    {
        return $this->agendaComments;
    }

    public function addAgendaComment(AgendaComment $agendaComment): self
    {
        if (!$this->agendaComments->contains($agendaComment)) {
            $this->agendaComments[] = $agendaComment;
            $agendaComment->setAgenda($this);
        }

        return $this;
    }

    public function removeAgendaComment(AgendaComment $agendaComment): self
    {
        if ($this->agendaComments->contains($agendaComment)) {
            $this->agendaComments->removeElement($agendaComment);
            // set the owning side to null (unless already changed)
            if ($agendaComment->getAgenda() === $this) {
                $agendaComment->setAgenda(null);
            }
        }

        return $this;
    }
}
