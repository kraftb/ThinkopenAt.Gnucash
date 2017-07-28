<?php
namespace ThinkopenAt\Gnucash\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.TimeFlies". *
 *                                                                        *
 *                                                                        */

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;
use TYPO3\Flow\Utility\Arrays;

class AbstractBmdExportController extends AbstractGnucashController {

    /**
     * The CSV file type configuration
     *
     * @var array
     */
    protected $csv = [
        'delimiter' => ';',
        'enclosure' => '"',
        'escape' => '\\',
    ];

    /**
     * Generate CSV head for export
     *
     * @param array $config: The configuration for the export
     * @return string The CSV export head line
     */
    protected function bmdExportHead($config) {
        $fd = fopen('php://temp', 'w+b');
        fputcsv($fd, array_keys($config), $this->csv['delimiter'], $this->csv['enclosure'], $this->csv['escape']);
        return $this->getFileContent($fd);
    }

    /**
     * Export the passed splits/transaction according to the given configuration
     *
     * @param \TYPO3\Flow\Persistence\Doctrine\QueryResult $splits: The transaction splits which should get exported
     * @param array $config: The export configuration
     * @return string The exported splits as CSV lines
     */
    protected function bmdExport($splits, $config) {
        $fd = fopen('php://temp', 'w+b');
        foreach ($splits as $split) {
            $data = array();
            foreach ($config as $field => $fieldConfig) {
                $data[$field] = $this->exportField($split, $fieldConfig, $field);
            }
            fputcsv($fd, $data, $this->csv['delimiter'], $this->csv['enclosure'], $this->csv['escape']);
        }
        return $this->getFileContent($fd);
    }

    /**
     * Reads out all content from the passed file descriptor and closes it.
     *
     * @param resource $fd: The file descriptor which to read
     * @return string All content from the passed resource
     */
    protected function getFileContent($fd) {
        // Read-out and return generated CSV lines.
        rewind($fd);
        $result = stream_get_contents($fd);
        fclose($fd);
        return $result;
    }

    /**
     * Generates the output data for a given field according to the fiel configuration
     *
     * @param \ThinkopenAt\Gnucash\Domain\Model\Split $split: The split from which to export a field
     * @param array|string $fieldConfig: Either a plain value (string) or an export configuration
     * @param string $fieldName: The name of the field to export
     * @return string The generated export value
     */
    protected function exportField($split, $fieldConfig, $fieldName) {
        // Guard clause
        if (!is_array($fieldConfig)) {
            // Plain static value
            return $fieldConfig;
        }

        // Initialize result to empty
        $result = '';

        // TODO: Split up field handlers to separate class files.

        // Get value from field/property of split
        if (isset($fieldConfig['field'])) {
            $parts = explode('.', $fieldConfig['field']);
            $value = $split;
            foreach ($parts as $part) {
                $getter = 'get' . ucfirst($part);
                $value = $value->$getter();
            }
            if ($value instanceof \DateTime) {
                $result = $value->format(isset($fieldConfig['dateFormat']) ? $fieldConfig['dateFormat'] : 'd.m.Y');
            } else {
                $result = (string)$value;
            }
        }

        // Apply a multiplicative factor
        if (isset($fieldConfig['factor'])) {
            if (!is_numeric($result)) {
                throw new \Exception('Field "' . $fieldName . '": Value "' . $result . '" is not numeric!');
            }
            $result =  $result * $fieldConfig['factor'];
        }

        // Format number according to a given format
        if (isset($fieldConfig['numberFormat'])) {
            $result = number_format(
                    $result,
                    $fieldConfig['numberFormat'][0],
                    $fieldConfig['numberFormat'][1],
                    $fieldConfig['numberFormat'][2]
                    );
        }

        // Retrieve part of a "|" separated key:value list
        if (isset($fieldConfig['pipePart'])) {
            // TODO: Create util/service for retrieval of "|" separated
            // key:value fields. Also required in Vendor domain model.
            $prefix = $fieldConfig['pipePart'] . ':';
            $parts = explode('|', $result);
            $result = '';
            foreach ($parts as $part) {
                if (strpos($part, $prefix) === 0) {
                    $result = substr($part, strlen($prefix));
                    break;
                }
            }
        }

        // Give back result
        return $result;
    }

}

