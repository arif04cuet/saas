<!DOCTYPE html>
<html lang="en">
<head>
    {% block head %}
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{ stylesheet_link('css/bootstrap.min.css') }}
        {{ stylesheet_link('css/skeleton.css') }}
        {{ stylesheet_link('css/meganizr.css') }}
        {{ stylesheet_link('css/custom.css') }}

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <!--<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->
        <![endif]-->

        
        {{ javascript_include('js/jquery.js') }}
        {{ javascript_include('js/bootstrap/bootstrap.min.js') }}
        

    {% endblock %}

    <title>{% block title %}{% endblock %}</title>


</head>
<body>

<div class="container">

    <div id="header">
        <div class="row">
            <div class="col-md-12"><?php echo $this->partial('site/partial/topbar');?></div>
        </div>

        <div class="row">
            <div class="col-md-12"><?php echo $this->partial('site/partial/banner');?></div>
        </div>

        <div class="row">
            <div class="col-md-12"><?php echo $this->partial('site/partial/menu');?></div>
        </div>

    </div>


    <div id="content">
        <br>
        <div class="row">
            <div class="<?php echo $is_disable_rightbar?'col-md-12':'col-md-9'?>">
                <?php echo $this->partial('site/partial/leftbar');?>
            </div>
            <?php if(!$is_disable_rightbar):?>
            <div class="col-md-3"><?php echo $this->partial('site/partial/rightbar');?></div>
            <?php endif;?>
        </div>
    </div>

</div>

<div class="footer-artwork" id="footer-artwork">&nbsp;</div>
<div id="footer">
    <div class="row">
        <div class="col-md-12">
            <div class="footer-wrapper full-width" id="footer-wrapper">
                <div id="footer-menu">
                    <?php echo $this->partial('site/partial/footer');?>
                </div>
            </div>
        </div>
    </div>
</div>



</body>
</html>