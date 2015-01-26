$(function () {
    var response = [];
    $.post("ajaxs/getData.php", {value:""}, function(data) {
        response = JSON.parse(data) ;

        $('#container-countView').highcharts({
            chart: {
                type: "line",
                height: 400,
                width:980,
                animation: true,
                marginTop: 70,
                style:{"fontSize": "15px"}
            },
            title: {
                text: "Biểu đồ thống kê số lượt truy cập hòm thư góp ý",
                style:{fontSize:"13px", "text-transform" : "uppercase", "color": '#0091a7', "fontWeight": 'bold'}
            },
            xAxis: {
                categories:  response.Time
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Số lượng',
                    style:{"fontSize":"15px" , "color":"#333", 'fontWeight':'bold'}
                },
                lineColor: '#CCC',
                lineWidth: 1
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:1} </b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:1f}',
                        style:{"color": "#333", "fontSize": "12px" , 'fontWeight' : 'bold' }
                    }
                },
                line: {
                    dataLabels: {
                        enabled: true,
                        borderRadius: 25,
                        backgroundColor: 'rgba(252, 255, 197, 0.7)',
                        borderWidth: 0.5,
                        borderColor: '#AAA',
                        y: -6,
                        format: '{point.y:1f}',
                        style:{"color": "#333", "fontSize": "12px", 'fontWeight' : 'bold'}
                    },
                    lineWidth:3
                }
            },
            colors: ['#DC143C', '#4572a7', '#993399', '#f7a35c', '#8085e9',
                '#f15c80', '#e4d354', '#8085e8', '#8d4653', '#91e8e1'],

            series: response.infoValue
        });

    });

});