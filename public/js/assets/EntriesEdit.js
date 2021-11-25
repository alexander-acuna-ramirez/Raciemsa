const btnSave = document.getElementById('saveChanges');
var original = [];
var deleted = [];

window.addEventListener('load',(e)=>{

    original = getEntries();
})

btnSave.addEventListener('click',(e)=>{
    Swal.fire({
        title: '¿Estas seguro?',
        text: "Se guardaran todos los cambios",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, guardar!',
        cancelButtonText: 'Cancelar'
    }).then(function (result){
        if(result.isConfirmed){
            let sendData = getModifyEntries();
            axios.put('/entryvoucher/'+sendData.ID_vale_entrada,sendData)
                 .then((res)=>{
                     if(res.status == 200 && res.data.status == "OK"){
                         Swal.fire({
                             icon: 'success',
                             title: 'Editado correctamente',
                             showConfirmButton: false,
                             timer: 2000
                         })
                         window.location.replace("/entryvoucher");
                     }else{
                         Swal.fire({
                             icon: 'error',
                             title: res.data.msg,
                             showConfirmButton: false,
                             timer: 2000
                         })
                         //window.location.replace("/entryvoucher");
                     }
                 })

        }
    })
})
function getEntries(){
    let data = [];
    const tableEntries = document.getElementById('dataTable')
    const sizeEntries = tableEntries.children[1].children.length;
    for (let i = 0; i < sizeEntries; i++) {
        data.push({
            Numero_de_parte: tableEntries.children[1].children[i].children[0].children[0].value,
            Cantidad: tableEntries.children[1].children[i].children[2].children[0].value,
            Observacion: tableEntries.children[1].children[i].children[3].children[0].value,
            Status:tableEntries.children[1].children[i].children[4].children[0].checked,
        })
    }
    return data;
}
function deleteEntry(element){
    Swal.fire({
        title: '¿Estas seguro?',
        text: "Si guardas los cambios esta entrada se eliminara definitivamente",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!',
        cancelButtonText: 'Cancelar'
    }).then(function (result){
        if(result.isConfirmed){
            const tableEntries = document.getElementById('dataTable')
            const sizeEntries = tableEntries.children[1].children.length;
            if(sizeEntries > 1){
                let row = element.parentElement.parentElement;
                deleted.push(row.children[0].children[0].value);
                element.parentElement.parentElement.parentElement.removeChild(row);
            }else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'No puede eliminar todas las entradas del vale',
                })
            }

        }
    })
}
function getModifyEntries(){
    return {
        ID_vale_entrada: document.getElementById('ID_vale_entrada').value,
        update: getEntries(),
        delete: deleted,
    }
}
