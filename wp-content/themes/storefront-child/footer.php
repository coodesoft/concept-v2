<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */

?>

		</div><!-- .col-full -->
	</div><!-- #content -->

	<?php do_action( 'storefront_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="footer-container col-full">

            <div class="links">
                <ul class="links-list">
                    <li><a href="http://localhost/concept/">Home</a></li>
                    <li><a href="http://localhost/concept/nosotros">Nosotros</a></li>
                    <li><a href="http://localhost/concept/servicios">Servicios</a></li>
                    <li><a href="http://localhost/concept/productos">Productos</a></li>
                    <li><a href="http://localhost/concept/novedades">Novedades</a></li>
                    <li><a href="http://localhost/concept/contacto">Contacto</a></li>
                </ul>
            </div>
            <div class="filial">
                <span class="filial-title">Locales</span>
                <div class="filial-item">
                    <div>Emilio Lamarca 324</div>
                    <div>Flores, CABA</div>
                    <div>Tel.:</div>
                </div>
                <div class="filial-item">
                    <div>Helguera 195</div>
                    <div>Flores, CABA</div>
                    <div>Tel.:</div>
                </div>
            </div>
            <div class="office">
                <span class="office-title">Oficina & Showroom</span>
                <div class="office-item">
                    <div>Paez 2981</div>
                    <div>Flores, CABA</div>
                    <div>Tel.: 11 4619-1838</div>
                    <div>info@conceptmoda.com</div>
                </div>
            </div>
            <div class="logo">
                <img src="http://localhost/concept/wp-content/uploads/2019/11/Logo-cuadrado.png" alt="logo">
            </div>

		</div><!-- .col-full -->
        <div class="social-area col-full">
            <ul class="social-list">
                <li><i class="fab fa-facebook-square"></i></li>
                <li><i class="fab fa-instagram-square"></i></li>
                <li><i class="fab fa-linkedin"></i></li>
                <li><i class="fas fa-envelope-square"></i></li>
            </ul>
        </div>
	</footer><!-- #colophon -->

	<?php do_action( 'storefront_after_footer' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
