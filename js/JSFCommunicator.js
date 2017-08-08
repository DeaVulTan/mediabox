/* =========================================================================

CLASS: JSFCommunicator
AUTHOR: Abdul Qabiz 
DATE  : 12/13/2003

COMMENT: Communicates with Flash in different ways. It can
			- get a flash variable
			- set a flash variable
			- 



METHODS:
	- setVariable(propName,propValue)
	- getVariable(propName)
	- callFunction(fnLocation, fnName, fnArgs);



USAGE: 
//create an instance of JSFCommunicator, pass reference of flashMovie's
var fc = new JSFCommunicator(flashMovie);
//to set a variable, call JSFlashCommunicator's setVariable function
fc.setVariable("name","Abdul");

fc.callFunction("_root","setInfo",["Abdul",22]); //setInfo function accepts two args
fc.callFunction("_root.box_mc","gotoAndPlay",[2]);

REVISION HISTORY:-
	- Jan 22-04	undefined is turned to "undefined"
	- Jan 22-04	fnArgs is now type checked
	- Jan 22-04	comma-delimted string is no more passed to flash, instead $@$$ delimited session is flash.
	- Jan 22-04	instanceof operator has been removed and typeof() is used instead.
	
============================================================================ */

/**
 * @constructor JSFCommunicator
 * @param flashMovie:Refrence to activeX or Plugin
 * @description This is constructor function of JSFCommunicator class
 *
*/

function JSFCommunicator(flashMovie)
{	
	this.init(flashMovie);
}

/**
 * @method init()
 * @param flashMovie:Reference to ActiveX or Plugin object
 * @return none
 * @description initializes all variables for communication
 * @author Abdul Qabiz
 * @data Dec 12, 2003
*/
JSFCommunicator.prototype.init = function(flashMovie) {

	if(flashMovie=="undefined") {
		var flashMovie = null;
	 }
	this.setMovie(flashMovie);
	this.functionToCall = null;
	this.functionLocationinFlash = null;
	this.functionArgs = null;
}


/**
 * @method setMovie(flashMovie)
 * @param flashMovie:Reference to ActiveX or Plugin object
 * @return none
 * @description initializes all variables for communication
 * @author Abdul Qabiz
 * @data Dec 12, 2003
*/

JSFCommunicator.prototype.setMovie = function(flashMovie)
{
	this.flashMovie = flashMovie;
}


/**
 * @method setVariable(propName,propValue)
 * @param propName:String, variable name in flash to be set.
 * @param propValue:any primitive type
 * @return none
 * @description Sets a variable in flash
 * @author Abdul Qabiz
 * @data Dec 12, 2003
*/
JSFCommunicator.prototype.setVariable  = function(propName, propValue) {
	this.flashMovie.SetVariable(propName,propValue);
}



/**
 * @method getVariable(propName)
 * @param propName:String, variable name in flash
 * @return Any primitive value
 * @description Gets a specified properties value from flash
 * @author Abdul Qabiz
 * @data Dec 12, 2003
*/
JSFCommunicator.prototype.getVariable  = function(propName) {

	var result = this.flashMovie.GetVariable(propName);
	return result;
}


/**
 * @method callFunction(fnLocation,fnName, fnArgs)
 * @param fnLocation:String, funtion's parent objects path in flash. e.g. _root or _level0 or _level0.my_mc etc
 * @param fnName:String, name of flash function be executed
 * @param fnArgs:Array, parameters to be passed to flash function. only primitive data can be passed
 * @return Boolean, depending upon the success or failure of the call made
 * @description calls a specified flash function from javascript
 * @author Abdul Qabiz
 * @data Dec 12, 2003
*/
JSFCommunicator.prototype.callFunction = function(fnLocation,fnName,fnArgs) {

	if(this.flashMovie==null) {	return false; }
	
//	get the current value of triggerFn from flash
	var flag = this.getVariable("/:triggerFn");
	var result = false;

//	if no function name passed, return false
	if(fnName=="") {return false; }
//	if 	fnLocation is not proper, set it to _level0 as default
	if(fnLocation=="") {
		var fnLocation = "_level0";
	}

	this.setVariable("/:fnLocation",fnLocation);
	this.setVariable("/:fnName",fnName);
	
//	check if fnArgs is an array
	if(typeof(fnArgs)=="object") {
//		convert it to $@$$-delemited string and pass to flash
		this.setVariable("/:fnArgs",fnArgs.join("$@$$"));
	}else if(typeof(fnArgs)=="number" || typeof(fnArgs)=="string") {
		this.setVariable("/:fnArgs",fnArgs);
	}
	
//	change triggerFn property in flash which being watched
	this.setVariable("/:triggerFn",!flag);

//	check if function in flash called successfully or not.
	result = this.getVariable("triggerFnStatus");
	
//	set triggerFnStatus false again.
	this.setVariable("/:triggerFnStatus",false);

//	return result of call.
	return result;

	
}

//======================================================
