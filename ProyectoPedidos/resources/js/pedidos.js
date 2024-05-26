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


function deleteUser(deleteUserBtn) {
    deleteUserBtn.addEventListener("click", function(event) {
        event.preventDefault();
        

        let userId = event.target.getAttribute("data-id");
        console.log(userId);
        let objeto = {
            id: userId
        };
        let json = JSON.stringify(objeto);

        fetch('http://proyectopedidos.io/api/v1/Dpedidos.php', {
            method: 'DELETE',
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
            window.location.href = '/pedido';
        })
        .catch(error => {
            console.error(error);
        });
    });
}
