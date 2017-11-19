<div class="sixteen columns" style="background-color: #333; box-shadow: 0 1px 5px #999999;">
    <div style="color: #eee; font-size: .7em;padding: 0 10px;height:30px">
        <div class="slide-panel-btns" style="float: left">
            <?php if ($lang == 'bn') { ?>
            <div class="slide-panel-button" style="display: block;"><i class="flaticon-menu10"></i>
                <a href="http://www.bangladesh.gov.bd/" target="_blank">বাংলাদেশ জাতীয় তথ্য বাতায়ন</a>
            </div>
            <div class="slide-panel-button" id="close-button" style="display: none;"><i
                        class="flaticon-cross5"></i>বাংলাদেশ
                জাতীয় তথ্য বাতায়ন
            </div>
            <?php } else { ?>
            <div class="slide-panel-button" style="display: block;"><i class="flaticon-menu10"></i>
                <a href="http://www.bangladesh.gov.bd/" target="_blank"> Bangladesh National Portal</a>

            </div>
            <div class="slide-panel-button" id="close-button" style="display: none;"><i
                        class="flaticon-cross5"></i>
                Bangladesh National Portal
            </div>

            <?php } ?>
        </div>
        <div id="div-lang"
             style=" padding: 0;position: absolute;right: 0;top: 0;z-index: 1001;margin-top: 2px; width: 405px;">
            <!-- <input style="width:300px" id="search" value=""/><a href="#" class="search-btn">go</a>-->
            <form action="/site/search" style="margin: 0;padding: 0;width: 345px;float: left">
                <!-- tt responsive 11-08-2015 -->
                <input style="width:300px" id="search" name="key" value=""/>
                <!-- tt end -->
                <button class="search-btn" type="submit" style="margin: 0;padding: 2px 10px"/>
                Go</button>
            </form>
            <div id="div-lang-sel">

                <form id="lang_form" action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="post">
                <?php
                        if ($lang != 'bn') {
                            ?>
                <input type="hidden" name="lang" id="lang" value="bn"/>
                <!-- <a href="javascript:;" style="color:#fff;font-weight:normal;font-size:.7em;"
                    onclick="return setLanguage();">বাংলা</a>-->
                <button type="submit" style="height: 26px;padding: 4px;">বাংলা</button>
                <?php } ?>
                <?php if ($lang != 'en') {
                            ?>
                <input type="hidden" name="lang" id="lang" value="en"/>
                <!--<a href="javascript:;" style="color:#fff;font-weight:normal;font-size:.7em;"
                   onclick="return setLanguage();">English</a>-->
                <button type="submit" style="height: 26px;padding: 4px;">English</button>
                <?php } ?>
                </form>

            </div>
        </div>
    </div>
</div>