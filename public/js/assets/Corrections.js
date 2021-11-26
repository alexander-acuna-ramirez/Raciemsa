const searchGuide = document.getElementById('searchBtn');
const guideInput = document.getElementById('inputGuide');
const social = document.getElementById('Social');
const EmisionGuide = document.getElementById('Emision');
const InicioGuide = document.getElementById('Inicio');
const FinGuide = document.getElementById('Fin');

const addCorrections = document.getElementById('addCorrections');

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
        axios.get(`/CorrectionRequest/searchGuide/${guideInput.value}`)
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
addCorrections.addEventListener('click',agregarFila);
btnSave.addEventListener('click',saveCorrectionRequest);
function  saveCorrectionRequest(){
    let problems = checkCorrections();
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
            Codigo_reposicion: document.getElementById('Codigo_reposicion').value,
            Motivo: document.getElementById('Motivo').value,
            Fecha: document.getElementById('Fecha').value,
            Correcciones: getCorrections()
        }
        axios.post('/CorrectionRequest',sendData)
             .then((res)=>{
                console.log(res.data.msg);
                if(res.data.msg == "Ok" && res.status == 200){
                    Swal.fire({
                        icon: 'success',
                        title: 'Agregado correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    window.location.replace("/CorrectionRequest");
                }
             });
    }

}
function checkCorrections(){
    var problems = [];
    let corrections = getCorrections();
    let checkCorrections = corrections.filter(x => x.Numero_de_parte === "");
    if(corrections.length === 0 ){
        problems.push('Sin correcciones en la solicitud');
    }
    if(checkCorrections.length > 0){
        problems.push(`Hay ${checkCorrections.length} correcciones que no tienen número de parte`);
    }
    checkCorrections = corrections.filter(x => x.Diferencia === "" || x.Diferencia == 0);
    if(checkCorrections.length > 0){
        problems.push(`Hay ${checkCorrections.length} correcciones sin una diferencia`);
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
                        "<td><input name='Diferencia'  class='form-control' type='number'></td>" +                
                        "<td><button class='btn btn-danger' onclick='eliminarFila(this)'><i class='fas fa-trash'></i></button></td>"+
                    "</tr>";
    document.getElementById("dataTable").childNodes[3].appendChild(tr);
}
function searchProduct(element){
    if(element.value != ""){
        let corrections = getCorrections().filter(x => x.Numero_de_parte != "");
        let isRepeated = [...new Set(corrections.map(x => x.Numero_de_parte))];
        if(isRepeated.length === corrections.length){
            axios.get(`/CorrectionRequest/searchProduct/${element.value}`)
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
function getCorrections(){
    let data = [];
    const tableCorrections = document.getElementById('dataTable')
    let numberNodes = tableCorrections.childNodes[3].childNodes.length;
    for (let i = 1; i < numberNodes ; i++) {
        let row = {
            Numero_de_parte:tableCorrections.childNodes[3].childNodes[i].childNodes[0].childNodes[0].value,
            Diferencia: tableCorrections.childNodes[3].childNodes[i].childNodes[2].childNodes[0].value,
        }
        data.push(row);
    }
    return data;
}
function eliminarFila(element){
    let row = element.parentElement.parentElement;
    element.parentElement.parentElement.parentElement.removeChild(row);
}