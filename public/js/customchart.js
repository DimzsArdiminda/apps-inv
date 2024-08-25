const data = {
  labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
  datasets: [{
    label: 'Pemasukan',
    data: [100, 200, 120, 150, 500, 450, 320],
    fill: true,
    borderColor: 'rgba(78, 115, 223, 1)',
    backgroundColor : 'rgba(78, 115, 223, 0.1)',
    lineTension: 0.3,
    pointRadius: 3,
    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
    pointHitRadius: 10,
    pointBorderWidth: 2
  },
  {
    label: 'Pengeluaran',
    data: [50, 300, 120, 100, 400, 450, 220],
    fill: true,
    borderColor: 'rgba(231, 74, 59, 1)',
    backgroundColor : 'rgba(231, 74, 59, 0.1)',
    lineTension: 0.3,
    pointRadius: 3,
    pointHoverBackgroundColor: "rgba(231, 74, 59, 1)",
    pointHoverBorderColor: "rgba(231, 74, 59, 1)",
    pointHitRadius: 10,
    pointBorderWidth: 2
  }
]
};

new Chart(document.getElementById("myChart"), {
  type: 'line',
  data: data,
  options: {

    title: {
      display: true,
      text: 'Jumlah Pemasukan dan Pengeluaran'
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
      }],
      yAxes: [{
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
    }
    
  }
});