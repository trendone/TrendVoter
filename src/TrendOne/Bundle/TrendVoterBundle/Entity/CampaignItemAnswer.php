<?php

namespace TrendOne\Bundle\TrendVoterBundle\Entity;

/**
 * CampaignItemAnswer
 *
 * @author Enrico Thies <enrico.thies@gmail.com>
 */
class CampaignItemAnswer
{
    /** @var integer */
    private $id;

    /** @var string */
    private $user;

    /** @var integer */
    private $answerX;

    /** @var integer */
    private $answerY;

    /** @var \DateTime */
    private $createdAt;

    /** @var \DateTime */
    private $updatedAt;

    /** @var \DateTime */
    private $deletedAt;

    /** @var CampaignItem */
    private $campaignItem;


    /**
     * Set user
     *
     * @param string $user
     *
     * @return CampaignItemAnswer
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set answerX
     *
     * @param integer $answerX
     *
     * @return CampaignItemAnswer
     */
    public function setAnswerX($answerX)
    {
        $this->answerX = $answerX;

        return $this;
    }

    /**
     * Get answerX
     *
     * @return integer
     */
    public function getAnswerX()
    {
        return $this->answerX;
    }

    /**
     * Set answerY
     *
     * @param integer $answerY
     *
     * @return CampaignItemAnswer
     */
    public function setAnswerY($answerY)
    {
        $this->answerY = $answerY;

        return $this;
    }

    /**
     * Get answerY
     *
     * @return integer
     */
    public function getAnswerY()
    {
        return $this->answerY;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return CampaignItemAnswer
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
     * @return CampaignItemAnswer
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
     * @return CampaignItemAnswer
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
     * Set campaignItem
     *
     * @param CampaignItem $campaignItem
     *
     * @return CampaignItemAnswer
     */
    public function setCampaignItem(CampaignItem $campaignItem)
    {
        $this->campaignItem = $campaignItem;

        return $this;
    }

    /**
     * Get campaignItem
     *
     * @return CampaignItem
     */
    public function getCampaignItem()
    {
        return $this->campaignItem;
    }
}
