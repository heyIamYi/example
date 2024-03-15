function editFun(obj){
	var defValue=fieldName='';
	// console.log(obj);
	// var str='name';
	// alert(obj[str][2]);
	// alert(obj['name'][2]);
	// alert(obj.name[2]);
	$(':input').each(function (){
		defValue='';
		fieldName=$(this).attr('name');
		if(fieldName){
		// 陣列
		if(fieldName.indexOf("[")>0) {
			// console.log(fieldName+' -> ');
			var tempName=fieldName.substr(0,fieldName.indexOf("["));
			var tempKey=fieldName.substring(fieldName.indexOf("[")+1,fieldName.length-1);
			if(obj[tempName] && obj[tempName][tempKey]) defValue=obj[tempName][tempKey];
			// console.log(tempName+' '+tempKey);
			// console.log(defValue);
		}
		else defValue=obj[fieldName];
		if(defValue){
			switch($(this).attr('type')){
				case 'file'		:
								break;
				case 'checkbox'	:
								if(defValue>0)
									$(this).attr('checked','checked');
								break;
				case 'radio'	:
								$("input[name='"+fieldName+"'][value="+defValue+"]").attr("checked",true);
								// $("input[@name="+fieldName+"][@value="+obj[fieldName]+"]").attr("checked",true);
								break;
				default			:
								$(this).val(defValue);
								break;
			}
		}
		}
	})
}
