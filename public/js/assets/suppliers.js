const addSupplier = document.getElementById('addSupplier');

const guideInput = document.getElementById('inputGuide');

const deleteDetailBtns = document.querySelectorAll('.deleteDetail');
const btnSave = document.getElementById('saveDetails');
const alerts = document.getElementById('alerts');


addSupplier.addEventListener('click', agregarFila);
btnSave.addEventListener('click', saveSupplier);

function saveSupplier() {
    let problems = checkSupplier();
    if (problems.lengh > 0) {
        alerts.innerHTML = "";
        let ul = document.createElement('ul');
        problems.map((p) => {
            let li = document.createElement('li');
            li.innerText = p;
            ul.appendChild(li);
        });
        alerts.appendChild(ul);
        alerts.classList.remove('d-none');
        setTimeout(function() {
            alerts.classList.add('d-none');
        }, 4000);
    } else {
        let senData = {
            Codigo_proveedor: guideInput.value,
            Razon_social: document.getElementById('Razon_social').value,
            RUC: document.getElementById('RUC').value,
            Telefono: getTelefono(),
            Correos: getCorreo(),
            Direcciones: getDirecciones()
        }
        axios.post('/Supplier', senData)
            .then((res) => {
                console.log(res.data.msg);
                if (res.data.msg == "OK" && res.status == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Proveedor Agregado Correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    window.location.replace("/supplier");
                }
            });
    }
}

function agregarFila() {
    let tr = document.createElement('tr');
    tr.innerHTML = "<tr>" +
        "<td><input name='Telefono' class='form-control' onchange='(this)' type='text'> </td>" +
        "<td><input name='Direccion' class='form-control' onchange='(this)' type='text'> </td>" +
        "<td><input name='Correo' class='form-control' onchange='(this)' type='text'> </td>" +
        "<td><button class='btn btn-danger' onclick='eliminarFila(this)'><i class='fas fa-trash'></i></button></td>" +
        "</tr>";
    document.getElementById("dataTable").childNodes[3].appendChild(tr);
}

function getTelefono() {
    let data = [];
    const tablePhone = document.getElementById('dataTable')
    let numberNodes = tablePhone.childNodes[3].childNodes.length;
    for (let i = 1; i < numberNodes; i++) {
        let row = {
            Telefono: tablePhone.childNodes[3].childNodes[i].childNodes[0].childNodes[0].value,

        }
        data.push(row);
    }
    return data;
}

function eliminarFila(element) {
    let row = element.parentElement.parentElement;
    element.parentElement.parentElement.parentElement.removeChild(row);
}