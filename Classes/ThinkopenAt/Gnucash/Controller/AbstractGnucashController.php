<?php
namespace ThinkopenAt\Gnucash\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.TimeFlies". *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;

class AbstractGnucashController extends ActionController {

	/**
	 * @Flow\Inject
	 * @var \ThinkopenAt\Gnucash\Domain\Repository\AccountRepository
	 */
	protected $accountRepository;

	/**
	 * @Flow\Inject
	 * @var \ThinkopenAt\Gnucash\Domain\Repository\SplitRepository
	 */
	protected $splitRepository = NULL;


	/**
	 * Setter for injected settings.
	 *
	 * @param array $settings
	 * @return void
	 */
	public function setSettings(array $settings) {
		$this->settings = $settings;
	}

    /**
     * Determine the DateTime for the start of a quarter
     *
     * @param integer $year: The year for which to determine the quarter start
     * @param integer $quarter: The quarter (1-4) for which to determine the start
     * @return \DateTime The quarter start
     */
    protected function getQuarterStart($year, $quarter) {
        $month = (($quarter - 1) * 3) + 1;
        return new \TYPO3\Flow\Utility\Now($year.'-'.$month.'-1 0:00');
    }

    /**
     * Determine the DateTime for the end of a quarter
     *
     * @param integer $year: The year for which to determine the quarter end
     * @param integer $quarter: The quarter (1-4) for which to determine the end
     * @return \DateTime The quarter end
     */
    protected function getQuarterEnd($year, $quarter) {
        $month = ($quarter * 3) + 1;
        if ($month > 12) {
            $month -= 12;
            $year += 1;
        }
        return new \TYPO3\Flow\Utility\Now($year.'-'.$month.'-1 0:00');
    }

}

