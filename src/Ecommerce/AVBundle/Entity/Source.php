<?php

namespace Ecommerce\AVBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecommerce\AVBundle\Entity\Source
 */
class Source
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var datetime $created
     */
    protected $created;

    /**
     * @var datetime $updated
     */
    protected $updated;

    /**
     * @var boolean $active
     */
    protected $active;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $source
     */
    protected $source;

    /**
     * @var text $ip
     */
    protected $ip;

    /**
     * @var boolean $wikiuser
     */
    protected $wikiuser;


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
     * Set created
     *
     * @param datetime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get created
     *
     * @return datetime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param datetime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * Get updated
     *
     * @return datetime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set active
     *
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set source
     *
     * @param string $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     * Get source
     *
     * @return string 
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set ip
     *
     * @param text $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * Get ip
     *
     * @return text 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set wikiuser
     *
     * @param boolean $wikiuser
     */
    public function setWikiuser($wikiuser)
    {
        $this->wikiuser = $wikiuser;
    }

    /**
     * Get wikiuser
     *
     * @return boolean 
     */
    public function getWikiuser()
    {
        return $this->wikiuser;
    }

	function __toJson()
	{
		$json = new \stdClass();

		foreach ($this as $key => $value) {
			if (is_object($value)) {
				if (method_exists($value, '__toJson')) {
					$json->$key = $value->__toJson();
				}
			} else {
				$json->$key = $value;
			}
		}
		return $json;
	}
}