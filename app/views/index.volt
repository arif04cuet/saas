<?php
header("X-XSS-Protection: 0");
header('X-Content-Type-Options: nosniff');
?>
<!DOCTYPE html>
<html>
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="chrome=1">
        <meta http-equiv="X-Frame-Options" content="deny">
		<?php echo $this->tag->getTitle(); ?></title>
<!--		<link href="//netdna.bootstrapcdn.com/bootswatch/2.3.1/united/bootstrap.min.css" rel="stylesheet">-->
        {{ stylesheet_link('css/bootstrap/css/bootstrap.min.css') }}
<!--        {{ stylesheet_link('css/bootstrap/themes/united/bootstrap.min.css') }}-->
        {{ stylesheet_link('css/font-awesome.css') }}
        {{ stylesheet_link('css/flaticon/flaticon.css') }}
		{{ stylesheet_link('js/select2/select2.css') }}
		{{ stylesheet_link('css/style.css') }}

<!--        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->

        {{ javascript_include('js/jquery.js') }}

        <!--        <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>-->
        {{ javascript_include('js/bootstrap/bootstrap.min.js') }}
        {{ javascript_include('js/select2/select2.js') }}
        {{ javascript_include('js/jquery-sortable.js') }}
        {{ javascript_include('js/domain_selector.js') }}
        {{ javascript_include('js/bootstrap.touchspin.js') }}
        {{ javascript_include('js/jqBootstrapValidation.js') }}
        {{ javascript_include('js/common.js') }}

        <!--[if (gt IE 7)|!(IE)]><!-->
        <!--[if lt IE 7]>
        <script src="http://ie7-js.googlecode.com/svn/version/2.0(beta3)/IE7.js" type="text/javascript"></script>
        <![endif]-->
    <!-- this is test -->
	</head>
	<body>

		{{ content() }}

<style>
    .clearfix{
        background-color: #EEEEEE;
        margin: 10px 0;
        padding: 10px;
    }
    .clearfix label{
        font-weight: bold;
    }
</style>
    <script>
        $(document).ready(function(){
            $("input[type='checkbox']").bind('click',function(){
                if($(this).is(':checked')){
                    $(this).val('1');
                }else{
                    $(this).val('0');
                }
            });
            $('.btn').tooltip();
        });
    </script>
	</body>
</html>