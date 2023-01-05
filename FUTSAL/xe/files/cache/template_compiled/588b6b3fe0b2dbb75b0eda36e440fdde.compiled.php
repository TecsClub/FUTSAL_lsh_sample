<?php if(!defined("__XE__"))exit;?><script>
	var POPUP_USER_SELECT = null;
	function INIT_WIDGETS_FOR_POPUP_USER_SELECT(args_POPUP){
		POPUP_USER_SELECT = args_POPUP;
		var source = [];
        ALL_USER_DATA.forEach(function (ONE_USER) {
        	if ('NOOL_NAME' in ONE_USER.data.META) {
        		if (USER_DATA.ID != ONE_USER.ID) {
		        	source.push({
		        		ID: ONE_USER.data.ID,
		        		HTML: ONE_USER.data.META.NOOL_NAME[0] + " " + ONE_USER.data.META.NOOL_BIRTH[0]
		        	});
        		}
        	} else {
	        	source.push({
	        		HTML: 'NO META DATA'
	        	});
        	}
        });
        
        // Create a jqxDropDownList
        $("#USER_SELECT_DROP").jqxDropDownList({
        	source: source, selectedIndex: 0, width: '250', height: '35px',
        	displayMember: 'HTML'
        });
        $('#BTN_USER_SELECT').on('click', function () {
        	var sel_index = $("#USER_SELECT_DROP").jqxDropDownList('getSelectedIndex');
        	USER_DATA_FOR_CONTENT = ALL_USER_DATA[sel_index];
        	LOAD_MOTION_DATA();
        	
        	
        });
	}
</script>
<style>
	.left_con{
		background-color: #555;
	}
	.right_con{
		background-color: #555;
	}
</style>
<div id="USER_SELECT_DROP" style="text-align:center; margin:0 auto;">
</div>
<button id="BTN_USER_SELECT" class="btn btn-default BTN_POPUP" style="display: block;margin: 2% auto;background-color: #333;color: #fff;font-weight: 500; box-shadow: none;">선택</button>