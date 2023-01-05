const player	= require('node-wav-player');
const BME280	= require('bme280-sensor');
const Gpio		= require('onoff').Gpio;
const MOTION	= new Gpio(27, 'in', 'rising', {debounceTimeout: 10});
const GAS		= new Gpio(17, 'in', 'falling', {debounceTimeout: 10});
const LED_LIGHT	= new Gpio(22, 'out');

const request	= require('request');
const ip		= require('ip');


var REPORT_URL							= 'http://gl.1key.kr';
var readSensorData_PERIOD = 2500;
var THRESHOLD_HTTP_REPORT_Temperature	= 31.0;
var PERIOD_HTTP_REPORT_Temperature		= 15;
var PERIOD_HTTP_REPORT_Gas				= 15;
var PERIOD_HTTP_REPORT_Motion			= 15;
var PERIOD_LED_LIGHT_Duration			= 15;

var ALERT_SMS = {
	ALERT_Temperature : {
		SMS_TO: '01077743438',
		SMS_MSG : '그린라인 감지장치 과열상태!\nhttp://gl.1key.kr'
	},
	ALERT_Gas : {
		SMS_TO: '01077743438',
		SMS_MSG : '그린라인 감지장치 유해가스 감지!\nhttp://gl.1key.kr'
	},
	ALERT_Motion : {
		SMS_TO: '01077743438',
		SMS_MSG : '그린라인 감지장치 움직임 감지!\nhttp://gl.1key.kr'
	}
};

var NOW = new Date();

var NEXT_TIME_HTTP_REPORT_Temperature	= NOW.getTime() + 1000 * PERIOD_HTTP_REPORT_Temperature;
var NEXT_TIME_HTTP_REPORT_Gas			= NOW.getTime() + 1000 * PERIOD_HTTP_REPORT_Gas;
var NEXT_TIME_HTTP_REPORT_Motion		= NOW.getTime() + 1000 * PERIOD_HTTP_REPORT_Motion;

const SOUND_PLAY = (formData) => {
	var SOUND_FILE_PATH = '';
	if (formData.EVENT == 'DUMMY') {
	} else if (formData.EVENT == 'REPORT_Temperature') {
		SOUND_FILE_PATH = "REPORT_Temperature.wav";
	} else if (formData.EVENT == 'DETECT_MOTION') {
		SOUND_FILE_PATH = "DETECT_MOTION.wav";
	} else if (formData.EVENT == 'DETECT_GAS') {
		SOUND_FILE_PATH = "DETECT_GAS.wav";
	}
	
	if (SOUND_FILE_PATH.length > 0) {
		player.play({
		  path: SOUND_FILE_PATH,
		}).then(() => {
	//	  console.log('The wav file started to be played successfully.');
		}).catch((error) => {
	//	  console.error(error);
		});
	}
}

const HTTP_REPORT = (formData) => {
	SOUND_PLAY(formData);
	request.post({
	  url: REPORT_URL,
	  method: 'POST',
	  formData: formData,
	}, function callback(err, httpResponse, body) {
      console.log(body);
	});
}

const CONTROL_LED_LIGHT = (ON_OFF) => {
	if (ON_OFF) {
		LED_LIGHT.writeSync(1);
	} else {
		LED_LIGHT.writeSync(0);
	}
	setTimeout(function () {
		LED_LIGHT.writeSync(0);
		LED_LIGHT.unexport();
	}, PERIOD_LED_LIGHT_Duration * 1000);
}

// The BME280 constructor options are optional.
// 
const bme280 = new BME280({
	i2cBusNo   : 1,		// defaults to 1
	i2cAddress : 0x76	// BME280.BME280_DEFAULT_I2C_ADDRESS() // defaults to 0x77
});

// Read BME280 sensor data, repeat
//
const readSensorData = () => {
  bme280.readSensorData()
    .then((data) => {
		// temperature_C, pressure_hPa, and humidity are returned by default.
//		console.log(`data = ${JSON.stringify(data, null, 2)}`);
		if (data.temperature_C > THRESHOLD_HTTP_REPORT_Temperature) {
			if (NEXT_TIME_HTTP_REPORT_Temperature < new Date().getTime()) {
				data.REQ		= 'api_GreenLine';
				data.EVENT		= 'REPORT_Temperature';
				data.LOCAL_ADDR	= ip.address();
				data.ALERT_SMS_TO	= ALERT_SMS.ALERT_Temperature.SMS_TO;
				data.ALERT_SMS_MSG	= ALERT_SMS.ALERT_Temperature.SMS_MSG;
			  	HTTP_REPORT(data);
			  	NEXT_TIME_HTTP_REPORT_Temperature	= new Date().getTime() + 1000 * PERIOD_HTTP_REPORT_Temperature;
		      	CONTROL_LED_LIGHT(true);
			}
		}
		setTimeout(readSensorData, readSensorData_PERIOD);
    })
    .catch((err) => {
		console.log(`BME280 read error: ${err}`);
		setTimeout(readSensorData, readSensorData_PERIOD);
    });
};

// Initialize the BME280 sensor
//
bme280.init()
	.then(() => {
		console.log('BME280 initialization succeeded');
		readSensorData();
		CONTROL_LED_LIGHT(false);
	})
	.catch((err) => console.error(`BME280 initialization failed: ${err} `));

MOTION.watch((err, value) => {
	if (err) { throw err; }
//	console.log('DETECT_MOTION!', );
  	if (NEXT_TIME_HTTP_REPORT_Motion < new Date().getTime()) {
		HTTP_REPORT({
      		REQ: 'api_GreenLine',
      		EVENT: 'DETECT_MOTION',
      		LOCAL_ADDR: ip.address(),
      		ALERT_SMS_TO: ALERT_SMS.ALERT_Motion.SMS_TO,
      		ALERT_SMS_MSG: ALERT_SMS.ALERT_Motion.SMS_MSG,
		});
      	NEXT_TIME_HTTP_REPORT_Motion	= new Date().getTime() + 1000 * PERIOD_HTTP_REPORT_Motion;
      	CONTROL_LED_LIGHT(true);
  	}
});

GAS.watch((err, value) => {
	if (err) { throw err; }
//	console.log('DETECT_GAS!', );
  	if (NEXT_TIME_HTTP_REPORT_Gas < new Date().getTime()) {
		HTTP_REPORT({
      		REQ: 'api_GreenLine',
      		EVENT: 'DETECT_GAS',
      		LOCAL_ADDR: ip.address(),
      		ALERT_SMS_TO: ALERT_SMS.ALERT_Gas.SMS_TO,
      		ALERT_SMS_MSG: ALERT_SMS.ALERT_Gas.SMS_MSG,
		});
      	NEXT_TIME_HTTP_REPORT_Gas	= new Date().getTime() + 1000 * PERIOD_HTTP_REPORT_Gas;
      	CONTROL_LED_LIGHT(true);
  	}
});

process.on('SIGINT', _ => {
	MOTION.unexport();
	GAS.unexport();
});

