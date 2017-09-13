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
	 * Instance of the "misc" utility
	 *
	 * @Flow\Inject
	 * @var \ThinkopenAt\Gnucash\Utility\Misc
	 */
	protected $misc = NULL;

	/**
	 * Instance of the "accountTag" repository
	 *
	 * @Flow\Inject
	 * @var \ThinkopenAt\Gnucash\Domain\Repository\AccountTagRepository
	 */
	protected $accountTagRepository = NULL;

    /**
     * An array of variables being used during export
     *
     * @var array
     */
    protected $exportVariables = [];

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
     * @param array $mapping: The mapping for the export
     * @return string The CSV export head line
     */
    protected function bmdExportHead(array $mapping) {
        $fd = fopen('php://temp', 'w+b');
        fputcsv($fd, array_keys($mapping), $this->csv['delimiter'], $this->csv['enclosure'], $this->csv['escape']);
        return $this->getFileContent($fd);
    }

    /**
     * Export the passed splits/transaction according to the given mapping and configuration
     *
     * @param \TYPO3\Flow\Persistence\Doctrine\QueryResult $splits: The transaction splits which should get exported
     * @param array $mapping: The export mapping
     * @param array $config: The export configuration
     * @return string The exported splits as CSV lines
     */
    protected function bmdExport(\TYPO3\Flow\Persistence\Doctrine\QueryResult $splits, array $mapping, array $config = null) {
        $fd = fopen('php://temp', 'w+b');
        foreach ($splits as $split) {
/*
			echo "<br />\n";
			echo $split->getTransaction()->getPostDate()->format('Y-m-d');;
			echo "<br />\n";
			echo $split->getTransaction()->getDescription();
			echo "<br />\n";
*/

			$currentMapping = $this->processExportMapping($split, $mapping, $config);

			// Check whether to skip split
			if (isset($config['skipSplits']) && is_array($config['skipSplits'])) {
				$skip = false;
				foreach ($config['skipSplits'] as $key => $skipConfig) {
					$skip |= $this->evaluateIfConfig($split, $skipConfig);
				}
				if ($skip) {
					continue;
				}
			}

            $data = array();
            foreach ($currentMapping as $field => $fieldMapping) {
                try {
					$data[$field] = $this->exportField($split, $fieldMapping, $field);
				} catch (\Exception $e) {
					throw $e;
				}
            }
            fputcsv($fd, $data, $this->csv['delimiter'], $this->csv['enclosure'], $this->csv['escape']);
        }
        return $this->getFileContent($fd);
    }

	/**
	 * Evaluate "if" conditions regarding a split
	 *
     * @param \ThinkopenAt\Gnucash\DomainModelSplit $split: The split which to inspect
     * @param array $evalConfig: The evaluation
	 * @param
	 */
	protected function evaluateIfConfig($split, $evalConfig) {
		$result = true;
		foreach ($evalConfig as $type => $params) {
			switch ($type) {
				case 'matching':
					reset($params);
					$matchFieldName = key($params);
					$matchConfig = current($params);
    				$compare = $this->exportField($split, $matchConfig, $matchFieldName);
					while (next($params) !== false) {
						$matchFieldName = key($params);
						$matchConfig = current($params);
    					$compareTo = $this->exportField($split, $matchConfig, $matchFieldName);
						if ($compare != $compareTo) {
							$result = false;
							break;
						}
					}
				break;

				default:
					throw new \Exception('Invalid split evaluation type');
				break;
			}
		}
		return $result;
	}

    /**
     * Processes the mapping on a per split/item basis.
	 * This allows to alter the mapping depending on configuration/criteria upon
	 * the currently exported split. This is used for example to have different
	 * mapping "overlays" for the different kind of VAT settings.
     *
     * @param \ThinkopenAt\Gnucash\DomainModelSplit $split: The split by which to modify the configuration
     * @param array $mapping: The export mapping for the current type of export
     * @param array $config: The export configuration for the current type of export
     * @return array The modified export mapping for this split.
     */
	protected function processExportMapping(\ThinkopenAt\Gnucash\Domain\Model\Split $split, array $mapping, array $config = null) {
		$vatSplit = $split->getVatSplit();
		if ($vatSplit) {
			$code = $this->getCodePartFromSplit($vatSplit, 'VAT');
			if (isset($config['vatSplits'][$code]['overlay'])) {
				$overlayMapping = $config['vatSplits'][$code]['overlay'];
				$mapping = array_replace_recursive($mapping, $overlayMapping);
			}
		}
		return $mapping;
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
	 * Note: The stdWrap of BmdExport.
     *
     * @param \ThinkopenAt\Gnucash\Domain\Model\Split $split: The split from which to export a field
     * @param array|string $fieldMapping: Either a plain value (string) or an export mapping command array
     * @param string $fieldName: The name of the field to export
     * @param string $result: The current result for recursive calling
     * @return string The generated export value
     */
    protected function exportField(\ThinkopenAt\Gnucash\Domain\Model\Split $split, $fieldMapping, $fieldName, $result = '') {
        // Guard clause
        if (!is_array($fieldMapping)) {
            // Plain static value
            return $fieldMapping;
        }

        // TODO: Split up field handlers to separate class files.
		// This will become something like a ViewHelper. Could get named "ExportHelper"

        // Get value from field/property of split
        if (isset($fieldMapping['field'])) {
            $parts = explode('.', $fieldMapping['field']);
            $value = $split;
            foreach ($parts as $part) {
                $getter = 'get' . ucfirst($part);
                $value = $value->$getter();
            }
            if ($value instanceof \DateTime) {
                $result = $value->format(isset($fieldMapping['dateFormat']) ? $fieldMapping['dateFormat'] : 'd.m.Y');
            } else {
                $result = (string)$value;
            }
        }

        if (isset($fieldMapping['index'])) {
			if (is_array($fieldMapping['index'])) {
				$key = $fieldMapping['index']['key'];
			} else {
				$key = $fieldMapping['index'];
			}
			if (is_array($key)) {
				$key = $this->exportField($split, $key, $fieldName . '|index-key');
			}

			$key = 'index-' . $key;
			if (!isset($this->exportVariables[$key])) {
				$this->exportVariables[$key] = 0;
				if (is_array($fieldMapping['index']) && isset($fieldMapping['index']['start'])) {
					$this->exportVariables[$key] = (int)$fieldMapping['index']['start'];
				}
			}
			$result = $this->exportVariables[$key]++;
		}

        if (isset($fieldMapping['concat']) && is_array($fieldMapping['concat'])) {
			$str = '';
			foreach ($fieldMapping['concat'] as $concatKey => $concatConfig) {
				$item = $this->exportField($split, $concatConfig, $fieldName . '|concat:' . $concatKey);
				$str .= $item;
			}
			$result = $str;
		}

        if (isset($fieldMapping['sum']) && is_array($fieldMapping['sum'])) {
			$sum = 0;
			foreach ($fieldMapping['sum'] as $index => $subMapping) {
				$value = $this->exportField($split, $subMapping, $fieldName . '|sum:' . $index);
				$sum += $value;
			}
			$result = $sum;
		}

        // Apply a multiplicative factor
        if (isset($fieldMapping['factor'])) {
            if (!is_numeric($result)) {
                throw new \Exception('Field "' . $fieldName . '": Value "' . $result . '" is not numeric!');
            }
            $result =  $result * $fieldMapping['factor'];
        }

        // Format number according to a given format
        if (isset($fieldMapping['numberFormat'])) {
            $result = number_format(
				$result,
				$fieldMapping['numberFormat'][0],
				$fieldMapping['numberFormat'][1],
				$fieldMapping['numberFormat'][2]
			);
        }

        // Retrieve part of a "|" separated key:value list
        if (isset($fieldMapping['pipePart'])) {
            // TODO: Create util/service for retrieval of "|" separated
            // key:value fields. Also required in Vendor domain model.
			$result = $this->misc->getPipePart($fieldMapping['pipePart'], $result);
/*
            $prefix = $fieldMapping['pipePart'] . ':';
            $parts = explode('|', $result);
            $result = '';
            foreach ($parts as $part) {
                if (strpos($part, $prefix) === 0) {
                    $result = substr($part, strlen($prefix));
                    break;
                }
            }
*/
        }

        if (isset($fieldMapping['switch'])) {
			if (isset($fieldMapping['switch'][$result])) {
				$result = $fieldMapping['switch'][$result];
			} elseif (isset($fieldMapping['switch']['__default'])) {
				$result = $fieldMapping['switch']['__default'];
			} else {
				throw new \Exception('Invalid value "' . $result . '" for "switch" instruction!');
			}
		}

        if (isset($fieldMapping['sign'])) {
			if ($result >= 0) {
				$result = $fieldMapping['sign']['+'];
			} else {
				$result = $fieldMapping['sign']['-'];
			}
		}

        if (isset($fieldMapping['customProcessing'])) {
			$method = $fieldMapping['customProcessing'];
			$result = $this->$method($result);
		}

        if (isset($fieldMapping['exportField'])) {
			// Call recursive
			$result = $this->exportField($split, $fieldMapping['exportField'], $fieldName . '|exportField', $result);
		}

        // Give back result
        return $result;
    }

	/**
	 * Retrieves the code value specified by the given key from the account of the given split.
	 *
	 * @param \ThinkopenAt\Gnucash\Domain\Model\Split $split: The split from which to retrieve a code part
	 * @param string $key: The code value which to retrieve
	 * @return string The requested code part - if available
	 */
	protected function getCodePartFromSplit($split, $key) {
		$account = $split->getAccount();
		$code = $account->getCode();
		$codePart = $this->misc->getPipePart($key, $code);
		return $codePart;
	}

}

