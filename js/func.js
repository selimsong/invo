//for color change whem mouse over,out,click
var varOverColor = "#E0E0E0";
var varOutColor = "#eee";
var varSelectedColor = "#DEE2FE";
var headerName = '';//such as 'check' etc.

function moveColor(OBJ){
	divObj = document.getElementById(OBJ.id);
	if(document.getElementById(headerName+OBJ.id).checked == false){
		divObj.style.background = varOverColor;
	}
	else{}
}
function outColor(OBJ){
	divObj = document.getElementById(OBJ.id);
	if(document.getElementById(headerName+OBJ.id).checked == false){
		divObj.style.background = varOutColor;
	}
	else{
		divObj.style.background = selectedColor;
	}
}
function downColor(OBJ){
	divObj = document.getElementById(OBJ.id);
	if(document.getElementById(headerName+OBJ.id).checked == false){
	divObj.style.background = varSelectedColor;
	document.getElementById(headerName+OBJ.id).checked = true;
	}
	else{
	divObj.style.background = varOutColor;
	document.getElementById(headerName+OBJ.id).checked = false;
	}
}
function highLightThis(obj){
	obj.className = "heightLight";
}
function unHighLightThis(obj){
	obj.className = "unHeightLight";
}
function format(value) {
	value +="";
	var offset = value.length % 3;
	var result = value.substring(0, offset);
	for (var i = offset; i < value.length; i += 3 ) {
		if (result.length != 0) {
			result += ",";
		}
		result += value.substring(i, i + 3);
	}
	return result;
}
function isNull(aNode){
	if (aNode==null){return true;}// works in cortona, not in cosmo
	else{
		return false;
	}
}
function get_sqft_rate(country){
	switch(country){
		case "Hong Kong":
			sqft_name = "sqft";
			sqft_rate = "1";
			break;
		case "Japan":
			sqft_name = "Tsubo";
			sqft_rate = "35.6" ;
			break;
		case "Singapore":
			sqft_name = "sqft";
			sqft_rate = "1" ;
			break;
		default:
			sqft_name = "S.M.";
			sqft_rate = "10.76";
			break;		
	}
	return sqft_rate;
}
var secs = 30;
var res = false;
function check_timeout(){ 
	for(var i=secs;i>=0;i--)
	{
		window.setTimeout("doUpdate(" + i + ")", (secs-i) * 60000);
	}

}
function doUpdate(num)
{
	document.getElementById("time_count").innerHTML = num ;
	if (num == 0){
		//timeout_action();
	}
}
function int_float(n){
	if(typeof(n) == "number"){
		n = n.toString();
	}
	var na;
	na = n.split(".");
	return na;
}
function numRemoveComma(n){
	if(typeof(n) == "number"){
		n = n.toString();
	}
	return n.replace(/,/g,"");
}
function numCut(n){ 
	num = parseFloat(n);
	num = (Math.round(num*100))/100;
	return num;
}
function addComma(numberStr)  
  {  
  var   str=numberStr;  
  var   subs=new   Array()  
  var   newStr=""  
  for(var   i=str.length,j=0;i>0;i-=3,j++)    
  subs[j]=str.substring(i,i-3)    
  subs.reverse()  
  for(var   i=0;i<subs.length;i++)    
  newStr+=(i==subs.length-1)?subs[i]:subs[i]+","  
  return   newStr  
}
function numAddComma(n){
	n = numRemoveComma(n);
	var ret
	na = int_float(numCut(n));
	if(typeof(na[1]) == "undefined"){
		ret = addComma(na[0]);
	}
	else{
		ret = addComma(na[0]) + "." + na[1];
		//alert(typeof(ret)+":"+ret);
	}
	return ret;
}
function fields_comma(obj,c){   //selimsong
	/**
	if(c != 110 && c != 190 && obj.value != ""){
		var v;
		v = numRemoveComma(obj.value);
		obj.value = numAddComma(v);
	}
*/
}
function getLength(formName,Max){
	f = true;
	for(i=0;i<formName.length;i++){
		if(formName.elements[i].type == "text" && formName.elements[i].value.length > Max){
			formName.elements[i].style.backgroundColor = "Pink";
			f = false;
		}
	}
	return f;
}
function check_dot(obj){
	str = obj.value;
	if(str.indexOf(".") == -1){
		if(confirm("A valid broker name is firstname.lastname! \nDo you want to add \".\"?")){
			str = str.replace(/\ /g,".");
		}
	}
	obj.value = str;
}
function hideDiv(divname){
	document.getElementById(divname).style.display = "none";
}
function showDiv(divname){
	document.getElementById(divname).style.display = "block";
}
function selectThis(inputName,value,hintDiv){
	document.getElementById(inputName).value = value;
	hideDiv(hintDiv);
}
function set_v(str){
	document.getElementById('Client').value = str;
}
function check_inv_no(a){
	var argvs;
	argvs = 'invoice_no='+a;
	new net.ContentLoader('check_inv_no.php', check_inv_no_return, null, 'POST',  argvs);
}
function check_inv_no_return(){
	if(this.req.responseText != "failed" && this.req.responseText != "Null"){
		document.getElementById('inv_no_check').style.color="red";
		document.getElementById('inv_no_check').innerHTML = "Invoice No exists already! Reference ID: " + this.req.responseText;
	}
	else if(this.req.responseText == "Null"){
		document.getElementById('inv_no_check').innerHTML = "";
	}
	else{
		document.getElementById('inv_no_check').style.color="green";
		document.getElementById('inv_no_check').innerHTML = "It's ok!";
	}
}