const codProv = document.getElementById('codProveedor');
const saveBtn = document.getElementById('saveEverything');
const btnAddTelefono = document.getElementById('btnAddTelefono');
const btnAddCorreo = document.getElementById('btnAddCorreo');
const btnAddDireccion = document.getElementById('btnAddDireccion');

const bodyCorreo = document.getElementById('correoBody');
const bodyDireccion = document.getElementById('direccionBody');
const bodyTelefono = document.getElementById('telefonoBody');
var deleted = {
    correos:[],
    direcciones:[],
    telefonos:[],
};

btnAddTelefono.addEventListener('click',(event)=>{
    let tr = document.createElement('tr');
    tr.innerHTML = `
        <td>
            <input type="text" class='form-control' disabled> 
        </td>
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
            <input type="text" class='form-control' disabled> 
        </td>
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
            <input type="text" class='form-control' disabled> 
        </td>
        <td>
            <input type="text" class='form-control'> 
        </td>
        <td>
            <button class='btn btn-danger' onclick="deleteDireccion(this)"  maxlength="70">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    `;
    bodyDireccion.appendChild(tr);
})



function deleteDireccion(element){
    let row  = element.parentElement.parentElement;
    if(row.children[0].children[0].value != ""){
        deleted.direcciones.push({
            Id_direccion: row.children[0].children[0].value,
            Direccion: row.children[1].children[0].value
        })
        element.parentElement.parentElement.parentElement.removeChild(row);
    }else{
        element.parentElement.parentElement.parentElement.removeChild(row);
    }
}
function deleteCorreo(element){
    let row  = element.parentElement.parentElement;
    if(row.children[0].children[0].value != ""){
        deleted.correos.push({
            Id_correo: row.children[0].children[0].value,
            Correo: row.children[1].children[0].value
        })
        element.parentElement.parentElement.parentElement.removeChild(row);
    }else{
        element.parentElement.parentElement.parentElement.removeChild(row);
    }


}
function deleteTelefono(element){

    let row  = element.parentElement.parentElement;
    if(row.children[0].children[0].value != ""){
        deleted.telefonos.push({
            Id_telefono: row.children[0].children[0].value,
            Telefono: row.children[1].children[0].value
        })
        element.parentElement.parentElement.parentElement.removeChild(row);
    }else{
        element.parentElement.parentElement.parentElement.removeChild(row);
    }
}

saveBtn.addEventListener('click',(e)=>{
    axios.post('/updateContact/',{prov:codProv.value,data:getData(),delete:deleted})
        .then((response)=>{
            if(response.status == 200 && response.data.status == 'OK'){
                Swal.fire({
                    icon: 'success',
                    title: 'Editado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                })
                window.location.replace("/supplier");
            }else{
                console.log(response)
            }
        })
})

function getData(){
    let data = {
        correos: [],
        direcciones: [],
        telefonos: []
    }
    if(bodyCorreo.children.length > 1){
        for(let i=1; i<bodyCorreo.children.length; i++){
            if(bodyCorreo.children[i].children[1].children[0].value !=""){
                data.correos.push(
                    {
                        Id_correo: bodyCorreo.children[i].children[0].children[0].value,
                        Correo: bodyCorreo.children[i].children[1].children[0].value,
                    }
                );
            }
        }
    }
    if(bodyDireccion.children.length > 1){
        for(let i=1; i<bodyDireccion.children.length; i++){
            if(bodyDireccion.children[i].children[1].children[0].value !=""){
                data.direcciones.push(
                    {
                        Id_direccion: bodyDireccion.children[i].children[0].children[0].value,
                        Direccion: bodyDireccion.children[i].children[1].children[0].value,
                    }
                );
            }
        }
    }
    if(bodyTelefono.children.length > 1){
        for(let i=1; i<bodyTelefono.children.length; i++){
            if(bodyTelefono.children[i].children[1].children[0].value !=""){
                data.telefonos.push(
                    {
                        Id_telefono: bodyTelefono.children[i].children[0].children[0].value,
                        Telefono: bodyTelefono.children[i].children[1].children[0].value,
                    }
                );
            }
        }
    }
    return data;

}