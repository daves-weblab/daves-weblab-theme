<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

    <title><?php wp_title() ?></title>

    <?php wp_head() ?>

    <?php $this->head() ?>
</head>

<body>
<!-- Page Content -->
<!-- ------------ -->

<?php $this->tpl->display() ?>

<!-- ------------- -->
<!-- /Page Content -->

<?php wp_footer() ?>
</body>
</html>