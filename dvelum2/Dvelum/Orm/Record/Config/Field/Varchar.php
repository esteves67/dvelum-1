<?php
/**
 *  DVelum project http://code.google.com/p/dvelum/ , https://github.com/k-samuel/dvelum , http://dvelum.net
 *  Copyright (C) 2011-2017  Kirill Yegorov
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */
declare(strict_types=1);

namespace Dvelum\Orm\Record\Config\Field;
use Dvelum\Orm\Record\Config\Field;

class Varchar extends \Dvelum\Orm\Record\Config\Field
{
    /**
     * Apply value filter
     * @param mixed $value
     * @return mixed
     */
    public function filter($value)
    {
        if(is_null($value) && $this->isNull()){
            return null;
        }

        if(!isset($this->config['allow_html']) || !$this->config['allow_html']){
            $value = \Filter::filterValue('string' , $value);
        }

        return $value;
    }

    /**
     * Validate value
     * @param $value
     * @return bool
     */
    public function validate($value) : bool
    {
        if(!parent::validate($value)){
            return false;
        }

        if(mb_strlen((string)$value ,'UTF-8') > $this->config['db_len']){
            $this->validationError = 'The field value exceeds the allowable length.';
            return false;
        }

        return true;
    }

}

