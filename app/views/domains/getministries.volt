<div class="gov-links">
    <ul>
        <?php foreach($linkList as $link):?>

        <li class="<?php echo (count($link['child'])>0)?'hasChild':''?>">
            <div class="parent">
                <img src="http://localhost/phalcon/public/img/gov_logo.gif" alt="logo"/>

                <p><a target="_blank" href="<?php echo $link['url'];?>"><?php echo $link['name'];?></a></p>
                <span class="status status<?php echo $link['progress_status']?>"><?php echo $link['site_status'];?></span>
            </div>
            <?php if(count($link['child'])>0):?>
            <div class="child-section">
                <ul class="child">
                    <?php
                        $childPart = $link['child'];
                        $childKeys = array_keys($childPart);
                    ?>
                    <?php foreach($childPart as $name => $childList):?>
                    <li class="<?php echo $name;?>"><a href="#"><?php echo ($ln=='en')? ucfirst($name):getName($name);?>
                            (<?php echo count($childList);?>)</a></li>
                    <?php endforeach;?>
                </ul>
                <div class="child-list">
                    <?php foreach($childKeys as $key):?>
                    <ul class="<?php echo $key;?>">
                        <?php foreach($childPart[$key] as $child):?>
                        <li>
                            <div>
                                <img src="http://localhost/phalcon/public/img/gov_logo.gif" alt="asdsad"/>

                                <p><a target="_blank"
                                      href="<?php echo $child['url'];?>"><?php echo $child['name'];?></a></p>
                                <span class="status status<?php echo $child['progress_status']?>"><?php echo $child['site_status'];?></span>
                            </div>
                        </li>
                        <?php endforeach;?>
                    </ul>
                    <?php endforeach;?>
                </div>
            </div>
            <?php endif;?>
        </li>
        <?php endforeach;?>
    </ul>
</div>
<?php
function getName($key)
{
 $names = array(
            'directorate'=>'অধিদপ্তর',
'division'=>'বিভাগ',
'institute'=>'প্রতিষ্ঠান'
);
return $names[$key];
}
?>
<style type="text/css">

    .gov-links {
        width: 500px;
    }

    .gov-links * {
        margin: 0;
        padding: 0
    }

    .gov-links a {
        text-decoration: none;
    }

    .gov-links ul {
        list-style: none;
    }

    .gov-links > ul > li {
        border-bottom: 0px solid #EFEFEF;
        padding: 10px 0;
    }

    .gov-links ul li .parent * {
        display: inline;
        margin-right: 10px;
        vertical-align: top;
    }

    .gov-links img {
        width: 20px;
        margin-right: 10px;
    }

    .status {
        padding: 0px 5px;
        border-radius: 7px;
        display: block;
        color: #ffffff;
    }

    .status1 {
        background-color: #0000ff;
    }

    .status2 {
        background-color: #609513;
    }

    .status3 {
        background-color: #DA7A05;
    }

    .status4 {
        background-color: #E9002C;
    }

    .parent {
        margin-bottom: 5px;
    }

    .parent a {
        font-size: 18px
    }

    .child-section .child {
        margin-left: 45px;
        border-bottom: 1px solid #EFEFEF;
        margin-bottom: 10px;

    }

    .child-section .child li {
        display: inline;
        border-right: 1px solid #EFEFEF;
        padding-left: 5px;
        margin: 0 !important;
    }

    .child-section .child li.active a {
        color: #2F9626;
    }

    .child-section .child li:last-child {
        border-right: 0px solid lightslategray;
    }

    .child-section .child-list {
        margin-left: 35px;
    }

    .child-section .child-list ul {
        display: none;
    }

    .child-section .child-list ul li {
        border-bottom: 1px solid #efefef;
        border-left: 3px solid green;
        margin-bottom: 2px;
        padding: 8px 0 8px 10px;
        margin-left: 10px !important;
    }

    .child-section .child-list ul li div * {
        display: inline;
        vertical-align: top;
    }

</style>
{#{{ javascript_include('js/jquery.min.js') }}#}
<script type="text/javascript">
    $(document).ready(function () {
        $(".child li").click(function (e) {
            e.preventDefault();
            //$(this).parents('.child-section').find('.child-list ul').hide()
            var $child = '.child-list .' + $(this).attr('class').split(' ')[0];
            $(this).parents('.child-section').find($child).toggle();
            $(this).siblings('li').removeClass('active');
            $(this).toggleClass('active');
        });
    });
</script>