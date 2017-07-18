<?php
/**
 * @category    GoogleLogin
 * @date        19/05/2017 14:31
 * @author      Jakub Płaskonka <jplaskonka@divante.pl>
 * @copyright   Copyright (c) 2017 Divante Ltd. (https://divante.co)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/plugins/GoogleLogin/static/css/normalize.css">
    <link rel="stylesheet" href="/plugins/GoogleLogin/static/css/skeleton.css">
</head>
<body>

<!-- Primary Page Layout
–––––––––––––––––––––––––––––––––––––––––––––––––– -->
<div class="container">
    <div class="row">
        <div class="one-half column" style="margin-top: 10%">
            <h4><?=$this->t("google_login_config");?></h4>
            <?php if($this->saved): ?>
                <?=$this->t("configuration_has_been_saved");?>
            <?php endif; ?>
            <form action="#" method="post">
                <div class="row">
                    <div class="six columns">
                        <label for="className"><?=$this->t("client_id");?></label>
                        <input class="u-full-width" type="text" placeholder="<?=$this->t("client_id");?>" id="className" name="clientId" value="<?= $this->clientId ?>">
                        <label for="adminUrl"><?=$this->t("client_secret");?></label>
                        <input class="u-full-width" type="text" placeholder="<?=$this->t("client_secret");?>" id="adminUrl" name="clientSecret" value="<?= $this->clientSecret ?>">
                        <label for="className"><?=$this->t("redirect_uri");?></label>
                        <input class="u-full-width" type="text" placeholder="<?=$this->t("redirect_uri");?>" id="className" name="redirectUri" value="<?= $this->redirectUri ?>">
                        <label for="className"><?=$this->t("hosted_domain");?></label>
                        <input class="u-full-width" type="text" placeholder="<?=$this->t("hosted_domain");?>" id="className" name="hostedDomain" value="<?= $this->hostedDomain ?>">
                    </div>
                </div>

                <input class="button-primary" type="submit" value="<?=$this->t("save");?>">

            </form>
        </div>
    </div>
</div>
<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
