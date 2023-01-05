/* 차트1 활동량 */
var sampleData = [
        { Day: '.', 자율측정: 1500, 손목: 1100, 근력: 1000 },
        { Day: '2018/01/08', 자율측정: 2800, 손목: 2300, 근력: 1800 },
        { Day: '.', 자율측정: 2500, 손목: 2000, 근력: 1200 },
        { Day: '.', 자율측정: 2800, 손목: 2300, 근력: 1800 },
        { Day: '.', 자율측정: 3000, 손목: 2400, 근력: 2500 },
        { Day: '2018/01/12', 자율측정: 3200, 손목: 2500, 근력: 2900 },
        { Day: '.', }
    ];

// prepare jqxChart settings
var settings = {
    backgroundColor:'#ededed',
    borderColor: '#eee',
    title: "",
    description: "",
    enableAnimations: true,
    showLegend: false,
    padding: { left: 10, top: 10, right: 15, bottom: 10 },
    titlePadding: { left: 90, top: 0, right: 0, bottom: 10 },
    source: sampleData,
    colorScheme: 'scheme04',
    xAxis: {
        dataField: 'Day',
        unitInterval: 1,
        tickMarks: { visible: true, interval: 1 },
        gridLinesInterval: { visible: true, interval: 1 },
        valuesOnTicks: true,
        padding: { bottom: 10 },
        formatFunction: function (value) {
            if (value == ".") {
                return " ";
            } else {
                return value;
            }
        }
    },
    valueAxis: {
        unitInterval: 1000,
        minValue: 0,
        maxValue: 4000,
        title: { text: '' },
        labels: { 
            horizontalAlignment: 'right',
            formatSettings: { decimalPlaces: 0 },
            formatFunction: function (value, itemIndex, serieIndex, groupIndex) {
                return Math.round(value / 1000) + ' K';
            }

        }
    },
    seriesGroups:
    [
        {
            type: 'line',
            series:
            [
                {
                    dataField: '자율측정',
                    symbolType: '자율측정',
                    labels:
                    {
                        visible: true,
                        backgroundColor: '#FEFEFE',
                        backgroundOpacity: 0.2,
                        borderColor: '#7FC4EF',
                        borderOpacity: 0.7,

                        padding: { left: 5, right: 5, top: 0, bottom: 0 }


                    }
                },
                {
                    dataField: '손목',
                    symbolType: '손목',
                    labels:
                    {
                        visible: true,
                        backgroundColor: '#FEFEFE',
                        backgroundOpacity: 0.2,
                        borderColor: '#7FC4EF',
                        borderOpacity: 0.7,
                        padding: { left: 5, right: 5, top: 0, bottom: 0 }
                    }
                },
                {
                    dataField: '근력',
                    symbolType: '근력',
                    labels:
                    {
                        visible: true,
                        backgroundColor: '#FEFEFE',
                        backgroundOpacity: 0.2,
                        borderColor: '#7FC4EF',
                        borderOpacity: 0.7,
                        padding: { left: 5, right: 5, top: 0, bottom: 0 }
                    }
                }
            ]
        }
    ]
};
// setup the chart
$('#chartContainer').jqxChart(settings);
