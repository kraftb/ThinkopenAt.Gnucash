<?php
namespace ThinkopenAt\Gnucash\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * This domain model represents an GnuCash vendor.
 *
 * @Flow\Entity
 */
class Vendor extends AbstractVendorCustomer {

    /**
     * Returns the "QR" identifier stored in the notes field
     *
     * @return string The QR identifier
     */
    public function getQrIdentifier() {
        return $this->getPipePart($this->getNotes(), 'QR');
    }

    /**
     * Returns the "QR" identifier stored in the notes field
     *
     * @return string The QR identifier
     */
    public function getAccount() {
        return $this->getPipePart($this->getNotes(), 'ACCOUNT');
    }

    /**
     * Returns the "QR" identifier stored in the notes field
     *
     * @return string The QR identifier
     */
    protected function getPipePart($value, $prefix) {
        $parts = explode('|', $value);
        foreach ($parts as $part) {
            @list($key, $value) = explode(':', $part);
            if ($key === $prefix) {
                return $value;
            }
        }
        return '';
    }

}

