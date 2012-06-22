<?php

namespace Cinch\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cinch\CoreBundle\Entity\Block
 */
class Block
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var integer $region_id
     */
    private $region_id;

    /**
     * @var string $subject
     */
    private $subject;

    /**
     * @var integer $subject_id
     */
    private $subject_id;

    /**
     * @var text $comments
     */
    private $comments;

    /**
     * @var Region $region
     */
    protected $region;


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
     * Set subject
     *
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set subject_id
     *
     * @param integer $subjectId
     */
    public function setSubjectId($subjectId)
    {
        $this->subject_id = $subjectId;
    }

    /**
     * Get subject_id
     *
     * @return integer 
     */
    public function getSubjectId()
    {
        return $this->subject_id;
    }

    /**
     * Set comments
     *
     * @param text $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * Get comments
     *
     * @return text 
     */
    public function getComments()
    {
        return $this->comments;
    }
}