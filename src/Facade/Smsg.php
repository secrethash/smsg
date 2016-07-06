<?php
 /*
 * This file is part of Secrethash-Smsg
 *
 * (c) 2013 Shashwat Mishra
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 *
 * @category    Shashwat Mishra
 * @package     Smsg
 * @copyright   (c) 2013 Shashwat Mishra <shashwat@secrethash.io>
 * @link        http://secrethash.io
 */

namespace Secrethash\Smsg\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * SmsgFacade
 *
 * @author Shashwat Mishra <shashwat@secrethash.io>
 */ 
class Smsg extends Facade {
 
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'smsg'; }
 
}