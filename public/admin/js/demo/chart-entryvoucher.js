const entryToday = document.getElementById("entryVoucherToday");
const Legend = document.getElementById('legendChart')
var ctx = document.getElementById('entryVoucherChart').getContext('2d');
var ctx2 = document.getElementById("donutEntryChart");

window.addEventListener('load',(e)=>{
    axios.get('/entryVoucherToday').then((res)=>{
        if(res.status == 200){
            entryToday.innerText = res.data;
        }else{
            entryToday.innerText = "Error";
        }
    });
    axios.get('/entryVoucherMonth').then((res)=>{
        if(res.status == 200){
            let stats = getMonths(res.data);
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: stats.Months,
                    datasets: [{
                        label: 'Materiales ingresados por mes',
                        data: stats.Cants,
                        backgroundColor: "rgba(78, 115, 223, 0.05)",
                        borderColor: "rgba(78, 115, 223, 1)",
                        borderWidth: 1,
                        pointRadius: 3,
                        pointBackgroundColor: "rgba(78, 115, 223, 1)",
                        pointBorderColor: "rgba(78, 115, 223, 1)",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                        pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }else{
            console.log("Error");
        }
    });
    axios.get('/chartDonutTopMaterials').then((res)=>{
        Legend.innerHTML =`
            <span class="mr-2">
                <i class="fas fa-circle text-primary"></i> ${res.data[0].Descripcion}
            </span>
            </br>
            <span class="mr-2">
                <i class="fas fa-circle text-success"></i> ${res.data[1].Descripcion}
            </span>
            </br>
            <span class="mr-2">
                <i class="fas fa-circle text-info"></i> ${res.data[2].Descripcion}
            </span>
        `;
        var myPieChart = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: res.data.map((e)=>{
                    return e.Descripcion;
                }),
                datasets: [{
                    data: res.data.map((e)=>{
                        return e.Stock;
                    }),
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                    hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: false
                },
                cutoutPercentage: 80,
            },
        });
    });
})
function getMonths(data){
    let months = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
    let cants = [0,0,0,0,0,0,0,0,0,0,0,0];
    data.forEach((element)=>{
        switch (element.mes) {
            case "January":
                cants[0] = element.numFilas;
                break;
            case "February":
                cants[1] = element.numFilas;
                break;
            case "March":
                cants[2] = element.numFilas;
                break;
            case "April":
                cants[3] = element.numFilas;
                break;
            case "May":
                cants[4] = element.numFilas;
                break;
            case "June":
                cants[5] = element.numFilas;
                break;
            case "July":
                cants[6] = element.numFilas;
                break;
            case "August":
                cants[7] = element.numFilas;
                break;
            case "September":
                cants[8] = element.numFilas;
                break;
            case "October":
                cants[9] = element.numFilas;
                break;
            case "November":
                cants[10] = element.numFilas;
                break;
            case "December":
                cants[11] = element.numFilas;
                break;
        }
    });
    return {
        Months: months,
        Cants: cants
    };
}
