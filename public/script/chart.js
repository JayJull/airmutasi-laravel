// function generateChart(title, series) {
//   return {
//     series,
//     chart: {
//       type: "line",
//       zoom: {
//         enabled: false,
//       },
//     },
//     dataLabels: {
//       enabled: false,
//     },
//     stroke: {
//       curve: "straight",
//     },
//     title: {
//       text: title,
//       align: "left",
//     },
//     grid: {
//       row: {
//         colors: ["#f3f3f3", "transparent"],
//         opacity: 0.5,
//       },
//     },
//     xaxis: {
//       categories: [
//         "Jan",
//         "Feb",
//         "Mar",
//         "Apr",
//         "May",
//         "Jun",
//         "Jul",
//         "Aug",
//         "Sep",
//       ],
//     },
//   };
// }

function generateBarChart(title, series) {
    return {
        series,
        chart: {
            type: "bar",
        },
        title: {
            text: title,
            align: "left",
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "55%",
                endingShape: "rounded",
            },
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            show: true,
            width: 2,
            colors: ["transparent"],
        },
        xaxis: {
            categories: ["FRMS", "Current", "Formasi"],
        },
        yaxis: {
            title: {
                text: "Jumlah Personel",
            },
        },
        fill: {
            opacity: 1,
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + " Orang";
                },
            },
        },
    };
}

function generatePieChart(title, series) {
    return {
        series,
        chart: {
            type: "pie",
        },
        labels: ["FRMS", "Current", "Formasi"],
        title: {
            text: title,
            align: "left",
        },
        responsive: [
            {
                breakpoint: 480,
                options: {
                    legend: {
                        position: "bottom",
                    },
                },
            },
        ],
    };
}
