<?php

 /**
  *  YunoHost - Self-hosting for all
  *  Copyright (C) 2012  Kload <kload@kload.fr>
  *
  *  This program is free software: you can redistribute it and/or modify
  *  it under the terms of the GNU Affero General Public License as
  *  published by the Free Software Foundation, either version 3 of the
  *  License, or (at your option) any later version.
  *
  *  This program is distributed in the hope that it will be useful,
  *  but WITHOUT ANY WARRANTY; without even the implied warranty of
  *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  *  GNU Affero General Public License for more details.
  *
  *  You should have received a copy of the GNU Affero General Public License
  *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
  */

class YunoHostLdap extends LdapEntry
{
	public function __construct($server, $domain, $modelPath)
	{
		parent::__construct($server, $domain, $modelPath);
	}

	public function connectAs($uid, $password)
	{
		$this->searchPath = array('ou' => 'users');
		$this->attributesToFetch = array('uid');
		$result = $this->findOneBy(array('uid' => $uid));
		$userDnArray = array('uid' => $result['uid'], 'ou' => 'users');
	    return $this->connect($userDnArray, $password);
	}

	protected function ldapError() {
		$error = 'Error: ('. ldap_errno($this->connection) .') '. ldap_error($this->connection);
		flash('error', $error);
	}
}
