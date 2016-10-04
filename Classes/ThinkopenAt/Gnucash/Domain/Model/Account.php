<?php
namespace ThinkopenAt\Gnucash\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * This domain model represents an GnuCash account.
 *
 * @Flow\Entity
 */
class Account {

	/**
	 * The parent account for this account
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Model\Account
	 * @ORM\ManyToOne(inversedBy="children")
	 * @Flow\Lazy
	 */	 
	protected $parent = NULL;

	/**
	 * The child accounts for this account
	 *
	 * @var \SplObjectStorage<\ThinkopenAt\Gnucash\Domain\Model\Account>
	 * @ORM\OneToMany(mappedBy="parent")
	 * @ORM\OrderBy({"name" = "ASC"})
	 */	 
	protected $children = NULL;

	/**
	 * The name of this account
	 *
	 * @var string
	 */	 
	protected $name = '';

	/**
	 * A description for this account
	 *
	 * @var string
	 */	 
	protected $description = '';

	/**
	 * A code being defined for this account.
	 *
	 * @var string
	 */	 
	protected $code = '';

	/**
	 * The type of this account
	 * Probably there should be a domain model (Dto) for this variable instead of just being a string
	 *
	 * @var string
	 * @ORM\Column(name="account_type")
	 */	 
	protected $accountType = '';

	/**
	 * The commodity for this account. Usually referes to the kind of currency being
     * used for this account. Like EURO, Dollar, etc.
	 * Probably there should be a domain model (Dto) for this variable instead of just being a string
	 *
	 * @var string
	 */	 
	protected $commodity = '';


    /**
     * Returns the parent of this account
     * 
	 * @return \ThinkopenAt\Gnucash\Domain\Model\Account The parent for this account
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * Sets the parent of this account
     * 
	 * @param \ThinkopenAt\Gnucash\Domain\Model\Account $parent: The parent for this account
     * @return void
     */
    public function setParent(\ThinkopenAt\Gnucash\Domain\Model\Account $parent) {
        $this->parent = $parent;
    }

    /**
     * Returns the children of this account
     * 
	 * @return \SplObjectStorage The children of this account
     */
    public function getChildren() {
        return $this->children;
    }

    /**
     * Sets the children of this account
     * 
	 * @param \SplObjectStorage $children: The children of this account
     * @return void
     */
    public function setChildren(\SplObjectStorage $children) {
        $this->children = $children;
    }

    /**
     * Returns the name of this account
     * 
	 * @return string The name of this account
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Sets the name of this account
     * 
	 * @param string $name: The name of this account
     * @return void
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Returns the description of this account
     * 
	 * @return string The description of this account
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Sets the description of this account
     * 
	 * @param string $description: The description of this account
     * @return void
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * Returns the code for this account
     * 
	 * @return string The code for this account
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * Sets the code for this account
     * 
	 * @param string $code: The code for this account
     * @return void
     */
    public function setCode($code) {
        $this->code = $code;
    }

    /**
     * Returns the type for this account
     * 
	 * @return string The type for this account
     */
    public function getAccountType() {
        return $this->accountType;
    }

    /**
     * Sets the type for this account
     * 
	 * @param string $accountType: The type for this account
     * @return void
     */
    public function setAccountType($accountType) {
        $this->accountType = $accountType;
    }

    /**
     * Returns the commodity for this account
     * 
	 * @return string The commodity for this account
     */
    public function getCommodity() {
        return $this->commodity;
    }

    /**
     * Sets the commodity for this account
     * 
	 * @param string $commodity: The commodity for this account
     * @return void
     */
    public function setCommodity($commodity) {
        $this->commodity = $commodity;
    }

    public function __toString() {
        return $this->Persistence_Object_Identifier;
    }

}

