<!--/** * Created by PhpStorm. * Date: 07.12.2017 */-->

<footer id="footer"><!--Footer-->
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <p class="pull-left">Copyright © 2017</p>
                <p class="pull-right">Test task for https://wezom.com.ua/</p>
            </div>
        </div>
    </div>
</footer><!--/Footer-->



<script src="/assets/js/jquery.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/jquery.scrollUp.min.js"></script>
<script src="/assets/js/price-range.js"></script>
<script src="/assets/js/jquery.prettyPhoto.js"></script>
<script src="/assets/js/main.js"></script>
<!--добавляем товары в корзину асинхронно-->

<script>
    $(document).ready(function(){
        $(".add-to-cart").click(function () {
            var id = $(this).attr("data-id");
            $.post("/cart/addAjax/"+id, {}, function (data) {
                $("#cart-count").html(data);
            });
            return false;
        });
    });
</script>




</body>
</html>