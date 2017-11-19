<script>
    /* Responsive Design*/
    $(document).ready(function () {
        var wi = $(window).width();
        if (wi < 980) {
            $('.show-menu').click(function () {
                //$('.mzr-responsive').show();
                $(".mzr-responsive").slideToggle(700, "linear", function () {
                });
            });

            $(".mzr-drop> a").click(function () {

                $(".mzr-drop> a").siblings().addClass('sibling-toggle');

                $(this).parent().find(".mzr-content").removeClass('sibling-toggle').addClass('slide-visible').slideToggle(700, "linear", function () {
                    // Animation complete.

                    //$(".mzr-drop> a").siblings().addClass('sibling-toggle');
                });
                return false;
            });
        }

    });

</script>
<div class="sixteen columns">
    <a href="#" class="show-menu menu-head"> {{ menu_text }}</a>

    <ul class="meganizr mzr-slide mzr-responsive">
        {{ menu }}
    </ul>

</div>