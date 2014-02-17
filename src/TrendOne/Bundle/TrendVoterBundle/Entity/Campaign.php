<?php

namespace TrendOne\Bundle\TrendVoterBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Campaign
 *
 * @author Enrico Thies <enrico.thies@gmail.com>
 */
class Campaign
{
    /** @var integer */
    private $id;

    /** @var string */
    private $title;

    /** @var string */
    private $description;

    /** @var string */
    private $slug;

    /** @var string */
    private $questionX;

    /** @var string */
    private $questionY;

    /** @var ArrayCollection */
    private $items;

    /** @var \DateTime */
    private $createdAt;

    /** @var \DateTime */
    private $updatedAt;

    /** @var \DateTime */
    private $deletedAt;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Campaign
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Campaign
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Campaign
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set questionX
     *
     * @param string $questionX
     *
     * @return Campaign
     */
    public function setQuestionX($questionX)
    {
        $this->questionX = $questionX;

        return $this;
    }

    /**
     * Get questionX
     *
     * @return string
     */
    public function getQuestionX()
    {
        return $this->questionX;
    }

    /**
     * Set questionY
     *
     * @param string $questionY
     *
     * @return Campaign
     */
    public function setQuestionY($questionY)
    {
        $this->questionY = $questionY;

        return $this;
    }

    /**
     * Get questionY
     *
     * @return string
     */
    public function getQuestionY()
    {
        return $this->questionY;
    }

    /**
     * Add items
     *
     * @param CampaignItem $item
     *
     * @return Campaign
     */
    public function addItem(CampaignItem $item)
    {
        $this->items[] = $item;
        $item->setCampaign($this);

        return $this;
    }

    /**
     * Remove items
     *
     * @param CampaignItem $item
     */
    public function removeItem(CampaignItem $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Campaign
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Campaign
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     *
     * @return Campaign
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }
}
