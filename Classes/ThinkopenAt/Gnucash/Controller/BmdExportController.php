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

class BmdExportController extends AbstractGnucashController {

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
     * Export configuration for the various export type.
     * This is somehow a BMD/Gnucash field mapping.
     *
     * @var array
     */
    protected $exportConfig = [
        'outgoing' => [
            'AT' => [
                'satzart' => 0,
                'konto' => '200000',
                'gkonto' => '4000',
                'belegdatum' => [
                    'field' => 'transaction.postDate',
                ],
                'belegnr' => [
                    'field' => 'transaction.number',
                ],
                'buchsymbol' => 'AR',
                'buchcode' => '1',
                'steuercode' => '1',
                'prozent' => '20',
                'betrag' => [
                    'field' => 'quantity',
                    'factor' => -1.2,
                    'numberFormat' => array(2, ',', ''),
                ],
                'steuer' => [
                    'field' => 'quantity',
                    'factor' => 0.2,
                    'numberFormat' => array(2, ',', ''),
                ],
                'text' => [
                    'field' => 'transaction.description',
                ],
            ],
            'EU' => [
                'satzart' => 0,
                'konto' => '200000',
                'gkonto' => '4113',
                'belegdatum' => [
                    'field' => 'transaction.postDate',
                ],
                'belegnr' => [
                    'field' => 'transaction.number',
                ],
                'buchsymbol' => 'AR',
                'buchcode' => '1',
                'steuercode' => '77',
                'prozent' => '0',
                'betrag' => [
                    'field' => 'quantity',
                    'numberFormat' => array(2, ',', ''),
                ],
                'steuer' => '0',
                'text' => [
                    'field' => 'transaction.description',
                ],
            ],
        ]
    ];


	/**
	 * @return void
	 */
	public function indexAction() {
	}

	/**
	 * @return void
	 */
	public function outgoingInvoicesAction() {
        $year = 2016;

        $this->controllerContext->getResponse()->setHeader('Content-Type', 'text/csv');
        $accountsIncomeAt = $this->accountRepository->findChildrenByCode('VAT-INCOME-AT');
        $accountsIncomeEu = $this->accountRepository->findChildrenByCode('VAT-INCOME-EU');
        $accountsIncomeWw = $this->accountRepository->findChildrenByCode('VAT-INCOME-WW');

        $begin = $this->getQuarterStart($year, 1);
        $end = $this->getQuarterEnd($year, 4);

        $splitsIncomeAt = $this->splitRepository->findByPostDateRangeAndAccount($begin, $end, $accountsIncomeAt);
        $splitsIncomeEu = $this->splitRepository->findByPostDateRangeAndAccount($begin, $end, $accountsIncomeEu);
        $splitsIncomeWw = $this->splitRepository->findByPostDateRangeAndAccount($begin, $end, $accountsIncomeWw);

        $result = '';
        $result .= $this->bmdExportHead($this->exportConfig['outgoing']['AT']);
        $result .= $this->bmdExport($splitsIncomeAt, $this->exportConfig['outgoing']['AT']);
        $result .= $this->bmdExport($splitsIncomeEu, $this->exportConfig['outgoing']['EU']);
        // TODO: Weltweite Umsätze entsprechend ausgeben.
        return $result;
	}

    protected function bmdExportHead($config) {
        $fd = fopen('php://temp', 'w+b');
        fputcsv($fd, array_keys($config), $this->csv['delimiter'], $this->csv['enclosure'], $this->csv['escape']);
        return $this->getFileContent($fd);
    }

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

    protected function getFileContent($fd) {
        // Read-out and return generated CSV lines.
        rewind($fd);
        $result = stream_get_contents($fd);
        fclose($fd);
        return $result;
    }

    protected function exportField($split, $fieldConfig, $fieldName) {
        $result = '';
        if (is_array($fieldConfig)) {
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

            if (isset($fieldConfig['factor'])) {
                if (!is_numeric($result)) {
                    throw new \Exception('Field "' . $fieldName . '": Value "' . $result . '" is not numeric!');
                }
                $result =  $result * $fieldConfig['factor'];
            }
            if (isset($fieldConfig['numberFormat'])) {
                $result = number_format(
                    $result,
                    $fieldConfig['numberFormat'][0],
                    $fieldConfig['numberFormat'][1],
                    $fieldConfig['numberFormat'][2]
                );
            }
        } else {
            $result = $fieldConfig;
        }

        return $result;
    }

}

