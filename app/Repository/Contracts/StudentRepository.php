<?php
/**
 * Created by PhpStorm.
 * User: usr0
 * Date: 9/23/19
 * Time: 1:47 AM
 */

namespace App\Repository\Contracts;

/**
 * Interface AccountRepository
 */
interface StudentRepository
{
    public function getItem($id);
    public function create($attrs);
    public function update($id, $attrs);
    public function getItemByAttr($attr, $val);
}
