<!DOCTYPE HTML>

<html lang="en">

<head>

    <title><?php echo $cpagetitle;?></title>

    <meta charset="utf-8">

    <?php include('includes.php'); ?>

</head>

<body>

    <section id="content" style="min-width:400px; padding:0;">

        <section class="clearfix">

            <section id="main">

                <article id="<?php echo $cpage;?>">

                    <?php $this->load->view('../message');  ?>

                    <?php  $this->load->view($cpage); ?>

                </article>

            </section>

        </section>

    </section>

</body>

</html>