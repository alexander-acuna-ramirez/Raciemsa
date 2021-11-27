
const btnAddTelefono = document.getElementById('btnAddTelefono');
const btnAddCorreo = document.getElementById('btnAddCorreo');
const btnAddDireccion = document.getElementById('btnAddDireccion');

const bodyCorreo = document.getElementById('correoBody');
const bodyDireccion = document.getElementById('direccionBody');
const bodyTelefono = document.getElementById('telefonoBody');
const saveBtn = document.getElementById('saveEverything');
const inputRazon = document.getElementById('Razon_Social');
const inputRUC = document.getElementById('RUC');

function changeRUC(element){
    axios.get('/supplierSearchByRUC?ruc='+inputRUC.value)
         .then((response)=>{
             if(response.data.tam > 0){
                Toast.fire({
                    icon: 'warning',
                    title: 'RUC ya registrado'
                })
                inputRUC.value = "";
             }
         })
}

function changeName(element){
    axios.get('/supplierSearchByName?name='+inputRazon.value)
         .then((response)=>{
             if(response.data.tam > 0){
                Toast.fire({
                    icon: 'warning',
                    title: 'Razon social ya registrada'
                })
                inputRazon.value = "";
             }
         })
}

btnAddTelefono.addEventListener('click',(event)=>{
    let tr = document.createElement('tr');
    tr.innerHTML = `
        <td>
            <input type="tel" class='form-control'> 
        </td>
        <td>
            <button class='btn btn-danger' onclick="deleteTelefono(this)" maxlength="12">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    `;
    bodyTelefono.appendChild(tr);
})

btnAddCorreo.addEventListener('click',(event)=>{
    let tr = document.createElement('tr');
    tr.innerHTML = `
        <td>
            <input type="email" class='form-control'> 
        </td>
        <td>
            <button class='btn btn-danger' onclick="deleteCorreo(this)"  maxlength="30">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    `;
    bodyCorreo.appendChild(tr);
})

btnAddDireccion.addEventListener('click',(event)=>{
    let tr = document.createElement('tr');
    tr.innerHTML = `
        <td>
            <input type="text" class='form-control' maxlength='20'> 
        </td>
        <td>
            <button class='btn btn-danger' onclick="deleteDireccion(this)" >
                <i class="fas fa-trash"></i>
            </button>
        </td>
    `;
    bodyDireccion.appendChild(tr);
})
saveBtn.addEventListener('click',(e)=>{
    getDataAndValidate();
})
function getDataAndValidate(){
    if(inputRUC.value.length != 11 && inputRUC.value == ""){
        Toast.fire({
            icon: 'warning',
            title: 'RUC no valido o vacío'
        })
    }else{
        if(inputRazon.value == ""){
            Toast.fire({
                icon: 'warning',
                title: 'Falta Razon social'
            })
        }else{
            let dataContact = getData();
            let sendData = {
                Razon_social: inputRazon.value,
                RUC: inputRUC.value,
                correos: dataContact.correos,
                direcciones: dataContact.direcciones,
                telefonos: dataContact.telefonos,
            }
            console.log(sendData);
            axios.post('/supplier',sendData)
            .then((response)=>{
                if(response.data.status == "OK" && response.status == 200){
                    Swal.fire({
                        icon: 'success',
                        title: 'Agregado correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    setTimeout(function () {
                        window.location.replace("/supplier");
                    },2000);
                }else{
                    Swal.fire({
                        icon: 'warning',
                        title: 'Error',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    console.log(response)
                    window.location.replace("/supplier");
                }
            })
        }
    }
}

function getData(){
    let data = {
        correos: [],
        direcciones: [],
        telefonos: []
    }
    if(bodyCorreo.children.length > 1){
        for(let i=1; i<bodyCorreo.children.length; i++){
            data.correos.push(bodyCorreo.children[i].children[0].children[0].value);
        }
    }
    if(bodyDireccion.children.length > 1){
        for(let i=1; i<bodyDireccion.children.length; i++){
            data.direcciones.push(bodyDireccion.children[i].children[0].children[0].value);
        }
    }
    if(bodyTelefono.children.length > 1){
        for(let i=1; i<bodyTelefono.children.length; i++){
            data.telefonos.push(bodyTelefono.children[i].children[0].children[0].value);
        }
    }

    return data;
}




function deleteDireccion(element){
    let row  = element.parentElement.parentElement;
    //bodyDireccion.removeChild(row);
    element.parentElement.parentElement.parentElement.removeChild(row);
}
function deleteCorreo(element){
    let row  = element.parentElement.parentElement;
    element.parentElement.parentElement.parentElement.removeChild(row);
    console.log(row)
}
function deleteTelefono(element){
    let row  = element.parentElement.parentElement;
    element.parentElement.parentElement.parentElement.removeChild(row);
    console.log(row)
}