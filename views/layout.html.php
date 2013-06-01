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

 ?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?= $locale ?>"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>YunoHost <?= (isset($title)) ? "| ".$title : "" ?></title>
	<meta name="description" content="">
	<meta name="author" content="">

	<meta name="viewport" content="width=device-width">
    <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?= PUBLIC_DIR ?>/javascript/libs/jquery-1.7.1.min.js"><\/script>')</script>-->
    <link media="all" type="text/css" href="<?= PUBLIC_DIR ?>/stylesheets/app.css" rel="stylesheet">
	<script src="<?= PUBLIC_DIR ?>/javascript/libs/custom.modernizr.js"></script>
</head>
<body class="">
    <img src="/public/images/poc.png" id="poc" style="position: absolute; top: 112px; left: 130px; display: none;" />
    <nav class="tool-bar">
      <div class="tool-bar-wrapper">
        <ul class="left">
          <li class="name">
              <h1><a class="brand" href="<?= url_for('/') ?>"><span class="logo-white">YUNOHOST</span></a></h1>
          </li>
        </ul>
        <ul class="right">
          <li class="text">
            <a href="#" data-dropdown="locale-dropdown"><span class="uppercase"><?= $locale ?></span></a>
            <ul id="locale-dropdown" class="f-dropdown tiny" data-dropdown-content>
              <li><a href="<?= url_for('/lang/en') ?>">EN</a></li>
              <li><a href="<?= url_for('/lang/fr') ?>">FR</a></li>
            </ul>
          </li>
          <li class="">
            <a class="chat-button" href="<?= url_for('/support') ?>" title="<?= T_('Support chat') ?>"></a>
          </li>
          <li class="">
            <a class="logout-button" href="<?= url_for('/logout') ?>" title="<?= T_('Logout') ?>"></a>
          </li>
        </ul>
      </div>
    </nav>
    <div class="clear"></div>

    <div id="container" class="row small-fix">
        <div id="content">
            <div id="content-wrapper" class="stroked">
                <?php if (isset($flash['error'])) { ?>
                    <div data-alert class="alert-box alert">
                      <?= $flash['error'] ?>
                      <a href="#" class="close">&times;</a>
                    </div>
                <?php } elseif (isset($flash['notice'])) { ?>
                    <div data-alert class="alert-box">
                      <strong><?= T_('Notice') ?>:</strong> <?= $flash['notice'] ?>
                      <a href="#" class="close">&times;</a>
                    </div>
                <?php } elseif (isset($flash['success'])) { ?>
                    <div data-alert class="alert-box success">
                      <?= $flash['success'] ?>
                      <a href="#" class="close">&times;</a>
                    </div>
                <?php } ?>
                <?= $content?>
                <div class="row modal-wrapper">
                  <div class="reveal-modal gridBlock stroked" id="modal" style="display: none">
                  </div>
                </div>
            </div>
        </div>
    </div> <!-- /container -->


<script type="text/javascript">
  // i18n
  var dataTable_i18n = {
    "sSearch": "<i class='icon-search' style='z-index: 100'></i>",
    "sInfo": "<?= T_('Showing _START_ to _END_ of _TOTAL_'); ?>",
    "sInfoFiltered": "<?= T_('(filtered from _MAX_ total entries)'); ?>",
  };
</script>


<script type="text/javascript">
      document.write('<script src=' +
      ('__proto__' in {} ? '<?= PUBLIC_DIR ?>/javascript/libs/zepto' : '<?= PUBLIC_DIR ?>/javascript/libs/jquery') +
      '.js><\/script>');
</script>

<script src="<?= PUBLIC_DIR ?>/javascript/libs/foundation/foundation.js"></script>
<script src="<?= PUBLIC_DIR ?>/javascript/libs/foundation/foundation.alerts.js"></script>
<script src="<?= PUBLIC_DIR ?>/javascript/libs/foundation/foundation.clearing.js"></script>
<script src="<?= PUBLIC_DIR ?>/javascript/libs/foundation/foundation.cookie.js"></script>
<script src="<?= PUBLIC_DIR ?>/javascript/libs/foundation/foundation.dropdown.js"></script>
<script src="<?= PUBLIC_DIR ?>/javascript/libs/foundation/foundation.forms.js"></script>
<script src="<?= PUBLIC_DIR ?>/javascript/libs/foundation/foundation.joyride.js"></script>
<script src="<?= PUBLIC_DIR ?>/javascript/libs/foundation/foundation.magellan.js"></script>
<script src="<?= PUBLIC_DIR ?>/javascript/libs/foundation/foundation.orbit.js"></script>
<script src="<?= PUBLIC_DIR ?>/javascript/libs/foundation/foundation.placeholder.js"></script>
<script src="<?= PUBLIC_DIR ?>/javascript/libs/foundation/foundation.reveal.js"></script>
<script src="<?= PUBLIC_DIR ?>/javascript/libs/foundation/foundation.section.js"></script>
<script src="<?= PUBLIC_DIR ?>/javascript/libs/foundation/foundation.tooltips.js"></script>
<script src="<?= PUBLIC_DIR ?>/javascript/libs/foundation/foundation.topbar.js"></script>
<script>
    $(document).foundation();
</script>


<!-- <script src="<?= PUBLIC_DIR ?>/javascript/libs/jquery.dataTables.min.js"></script> -->
<script src="//cdnjs.cloudflare.com/ajax/libs/mustache.js/0.7.2/mustache.min.js"></script>

<!-- scripts concatenated and minified via ant build script-->
<script src="<?= PUBLIC_DIR ?>/javascript/plugins.js"></script>
<script src="<?= PUBLIC_DIR ?>/javascript/script.js"></script>

<?php if (isset($_SESSION['chat'])) { ?>
  <script type="text/javascript">
    jQuery.ajaxSetup({cache: true});
    jQuery.getScript("https://static.jappix.com/php/get.php?l=<?= $locale ?>&t=js&g=mini.xml", function() {
      MINI_GROUPCHATS = ["support@conference.yunohost.org"];
      HOST_ANONYMOUS = "yunohost.org";
      HOST_MUC = "conference.yunohost.org";
      HOST_BOSH = "http://yunohost.org/http-bind/";
      LOCK_HOST = 'off';
      MINI_ANIMATE = true;
      MINI_ANONYMOUS = true;
      launchMini(false, true, 'yunohost.org');
    });
  </script>
<?php } ?>



<!-- end scripts-->
</body>
</html>
