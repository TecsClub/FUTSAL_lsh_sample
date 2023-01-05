class WS2S {
	constructor(WS_SERVER_URL, args_HOST, args_PORT, FUNC_ON_STATUS, FUNC_ON_RECEIVE) {
		this.WS_SERVER_URL	= WS_SERVER_URL;
		this.WS_CHANNEL		= 'ws2s';
		this.INIT_WS2S_CONNECTION(WS_SERVER_URL, args_HOST, args_PORT, FUNC_ON_STATUS, FUNC_ON_RECEIVE);
    }
    
    SEND_2_SOCKET(STR_MESSAGE) {
    	var JSON_MESSAGE = {
    		CONNECTION_ID: this.CONNECTION_ID,
    		METHOD: 'SEND_2_SOCKET',
    		SOCKET_MESSAGE: STR_MESSAGE
    	}
    	this.WS2S_CONNECTION.send(JSON.stringify(JSON_MESSAGE) + '\n');
    }
    
	INIT_WS2S_CONNECTION(WS_SERVER_URL, args_HOST, args_PORT, FUNC_ON_STATUS, FUNC_ON_RECEIVE) {
		var _THIS = this;
	    // if user is running mozilla then use it's built-in WebSocket
	    window.WebSocket = window.WebSocket || window.MozWebSocket;
	  
	    // if browser doesn't support WebSocket, just show some notification and exit
	    if (!window.WebSocket) {
	    	var STR_LOG = '죄송합니다, 접속에 사용하신 웹 브라우저가 WebSockets 기능을 지원하지 않습니다.';
	    	if (FUNC_ON_STATUS != undefined) FUNC_ON_STATUS(STR_LOG);
			return;
	    }

	    // open connection
	    this.WS2S_CONNECTION = new WebSocket(this.WS_SERVER_URL, this.WS_CHANNEL);

	    this.WS2S_CONNECTION.onopen = function () {
	    	var STR_LOG = sprintf( "new WS2S('%s', '%s') 이 연결되었습니다.", _THIS.WS_SERVER_URL, _THIS.WS_CHANNEL);
	    	if (FUNC_ON_STATUS != undefined) FUNC_ON_STATUS(STR_LOG);
	    	this.TCP_CONNECTED = false;
	    };
	    
	    this.WS2S_CONNECTION.onerror = function (error) {
	    	var STR_LOG = 'WS2S 연결에 어떤 문제가 있거나 WS2S 서버가 응답하지 않습니다.';
	    	if (FUNC_ON_STATUS != undefined) FUNC_ON_STATUS(STR_LOG);
	    };

	    // most important part - incoming messages
	    this.WS2S_CONNECTION.onmessage = function (message) {
	        // try to parse JSON message. Because we know that the server always returns
	        // JSON this should work without any problem but we should make sure that
	        // the massage is not chunked or otherwise damaged.
	        try {
	          var JSON_PARSED = JSON.parse(message.data);
	        } catch (e) {
		    	var STR_LOG = 'WS2S_CONNECTION : 이건 JSON 스트링이 아닌것 같아요! : ' + message.data;
		    	if (FUNC_ON_STATUS != undefined) FUNC_ON_STATUS(STR_LOG);
				return;
	        }

	        // NOTE: if you're not sure about the JSON structure
	        // check the server source code above
	        if ('CONNECTION_ID' in JSON_PARSED) {
				_THIS.CONNECTION_ID = JSON_PARSED.CONNECTION_ID;
				if (!_THIS.TCP_CONNECTED) {
					_THIS.TCP_CONNECTED = true;
			    	var JSON_MESSAGE = {
			    		CONNECTION_ID: _THIS.CONNECTION_ID,
			    		METHOD: 'TCP_CONNECT',
			    		PARAMS: {
			    			HOST: args_HOST,
			    			PORT: args_PORT
			    		}
			    	}
			    	_THIS.WS2S_CONNECTION.send(JSON.stringify(JSON_MESSAGE) + '\n');
				}
				if ('SOCKET_MESSAGE' in JSON_PARSED) {

			        try {
			          	var JSON_PARSED = JSON.parse(JSON_PARSED.SOCKET_MESSAGE);

				        if ('CONNECTION_ID' in JSON_PARSED) {
							if (_THIS.SOCKET_CONNECTION_ID == undefined) {
					        	_THIS.SOCKET_CONNECTION_ID = JSON_PARSED.CONNECTION_ID;
						    	var STR_LOG = sprintf( "SOCKET('%s', '%s') 이 연결되었습니다.", args_HOST, args_PORT);
			    		    	if (FUNC_ON_STATUS != undefined) FUNC_ON_STATUS(STR_LOG);
							}
				        }
			        } catch (e) {
				    	var STR_LOG = 'WS2S_CONNECTION.SOCKET_MESSAGE 이건 JSON 스트링이 아닌것 같아요! : ' + JSON_PARSED.SOCKET_MESSAGE;
				    	if (FUNC_ON_STATUS != undefined) FUNC_ON_STATUS(STR_LOG);
						return;
			        }
			        
			        if (FUNC_ON_RECEIVE != undefined) FUNC_ON_RECEIVE(JSON_PARSED);
			        
				}
	        }
	    };

	    this.WS2S_CONNECTION.onclose  = function () {
	    	_THIS.TCP_CONNECTED = false;
	    	var STR_LOG = 'WS2S 연결이 끊어졌습니다. 1초 이내에 WS2S 연결을 재시도 합니다.';
	    	if (FUNC_ON_STATUS != undefined) FUNC_ON_STATUS(STR_LOG);
			//try to reconnect in 5 seconds
			setTimeout(function(){_THIS.INIT_WS2S_CONNECTION(WS_SERVER_URL, args_HOST, args_PORT, FUNC_ON_STATUS, FUNC_ON_RECEIVE);}, 1000);
	    };
		
    }
}
