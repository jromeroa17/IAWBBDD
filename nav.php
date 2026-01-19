<?php
function crea_nav(){
    ?>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div>
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>

                    <?php if (!isset($_SESSION["usuario"])) { ?>
                        <li class="nav-item active">
                            <a class="nav-link" href="registro.php">Registrarse</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Inicio de Sesión</a>
                        </li>
                    <?php } ?>

                    <?php if (isset($_SESSION["usuario"])) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="micuenta.php">Mi Cuenta</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                               role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Personajes
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="creapersonaje.php">Crear</a>
                                <a class="dropdown-item" href="modificarpersonaje.php">Modificar</a>
                                <a class="dropdown-item" href="listarpersonajes.php">Listar</a>
                                <a class="dropdown-item" href="borrarpersonaje.php">Borrar</a>
                                <a class="dropdown-item" href="buscarpersonajes.php">Buscar</a>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                        </li>
                    <?php } ?>
					<?php if(isset($_SESSION["usuario"]) and $_SESSION["usuario"] == "admin") { ?>
						<li class="nav-item">
                            <a class="nav-link" href="admin.php">Usuarios</a>
                        </li>
					<?php }?>
                </ul>
            </div>
        </nav>
    </header>
    <?php
}
?>