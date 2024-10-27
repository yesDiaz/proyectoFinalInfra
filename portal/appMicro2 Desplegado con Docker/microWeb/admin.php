<?php
        session_start();
        $us=$_SESSION["usuario"];
        if ($us==""){
            header("Location: index.html");
            exit();
        }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Administrar Usuarios</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin.php">Jeyxul</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="admin.php">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin-prod.php">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin-ord.php">Ordenes</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    <?php echo "<a class='nav-link' href='logout.php'>Logout $us</a>"; ?>
                </span>
            </div>
        </div>
    </nav>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Email</th>
                <th scope="col">Usuario</th>
                <th scope="col">Password</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $servurl = "http://microusuarios:3001/usuarios";
            $curl = curl_init($servurl);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
           
            if ($response === false) {
                curl_close($curl);
                die("Error en la conexión");
            }

            curl_close($curl);
            $resp = json_decode($response);
            $long = count($resp);
            for ($i = 0; $i < $long; $i++) {
                $dec = $resp[$i];
                $nombre = $dec->nombre;
                $email = $dec->email;
                $usuario = $dec->usuario;
                $password = $dec->password;
        ?>
            <tr>
                <td><?php echo $nombre; ?></td>
                <td><?php echo $email; ?></td>
                <td><?php echo $usuario; ?></td>
                <td><?php echo $password; ?></td>
                <td>
                    <!-- Botón para abrir el modal de actualización -->
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal"
                        data-nombre="<?php echo $nombre; ?>"
                        data-email="<?php echo $email; ?>"
                        data-usuario="<?php echo $usuario; ?>"
                        data-password="<?php echo $password; ?>">
                        Actualizar
                    </button>

                    <!-- Botón para eliminar usuario -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"
                        data-usuario="<?php echo $usuario; ?>">
                        Eliminar
                    </button>
                </td>
            </tr>
        <?php 
            }
        ?>   
        </tbody>
    </table>

    <!-- Botón para abrir el modal de creación -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
        CREAR USUARIO
    </button>

    <!-- Modal para confirmar eliminación de usuario -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="confirmDeleteText">¿Estás seguro de que deseas eliminar este usuario?</p>
                </div>
                <div class="modal-footer">
                    <form action="eliminarUsuario.php" method="post">
                        <input type="hidden" name="usuario" id="deleteUsuario">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para actualizar usuario -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">ACTUALIZAR USUARIO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="actualizarUsuario.php" method="post">
                        <!-- Campo oculto para el email original -->
                        <input type="hidden" name="email_original" id="editEmailOriginal">

                        <div class="mb-3">
                            <label for="editNombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" id="editNombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control" id="editEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="editUsuario" class="form-label">Usuario</label>
                            <input type="text" name="usuario" class="form-control" id="editUsuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPassword" class="form-label">Contraseña</label>
                            <input type="password" name="password" class="form-control" id="editPassword">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para crear usuario -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">CREAR USUARIO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="crearUsuario.php" method="post">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" id="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" name="usuario" class="form-control" id="usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Crear Usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para pasar los datos del usuario al modal de edición -->
    <script>
        var editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var nombre = button.getAttribute('data-nombre');
            var email = button.getAttribute('data-email');
            var usuario = button.getAttribute('data-usuario');
            var password = button.getAttribute('data-password');

            var modalBody = editModal.querySelector('.modal-body');
            modalBody.querySelector('#editNombre').value = nombre;
            modalBody.querySelector('#editEmail').value = email;
            modalBody.querySelector('#editUsuario').value = usuario;
            modalBody.querySelector('#editPassword').value = password;

            // Guardar el email original en un campo oculto
            modalBody.querySelector('#editEmailOriginal').value = email;
        });

        // Script para pasar los datos al modal de confirmación de eliminación
        var confirmDeleteModal = document.getElementById('confirmDeleteModal');
        confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var usuario = button.getAttribute('data-usuario');

            var confirmDeleteText = confirmDeleteModal.querySelector('#confirmDeleteText');
            confirmDeleteText.textContent = '¿Estás seguro de que deseas eliminar el usuario "' + usuario + '"?';

            var deleteForm = confirmDeleteModal.querySelector('form');
            var deleteUsuarioInput = deleteForm.querySelector('#deleteUsuario');
            deleteUsuarioInput.value = usuario;
        });
    </script>
</body>
</html>
