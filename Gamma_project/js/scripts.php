        <!-- SCRIPTS FIXOS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/js/ion.rangeSlider.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
        <!-- <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script> -->
        <script src="<?=ENDERECO?>js/libs/jnotify/jquery/jNotify.jquery.js" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
        <script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js" integrity="sha256-hlKLmzaRlE8SCJC1Kw8zoUbU8BxA+8kR3gseuKfMjxA=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
        <!-- SCRIPTS -->
        <script src="<?=ENDERECO?>js/scripts.js"></script>
        <script src="<?=ENDERECO?>js/functions.js"></script>
        <script src="<?=ENDERECO?>js/sale.js"></script>
        <script src="<?=ENDERECO?>js/price-filter.js"></script>
        <script src="<?=ENDERECO?>js/scrollAnimator.js"></script>

        <?php if(!empty($googleApi)):?>
            <script async src="https://cse.google.com/cse.js?cx=<?=$googleApi?>"></script>
        <?php endif;?>
    </body>
</html>