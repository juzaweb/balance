<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Balance\Events;

use Juzaweb\Balance\Models\WithdrawRequest;

class WithdrawRequestSuccess
{
    public function __construct(protected WithdrawRequest $withdrawRequest)
    {
    }
}
