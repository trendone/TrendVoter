<?php

namespace TrendOne\Bundle\TrendVoterBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * CampaignItem
 *
 * @author Enrico Thies <enrico.thies@gmail.com>
 *
 * @Vich\Uploadable
 */
class CampaignItem
{
    /** @var integer */
    private $id;

    /** @var string */
    private $title;

    /** @var string */
    private $image;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="campaignItem_image", fileNameProperty="image")
     */
    private $imageResource;

    /** @var string */
    private $description;

    /** @var Campaign */
    private $campaign;

    /** @var \Doctrine\Common\Collections\Collection */
    private $answers;

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
        $this->answers = new ArrayCollection();
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
     * @return CampaignItem
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
     * Set image
     *
     * @param string $image
     *
     * @return CampaignItem
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set imageResource
     *
     * @param File $imageResource
     *
     * @return CampaignItem
     */
    public function setImageResource($imageResource)
    {
        $this->imageResource = $imageResource;
        $this->setUpdatedAt(new \DateTime());

        return $this;
    }

    /**
     * Get imageResource
     *
     * @return File
     */
    public function getImageResource()
    {
        return $this->imageResource;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return CampaignItem
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
     * Set campaign
     *
     * @param Campaign $campaign
     *
     * @return CampaignItem
     */
    public function setCampaign($campaign)
    {
        $this->campaign = $campaign;

        return $this;
    }

    /**
     * Get campaign
     *
     * @return Campaign
     */
    public function getCampaign()
    {
        return $this->campaign;
    }

    /**
     * Add answer
     *
     * @param CampaignItemAnswer $answer
     *
     * @return CampaignItem
     */
    public function addAnswer(CampaignItemAnswer $answer)
    {
        $this->answers[] = $answer;

        return $this;
    }

    /**
     * Remove answer
     *
     * @param CampaignItemAnswer $answer
     */
    public function removeAnswer(CampaignItemAnswer $answer)
    {
        $this->answers->removeElement($answer);
    }

    /**
     * Get answers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return CampaignItem
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
     * @return CampaignItem
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
     * @return CampaignItem
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
     * @param integer $value
     *
     * @return number
     */
    public function countAnswersByX($value)
    {
        $counter = 0;

        foreach ($this->getAnswers() as $answer) {
            if ($answer->getAnswerX() == $value) {
                $counter++;
            }
        }

        return $counter;
    }

    /**
     * @return number
     */
    public function averageAnswersX()
    {
        $amount = 0;
        $counter = 0;

        foreach ($this->getAnswers() as $answer) {
            $amount += $answer->getAnswerX();
            $counter++;
        }

        return $counter > 0 ? $amount / $counter : 0;
    }

    /**
     * @return number
     */
    public function medianAnswersX()
    {
        $answers = array();
        $medians = array('upper' => null, 'lower' => null);

        foreach ($this->getAnswers() as $answer) {
            $answers[] = $answer->getAnswerX();
        }

        sort($answers);
        $medians['lower'] = $answers[ceil(count($answers)/2)-1];

        rsort($answers);
        $medians['upper'] = $answers[ceil(count($answers)/2)-1];

        return $medians;
    }

    /**
     * @param integer $value
     *
     * @return number
     */
    public function countAnswersByY($value)
    {
        $counter = 0;

        foreach ($this->getAnswers() as $answer) {
            if ($answer->getAnswerY() == $value) {
                $counter++;
            }
        }

        return $counter;
    }

    /**
     * @return number
     */
    public function averageAnswersY()
    {
        $amount = 0;
        $counter = 0;

        foreach ($this->getAnswers() as $answer) {
            $amount += $answer->getAnswerY();
            $counter++;
        }

        return $counter > 0 ? $amount / $counter : 0;
    }

    /**
     * @return number
     */
    public function medianAnswersY()
    {
        $answers = array();
        $medians = array('upper' => null, 'lower' => null);

        foreach ($this->getAnswers() as $answer) {
            $answers[] = $answer->getAnswerY();
        }

        sort($answers);
        $medians['lower'] = $answers[ceil(count($answers)/2)-1];

        rsort($answers);
        $medians['upper'] = $answers[ceil(count($answers)/2)-1];

        return $medians;
    }
}
