<?php 

 /**
  *  YunoHost - Self-hosting for all
  *  Copyright (C) 2012  
  *     Kload <kload@kload.fr>
  *     Guillaume DOTT <github@dott.fr>
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
function home() {
  set('tab', 'home');
  set('title', T_('Welcome !'));
  return render("homepage.html.php");
}

/**
 * GET /logout
 */
function logout() {
  $_SESSION['isConnected'] = false;

  redirect_to('/user/list');
}

/**
 * GET /lang/:locale
 */
function changeLocale ($locale = 'en') {
  switch ($locale) {
    case 'fr':
      $_SESSION['locale'] = 'fr';
      break;

    default:
      $_SESSION['locale'] = 'en';
      break;
  }
  if(!empty($_GET['redirect_to']))
    redirect_to($_GET['redirect_to']);
  else
    redirect_to('/user/list');
}

/**
 * GET /images/:name/:size
 */
function image_show() {
  $ext = file_extension(params('name'));
  $filename = option('public_dir').basename(params('name'), ".$ext");
  if(params('size') == 'thumb') $filename .= ".thb";
  $filename .= '.jpg';

  if(!file_exists($filename)) halt(NOT_FOUND, "$filename doesn't exists");
  render_file($filename);
}

/**
 * GET /images/*.jpg/:size
 */
function image_show_jpeg_only() {
  $ext = file_extension(params(0));
  $filename = option('public_dir').params(0);
  if(params('size') == 'thumb') $filename .= ".thb";
  $filename .= '.jpg';

  if(!file_exists($filename)) halt(NOT_FOUND, "$filename doesn't exists");
  render_file($filename);
}

/**
 * GET /ping/:vhost
 */
function ping ($vhost) {
  switch ($vhost) {
    case 'public':
      exec ('ping -c2 -q -w2 '.$_SESSION['mainDomain'], $output, $return_code);
      break;

    case 'www':
      exec ('ping -c2 -q -w2 www.'.$_SESSION['mainDomain'], $output, $return_code);
      break;

    case 'mail':
      exec ('ping -c2 -q -w2 mail.'.$_SESSION['mainDomain'], $output, $return_code);
      break;

    case 'apps':
      exec ('ping -c2 -q -w2 apps.'.$_SESSION['mainDomain'], $output, $return_code);
      break;

    case 'auth':
      exec ('ping -c2 -q -w2 auth.'.$_SESSION['mainDomain'], $output, $return_code);
      break;

    case 'admin':
      exec ('ping -c2 -q -w2 admin.'.$_SESSION['mainDomain'], $output, $return_code);
      break;

    default:
      $ping = 2;
      break;
  }

  if ($return_code == 0)
    header('HTTP/1.0 200 OK');
  else
    header('HTTP/1.0 404 Not Found');

  exit;
}
