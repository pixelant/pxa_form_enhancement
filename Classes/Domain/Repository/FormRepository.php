<?php
/**
 * Created by PhpStorm.
 * User: anjey
 * Date: 13.06.16
 * Time: 15:24
 */

namespace Pixelant\PxaFormEnhancement\Domain\Repository;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Andriy Oprysko <andriy@pixelant.se>, Pixelant
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Class FormRepository
 * @package Pixelant\PxaFormEnhancement\Domain\FormRepository
 */
class FormRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

    /**
     * count records
     *
     * @param int $pid
     * @return int
     */
    public function countByPid($pid) {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);
        $query->getQuerySettings()->setRespectSysLanguage(FALSE);

        return $query
            ->matching(
                $query->equals('pid', $pid)
            )
            ->execute()
            ->count();
    }
}