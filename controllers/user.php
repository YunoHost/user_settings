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


/**
 * GET /
 */
function updateUserForm () {
  global $ldap;
  $domains = $ldap->findAll('(objectClass=mailDomain)');
  $uid = $_SERVER['PHP_AUTH_USER'];
  $ldap->setSearchPath(array('ou' => 'users'));
  $ldap->setAttributesToFetch(array('uid', 'cn', 'givenname', 'sn', 'mail'));
  $user = $ldap->findOneBy(array('uid' => $uid));
  set('domains', $domains);
  set('uid', $uid);
  set('user', $user);
  set('title', T_('Update').' '.$uid);
  return render("updateUserForm.html.php");
}


/**
 * PUT /user
 */
function updateUser ($uid = null) {
  global $ldap;
  $uid = $_SERVER['PHP_AUTH_USER'];
  $firstname = htmlspecialchars($_POST["firstname"]);
  $lastname = htmlspecialchars($_POST["lastname"]);
  $mail = htmlspecialchars($_POST["mail"]);
  $becomeAdmin = isset($_POST["isadmin"]);

  $ldap->populateUser(array('uid' => $uid));

  $wasAdmin = ('admin' === $ldap->user->description);

  $ldap->setUserGivenname($firstname);
  $ldap->setUserSn($lastname);
  $ldap->setUserMail($mail);
  $ldap->setUserCn($firstname.' '.$lastname);

  if ($wasAdmin && !$becomeAdmin) {
    $ldap->setUserDescription('NO MORE admin');
    $ldap->revokeAdmin($username);
  }

  if (!$wasAdmin && $becomeAdmin) {
    $ldap->setUserDescription('admin');
    $ldap->grantAdmin($username);
  }

  if ($ldap->saveUser())
    flash('success', T_('User successfully updated.'));
  else
    flash('error', T_('An error occured on user update.'));

  redirect_to('/user/list');
}

/**
 * GET /user/mailaliases/:user
 */
function updateMailAliasesUserForm ($uid = null) {
  global $ldap;

  if (isset($uid)) {
    $uid = htmlspecialchars($uid);
    $ldap->setSearchPath(array('ou' => 'users'));
    $ldap->setAttributesToFetch(array('uid', 'mail', 'mailalias'));
    $user = $ldap->findOneBy(array('uid' => $uid));
    if (!isset($user['mailalias'])) $user['mailalias'] = array();
    if (!is_array($user['mailalias'])) $user['mailalias'] = array($user['mailalias']);
    set('uid', $uid);
    set('user', $user);
    set('title', T_('Mail aliases of').' '.$uid);
    return render("mailAliasesUserForm.html.php");
  } else {
    redirect_to('/user/list');
  }
}


/**
 * PUT /user/mailaliases/:user
 */
function updateMailAliasesUser ($uid = null) {
  global $ldap;

  foreach ($_POST["mailalias"] as $mailalias) {
    if (!empty($mailalias))
      $mailaliases[] = htmlspecialchars($mailalias);
  }

  $ldap->populateUser(array('uid' => $uid));
  $ldap->setUserMailalias($mailaliases);

  if ($ldap->saveUser())
    flash('success', T_('Mail aliases updated.'));
  else
    flash('error', T_('An error occured on aliases update.'));

  redirect_to('/user/update/'.$uid);

}


/**
 * GET /user/password/:user
 */
function updatePasswordUserForm ($uid = null) {
  if (isset($uid)) {
    $uid = htmlspecialchars($uid);
    set('uid', $uid);
    set('title', T_('Change password of').' '.$uid);
    return render("passwordUserForm.html.php");
  } else {
    redirect_to('/user/list');
  }
}


/**
 * PUT /user/password/:user
 */
function updatePasswordUser ($uid = null) {
  global $ldap;

  $actualPassword = '{MD5}'.base64_encode(pack('H*',md5($_POST["actualPassword"])));
  $newPassword = '{MD5}'.base64_encode(pack('H*',md5($_POST["newPassword"])));

  $ldap->populateUser(array('uid' => $uid));

  if (($ldap->user->userpassword == $actualPassword) && ($_POST["newPassword"] == $_POST["newPassword2"])) {
    $ldap->setUserUserpassword($newPassword);

    if ($ldap->saveUser())
      flash('success', T_('Password changed.'));
    else
      flash('error', T_('An error occured on password update.'));

    redirect_to('/user/update/'.$uid);
  } else {
    flash('error', T_('Actual password doesn\'t match'));
    redirect_to('/user/password/'.$uid);
  }


}


/**
 * GET /user/delete/:user
 */
function deleteUserForm ($uid = null) {
  global $ldap;
  if (isset($uid)) {
    $username = htmlspecialchars($uid);
    $ldap->setAttributesToFetch(array('cn', 'mail'));
    $ldap->setSearchPath(array('ou' => 'users'));
    if ($user = $ldap->findOneBy(array('uid' => $uid))) {
      set('username', $uid);
      set('name', $user['cn']);
      set('mail', $user['mail']);
      set('title', T_('Delete').' '.$uid);
      return render("deleteUserForm.html.php");
    } else {
      flash('error', T_('This user doesn\'t exists.'));
      redirect_to('/user/list');
    }
  } else {
    flash('error', T_('No user set.'));
    redirect_to('/user/list');
  }
}


/**
 * DELETE /user/delete
 */
function deleteUser () {
  global $ldap;
  $uid = htmlspecialchars($_POST["user"]);
  $ldap->populateUser(array('uid' => $uid));
  if ('admin' === $ldap->getUserDescription())
    $ldap->revokeAdmin($uid);
  if ($ldap->deleteUser(array('cn' => $ldap->getUserCn())))
    flash('success', T_('User successfully deleted.'));
  else
    flash('error', T_('An error occured on user deletion.'));

  redirect_to('/user/list');
}
