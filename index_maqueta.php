<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>Tienda de Camisetas</title>
</head>

<body>
    <!--	CABECERA	-->
    <header id="header">
        <div id="logo">
            <img src="assets/img/camiseta.png" alt="Camiseta Logo">
            <a href="index.php">Tienda de camisetas</a>
        </div>
    </header>
    <!--	MENU	-->
    <nav id="menu">
        <ul>
            <li>
                <a href="#">Inicio</a>
            </li>
            <li>
                <a href="#">Categoria 1</a>
            </li>
            <li>
                <a href="#">Categoria 2</a>
            </li>
            <li>
                <a href="#">Categoria 3</a>
            </li>
            <li>
                <a href="#">Categoria 4</a>
            </li>
            <li>
                <a href="#">Categoria 5</a>
            </li>
        </ul>
    </nav>

    <div id="contenido">
        <!--	BARRA LATERAL	-->
        <aside id="lateral">
            <div id="login" class="bloque-aside">
                <h3>Entrar a la Web</h3>
                <form action="#" method="post">
                    <label for="email">Email</label>
                    <input type="email" name="email">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password">
                    <input type="submit" value="Enviar">
                </form>
                <ul>
                    <li>
                        <a href="#">Mis pedidos</a>
                    </li>
                    <li>
                        <a href="#">Gestionar pedidos</a>
                    </li>
                    <li>
                        <a href="#">Gestionar categorias</a>
                    </li>
                </ul>
            </div> <!--	fin #login	-->

        </aside>
        <!--	CONTENIDO CENTRAL	-->
        <div id="central">
            <h1>Productos destacados</h1> 
            <div class="producto">
                <img src="assets/img/camiseta.png" alt="camiseta">
                <h2>Camiseta Azul Ancha</h2>
                <p>30 euros</p>
                <a href="">Comprar</a>
            </div><!--	fin .product	-->
            <div class="producto">
                <img src="assets/img/camiseta.png" alt="camiseta">
                <h2>Camiseta Azul Ancha</h2>
                <p>30 euros</p>
                <a href="">Comprar</a>
            </div><!--	fin .product	-->
            <div class="producto">
                <img src="assets/img/camiseta.png" alt="camiseta">
                <h2>Camiseta Azul Ancha</h2>
                <p>30 euros</p>
                <a href="">Comprar</a>
            </div><!--	fin .product	-->

        </div><!--	fin #central	-->

    </div><!--	fin #content	-->

    <!--	PIE DE PÁGINA	-->
    <footer id="footer">
        <p>Desarrollado por Oversistemas &COPY; <?= DATE('Y'); ?></p>
    </footer>

</body>

</html>