// i like to avoid using variables AMAP
document.querySelector('.add_b').addEventListener('click', add_user);
document.getElementById('delete_confirm').addEventListener('click', delete_user);
document.getElementById('edit_confirm').addEventListener('click', edit_user);

const getUsers = async () => {
    const response = await fetch("http://localhost/php_rest_api/api/user/read.php");
    const data = await response.json();
    content = `<table class="table">
    <thead>
      <tr>
        <th scope="col">Names</th>
      </tr>
    </thead>
    <tbody id="names">`;
    data.forEach(e => {
        content += `<tr>
        <th scope="row">${e.user_name}</th>
        <td value="${e.id}"><button class="btn btn-sm btn-success edit_b"  data-bs-toggle="modal" data-bs-target="#edit_modal"><i class="fas fa-edit"></i></button></td>
        <td value="${e.id}"><button class="btn btn-sm btn-danger delete_b" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="fas fa-trash-alt"></i></button></td>
      </tr>`;
    });

    // print all users
    document.querySelector('#users').innerHTML = content;

    //add the delete event-listener to the buttons
    document.querySelectorAll('.delete_b').forEach(e => {
        e.addEventListener('click', function () {
            document.getElementById('delete_confirm').setAttribute('value', this.parentElement.getAttribute("value"));
        });
    })

    //add the edit event-listener to the buttons
    document.querySelectorAll('.edit_b').forEach(e => {
        e.addEventListener('click', function () {
            document.getElementById('name_user').value = this.parentElement.parentElement.children[0].innerHTML;
            document.getElementById('edit_confirm').setAttribute('value', this.parentElement.getAttribute("value"));
        });
    })
}
getUsers();

async function add_user() {
    //create the data as an object
    data = {
        'name': document.querySelector('#add input').value,
        'id_address': '1'
    };
    document.querySelector('#add input').value = "";

    fetch("http://localhost/php_rest_api/api/user/create.php", {
        method: "POST",
        headers: {
            'Accept': 'application/json',
            'Content-type': 'application/json'
        },
        body: JSON.stringify(data)
    }
    ).then(res => res.json())
        .then(data => console.log(data))
        .then(getUsers)
}

async function delete_user() {
    //create the data as an object
    data = {
        'id': document.querySelector('#delete_confirm').value,
    };
    document.querySelector('#add input').value = "";

    fetch("http://localhost/php_rest_api/api/user/delete.php", {
        method: "POST",
        headers: {
            'Accept': 'application/json',
            'Content-type': 'application/json'
        },
        body: JSON.stringify(data)
    }
    ).then(res => res.json())
        .then(data => console.log(data))
        .then(getUsers)
}

async function edit_user() {
    //create the data as an object

    document.querySelector('#add input').value = "";

    fetch("http://localhost/php_rest_api/api/user/update.php", {
        method: "POST",
        headers: {
            'Accept': 'application/json',
            'Content-type': 'application/json'
        },
        body: JSON.stringify(
            {
                'name': document.getElementById('name_user').value,
                'id': document.getElementById('edit_confirm').value,
                'id_address': '1'
            }
        )
    }
    ).then(res => res.json())
        .then(data => console.log(data))
        .then(getUsers)
}