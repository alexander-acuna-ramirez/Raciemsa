const searchGuide = document.getElementById('searchBtn');
const guideInput = document.getElementById('inputGuide');
const social = document.getElementById('Social');
const EmisionGuide = document.getElementById('Emision');
const InicioGuide = document.getElementById('Inicio');
const FinGuide = document.getElementById('Fin');
const addEntry = document.getElementById('addEntry');
const deleteDetailBtns = document.querySelectorAll('.deleteDetail');
const btnSave = document.getElementById('saveDetails');
const alerts = document.getElementById('alerts');

searchGuide.addEventListener('click',(e)=>{
    if(guideInput.value == ""){
        Toast.fire({
            icon: 'warning',
            title: 'Ingrese el codigo de la guia de remisión'
        })
    }else{
        /*Necesita validacion*/
        axios.get(`/searchGuide/${guideInput.value}`)
            .then((response)=>{
                if(response.data.length === 0){
                    Toast.fire({
                        icon: 'warning',
                        title: 'Guia no encontrada'
                    })
                }else{
                    Toast.fire({
                        icon: 'success',
                        title: 'Guia encontrada'
                    })
                    social.value = response.data[0].Razon_social;
                    EmisionGuide.value = response.data[0].Fecha_de_emision;
                    InicioGuide.value = response.data[0].Inicio_traslado;
                    FinGuide.value = response.data[0].Fin_traslado;
                    guideInput.readOnly = true;
                    searchGuide.disabled = true;
                }
            });
    }
});
addEntry.addEventListener('click',agregarFila);
btnSave.addEventListener('click',saveEntryVoucher);
function  saveEntryVoucher(){
    let problems = checkEntries();
    if(problems.length > 0){
        alerts.innerHTML = "";
        let ul = document.createElement('ul');
        problems.map((p)=>{
            let li = document.createElement('li');
            li.innerText = p;
            ul.appendChild(li);
        });
        alerts.appendChild(ul);
        alerts.classList.remove('d-none');
        setTimeout(function (){
            alerts.classList.add('d-none');
        },4000);
    }else{
        let sendData = {
            Codigo_guia_remision:guideInput.value,
            Hora: document.getElementById('Hora').value,
            Fecha: document.getElementById('Fecha').value,
            Entradas: getEntries()
        }
        axios.post('/entryvoucher',sendData)
             .then((res)=>{
                console.log(res.data.msg);
                if(res.data.msg == "Ok" && res.status == 200){
                    Swal.fire({
                        icon: 'success',
                        title: 'Agregado correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    window.location.replace("/entryvoucher");
                }
             });
    }

}
function checkEntries(){
    let problems = [];
    let entries = getEntries();
    let checkEntries = entries.filter(x => x.Numero_de_parte === "");
    if(entries.length === 0 ){
        problems.push('Sin entradas en el vale');
    }
    if(checkEntries.length > 0){
        problems.push(`Hay ${checkEntries.length} entradas que no tienen numero de parte`);
    }
    checkEntries = entries.filter(x => x.Cantidad === "" || x.Cantidad == 0);
    if(checkEntries.length > 0){
        problems.push(`Hay ${checkEntries.length} entradas sin una cantidad`);
    }
    if(searchGuide.disabled == false){
        problems.push(`Falta vincular una guia de remision`);
    }
    return problems;

}
function agregarFila(){
    let tr = document.createElement('tr');
    tr.innerHTML = "<tr>"+
                        "<td><input name='codigo' class='form-control' onchange='searchProduct(this)' type='text'></td>" +
                        "<td><input name='Descripcion' class='form-control' disabled type='text'></td>" +
                        "<td><input name='Cantidad'  class='form-control' type='number'></td>" +
                        "<td><input name='Observaciones'  class='form-control' type='text'></td>"+
                        "<td><input name='status'  class='form-control' type='checkbox' checked></td>"+
                        "<td><button class='btn btn-danger' onclick='eliminarFila(this)'><i class='fas fa-trash'></i></button></td>"+
                    "</tr>";
    document.getElementById("dataTable").childNodes[3].appendChild(tr);
}
function searchProduct(element){
    if(element.value != ""){
        let entries = getEntries().filter(x => x.Numero_de_parte != "");
        let isRepeated = [...new Set(entries.map(x => x.Numero_de_parte))];
        if(isRepeated.length === entries.length){
            axios.get(`/searchProduct/${element.value}`)
                .then((res)=>{
                    if(res.status == 200 && res.data.length > 0 ){
                        parent = element.parentElement.parentElement;
                        parent.childNodes[1].childNodes[0].value = res.data[0].Descripcion;
                        element.readOnly = true;
                    }else{
                        Toast.fire({
                            icon: 'warning',
                            title: 'Material no encontrado'
                        })
                        element.value = "";
                    }
                });
        }else{
            Toast.fire({
                icon: 'warning',
                title: 'Material repetido'
            })
            element.value = "";
        }
    }
}
function getEntries(){
    let data = [];
    const tableEntries = document.getElementById('dataTable')
    let numberNodes = tableEntries.childNodes[3].childNodes.length;
    for (let i = 1; i < numberNodes ; i++) {
        let row = {
            Numero_de_parte:tableEntries.childNodes[3].childNodes[i].childNodes[0].childNodes[0].value,
            Cantidad: tableEntries.childNodes[3].childNodes[i].childNodes[2].childNodes[0].value,
            Observacion: tableEntries.childNodes[3].childNodes[i].childNodes[3].childNodes[0].value,
            Status: tableEntries.childNodes[3].childNodes[i].childNodes[4].childNodes[0].checked,
        }
        data.push(row);
    }
    return data;
}
function eliminarFila(element){
    let row = element.parentElement.parentElement;
    element.parentElement.parentElement.parentElement.removeChild(row);
}
