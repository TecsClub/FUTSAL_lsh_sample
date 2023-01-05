<?php if(!defined("__XE__"))exit;?><script>
var CALL_AMOUNT_ACCUMULATE = [];
var CALL_AMOUNT_REALTIME = [];
var CHART_DATAS_PREV_DATE = '';
var GRAPH_UPDATE_INTERVAL = 1000; // 5초
function INIT_CHART_DATAS() {
	var CHART_DATAS_CURR_DATE = dateFormat(new Date(), 'yyyy-HH');
//	console.log('CHART_DATAS_PREV_DATE : ' + CHART_DATAS_PREV_DATE + ' .vs. ' + 'CHART_DATAS_CURR_DATE : ' + CHART_DATAS_CURR_DATE );
	if (CHART_DATAS_PREV_DATE == CHART_DATAS_CURR_DATE) {
		if (FLAG_CALL_AMOUNT_WINDOW) {
			setTimeout(function () {
				INIT_CHART_DATAS();
			}, 1000);
		}
		return;
	}
	CHART_DATAS_PREV_DATE = CHART_DATAS_CURR_DATE;
	CALL_AMOUNT_ACCUMULATE = [];
	CALL_AMOUNT_REALTIME = [];
	
	_RS.APP_CONFIG.IVR_SERVER_IPS.forEach(function (ONE_ELEMENT) {
		var ONE_DATA = {
				IVR_SERVER_NAME:	ONE_ELEMENT.SERVER_NAME,
				IVR_SERVER_IP:		ONE_ELEMENT.SERVER_IP,
			};
		var KEY;
		for (var i=0; i<24; i++) {
			KEY = sprintf('T_%02d', i); ONE_DATA[KEY] = 0; //  ONE_DATA[KEY] = Math.floor((Math.random() * 10) + 1);
			KEY = sprintf('C_%02d', i); ONE_DATA[KEY] = 0; //  ONE_DATA[KEY] = Math.floor((Math.random() * 10) + 1);
		}
		CALL_AMOUNT_ACCUMULATE.push(ONE_DATA);
		
		CALL_AMOUNT_REALTIME.push({
			IVR_SERVER_NAME:	ONE_ELEMENT.SERVER_NAME,
			IVR_SERVER_IP:		ONE_ELEMENT.SERVER_IP,
			CALL_TASK:			0,
			CALL_CONNECT:		0
		});
	});
//	console.log(CALL_AMOUNT_REALTIME);
	if (FLAG_CALL_AMOUNT_WINDOW) {
		setTimeout(function () {
			INIT_CHART_DATAS();
		}, 1000);
	}
}
var BACKGROUND_CALL_TASK = '#E00000';
var BACKGROUND_CALL_CONNECT = '#0000E0'
var OBJ_POPUP_CALL_AMOUNT = null;
function INIT_WIDGETS_POPUP_CALL_AMOUNT(OBJ_POPUP) {
	OBJ_POPUP_CALL_AMOUNT = OBJ_POPUP;
    FLAG_CALL_AMOUNT_WINDOW = true;
	
	INIT_CHART_DATAS();
	
    // prepare jqxChart settings_ACCUMULATE
    var settings_ACCUMULATE = {
        title: "IVR 서버별 누적 통화량",
        description: "",
        enableAnimations: false,
        showLegend: false,
        padding: { left: 5, top: 5, right: 5, bottom: 5 },
//		titlePadding: { left: 90, top: 0, right: 0, bottom: 10 },
        source: CALL_AMOUNT_ACCUMULATE,
        xAxis: {
            dataField: 'IVR_SERVER_NAME',
            unitInterval: 1,
            axisSize: 'auto',
            tickMarks: {
                visible: true,
                interval: 1,
                color: '#BCBCBC'
            },
            gridLines: {
                visible: true,
                interval: 1,
                color: '#BCBCBC'
            }
        },
        valueAxis: {
//			maxValue: 120,
			unitInterval: 50,
			minValue: 0,
            title: { text: '통화건 수' },
            labels: { horizontalAlignment: 'right' },
            tickMarks: { color: '#BCBCBC' }
        },
        colorScheme: 'scheme06',
        seriesGroups:[
            {
                type: 'stackedcolumn',
                columnsGapPercent: 50,
                seriesGapPercent: 0,
                series: [
                    { dataField: 'T_00',	displayText: 'T_00', fillColor:	BACKGROUND_CALL_TASK},
                    { dataField: 'C_00',	displayText: 'C_00', fillColor:	BACKGROUND_CALL_CONNECT}
                ]
            },{
                type: 'stackedcolumn',
                columnsGapPercent: 50,
                seriesGapPercent: 0,
                series: [
                    { dataField: 'T_01',	displayText: 'T_01', fillColor:	BACKGROUND_CALL_TASK	},
                    { dataField: 'C_01',	displayText: 'C_01', fillColor:	BACKGROUND_CALL_CONNECT	}
                ]
            },{
                type: 'stackedcolumn',
                columnsGapPercent: 50,
                seriesGapPercent: 0,
                series: [
                    { dataField: 'T_02',	displayText: 'T_02', fillColor:	BACKGROUND_CALL_TASK	},
                    { dataField: 'C_02',	displayText: 'C_02', fillColor:	BACKGROUND_CALL_CONNECT	}
                ]
            },{
                type: 'stackedcolumn',
                columnsGapPercent: 50,
                seriesGapPercent: 0,
                series: [
                    { dataField: 'T_03',	displayText: 'T_03', fillColor:	BACKGROUND_CALL_TASK	},
                    { dataField: 'C_03',	displayText: 'C_03', fillColor:	BACKGROUND_CALL_CONNECT	}
                ]
            },{
                type: 'stackedcolumn',
                columnsGapPercent: 50,
                seriesGapPercent: 0,
                series: [
                    { dataField: 'T_04',	displayText: 'T_04', fillColor:	BACKGROUND_CALL_TASK	},
                    { dataField: 'C_04',	displayText: 'C_04', fillColor:	BACKGROUND_CALL_CONNECT	}
                ]
            },{
                type: 'stackedcolumn',
                columnsGapPercent: 50,
                seriesGapPercent: 0,
                series: [
                    { dataField: 'T_05',	displayText: 'T_05', fillColor:	BACKGROUND_CALL_TASK	},
                    { dataField: 'C_05',	displayText: 'C_05', fillColor:	BACKGROUND_CALL_CONNECT	}
                ]
            },{
                type: 'stackedcolumn',
                columnsGapPercent: 50,
                seriesGapPercent: 0,
                series: [
                    { dataField: 'T_06',	displayText: 'T_06', fillColor:	BACKGROUND_CALL_TASK	},
                    { dataField: 'C_06',	displayText: 'C_06', fillColor:	BACKGROUND_CALL_CONNECT	}
                ]
            },{
                type: 'stackedcolumn',
                columnsGapPercent: 50,
                seriesGapPercent: 0,
                series: [
                    { dataField: 'T_07',	displayText: 'T_07', fillColor:	BACKGROUND_CALL_TASK	},
                    { dataField: 'C_07',	displayText: 'C_07', fillColor:	BACKGROUND_CALL_CONNECT	}
                ]
            },{
                type: 'stackedcolumn',
                columnsGapPercent: 50,
                seriesGapPercent: 0,
                series: [
                    { dataField: 'T_08',	displayText: 'T_08', fillColor:	BACKGROUND_CALL_TASK	},
                    { dataField: 'C_08',	displayText: 'C_08', fillColor:	BACKGROUND_CALL_CONNECT	}
                ]
            },{
                type: 'stackedcolumn',
                columnsGapPercent: 50,
                seriesGapPercent: 0,
                series: [
                    { dataField: 'T_09',	displayText: 'T_09', fillColor:	BACKGROUND_CALL_TASK	},
                    { dataField: 'C_09',	displayText: 'C_09', fillColor:	BACKGROUND_CALL_CONNECT	}
                ]
            },{
                type: 'stackedcolumn',
                columnsGapPercent: 50,
                seriesGapPercent: 0,
                series: [
                    { dataField: 'T_10',	displayText: 'T_10', fillColor:	BACKGROUND_CALL_TASK	},
                    { dataField: 'C_10',	displayText: 'C_10', fillColor:	BACKGROUND_CALL_CONNECT	}
                ]
            },{
                type: 'stackedcolumn',
                columnsGapPercent: 50,
                seriesGapPercent: 0,
                series: [
                    { dataField: 'T_11',	displayText: 'T_11', fillColor:	BACKGROUND_CALL_TASK	},
                    { dataField: 'C_11',	displayText: 'C_11', fillColor:	BACKGROUND_CALL_CONNECT	}
                ]
            },{
                type: 'stackedcolumn',
                columnsGapPercent: 50,
                seriesGapPercent: 0,
                series: [
                    { dataField: 'T_12',	displayText: 'T_12', fillColor:	BACKGROUND_CALL_TASK	},
                    { dataField: 'C_12',	displayText: 'C_12', fillColor:	BACKGROUND_CALL_CONNECT	}
                ]
            },{
                type: 'stackedcolumn',
                columnsGapPercent: 50,
                seriesGapPercent: 0,
                series: [
                    { dataField: 'T_13',	displayText: 'T_13', fillColor:	BACKGROUND_CALL_TASK	},
                    { dataField: 'C_13',	displayText: 'C_13', fillColor:	BACKGROUND_CALL_CONNECT	}
                ]
            },{
                type: 'stackedcolumn',
                columnsGapPercent: 50,
                seriesGapPercent: 0,
                series: [
                    { dataField: 'T_14',	displayText: 'T_14', fillColor:	BACKGROUND_CALL_TASK	},
                    { dataField: 'C_14',	displayText: 'C_14', fillColor:	BACKGROUND_CALL_CONNECT	}
                ]
            },{
                type: 'stackedcolumn',
                columnsGapPercent: 50,
                seriesGapPercent: 0,
                series: [
                    { dataField: 'T_15',	displayText: 'T_15', fillColor:	BACKGROUND_CALL_TASK	},
                    { dataField: 'C_15',	displayText: 'C_15', fillColor:	BACKGROUND_CALL_CONNECT	}
                ]
            },{
                type: 'stackedcolumn',
                columnsGapPercent: 50,
                seriesGapPercent: 0,
                series: [
                    { dataField: 'T_16',	displayText: 'T_16', fillColor:	BACKGROUND_CALL_TASK	},
                    { dataField: 'C_16',	displayText: 'C_16', fillColor:	BACKGROUND_CALL_CONNECT	}
                ]
            },{
                type: 'stackedcolumn',
                columnsGapPercent: 50,
                seriesGapPercent: 0,
                series: [
                    { dataField: 'T_17',	displayText: 'T_17', fillColor:	BACKGROUND_CALL_TASK	},
                    { dataField: 'C_17',	displayText: 'C_17', fillColor:	BACKGROUND_CALL_CONNECT	}
                ]
            },{
                type: 'stackedcolumn',
                columnsGapPercent: 50,
                seriesGapPercent: 0,
                series: [
                    { dataField: 'T_18',	displayText: 'T_18', fillColor:	BACKGROUND_CALL_TASK	},
                    { dataField: 'C_18',	displayText: 'C_18', fillColor:	BACKGROUND_CALL_CONNECT	}
                ]
            },{
                type: 'stackedcolumn',
                columnsGapPercent: 50,
                seriesGapPercent: 0,
                series: [
                    { dataField: 'T_19',	displayText: 'T_19', fillColor:	BACKGROUND_CALL_TASK	},
                    { dataField: 'C_19',	displayText: 'C_19', fillColor:	BACKGROUND_CALL_CONNECT	}
                ]
            },{
                type: 'stackedcolumn',
                columnsGapPercent: 50,
                seriesGapPercent: 0,
                series: [
                    { dataField: 'T_20',	displayText: 'T_20', fillColor:	BACKGROUND_CALL_TASK	},
                    { dataField: 'C_20',	displayText: 'C_20', fillColor:	BACKGROUND_CALL_CONNECT	}
                ]
            },{
                type: 'stackedcolumn',
                columnsGapPercent: 50,
                seriesGapPercent: 0,
                series: [
                    { dataField: 'T_21',	displayText: 'T_21', fillColor:	BACKGROUND_CALL_TASK	},
                    { dataField: 'C_21',	displayText: 'C_21', fillColor:	BACKGROUND_CALL_CONNECT	}
                ]
            },{
                type: 'stackedcolumn',
                columnsGapPercent: 50,
                seriesGapPercent: 0,
                series: [
                    { dataField: 'T_22',	displayText: 'T_22', fillColor:	BACKGROUND_CALL_TASK	},
                    { dataField: 'C_22',	displayText: 'C_22', fillColor:	BACKGROUND_CALL_CONNECT	}
                ]
            },{
                type: 'stackedcolumn',
                columnsGapPercent: 50,
                seriesGapPercent: 0,
                series: [
                    { dataField: 'T_23',	displayText: 'T_23', fillColor:	BACKGROUND_CALL_TASK	},
                    { dataField: 'C_23',	displayText: 'C_23', fillColor:	BACKGROUND_CALL_CONNECT	}
                ]
            }
        ]
    };
    // setup the chart
    $('#IVR_CALL_AMOUNT_ACCUMULATE_chartContainer').jqxChart(settings_ACCUMULATE);
    // prepare jqxChart settings_REALTIME
    var settings_REALTIME = {
        title: "IVR 서버별 실시간 통화량",
        description: "",
        enableAnimations: false,
        showLegend: true,
        padding: { left: 5, top: 5, right: 5, bottom: 5 },
//		titlePadding: { left: 90, top: 0, right: 0, bottom: 10 },
        source: CALL_AMOUNT_REALTIME,
        xAxis: {
            dataField: 'IVR_SERVER_NAME',
            unitInterval: 1,
            axisSize: 'auto',
            tickMarks: {
                visible: true,
                interval: 1,
                color: '#BCBCBC'
            },
            gridLines: {
                visible: true,
                interval: 1,
                color: '#BCBCBC'
            }
        },
        valueAxis: {
//			maxValue: 120,
			unitInterval: 10,
			minValue: 0,
            title: { text: '통화건 수' },
            labels: { horizontalAlignment: 'right' },
            tickMarks: { color: '#BCBCBC' }
        },
        colorScheme: 'scheme06',
        seriesGroups:[
            {
                type: 'stackedcolumn',
                columnsGapPercent: 50,
                seriesGapPercent: 0,
                series: [
                        { dataField: 'CALL_TASK',		displayText: 'CALL_TASK'	, fillColor:	BACKGROUND_CALL_TASK },
                        { dataField: 'CALL_CONNECT',	displayText: 'CALL_CONNECT'	, fillColor:	BACKGROUND_CALL_CONNECT }
                    ]
            }
        ]
    };
    // setup the chart
    $('#IVR_CALL_AMOUNT_REALTIME_chartContainer').jqxChart(settings_REALTIME);
    
    GRAPH_UPDATE();
}
function GRAPH_UPDATE() {
//	console.log('GRAPH_UPDATE()');
	$('#IVR_CALL_AMOUNT_REALTIME_chartContainer').jqxChart('update');
	$('#IVR_CALL_AMOUNT_ACCUMULATE_chartContainer').jqxChart('update');
	if (FLAG_CALL_AMOUNT_WINDOW) {
		setTimeout(function () {
			GRAPH_UPDATE();
			},
			GRAPH_UPDATE_INTERVAL
		);
	}
}
function UPDATE_CALL_AMOUNT_CHART_CHANGE_2_CONNECT(JSON_ARGS) {
//	console.log(JSON.stringify(JSON_ARGS, null, '\t'));
//	console.log(JSON.stringify(CALL_AMOUNT_REALTIME, null, '\t'));
//	console.log(JSON.stringify(CALL_AMOUNT_ACCUMULATE, null, '\t'));
	CALL_AMOUNT_REALTIME.forEach(function (ONE_ELEMENT) {
		if (JSON_ARGS.REMOTE_ADDR == ONE_ELEMENT.IVR_SERVER_IP) {
			ONE_ELEMENT.CALL_CONNECT	+= 1;
			if (ONE_ELEMENT.CALL_TASK > 0) {
				ONE_ELEMENT.CALL_TASK	-= 1;
			}
		}
	});
	CALL_AMOUNT_ACCUMULATE.forEach(function (ONE_ELEMENT) {
		if (JSON_ARGS.REMOTE_ADDR == ONE_ELEMENT.IVR_SERVER_IP) {
			var THIS_TIME = new Date();
			var KEY_T = sprintf("T_%02d", THIS_TIME.getHours());
			var KEY_C = sprintf("C_%02d", THIS_TIME.getHours());
			ONE_ELEMENT[KEY_C]	+= 1;
			if (ONE_ELEMENT[KEY_T] > 0) {
				ONE_ELEMENT[KEY_T]	-= 1;
			}
//			console.log(ONE_ELEMENT);
		}
	});
	
}
function UPDATE_CALL_AMOUNT_CHART_NEW_TASK_OR_CONNECT(JSON_ARGS) {
//	console.log(JSON.stringify(JSON_ARGS, null, '\t'));
//	console.log(JSON.stringify(CALL_AMOUNT_REALTIME, null, '\t'));
//	console.log(JSON.stringify(CALL_AMOUNT_ACCUMULATE, null, '\t'));
	CALL_AMOUNT_REALTIME.forEach(function (ONE_ELEMENT) {
		if (JSON_ARGS.REMOTE_ADDR == ONE_ELEMENT.IVR_SERVER_IP) {
			if (JSON_ARGS.CALL_CONNECT) {
				ONE_ELEMENT.CALL_CONNECT	+= 1;
			} else {
				ONE_ELEMENT.CALL_TASK		+= 1;
			}
		}
	});
	CALL_AMOUNT_ACCUMULATE.forEach(function (ONE_ELEMENT) {
		if (JSON_ARGS.REMOTE_ADDR == ONE_ELEMENT.IVR_SERVER_IP) {
			var THIS_TIME = new Date();
			var KEY_T = sprintf("T_%02d", THIS_TIME.getHours());
			var KEY_C = sprintf("C_%02d", THIS_TIME.getHours());
			if (JSON_ARGS.CALL_CONNECT) {
				ONE_ELEMENT[KEY_C]	+= 1;
			} else {
				ONE_ELEMENT[KEY_T]	+= 1;
			}
//			console.log(ONE_ELEMENT);
		}
	});
}
function UPDATE_CALL_AMOUNT_CHART_REMOVE_TASK(JSON_ARGS) {
//	console.log(JSON_ARGS);
	CALL_AMOUNT_REALTIME.forEach(function (ONE_ELEMENT) {
		if (JSON_ARGS.REMOTE_ADDR == ONE_ELEMENT.IVR_SERVER_IP) {
			if (ONE_ELEMENT.CALL_TASK > 0)	ONE_ELEMENT.CALL_TASK -= 1;
		}
	});
}
function UPDATE_CALL_AMOUNT_CHART_REMOVE_CONNECT(JSON_ARGS) {
//	console.log(JSON_ARGS);
	CALL_AMOUNT_REALTIME.forEach(function (ONE_ELEMENT) {
		if (JSON_ARGS.REMOTE_ADDR == ONE_ELEMENT.IVR_SERVER_IP) {
			if (ONE_ELEMENT.CALL_CONNECT > 0)	ONE_ELEMENT.CALL_CONNECT	-= 1;
		}
	});
}
	
</script>
<div id='IVR_CALL_AMOUNT_REALTIME_chartContainer'   style="box-sizing:border-box; width:100%; height:50%;"/>
<div id='IVR_CALL_AMOUNT_ACCUMULATE_chartContainer' style="box-sizing:border-box; width:100%; height:50%;"/>
