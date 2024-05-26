let formCreate = document.querySelector("#form-create-user");
let formUpdate = document.querySelector("#form-update-user");
let formLogin = document.querySelector("#form-login");
let deleteButtons = document.querySelectorAll("#del-user");

if(formCreate) {
    createUser(formCreate);
}
if(formUpdate) {
    updateUser(formUpdate);
}
if(formLogin) {
    loginUser(formLogin);
}
deleteButtons.forEach(function(deleteUserBtn) {
    deleteUser(deleteUserBtn);
});


//aqui donde se agregar los productos
function deleteUser(deleteUserBtn) {
    deleteUserBtn.addEventListener("click", function(event) {
        event.preventDefault();
        
        // Encuentra el elemento padre de la fila actual (tr)
        var row = deleteUserBtn.closest('tr');

        // Encuentra el campo de entrada dentro de la fila actual
        var inputElement = row.querySelector('input[type="number"]');

        // Obtener el valor del campo de entrada
        var valor = inputElement.value;

        // Convertir el valor a un número (en caso de ser necesario)
        var numero = parseInt(valor);
        let kantidad;

        // Verificar si el valor es un número válido
        if (!isNaN(numero)){
            // Haz algo con el número obtenido
            kantidad = numero;
        } else {
            throw new Error('Ocurrió un error: ' + response.status);
        };

        let idCliente = document.getElementById('user-name').value;

        // Obtener el ID del producto del atributo de datos del botón
        let idProducto = deleteUserBtn.getAttribute("data-id");
        
        console.log(idCliente);
        console.log(idProducto);
        console.log(kantidad);

        let objeto = {
            fkUsuarios:idCliente,
            fkproducto:idProducto,
            cantidad:kantidad
        };
        let json = JSON.stringify(objeto);

        fetch('http://proyectopedidos.io/api/v1/Dpedidos.php', {
            method: 'POST',
            body: json
        })
        .then(response => {
            if(!response.ok) {
                throw new Error('Ocurrió un error: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log(data.message);
            window.location.href = '/users';
        })
        .catch(error => {
            console.error(error);
        });
    });
}

function loginUser(loginUserForm) {
    loginUserForm.addEventListener("submit", function(event) {
        event.preventDefault();


        let data = new FormData(event.target);
        let object = {};
        data.forEach(function(value, key) {
            object[key] = value;
        });
        let json = JSON.stringify(object);
        //console.log(json);
        //http://proyectopedidos.io
        fetch('http://proyectopedidos.io/api/v1/users.php?login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: json,
        })
        .then(response => response.json())
        .then(data => {
            if(data.error) {
                console.error(data.error);
                if(data.error.includes('Nombre')) {
                    document.getElementById('usernameError').textContent = data.error;
                    document.getElementsById('passwordError').textContent = '';
                }
                if(data.error.includes('password')) {
                    document.getElementById('passwordError').textContent = data.error;
                    document.getElementsById('usernameError').textContent = '';
                }
            } else {
                //login con éxito
                //console.log($_SESSION['datos']);
                window.location.href = '/';
            }
        })
        .catch(error => {
            console.error(error);
        });
    });
}

function createUser(createUserForm) {
    createUserForm.addEventListener("submit", function(event) {
        event.preventDefault();

        let data = new FormData(event.target);
        let object = {};
        data.forEach(function(value, key) {
            object[key] = value;
        });
        let json = JSON.stringify(object);
        //console.log(json);

        fetch('http://proyectopedidos.io/api/v1/users.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: json
        })
        .then(response => {
            if(!response.ok) {
                throw new Error('Ocurrió un error: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log(data.message);
            //formCreate.reset();
            window.location.href = '/users';
        })
        .catch(error => {
            console.error(error);
        });

        


    });
}

function updateUser(updateUserForm) {
    updateUserForm.addEventListener("submit", function(event) {
        event.preventDefault();

        let data = new FormData(event.target);
        let object = {};
        data.forEach(function(value, key) {
            object[key] = value;
        });
        let json = JSON.stringify(object);
        //console.log(json);

        fetch('http://proyectopedidos.io/api/v1/users.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'Accept': 'application/json'
            },
            body: json
        })
        .then(response => {
            if(!response.ok) {
                throw new Error('Ocurrió un error: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log(data.message);
            //formCreate.reset();
            window.location.href = '/users';
        })
        .catch(error => {
            console.error(error);
        });
    });
}

