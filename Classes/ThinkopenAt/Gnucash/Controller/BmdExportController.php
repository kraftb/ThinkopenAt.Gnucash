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

class BmdExportController extends AbstractBmdExportController {

	/**
	 * @Flow\Inject
	 * @var \ThinkopenAt\Gnucash\Domain\Repository\TransactionRepository
	 */
	protected $transactionRepository = NULL;

	const bmdSplitAccount = '99900';

    /**
     * Export configuration for the various export type.
	 * Configures special aspects of each export type
     *
     * @var array
     */
    protected $exportConfiguration = [
        'category-70400' => [
		],
        'category-28950' => [
			'combineSplits' => true,
		],
        'category-35300' => [
			'combineSplits' => true,
		],
        'transfer-3-2' => [
			'combineSplits' => true,
			'excludeAccounts' => [
				'961cb1d6cb4763065f804de702757c43',
			],
		],
		'category-5' => [
			'skipSplits' => [
				'Bezugsspesen' => [
                	'matching' => [
						'gkonto' => [
							'field' => 'account.code',
							'pipePart' => 'BMD',
						],
						'54400' => '54400',
					]
				]
			]
		],
		'category-6' => [
			'combineSplits' => true,
		],
		'category-7' => [
			'vatSplits' => [
				'RETURN-20' => [
					'overlay' => [
						'prozent' => '20',
						'steuercode' => '2',
						'betrag' => [
							'sum' => [
								[
									'field' => 'quantity',
									'numberFormat' => array(2, '.', ''),
								],
								[
									'field' => 'vatSplit.quantity',
									'numberFormat' => array(2, '.', ''),
								],
							],
                    		'factor' => -1,
							'numberFormat' => array(2, ',', ''),
						],
						'steuer' => [
							'field' => 'vatSplit.quantity',
							'numberFormat' => array(2, ',', ''),
						],
					],
				],
				'RETURN-10' => [
					'overlay' => [
						'prozent' => '10',
						'steuercode' => '2',
						'betrag' => [
							'sum' => [
								[
									'field' => 'quantity',
									'numberFormat' => array(2, '.', ''),
								],
								[
									'field' => 'vatSplit.quantity',
									'numberFormat' => array(2, '.', ''),
								],
							],
                    		'factor' => -1,
							'numberFormat' => array(2, ',', ''),
						],
						'steuer' => [
							'field' => 'vatSplit.quantity',
							'numberFormat' => array(2, ',', ''),
						],
					],
				],
				'RETURN-EU' => [
					'otherSplit' => 'EU',
					'overlay' => [
						'prozent' => '20',
						'steuercode' => '19',
						'steuer' => [
							'field' => 'vatSplit.quantity',
                    		'factor' => -1,
							'numberFormat' => array(2, ',', ''),
						],
					],
				]
			],
			'combineSplits' => true,
		],
		'category-8' => [
			'combineSplits' => true,
		],
	];
	
    /**
     * Export mapping for the various export type.
     * This is somehow a BMD/Gnucash field mapping.
     *
     * TODO: Eventually move this to a yaml configuration file?
	 * // 'buchcode' => '1', ... Sollbuchung
	 * // 'buchcode' => '2', ... Habenbuchung
     *
     * @var array
     */
    protected $exportMapping = [
        'category-70400' => [
                'satzart' => 0,
                'konto' => [
                    'field' => 'account.code',
                    'pipePart' => 'BMD',
                ],
                'gkonto' => self::bmdSplitAccount;
                'belegnr' => [
                    'field' => 'transaction.number',
				]
                'belegdatum' => [
                    'field' => 'transaction.postDate',
                ],
                'buchsymbol' => [
                    'field' => 'otherSplit.account.code',
                    'pipePart' => 'BMD',
					'switch' => [
						'28000' => 'BK',
						'28951' => 'BK',
						'35300' => 'BK',
						'300006' => 'BK',
					],
				],
                'buchcode' => [
					'field' => 'quantity',
					'sign' => [
						'+' => '1',
						'-' => '2',
					],
				],
                'betrag' => [
                    'field' => 'quantity',
                    'factor' => -1,
                    'numberFormat' => array(2, ',', ''),
                ],
                'text' => [
                    'field' => 'transaction.description',
                    'pipePart' => 0,
                ],
		],
        'category-28950' => [
                'satzart' => 0,
                'konto' => [
                    'field' => 'otherSplit.account.code',
                    'pipePart' => 'BMD',
                ],
                'gkonto' => [
                    'field' => 'account.code',
                    'pipePart' => 'BMD',
				],
                'belegnr' => [
                    'index' => [
						'key' => [
							'concat' => [
								'prefix' => 'belegnr-',
								'key-code' => [
									'field' => 'otherSplit.account.code',
									'pipePart' => 'BMD',
									'switch' => [
										'28000' => 'BK',
										'28951' => 'BK',
										'35300' => 'BK',
										'300006' => 'BK',
									],
								]
							]
						],
						'start' => 1,
					],
                ],
                'belegdatum' => [
                    'field' => 'transaction.postDate',
                ],
                'buchsymbol' => [
                    'field' => 'otherSplit.account.code',
                    'pipePart' => 'BMD',
					'switch' => [
						'28000' => 'BK',
						'28951' => 'BK',
						'35300' => 'BK',
						'300006' => 'BK',
					],
				],
                'buchcode' => [
					'field' => 'quantity',
					'sign' => [
						'+' => '1',
						'-' => '2',
					],
				],
                'betrag' => [
                    'field' => 'quantity',
                    'factor' => -1,
                    'numberFormat' => array(2, ',', ''),
                ],
                'text' => [
                    'field' => 'transaction.description',
                    'pipePart' => 0,
                ],
		],
        'category-35300' => [
                'satzart' => 0,
                'konto' => [
                    'field' => 'account.code',
                    'pipePart' => 'BMD',
                ],
                'gkonto' => [
                    'field' => 'otherSplit.account.code',
                    'pipePart' => 'BMD',
				],
                'belegnr' => [
/*
                    'ThinkopenAt\Gnucash\ExportHelper\Index' => [
						'key' => 'from-1',
						'start' => 1,
					]
*/
                    'index' => [
						'key' => [
							'concat' => [
								'prefix' => 'belegnr-',
								'key-code' => [
									'field' => 'otherSplit.account.code',
									'pipePart' => 'BMD',
									'switch' => [
										'28950' => 'BK',
										'85000' => 'FA',
										'66210' => 'FA',
										'66310' => 'FA',
										'35200' => 'FA',
									],
								]
							]
						],
						'start' => 1,
					],
                ],
                'belegdatum' => [
                    'field' => 'transaction.postDate',
                ],
                'buchsymbol' => [
                    'field' => 'otherSplit.account.code',
                    'pipePart' => 'BMD',
					'switch' => [
						'28950' => 'BK',
						'85000' => 'FA',
						'66210' => 'FA',
						'66310' => 'FA',
						'35200' => 'FA',
					],
				],
                'buchcode' => [
					'field' => 'quantity',
					'sign' => [
						'+' => '1',
						'-' => '2',
					],
				],
                'betrag' => [
                    'field' => 'quantity',
                    'numberFormat' => array(2, ',', ''),
                ],
                'text' => [
                    'field' => 'transaction.description',
                    'pipePart' => 0,
                ],
		],
        'transfer-3-2' => [
                'satzart' => 0,
                'konto' => [
                    'field' => 'account.code',
                    'pipePart' => 'BMD',
                ],
                'gkonto' => [
                    'field' => 'otherSplit.account.code',
                    'pipePart' => 'BMD',
				],
                'belegnr' => [
                    'field' => 'transaction.number',
                ],
                'belegdatum' => [
                    'field' => 'transaction.postDate',
                ],
                'buchsymbol' => 'BK',
                'buchcode' => [
					'field' => 'quantity',
					'sign' => [
						'+' => '1',
						'-' => '2',
					],
				],
                'betrag' => [
                    'field' => 'quantity',
                    'numberFormat' => array(2, ',', ''),
                ],
                'text' => [
                    'field' => 'transaction.description',
                    'pipePart' => 0,
                ],
                'ausz-belegnr' => [
                    'field' => 'transaction.description',
                    'pipePart' => 'RNR',
				],
                'ausz-betrag' => '',
		],
        'category-5' => [
			// gets inherited from category-7 in initializeObject. Make inheritance configurable.
		],
        'category-6' => [
                'satzart' => 0,
                'konto' => [
                    'field' => 'account.code',
                    'pipePart' => 'BMD',
                ],
                'gkonto' => [
                    'field' => 'otherSplit.account.code',
                    'pipePart' => 'BMD',
				],
                'buchdatum' => [
                    'field' => 'transaction.postDate',
                ],
                'belegdatum' => [
                    'field' => 'transaction.postDate',
                ],
                'belegnr' => [
                    'field' => 'transaction.number',
                ],
                'betrag' => [
                    'field' => 'quantity',
                    'numberFormat' => array(2, ',', ''),
                ],
                'waehrung' => 'EUR',
                'text' => [
                    'field' => 'transaction.description',
                    'pipePart' => 0,
                ],
                'buchsymbol' => 'LG',
                'buchcode' => [
					'field' => 'quantity',
					'sign' => [
						'+' => '1',
						'-' => '2',
					],
				],
                'periode' => [
                    'field' => 'transaction.description',
                    'pipePart' => 'Period',
					'customProcessing' => 'findMonthFromYearAndMonth'
                ],
                'gegenbuchkz' => 'O',
                'verbuchkz' => 'A',
                'verbuchstatus' => 0,
                'steuer' => '',
                'prozent' => '',
                'steuercode' => '',
		],
        'category-7' => [
                'satzart' => 0,
                'konto' => [
                    'field' => 'otherSplit.account.code',
                    'pipePart' => 'BMD',
				],
				// We are exporting account class "7" which usually should
				// all be a "Sachkonto" as the corresponding "Personenkonten"
				// are on the other side (Verbindlichkeiten, Girokonto, Bargeld)
                'gkonto' => [
                    'field' => 'account.code',
                    'pipePart' => 'BMD',
                ],
                'belegnr' => [
                    'field' => 'transaction.number',
                ],
                'belegdatum' => [
                    'field' => 'transaction.postDate',
                ],
                'buchsymbol' => 'ER',
                'buchcode' => [
					'field' => 'quantity',
					'sign' => [
						'+' => '2',
						'-' => '1',
					],
				],
                'prozent' => '',
                'steuercode' => '',
                'betrag' => [
                    'field' => 'quantity',
                    'factor' => -1,
                    'numberFormat' => array(2, ',', ''),
                ],
                'steuer' => '',
                'text' => [
                    'field' => 'transaction.description',
                    'pipePart' => 0,
                ],
                'kost' => '', 	// TODO?
                'extbelegnr' => [
                    'field' => 'transaction.description',
                    'pipePart' => 'RNR',
				]
		],
        'category-8' => [
				// TODO: Wie kann man Zinsen (sind nur wenige Buchungen) verbuchen???
                'satzart' => 0,
                'konto' => [
                    'field' => 'account.code',
                    'pipePart' => 'BMD',
                ],
                'gkonto' => [
                    'field' => 'otherSplit.account.code',
                    'pipePart' => 'BMD',
				],
                'belegnr' => [
                    'field' => 'transaction.number',
                ],
                'belegdatum' => [
                    'field' => 'transaction.postDate',
                ],
				// TODO ???
                'buchsymbol' => 'BK',
                'buchcode' => [
					'field' => 'quantity',
					'sign' => [
						'+' => '1',
						'-' => '2',
					],
				],
                'betrag' => [
                    'field' => 'quantity',
                    'numberFormat' => array(2, ',', ''),
                ],
                'text' => [
                    'field' => 'transaction.description',
                    'pipePart' => 0,
                ],
				// TODO ???
                'ausz-belegnr' => '',
                'ausz-betrag' => '',
		],
        'incoming' => [
            'AT' => [
                'satzart' => 0,
                'konto' => [
                    'field' => 'account.code',
                    'pipePart' => 'BMD',
                ],
                'gkonto' => '50000',
                'belegnr' => [
                    'field' => 'transaction.number',
                ],
                'belegdatum' => [
                    'field' => 'transaction.postDate',
                ],
                'betrag' => [
                    'field' => 'quantity',
                    'factor' => -1.2,
                    'numberFormat' => array(2, ',', ''),
                ],
                'buchsymbol' => 'ER',
                'buchcode' => '2',
                'prozent' => '20',
                'steuercode' => '2',
            ],
        ],
        'outgoing' => [
            'AT' => [
                'satzart' => 0,
//                'konto' => '200000',
                'konto' => [
                    'field' => 'account.code',
                    'pipePart' => 'BMD',
                ],
                'gkonto' => '40000',
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
//                'konto' => '200000',
                'konto' => [
                    'field' => 'account.code',
                    'pipePart' => 'BMD',
                ],
                'gkonto' => '41130',
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
                    'factor' => -1,
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
	 * Poor mans constructor
	 *
	 * @return void
	 */
	public function initializeObject() {
		$this->exportMapping['category-5'] = array_replace_recursive($this->exportMapping['category-5'], $this->exportMapping['category-7']);
		$this->exportConfiguration['category-5'] = array_replace_recursive($this->exportConfiguration['category-5'], $this->exportConfiguration['category-7']);
	}

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
        $begin = $this->getQuarterStart($year, 1);
        $end = $this->getQuarterEnd($year, 4);

        $this->controllerContext->getResponse()->setHeader('Content-Type', 'text/csv');

        $accountsIncomeAt = $this->accountRepository->findChildrenByCode('VAT:INCOME-AT');
        $accountsIncomeEu = $this->accountRepository->findChildrenByCode('VAT:INCOME-EU');
        $accountsIncomeWw = $this->accountRepository->findChildrenByCode('VAT:INCOME-WW');

        $splitsIncomeAt = $this->splitRepository->findByPostDateRangeAndAccount($begin, $end, $accountsIncomeAt);
        $splitsIncomeEu = $this->splitRepository->findByPostDateRangeAndAccount($begin, $end, $accountsIncomeEu);
        $splitsIncomeWw = $this->splitRepository->findByPostDateRangeAndAccount($begin, $end, $accountsIncomeWw);

        $result = '';
        $result .= $this->bmdExportHead($this->exportMapping['outgoing']['AT']);
        $result .= $this->bmdExport($splitsIncomeAt, $this->exportMapping['outgoing']['AT']);
        $result .= $this->bmdExport($splitsIncomeEu, $this->exportMapping['outgoing']['EU']);
        // TODO: Weltweite Umsätze entsprechend ausgeben.
        return $result;
	}

	/**
	 * @return void
	 */
	public function incomingInvoicesAction() {
        $year = 2016;
        $begin = $this->getQuarterStart($year, 1);
        $end = $this->getQuarterEnd($year, 4);

        $this->controllerContext->getResponse()->setHeader('Content-Type', 'text/csv');

        $accountsExpenseAt = $this->accountRepository->findChildrenByCode('EXPENSES-AT');

        $splitsExpensesAt = $this->splitRepository->findByPostDateRangeAndAccount($begin, $end, $accountsExpenseAt);

        $result = '';
        $result .= $this->bmdExportHead($this->exportMapping['incoming']['AT']);
        $result .= $this->bmdExport($splitsExpensesAt, $this->exportMapping['incoming']['AT']);
        return $result;

    }

	protected function findMonthFromYearAndMonth($yearAndMonth) {
		if (preg_match('/(2[0-9]{3})\\/([0-9]{1,2})/', $yearAndMonth, $matches)) {
			return (int)$matches[2];
		}
		if (preg_match('/([0-9]{1,2})\\/(2[0-9]{3})/', $yearAndMonth, $matches)) {
			return (int)$matches[1];
		}
		return '';
	}

	/**
	 * Exports all transactions of a specific category
	 *
	 * @param string $category: The category which to export (as tagged by "BMD:" attribute)
	 * @return void
	 */
	public function exportCategoryAction($category) {
		$configKey = 'category-' . $category;
		$exportMapping = $this->exportMapping[$configKey];
		$exportConfiguration = $this->exportConfiguration[$configKey];

        $year = 2016;
        $begin = $this->getQuarterStart($year, 1);
        $end = $this->getQuarterEnd($year, 4);

		if (preg_match('/[^0-9]/', $category)) {
			throw new \Exception('Invalid characters in category!');
		}

		$this->controllerContext->getResponse()->setHeader('Content-Type', 'text/csv');
		$this->controllerContext->getResponse()->setHeader('Content-Type', 'text/plain');

		$tags = $this->accountTagRepository->findByTagLike('BMD:' . $category . '%');
        $taggedAccounts = $this->accountRepository->findByTags($tags);

        $splits = $this->splitRepository->findByPostDateRangeAndAccount($begin, $end, $taggedAccounts);

		$exportSplits = $this->processSplits($splits, $exportConfiguration, $exportMapping);

        $result = '';
        $result .= $this->bmdExportHead($exportMapping);
        $result .= $this->bmdExport($exportSplits, $exportMapping, $exportConfiguration);
        return $result;
	}

	/**
	 * Exports only transactions from one specified category to another
	 *
	 * @param string $category1: Either source or target category (as tagged by "BMD:" attribute)
	 * @param string $category2: Either source or target category (as tagged by "BMD:" attribute)
	 * @return void
	 */
	public function exportTransferAction($category1, $category2) {
		$configKey = 'transfer-' . $category1 . '-' . $category2;
		$exportMapping = $this->exportMapping[$configKey];
		$exportConfiguration = $this->exportConfiguration[$configKey];

        $year = 2016;
        $begin = $this->getQuarterStart($year, 1);
        $end = $this->getQuarterEnd($year, 4);

		if (preg_match('/[^0-9]*/', $category1)) {
			throw new \Exception('Invalid characters in category!');
		}
		if (preg_match('/[^0-9]*/', $category2)) {
			throw new \Exception('Invalid characters in category!');
		}

		$this->controllerContext->getResponse()->setHeader('Content-Type', 'text/csv');
		$this->controllerContext->getResponse()->setHeader('Content-Type', 'text/plain');

		// Get tagged accounts for both (source/target) categories.
		// Tagged means the accounts start with a BMD category code of 2 (Vermögen), 3 (Forderungen), 5 (Hilfsmittel ..), etc.
		$tags1 = $this->accountTagRepository->findByTagLike('BMD:' . $category1 . '%');
        $taggedAccounts1 = $this->accountRepository->findByTags($tags1);
		$accountKeys1 = $this->getPersistenceObjectIdentifiers($taggedAccounts1);

		$tags2 = $this->accountTagRepository->findByTagLike('BMD:' . $category2 . '%');
        $taggedAccounts2 = $this->accountRepository->findByTags($tags2);
		$accountKeys2 = $this->getPersistenceObjectIdentifiers($taggedAccounts2);

		if ($exportConfiguration['excludeAccounts']) {
			$accountKeys1 = array_diff($accountKeys1, $exportConfiguration['excludeAccounts']);
			$accountKeys2 = array_diff($accountKeys2, $exportConfiguration['excludeAccounts']);
		}

		// Get all splits in the defined date range (year) and in the found, tagged accounts
        $splits1 = $this->splitRepository->findByPostDateRangeAndAccount($begin, $end, $accountKeys1);
        $splits2 = $this->splitRepository->findByPostDateRangeAndAccount($begin, $end, $accountKeys2);

		// Get transactions for the found splits
		$transactions1 = $this->transactionRepository->findBySplits($splits1);
		$transactions2 = $this->transactionRepository->findBySplits($splits2);

		// Get PersistenceObjectIdentifiers for the found transactions
		$transactionKeys1 = $this->getPersistenceObjectIdentifiers($transactions1);
		$transactionKeys2 = $this->getPersistenceObjectIdentifiers($transactions2);

		// Make intersection of PersistenceObjectIdentifiers
		// This will give us only transactions which contain splits concerning both (source/target) categories
		$transferTransactions = array_values(array_intersect($transactionKeys1, $transactionKeys2));

		$splits = $this->splitRepository->findByAccountAndTransaction($taggedAccounts1, $transferTransactions);
		$exportSplits = $this->processSplits($splits, $exportConfiguration, $exportMapping);

        $result = '';
        $result .= $this->bmdExportHead($exportMapping);
        $result .= $this->bmdExport($exportSplits, $exportMapping, $exportConfiguration);
        return $result;
	}

	/**
	 * Processes splits for proper exporting (adding VAT split, adding other side split, etc.)
	 *
	 * @param \TYPO3\Flow\Persistence\QueryResultInterface $objects: Objects from which to get PersistenceObjectIdentifiers
	 * @return array Only the PersistenceObjectIdentifiers of the given objects.
	 */
	protected function getPersistenceObjectIdentifiers($objects) {
		$result = [];
		foreach ($objects as $object) {
			$identifier = $object->getPersistenceObjectIdentifier();
			$result[] = $identifier;
		}
		return $result;
	}

	/**
	 * Processes splits for proper exporting (adding VAT split, adding other side split, etc.)
	 *
	 * @param \TYPO3\Flow\Persistence\QueryResultInterface $splits: The splits which to process
     * @param array $exportConfiguration: The export configuration
     * @param array $exportMapping: The export mapping
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The splits prepared for export
	 */
	protected function processSplits($splits, array $exportConfiguration, array $exportMapping) {
		if (!empty($exportConfiguration['vatSplits'])) {
			$this->addVatSplit($splits, $exportConfiguration['vatSplits']);
		}

		if (!empty($exportConfiguration['combineSplits'])) {
			$this->addOtherSplit($splits);
			$exportSplits = $splits;
		} else {
			if (empty($exportConfiguration['autoSplitForBmd']) && $exportMapping['konto'] !== self::bmdSplitAccount && $exportMapping['gkonto'] !== self::bmdSplitAccount) {
				throw new \Exception('You are not combining splits but neither "konto" nor "gkonto" are the BMD "Technisches Gegenkonto".');
			}
			if (!empty($exportConfiguration['autoSplitForBmd'])) {
				throw new \Exception('TODO!');
			}
        	$transactions = $this->transactionRepository->findBySplits($splits);
			$exportSplits = $this->splitRepository->findByTransaction($transactions);
		}
		return $exportSplits;
	}


	/**
	 * Finds the "other" account/split for each split and assigns it to the transient variable "otherSplit"
	 * If any of the splits is part of a more-than-2-splits transaction an exception will get thrown.
	 * 
	 * @param \TYPO3\Flow\Persistence\QueryResultInterface $splits: The splits for which to set the "otherSplit"
	 * @return void
	 */
	protected function addOtherSplit(\TYPO3\Flow\Persistence\QueryResultInterface $splits) {
		foreach ($splits as $split) {
			$transaction = $split->getTransaction();
			$transactionSplits = $transaction->getSplits();
			$vatSplit = $split->getVatSplit();
			if ($vatSplit !== NULL) {
				if (count($transactionSplits) !== 3 && count($transactionSplits) !== 4) {
//					\TYPO3\Flow\var_dump($transactionSplits, '', false, null, 4);
					throw new \Exception('Transactions with a VAT split must have 3 or 4 splits!');
				}
			} else {
				if (($count = count($transactionSplits)) !== 2) {
					\TYPO3\Flow\var_dump($split, '', false, null, 6);
					\TYPO3\Flow\var_dump($transactionSplits, '', false, null, 6);
					throw new \Exception('Transaction without VAT split must have exactly 2 splits but has ' . $count . ' splits!');
				}
			}
			foreach ($transactionSplits as $transactionSplit) {
				if ($split === $transactionSplit) {
					continue;
				}
				if ($vatSplit === $transactionSplit) {
					continue;
				}
				if ($vatSplit && $vatSplit->getOtherSplit() === $transactionSplit) {
					continue;
				}
				$split->setOtherSplit($transactionSplit);
			}
		}
	}

	/**
	 * Finds the VAT split (by account code) for each passed split and assigns it to the transient
	 * variable "vatSplit".
	 *
	 * The situation in GnuCash is somewhat unorganized. When not using incoming bills as defined
	 * by GnuCash the VAT splits of a transaction are not specially marked and so the BMD/Gnucash
	 * export filter can not determine which parts and how much of a transaction is VAT. But this
	 * is mandatory for BMD. So the splits regarding VAT have to get separated from the other
	 * splits of a transaction.
	 * 
	 * @param \TYPO3\Flow\Persistence\QueryResultInterface $splits: The splits for which to set the "vatSplit"
	 * @param array $vatSplitConfiguration: The VAT split configuration
	 * @return void
	 */
	protected function addVatSplit(\TYPO3\Flow\Persistence\QueryResultInterface $splits, $vatSplitConfiguration) {
		foreach ($splits as $split) {
			$transaction = $split->getTransaction();
			$transactionSplits = $transaction->getSplits();

			$vatSplits = $this->filterVatSplits($transactionSplits, $vatSplitConfiguration);
			$vatSplit = $this->validateAndOrganizeVatSplits($vatSplits, $vatSplitConfiguration);

			if ($vatSplit) {
				$split->setVatSplit($vatSplit);
			}
		}
	}

	/**
	 * Returns only those splits which are assigned to a VAT associated account
	 *
	 * @param \Doctrine\ORM\PersistentCollection $splits: The splits which to filter
	 * @param array $vatSplitConfiguration: The VAT split configuration
	 * @return array Only VAT associated splits
	 */
	protected function filterVatSplits(\Doctrine\ORM\PersistentCollection $splits, array $vatSplitConfiguration) {
		$result = array();
		$vatKeys = array();
		foreach ($vatSplitConfiguration as $key => $config) {
			$vatKeys[] = $key;
			if (isset($config['otherSplit'])) {
				$vatKeys[] = $config['otherSplit'];
			}
		}
		foreach ($splits as $split) {
				$vatCode = $this->getCodePartFromSplit($split, 'VAT');
				if (!empty($vatCode) && in_array($vatCode, $vatKeys)) {
					$result[] = $split;
				}
		}
		return $result;
	}

	/**
	 * Validates the given VAT splits and organizes them into a single VAT split
	 *
	 * @param array $splits: The VAT splits
	 * @param array $vatSplitConfiguration: The VAT split configuration
	 * @return \ThinkopenAt\Gnucash\Domain\Model\Split: The VAT split
	 */
	protected function validateAndOrganizeVatSplits(array $splits, array $vatSplitConfiguration) {
		$num = count($splits);
		if ($num > 2) {
			throw new \Exception('There must not be more than 2 VAT splits!');
		}

		if ($num === 0) {
			// There is no VAT split
			return null;
		}

		if ($num === 1) {
			// Only a single VAT split.
			// Check if this is fine or if there should be a "other" side.
			$vatSplit = array_shift($splits);
			$code = $this->getCodePartFromSplit($vatSplit, 'VAT');
			if (empty($vatSplitConfiguration[$code])) {
				throw new \Exception('Invalid single VAT split!');
			}
			$splitConfig = $vatSplitConfiguration[$code];
			if (isset($splitConfig['otherSplit'])) {
				throw new \Exception('Configuration says there should be another VAT split!');
			}
		} elseif ($num === 2) {
			// Two VAT splits. Looks like a reverse charge purchase.

			// Get VAT account code of both splits
			$vatSplit1 = array_shift($splits);
			$vatSplit2 = array_shift($splits);
			$code1 = $this->getCodePartFromSplit($vatSplit1, 'VAT');
			$code2 = $this->getCodePartFromSplit($vatSplit2, 'VAT');

			// Take care that at least one but not both codes
			// are defined in the VAT split configuration.
			if (empty($vatSplitConfiguration[$code1]) && empty($vatSplitConfiguration[$code2])) {
				throw new \Exception('Invalid dual (reverse-charge) VAT split!');
			}
			if (isset($vatSplitConfiguration[$code1]) && isset($vatSplitConfiguration[$code2])) {
				throw new \Exception('Invalid dual (reverse-charge) VAT split!');
			}

			// Determine which one is the vatSplit and the otherVatSplit
			if (isset($vatSplitConfiguration[$code1])) {
				$vatSplit = $vatSplit1;
				$vatCode = $code1;
				$otherVatSplit = $vatSplit2;
				$otherVatCode = $code2;
			} else {
				$vatSplit = $vatSplit2;
				$vatCode = $code2;
				$otherVatSplit = $vatSplit1;
				$otherVatCode = $code1;
			}

			// Check there is configuration for other-side VAT split
			// and the VAT code of the other-side VAT split matches
			// the configured account VAT code part.
			$splitConfig = $vatSplitConfiguration[$vatCode];
			if (!$splitConfig['otherSplit']) {
				throw new \Exception('No other side of VAT configured altough there are 2 VAT splits!');
			}
			if ($splitConfig['otherSplit'] !== $otherVatCode) {
				throw new \Exception('Other-side-VAT-code/confguration mismatch!');
			}

			// Everything fine. Set the "other" side of
			// a double-sided-single-transaction VAT split.
			$vatSplit->setOtherSplit($otherVatSplit);

			// @question: Maybe all reverse-charge VAT bookings should be made
			// like normal VAT bookings and only get cleared by a counter-transaction
			// by the quarterly (montly) VAT pre declaration (Umsatzsteuervoranmeldung)
			// Then there would only be single-sided VATs - and no(?) transactions with
			// four splits in the category-7 accounts.
		}
		return $vatSplit;
	}

}

