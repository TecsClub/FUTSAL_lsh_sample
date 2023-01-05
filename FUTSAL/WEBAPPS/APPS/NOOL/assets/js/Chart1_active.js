/* ��Ʈ1 Ȱ���� */
var sampleData = [
        { Day: '.', ��������: 1500, �ո�: 1100, �ٷ�: 1000 },
        { Day: '2018/01/08', ��������: 2800, �ո�: 2300, �ٷ�: 1800 },
        { Day: '.', ��������: 2500, �ո�: 2000, �ٷ�: 1200 },
        { Day: '.', ��������: 2800, �ո�: 2300, �ٷ�: 1800 },
        { Day: '.', ��������: 3000, �ո�: 2400, �ٷ�: 2500 },
        { Day: '2018/01/12', ��������: 3200, �ո�: 2500, �ٷ�: 2900 },
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
                    dataField: '��������',
                    symbolType: '��������',
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
                    dataField: '�ո�',
                    symbolType: '�ո�',
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
                    dataField: '�ٷ�',
                    symbolType: '�ٷ�',
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
