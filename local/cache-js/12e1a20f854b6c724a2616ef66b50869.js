/* compact [
	../prive/javascript/jquery.js
	../prive/javascript/jquery.form.js
	../prive/javascript/jquery.autosave.js
	../prive/javascript/jquery.placeholder-label.js
	../prive/javascript/ajaxCallback.js
	../prive/javascript/jquery.colors.js
	../prive/javascript/jquery.cookie.js
	../prive/javascript/spip_barre.js
	../prive/javascript/layer.js
	../prive/javascript/presentation.js
	../prive/javascript/gadgets.js
	../plugins-dist/mediabox/javascript/jquery.colorbox.js?1407942352
	../plugins-dist/mediabox/javascript/spip.mediabox.js?1407942352
	../plugins-dist/porte_plume/javascript/jquery.markitup_pour_spip.js
	../plugins-dist/porte_plume/javascript/jquery.previsu_spip.js
	page=porte_plume_start.js(lang=fr)
	../plugins-dist/porte_plume/javascript/porte_plume_forcer_hauteur.js
] 59.9% */

/* ../prive/javascript/jquery.js */

(function(window,undefined){
var document=window.document,
navigator=window.navigator,
location=window.location;
var jQuery=(function(){
var jQuery=function(selector,context){
return new jQuery.fn.init(selector,context,rootjQuery);
},
_jQuery=window.jQuery,
_$=window.$,
rootjQuery,
quickExpr=/^(?:[^#<]*(<[\w\W]+>)[^>]*$|#([\w\-]*)$)/,
rnotwhite=/\S/,
trimLeft=/^\s+/,
trimRight=/\s+$/,
rsingleTag=/^<(\w+)\s*\/?>(?:<\/\1>)?$/,
rvalidchars=/^[\],:{}\s]*$/,
rvalidescape=/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g,
rvalidtokens=/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,
rvalidbraces=/(?:^|:|,)(?:\s*\[)+/g,
rwebkit=/(webkit)[ \/]([\w.]+)/,
ropera=/(opera)(?:.*version)?[ \/]([\w.]+)/,
rmsie=/(msie) ([\w.]+)/,
rmozilla=/(mozilla)(?:.*? rv:([\w.]+))?/,
rdashAlpha=/-([a-z]|[0-9])/ig,
rmsPrefix=/^-ms-/,
fcamelCase=function(all,letter){
return(letter+"").toUpperCase();
},
userAgent=navigator.userAgent,
browserMatch,
readyList,
DOMContentLoaded,
toString=Object.prototype.toString,
hasOwn=Object.prototype.hasOwnProperty,
push=Array.prototype.push,
slice=Array.prototype.slice,
trim=String.prototype.trim,
indexOf=Array.prototype.indexOf,
class2type={};
jQuery.fn=jQuery.prototype={
constructor:jQuery,
init:function(selector,context,rootjQuery){
var match,elem,ret,doc;
if(!selector){
return this;
}
if(selector.nodeType){
this.context=this[0]=selector;
this.length=1;
return this;
}
if(selector==="body"&&!context&&document.body){
this.context=document;
this[0]=document.body;
this.selector=selector;
this.length=1;
return this;
}
if(typeof selector==="string"){
if(selector.charAt(0)==="<"&&selector.charAt(selector.length-1)===">"&&selector.length>=3){
match=[null,selector,null];
}else{
match=quickExpr.exec(selector);
}
if(match&&(match[1]||!context)){
if(match[1]){
context=context instanceof jQuery?context[0]:context;
doc=(context?context.ownerDocument||context:document);
ret=rsingleTag.exec(selector);
if(ret){
if(jQuery.isPlainObject(context)){
selector=[document.createElement(ret[1])];
jQuery.fn.attr.call(selector,context,true);
}else{
selector=[doc.createElement(ret[1])];
}
}else{
ret=jQuery.buildFragment([match[1]],[doc]);
selector=(ret.cacheable?jQuery.clone(ret.fragment):ret.fragment).childNodes;
}
return jQuery.merge(this,selector);
}else{
elem=document.getElementById(match[2]);
if(elem&&elem.parentNode){
if(elem.id!==match[2]){
return rootjQuery.find(selector);
}
this.length=1;
this[0]=elem;
}
this.context=document;
this.selector=selector;
return this;
}
}else if(!context||context.jquery){
return(context||rootjQuery).find(selector);
}else{
return this.constructor(context).find(selector);
}
}else if(jQuery.isFunction(selector)){
return rootjQuery.ready(selector);
}
if(selector.selector!==undefined){
this.selector=selector.selector;
this.context=selector.context;
}
return jQuery.makeArray(selector,this);
},
selector:"",
jquery:"1.7.2",
length:0,
size:function(){
return this.length;
},
toArray:function(){
return slice.call(this,0);
},
get:function(num){
return num==null?
this.toArray():
(num<0?this[this.length+num]:this[num]);
},
pushStack:function(elems,name,selector){
var ret=this.constructor();
if(jQuery.isArray(elems)){
push.apply(ret,elems);
}else{
jQuery.merge(ret,elems);
}
ret.prevObject=this;
ret.context=this.context;
if(name==="find"){
ret.selector=this.selector+(this.selector?" ":"")+selector;
}else if(name){
ret.selector=this.selector+"."+name+"("+selector+")";
}
return ret;
},
each:function(callback,args){
return jQuery.each(this,callback,args);
},
ready:function(fn){
jQuery.bindReady();
readyList.add(fn);
return this;
},
eq:function(i){
i=+i;
return i===-1?
this.slice(i):
this.slice(i,i+1);
},
first:function(){
return this.eq(0);
},
last:function(){
return this.eq(-1);
},
slice:function(){
return this.pushStack(slice.apply(this,arguments),
"slice",slice.call(arguments).join(","));
},
map:function(callback){
return this.pushStack(jQuery.map(this,function(elem,i){
return callback.call(elem,i,elem);
}));
},
end:function(){
return this.prevObject||this.constructor(null);
},
push:push,
sort:[].sort,
splice:[].splice
};
jQuery.fn.init.prototype=jQuery.fn;
jQuery.extend=jQuery.fn.extend=function(){
var options,name,src,copy,copyIsArray,clone,
target=arguments[0]||{},
i=1,
length=arguments.length,
deep=false;
if(typeof target==="boolean"){
deep=target;
target=arguments[1]||{};
i=2;
}
if(typeof target!=="object"&&!jQuery.isFunction(target)){
target={};
}
if(length===i){
target=this;
--i;
}
for(;i<length;i++){
if((options=arguments[i])!=null){
for(name in options){
src=target[name];
copy=options[name];
if(target===copy){
continue;
}
if(deep&&copy&&(jQuery.isPlainObject(copy)||(copyIsArray=jQuery.isArray(copy)))){
if(copyIsArray){
copyIsArray=false;
clone=src&&jQuery.isArray(src)?src:[];
}else{
clone=src&&jQuery.isPlainObject(src)?src:{};
}
target[name]=jQuery.extend(deep,clone,copy);
}else if(copy!==undefined){
target[name]=copy;
}
}
}
}
return target;
};
jQuery.extend({
noConflict:function(deep){
if(window.$===jQuery){
window.$=_$;
}
if(deep&&window.jQuery===jQuery){
window.jQuery=_jQuery;
}
return jQuery;
},
isReady:false,
readyWait:1,
holdReady:function(hold){
if(hold){
jQuery.readyWait++;
}else{
jQuery.ready(true);
}
},
ready:function(wait){
if((wait===true&&!--jQuery.readyWait)||(wait!==true&&!jQuery.isReady)){
if(!document.body){
return setTimeout(jQuery.ready,1);
}
jQuery.isReady=true;
if(wait!==true&&--jQuery.readyWait>0){
return;
}
readyList.fireWith(document,[jQuery]);
if(jQuery.fn.trigger){
jQuery(document).trigger("ready").off("ready");
}
}
},
bindReady:function(){
if(readyList){
return;
}
readyList=jQuery.Callbacks("once memory");
if(document.readyState==="complete"){
return setTimeout(jQuery.ready,1);
}
if(document.addEventListener){
document.addEventListener("DOMContentLoaded",DOMContentLoaded,false);
window.addEventListener("load",jQuery.ready,false);
}else if(document.attachEvent){
document.attachEvent("onreadystatechange",DOMContentLoaded);
window.attachEvent("onload",jQuery.ready);
var toplevel=false;
try{
toplevel=window.frameElement==null;
}catch(e){}
if(document.documentElement.doScroll&&toplevel){
doScrollCheck();
}
}
},
isFunction:function(obj){
return jQuery.type(obj)==="function";
},
isArray:Array.isArray||function(obj){
return jQuery.type(obj)==="array";
},
isWindow:function(obj){
return obj!=null&&obj==obj.window;
},
isNumeric:function(obj){
return!isNaN(parseFloat(obj))&&isFinite(obj);
},
type:function(obj){
return obj==null?
String(obj):
class2type[toString.call(obj)]||"object";
},
isPlainObject:function(obj){
if(!obj||jQuery.type(obj)!=="object"||obj.nodeType||jQuery.isWindow(obj)){
return false;
}
try{
if(obj.constructor&&
!hasOwn.call(obj,"constructor")&&
!hasOwn.call(obj.constructor.prototype,"isPrototypeOf")){
return false;
}
}catch(e){
return false;
}
var key;
for(key in obj){}
return key===undefined||hasOwn.call(obj,key);
},
isEmptyObject:function(obj){
for(var name in obj){
return false;
}
return true;
},
error:function(msg){
throw new Error(msg);
},
parseJSON:function(data){
if(typeof data!=="string"||!data){
return null;
}
data=jQuery.trim(data);
if(window.JSON&&window.JSON.parse){
return window.JSON.parse(data);
}
if(rvalidchars.test(data.replace(rvalidescape,"@")
.replace(rvalidtokens,"]")
.replace(rvalidbraces,""))){
return(new Function("return "+data))();
}
jQuery.error("Invalid JSON: "+data);
},
parseXML:function(data){
if(typeof data!=="string"||!data){
return null;
}
var xml,tmp;
try{
if(window.DOMParser){
tmp=new DOMParser();
xml=tmp.parseFromString(data,"text/xml");
}else{
xml=new ActiveXObject("Microsoft.XMLDOM");
xml.async="false";
xml.loadXML(data);
}
}catch(e){
xml=undefined;
}
if(!xml||!xml.documentElement||xml.getElementsByTagName("parsererror").length){
jQuery.error("Invalid XML: "+data);
}
return xml;
},
noop:function(){},
globalEval:function(data){
if(data&&rnotwhite.test(data)){
(window.execScript||function(data){
window["eval"].call(window,data);
})(data);
}
},
camelCase:function(string){
return string.replace(rmsPrefix,"ms-").replace(rdashAlpha,fcamelCase);
},
nodeName:function(elem,name){
return elem.nodeName&&elem.nodeName.toUpperCase()===name.toUpperCase();
},
each:function(object,callback,args){
var name,i=0,
length=object.length,
isObj=length===undefined||jQuery.isFunction(object);
if(args){
if(isObj){
for(name in object){
if(callback.apply(object[name],args)===false){
break;
}
}
}else{
for(;i<length;){
if(callback.apply(object[i++],args)===false){
break;
}
}
}
}else{
if(isObj){
for(name in object){
if(callback.call(object[name],name,object[name])===false){
break;
}
}
}else{
for(;i<length;){
if(callback.call(object[i],i,object[i++])===false){
break;
}
}
}
}
return object;
},
trim:trim?
function(text){
return text==null?
"":
trim.call(text);
}:
function(text){
return text==null?
"":
text.toString().replace(trimLeft,"").replace(trimRight,"");
},
makeArray:function(array,results){
var ret=results||[];
if(array!=null){
var type=jQuery.type(array);
if(array.length==null||type==="string"||type==="function"||type==="regexp"||jQuery.isWindow(array)){
push.call(ret,array);
}else{
jQuery.merge(ret,array);
}
}
return ret;
},
inArray:function(elem,array,i){
var len;
if(array){
if(indexOf){
return indexOf.call(array,elem,i);
}
len=array.length;
i=i?i<0?Math.max(0,len+i):i:0;
for(;i<len;i++){
if(i in array&&array[i]===elem){
return i;
}
}
}
return-1;
},
merge:function(first,second){
var i=first.length,
j=0;
if(typeof second.length==="number"){
for(var l=second.length;j<l;j++){
first[i++]=second[j];
}
}else{
while(second[j]!==undefined){
first[i++]=second[j++];
}
}
first.length=i;
return first;
},
grep:function(elems,callback,inv){
var ret=[],retVal;
inv=!!inv;
for(var i=0,length=elems.length;i<length;i++){
retVal=!!callback(elems[i],i);
if(inv!==retVal){
ret.push(elems[i]);
}
}
return ret;
},
map:function(elems,callback,arg){
var value,key,ret=[],
i=0,
length=elems.length,
isArray=elems instanceof jQuery||length!==undefined&&typeof length==="number"&&((length>0&&elems[0]&&elems[length-1])||length===0||jQuery.isArray(elems));
if(isArray){
for(;i<length;i++){
value=callback(elems[i],i,arg);
if(value!=null){
ret[ret.length]=value;
}
}
}else{
for(key in elems){
value=callback(elems[key],key,arg);
if(value!=null){
ret[ret.length]=value;
}
}
}
return ret.concat.apply([],ret);
},
guid:1,
proxy:function(fn,context){
if(typeof context==="string"){
var tmp=fn[context];
context=fn;
fn=tmp;
}
if(!jQuery.isFunction(fn)){
return undefined;
}
var args=slice.call(arguments,2),
proxy=function(){
return fn.apply(context,args.concat(slice.call(arguments)));
};
proxy.guid=fn.guid=fn.guid||proxy.guid||jQuery.guid++;
return proxy;
},
access:function(elems,fn,key,value,chainable,emptyGet,pass){
var exec,
bulk=key==null,
i=0,
length=elems.length;
if(key&&typeof key==="object"){
for(i in key){
jQuery.access(elems,fn,i,key[i],1,emptyGet,value);
}
chainable=1;
}else if(value!==undefined){
exec=pass===undefined&&jQuery.isFunction(value);
if(bulk){
if(exec){
exec=fn;
fn=function(elem,key,value){
return exec.call(jQuery(elem),value);
};
}else{
fn.call(elems,value);
fn=null;
}
}
if(fn){
for(;i<length;i++){
fn(elems[i],key,exec?value.call(elems[i],i,fn(elems[i],key)):value,pass);
}
}
chainable=1;
}
return chainable?
elems:
bulk?
fn.call(elems):
length?fn(elems[0],key):emptyGet;
},
now:function(){
return(new Date()).getTime();
},
uaMatch:function(ua){
ua=ua.toLowerCase();
var match=rwebkit.exec(ua)||
ropera.exec(ua)||
rmsie.exec(ua)||
ua.indexOf("compatible")<0&&rmozilla.exec(ua)||
[];
return{browser:match[1]||"",version:match[2]||"0"};
},
sub:function(){
function jQuerySub(selector,context){
return new jQuerySub.fn.init(selector,context);
}
jQuery.extend(true,jQuerySub,this);
jQuerySub.superclass=this;
jQuerySub.fn=jQuerySub.prototype=this();
jQuerySub.fn.constructor=jQuerySub;
jQuerySub.sub=this.sub;
jQuerySub.fn.init=function init(selector,context){
if(context&&context instanceof jQuery&&!(context instanceof jQuerySub)){
context=jQuerySub(context);
}
return jQuery.fn.init.call(this,selector,context,rootjQuerySub);
};
jQuerySub.fn.init.prototype=jQuerySub.fn;
var rootjQuerySub=jQuerySub(document);
return jQuerySub;
},
browser:{}
});
jQuery.each("Boolean Number String Function Array Date RegExp Object".split(" "),function(i,name){
class2type["[object "+name+"]"]=name.toLowerCase();
});
browserMatch=jQuery.uaMatch(userAgent);
if(browserMatch.browser){
jQuery.browser[browserMatch.browser]=true;
jQuery.browser.version=browserMatch.version;
}
if(jQuery.browser.webkit){
jQuery.browser.safari=true;
}
if(rnotwhite.test("\xA0")){
trimLeft=/^[\s\xA0]+/;
trimRight=/[\s\xA0]+$/;
}
rootjQuery=jQuery(document);
if(document.addEventListener){
DOMContentLoaded=function(){
document.removeEventListener("DOMContentLoaded",DOMContentLoaded,false);
jQuery.ready();
};
}else if(document.attachEvent){
DOMContentLoaded=function(){
if(document.readyState==="complete"){
document.detachEvent("onreadystatechange",DOMContentLoaded);
jQuery.ready();
}
};
}
function doScrollCheck(){
if(jQuery.isReady){
return;
}
try{
document.documentElement.doScroll("left");
}catch(e){
setTimeout(doScrollCheck,1);
return;
}
jQuery.ready();
}
return jQuery;
})();
var flagsCache={};
function createFlags(flags){
var object=flagsCache[flags]={},
i,length;
flags=flags.split(/\s+/);
for(i=0,length=flags.length;i<length;i++){
object[flags[i]]=true;
}
return object;
}
jQuery.Callbacks=function(flags){
flags=flags?(flagsCache[flags]||createFlags(flags)):{};
var
list=[],
stack=[],
memory,
fired,
firing,
firingStart,
firingLength,
firingIndex,
add=function(args){
var i,
length,
elem,
type,
actual;
for(i=0,length=args.length;i<length;i++){
elem=args[i];
type=jQuery.type(elem);
if(type==="array"){
add(elem);
}else if(type==="function"){
if(!flags.unique||!self.has(elem)){
list.push(elem);
}
}
}
},
fire=function(context,args){
args=args||[];
memory=!flags.memory||[context,args];
fired=true;
firing=true;
firingIndex=firingStart||0;
firingStart=0;
firingLength=list.length;
for(;list&&firingIndex<firingLength;firingIndex++){
if(list[firingIndex].apply(context,args)===false&&flags.stopOnFalse){
memory=true;
break;
}
}
firing=false;
if(list){
if(!flags.once){
if(stack&&stack.length){
memory=stack.shift();
self.fireWith(memory[0],memory[1]);
}
}else if(memory===true){
self.disable();
}else{
list=[];
}
}
},
self={
add:function(){
if(list){
var length=list.length;
add(arguments);
if(firing){
firingLength=list.length;
}else if(memory&&memory!==true){
firingStart=length;
fire(memory[0],memory[1]);
}
}
return this;
},
remove:function(){
if(list){
var args=arguments,
argIndex=0,
argLength=args.length;
for(;argIndex<argLength;argIndex++){
for(var i=0;i<list.length;i++){
if(args[argIndex]===list[i]){
if(firing){
if(i<=firingLength){
firingLength--;
if(i<=firingIndex){
firingIndex--;
}
}
}
list.splice(i--,1);
if(flags.unique){
break;
}
}
}
}
}
return this;
},
has:function(fn){
if(list){
var i=0,
length=list.length;
for(;i<length;i++){
if(fn===list[i]){
return true;
}
}
}
return false;
},
empty:function(){
list=[];
return this;
},
disable:function(){
list=stack=memory=undefined;
return this;
},
disabled:function(){
return!list;
},
lock:function(){
stack=undefined;
if(!memory||memory===true){
self.disable();
}
return this;
},
locked:function(){
return!stack;
},
fireWith:function(context,args){
if(stack){
if(firing){
if(!flags.once){
stack.push([context,args]);
}
}else if(!(flags.once&&memory)){
fire(context,args);
}
}
return this;
},
fire:function(){
self.fireWith(this,arguments);
return this;
},
fired:function(){
return!!fired;
}
};
return self;
};
var
sliceDeferred=[].slice;
jQuery.extend({
Deferred:function(func){
var doneList=jQuery.Callbacks("once memory"),
failList=jQuery.Callbacks("once memory"),
progressList=jQuery.Callbacks("memory"),
state="pending",
lists={
resolve:doneList,
reject:failList,
notify:progressList
},
promise={
done:doneList.add,
fail:failList.add,
progress:progressList.add,
state:function(){
return state;
},
isResolved:doneList.fired,
isRejected:failList.fired,
then:function(doneCallbacks,failCallbacks,progressCallbacks){
deferred.done(doneCallbacks).fail(failCallbacks).progress(progressCallbacks);
return this;
},
always:function(){
deferred.done.apply(deferred,arguments).fail.apply(deferred,arguments);
return this;
},
pipe:function(fnDone,fnFail,fnProgress){
return jQuery.Deferred(function(newDefer){
jQuery.each({
done:[fnDone,"resolve"],
fail:[fnFail,"reject"],
progress:[fnProgress,"notify"]
},function(handler,data){
var fn=data[0],
action=data[1],
returned;
if(jQuery.isFunction(fn)){
deferred[handler](function(){
returned=fn.apply(this,arguments);
if(returned&&jQuery.isFunction(returned.promise)){
returned.promise().then(newDefer.resolve,newDefer.reject,newDefer.notify);
}else{
newDefer[action+"With"](this===deferred?newDefer:this,[returned]);
}
});
}else{
deferred[handler](newDefer[action]);
}
});
}).promise();
},
promise:function(obj){
if(obj==null){
obj=promise;
}else{
for(var key in promise){
obj[key]=promise[key];
}
}
return obj;
}
},
deferred=promise.promise({}),
key;
for(key in lists){
deferred[key]=lists[key].fire;
deferred[key+"With"]=lists[key].fireWith;
}
deferred.done(function(){
state="resolved";
},failList.disable,progressList.lock).fail(function(){
state="rejected";
},doneList.disable,progressList.lock);
if(func){
func.call(deferred,deferred);
}
return deferred;
},
when:function(firstParam){
var args=sliceDeferred.call(arguments,0),
i=0,
length=args.length,
pValues=new Array(length),
count=length,
pCount=length,
deferred=length<=1&&firstParam&&jQuery.isFunction(firstParam.promise)?
firstParam:
jQuery.Deferred(),
promise=deferred.promise();
function resolveFunc(i){
return function(value){
args[i]=arguments.length>1?sliceDeferred.call(arguments,0):value;
if(!(--count)){
deferred.resolveWith(deferred,args);
}
};
}
function progressFunc(i){
return function(value){
pValues[i]=arguments.length>1?sliceDeferred.call(arguments,0):value;
deferred.notifyWith(promise,pValues);
};
}
if(length>1){
for(;i<length;i++){
if(args[i]&&args[i].promise&&jQuery.isFunction(args[i].promise)){
args[i].promise().then(resolveFunc(i),deferred.reject,progressFunc(i));
}else{
--count;
}
}
if(!count){
deferred.resolveWith(deferred,args);
}
}else if(deferred!==firstParam){
deferred.resolveWith(deferred,length?[firstParam]:[]);
}
return promise;
}
});
jQuery.support=(function(){
var support,
all,
a,
select,
opt,
input,
fragment,
tds,
events,
eventName,
i,
isSupported,
div=document.createElement("div"),
documentElement=document.documentElement;
div.setAttribute("className","t");
div.innerHTML="   <link/><table></table><a href='/a' style='top:1px;float:left;opacity:.55;'>a</a><input type='checkbox'/>";
all=div.getElementsByTagName("*");
a=div.getElementsByTagName("a")[0];
if(!all||!all.length||!a){
return{};
}
select=document.createElement("select");
opt=select.appendChild(document.createElement("option"));
input=div.getElementsByTagName("input")[0];
support={
leadingWhitespace:(div.firstChild.nodeType===3),
tbody:!div.getElementsByTagName("tbody").length,
htmlSerialize:!!div.getElementsByTagName("link").length,
style:/top/.test(a.getAttribute("style")),
hrefNormalized:(a.getAttribute("href")==="/a"),
opacity:/^0.55/.test(a.style.opacity),
cssFloat:!!a.style.cssFloat,
checkOn:(input.value==="on"),
optSelected:opt.selected,
getSetAttribute:div.className!=="t",
enctype:!!document.createElement("form").enctype,
html5Clone:document.createElement("nav").cloneNode(true).outerHTML!=="<:nav></:nav>",
submitBubbles:true,
changeBubbles:true,
focusinBubbles:false,
deleteExpando:true,
noCloneEvent:true,
inlineBlockNeedsLayout:false,
shrinkWrapBlocks:false,
reliableMarginRight:true,
pixelMargin:true
};
jQuery.boxModel=support.boxModel=(document.compatMode==="CSS1Compat");
input.checked=true;
support.noCloneChecked=input.cloneNode(true).checked;
select.disabled=true;
support.optDisabled=!opt.disabled;
try{
delete div.test;
}catch(e){
support.deleteExpando=false;
}
if(!div.addEventListener&&div.attachEvent&&div.fireEvent){
div.attachEvent("onclick",function(){
support.noCloneEvent=false;
});
div.cloneNode(true).fireEvent("onclick");
}
input=document.createElement("input");
input.value="t";
input.setAttribute("type","radio");
support.radioValue=input.value==="t";
input.setAttribute("checked","checked");
input.setAttribute("name","t");
div.appendChild(input);
fragment=document.createDocumentFragment();
fragment.appendChild(div.lastChild);
support.checkClone=fragment.cloneNode(true).cloneNode(true).lastChild.checked;
support.appendChecked=input.checked;
fragment.removeChild(input);
fragment.appendChild(div);
if(div.attachEvent){
for(i in{
submit:1,
change:1,
focusin:1
}){
eventName="on"+i;
isSupported=(eventName in div);
if(!isSupported){
div.setAttribute(eventName,"return;");
isSupported=(typeof div[eventName]==="function");
}
support[i+"Bubbles"]=isSupported;
}
}
fragment.removeChild(div);
fragment=select=opt=div=input=null;
jQuery(function(){
var container,outer,inner,table,td,offsetSupport,
marginDiv,conMarginTop,style,html,positionTopLeftWidthHeight,
paddingMarginBorderVisibility,paddingMarginBorder,
body=document.getElementsByTagName("body")[0];
if(!body){
return;
}
conMarginTop=1;
paddingMarginBorder="padding:0;margin:0;border:";
positionTopLeftWidthHeight="position:absolute;top:0;left:0;width:1px;height:1px;";
paddingMarginBorderVisibility=paddingMarginBorder+"0;visibility:hidden;";
style="style='"+positionTopLeftWidthHeight+paddingMarginBorder+"5px solid #000;";
html="<div "+style+"display:block;'><div style='"+paddingMarginBorder+"0;display:block;overflow:hidden;'></div></div>"+
"<table "+style+"' cellpadding='0' cellspacing='0'>"+
"<tr><td></td></tr></table>";
container=document.createElement("div");
container.style.cssText=paddingMarginBorderVisibility+"width:0;height:0;position:static;top:0;margin-top:"+conMarginTop+"px";
body.insertBefore(container,body.firstChild);
div=document.createElement("div");
container.appendChild(div);
div.innerHTML="<table><tr><td style='"+paddingMarginBorder+"0;display:none'></td><td>t</td></tr></table>";
tds=div.getElementsByTagName("td");
isSupported=(tds[0].offsetHeight===0);
tds[0].style.display="";
tds[1].style.display="none";
support.reliableHiddenOffsets=isSupported&&(tds[0].offsetHeight===0);
if(window.getComputedStyle){
div.innerHTML="";
marginDiv=document.createElement("div");
marginDiv.style.width="0";
marginDiv.style.marginRight="0";
div.style.width="2px";
div.appendChild(marginDiv);
support.reliableMarginRight=
(parseInt((window.getComputedStyle(marginDiv,null)||{marginRight:0}).marginRight,10)||0)===0;
}
if(typeof div.style.zoom!=="undefined"){
div.innerHTML="";
div.style.width=div.style.padding="1px";
div.style.border=0;
div.style.overflow="hidden";
div.style.display="inline";
div.style.zoom=1;
support.inlineBlockNeedsLayout=(div.offsetWidth===3);
div.style.display="block";
div.style.overflow="visible";
div.innerHTML="<div style='width:5px;'></div>";
support.shrinkWrapBlocks=(div.offsetWidth!==3);
}
div.style.cssText=positionTopLeftWidthHeight+paddingMarginBorderVisibility;
div.innerHTML=html;
outer=div.firstChild;
inner=outer.firstChild;
td=outer.nextSibling.firstChild.firstChild;
offsetSupport={
doesNotAddBorder:(inner.offsetTop!==5),
doesAddBorderForTableAndCells:(td.offsetTop===5)
};
inner.style.position="fixed";
inner.style.top="20px";
offsetSupport.fixedPosition=(inner.offsetTop===20||inner.offsetTop===15);
inner.style.position=inner.style.top="";
outer.style.overflow="hidden";
outer.style.position="relative";
offsetSupport.subtractsBorderForOverflowNotVisible=(inner.offsetTop===-5);
offsetSupport.doesNotIncludeMarginInBodyOffset=(body.offsetTop!==conMarginTop);
if(window.getComputedStyle){
div.style.marginTop="1%";
support.pixelMargin=(window.getComputedStyle(div,null)||{marginTop:0}).marginTop!=="1%";
}
if(typeof container.style.zoom!=="undefined"){
container.style.zoom=1;
}
body.removeChild(container);
marginDiv=div=container=null;
jQuery.extend(support,offsetSupport);
});
return support;
})();
var rbrace=/^(?:\{.*\}|\[.*\])$/,
rmultiDash=/([A-Z])/g;
jQuery.extend({
cache:{},
uuid:0,
expando:"jQuery"+(jQuery.fn.jquery+Math.random()).replace(/\D/g,""),
noData:{
"embed":true,
"object":"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000",
"applet":true
},
hasData:function(elem){
elem=elem.nodeType?jQuery.cache[elem[jQuery.expando]]:elem[jQuery.expando];
return!!elem&&!isEmptyDataObject(elem);
},
data:function(elem,name,data,pvt){
if(!jQuery.acceptData(elem)){
return;
}
var privateCache,thisCache,ret,
internalKey=jQuery.expando,
getByName=typeof name==="string",
isNode=elem.nodeType,
cache=isNode?jQuery.cache:elem,
id=isNode?elem[internalKey]:elem[internalKey]&&internalKey,
isEvents=name==="events";
if((!id||!cache[id]||(!isEvents&&!pvt&&!cache[id].data))&&getByName&&data===undefined){
return;
}
if(!id){
if(isNode){
elem[internalKey]=id=++jQuery.uuid;
}else{
id=internalKey;
}
}
if(!cache[id]){
cache[id]={};
if(!isNode){
cache[id].toJSON=jQuery.noop;
}
}
if(typeof name==="object"||typeof name==="function"){
if(pvt){
cache[id]=jQuery.extend(cache[id],name);
}else{
cache[id].data=jQuery.extend(cache[id].data,name);
}
}
privateCache=thisCache=cache[id];
if(!pvt){
if(!thisCache.data){
thisCache.data={};
}
thisCache=thisCache.data;
}
if(data!==undefined){
thisCache[jQuery.camelCase(name)]=data;
}
if(isEvents&&!thisCache[name]){
return privateCache.events;
}
if(getByName){
ret=thisCache[name];
if(ret==null){
ret=thisCache[jQuery.camelCase(name)];
}
}else{
ret=thisCache;
}
return ret;
},
removeData:function(elem,name,pvt){
if(!jQuery.acceptData(elem)){
return;
}
var thisCache,i,l,
internalKey=jQuery.expando,
isNode=elem.nodeType,
cache=isNode?jQuery.cache:elem,
id=isNode?elem[internalKey]:internalKey;
if(!cache[id]){
return;
}
if(name){
thisCache=pvt?cache[id]:cache[id].data;
if(thisCache){
if(!jQuery.isArray(name)){
if(name in thisCache){
name=[name];
}else{
name=jQuery.camelCase(name);
if(name in thisCache){
name=[name];
}else{
name=name.split(" ");
}
}
}
for(i=0,l=name.length;i<l;i++){
delete thisCache[name[i]];
}
if(!(pvt?isEmptyDataObject:jQuery.isEmptyObject)(thisCache)){
return;
}
}
}
if(!pvt){
delete cache[id].data;
if(!isEmptyDataObject(cache[id])){
return;
}
}
if(jQuery.support.deleteExpando||!cache.setInterval){
delete cache[id];
}else{
cache[id]=null;
}
if(isNode){
if(jQuery.support.deleteExpando){
delete elem[internalKey];
}else if(elem.removeAttribute){
elem.removeAttribute(internalKey);
}else{
elem[internalKey]=null;
}
}
},
_data:function(elem,name,data){
return jQuery.data(elem,name,data,true);
},
acceptData:function(elem){
if(elem.nodeName){
var match=jQuery.noData[elem.nodeName.toLowerCase()];
if(match){
return!(match===true||elem.getAttribute("classid")!==match);
}
}
return true;
}
});
jQuery.fn.extend({
data:function(key,value){
var parts,part,attr,name,l,
elem=this[0],
i=0,
data=null;
if(key===undefined){
if(this.length){
data=jQuery.data(elem);
if(elem.nodeType===1&&!jQuery._data(elem,"parsedAttrs")){
attr=elem.attributes;
for(l=attr.length;i<l;i++){
name=attr[i].name;
if(name.indexOf("data-")===0){
name=jQuery.camelCase(name.substring(5));
dataAttr(elem,name,data[name]);
}
}
jQuery._data(elem,"parsedAttrs",true);
}
}
return data;
}
if(typeof key==="object"){
return this.each(function(){
jQuery.data(this,key);
});
}
parts=key.split(".",2);
parts[1]=parts[1]?"."+parts[1]:"";
part=parts[1]+"!";
return jQuery.access(this,function(value){
if(value===undefined){
data=this.triggerHandler("getData"+part,[parts[0]]);
if(data===undefined&&elem){
data=jQuery.data(elem,key);
data=dataAttr(elem,key,data);
}
return data===undefined&&parts[1]?
this.data(parts[0]):
data;
}
parts[1]=value;
this.each(function(){
var self=jQuery(this);
self.triggerHandler("setData"+part,parts);
jQuery.data(this,key,value);
self.triggerHandler("changeData"+part,parts);
});
},null,value,arguments.length>1,null,false);
},
removeData:function(key){
return this.each(function(){
jQuery.removeData(this,key);
});
}
});
function dataAttr(elem,key,data){
if(data===undefined&&elem.nodeType===1){
var name="data-"+key.replace(rmultiDash,"-$1").toLowerCase();
data=elem.getAttribute(name);
if(typeof data==="string"){
try{
data=data==="true"?true:
data==="false"?false:
data==="null"?null:
jQuery.isNumeric(data)?+data:
rbrace.test(data)?jQuery.parseJSON(data):
data;
}catch(e){}
jQuery.data(elem,key,data);
}else{
data=undefined;
}
}
return data;
}
function isEmptyDataObject(obj){
for(var name in obj){
if(name==="data"&&jQuery.isEmptyObject(obj[name])){
continue;
}
if(name!=="toJSON"){
return false;
}
}
return true;
}
function handleQueueMarkDefer(elem,type,src){
var deferDataKey=type+"defer",
queueDataKey=type+"queue",
markDataKey=type+"mark",
defer=jQuery._data(elem,deferDataKey);
if(defer&&
(src==="queue"||!jQuery._data(elem,queueDataKey))&&
(src==="mark"||!jQuery._data(elem,markDataKey))){
setTimeout(function(){
if(!jQuery._data(elem,queueDataKey)&&
!jQuery._data(elem,markDataKey)){
jQuery.removeData(elem,deferDataKey,true);
defer.fire();
}
},0);
}
}
jQuery.extend({
_mark:function(elem,type){
if(elem){
type=(type||"fx")+"mark";
jQuery._data(elem,type,(jQuery._data(elem,type)||0)+1);
}
},
_unmark:function(force,elem,type){
if(force!==true){
type=elem;
elem=force;
force=false;
}
if(elem){
type=type||"fx";
var key=type+"mark",
count=force?0:((jQuery._data(elem,key)||1)-1);
if(count){
jQuery._data(elem,key,count);
}else{
jQuery.removeData(elem,key,true);
handleQueueMarkDefer(elem,type,"mark");
}
}
},
queue:function(elem,type,data){
var q;
if(elem){
type=(type||"fx")+"queue";
q=jQuery._data(elem,type);
if(data){
if(!q||jQuery.isArray(data)){
q=jQuery._data(elem,type,jQuery.makeArray(data));
}else{
q.push(data);
}
}
return q||[];
}
},
dequeue:function(elem,type){
type=type||"fx";
var queue=jQuery.queue(elem,type),
fn=queue.shift(),
hooks={};
if(fn==="inprogress"){
fn=queue.shift();
}
if(fn){
if(type==="fx"){
queue.unshift("inprogress");
}
jQuery._data(elem,type+".run",hooks);
fn.call(elem,function(){
jQuery.dequeue(elem,type);
},hooks);
}
if(!queue.length){
jQuery.removeData(elem,type+"queue "+type+".run",true);
handleQueueMarkDefer(elem,type,"queue");
}
}
});
jQuery.fn.extend({
queue:function(type,data){
var setter=2;
if(typeof type!=="string"){
data=type;
type="fx";
setter--;
}
if(arguments.length<setter){
return jQuery.queue(this[0],type);
}
return data===undefined?
this:
this.each(function(){
var queue=jQuery.queue(this,type,data);
if(type==="fx"&&queue[0]!=="inprogress"){
jQuery.dequeue(this,type);
}
});
},
dequeue:function(type){
return this.each(function(){
jQuery.dequeue(this,type);
});
},
delay:function(time,type){
time=jQuery.fx?jQuery.fx.speeds[time]||time:time;
type=type||"fx";
return this.queue(type,function(next,hooks){
var timeout=setTimeout(next,time);
hooks.stop=function(){
clearTimeout(timeout);
};
});
},
clearQueue:function(type){
return this.queue(type||"fx",[]);
},
promise:function(type,object){
if(typeof type!=="string"){
object=type;
type=undefined;
}
type=type||"fx";
var defer=jQuery.Deferred(),
elements=this,
i=elements.length,
count=1,
deferDataKey=type+"defer",
queueDataKey=type+"queue",
markDataKey=type+"mark",
tmp;
function resolve(){
if(!(--count)){
defer.resolveWith(elements,[elements]);
}
}
while(i--){
if((tmp=jQuery.data(elements[i],deferDataKey,undefined,true)||
(jQuery.data(elements[i],queueDataKey,undefined,true)||
jQuery.data(elements[i],markDataKey,undefined,true))&&
jQuery.data(elements[i],deferDataKey,jQuery.Callbacks("once memory"),true))){
count++;
tmp.add(resolve);
}
}
resolve();
return defer.promise(object);
}
});
var rclass=/[\n\t\r]/g,
rspace=/\s+/,
rreturn=/\r/g,
rtype=/^(?:button|input)$/i,
rfocusable=/^(?:button|input|object|select|textarea)$/i,
rclickable=/^a(?:rea)?$/i,
rboolean=/^(?:autofocus|autoplay|async|checked|controls|defer|disabled|hidden|loop|multiple|open|readonly|required|scoped|selected)$/i,
getSetAttribute=jQuery.support.getSetAttribute,
nodeHook,boolHook,fixSpecified;
jQuery.fn.extend({
attr:function(name,value){
return jQuery.access(this,jQuery.attr,name,value,arguments.length>1);
},
removeAttr:function(name){
return this.each(function(){
jQuery.removeAttr(this,name);
});
},
prop:function(name,value){
return jQuery.access(this,jQuery.prop,name,value,arguments.length>1);
},
removeProp:function(name){
name=jQuery.propFix[name]||name;
return this.each(function(){
try{
this[name]=undefined;
delete this[name];
}catch(e){}
});
},
addClass:function(value){
var classNames,i,l,elem,
setClass,c,cl;
if(jQuery.isFunction(value)){
return this.each(function(j){
jQuery(this).addClass(value.call(this,j,this.className));
});
}
if(value&&typeof value==="string"){
classNames=value.split(rspace);
for(i=0,l=this.length;i<l;i++){
elem=this[i];
if(elem.nodeType===1){
if(!elem.className&&classNames.length===1){
elem.className=value;
}else{
setClass=" "+elem.className+" ";
for(c=0,cl=classNames.length;c<cl;c++){
if(!~setClass.indexOf(" "+classNames[c]+" ")){
setClass+=classNames[c]+" ";
}
}
elem.className=jQuery.trim(setClass);
}
}
}
}
return this;
},
removeClass:function(value){
var classNames,i,l,elem,className,c,cl;
if(jQuery.isFunction(value)){
return this.each(function(j){
jQuery(this).removeClass(value.call(this,j,this.className));
});
}
if((value&&typeof value==="string")||value===undefined){
classNames=(value||"").split(rspace);
for(i=0,l=this.length;i<l;i++){
elem=this[i];
if(elem.nodeType===1&&elem.className){
if(value){
className=(" "+elem.className+" ").replace(rclass," ");
for(c=0,cl=classNames.length;c<cl;c++){
className=className.replace(" "+classNames[c]+" "," ");
}
elem.className=jQuery.trim(className);
}else{
elem.className="";
}
}
}
}
return this;
},
toggleClass:function(value,stateVal){
var type=typeof value,
isBool=typeof stateVal==="boolean";
if(jQuery.isFunction(value)){
return this.each(function(i){
jQuery(this).toggleClass(value.call(this,i,this.className,stateVal),stateVal);
});
}
return this.each(function(){
if(type==="string"){
var className,
i=0,
self=jQuery(this),
state=stateVal,
classNames=value.split(rspace);
while((className=classNames[i++])){
state=isBool?state:!self.hasClass(className);
self[state?"addClass":"removeClass"](className);
}
}else if(type==="undefined"||type==="boolean"){
if(this.className){
jQuery._data(this,"__className__",this.className);
}
this.className=this.className||value===false?"":jQuery._data(this,"__className__")||"";
}
});
},
hasClass:function(selector){
var className=" "+selector+" ",
i=0,
l=this.length;
for(;i<l;i++){
if(this[i].nodeType===1&&(" "+this[i].className+" ").replace(rclass," ").indexOf(className)>-1){
return true;
}
}
return false;
},
val:function(value){
var hooks,ret,isFunction,
elem=this[0];
if(!arguments.length){
if(elem){
hooks=jQuery.valHooks[elem.type]||jQuery.valHooks[elem.nodeName.toLowerCase()];
if(hooks&&"get"in hooks&&(ret=hooks.get(elem,"value"))!==undefined){
return ret;
}
ret=elem.value;
return typeof ret==="string"?
ret.replace(rreturn,""):
ret==null?"":ret;
}
return;
}
isFunction=jQuery.isFunction(value);
return this.each(function(i){
var self=jQuery(this),val;
if(this.nodeType!==1){
return;
}
if(isFunction){
val=value.call(this,i,self.val());
}else{
val=value;
}
if(val==null){
val="";
}else if(typeof val==="number"){
val+="";
}else if(jQuery.isArray(val)){
val=jQuery.map(val,function(value){
return value==null?"":value+"";
});
}
hooks=jQuery.valHooks[this.type]||jQuery.valHooks[this.nodeName.toLowerCase()];
if(!hooks||!("set"in hooks)||hooks.set(this,val,"value")===undefined){
this.value=val;
}
});
}
});
jQuery.extend({
valHooks:{
option:{
get:function(elem){
var val=elem.attributes.value;
return!val||val.specified?elem.value:elem.text;
}
},
select:{
get:function(elem){
var value,i,max,option,
index=elem.selectedIndex,
values=[],
options=elem.options,
one=elem.type==="select-one";
if(index<0){
return null;
}
i=one?index:0;
max=one?index+1:options.length;
for(;i<max;i++){
option=options[i];
if(option.selected&&(jQuery.support.optDisabled?!option.disabled:option.getAttribute("disabled")===null)&&
(!option.parentNode.disabled||!jQuery.nodeName(option.parentNode,"optgroup"))){
value=jQuery(option).val();
if(one){
return value;
}
values.push(value);
}
}
if(one&&!values.length&&options.length){
return jQuery(options[index]).val();
}
return values;
},
set:function(elem,value){
var values=jQuery.makeArray(value);
jQuery(elem).find("option").each(function(){
this.selected=jQuery.inArray(jQuery(this).val(),values)>=0;
});
if(!values.length){
elem.selectedIndex=-1;
}
return values;
}
}
},
attrFn:{
val:true,
css:true,
html:true,
text:true,
data:true,
width:true,
height:true,
offset:true
},
attr:function(elem,name,value,pass){
var ret,hooks,notxml,
nType=elem.nodeType;
if(!elem||nType===3||nType===8||nType===2){
return;
}
if(pass&&name in jQuery.attrFn){
return jQuery(elem)[name](value);
}
if(typeof elem.getAttribute==="undefined"){
return jQuery.prop(elem,name,value);
}
notxml=nType!==1||!jQuery.isXMLDoc(elem);
if(notxml){
name=name.toLowerCase();
hooks=jQuery.attrHooks[name]||(rboolean.test(name)?boolHook:nodeHook);
}
if(value!==undefined){
if(value===null){
jQuery.removeAttr(elem,name);
return;
}else if(hooks&&"set"in hooks&&notxml&&(ret=hooks.set(elem,value,name))!==undefined){
return ret;
}else{
elem.setAttribute(name,""+value);
return value;
}
}else if(hooks&&"get"in hooks&&notxml&&(ret=hooks.get(elem,name))!==null){
return ret;
}else{
ret=elem.getAttribute(name);
return ret===null?
undefined:
ret;
}
},
removeAttr:function(elem,value){
var propName,attrNames,name,l,isBool,
i=0;
if(value&&elem.nodeType===1){
attrNames=value.toLowerCase().split(rspace);
l=attrNames.length;
for(;i<l;i++){
name=attrNames[i];
if(name){
propName=jQuery.propFix[name]||name;
isBool=rboolean.test(name);
if(!isBool){
jQuery.attr(elem,name,"");
}
elem.removeAttribute(getSetAttribute?name:propName);
if(isBool&&propName in elem){
elem[propName]=false;
}
}
}
}
},
attrHooks:{
type:{
set:function(elem,value){
if(rtype.test(elem.nodeName)&&elem.parentNode){
jQuery.error("type property can't be changed");
}else if(!jQuery.support.radioValue&&value==="radio"&&jQuery.nodeName(elem,"input")){
var val=elem.value;
elem.setAttribute("type",value);
if(val){
elem.value=val;
}
return value;
}
}
},
value:{
get:function(elem,name){
if(nodeHook&&jQuery.nodeName(elem,"button")){
return nodeHook.get(elem,name);
}
return name in elem?
elem.value:
null;
},
set:function(elem,value,name){
if(nodeHook&&jQuery.nodeName(elem,"button")){
return nodeHook.set(elem,value,name);
}
elem.value=value;
}
}
},
propFix:{
tabindex:"tabIndex",
readonly:"readOnly",
"for":"htmlFor",
"class":"className",
maxlength:"maxLength",
cellspacing:"cellSpacing",
cellpadding:"cellPadding",
rowspan:"rowSpan",
colspan:"colSpan",
usemap:"useMap",
frameborder:"frameBorder",
contenteditable:"contentEditable"
},
prop:function(elem,name,value){
var ret,hooks,notxml,
nType=elem.nodeType;
if(!elem||nType===3||nType===8||nType===2){
return;
}
notxml=nType!==1||!jQuery.isXMLDoc(elem);
if(notxml){
name=jQuery.propFix[name]||name;
hooks=jQuery.propHooks[name];
}
if(value!==undefined){
if(hooks&&"set"in hooks&&(ret=hooks.set(elem,value,name))!==undefined){
return ret;
}else{
return(elem[name]=value);
}
}else{
if(hooks&&"get"in hooks&&(ret=hooks.get(elem,name))!==null){
return ret;
}else{
return elem[name];
}
}
},
propHooks:{
tabIndex:{
get:function(elem){
var attributeNode=elem.getAttributeNode("tabindex");
return attributeNode&&attributeNode.specified?
parseInt(attributeNode.value,10):
rfocusable.test(elem.nodeName)||rclickable.test(elem.nodeName)&&elem.href?
0:
undefined;
}
}
}
});
jQuery.attrHooks.tabindex=jQuery.propHooks.tabIndex;
boolHook={
get:function(elem,name){
var attrNode,
property=jQuery.prop(elem,name);
return property===true||typeof property!=="boolean"&&(attrNode=elem.getAttributeNode(name))&&attrNode.nodeValue!==false?
name.toLowerCase():
undefined;
},
set:function(elem,value,name){
var propName;
if(value===false){
jQuery.removeAttr(elem,name);
}else{
propName=jQuery.propFix[name]||name;
if(propName in elem){
elem[propName]=true;
}
elem.setAttribute(name,name.toLowerCase());
}
return name;
}
};
if(!getSetAttribute){
fixSpecified={
name:true,
id:true,
coords:true
};
nodeHook=jQuery.valHooks.button={
get:function(elem,name){
var ret;
ret=elem.getAttributeNode(name);
return ret&&(fixSpecified[name]?ret.nodeValue!=="":ret.specified)?
ret.nodeValue:
undefined;
},
set:function(elem,value,name){
var ret=elem.getAttributeNode(name);
if(!ret){
ret=document.createAttribute(name);
elem.setAttributeNode(ret);
}
return(ret.nodeValue=value+"");
}
};
jQuery.attrHooks.tabindex.set=nodeHook.set;
jQuery.each(["width","height"],function(i,name){
jQuery.attrHooks[name]=jQuery.extend(jQuery.attrHooks[name],{
set:function(elem,value){
if(value===""){
elem.setAttribute(name,"auto");
return value;
}
}
});
});
jQuery.attrHooks.contenteditable={
get:nodeHook.get,
set:function(elem,value,name){
if(value===""){
value="false";
}
nodeHook.set(elem,value,name);
}
};
}
if(!jQuery.support.hrefNormalized){
jQuery.each(["href","src","width","height"],function(i,name){
jQuery.attrHooks[name]=jQuery.extend(jQuery.attrHooks[name],{
get:function(elem){
var ret=elem.getAttribute(name,2);
return ret===null?undefined:ret;
}
});
});
}
if(!jQuery.support.style){
jQuery.attrHooks.style={
get:function(elem){
return elem.style.cssText.toLowerCase()||undefined;
},
set:function(elem,value){
return(elem.style.cssText=""+value);
}
};
}
if(!jQuery.support.optSelected){
jQuery.propHooks.selected=jQuery.extend(jQuery.propHooks.selected,{
get:function(elem){
var parent=elem.parentNode;
if(parent){
parent.selectedIndex;
if(parent.parentNode){
parent.parentNode.selectedIndex;
}
}
return null;
}
});
}
if(!jQuery.support.enctype){
jQuery.propFix.enctype="encoding";
}
if(!jQuery.support.checkOn){
jQuery.each(["radio","checkbox"],function(){
jQuery.valHooks[this]={
get:function(elem){
return elem.getAttribute("value")===null?"on":elem.value;
}
};
});
}
jQuery.each(["radio","checkbox"],function(){
jQuery.valHooks[this]=jQuery.extend(jQuery.valHooks[this],{
set:function(elem,value){
if(jQuery.isArray(value)){
return(elem.checked=jQuery.inArray(jQuery(elem).val(),value)>=0);
}
}
});
});
var rformElems=/^(?:textarea|input|select)$/i,
rtypenamespace=/^([^\.]*)?(?:\.(.+))?$/,
rhoverHack=/(?:^|\s)hover(\.\S+)?\b/,
rkeyEvent=/^key/,
rmouseEvent=/^(?:mouse|contextmenu)|click/,
rfocusMorph=/^(?:focusinfocus|focusoutblur)$/,
rquickIs=/^(\w*)(?:#([\w\-]+))?(?:\.([\w\-]+))?$/,
quickParse=function(selector){
var quick=rquickIs.exec(selector);
if(quick){
quick[1]=(quick[1]||"").toLowerCase();
quick[3]=quick[3]&&new RegExp("(?:^|\\s)"+quick[3]+"(?:\\s|$)");
}
return quick;
},
quickIs=function(elem,m){
var attrs=elem.attributes||{};
return(
(!m[1]||elem.nodeName.toLowerCase()===m[1])&&
(!m[2]||(attrs.id||{}).value===m[2])&&
(!m[3]||m[3].test((attrs["class"]||{}).value))
);
},
hoverHack=function(events){
return jQuery.event.special.hover?events:events.replace(rhoverHack,"mouseenter$1 mouseleave$1");
};
jQuery.event={
add:function(elem,types,handler,data,selector){
var elemData,eventHandle,events,
t,tns,type,namespaces,handleObj,
handleObjIn,quick,handlers,special;
if(elem.nodeType===3||elem.nodeType===8||!types||!handler||!(elemData=jQuery._data(elem))){
return;
}
if(handler.handler){
handleObjIn=handler;
handler=handleObjIn.handler;
selector=handleObjIn.selector;
}
if(!handler.guid){
handler.guid=jQuery.guid++;
}
events=elemData.events;
if(!events){
elemData.events=events={};
}
eventHandle=elemData.handle;
if(!eventHandle){
elemData.handle=eventHandle=function(e){
return typeof jQuery!=="undefined"&&(!e||jQuery.event.triggered!==e.type)?
jQuery.event.dispatch.apply(eventHandle.elem,arguments):
undefined;
};
eventHandle.elem=elem;
}
types=jQuery.trim(hoverHack(types)).split(" ");
for(t=0;t<types.length;t++){
tns=rtypenamespace.exec(types[t])||[];
type=tns[1];
namespaces=(tns[2]||"").split(".").sort();
special=jQuery.event.special[type]||{};
type=(selector?special.delegateType:special.bindType)||type;
special=jQuery.event.special[type]||{};
handleObj=jQuery.extend({
type:type,
origType:tns[1],
data:data,
handler:handler,
guid:handler.guid,
selector:selector,
quick:selector&&quickParse(selector),
namespace:namespaces.join(".")
},handleObjIn);
handlers=events[type];
if(!handlers){
handlers=events[type]=[];
handlers.delegateCount=0;
if(!special.setup||special.setup.call(elem,data,namespaces,eventHandle)===false){
if(elem.addEventListener){
elem.addEventListener(type,eventHandle,false);
}else if(elem.attachEvent){
elem.attachEvent("on"+type,eventHandle);
}
}
}
if(special.add){
special.add.call(elem,handleObj);
if(!handleObj.handler.guid){
handleObj.handler.guid=handler.guid;
}
}
if(selector){
handlers.splice(handlers.delegateCount++,0,handleObj);
}else{
handlers.push(handleObj);
}
jQuery.event.global[type]=true;
}
elem=null;
},
global:{},
remove:function(elem,types,handler,selector,mappedTypes){
var elemData=jQuery.hasData(elem)&&jQuery._data(elem),
t,tns,type,origType,namespaces,origCount,
j,events,special,handle,eventType,handleObj;
if(!elemData||!(events=elemData.events)){
return;
}
types=jQuery.trim(hoverHack(types||"")).split(" ");
for(t=0;t<types.length;t++){
tns=rtypenamespace.exec(types[t])||[];
type=origType=tns[1];
namespaces=tns[2];
if(!type){
for(type in events){
jQuery.event.remove(elem,type+types[t],handler,selector,true);
}
continue;
}
special=jQuery.event.special[type]||{};
type=(selector?special.delegateType:special.bindType)||type;
eventType=events[type]||[];
origCount=eventType.length;
namespaces=namespaces?new RegExp("(^|\\.)"+namespaces.split(".").sort().join("\\.(?:.*\\.)?")+"(\\.|$)"):null;
for(j=0;j<eventType.length;j++){
handleObj=eventType[j];
if((mappedTypes||origType===handleObj.origType)&&
(!handler||handler.guid===handleObj.guid)&&
(!namespaces||namespaces.test(handleObj.namespace))&&
(!selector||selector===handleObj.selector||selector==="**"&&handleObj.selector)){
eventType.splice(j--,1);
if(handleObj.selector){
eventType.delegateCount--;
}
if(special.remove){
special.remove.call(elem,handleObj);
}
}
}
if(eventType.length===0&&origCount!==eventType.length){
if(!special.teardown||special.teardown.call(elem,namespaces)===false){
jQuery.removeEvent(elem,type,elemData.handle);
}
delete events[type];
}
}
if(jQuery.isEmptyObject(events)){
handle=elemData.handle;
if(handle){
handle.elem=null;
}
jQuery.removeData(elem,["events","handle"],true);
}
},
customEvent:{
"getData":true,
"setData":true,
"changeData":true
},
trigger:function(event,data,elem,onlyHandlers){
if(elem&&(elem.nodeType===3||elem.nodeType===8)){
return;
}
var type=event.type||event,
namespaces=[],
cache,exclusive,i,cur,old,ontype,special,handle,eventPath,bubbleType;
if(rfocusMorph.test(type+jQuery.event.triggered)){
return;
}
if(type.indexOf("!")>=0){
type=type.slice(0,-1);
exclusive=true;
}
if(type.indexOf(".")>=0){
namespaces=type.split(".");
type=namespaces.shift();
namespaces.sort();
}
if((!elem||jQuery.event.customEvent[type])&&!jQuery.event.global[type]){
return;
}
event=typeof event==="object"?
event[jQuery.expando]?event:
new jQuery.Event(type,event):
new jQuery.Event(type);
event.type=type;
event.isTrigger=true;
event.exclusive=exclusive;
event.namespace=namespaces.join(".");
event.namespace_re=event.namespace?new RegExp("(^|\\.)"+namespaces.join("\\.(?:.*\\.)?")+"(\\.|$)"):null;
ontype=type.indexOf(":")<0?"on"+type:"";
if(!elem){
cache=jQuery.cache;
for(i in cache){
if(cache[i].events&&cache[i].events[type]){
jQuery.event.trigger(event,data,cache[i].handle.elem,true);
}
}
return;
}
event.result=undefined;
if(!event.target){
event.target=elem;
}
data=data!=null?jQuery.makeArray(data):[];
data.unshift(event);
special=jQuery.event.special[type]||{};
if(special.trigger&&special.trigger.apply(elem,data)===false){
return;
}
eventPath=[[elem,special.bindType||type]];
if(!onlyHandlers&&!special.noBubble&&!jQuery.isWindow(elem)){
bubbleType=special.delegateType||type;
cur=rfocusMorph.test(bubbleType+type)?elem:elem.parentNode;
old=null;
for(;cur;cur=cur.parentNode){
eventPath.push([cur,bubbleType]);
old=cur;
}
if(old&&old===elem.ownerDocument){
eventPath.push([old.defaultView||old.parentWindow||window,bubbleType]);
}
}
for(i=0;i<eventPath.length&&!event.isPropagationStopped();i++){
cur=eventPath[i][0];
event.type=eventPath[i][1];
handle=(jQuery._data(cur,"events")||{})[event.type]&&jQuery._data(cur,"handle");
if(handle){
handle.apply(cur,data);
}
handle=ontype&&cur[ontype];
if(handle&&jQuery.acceptData(cur)&&handle.apply(cur,data)===false){
event.preventDefault();
}
}
event.type=type;
if(!onlyHandlers&&!event.isDefaultPrevented()){
if((!special._default||special._default.apply(elem.ownerDocument,data)===false)&&
!(type==="click"&&jQuery.nodeName(elem,"a"))&&jQuery.acceptData(elem)){
if(ontype&&elem[type]&&((type!=="focus"&&type!=="blur")||event.target.offsetWidth!==0)&&!jQuery.isWindow(elem)){
old=elem[ontype];
if(old){
elem[ontype]=null;
}
jQuery.event.triggered=type;
elem[type]();
jQuery.event.triggered=undefined;
if(old){
elem[ontype]=old;
}
}
}
}
return event.result;
},
dispatch:function(event){
event=jQuery.event.fix(event||window.event);
var handlers=((jQuery._data(this,"events")||{})[event.type]||[]),
delegateCount=handlers.delegateCount,
args=[].slice.call(arguments,0),
run_all=!event.exclusive&&!event.namespace,
special=jQuery.event.special[event.type]||{},
handlerQueue=[],
i,j,cur,jqcur,ret,selMatch,matched,matches,handleObj,sel,related;
args[0]=event;
event.delegateTarget=this;
if(special.preDispatch&&special.preDispatch.call(this,event)===false){
return;
}
if(delegateCount&&!(event.button&&event.type==="click")){
jqcur=jQuery(this);
jqcur.context=this.ownerDocument||this;
for(cur=event.target;cur!=this;cur=cur.parentNode||this){
if(cur.disabled!==true){
selMatch={};
matches=[];
jqcur[0]=cur;
for(i=0;i<delegateCount;i++){
handleObj=handlers[i];
sel=handleObj.selector;
if(selMatch[sel]===undefined){
selMatch[sel]=(
handleObj.quick?quickIs(cur,handleObj.quick):jqcur.is(sel)
);
}
if(selMatch[sel]){
matches.push(handleObj);
}
}
if(matches.length){
handlerQueue.push({elem:cur,matches:matches});
}
}
}
}
if(handlers.length>delegateCount){
handlerQueue.push({elem:this,matches:handlers.slice(delegateCount)});
}
for(i=0;i<handlerQueue.length&&!event.isPropagationStopped();i++){
matched=handlerQueue[i];
event.currentTarget=matched.elem;
for(j=0;j<matched.matches.length&&!event.isImmediatePropagationStopped();j++){
handleObj=matched.matches[j];
if(run_all||(!event.namespace&&!handleObj.namespace)||event.namespace_re&&event.namespace_re.test(handleObj.namespace)){
event.data=handleObj.data;
event.handleObj=handleObj;
ret=((jQuery.event.special[handleObj.origType]||{}).handle||handleObj.handler)
.apply(matched.elem,args);
if(ret!==undefined){
event.result=ret;
if(ret===false){
event.preventDefault();
event.stopPropagation();
}
}
}
}
}
if(special.postDispatch){
special.postDispatch.call(this,event);
}
return event.result;
},
props:"attrChange attrName relatedNode srcElement altKey bubbles cancelable ctrlKey currentTarget eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),
fixHooks:{},
keyHooks:{
props:"char charCode key keyCode".split(" "),
filter:function(event,original){
if(event.which==null){
event.which=original.charCode!=null?original.charCode:original.keyCode;
}
return event;
}
},
mouseHooks:{
props:"button buttons clientX clientY fromElement offsetX offsetY pageX pageY screenX screenY toElement".split(" "),
filter:function(event,original){
var eventDoc,doc,body,
button=original.button,
fromElement=original.fromElement;
if(event.pageX==null&&original.clientX!=null){
eventDoc=event.target.ownerDocument||document;
doc=eventDoc.documentElement;
body=eventDoc.body;
event.pageX=original.clientX+(doc&&doc.scrollLeft||body&&body.scrollLeft||0)-(doc&&doc.clientLeft||body&&body.clientLeft||0);
event.pageY=original.clientY+(doc&&doc.scrollTop||body&&body.scrollTop||0)-(doc&&doc.clientTop||body&&body.clientTop||0);
}
if(!event.relatedTarget&&fromElement){
event.relatedTarget=fromElement===event.target?original.toElement:fromElement;
}
if(!event.which&&button!==undefined){
event.which=(button&1?1:(button&2?3:(button&4?2:0)));
}
return event;
}
},
fix:function(event){
if(event[jQuery.expando]){
return event;
}
var i,prop,
originalEvent=event,
fixHook=jQuery.event.fixHooks[event.type]||{},
copy=fixHook.props?this.props.concat(fixHook.props):this.props;
event=jQuery.Event(originalEvent);
for(i=copy.length;i;){
prop=copy[--i];
event[prop]=originalEvent[prop];
}
if(!event.target){
event.target=originalEvent.srcElement||document;
}
if(event.target.nodeType===3){
event.target=event.target.parentNode;
}
if(event.metaKey===undefined){
event.metaKey=event.ctrlKey;
}
return fixHook.filter?fixHook.filter(event,originalEvent):event;
},
special:{
ready:{
setup:jQuery.bindReady
},
load:{
noBubble:true
},
focus:{
delegateType:"focusin"
},
blur:{
delegateType:"focusout"
},
beforeunload:{
setup:function(data,namespaces,eventHandle){
if(jQuery.isWindow(this)){
this.onbeforeunload=eventHandle;
}
},
teardown:function(namespaces,eventHandle){
if(this.onbeforeunload===eventHandle){
this.onbeforeunload=null;
}
}
}
},
simulate:function(type,elem,event,bubble){
var e=jQuery.extend(
new jQuery.Event(),
event,
{type:type,
isSimulated:true,
originalEvent:{}
}
);
if(bubble){
jQuery.event.trigger(e,null,elem);
}else{
jQuery.event.dispatch.call(elem,e);
}
if(e.isDefaultPrevented()){
event.preventDefault();
}
}
};
jQuery.event.handle=jQuery.event.dispatch;
jQuery.removeEvent=document.removeEventListener?
function(elem,type,handle){
if(elem.removeEventListener){
elem.removeEventListener(type,handle,false);
}
}:
function(elem,type,handle){
if(elem.detachEvent){
elem.detachEvent("on"+type,handle);
}
};
jQuery.Event=function(src,props){
if(!(this instanceof jQuery.Event)){
return new jQuery.Event(src,props);
}
if(src&&src.type){
this.originalEvent=src;
this.type=src.type;
this.isDefaultPrevented=(src.defaultPrevented||src.returnValue===false||
src.getPreventDefault&&src.getPreventDefault())?returnTrue:returnFalse;
}else{
this.type=src;
}
if(props){
jQuery.extend(this,props);
}
this.timeStamp=src&&src.timeStamp||jQuery.now();
this[jQuery.expando]=true;
};
function returnFalse(){
return false;
}
function returnTrue(){
return true;
}
jQuery.Event.prototype={
preventDefault:function(){
this.isDefaultPrevented=returnTrue;
var e=this.originalEvent;
if(!e){
return;
}
if(e.preventDefault){
e.preventDefault();
}else{
e.returnValue=false;
}
},
stopPropagation:function(){
this.isPropagationStopped=returnTrue;
var e=this.originalEvent;
if(!e){
return;
}
if(e.stopPropagation){
e.stopPropagation();
}
e.cancelBubble=true;
},
stopImmediatePropagation:function(){
this.isImmediatePropagationStopped=returnTrue;
this.stopPropagation();
},
isDefaultPrevented:returnFalse,
isPropagationStopped:returnFalse,
isImmediatePropagationStopped:returnFalse
};
jQuery.each({
mouseenter:"mouseover",
mouseleave:"mouseout"
},function(orig,fix){
jQuery.event.special[orig]={
delegateType:fix,
bindType:fix,
handle:function(event){
var target=this,
related=event.relatedTarget,
handleObj=event.handleObj,
selector=handleObj.selector,
ret;
if(!related||(related!==target&&!jQuery.contains(target,related))){
event.type=handleObj.origType;
ret=handleObj.handler.apply(this,arguments);
event.type=fix;
}
return ret;
}
};
});
if(!jQuery.support.submitBubbles){
jQuery.event.special.submit={
setup:function(){
if(jQuery.nodeName(this,"form")){
return false;
}
jQuery.event.add(this,"click._submit keypress._submit",function(e){
var elem=e.target,
form=jQuery.nodeName(elem,"input")||jQuery.nodeName(elem,"button")?elem.form:undefined;
if(form&&!form._submit_attached){
jQuery.event.add(form,"submit._submit",function(event){
event._submit_bubble=true;
});
form._submit_attached=true;
}
});
},
postDispatch:function(event){
if(event._submit_bubble){
delete event._submit_bubble;
if(this.parentNode&&!event.isTrigger){
jQuery.event.simulate("submit",this.parentNode,event,true);
}
}
},
teardown:function(){
if(jQuery.nodeName(this,"form")){
return false;
}
jQuery.event.remove(this,"._submit");
}
};
}
if(!jQuery.support.changeBubbles){
jQuery.event.special.change={
setup:function(){
if(rformElems.test(this.nodeName)){
if(this.type==="checkbox"||this.type==="radio"){
jQuery.event.add(this,"propertychange._change",function(event){
if(event.originalEvent.propertyName==="checked"){
this._just_changed=true;
}
});
jQuery.event.add(this,"click._change",function(event){
if(this._just_changed&&!event.isTrigger){
this._just_changed=false;
jQuery.event.simulate("change",this,event,true);
}
});
}
return false;
}
jQuery.event.add(this,"beforeactivate._change",function(e){
var elem=e.target;
if(rformElems.test(elem.nodeName)&&!elem._change_attached){
jQuery.event.add(elem,"change._change",function(event){
if(this.parentNode&&!event.isSimulated&&!event.isTrigger){
jQuery.event.simulate("change",this.parentNode,event,true);
}
});
elem._change_attached=true;
}
});
},
handle:function(event){
var elem=event.target;
if(this!==elem||event.isSimulated||event.isTrigger||(elem.type!=="radio"&&elem.type!=="checkbox")){
return event.handleObj.handler.apply(this,arguments);
}
},
teardown:function(){
jQuery.event.remove(this,"._change");
return rformElems.test(this.nodeName);
}
};
}
if(!jQuery.support.focusinBubbles){
jQuery.each({focus:"focusin",blur:"focusout"},function(orig,fix){
var attaches=0,
handler=function(event){
jQuery.event.simulate(fix,event.target,jQuery.event.fix(event),true);
};
jQuery.event.special[fix]={
setup:function(){
if(attaches++===0){
document.addEventListener(orig,handler,true);
}
},
teardown:function(){
if(--attaches===0){
document.removeEventListener(orig,handler,true);
}
}
};
});
}
jQuery.fn.extend({
on:function(types,selector,data,fn,one){
var origFn,type;
if(typeof types==="object"){
if(typeof selector!=="string"){
data=data||selector;
selector=undefined;
}
for(type in types){
this.on(type,selector,data,types[type],one);
}
return this;
}
if(data==null&&fn==null){
fn=selector;
data=selector=undefined;
}else if(fn==null){
if(typeof selector==="string"){
fn=data;
data=undefined;
}else{
fn=data;
data=selector;
selector=undefined;
}
}
if(fn===false){
fn=returnFalse;
}else if(!fn){
return this;
}
if(one===1){
origFn=fn;
fn=function(event){
jQuery().off(event);
return origFn.apply(this,arguments);
};
fn.guid=origFn.guid||(origFn.guid=jQuery.guid++);
}
return this.each(function(){
jQuery.event.add(this,types,fn,data,selector);
});
},
one:function(types,selector,data,fn){
return this.on(types,selector,data,fn,1);
},
off:function(types,selector,fn){
if(types&&types.preventDefault&&types.handleObj){
var handleObj=types.handleObj;
jQuery(types.delegateTarget).off(
handleObj.namespace?handleObj.origType+"."+handleObj.namespace:handleObj.origType,
handleObj.selector,
handleObj.handler
);
return this;
}
if(typeof types==="object"){
for(var type in types){
this.off(type,selector,types[type]);
}
return this;
}
if(selector===false||typeof selector==="function"){
fn=selector;
selector=undefined;
}
if(fn===false){
fn=returnFalse;
}
return this.each(function(){
jQuery.event.remove(this,types,fn,selector);
});
},
bind:function(types,data,fn){
return this.on(types,null,data,fn);
},
unbind:function(types,fn){
return this.off(types,null,fn);
},
live:function(types,data,fn){
jQuery(this.context).on(types,this.selector,data,fn);
return this;
},
die:function(types,fn){
jQuery(this.context).off(types,this.selector||"**",fn);
return this;
},
delegate:function(selector,types,data,fn){
return this.on(types,selector,data,fn);
},
undelegate:function(selector,types,fn){
return arguments.length==1?this.off(selector,"**"):this.off(types,selector,fn);
},
trigger:function(type,data){
return this.each(function(){
jQuery.event.trigger(type,data,this);
});
},
triggerHandler:function(type,data){
if(this[0]){
return jQuery.event.trigger(type,data,this[0],true);
}
},
toggle:function(fn){
var args=arguments,
guid=fn.guid||jQuery.guid++,
i=0,
toggler=function(event){
var lastToggle=(jQuery._data(this,"lastToggle"+fn.guid)||0)%i;
jQuery._data(this,"lastToggle"+fn.guid,lastToggle+1);
event.preventDefault();
return args[lastToggle].apply(this,arguments)||false;
};
toggler.guid=guid;
while(i<args.length){
args[i++].guid=guid;
}
return this.click(toggler);
},
hover:function(fnOver,fnOut){
return this.mouseenter(fnOver).mouseleave(fnOut||fnOver);
}
});
jQuery.each(("blur focus focusin focusout load resize scroll unload click dblclick "+
"mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave "+
"change select submit keydown keypress keyup error contextmenu").split(" "),function(i,name){
jQuery.fn[name]=function(data,fn){
if(fn==null){
fn=data;
data=null;
}
return arguments.length>0?
this.on(name,null,data,fn):
this.trigger(name);
};
if(jQuery.attrFn){
jQuery.attrFn[name]=true;
}
if(rkeyEvent.test(name)){
jQuery.event.fixHooks[name]=jQuery.event.keyHooks;
}
if(rmouseEvent.test(name)){
jQuery.event.fixHooks[name]=jQuery.event.mouseHooks;
}
});
(function(){
var chunker=/((?:\((?:\([^()]+\)|[^()]+)+\)|\[(?:\[[^\[\]]*\]|['"][^'"]*['"]|[^\[\]'"]+)+\]|\\.|[^ >+~,(\[\\]+)+|[>+~])(\s*,\s*)?((?:.|\r|\n)*)/g,
expando="sizcache"+(Math.random()+'').replace('.',''),
done=0,
toString=Object.prototype.toString,
hasDuplicate=false,
baseHasDuplicate=true,
rBackslash=/\\/g,
rReturn=/\r\n/g,
rNonWord=/\W/;
[0,0].sort(function(){
baseHasDuplicate=false;
return 0;
});
var Sizzle=function(selector,context,results,seed){
results=results||[];
context=context||document;
var origContext=context;
if(context.nodeType!==1&&context.nodeType!==9){
return[];
}
if(!selector||typeof selector!=="string"){
return results;
}
var m,set,checkSet,extra,ret,cur,pop,i,
prune=true,
contextXML=Sizzle.isXML(context),
parts=[],
soFar=selector;
do{
chunker.exec("");
m=chunker.exec(soFar);
if(m){
soFar=m[3];
parts.push(m[1]);
if(m[2]){
extra=m[3];
break;
}
}
}while(m);
if(parts.length>1&&origPOS.exec(selector)){
if(parts.length===2&&Expr.relative[parts[0]]){
set=posProcess(parts[0]+parts[1],context,seed);
}else{
set=Expr.relative[parts[0]]?
[context]:
Sizzle(parts.shift(),context);
while(parts.length){
selector=parts.shift();
if(Expr.relative[selector]){
selector+=parts.shift();
}
set=posProcess(selector,set,seed);
}
}
}else{
if(!seed&&parts.length>1&&context.nodeType===9&&!contextXML&&
Expr.match.ID.test(parts[0])&&!Expr.match.ID.test(parts[parts.length-1])){
ret=Sizzle.find(parts.shift(),context,contextXML);
context=ret.expr?
Sizzle.filter(ret.expr,ret.set)[0]:
ret.set[0];
}
if(context){
ret=seed?
{expr:parts.pop(),set:makeArray(seed)}:
Sizzle.find(parts.pop(),parts.length===1&&(parts[0]==="~"||parts[0]==="+")&&context.parentNode?context.parentNode:context,contextXML);
set=ret.expr?
Sizzle.filter(ret.expr,ret.set):
ret.set;
if(parts.length>0){
checkSet=makeArray(set);
}else{
prune=false;
}
while(parts.length){
cur=parts.pop();
pop=cur;
if(!Expr.relative[cur]){
cur="";
}else{
pop=parts.pop();
}
if(pop==null){
pop=context;
}
Expr.relative[cur](checkSet,pop,contextXML);
}
}else{
checkSet=parts=[];
}
}
if(!checkSet){
checkSet=set;
}
if(!checkSet){
Sizzle.error(cur||selector);
}
if(toString.call(checkSet)==="[object Array]"){
if(!prune){
results.push.apply(results,checkSet);
}else if(context&&context.nodeType===1){
for(i=0;checkSet[i]!=null;i++){
if(checkSet[i]&&(checkSet[i]===true||checkSet[i].nodeType===1&&Sizzle.contains(context,checkSet[i]))){
results.push(set[i]);
}
}
}else{
for(i=0;checkSet[i]!=null;i++){
if(checkSet[i]&&checkSet[i].nodeType===1){
results.push(set[i]);
}
}
}
}else{
makeArray(checkSet,results);
}
if(extra){
Sizzle(extra,origContext,results,seed);
Sizzle.uniqueSort(results);
}
return results;
};
Sizzle.uniqueSort=function(results){
if(sortOrder){
hasDuplicate=baseHasDuplicate;
results.sort(sortOrder);
if(hasDuplicate){
for(var i=1;i<results.length;i++){
if(results[i]===results[i-1]){
results.splice(i--,1);
}
}
}
}
return results;
};
Sizzle.matches=function(expr,set){
return Sizzle(expr,null,null,set);
};
Sizzle.matchesSelector=function(node,expr){
return Sizzle(expr,null,null,[node]).length>0;
};
Sizzle.find=function(expr,context,isXML){
var set,i,len,match,type,left;
if(!expr){
return[];
}
for(i=0,len=Expr.order.length;i<len;i++){
type=Expr.order[i];
if((match=Expr.leftMatch[type].exec(expr))){
left=match[1];
match.splice(1,1);
if(left.substr(left.length-1)!=="\\"){
match[1]=(match[1]||"").replace(rBackslash,"");
set=Expr.find[type](match,context,isXML);
if(set!=null){
expr=expr.replace(Expr.match[type],"");
break;
}
}
}
}
if(!set){
set=typeof context.getElementsByTagName!=="undefined"?
context.getElementsByTagName("*"):
[];
}
return{set:set,expr:expr};
};
Sizzle.filter=function(expr,set,inplace,not){
var match,anyFound,
type,found,item,filter,left,
i,pass,
old=expr,
result=[],
curLoop=set,
isXMLFilter=set&&set[0]&&Sizzle.isXML(set[0]);
while(expr&&set.length){
for(type in Expr.filter){
if((match=Expr.leftMatch[type].exec(expr))!=null&&match[2]){
filter=Expr.filter[type];
left=match[1];
anyFound=false;
match.splice(1,1);
if(left.substr(left.length-1)==="\\"){
continue;
}
if(curLoop===result){
result=[];
}
if(Expr.preFilter[type]){
match=Expr.preFilter[type](match,curLoop,inplace,result,not,isXMLFilter);
if(!match){
anyFound=found=true;
}else if(match===true){
continue;
}
}
if(match){
for(i=0;(item=curLoop[i])!=null;i++){
if(item){
found=filter(item,match,i,curLoop);
pass=not^found;
if(inplace&&found!=null){
if(pass){
anyFound=true;
}else{
curLoop[i]=false;
}
}else if(pass){
result.push(item);
anyFound=true;
}
}
}
}
if(found!==undefined){
if(!inplace){
curLoop=result;
}
expr=expr.replace(Expr.match[type],"");
if(!anyFound){
return[];
}
break;
}
}
}
if(expr===old){
if(anyFound==null){
Sizzle.error(expr);
}else{
break;
}
}
old=expr;
}
return curLoop;
};
Sizzle.error=function(msg){
throw new Error("Syntax error, unrecognized expression: "+msg);
};
var getText=Sizzle.getText=function(elem){
var i,node,
nodeType=elem.nodeType,
ret="";
if(nodeType){
if(nodeType===1||nodeType===9||nodeType===11){
if(typeof elem.textContent==='string'){
return elem.textContent;
}else if(typeof elem.innerText==='string'){
return elem.innerText.replace(rReturn,'');
}else{
for(elem=elem.firstChild;elem;elem=elem.nextSibling){
ret+=getText(elem);
}
}
}else if(nodeType===3||nodeType===4){
return elem.nodeValue;
}
}else{
for(i=0;(node=elem[i]);i++){
if(node.nodeType!==8){
ret+=getText(node);
}
}
}
return ret;
};
var Expr=Sizzle.selectors={
order:["ID","NAME","TAG"],
match:{
ID:/#((?:[\w\u00c0-\uFFFF\-]|\\.)+)/,
CLASS:/\.((?:[\w\u00c0-\uFFFF\-]|\\.)+)/,
NAME:/\[name=['"]*((?:[\w\u00c0-\uFFFF\-]|\\.)+)['"]*\]/,
ATTR:/\[\s*((?:[\w\u00c0-\uFFFF\-]|\\.)+)\s*(?:(\S?=)\s*(?:(['"])(.*?)\3|(#?(?:[\w\u00c0-\uFFFF\-]|\\.)*)|)|)\s*\]/,
TAG:/^((?:[\w\u00c0-\uFFFF\*\-]|\\.)+)/,
CHILD:/:(only|nth|last|first)-child(?:\(\s*(even|odd|(?:[+\-]?\d+|(?:[+\-]?\d*)?n\s*(?:[+\-]\s*\d+)?))\s*\))?/,
POS:/:(nth|eq|gt|lt|first|last|even|odd)(?:\((\d*)\))?(?=[^\-]|$)/,
PSEUDO:/:((?:[\w\u00c0-\uFFFF\-]|\\.)+)(?:\((['"]?)((?:\([^\)]+\)|[^\(\)]*)+)\2\))?/
},
leftMatch:{},
attrMap:{
"class":"className",
"for":"htmlFor"
},
attrHandle:{
href:function(elem){
return elem.getAttribute("href");
},
type:function(elem){
return elem.getAttribute("type");
}
},
relative:{
"+":function(checkSet,part){
var isPartStr=typeof part==="string",
isTag=isPartStr&&!rNonWord.test(part),
isPartStrNotTag=isPartStr&&!isTag;
if(isTag){
part=part.toLowerCase();
}
for(var i=0,l=checkSet.length,elem;i<l;i++){
if((elem=checkSet[i])){
while((elem=elem.previousSibling)&&elem.nodeType!==1){}
checkSet[i]=isPartStrNotTag||elem&&elem.nodeName.toLowerCase()===part?
elem||false:
elem===part;
}
}
if(isPartStrNotTag){
Sizzle.filter(part,checkSet,true);
}
},
">":function(checkSet,part){
var elem,
isPartStr=typeof part==="string",
i=0,
l=checkSet.length;
if(isPartStr&&!rNonWord.test(part)){
part=part.toLowerCase();
for(;i<l;i++){
elem=checkSet[i];
if(elem){
var parent=elem.parentNode;
checkSet[i]=parent.nodeName.toLowerCase()===part?parent:false;
}
}
}else{
for(;i<l;i++){
elem=checkSet[i];
if(elem){
checkSet[i]=isPartStr?
elem.parentNode:
elem.parentNode===part;
}
}
if(isPartStr){
Sizzle.filter(part,checkSet,true);
}
}
},
"":function(checkSet,part,isXML){
var nodeCheck,
doneName=done++,
checkFn=dirCheck;
if(typeof part==="string"&&!rNonWord.test(part)){
part=part.toLowerCase();
nodeCheck=part;
checkFn=dirNodeCheck;
}
checkFn("parentNode",part,doneName,checkSet,nodeCheck,isXML);
},
"~":function(checkSet,part,isXML){
var nodeCheck,
doneName=done++,
checkFn=dirCheck;
if(typeof part==="string"&&!rNonWord.test(part)){
part=part.toLowerCase();
nodeCheck=part;
checkFn=dirNodeCheck;
}
checkFn("previousSibling",part,doneName,checkSet,nodeCheck,isXML);
}
},
find:{
ID:function(match,context,isXML){
if(typeof context.getElementById!=="undefined"&&!isXML){
var m=context.getElementById(match[1]);
return m&&m.parentNode?[m]:[];
}
},
NAME:function(match,context){
if(typeof context.getElementsByName!=="undefined"){
var ret=[],
results=context.getElementsByName(match[1]);
for(var i=0,l=results.length;i<l;i++){
if(results[i].getAttribute("name")===match[1]){
ret.push(results[i]);
}
}
return ret.length===0?null:ret;
}
},
TAG:function(match,context){
if(typeof context.getElementsByTagName!=="undefined"){
return context.getElementsByTagName(match[1]);
}
}
},
preFilter:{
CLASS:function(match,curLoop,inplace,result,not,isXML){
match=" "+match[1].replace(rBackslash,"")+" ";
if(isXML){
return match;
}
for(var i=0,elem;(elem=curLoop[i])!=null;i++){
if(elem){
if(not^(elem.className&&(" "+elem.className+" ").replace(/[\t\n\r]/g," ").indexOf(match)>=0)){
if(!inplace){
result.push(elem);
}
}else if(inplace){
curLoop[i]=false;
}
}
}
return false;
},
ID:function(match){
return match[1].replace(rBackslash,"");
},
TAG:function(match,curLoop){
return match[1].replace(rBackslash,"").toLowerCase();
},
CHILD:function(match){
if(match[1]==="nth"){
if(!match[2]){
Sizzle.error(match[0]);
}
match[2]=match[2].replace(/^\+|\s*/g,'');
var test=/(-?)(\d*)(?:n([+\-]?\d*))?/.exec(
match[2]==="even"&&"2n"||match[2]==="odd"&&"2n+1"||
!/\D/.test(match[2])&&"0n+"+match[2]||match[2]);
match[2]=(test[1]+(test[2]||1))-0;
match[3]=test[3]-0;
}
else if(match[2]){
Sizzle.error(match[0]);
}
match[0]=done++;
return match;
},
ATTR:function(match,curLoop,inplace,result,not,isXML){
var name=match[1]=match[1].replace(rBackslash,"");
if(!isXML&&Expr.attrMap[name]){
match[1]=Expr.attrMap[name];
}
match[4]=(match[4]||match[5]||"").replace(rBackslash,"");
if(match[2]==="~="){
match[4]=" "+match[4]+" ";
}
return match;
},
PSEUDO:function(match,curLoop,inplace,result,not){
if(match[1]==="not"){
if((chunker.exec(match[3])||"").length>1||/^\w/.test(match[3])){
match[3]=Sizzle(match[3],null,null,curLoop);
}else{
var ret=Sizzle.filter(match[3],curLoop,inplace,true^not);
if(!inplace){
result.push.apply(result,ret);
}
return false;
}
}else if(Expr.match.POS.test(match[0])||Expr.match.CHILD.test(match[0])){
return true;
}
return match;
},
POS:function(match){
match.unshift(true);
return match;
}
},
filters:{
enabled:function(elem){
return elem.disabled===false&&elem.type!=="hidden";
},
disabled:function(elem){
return elem.disabled===true;
},
checked:function(elem){
return elem.checked===true;
},
selected:function(elem){
if(elem.parentNode){
elem.parentNode.selectedIndex;
}
return elem.selected===true;
},
parent:function(elem){
return!!elem.firstChild;
},
empty:function(elem){
return!elem.firstChild;
},
has:function(elem,i,match){
return!!Sizzle(match[3],elem).length;
},
header:function(elem){
return(/h\d/i).test(elem.nodeName);
},
text:function(elem){
var attr=elem.getAttribute("type"),type=elem.type;
return elem.nodeName.toLowerCase()==="input"&&"text"===type&&(attr===type||attr===null);
},
radio:function(elem){
return elem.nodeName.toLowerCase()==="input"&&"radio"===elem.type;
},
checkbox:function(elem){
return elem.nodeName.toLowerCase()==="input"&&"checkbox"===elem.type;
},
file:function(elem){
return elem.nodeName.toLowerCase()==="input"&&"file"===elem.type;
},
password:function(elem){
return elem.nodeName.toLowerCase()==="input"&&"password"===elem.type;
},
submit:function(elem){
var name=elem.nodeName.toLowerCase();
return(name==="input"||name==="button")&&"submit"===elem.type;
},
image:function(elem){
return elem.nodeName.toLowerCase()==="input"&&"image"===elem.type;
},
reset:function(elem){
var name=elem.nodeName.toLowerCase();
return(name==="input"||name==="button")&&"reset"===elem.type;
},
button:function(elem){
var name=elem.nodeName.toLowerCase();
return name==="input"&&"button"===elem.type||name==="button";
},
input:function(elem){
return(/input|select|textarea|button/i).test(elem.nodeName);
},
focus:function(elem){
return elem===elem.ownerDocument.activeElement;
}
},
setFilters:{
first:function(elem,i){
return i===0;
},
last:function(elem,i,match,array){
return i===array.length-1;
},
even:function(elem,i){
return i%2===0;
},
odd:function(elem,i){
return i%2===1;
},
lt:function(elem,i,match){
return i<match[3]-0;
},
gt:function(elem,i,match){
return i>match[3]-0;
},
nth:function(elem,i,match){
return match[3]-0===i;
},
eq:function(elem,i,match){
return match[3]-0===i;
}
},
filter:{
PSEUDO:function(elem,match,i,array){
var name=match[1],
filter=Expr.filters[name];
if(filter){
return filter(elem,i,match,array);
}else if(name==="contains"){
return(elem.textContent||elem.innerText||getText([elem])||"").indexOf(match[3])>=0;
}else if(name==="not"){
var not=match[3];
for(var j=0,l=not.length;j<l;j++){
if(not[j]===elem){
return false;
}
}
return true;
}else{
Sizzle.error(name);
}
},
CHILD:function(elem,match){
var first,last,
doneName,parent,cache,
count,diff,
type=match[1],
node=elem;
switch(type){
case"only":
case"first":
while((node=node.previousSibling)){
if(node.nodeType===1){
return false;
}
}
if(type==="first"){
return true;
}
node=elem;
case"last":
while((node=node.nextSibling)){
if(node.nodeType===1){
return false;
}
}
return true;
case"nth":
first=match[2];
last=match[3];
if(first===1&&last===0){
return true;
}
doneName=match[0];
parent=elem.parentNode;
if(parent&&(parent[expando]!==doneName||!elem.nodeIndex)){
count=0;
for(node=parent.firstChild;node;node=node.nextSibling){
if(node.nodeType===1){
node.nodeIndex=++count;
}
}
parent[expando]=doneName;
}
diff=elem.nodeIndex-last;
if(first===0){
return diff===0;
}else{
return(diff%first===0&&diff/first>=0);
}
}
},
ID:function(elem,match){
return elem.nodeType===1&&elem.getAttribute("id")===match;
},
TAG:function(elem,match){
return(match==="*"&&elem.nodeType===1)||!!elem.nodeName&&elem.nodeName.toLowerCase()===match;
},
CLASS:function(elem,match){
return(" "+(elem.className||elem.getAttribute("class"))+" ")
.indexOf(match)>-1;
},
ATTR:function(elem,match){
var name=match[1],
result=Sizzle.attr?
Sizzle.attr(elem,name):
Expr.attrHandle[name]?
Expr.attrHandle[name](elem):
elem[name]!=null?
elem[name]:
elem.getAttribute(name),
value=result+"",
type=match[2],
check=match[4];
return result==null?
type==="!=":
!type&&Sizzle.attr?
result!=null:
type==="="?
value===check:
type==="*="?
value.indexOf(check)>=0:
type==="~="?
(" "+value+" ").indexOf(check)>=0:
!check?
value&&result!==false:
type==="!="?
value!==check:
type==="^="?
value.indexOf(check)===0:
type==="$="?
value.substr(value.length-check.length)===check:
type==="|="?
value===check||value.substr(0,check.length+1)===check+"-":
false;
},
POS:function(elem,match,i,array){
var name=match[2],
filter=Expr.setFilters[name];
if(filter){
return filter(elem,i,match,array);
}
}
}
};
var origPOS=Expr.match.POS,
fescape=function(all,num){
return"\\"+(num-0+1);
};
for(var type in Expr.match){
Expr.match[type]=new RegExp(Expr.match[type].source+(/(?![^\[]*\])(?![^\(]*\))/.source));
Expr.leftMatch[type]=new RegExp(/(^(?:.|\r|\n)*?)/.source+Expr.match[type].source.replace(/\\(\d+)/g,fescape));
}
Expr.match.globalPOS=origPOS;
var makeArray=function(array,results){
array=Array.prototype.slice.call(array,0);
if(results){
results.push.apply(results,array);
return results;
}
return array;
};
try{
Array.prototype.slice.call(document.documentElement.childNodes,0)[0].nodeType;
}catch(e){
makeArray=function(array,results){
var i=0,
ret=results||[];
if(toString.call(array)==="[object Array]"){
Array.prototype.push.apply(ret,array);
}else{
if(typeof array.length==="number"){
for(var l=array.length;i<l;i++){
ret.push(array[i]);
}
}else{
for(;array[i];i++){
ret.push(array[i]);
}
}
}
return ret;
};
}
var sortOrder,siblingCheck;
if(document.documentElement.compareDocumentPosition){
sortOrder=function(a,b){
if(a===b){
hasDuplicate=true;
return 0;
}
if(!a.compareDocumentPosition||!b.compareDocumentPosition){
return a.compareDocumentPosition?-1:1;
}
return a.compareDocumentPosition(b)&4?-1:1;
};
}else{
sortOrder=function(a,b){
if(a===b){
hasDuplicate=true;
return 0;
}else if(a.sourceIndex&&b.sourceIndex){
return a.sourceIndex-b.sourceIndex;
}
var al,bl,
ap=[],
bp=[],
aup=a.parentNode,
bup=b.parentNode,
cur=aup;
if(aup===bup){
return siblingCheck(a,b);
}else if(!aup){
return-1;
}else if(!bup){
return 1;
}
while(cur){
ap.unshift(cur);
cur=cur.parentNode;
}
cur=bup;
while(cur){
bp.unshift(cur);
cur=cur.parentNode;
}
al=ap.length;
bl=bp.length;
for(var i=0;i<al&&i<bl;i++){
if(ap[i]!==bp[i]){
return siblingCheck(ap[i],bp[i]);
}
}
return i===al?
siblingCheck(a,bp[i],-1):
siblingCheck(ap[i],b,1);
};
siblingCheck=function(a,b,ret){
if(a===b){
return ret;
}
var cur=a.nextSibling;
while(cur){
if(cur===b){
return-1;
}
cur=cur.nextSibling;
}
return 1;
};
}
(function(){
var form=document.createElement("div"),
id="script"+(new Date()).getTime(),
root=document.documentElement;
form.innerHTML="<a name='"+id+"'/>";
root.insertBefore(form,root.firstChild);
if(document.getElementById(id)){
Expr.find.ID=function(match,context,isXML){
if(typeof context.getElementById!=="undefined"&&!isXML){
var m=context.getElementById(match[1]);
return m?
m.id===match[1]||typeof m.getAttributeNode!=="undefined"&&m.getAttributeNode("id").nodeValue===match[1]?
[m]:
undefined:
[];
}
};
Expr.filter.ID=function(elem,match){
var node=typeof elem.getAttributeNode!=="undefined"&&elem.getAttributeNode("id");
return elem.nodeType===1&&node&&node.nodeValue===match;
};
}
root.removeChild(form);
root=form=null;
})();
(function(){
var div=document.createElement("div");
div.appendChild(document.createComment(""));
if(div.getElementsByTagName("*").length>0){
Expr.find.TAG=function(match,context){
var results=context.getElementsByTagName(match[1]);
if(match[1]==="*"){
var tmp=[];
for(var i=0;results[i];i++){
if(results[i].nodeType===1){
tmp.push(results[i]);
}
}
results=tmp;
}
return results;
};
}
div.innerHTML="<a href='#'></a>";
if(div.firstChild&&typeof div.firstChild.getAttribute!=="undefined"&&
div.firstChild.getAttribute("href")!=="#"){
Expr.attrHandle.href=function(elem){
return elem.getAttribute("href",2);
};
}
div=null;
})();
if(document.querySelectorAll){
(function(){
var oldSizzle=Sizzle,
div=document.createElement("div"),
id="__sizzle__";
div.innerHTML="<p class='TEST'></p>";
if(div.querySelectorAll&&div.querySelectorAll(".TEST").length===0){
return;
}
Sizzle=function(query,context,extra,seed){
context=context||document;
if(!seed&&!Sizzle.isXML(context)){
var match=/^(\w+$)|^\.([\w\-]+$)|^#([\w\-]+$)/.exec(query);
if(match&&(context.nodeType===1||context.nodeType===9)){
if(match[1]){
return makeArray(context.getElementsByTagName(query),extra);
}else if(match[2]&&Expr.find.CLASS&&context.getElementsByClassName){
return makeArray(context.getElementsByClassName(match[2]),extra);
}
}
if(context.nodeType===9){
if(query==="body"&&context.body){
return makeArray([context.body],extra);
}else if(match&&match[3]){
var elem=context.getElementById(match[3]);
if(elem&&elem.parentNode){
if(elem.id===match[3]){
return makeArray([elem],extra);
}
}else{
return makeArray([],extra);
}
}
try{
return makeArray(context.querySelectorAll(query),extra);
}catch(qsaError){}
}else if(context.nodeType===1&&context.nodeName.toLowerCase()!=="object"){
var oldContext=context,
old=context.getAttribute("id"),
nid=old||id,
hasParent=context.parentNode,
relativeHierarchySelector=/^\s*[+~]/.test(query);
if(!old){
context.setAttribute("id",nid);
}else{
nid=nid.replace(/'/g,"\\$&");
}
if(relativeHierarchySelector&&hasParent){
context=context.parentNode;
}
try{
if(!relativeHierarchySelector||hasParent){
return makeArray(context.querySelectorAll("[id='"+nid+"'] "+query),extra);
}
}catch(pseudoError){
}finally{
if(!old){
oldContext.removeAttribute("id");
}
}
}
}
return oldSizzle(query,context,extra,seed);
};
for(var prop in oldSizzle){
Sizzle[prop]=oldSizzle[prop];
}
div=null;
})();
}
(function(){
var html=document.documentElement,
matches=html.matchesSelector||html.mozMatchesSelector||html.webkitMatchesSelector||html.msMatchesSelector;
if(matches){
var disconnectedMatch=!matches.call(document.createElement("div"),"div"),
pseudoWorks=false;
try{
matches.call(document.documentElement,"[test!='']:sizzle");
}catch(pseudoError){
pseudoWorks=true;
}
Sizzle.matchesSelector=function(node,expr){
expr=expr.replace(/\=\s*([^'"\]]*)\s*\]/g,"='$1']");
if(!Sizzle.isXML(node)){
try{
if(pseudoWorks||!Expr.match.PSEUDO.test(expr)&&!/!=/.test(expr)){
var ret=matches.call(node,expr);
if(ret||!disconnectedMatch||
node.document&&node.document.nodeType!==11){
return ret;
}
}
}catch(e){}
}
return Sizzle(expr,null,null,[node]).length>0;
};
}
})();
(function(){
var div=document.createElement("div");
div.innerHTML="<div class='test e'></div><div class='test'></div>";
if(!div.getElementsByClassName||div.getElementsByClassName("e").length===0){
return;
}
div.lastChild.className="e";
if(div.getElementsByClassName("e").length===1){
return;
}
Expr.order.splice(1,0,"CLASS");
Expr.find.CLASS=function(match,context,isXML){
if(typeof context.getElementsByClassName!=="undefined"&&!isXML){
return context.getElementsByClassName(match[1]);
}
};
div=null;
})();
function dirNodeCheck(dir,cur,doneName,checkSet,nodeCheck,isXML){
for(var i=0,l=checkSet.length;i<l;i++){
var elem=checkSet[i];
if(elem){
var match=false;
elem=elem[dir];
while(elem){
if(elem[expando]===doneName){
match=checkSet[elem.sizset];
break;
}
if(elem.nodeType===1&&!isXML){
elem[expando]=doneName;
elem.sizset=i;
}
if(elem.nodeName.toLowerCase()===cur){
match=elem;
break;
}
elem=elem[dir];
}
checkSet[i]=match;
}
}
}
function dirCheck(dir,cur,doneName,checkSet,nodeCheck,isXML){
for(var i=0,l=checkSet.length;i<l;i++){
var elem=checkSet[i];
if(elem){
var match=false;
elem=elem[dir];
while(elem){
if(elem[expando]===doneName){
match=checkSet[elem.sizset];
break;
}
if(elem.nodeType===1){
if(!isXML){
elem[expando]=doneName;
elem.sizset=i;
}
if(typeof cur!=="string"){
if(elem===cur){
match=true;
break;
}
}else if(Sizzle.filter(cur,[elem]).length>0){
match=elem;
break;
}
}
elem=elem[dir];
}
checkSet[i]=match;
}
}
}
if(document.documentElement.contains){
Sizzle.contains=function(a,b){
return a!==b&&(a.contains?a.contains(b):true);
};
}else if(document.documentElement.compareDocumentPosition){
Sizzle.contains=function(a,b){
return!!(a.compareDocumentPosition(b)&16);
};
}else{
Sizzle.contains=function(){
return false;
};
}
Sizzle.isXML=function(elem){
var documentElement=(elem?elem.ownerDocument||elem:0).documentElement;
return documentElement?documentElement.nodeName!=="HTML":false;
};
var posProcess=function(selector,context,seed){
var match,
tmpSet=[],
later="",
root=context.nodeType?[context]:context;
while((match=Expr.match.PSEUDO.exec(selector))){
later+=match[0];
selector=selector.replace(Expr.match.PSEUDO,"");
}
selector=Expr.relative[selector]?selector+"*":selector;
for(var i=0,l=root.length;i<l;i++){
Sizzle(selector,root[i],tmpSet,seed);
}
return Sizzle.filter(later,tmpSet);
};
Sizzle.attr=jQuery.attr;
Sizzle.selectors.attrMap={};
jQuery.find=Sizzle;
jQuery.expr=Sizzle.selectors;
jQuery.expr[":"]=jQuery.expr.filters;
jQuery.unique=Sizzle.uniqueSort;
jQuery.text=Sizzle.getText;
jQuery.isXMLDoc=Sizzle.isXML;
jQuery.contains=Sizzle.contains;
})();
var runtil=/Until$/,
rparentsprev=/^(?:parents|prevUntil|prevAll)/,
rmultiselector=/,/,
isSimple=/^.[^:#\[\.,]*$/,
slice=Array.prototype.slice,
POS=jQuery.expr.match.globalPOS,
guaranteedUnique={
children:true,
contents:true,
next:true,
prev:true
};
jQuery.fn.extend({
find:function(selector){
var self=this,
i,l;
if(typeof selector!=="string"){
return jQuery(selector).filter(function(){
for(i=0,l=self.length;i<l;i++){
if(jQuery.contains(self[i],this)){
return true;
}
}
});
}
var ret=this.pushStack("","find",selector),
length,n,r;
for(i=0,l=this.length;i<l;i++){
length=ret.length;
jQuery.find(selector,this[i],ret);
if(i>0){
for(n=length;n<ret.length;n++){
for(r=0;r<length;r++){
if(ret[r]===ret[n]){
ret.splice(n--,1);
break;
}
}
}
}
}
return ret;
},
has:function(target){
var targets=jQuery(target);
return this.filter(function(){
for(var i=0,l=targets.length;i<l;i++){
if(jQuery.contains(this,targets[i])){
return true;
}
}
});
},
not:function(selector){
return this.pushStack(winnow(this,selector,false),"not",selector);
},
filter:function(selector){
return this.pushStack(winnow(this,selector,true),"filter",selector);
},
is:function(selector){
return!!selector&&(
typeof selector==="string"?
POS.test(selector)?
jQuery(selector,this.context).index(this[0])>=0:
jQuery.filter(selector,this).length>0:
this.filter(selector).length>0);
},
closest:function(selectors,context){
var ret=[],i,l,cur=this[0];
if(jQuery.isArray(selectors)){
var level=1;
while(cur&&cur.ownerDocument&&cur!==context){
for(i=0;i<selectors.length;i++){
if(jQuery(cur).is(selectors[i])){
ret.push({selector:selectors[i],elem:cur,level:level});
}
}
cur=cur.parentNode;
level++;
}
return ret;
}
var pos=POS.test(selectors)||typeof selectors!=="string"?
jQuery(selectors,context||this.context):
0;
for(i=0,l=this.length;i<l;i++){
cur=this[i];
while(cur){
if(pos?pos.index(cur)>-1:jQuery.find.matchesSelector(cur,selectors)){
ret.push(cur);
break;
}else{
cur=cur.parentNode;
if(!cur||!cur.ownerDocument||cur===context||cur.nodeType===11){
break;
}
}
}
}
ret=ret.length>1?jQuery.unique(ret):ret;
return this.pushStack(ret,"closest",selectors);
},
index:function(elem){
if(!elem){
return(this[0]&&this[0].parentNode)?this.prevAll().length:-1;
}
if(typeof elem==="string"){
return jQuery.inArray(this[0],jQuery(elem));
}
return jQuery.inArray(
elem.jquery?elem[0]:elem,this);
},
add:function(selector,context){
var set=typeof selector==="string"?
jQuery(selector,context):
jQuery.makeArray(selector&&selector.nodeType?[selector]:selector),
all=jQuery.merge(this.get(),set);
return this.pushStack(isDisconnected(set[0])||isDisconnected(all[0])?
all:
jQuery.unique(all));
},
andSelf:function(){
return this.add(this.prevObject);
}
});
function isDisconnected(node){
return!node||!node.parentNode||node.parentNode.nodeType===11;
}
jQuery.each({
parent:function(elem){
var parent=elem.parentNode;
return parent&&parent.nodeType!==11?parent:null;
},
parents:function(elem){
return jQuery.dir(elem,"parentNode");
},
parentsUntil:function(elem,i,until){
return jQuery.dir(elem,"parentNode",until);
},
next:function(elem){
return jQuery.nth(elem,2,"nextSibling");
},
prev:function(elem){
return jQuery.nth(elem,2,"previousSibling");
},
nextAll:function(elem){
return jQuery.dir(elem,"nextSibling");
},
prevAll:function(elem){
return jQuery.dir(elem,"previousSibling");
},
nextUntil:function(elem,i,until){
return jQuery.dir(elem,"nextSibling",until);
},
prevUntil:function(elem,i,until){
return jQuery.dir(elem,"previousSibling",until);
},
siblings:function(elem){
return jQuery.sibling((elem.parentNode||{}).firstChild,elem);
},
children:function(elem){
return jQuery.sibling(elem.firstChild);
},
contents:function(elem){
return jQuery.nodeName(elem,"iframe")?
elem.contentDocument||elem.contentWindow.document:
jQuery.makeArray(elem.childNodes);
}
},function(name,fn){
jQuery.fn[name]=function(until,selector){
var ret=jQuery.map(this,fn,until);
if(!runtil.test(name)){
selector=until;
}
if(selector&&typeof selector==="string"){
ret=jQuery.filter(selector,ret);
}
ret=this.length>1&&!guaranteedUnique[name]?jQuery.unique(ret):ret;
if((this.length>1||rmultiselector.test(selector))&&rparentsprev.test(name)){
ret=ret.reverse();
}
return this.pushStack(ret,name,slice.call(arguments).join(","));
};
});
jQuery.extend({
filter:function(expr,elems,not){
if(not){
expr=":not("+expr+")";
}
return elems.length===1?
jQuery.find.matchesSelector(elems[0],expr)?[elems[0]]:[]:
jQuery.find.matches(expr,elems);
},
dir:function(elem,dir,until){
var matched=[],
cur=elem[dir];
while(cur&&cur.nodeType!==9&&(until===undefined||cur.nodeType!==1||!jQuery(cur).is(until))){
if(cur.nodeType===1){
matched.push(cur);
}
cur=cur[dir];
}
return matched;
},
nth:function(cur,result,dir,elem){
result=result||1;
var num=0;
for(;cur;cur=cur[dir]){
if(cur.nodeType===1&&++num===result){
break;
}
}
return cur;
},
sibling:function(n,elem){
var r=[];
for(;n;n=n.nextSibling){
if(n.nodeType===1&&n!==elem){
r.push(n);
}
}
return r;
}
});
function winnow(elements,qualifier,keep){
qualifier=qualifier||0;
if(jQuery.isFunction(qualifier)){
return jQuery.grep(elements,function(elem,i){
var retVal=!!qualifier.call(elem,i,elem);
return retVal===keep;
});
}else if(qualifier.nodeType){
return jQuery.grep(elements,function(elem,i){
return(elem===qualifier)===keep;
});
}else if(typeof qualifier==="string"){
var filtered=jQuery.grep(elements,function(elem){
return elem.nodeType===1;
});
if(isSimple.test(qualifier)){
return jQuery.filter(qualifier,filtered,!keep);
}else{
qualifier=jQuery.filter(qualifier,filtered);
}
}
return jQuery.grep(elements,function(elem,i){
return(jQuery.inArray(elem,qualifier)>=0)===keep;
});
}
function createSafeFragment(document){
var list=nodeNames.split("|"),
safeFrag=document.createDocumentFragment();
if(safeFrag.createElement){
while(list.length){
safeFrag.createElement(
list.pop()
);
}
}
return safeFrag;
}
var nodeNames="abbr|article|aside|audio|bdi|canvas|data|datalist|details|figcaption|figure|footer|"+
"header|hgroup|mark|meter|nav|output|progress|section|summary|time|video",
rinlinejQuery=/ jQuery\d+="(?:\d+|null)"/g,
rleadingWhitespace=/^\s+/,
rxhtmlTag=/<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/ig,
rtagName=/<([\w:]+)/,
rtbody=/<tbody/i,
rhtml=/<|&#?\w+;/,
rnoInnerhtml=/<(?:script|style)/i,
rnocache=/<(?:script|object|embed|option|style)/i,
rnoshimcache=new RegExp("<(?:"+nodeNames+")[\\s/>]","i"),
rchecked=/checked\s*(?:[^=]|=\s*.checked.)/i,
rscriptType=/\/(java|ecma)script/i,
rcleanScript=/^\s*<!(?:\[CDATA\[|\-\-)/,
wrapMap={
option:[1,"<select multiple='multiple'>","</select>"],
legend:[1,"<fieldset>","</fieldset>"],
thead:[1,"<table>","</table>"],
tr:[2,"<table><tbody>","</tbody></table>"],
td:[3,"<table><tbody><tr>","</tr></tbody></table>"],
col:[2,"<table><tbody></tbody><colgroup>","</colgroup></table>"],
area:[1,"<map>","</map>"],
_default:[0,"",""]
},
safeFragment=createSafeFragment(document);
wrapMap.optgroup=wrapMap.option;
wrapMap.tbody=wrapMap.tfoot=wrapMap.colgroup=wrapMap.caption=wrapMap.thead;
wrapMap.th=wrapMap.td;
if(!jQuery.support.htmlSerialize){
wrapMap._default=[1,"div<div>","</div>"];
}
jQuery.fn.extend({
text:function(value){
return jQuery.access(this,function(value){
return value===undefined?
jQuery.text(this):
this.empty().append((this[0]&&this[0].ownerDocument||document).createTextNode(value));
},null,value,arguments.length);
},
wrapAll:function(html){
if(jQuery.isFunction(html)){
return this.each(function(i){
jQuery(this).wrapAll(html.call(this,i));
});
}
if(this[0]){
var wrap=jQuery(html,this[0].ownerDocument).eq(0).clone(true);
if(this[0].parentNode){
wrap.insertBefore(this[0]);
}
wrap.map(function(){
var elem=this;
while(elem.firstChild&&elem.firstChild.nodeType===1){
elem=elem.firstChild;
}
return elem;
}).append(this);
}
return this;
},
wrapInner:function(html){
if(jQuery.isFunction(html)){
return this.each(function(i){
jQuery(this).wrapInner(html.call(this,i));
});
}
return this.each(function(){
var self=jQuery(this),
contents=self.contents();
if(contents.length){
contents.wrapAll(html);
}else{
self.append(html);
}
});
},
wrap:function(html){
var isFunction=jQuery.isFunction(html);
return this.each(function(i){
jQuery(this).wrapAll(isFunction?html.call(this,i):html);
});
},
unwrap:function(){
return this.parent().each(function(){
if(!jQuery.nodeName(this,"body")){
jQuery(this).replaceWith(this.childNodes);
}
}).end();
},
append:function(){
return this.domManip(arguments,true,function(elem){
if(this.nodeType===1){
this.appendChild(elem);
}
});
},
prepend:function(){
return this.domManip(arguments,true,function(elem){
if(this.nodeType===1){
this.insertBefore(elem,this.firstChild);
}
});
},
before:function(){
if(this[0]&&this[0].parentNode){
return this.domManip(arguments,false,function(elem){
this.parentNode.insertBefore(elem,this);
});
}else if(arguments.length){
var set=jQuery.clean(arguments);
set.push.apply(set,this.toArray());
return this.pushStack(set,"before",arguments);
}
},
after:function(){
if(this[0]&&this[0].parentNode){
return this.domManip(arguments,false,function(elem){
this.parentNode.insertBefore(elem,this.nextSibling);
});
}else if(arguments.length){
var set=this.pushStack(this,"after",arguments);
set.push.apply(set,jQuery.clean(arguments));
return set;
}
},
remove:function(selector,keepData){
for(var i=0,elem;(elem=this[i])!=null;i++){
if(!selector||jQuery.filter(selector,[elem]).length){
if(!keepData&&elem.nodeType===1){
jQuery.cleanData(elem.getElementsByTagName("*"));
jQuery.cleanData([elem]);
}
if(elem.parentNode){
elem.parentNode.removeChild(elem);
}
}
}
return this;
},
empty:function(){
for(var i=0,elem;(elem=this[i])!=null;i++){
if(elem.nodeType===1){
jQuery.cleanData(elem.getElementsByTagName("*"));
}
while(elem.firstChild){
elem.removeChild(elem.firstChild);
}
}
return this;
},
clone:function(dataAndEvents,deepDataAndEvents){
dataAndEvents=dataAndEvents==null?false:dataAndEvents;
deepDataAndEvents=deepDataAndEvents==null?dataAndEvents:deepDataAndEvents;
return this.map(function(){
return jQuery.clone(this,dataAndEvents,deepDataAndEvents);
});
},
html:function(value){
return jQuery.access(this,function(value){
var elem=this[0]||{},
i=0,
l=this.length;
if(value===undefined){
return elem.nodeType===1?
elem.innerHTML.replace(rinlinejQuery,""):
null;
}
if(typeof value==="string"&&!rnoInnerhtml.test(value)&&
(jQuery.support.leadingWhitespace||!rleadingWhitespace.test(value))&&
!wrapMap[(rtagName.exec(value)||["",""])[1].toLowerCase()]){
value=value.replace(rxhtmlTag,"<$1></$2>");
try{
for(;i<l;i++){
elem=this[i]||{};
if(elem.nodeType===1){
jQuery.cleanData(elem.getElementsByTagName("*"));
elem.innerHTML=value;
}
}
elem=0;
}catch(e){}
}
if(elem){
this.empty().append(value);
}
},null,value,arguments.length);
},
replaceWith:function(value){
if(this[0]&&this[0].parentNode){
if(jQuery.isFunction(value)){
return this.each(function(i){
var self=jQuery(this),old=self.html();
self.replaceWith(value.call(this,i,old));
});
}
if(typeof value!=="string"){
value=jQuery(value).detach();
}
return this.each(function(){
var next=this.nextSibling,
parent=this.parentNode;
jQuery(this).remove();
if(next){
jQuery(next).before(value);
}else{
jQuery(parent).append(value);
}
});
}else{
return this.length?
this.pushStack(jQuery(jQuery.isFunction(value)?value():value),"replaceWith",value):
this;
}
},
detach:function(selector){
return this.remove(selector,true);
},
domManip:function(args,table,callback){
var results,first,fragment,parent,
value=args[0],
scripts=[];
if(!jQuery.support.checkClone&&arguments.length===3&&typeof value==="string"&&rchecked.test(value)){
return this.each(function(){
jQuery(this).domManip(args,table,callback,true);
});
}
if(jQuery.isFunction(value)){
return this.each(function(i){
var self=jQuery(this);
args[0]=value.call(this,i,table?self.html():undefined);
self.domManip(args,table,callback);
});
}
if(this[0]){
parent=value&&value.parentNode;
if(jQuery.support.parentNode&&parent&&parent.nodeType===11&&parent.childNodes.length===this.length){
results={fragment:parent};
}else{
results=jQuery.buildFragment(args,this,scripts);
}
fragment=results.fragment;
if(fragment.childNodes.length===1){
first=fragment=fragment.firstChild;
}else{
first=fragment.firstChild;
}
if(first){
table=table&&jQuery.nodeName(first,"tr");
for(var i=0,l=this.length,lastIndex=l-1;i<l;i++){
callback.call(
table?
root(this[i],first):
this[i],
results.cacheable||(l>1&&i<lastIndex)?
jQuery.clone(fragment,true,true):
fragment
);
}
}
if(scripts.length){
jQuery.each(scripts,function(i,elem){
if(elem.src){
jQuery.ajax({
type:"GET",
global:false,
url:elem.src,
async:false,
dataType:"script"
});
}else{
jQuery.globalEval((elem.text||elem.textContent||elem.innerHTML||"").replace(rcleanScript,"/*$0*/"));
}
if(elem.parentNode){
elem.parentNode.removeChild(elem);
}
});
}
}
return this;
}
});
function root(elem,cur){
return jQuery.nodeName(elem,"table")?
(elem.getElementsByTagName("tbody")[0]||
elem.appendChild(elem.ownerDocument.createElement("tbody"))):
elem;
}
function cloneCopyEvent(src,dest){
if(dest.nodeType!==1||!jQuery.hasData(src)){
return;
}
var type,i,l,
oldData=jQuery._data(src),
curData=jQuery._data(dest,oldData),
events=oldData.events;
if(events){
delete curData.handle;
curData.events={};
for(type in events){
for(i=0,l=events[type].length;i<l;i++){
jQuery.event.add(dest,type,events[type][i]);
}
}
}
if(curData.data){
curData.data=jQuery.extend({},curData.data);
}
}
function cloneFixAttributes(src,dest){
var nodeName;
if(dest.nodeType!==1){
return;
}
if(dest.clearAttributes){
dest.clearAttributes();
}
if(dest.mergeAttributes){
dest.mergeAttributes(src);
}
nodeName=dest.nodeName.toLowerCase();
if(nodeName==="object"){
dest.outerHTML=src.outerHTML;
}else if(nodeName==="input"&&(src.type==="checkbox"||src.type==="radio")){
if(src.checked){
dest.defaultChecked=dest.checked=src.checked;
}
if(dest.value!==src.value){
dest.value=src.value;
}
}else if(nodeName==="option"){
dest.selected=src.defaultSelected;
}else if(nodeName==="input"||nodeName==="textarea"){
dest.defaultValue=src.defaultValue;
}else if(nodeName==="script"&&dest.text!==src.text){
dest.text=src.text;
}
dest.removeAttribute(jQuery.expando);
dest.removeAttribute("_submit_attached");
dest.removeAttribute("_change_attached");
}
jQuery.buildFragment=function(args,nodes,scripts){
var fragment,cacheable,cacheresults,doc,
first=args[0];
if(nodes&&nodes[0]){
doc=nodes[0].ownerDocument||nodes[0];
}
if(!doc.createDocumentFragment){
doc=document;
}
if(args.length===1&&typeof first==="string"&&first.length<512&&doc===document&&
first.charAt(0)==="<"&&!rnocache.test(first)&&
(jQuery.support.checkClone||!rchecked.test(first))&&
(jQuery.support.html5Clone||!rnoshimcache.test(first))){
cacheable=true;
cacheresults=jQuery.fragments[first];
if(cacheresults&&cacheresults!==1){
fragment=cacheresults;
}
}
if(!fragment){
fragment=doc.createDocumentFragment();
jQuery.clean(args,doc,fragment,scripts);
}
if(cacheable){
jQuery.fragments[first]=cacheresults?fragment:1;
}
return{fragment:fragment,cacheable:cacheable};
};
jQuery.fragments={};
jQuery.each({
appendTo:"append",
prependTo:"prepend",
insertBefore:"before",
insertAfter:"after",
replaceAll:"replaceWith"
},function(name,original){
jQuery.fn[name]=function(selector){
var ret=[],
insert=jQuery(selector),
parent=this.length===1&&this[0].parentNode;
if(parent&&parent.nodeType===11&&parent.childNodes.length===1&&insert.length===1){
insert[original](this[0]);
return this;
}else{
for(var i=0,l=insert.length;i<l;i++){
var elems=(i>0?this.clone(true):this).get();
jQuery(insert[i])[original](elems);
ret=ret.concat(elems);
}
return this.pushStack(ret,name,insert.selector);
}
};
});
function getAll(elem){
if(typeof elem.getElementsByTagName!=="undefined"){
return elem.getElementsByTagName("*");
}else if(typeof elem.querySelectorAll!=="undefined"){
return elem.querySelectorAll("*");
}else{
return[];
}
}
function fixDefaultChecked(elem){
if(elem.type==="checkbox"||elem.type==="radio"){
elem.defaultChecked=elem.checked;
}
}
function findInputs(elem){
var nodeName=(elem.nodeName||"").toLowerCase();
if(nodeName==="input"){
fixDefaultChecked(elem);
}else if(nodeName!=="script"&&typeof elem.getElementsByTagName!=="undefined"){
jQuery.grep(elem.getElementsByTagName("input"),fixDefaultChecked);
}
}
function shimCloneNode(elem){
var div=document.createElement("div");
safeFragment.appendChild(div);
div.innerHTML=elem.outerHTML;
return div.firstChild;
}
jQuery.extend({
clone:function(elem,dataAndEvents,deepDataAndEvents){
var srcElements,
destElements,
i,
clone=jQuery.support.html5Clone||jQuery.isXMLDoc(elem)||!rnoshimcache.test("<"+elem.nodeName+">")?
elem.cloneNode(true):
shimCloneNode(elem);
if((!jQuery.support.noCloneEvent||!jQuery.support.noCloneChecked)&&
(elem.nodeType===1||elem.nodeType===11)&&!jQuery.isXMLDoc(elem)){
cloneFixAttributes(elem,clone);
srcElements=getAll(elem);
destElements=getAll(clone);
for(i=0;srcElements[i];++i){
if(destElements[i]){
cloneFixAttributes(srcElements[i],destElements[i]);
}
}
}
if(dataAndEvents){
cloneCopyEvent(elem,clone);
if(deepDataAndEvents){
srcElements=getAll(elem);
destElements=getAll(clone);
for(i=0;srcElements[i];++i){
cloneCopyEvent(srcElements[i],destElements[i]);
}
}
}
srcElements=destElements=null;
return clone;
},
clean:function(elems,context,fragment,scripts){
var checkScriptType,script,j,
ret=[];
context=context||document;
if(typeof context.createElement==="undefined"){
context=context.ownerDocument||context[0]&&context[0].ownerDocument||document;
}
for(var i=0,elem;(elem=elems[i])!=null;i++){
if(typeof elem==="number"){
elem+="";
}
if(!elem){
continue;
}
if(typeof elem==="string"){
if(!rhtml.test(elem)){
elem=context.createTextNode(elem);
}else{
elem=elem.replace(rxhtmlTag,"<$1></$2>");
var tag=(rtagName.exec(elem)||["",""])[1].toLowerCase(),
wrap=wrapMap[tag]||wrapMap._default,
depth=wrap[0],
div=context.createElement("div"),
safeChildNodes=safeFragment.childNodes,
remove;
if(context===document){
safeFragment.appendChild(div);
}else{
createSafeFragment(context).appendChild(div);
}
div.innerHTML=wrap[1]+elem+wrap[2];
while(depth--){
div=div.lastChild;
}
if(!jQuery.support.tbody){
var hasBody=rtbody.test(elem),
tbody=tag==="table"&&!hasBody?
div.firstChild&&div.firstChild.childNodes:
wrap[1]==="<table>"&&!hasBody?
div.childNodes:
[];
for(j=tbody.length-1;j>=0;--j){
if(jQuery.nodeName(tbody[j],"tbody")&&!tbody[j].childNodes.length){
tbody[j].parentNode.removeChild(tbody[j]);
}
}
}
if(!jQuery.support.leadingWhitespace&&rleadingWhitespace.test(elem)){
div.insertBefore(context.createTextNode(rleadingWhitespace.exec(elem)[0]),div.firstChild);
}
elem=div.childNodes;
if(div){
div.parentNode.removeChild(div);
if(safeChildNodes.length>0){
remove=safeChildNodes[safeChildNodes.length-1];
if(remove&&remove.parentNode){
remove.parentNode.removeChild(remove);
}
}
}
}
}
var len;
if(!jQuery.support.appendChecked){
if(elem[0]&&typeof(len=elem.length)==="number"){
for(j=0;j<len;j++){
findInputs(elem[j]);
}
}else{
findInputs(elem);
}
}
if(elem.nodeType){
ret.push(elem);
}else{
ret=jQuery.merge(ret,elem);
}
}
if(fragment){
checkScriptType=function(elem){
return!elem.type||rscriptType.test(elem.type);
};
for(i=0;ret[i];i++){
script=ret[i];
if(scripts&&jQuery.nodeName(script,"script")&&(!script.type||rscriptType.test(script.type))){
scripts.push(script.parentNode?script.parentNode.removeChild(script):script);
}else{
if(script.nodeType===1){
var jsTags=jQuery.grep(script.getElementsByTagName("script"),checkScriptType);
ret.splice.apply(ret,[i+1,0].concat(jsTags));
}
fragment.appendChild(script);
}
}
}
return ret;
},
cleanData:function(elems){
var data,id,
cache=jQuery.cache,
special=jQuery.event.special,
deleteExpando=jQuery.support.deleteExpando;
for(var i=0,elem;(elem=elems[i])!=null;i++){
if(elem.nodeName&&jQuery.noData[elem.nodeName.toLowerCase()]){
continue;
}
id=elem[jQuery.expando];
if(id){
data=cache[id];
if(data&&data.events){
for(var type in data.events){
if(special[type]){
jQuery.event.remove(elem,type);
}else{
jQuery.removeEvent(elem,type,data.handle);
}
}
if(data.handle){
data.handle.elem=null;
}
}
if(deleteExpando){
delete elem[jQuery.expando];
}else if(elem.removeAttribute){
elem.removeAttribute(jQuery.expando);
}
delete cache[id];
}
}
}
});
var ralpha=/alpha\([^)]*\)/i,
ropacity=/opacity=([^)]*)/,
rupper=/([A-Z]|^ms)/g,
rnum=/^[\-+]?(?:\d*\.)?\d+$/i,
rnumnonpx=/^-?(?:\d*\.)?\d+(?!px)[^\d\s]+$/i,
rrelNum=/^([\-+])=([\-+.\de]+)/,
rmargin=/^margin/,
cssShow={position:"absolute",visibility:"hidden",display:"block"},
cssExpand=["Top","Right","Bottom","Left"],
curCSS,
getComputedStyle,
currentStyle;
jQuery.fn.css=function(name,value){
return jQuery.access(this,function(elem,name,value){
return value!==undefined?
jQuery.style(elem,name,value):
jQuery.css(elem,name);
},name,value,arguments.length>1);
};
jQuery.extend({
cssHooks:{
opacity:{
get:function(elem,computed){
if(computed){
var ret=curCSS(elem,"opacity");
return ret===""?"1":ret;
}else{
return elem.style.opacity;
}
}
}
},
cssNumber:{
"fillOpacity":true,
"fontWeight":true,
"lineHeight":true,
"opacity":true,
"orphans":true,
"widows":true,
"zIndex":true,
"zoom":true
},
cssProps:{
"float":jQuery.support.cssFloat?"cssFloat":"styleFloat"
},
style:function(elem,name,value,extra){
if(!elem||elem.nodeType===3||elem.nodeType===8||!elem.style){
return;
}
var ret,type,origName=jQuery.camelCase(name),
style=elem.style,hooks=jQuery.cssHooks[origName];
name=jQuery.cssProps[origName]||origName;
if(value!==undefined){
type=typeof value;
if(type==="string"&&(ret=rrelNum.exec(value))){
value=(+(ret[1]+1)*+ret[2])+parseFloat(jQuery.css(elem,name));
type="number";
}
if(value==null||type==="number"&&isNaN(value)){
return;
}
if(type==="number"&&!jQuery.cssNumber[origName]){
value+="px";
}
if(!hooks||!("set"in hooks)||(value=hooks.set(elem,value))!==undefined){
try{
style[name]=value;
}catch(e){}
}
}else{
if(hooks&&"get"in hooks&&(ret=hooks.get(elem,false,extra))!==undefined){
return ret;
}
return style[name];
}
},
css:function(elem,name,extra){
var ret,hooks;
name=jQuery.camelCase(name);
hooks=jQuery.cssHooks[name];
name=jQuery.cssProps[name]||name;
if(name==="cssFloat"){
name="float";
}
if(hooks&&"get"in hooks&&(ret=hooks.get(elem,true,extra))!==undefined){
return ret;
}else if(curCSS){
return curCSS(elem,name);
}
},
swap:function(elem,options,callback){
var old={},
ret,name;
for(name in options){
old[name]=elem.style[name];
elem.style[name]=options[name];
}
ret=callback.call(elem);
for(name in options){
elem.style[name]=old[name];
}
return ret;
}
});
jQuery.curCSS=jQuery.css;
if(document.defaultView&&document.defaultView.getComputedStyle){
getComputedStyle=function(elem,name){
var ret,defaultView,computedStyle,width,
style=elem.style;
name=name.replace(rupper,"-$1").toLowerCase();
if((defaultView=elem.ownerDocument.defaultView)&&
(computedStyle=defaultView.getComputedStyle(elem,null))){
ret=computedStyle.getPropertyValue(name);
if(ret===""&&!jQuery.contains(elem.ownerDocument.documentElement,elem)){
ret=jQuery.style(elem,name);
}
}
if(!jQuery.support.pixelMargin&&computedStyle&&rmargin.test(name)&&rnumnonpx.test(ret)){
width=style.width;
style.width=ret;
ret=computedStyle.width;
style.width=width;
}
return ret;
};
}
if(document.documentElement.currentStyle){
currentStyle=function(elem,name){
var left,rsLeft,uncomputed,
ret=elem.currentStyle&&elem.currentStyle[name],
style=elem.style;
if(ret==null&&style&&(uncomputed=style[name])){
ret=uncomputed;
}
if(rnumnonpx.test(ret)){
left=style.left;
rsLeft=elem.runtimeStyle&&elem.runtimeStyle.left;
if(rsLeft){
elem.runtimeStyle.left=elem.currentStyle.left;
}
style.left=name==="fontSize"?"1em":ret;
ret=style.pixelLeft+"px";
style.left=left;
if(rsLeft){
elem.runtimeStyle.left=rsLeft;
}
}
return ret===""?"auto":ret;
};
}
curCSS=getComputedStyle||currentStyle;
function getWidthOrHeight(elem,name,extra){
var val=name==="width"?elem.offsetWidth:elem.offsetHeight,
i=name==="width"?1:0,
len=4;
if(val>0){
if(extra!=="border"){
for(;i<len;i+=2){
if(!extra){
val-=parseFloat(jQuery.css(elem,"padding"+cssExpand[i]))||0;
}
if(extra==="margin"){
val+=parseFloat(jQuery.css(elem,extra+cssExpand[i]))||0;
}else{
val-=parseFloat(jQuery.css(elem,"border"+cssExpand[i]+"Width"))||0;
}
}
}
return val+"px";
}
val=curCSS(elem,name);
if(val<0||val==null){
val=elem.style[name];
}
if(rnumnonpx.test(val)){
return val;
}
val=parseFloat(val)||0;
if(extra){
for(;i<len;i+=2){
val+=parseFloat(jQuery.css(elem,"padding"+cssExpand[i]))||0;
if(extra!=="padding"){
val+=parseFloat(jQuery.css(elem,"border"+cssExpand[i]+"Width"))||0;
}
if(extra==="margin"){
val+=parseFloat(jQuery.css(elem,extra+cssExpand[i]))||0;
}
}
}
return val+"px";
}
jQuery.each(["height","width"],function(i,name){
jQuery.cssHooks[name]={
get:function(elem,computed,extra){
if(computed){
if(elem.offsetWidth!==0){
return getWidthOrHeight(elem,name,extra);
}else{
return jQuery.swap(elem,cssShow,function(){
return getWidthOrHeight(elem,name,extra);
});
}
}
},
set:function(elem,value){
return rnum.test(value)?
value+"px":
value;
}
};
});
if(!jQuery.support.opacity){
jQuery.cssHooks.opacity={
get:function(elem,computed){
return ropacity.test((computed&&elem.currentStyle?elem.currentStyle.filter:elem.style.filter)||"")?
(parseFloat(RegExp.$1)/100)+"":
computed?"1":"";
},
set:function(elem,value){
var style=elem.style,
currentStyle=elem.currentStyle,
opacity=jQuery.isNumeric(value)?"alpha(opacity="+value*100+")":"",
filter=currentStyle&&currentStyle.filter||style.filter||"";
style.zoom=1;
if(value>=1&&jQuery.trim(filter.replace(ralpha,""))===""){
style.removeAttribute("filter");
if(currentStyle&&!currentStyle.filter){
return;
}
}
style.filter=ralpha.test(filter)?
filter.replace(ralpha,opacity):
filter+" "+opacity;
}
};
}
jQuery(function(){
if(!jQuery.support.reliableMarginRight){
jQuery.cssHooks.marginRight={
get:function(elem,computed){
return jQuery.swap(elem,{"display":"inline-block"},function(){
if(computed){
return curCSS(elem,"margin-right");
}else{
return elem.style.marginRight;
}
});
}
};
}
});
if(jQuery.expr&&jQuery.expr.filters){
jQuery.expr.filters.hidden=function(elem){
var width=elem.offsetWidth,
height=elem.offsetHeight;
return(width===0&&height===0)||(!jQuery.support.reliableHiddenOffsets&&((elem.style&&elem.style.display)||jQuery.css(elem,"display"))==="none");
};
jQuery.expr.filters.visible=function(elem){
return!jQuery.expr.filters.hidden(elem);
};
}
jQuery.each({
margin:"",
padding:"",
border:"Width"
},function(prefix,suffix){
jQuery.cssHooks[prefix+suffix]={
expand:function(value){
var i,
parts=typeof value==="string"?value.split(" "):[value],
expanded={};
for(i=0;i<4;i++){
expanded[prefix+cssExpand[i]+suffix]=
parts[i]||parts[i-2]||parts[0];
}
return expanded;
}
};
});
var r20=/%20/g,
rbracket=/\[\]$/,
rCRLF=/\r?\n/g,
rhash=/#.*$/,
rheaders=/^(.*?):[ \t]*([^\r\n]*)\r?$/mg,
rinput=/^(?:color|date|datetime|datetime-local|email|hidden|month|number|password|range|search|tel|text|time|url|week)$/i,
rlocalProtocol=/^(?:about|app|app\-storage|.+\-extension|file|res|widget):$/,
rnoContent=/^(?:GET|HEAD)$/,
rprotocol=/^\/\//,
rquery=/\?/,
rscript=/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi,
rselectTextarea=/^(?:select|textarea)/i,
rspacesAjax=/\s+/,
rts=/([?&])_=[^&]*/,
rurl=/^([\w\+\.\-]+:)(?:\/\/([^\/?#:]*)(?::(\d+))?)?/,
_load=jQuery.fn.load,
prefilters={},
transports={},
ajaxLocation,
ajaxLocParts,
allTypes=["*/"]+["*"];
try{
ajaxLocation=location.href;
}catch(e){
ajaxLocation=document.createElement("a");
ajaxLocation.href="";
ajaxLocation=ajaxLocation.href;
}
ajaxLocParts=rurl.exec(ajaxLocation.toLowerCase())||[];
function addToPrefiltersOrTransports(structure){
return function(dataTypeExpression,func){
if(typeof dataTypeExpression!=="string"){
func=dataTypeExpression;
dataTypeExpression="*";
}
if(jQuery.isFunction(func)){
var dataTypes=dataTypeExpression.toLowerCase().split(rspacesAjax),
i=0,
length=dataTypes.length,
dataType,
list,
placeBefore;
for(;i<length;i++){
dataType=dataTypes[i];
placeBefore=/^\+/.test(dataType);
if(placeBefore){
dataType=dataType.substr(1)||"*";
}
list=structure[dataType]=structure[dataType]||[];
list[placeBefore?"unshift":"push"](func);
}
}
};
}
function inspectPrefiltersOrTransports(structure,options,originalOptions,jqXHR,
dataType,inspected){
dataType=dataType||options.dataTypes[0];
inspected=inspected||{};
inspected[dataType]=true;
var list=structure[dataType],
i=0,
length=list?list.length:0,
executeOnly=(structure===prefilters),
selection;
for(;i<length&&(executeOnly||!selection);i++){
selection=list[i](options,originalOptions,jqXHR);
if(typeof selection==="string"){
if(!executeOnly||inspected[selection]){
selection=undefined;
}else{
options.dataTypes.unshift(selection);
selection=inspectPrefiltersOrTransports(
structure,options,originalOptions,jqXHR,selection,inspected);
}
}
}
if((executeOnly||!selection)&&!inspected["*"]){
selection=inspectPrefiltersOrTransports(
structure,options,originalOptions,jqXHR,"*",inspected);
}
return selection;
}
function ajaxExtend(target,src){
var key,deep,
flatOptions=jQuery.ajaxSettings.flatOptions||{};
for(key in src){
if(src[key]!==undefined){
(flatOptions[key]?target:(deep||(deep={})))[key]=src[key];
}
}
if(deep){
jQuery.extend(true,target,deep);
}
}
jQuery.fn.extend({
load:function(url,params,callback){
if(typeof url!=="string"&&_load){
return _load.apply(this,arguments);
}else if(!this.length){
return this;
}
var off=url.indexOf(" ");
if(off>=0){
var selector=url.slice(off,url.length);
url=url.slice(0,off);
}
var type="GET";
if(params){
if(jQuery.isFunction(params)){
callback=params;
params=undefined;
}else if(typeof params==="object"){
params=jQuery.param(params,jQuery.ajaxSettings.traditional);
type="POST";
}
}
var self=this;
jQuery.ajax({
url:url,
type:type,
dataType:"html",
data:params,
complete:function(jqXHR,status,responseText){
responseText=jqXHR.responseText;
if(jqXHR.isResolved()){
jqXHR.done(function(r){
responseText=r;
});
self.html(selector?
jQuery("<div>")
.append(responseText.replace(rscript,""))
.find(selector):
responseText);
}
if(callback){
self.each(callback,[responseText,status,jqXHR]);
}
}
});
return this;
},
serialize:function(){
return jQuery.param(this.serializeArray());
},
serializeArray:function(){
return this.map(function(){
return this.elements?jQuery.makeArray(this.elements):this;
})
.filter(function(){
return this.name&&!this.disabled&&
(this.checked||rselectTextarea.test(this.nodeName)||
rinput.test(this.type));
})
.map(function(i,elem){
var val=jQuery(this).val();
return val==null?
null:
jQuery.isArray(val)?
jQuery.map(val,function(val,i){
return{name:elem.name,value:val.replace(rCRLF,"\r\n")};
}):
{name:elem.name,value:val.replace(rCRLF,"\r\n")};
}).get();
}
});
jQuery.each("ajaxStart ajaxStop ajaxComplete ajaxError ajaxSuccess ajaxSend".split(" "),function(i,o){
jQuery.fn[o]=function(f){
return this.on(o,f);
};
});
jQuery.each(["get","post"],function(i,method){
jQuery[method]=function(url,data,callback,type){
if(jQuery.isFunction(data)){
type=type||callback;
callback=data;
data=undefined;
}
return jQuery.ajax({
type:method,
url:url,
data:data,
success:callback,
dataType:type
});
};
});
jQuery.extend({
getScript:function(url,callback){
return jQuery.get(url,undefined,callback,"script");
},
getJSON:function(url,data,callback){
return jQuery.get(url,data,callback,"json");
},
ajaxSetup:function(target,settings){
if(settings){
ajaxExtend(target,jQuery.ajaxSettings);
}else{
settings=target;
target=jQuery.ajaxSettings;
}
ajaxExtend(target,settings);
return target;
},
ajaxSettings:{
url:ajaxLocation,
isLocal:rlocalProtocol.test(ajaxLocParts[1]),
global:true,
type:"GET",
contentType:"application/x-www-form-urlencoded; charset=UTF-8",
processData:true,
async:true,
accepts:{
xml:"application/xml, text/xml",
html:"text/html",
text:"text/plain",
json:"application/json, text/javascript",
"*":allTypes
},
contents:{
xml:/xml/,
html:/html/,
json:/json/
},
responseFields:{
xml:"responseXML",
text:"responseText"
},
converters:{
"* text":window.String,
"text html":true,
"text json":jQuery.parseJSON,
"text xml":jQuery.parseXML
},
flatOptions:{
context:true,
url:true
}
},
ajaxPrefilter:addToPrefiltersOrTransports(prefilters),
ajaxTransport:addToPrefiltersOrTransports(transports),
ajax:function(url,options){
if(typeof url==="object"){
options=url;
url=undefined;
}
options=options||{};
var
s=jQuery.ajaxSetup({},options),
callbackContext=s.context||s,
globalEventContext=callbackContext!==s&&
(callbackContext.nodeType||callbackContext instanceof jQuery)?
jQuery(callbackContext):jQuery.event,
deferred=jQuery.Deferred(),
completeDeferred=jQuery.Callbacks("once memory"),
statusCode=s.statusCode||{},
ifModifiedKey,
requestHeaders={},
requestHeadersNames={},
responseHeadersString,
responseHeaders,
transport,
timeoutTimer,
parts,
state=0,
fireGlobals,
i,
jqXHR={
readyState:0,
setRequestHeader:function(name,value){
if(!state){
var lname=name.toLowerCase();
name=requestHeadersNames[lname]=requestHeadersNames[lname]||name;
requestHeaders[name]=value;
}
return this;
},
getAllResponseHeaders:function(){
return state===2?responseHeadersString:null;
},
getResponseHeader:function(key){
var match;
if(state===2){
if(!responseHeaders){
responseHeaders={};
while((match=rheaders.exec(responseHeadersString))){
responseHeaders[match[1].toLowerCase()]=match[2];
}
}
match=responseHeaders[key.toLowerCase()];
}
return match===undefined?null:match;
},
overrideMimeType:function(type){
if(!state){
s.mimeType=type;
}
return this;
},
abort:function(statusText){
statusText=statusText||"abort";
if(transport){
transport.abort(statusText);
}
done(0,statusText);
return this;
}
};
function done(status,nativeStatusText,responses,headers){
if(state===2){
return;
}
state=2;
if(timeoutTimer){
clearTimeout(timeoutTimer);
}
transport=undefined;
responseHeadersString=headers||"";
jqXHR.readyState=status>0?4:0;
var isSuccess,
success,
error,
statusText=nativeStatusText,
response=responses?ajaxHandleResponses(s,jqXHR,responses):undefined,
lastModified,
etag;
if(status>=200&&status<300||status===304){
if(s.ifModified){
if((lastModified=jqXHR.getResponseHeader("Last-Modified"))){
jQuery.lastModified[ifModifiedKey]=lastModified;
}
if((etag=jqXHR.getResponseHeader("Etag"))){
jQuery.etag[ifModifiedKey]=etag;
}
}
if(status===304){
statusText="notmodified";
isSuccess=true;
}else{
try{
success=ajaxConvert(s,response);
statusText="success";
isSuccess=true;
}catch(e){
statusText="parsererror";
error=e;
}
}
}else{
error=statusText;
if(!statusText||status){
statusText="error";
if(status<0){
status=0;
}
}
}
jqXHR.status=status;
jqXHR.statusText=""+(nativeStatusText||statusText);
if(isSuccess){
deferred.resolveWith(callbackContext,[success,statusText,jqXHR]);
}else{
deferred.rejectWith(callbackContext,[jqXHR,statusText,error]);
}
jqXHR.statusCode(statusCode);
statusCode=undefined;
if(fireGlobals){
globalEventContext.trigger("ajax"+(isSuccess?"Success":"Error"),
[jqXHR,s,isSuccess?success:error]);
}
completeDeferred.fireWith(callbackContext,[jqXHR,statusText]);
if(fireGlobals){
globalEventContext.trigger("ajaxComplete",[jqXHR,s]);
if(!(--jQuery.active)){
jQuery.event.trigger("ajaxStop");
}
}
}
deferred.promise(jqXHR);
jqXHR.success=jqXHR.done;
jqXHR.error=jqXHR.fail;
jqXHR.complete=completeDeferred.add;
jqXHR.statusCode=function(map){
if(map){
var tmp;
if(state<2){
for(tmp in map){
statusCode[tmp]=[statusCode[tmp],map[tmp]];
}
}else{
tmp=map[jqXHR.status];
jqXHR.then(tmp,tmp);
}
}
return this;
};
s.url=((url||s.url)+"").replace(rhash,"").replace(rprotocol,ajaxLocParts[1]+"//");
s.dataTypes=jQuery.trim(s.dataType||"*").toLowerCase().split(rspacesAjax);
if(s.crossDomain==null){
parts=rurl.exec(s.url.toLowerCase());
s.crossDomain=!!(parts&&
(parts[1]!=ajaxLocParts[1]||parts[2]!=ajaxLocParts[2]||
(parts[3]||(parts[1]==="http:"?80:443))!=
(ajaxLocParts[3]||(ajaxLocParts[1]==="http:"?80:443)))
);
}
if(s.data&&s.processData&&typeof s.data!=="string"){
s.data=jQuery.param(s.data,s.traditional);
}
inspectPrefiltersOrTransports(prefilters,s,options,jqXHR);
if(state===2){
return false;
}
fireGlobals=s.global;
s.type=s.type.toUpperCase();
s.hasContent=!rnoContent.test(s.type);
if(fireGlobals&&jQuery.active++===0){
jQuery.event.trigger("ajaxStart");
}
if(!s.hasContent){
if(s.data){
s.url+=(rquery.test(s.url)?"&":"?")+s.data;
delete s.data;
}
ifModifiedKey=s.url;
if(s.cache===false){
var ts=jQuery.now(),
ret=s.url.replace(rts,"$1_="+ts);
s.url=ret+((ret===s.url)?(rquery.test(s.url)?"&":"?")+"_="+ts:"");
}
}
if(s.data&&s.hasContent&&s.contentType!==false||options.contentType){
jqXHR.setRequestHeader("Content-Type",s.contentType);
}
if(s.ifModified){
ifModifiedKey=ifModifiedKey||s.url;
if(jQuery.lastModified[ifModifiedKey]){
jqXHR.setRequestHeader("If-Modified-Since",jQuery.lastModified[ifModifiedKey]);
}
if(jQuery.etag[ifModifiedKey]){
jqXHR.setRequestHeader("If-None-Match",jQuery.etag[ifModifiedKey]);
}
}
jqXHR.setRequestHeader(
"Accept",
s.dataTypes[0]&&s.accepts[s.dataTypes[0]]?
s.accepts[s.dataTypes[0]]+(s.dataTypes[0]!=="*"?", "+allTypes+"; q=0.01":""):
s.accepts["*"]
);
for(i in s.headers){
jqXHR.setRequestHeader(i,s.headers[i]);
}
if(s.beforeSend&&(s.beforeSend.call(callbackContext,jqXHR,s)===false||state===2)){
jqXHR.abort();
return false;
}
for(i in{success:1,error:1,complete:1}){
jqXHR[i](s[i]);
}
transport=inspectPrefiltersOrTransports(transports,s,options,jqXHR);
if(!transport){
done(-1,"No Transport");
}else{
jqXHR.readyState=1;
if(fireGlobals){
globalEventContext.trigger("ajaxSend",[jqXHR,s]);
}
if(s.async&&s.timeout>0){
timeoutTimer=setTimeout(function(){
jqXHR.abort("timeout");
},s.timeout);
}
try{
state=1;
transport.send(requestHeaders,done);
}catch(e){
if(state<2){
done(-1,e);
}else{
throw e;
}
}
}
return jqXHR;
},
param:function(a,traditional){
var s=[],
add=function(key,value){
value=jQuery.isFunction(value)?value():value;
s[s.length]=encodeURIComponent(key)+"="+encodeURIComponent(value);
};
if(traditional===undefined){
traditional=jQuery.ajaxSettings.traditional;
}
if(jQuery.isArray(a)||(a.jquery&&!jQuery.isPlainObject(a))){
jQuery.each(a,function(){
add(this.name,this.value);
});
}else{
for(var prefix in a){
buildParams(prefix,a[prefix],traditional,add);
}
}
return s.join("&").replace(r20,"+");
}
});
function buildParams(prefix,obj,traditional,add){
if(jQuery.isArray(obj)){
jQuery.each(obj,function(i,v){
if(traditional||rbracket.test(prefix)){
add(prefix,v);
}else{
buildParams(prefix+"["+(typeof v==="object"?i:"")+"]",v,traditional,add);
}
});
}else if(!traditional&&jQuery.type(obj)==="object"){
for(var name in obj){
buildParams(prefix+"["+name+"]",obj[name],traditional,add);
}
}else{
add(prefix,obj);
}
}
jQuery.extend({
active:0,
lastModified:{},
etag:{}
});
function ajaxHandleResponses(s,jqXHR,responses){
var contents=s.contents,
dataTypes=s.dataTypes,
responseFields=s.responseFields,
ct,
type,
finalDataType,
firstDataType;
for(type in responseFields){
if(type in responses){
jqXHR[responseFields[type]]=responses[type];
}
}
while(dataTypes[0]==="*"){
dataTypes.shift();
if(ct===undefined){
ct=s.mimeType||jqXHR.getResponseHeader("content-type");
}
}
if(ct){
for(type in contents){
if(contents[type]&&contents[type].test(ct)){
dataTypes.unshift(type);
break;
}
}
}
if(dataTypes[0]in responses){
finalDataType=dataTypes[0];
}else{
for(type in responses){
if(!dataTypes[0]||s.converters[type+" "+dataTypes[0]]){
finalDataType=type;
break;
}
if(!firstDataType){
firstDataType=type;
}
}
finalDataType=finalDataType||firstDataType;
}
if(finalDataType){
if(finalDataType!==dataTypes[0]){
dataTypes.unshift(finalDataType);
}
return responses[finalDataType];
}
}
function ajaxConvert(s,response){
if(s.dataFilter){
response=s.dataFilter(response,s.dataType);
}
var dataTypes=s.dataTypes,
converters={},
i,
key,
length=dataTypes.length,
tmp,
current=dataTypes[0],
prev,
conversion,
conv,
conv1,
conv2;
for(i=1;i<length;i++){
if(i===1){
for(key in s.converters){
if(typeof key==="string"){
converters[key.toLowerCase()]=s.converters[key];
}
}
}
prev=current;
current=dataTypes[i];
if(current==="*"){
current=prev;
}else if(prev!=="*"&&prev!==current){
conversion=prev+" "+current;
conv=converters[conversion]||converters["* "+current];
if(!conv){
conv2=undefined;
for(conv1 in converters){
tmp=conv1.split(" ");
if(tmp[0]===prev||tmp[0]==="*"){
conv2=converters[tmp[1]+" "+current];
if(conv2){
conv1=converters[conv1];
if(conv1===true){
conv=conv2;
}else if(conv2===true){
conv=conv1;
}
break;
}
}
}
}
if(!(conv||conv2)){
jQuery.error("No conversion from "+conversion.replace(" "," to "));
}
if(conv!==true){
response=conv?conv(response):conv2(conv1(response));
}
}
}
return response;
}
var jsc=jQuery.now(),
jsre=/(\=)\?(&|$)|\?\?/i;
jQuery.ajaxSetup({
jsonp:"callback",
jsonpCallback:function(){
return jQuery.expando+"_"+(jsc++);
}
});
jQuery.ajaxPrefilter("json jsonp",function(s,originalSettings,jqXHR){
var inspectData=(typeof s.data==="string")&&/^application\/x\-www\-form\-urlencoded/.test(s.contentType);
if(s.dataTypes[0]==="jsonp"||
s.jsonp!==false&&(jsre.test(s.url)||
inspectData&&jsre.test(s.data))){
var responseContainer,
jsonpCallback=s.jsonpCallback=
jQuery.isFunction(s.jsonpCallback)?s.jsonpCallback():s.jsonpCallback,
previous=window[jsonpCallback],
url=s.url,
data=s.data,
replace="$1"+jsonpCallback+"$2";
if(s.jsonp!==false){
url=url.replace(jsre,replace);
if(s.url===url){
if(inspectData){
data=data.replace(jsre,replace);
}
if(s.data===data){
url+=(/\?/.test(url)?"&":"?")+s.jsonp+"="+jsonpCallback;
}
}
}
s.url=url;
s.data=data;
window[jsonpCallback]=function(response){
responseContainer=[response];
};
jqXHR.always(function(){
window[jsonpCallback]=previous;
if(responseContainer&&jQuery.isFunction(previous)){
window[jsonpCallback](responseContainer[0]);
}
});
s.converters["script json"]=function(){
if(!responseContainer){
jQuery.error(jsonpCallback+" was not called");
}
return responseContainer[0];
};
s.dataTypes[0]="json";
return"script";
}
});
jQuery.ajaxSetup({
accepts:{
script:"text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"
},
contents:{
script:/javascript|ecmascript/
},
converters:{
"text script":function(text){
jQuery.globalEval(text);
return text;
}
}
});
jQuery.ajaxPrefilter("script",function(s){
if(s.cache===undefined){
s.cache=false;
}
if(s.crossDomain){
s.type="GET";
s.global=false;
}
});
jQuery.ajaxTransport("script",function(s){
if(s.crossDomain){
var script,
head=document.head||document.getElementsByTagName("head")[0]||document.documentElement;
return{
send:function(_,callback){
script=document.createElement("script");
script.async="async";
if(s.scriptCharset){
script.charset=s.scriptCharset;
}
script.src=s.url;
script.onload=script.onreadystatechange=function(_,isAbort){
if(isAbort||!script.readyState||/loaded|complete/.test(script.readyState)){
script.onload=script.onreadystatechange=null;
if(head&&script.parentNode){
head.removeChild(script);
}
script=undefined;
if(!isAbort){
callback(200,"success");
}
}
};
head.insertBefore(script,head.firstChild);
},
abort:function(){
if(script){
script.onload(0,1);
}
}
};
}
});
var
xhrOnUnloadAbort=window.ActiveXObject?function(){
for(var key in xhrCallbacks){
xhrCallbacks[key](0,1);
}
}:false,
xhrId=0,
xhrCallbacks;
function createStandardXHR(){
try{
return new window.XMLHttpRequest();
}catch(e){}
}
function createActiveXHR(){
try{
return new window.ActiveXObject("Microsoft.XMLHTTP");
}catch(e){}
}
jQuery.ajaxSettings.xhr=window.ActiveXObject?
function(){
return!this.isLocal&&createStandardXHR()||createActiveXHR();
}:
createStandardXHR;
(function(xhr){
jQuery.extend(jQuery.support,{
ajax:!!xhr,
cors:!!xhr&&("withCredentials"in xhr)
});
})(jQuery.ajaxSettings.xhr());
if(jQuery.support.ajax){
jQuery.ajaxTransport(function(s){
if(!s.crossDomain||jQuery.support.cors){
var callback;
return{
send:function(headers,complete){
var xhr=s.xhr(),
handle,
i;
if(s.username){
xhr.open(s.type,s.url,s.async,s.username,s.password);
}else{
xhr.open(s.type,s.url,s.async);
}
if(s.xhrFields){
for(i in s.xhrFields){
xhr[i]=s.xhrFields[i];
}
}
if(s.mimeType&&xhr.overrideMimeType){
xhr.overrideMimeType(s.mimeType);
}
if(!s.crossDomain&&!headers["X-Requested-With"]){
headers["X-Requested-With"]="XMLHttpRequest";
}
try{
for(i in headers){
xhr.setRequestHeader(i,headers[i]);
}
}catch(_){}
xhr.send((s.hasContent&&s.data)||null);
callback=function(_,isAbort){
var status,
statusText,
responseHeaders,
responses,
xml;
try{
if(callback&&(isAbort||xhr.readyState===4)){
callback=undefined;
if(handle){
xhr.onreadystatechange=jQuery.noop;
if(xhrOnUnloadAbort){
delete xhrCallbacks[handle];
}
}
if(isAbort){
if(xhr.readyState!==4){
xhr.abort();
}
}else{
status=xhr.status;
responseHeaders=xhr.getAllResponseHeaders();
responses={};
xml=xhr.responseXML;
if(xml&&xml.documentElement){
responses.xml=xml;
}
try{
responses.text=xhr.responseText;
}catch(_){
}
try{
statusText=xhr.statusText;
}catch(e){
statusText="";
}
if(!status&&s.isLocal&&!s.crossDomain){
status=responses.text?200:404;
}else if(status===1223){
status=204;
}
}
}
}catch(firefoxAccessException){
if(!isAbort){
complete(-1,firefoxAccessException);
}
}
if(responses){
complete(status,statusText,responses,responseHeaders);
}
};
if(!s.async||xhr.readyState===4){
callback();
}else{
handle=++xhrId;
if(xhrOnUnloadAbort){
if(!xhrCallbacks){
xhrCallbacks={};
jQuery(window).unload(xhrOnUnloadAbort);
}
xhrCallbacks[handle]=callback;
}
xhr.onreadystatechange=callback;
}
},
abort:function(){
if(callback){
callback(0,1);
}
}
};
}
});
}
var elemdisplay={},
iframe,iframeDoc,
rfxtypes=/^(?:toggle|show|hide)$/,
rfxnum=/^([+\-]=)?([\d+.\-]+)([a-z%]*)$/i,
timerId,
fxAttrs=[
["height","marginTop","marginBottom","paddingTop","paddingBottom"],
["width","marginLeft","marginRight","paddingLeft","paddingRight"],
["opacity"]
],
fxNow;
jQuery.fn.extend({
show:function(speed,easing,callback){
var elem,display;
if(speed||speed===0){
return this.animate(genFx("show",3),speed,easing,callback);
}else{
for(var i=0,j=this.length;i<j;i++){
elem=this[i];
if(elem.style){
display=elem.style.display;
if(!jQuery._data(elem,"olddisplay")&&display==="none"){
display=elem.style.display="";
}
if((display===""&&jQuery.css(elem,"display")==="none")||
!jQuery.contains(elem.ownerDocument.documentElement,elem)){
jQuery._data(elem,"olddisplay",defaultDisplay(elem.nodeName));
}
}
}
for(i=0;i<j;i++){
elem=this[i];
if(elem.style){
display=elem.style.display;
if(display===""||display==="none"){
elem.style.display=jQuery._data(elem,"olddisplay")||"";
}
}
}
return this;
}
},
hide:function(speed,easing,callback){
if(speed||speed===0){
return this.animate(genFx("hide",3),speed,easing,callback);
}else{
var elem,display,
i=0,
j=this.length;
for(;i<j;i++){
elem=this[i];
if(elem.style){
display=jQuery.css(elem,"display");
if(display!=="none"&&!jQuery._data(elem,"olddisplay")){
jQuery._data(elem,"olddisplay",display);
}
}
}
for(i=0;i<j;i++){
if(this[i].style){
this[i].style.display="none";
}
}
return this;
}
},
_toggle:jQuery.fn.toggle,
toggle:function(fn,fn2,callback){
var bool=typeof fn==="boolean";
if(jQuery.isFunction(fn)&&jQuery.isFunction(fn2)){
this._toggle.apply(this,arguments);
}else if(fn==null||bool){
this.each(function(){
var state=bool?fn:jQuery(this).is(":hidden");
jQuery(this)[state?"show":"hide"]();
});
}else{
this.animate(genFx("toggle",3),fn,fn2,callback);
}
return this;
},
fadeTo:function(speed,to,easing,callback){
return this.filter(":hidden").css("opacity",0).show().end()
.animate({opacity:to},speed,easing,callback);
},
animate:function(prop,speed,easing,callback){
var optall=jQuery.speed(speed,easing,callback);
if(jQuery.isEmptyObject(prop)){
return this.each(optall.complete,[false]);
}
prop=jQuery.extend({},prop);
function doAnimation(){
if(optall.queue===false){
jQuery._mark(this);
}
var opt=jQuery.extend({},optall),
isElement=this.nodeType===1,
hidden=isElement&&jQuery(this).is(":hidden"),
name,val,p,e,hooks,replace,
parts,start,end,unit,
method;
opt.animatedProperties={};
for(p in prop){
name=jQuery.camelCase(p);
if(p!==name){
prop[name]=prop[p];
delete prop[p];
}
if((hooks=jQuery.cssHooks[name])&&"expand"in hooks){
replace=hooks.expand(prop[name]);
delete prop[name];
for(p in replace){
if(!(p in prop)){
prop[p]=replace[p];
}
}
}
}
for(name in prop){
val=prop[name];
if(jQuery.isArray(val)){
opt.animatedProperties[name]=val[1];
val=prop[name]=val[0];
}else{
opt.animatedProperties[name]=opt.specialEasing&&opt.specialEasing[name]||opt.easing||'swing';
}
if(val==="hide"&&hidden||val==="show"&&!hidden){
return opt.complete.call(this);
}
if(isElement&&(name==="height"||name==="width")){
opt.overflow=[this.style.overflow,this.style.overflowX,this.style.overflowY];
if(jQuery.css(this,"display")==="inline"&&
jQuery.css(this,"float")==="none"){
if(!jQuery.support.inlineBlockNeedsLayout||defaultDisplay(this.nodeName)==="inline"){
this.style.display="inline-block";
}else{
this.style.zoom=1;
}
}
}
}
if(opt.overflow!=null){
this.style.overflow="hidden";
}
for(p in prop){
e=new jQuery.fx(this,opt,p);
val=prop[p];
if(rfxtypes.test(val)){
method=jQuery._data(this,"toggle"+p)||(val==="toggle"?hidden?"show":"hide":0);
if(method){
jQuery._data(this,"toggle"+p,method==="show"?"hide":"show");
e[method]();
}else{
e[val]();
}
}else{
parts=rfxnum.exec(val);
start=e.cur();
if(parts){
end=parseFloat(parts[2]);
unit=parts[3]||(jQuery.cssNumber[p]?"":"px");
if(unit!=="px"){
jQuery.style(this,p,(end||1)+unit);
start=((end||1)/e.cur())*start;
jQuery.style(this,p,start+unit);
}
if(parts[1]){
end=((parts[1]==="-="?-1:1)*end)+start;
}
e.custom(start,end,unit);
}else{
e.custom(start,val,"");
}
}
}
return true;
}
return optall.queue===false?
this.each(doAnimation):
this.queue(optall.queue,doAnimation);
},
stop:function(type,clearQueue,gotoEnd){
if(typeof type!=="string"){
gotoEnd=clearQueue;
clearQueue=type;
type=undefined;
}
if(clearQueue&&type!==false){
this.queue(type||"fx",[]);
}
return this.each(function(){
var index,
hadTimers=false,
timers=jQuery.timers,
data=jQuery._data(this);
if(!gotoEnd){
jQuery._unmark(true,this);
}
function stopQueue(elem,data,index){
var hooks=data[index];
jQuery.removeData(elem,index,true);
hooks.stop(gotoEnd);
}
if(type==null){
for(index in data){
if(data[index]&&data[index].stop&&index.indexOf(".run")===index.length-4){
stopQueue(this,data,index);
}
}
}else if(data[index=type+".run"]&&data[index].stop){
stopQueue(this,data,index);
}
for(index=timers.length;index--;){
if(timers[index].elem===this&&(type==null||timers[index].queue===type)){
if(gotoEnd){
timers[index](true);
}else{
timers[index].saveState();
}
hadTimers=true;
timers.splice(index,1);
}
}
if(!(gotoEnd&&hadTimers)){
jQuery.dequeue(this,type);
}
});
}
});
function createFxNow(){
setTimeout(clearFxNow,0);
return(fxNow=jQuery.now());
}
function clearFxNow(){
fxNow=undefined;
}
function genFx(type,num){
var obj={};
jQuery.each(fxAttrs.concat.apply([],fxAttrs.slice(0,num)),function(){
obj[this]=type;
});
return obj;
}
jQuery.each({
slideDown:genFx("show",1),
slideUp:genFx("hide",1),
slideToggle:genFx("toggle",1),
fadeIn:{opacity:"show"},
fadeOut:{opacity:"hide"},
fadeToggle:{opacity:"toggle"}
},function(name,props){
jQuery.fn[name]=function(speed,easing,callback){
return this.animate(props,speed,easing,callback);
};
});
jQuery.extend({
speed:function(speed,easing,fn){
var opt=speed&&typeof speed==="object"?jQuery.extend({},speed):{
complete:fn||!fn&&easing||
jQuery.isFunction(speed)&&speed,
duration:speed,
easing:fn&&easing||easing&&!jQuery.isFunction(easing)&&easing
};
opt.duration=jQuery.fx.off?0:typeof opt.duration==="number"?opt.duration:
opt.duration in jQuery.fx.speeds?jQuery.fx.speeds[opt.duration]:jQuery.fx.speeds._default;
if(opt.queue==null||opt.queue===true){
opt.queue="fx";
}
opt.old=opt.complete;
opt.complete=function(noUnmark){
if(jQuery.isFunction(opt.old)){
opt.old.call(this);
}
if(opt.queue){
jQuery.dequeue(this,opt.queue);
}else if(noUnmark!==false){
jQuery._unmark(this);
}
};
return opt;
},
easing:{
linear:function(p){
return p;
},
swing:function(p){
return(-Math.cos(p*Math.PI)/2)+0.5;
}
},
timers:[],
fx:function(elem,options,prop){
this.options=options;
this.elem=elem;
this.prop=prop;
options.orig=options.orig||{};
}
});
jQuery.fx.prototype={
update:function(){
if(this.options.step){
this.options.step.call(this.elem,this.now,this);
}
(jQuery.fx.step[this.prop]||jQuery.fx.step._default)(this);
},
cur:function(){
if(this.elem[this.prop]!=null&&(!this.elem.style||this.elem.style[this.prop]==null)){
return this.elem[this.prop];
}
var parsed,
r=jQuery.css(this.elem,this.prop);
return isNaN(parsed=parseFloat(r))?!r||r==="auto"?0:r:parsed;
},
custom:function(from,to,unit){
var self=this,
fx=jQuery.fx;
this.startTime=fxNow||createFxNow();
this.end=to;
this.now=this.start=from;
this.pos=this.state=0;
this.unit=unit||this.unit||(jQuery.cssNumber[this.prop]?"":"px");
function t(gotoEnd){
return self.step(gotoEnd);
}
t.queue=this.options.queue;
t.elem=this.elem;
t.saveState=function(){
if(jQuery._data(self.elem,"fxshow"+self.prop)===undefined){
if(self.options.hide){
jQuery._data(self.elem,"fxshow"+self.prop,self.start);
}else if(self.options.show){
jQuery._data(self.elem,"fxshow"+self.prop,self.end);
}
}
};
if(t()&&jQuery.timers.push(t)&&!timerId){
timerId=setInterval(fx.tick,fx.interval);
}
},
show:function(){
var dataShow=jQuery._data(this.elem,"fxshow"+this.prop);
this.options.orig[this.prop]=dataShow||jQuery.style(this.elem,this.prop);
this.options.show=true;
if(dataShow!==undefined){
this.custom(this.cur(),dataShow);
}else{
this.custom(this.prop==="width"||this.prop==="height"?1:0,this.cur());
}
jQuery(this.elem).show();
},
hide:function(){
this.options.orig[this.prop]=jQuery._data(this.elem,"fxshow"+this.prop)||jQuery.style(this.elem,this.prop);
this.options.hide=true;
this.custom(this.cur(),0);
},
step:function(gotoEnd){
var p,n,complete,
t=fxNow||createFxNow(),
done=true,
elem=this.elem,
options=this.options;
if(gotoEnd||t>=options.duration+this.startTime){
this.now=this.end;
this.pos=this.state=1;
this.update();
options.animatedProperties[this.prop]=true;
for(p in options.animatedProperties){
if(options.animatedProperties[p]!==true){
done=false;
}
}
if(done){
if(options.overflow!=null&&!jQuery.support.shrinkWrapBlocks){
jQuery.each(["","X","Y"],function(index,value){
elem.style["overflow"+value]=options.overflow[index];
});
}
if(options.hide){
jQuery(elem).hide();
}
if(options.hide||options.show){
for(p in options.animatedProperties){
jQuery.style(elem,p,options.orig[p]);
jQuery.removeData(elem,"fxshow"+p,true);
jQuery.removeData(elem,"toggle"+p,true);
}
}
complete=options.complete;
if(complete){
options.complete=false;
complete.call(elem);
}
}
return false;
}else{
if(options.duration==Infinity){
this.now=t;
}else{
n=t-this.startTime;
this.state=n/options.duration;
this.pos=jQuery.easing[options.animatedProperties[this.prop]](this.state,n,0,1,options.duration);
this.now=this.start+((this.end-this.start)*this.pos);
}
this.update();
}
return true;
}
};
jQuery.extend(jQuery.fx,{
tick:function(){
var timer,
timers=jQuery.timers,
i=0;
for(;i<timers.length;i++){
timer=timers[i];
if(!timer()&&timers[i]===timer){
timers.splice(i--,1);
}
}
if(!timers.length){
jQuery.fx.stop();
}
},
interval:13,
stop:function(){
clearInterval(timerId);
timerId=null;
},
speeds:{
slow:600,
fast:200,
_default:400
},
step:{
opacity:function(fx){
jQuery.style(fx.elem,"opacity",fx.now);
},
_default:function(fx){
if(fx.elem.style&&fx.elem.style[fx.prop]!=null){
fx.elem.style[fx.prop]=fx.now+fx.unit;
}else{
fx.elem[fx.prop]=fx.now;
}
}
}
});
jQuery.each(fxAttrs.concat.apply([],fxAttrs),function(i,prop){
if(prop.indexOf("margin")){
jQuery.fx.step[prop]=function(fx){
jQuery.style(fx.elem,prop,Math.max(0,fx.now)+fx.unit);
};
}
});
if(jQuery.expr&&jQuery.expr.filters){
jQuery.expr.filters.animated=function(elem){
return jQuery.grep(jQuery.timers,function(fn){
return elem===fn.elem;
}).length;
};
}
function defaultDisplay(nodeName){
if(!elemdisplay[nodeName]){
var body=document.body,
elem=jQuery("<"+nodeName+">").appendTo(body),
display=elem.css("display");
elem.remove();
if(display==="none"||display===""){
if(!iframe){
iframe=document.createElement("iframe");
iframe.frameBorder=iframe.width=iframe.height=0;
}
body.appendChild(iframe);
if(!iframeDoc||!iframe.createElement){
iframeDoc=(iframe.contentWindow||iframe.contentDocument).document;
iframeDoc.write((jQuery.support.boxModel?"<!doctype html>":"")+"<html><body>");
iframeDoc.close();
}
elem=iframeDoc.createElement(nodeName);
iframeDoc.body.appendChild(elem);
display=jQuery.css(elem,"display");
body.removeChild(iframe);
}
elemdisplay[nodeName]=display;
}
return elemdisplay[nodeName];
}
var getOffset,
rtable=/^t(?:able|d|h)$/i,
rroot=/^(?:body|html)$/i;
if("getBoundingClientRect"in document.documentElement){
getOffset=function(elem,doc,docElem,box){
try{
box=elem.getBoundingClientRect();
}catch(e){}
if(!box||!jQuery.contains(docElem,elem)){
return box?{top:box.top,left:box.left}:{top:0,left:0};
}
var body=doc.body,
win=getWindow(doc),
clientTop=docElem.clientTop||body.clientTop||0,
clientLeft=docElem.clientLeft||body.clientLeft||0,
scrollTop=win.pageYOffset||jQuery.support.boxModel&&docElem.scrollTop||body.scrollTop,
scrollLeft=win.pageXOffset||jQuery.support.boxModel&&docElem.scrollLeft||body.scrollLeft,
top=box.top+scrollTop-clientTop,
left=box.left+scrollLeft-clientLeft;
return{top:top,left:left};
};
}else{
getOffset=function(elem,doc,docElem){
var computedStyle,
offsetParent=elem.offsetParent,
prevOffsetParent=elem,
body=doc.body,
defaultView=doc.defaultView,
prevComputedStyle=defaultView?defaultView.getComputedStyle(elem,null):elem.currentStyle,
top=elem.offsetTop,
left=elem.offsetLeft;
while((elem=elem.parentNode)&&elem!==body&&elem!==docElem){
if(jQuery.support.fixedPosition&&prevComputedStyle.position==="fixed"){
break;
}
computedStyle=defaultView?defaultView.getComputedStyle(elem,null):elem.currentStyle;
top-=elem.scrollTop;
left-=elem.scrollLeft;
if(elem===offsetParent){
top+=elem.offsetTop;
left+=elem.offsetLeft;
if(jQuery.support.doesNotAddBorder&&!(jQuery.support.doesAddBorderForTableAndCells&&rtable.test(elem.nodeName))){
top+=parseFloat(computedStyle.borderTopWidth)||0;
left+=parseFloat(computedStyle.borderLeftWidth)||0;
}
prevOffsetParent=offsetParent;
offsetParent=elem.offsetParent;
}
if(jQuery.support.subtractsBorderForOverflowNotVisible&&computedStyle.overflow!=="visible"){
top+=parseFloat(computedStyle.borderTopWidth)||0;
left+=parseFloat(computedStyle.borderLeftWidth)||0;
}
prevComputedStyle=computedStyle;
}
if(prevComputedStyle.position==="relative"||prevComputedStyle.position==="static"){
top+=body.offsetTop;
left+=body.offsetLeft;
}
if(jQuery.support.fixedPosition&&prevComputedStyle.position==="fixed"){
top+=Math.max(docElem.scrollTop,body.scrollTop);
left+=Math.max(docElem.scrollLeft,body.scrollLeft);
}
return{top:top,left:left};
};
}
jQuery.fn.offset=function(options){
if(arguments.length){
return options===undefined?
this:
this.each(function(i){
jQuery.offset.setOffset(this,options,i);
});
}
var elem=this[0],
doc=elem&&elem.ownerDocument;
if(!doc){
return null;
}
if(elem===doc.body){
return jQuery.offset.bodyOffset(elem);
}
return getOffset(elem,doc,doc.documentElement);
};
jQuery.offset={
bodyOffset:function(body){
var top=body.offsetTop,
left=body.offsetLeft;
if(jQuery.support.doesNotIncludeMarginInBodyOffset){
top+=parseFloat(jQuery.css(body,"marginTop"))||0;
left+=parseFloat(jQuery.css(body,"marginLeft"))||0;
}
return{top:top,left:left};
},
setOffset:function(elem,options,i){
var position=jQuery.css(elem,"position");
if(position==="static"){
elem.style.position="relative";
}
var curElem=jQuery(elem),
curOffset=curElem.offset(),
curCSSTop=jQuery.css(elem,"top"),
curCSSLeft=jQuery.css(elem,"left"),
calculatePosition=(position==="absolute"||position==="fixed")&&jQuery.inArray("auto",[curCSSTop,curCSSLeft])>-1,
props={},curPosition={},curTop,curLeft;
if(calculatePosition){
curPosition=curElem.position();
curTop=curPosition.top;
curLeft=curPosition.left;
}else{
curTop=parseFloat(curCSSTop)||0;
curLeft=parseFloat(curCSSLeft)||0;
}
if(jQuery.isFunction(options)){
options=options.call(elem,i,curOffset);
}
if(options.top!=null){
props.top=(options.top-curOffset.top)+curTop;
}
if(options.left!=null){
props.left=(options.left-curOffset.left)+curLeft;
}
if("using"in options){
options.using.call(elem,props);
}else{
curElem.css(props);
}
}
};
jQuery.fn.extend({
position:function(){
if(!this[0]){
return null;
}
var elem=this[0],
offsetParent=this.offsetParent(),
offset=this.offset(),
parentOffset=rroot.test(offsetParent[0].nodeName)?{top:0,left:0}:offsetParent.offset();
offset.top-=parseFloat(jQuery.css(elem,"marginTop"))||0;
offset.left-=parseFloat(jQuery.css(elem,"marginLeft"))||0;
parentOffset.top+=parseFloat(jQuery.css(offsetParent[0],"borderTopWidth"))||0;
parentOffset.left+=parseFloat(jQuery.css(offsetParent[0],"borderLeftWidth"))||0;
return{
top:offset.top-parentOffset.top,
left:offset.left-parentOffset.left
};
},
offsetParent:function(){
return this.map(function(){
var offsetParent=this.offsetParent||document.body;
while(offsetParent&&(!rroot.test(offsetParent.nodeName)&&jQuery.css(offsetParent,"position")==="static")){
offsetParent=offsetParent.offsetParent;
}
return offsetParent;
});
}
});
jQuery.each({scrollLeft:"pageXOffset",scrollTop:"pageYOffset"},function(method,prop){
var top=/Y/.test(prop);
jQuery.fn[method]=function(val){
return jQuery.access(this,function(elem,method,val){
var win=getWindow(elem);
if(val===undefined){
return win?(prop in win)?win[prop]:
jQuery.support.boxModel&&win.document.documentElement[method]||
win.document.body[method]:
elem[method];
}
if(win){
win.scrollTo(
!top?val:jQuery(win).scrollLeft(),
top?val:jQuery(win).scrollTop()
);
}else{
elem[method]=val;
}
},method,val,arguments.length,null);
};
});
function getWindow(elem){
return jQuery.isWindow(elem)?
elem:
elem.nodeType===9?
elem.defaultView||elem.parentWindow:
false;
}
jQuery.each({Height:"height",Width:"width"},function(name,type){
var clientProp="client"+name,
scrollProp="scroll"+name,
offsetProp="offset"+name;
jQuery.fn["inner"+name]=function(){
var elem=this[0];
return elem?
elem.style?
parseFloat(jQuery.css(elem,type,"padding")):
this[type]():
null;
};
jQuery.fn["outer"+name]=function(margin){
var elem=this[0];
return elem?
elem.style?
parseFloat(jQuery.css(elem,type,margin?"margin":"border")):
this[type]():
null;
};
jQuery.fn[type]=function(value){
return jQuery.access(this,function(elem,type,value){
var doc,docElemProp,orig,ret;
if(jQuery.isWindow(elem)){
doc=elem.document;
docElemProp=doc.documentElement[clientProp];
return jQuery.support.boxModel&&docElemProp||
doc.body&&doc.body[clientProp]||docElemProp;
}
if(elem.nodeType===9){
doc=elem.documentElement;
if(doc[clientProp]>=doc[scrollProp]){
return doc[clientProp];
}
return Math.max(
elem.body[scrollProp],doc[scrollProp],
elem.body[offsetProp],doc[offsetProp]
);
}
if(value===undefined){
orig=jQuery.css(elem,type);
ret=parseFloat(orig);
return jQuery.isNumeric(ret)?ret:orig;
}
jQuery(elem).css(type,value);
},type,value,arguments.length,null);
};
});
window.jQuery=window.$=jQuery;
if(typeof define==="function"&&define.amd&&define.amd.jQuery){
define("jquery",[],function(){return jQuery;});
}
})(window);


/* ../prive/javascript/jquery.form.js */

;(function($){
$.fn.ajaxSubmit=function(options){
if(!this.length){
log('ajaxSubmit: skipping submit process - no element selected');
return this;
}
var method,action,url,$form=this;
if(typeof options=='function'){
options={success:options};
}
method=this.attr('method');
action=this.attr('action');
url=(typeof action==='string')?$.trim(action):'';
url=url||window.location.href||'';
if(url){
url=(url.match(/^([^#]+)/)||[])[1];
}
options=$.extend(true,{
url:url,
success:$.ajaxSettings.success,
type:method||'GET',
iframeSrc:/^https/i.test(window.location.href||'')?'javascript:false':'about:blank'
},options);
var veto={};
this.trigger('form-pre-serialize',[this,options,veto]);
if(veto.veto){
log('ajaxSubmit: submit vetoed via form-pre-serialize trigger');
return this;
}
if(options.beforeSerialize&&options.beforeSerialize(this,options)===false){
log('ajaxSubmit: submit aborted via beforeSerialize callback');
return this;
}
var traditional=options.traditional;
if(traditional===undefined){
traditional=$.ajaxSettings.traditional;
}
var qx,n,v,a=this.formToArray(options.semantic);
if(options.data){
options.extraData=options.data;
qx=$.param(options.data,traditional);
}
if(options.beforeSubmit&&options.beforeSubmit(a,this,options)===false){
log('ajaxSubmit: submit aborted via beforeSubmit callback');
return this;
}
this.trigger('form-submit-validate',[a,this,options,veto]);
if(veto.veto){
log('ajaxSubmit: submit vetoed via form-submit-validate trigger');
return this;
}
var q=$.param(a,traditional);
if(qx){
q=(q?(q+'&'+qx):qx);
}
if(options.type.toUpperCase()=='GET'){
options.url+=(options.url.indexOf('?')>=0?'&':'?')+q;
options.data=null;
}
else{
options.data=q;
}
var callbacks=[];
if(options.resetForm){
callbacks.push(function(){$form.resetForm();});
}
if(options.clearForm){
callbacks.push(function(){$form.clearForm(options.includeHidden);});
}
if(!options.dataType&&options.target){
var oldSuccess=options.success||function(){};
callbacks.push(function(data){
var fn=options.replaceTarget?'replaceWith':'html';
$(options.target)[fn](data).each(oldSuccess,arguments);
});
}
else if(options.success){
callbacks.push(options.success);
}
options.success=function(data,status,xhr){
var context=options.context||options;
for(var i=0,max=callbacks.length;i<max;i++){
callbacks[i].apply(context,[data,status,xhr||$form,$form]);
}
};
var fileInputs=$('input:file:enabled[value]',this);
var hasFileInputs=fileInputs.length>0;
var mp='multipart/form-data';
var multipart=($form.attr('enctype')==mp||$form.attr('encoding')==mp);
var fileAPI=!!(hasFileInputs&&fileInputs.get(0).files&&window.FormData);
log("fileAPI :"+fileAPI);
var shouldUseFrame=(hasFileInputs||multipart);
if(options.iframe!==false&&(options.iframe||shouldUseFrame)){
if(options.closeKeepAlive){
$.get(options.closeKeepAlive,function(){
fileUploadIframe(a);
});
}
else{
fileUploadIframe(a);
}
}
else if((hasFileInputs||multipart)&&fileAPI){
options.progress=options.progress||$.noop;
fileUploadXhr(a);
}
else{
$.ajax(options);
}
this.trigger('form-submit-notify',[this,options]);
return this;
function fileUploadXhr(a){
var formdata=new FormData();
for(var i=0;i<a.length;i++){
if(a[i].type=='file')
continue;
formdata.append(a[i].name,a[i].value);
}
$form.find('input:file:enabled').each(function(){
var name=$(this).attr('name'),files=this.files;
if(name){
for(var i=0;i<files.length;i++)
formdata.append(name,files[i]);
}
});
if(options.extraData){
for(var k in options.extraData)
formdata.append(k,options.extraData[k])
}
options.data=null;
var s=$.extend(true,{},$.ajaxSettings,options,{
contentType:false,
processData:false,
cache:false,
type:'POST'
});
s.context=s.context||s;
s.data=null;
var beforeSend=s.beforeSend;
s.beforeSend=function(xhr,o){
o.data=formdata;
if(xhr.upload){
xhr.upload.onprogress=function(event){
o.progress(event.position,event.total);
};
}
if(beforeSend)
beforeSend.call(o,xhr,options);
};
$.ajax(s);
}
function fileUploadIframe(a){
var form=$form[0],el,i,s,g,id,$io,io,xhr,sub,n,timedOut,timeoutHandle;
var useProp=!!$.fn.prop;
if(a){
if(useProp){
for(i=0;i<a.length;i++){
el=$(form[a[i].name]);
el.prop('disabled',false);
}
}else{
for(i=0;i<a.length;i++){
el=$(form[a[i].name]);
el.removeAttr('disabled');
}
};
}
if($(':input[name=submit],:input[id=submit]',form).length){
alert('Error: Form elements must not have name or id of "submit".');
return;
}
s=$.extend(true,{},$.ajaxSettings,options);
s.context=s.context||s;
id='jqFormIO'+(new Date().getTime());
if(s.iframeTarget){
$io=$(s.iframeTarget);
n=$io.attr('name');
if(n==null)
$io.attr('name',id);
else
id=n;
}
else{
$io=$('<iframe name="'+id+'" src="'+s.iframeSrc+'" />');
$io.css({position:'absolute',top:'-1000px',left:'-1000px'});
}
io=$io[0];
xhr={
aborted:0,
responseText:null,
responseXML:null,
status:0,
statusText:'n/a',
getAllResponseHeaders:function(){},
getResponseHeader:function(){},
setRequestHeader:function(){},
abort:function(status){
var e=(status==='timeout'?'timeout':'aborted');
log('aborting upload... '+e);
this.aborted=1;
$io.attr('src',s.iframeSrc);
xhr.error=e;
s.error&&s.error.call(s.context,xhr,e,status);
g&&$.event.trigger("ajaxError",[xhr,s,e]);
s.complete&&s.complete.call(s.context,xhr,e);
}
};
g=s.global;
if(g&&!$.active++){
$.event.trigger("ajaxStart");
}
if(g){
$.event.trigger("ajaxSend",[xhr,s]);
}
if(s.beforeSend&&s.beforeSend.call(s.context,xhr,s)===false){
if(s.global){
$.active--;
}
return;
}
if(xhr.aborted){
return;
}
sub=form.clk;
if(sub){
n=sub.name;
if(n&&!sub.disabled){
s.extraData=s.extraData||{};
s.extraData[n]=sub.value;
if(sub.type=="image"){
s.extraData[n+'.x']=form.clk_x;
s.extraData[n+'.y']=form.clk_y;
}
}
}
var CLIENT_TIMEOUT_ABORT=1;
var SERVER_ABORT=2;
function getDoc(frame){
var doc=frame.contentWindow?frame.contentWindow.document:frame.contentDocument?frame.contentDocument:frame.document;
return doc;
}
var csrf_token=$('meta[name=csrf-token]').attr('content');
var csrf_param=$('meta[name=csrf-param]').attr('content');
if(csrf_param&&csrf_token){
s.extraData=s.extraData||{};
s.extraData[csrf_param]=csrf_token;
}
function doSubmit(){
var t=$form.attr('target'),a=$form.attr('action');
form.setAttribute('target',id);
if(!method){
form.setAttribute('method','POST');
}
if(a!=s.url){
form.setAttribute('action',s.url);
}
if(!s.skipEncodingOverride&&(!method||/post/i.test(method))){
$form.attr({
encoding:'multipart/form-data',
enctype:'multipart/form-data'
});
}
if(s.timeout){
timeoutHandle=setTimeout(function(){timedOut=true;cb(CLIENT_TIMEOUT_ABORT);},s.timeout);
}
function checkState(){
try{
var state=getDoc(io).readyState;
log('state = '+state);
if(state.toLowerCase()=='uninitialized')
setTimeout(checkState,50);
}
catch(e){
log('Server abort: ',e,' (',e.name,')');
cb(SERVER_ABORT);
timeoutHandle&&clearTimeout(timeoutHandle);
timeoutHandle=undefined;
}
}
var extraInputs=[];
try{
if(s.extraData){
for(var n in s.extraData){
extraInputs.push(
$('<input type="hidden" name="'+n+'">').attr('value',s.extraData[n])
.appendTo(form)[0]);
}
}
if(!s.iframeTarget){
$io.appendTo('body');
io.attachEvent?io.attachEvent('onload',cb):io.addEventListener('load',cb,false);
}
setTimeout(checkState,15);
form.submit();
}
finally{
form.setAttribute('action',a);
if(t){
form.setAttribute('target',t);
}else{
$form.removeAttr('target');
}
$(extraInputs).remove();
}
}
if(s.forceSync){
doSubmit();
}
else{
setTimeout(doSubmit,10);
}
var data,doc,domCheckCount=50,callbackProcessed;
function cb(e){
if(xhr.aborted||callbackProcessed){
return;
}
try{
doc=getDoc(io);
}
catch(ex){
log('cannot access response document: ',ex);
e=SERVER_ABORT;
}
if(e===CLIENT_TIMEOUT_ABORT&&xhr){
xhr.abort('timeout');
return;
}
else if(e==SERVER_ABORT&&xhr){
xhr.abort('server abort');
return;
}
if(!doc||doc.location.href==s.iframeSrc){
if(!timedOut)
return;
}
io.detachEvent?io.detachEvent('onload',cb):io.removeEventListener('load',cb,false);
var status='success',errMsg;
try{
if(timedOut){
throw'timeout';
}
var isXml=s.dataType=='xml'||doc.XMLDocument||$.isXMLDoc(doc);
log('isXml='+isXml);
if(!isXml&&window.opera&&(doc.body==null||doc.body.innerHTML=='')){
if(--domCheckCount){
log('requeing onLoad callback, DOM not available');
setTimeout(cb,250);
return;
}
}
var docRoot=doc.body?doc.body:doc.documentElement;
xhr.responseText=docRoot?docRoot.innerHTML:null;
xhr.responseXML=doc.XMLDocument?doc.XMLDocument:doc;
if(isXml)
s.dataType='xml';
xhr.getResponseHeader=function(header){
var headers={'content-type':s.dataType};
return headers[header];
};
if(docRoot){
xhr.status=Number(docRoot.getAttribute('status'))||xhr.status;
xhr.statusText=docRoot.getAttribute('statusText')||xhr.statusText;
}
var dt=(s.dataType||'').toLowerCase();
var scr=/(json|script|text)/.test(dt);
if(scr||s.textarea){
var ta=doc.getElementsByTagName('textarea')[0];
if(ta){
xhr.responseText=ta.value;
xhr.status=Number(ta.getAttribute('status'))||xhr.status;
xhr.statusText=ta.getAttribute('statusText')||xhr.statusText;
}
else if(scr){
var pre=doc.getElementsByTagName('pre')[0];
var b=doc.getElementsByTagName('body')[0];
if(pre){
xhr.responseText=pre.textContent?pre.textContent:pre.innerText;
}
else if(b){
xhr.responseText=b.textContent?b.textContent:b.innerText;
}
}
}
else if(dt=='xml'&&!xhr.responseXML&&xhr.responseText!=null){
xhr.responseXML=toXml(xhr.responseText);
}
try{
data=httpData(xhr,dt,s);
}
catch(e){
status='parsererror';
xhr.error=errMsg=(e||status);
}
}
catch(e){
log('error caught: ',e);
status='error';
xhr.error=errMsg=(e||status);
}
if(xhr.aborted){
log('upload aborted');
status=null;
}
if(xhr.status){
status=(xhr.status>=200&&xhr.status<300||xhr.status===304)?'success':'error';
}
if(status==='success'){
s.success&&s.success.call(s.context,data,'success',xhr);
g&&$.event.trigger("ajaxSuccess",[xhr,s]);
}
else if(status){
if(errMsg==undefined)
errMsg=xhr.statusText;
s.error&&s.error.call(s.context,xhr,status,errMsg);
g&&$.event.trigger("ajaxError",[xhr,s,errMsg]);
}
g&&$.event.trigger("ajaxComplete",[xhr,s]);
if(g&&!--$.active){
$.event.trigger("ajaxStop");
}
s.complete&&s.complete.call(s.context,xhr,status);
callbackProcessed=true;
if(s.timeout)
clearTimeout(timeoutHandle);
setTimeout(function(){
if(!s.iframeTarget)
$io.remove();
xhr.responseXML=null;
},100);
}
var toXml=$.parseXML||function(s,doc){
if(window.ActiveXObject){
doc=new ActiveXObject('Microsoft.XMLDOM');
doc.async='false';
doc.loadXML(s);
}
else{
doc=(new DOMParser()).parseFromString(s,'text/xml');
}
return(doc&&doc.documentElement&&doc.documentElement.nodeName!='parsererror')?doc:null;
};
var parseJSON=$.parseJSON||function(s){
return window['eval']('('+s+')');
};
var httpData=function(xhr,type,s){
var ct=xhr.getResponseHeader('content-type')||'',
xml=type==='xml'||!type&&ct.indexOf('xml')>=0,
data=xml?xhr.responseXML:xhr.responseText;
if(xml&&data.documentElement.nodeName==='parsererror'){
$.error&&$.error('parsererror');
}
if(s&&s.dataFilter){
data=s.dataFilter(data,type);
}
if(typeof data==='string'){
if(type==='json'||!type&&ct.indexOf('json')>=0){
data=parseJSON(data);
}else if(type==="script"||!type&&ct.indexOf("javascript")>=0){
$.globalEval(data);
}
}
return data;
};
}
};
$.fn.ajaxForm=function(options){
if(this.length===0){
var o={s:this.selector,c:this.context};
if(!$.isReady&&o.s){
log('DOM not ready, queuing ajaxForm');
$(function(){
$(o.s,o.c).ajaxForm(options);
});
return this;
}
log('terminating; zero elements found by selector'+($.isReady?'':' (DOM not ready)'));
return this;
}
return this.ajaxFormUnbind().bind('submit.form-plugin',function(e){
if(!e.isDefaultPrevented()){
e.preventDefault();
$(this).ajaxSubmit(options);
}
}).bind('click.form-plugin',function(e){
var target=e.target;
var $el=$(target);
if(!($el.is(":submit,input:image"))){
var t=$el.closest(':submit');
if(t.length==0){
return;
}
target=t[0];
}
var form=this;
form.clk=target;
if(target.type=='image'){
if(e.offsetX!=undefined){
form.clk_x=e.offsetX;
form.clk_y=e.offsetY;
}else if(typeof $.fn.offset=='function'){
var offset=$el.offset();
form.clk_x=e.pageX-offset.left;
form.clk_y=e.pageY-offset.top;
}else{
form.clk_x=e.pageX-target.offsetLeft;
form.clk_y=e.pageY-target.offsetTop;
}
}
setTimeout(function(){form.clk=form.clk_x=form.clk_y=null;},100);
});
};
$.fn.ajaxFormUnbind=function(){
return this.unbind('submit.form-plugin click.form-plugin');
};
$.fn.formToArray=function(semantic){
var a=[];
if(this.length===0){
return a;
}
var form=this[0];
var els=semantic?form.getElementsByTagName('*'):form.elements;
if(!els){
return a;
}
var i,j,n,v,el,max,jmax;
for(i=0,max=els.length;i<max;i++){
el=els[i];
n=el.name;
if(!n){
continue;
}
if(semantic&&form.clk&&el.type=="image"){
if(!el.disabled&&form.clk==el){
a.push({name:n,value:$(el).val(),type:el.type});
a.push({name:n+'.x',value:form.clk_x},{name:n+'.y',value:form.clk_y});
}
continue;
}
v=$.fieldValue(el,true);
if(v&&v.constructor==Array){
for(j=0,jmax=v.length;j<jmax;j++){
a.push({name:n,value:v[j]});
}
}
else if(v!==null&&typeof v!='undefined'){
a.push({name:n,value:v,type:el.type});
}
}
if(!semantic&&form.clk){
var $input=$(form.clk),input=$input[0];
n=input.name;
if(n&&!input.disabled&&input.type=='image'){
a.push({name:n,value:$input.val()});
a.push({name:n+'.x',value:form.clk_x},{name:n+'.y',value:form.clk_y});
}
}
return a;
};
$.fn.formSerialize=function(semantic){
return $.param(this.formToArray(semantic));
};
$.fn.fieldSerialize=function(successful){
var a=[];
this.each(function(){
var n=this.name;
if(!n){
return;
}
var v=$.fieldValue(this,successful);
if(v&&v.constructor==Array){
for(var i=0,max=v.length;i<max;i++){
a.push({name:n,value:v[i]});
}
}
else if(v!==null&&typeof v!='undefined'){
a.push({name:this.name,value:v});
}
});
return $.param(a);
};
$.fn.fieldValue=function(successful){
for(var val=[],i=0,max=this.length;i<max;i++){
var el=this[i];
var v=$.fieldValue(el,successful);
if(v===null||typeof v=='undefined'||(v.constructor==Array&&!v.length)){
continue;
}
v.constructor==Array?$.merge(val,v):val.push(v);
}
return val;
};
$.fieldValue=function(el,successful){
var n=el.name,t=el.type,tag=el.tagName.toLowerCase();
if(successful===undefined){
successful=true;
}
if(successful&&(!n||el.disabled||t=='reset'||t=='button'||
(t=='checkbox'||t=='radio')&&!el.checked||
(t=='submit'||t=='image')&&el.form&&el.form.clk!=el||
tag=='select'&&el.selectedIndex==-1)){
return null;
}
if(tag=='select'){
var index=el.selectedIndex;
if(index<0){
return null;
}
var a=[],ops=el.options;
var one=(t=='select-one');
var max=(one?index+1:ops.length);
for(var i=(one?index:0);i<max;i++){
var op=ops[i];
if(op.selected){
var v=op.value;
if(!v){
v=(op.attributes&&op.attributes['value']&&!(op.attributes['value'].specified))?op.text:op.value;
}
if(one){
return v;
}
a.push(v);
}
}
return a;
}
return $(el).val();
};
$.fn.clearForm=function(includeHidden){
return this.each(function(){
$('input,select,textarea',this).clearFields(includeHidden);
});
};
$.fn.clearFields=$.fn.clearInputs=function(includeHidden){
var re=/^(?:color|date|datetime|email|month|number|password|range|search|tel|text|time|url|week)$/i;
return this.each(function(){
var t=this.type,tag=this.tagName.toLowerCase();
if(re.test(t)||tag=='textarea'||(includeHidden&&/hidden/.test(t))){
this.value='';
}
else if(t=='checkbox'||t=='radio'){
this.checked=false;
}
else if(tag=='select'){
this.selectedIndex=-1;
}
});
};
$.fn.resetForm=function(){
return this.each(function(){
if(typeof this.reset=='function'||(typeof this.reset=='object'&&!this.reset.nodeType)){
this.reset();
}
});
};
$.fn.enable=function(b){
if(b===undefined){
b=true;
}
return this.each(function(){
this.disabled=!b;
});
};
$.fn.selected=function(select){
if(select===undefined){
select=true;
}
return this.each(function(){
var t=this.type;
if(t=='checkbox'||t=='radio'){
this.checked=select;
}
else if(this.tagName.toLowerCase()=='option'){
var $sel=$(this).parent('select');
if(select&&$sel[0]&&$sel[0].type=='select-one'){
$sel.find('option').selected(false);
}
this.selected=select;
}
});
};
$.fn.ajaxSubmit.debug=false;
function log(){
if(!$.fn.ajaxSubmit.debug)
return;
var msg='[jquery.form] '+Array.prototype.join.call(arguments,'');
if(window.console&&window.console.log){
window.console.log(msg);
}
else if(window.opera&&window.opera.postError){
window.opera.postError(msg);
}
};
})(jQuery);


/* ../prive/javascript/jquery.autosave.js */

(function($){
$.fn.autosave=function(opt){
opt=$.extend({
url:window.location,
confirm:false,
confirmstring:'Sauvegarder ?'
},opt);
var save_changed=function(){
$('form.autosavechanged')
.each(function(){
if(!opt.confirm||confirm(opt.confirmstring)){
var contenu=$(this).serialize();
var d=new Date();
contenu=contenu+"&__timestamp="+d.getTime();
$.post(opt.url,{
'action':'session',
'var':'autosave_'+$('input[name=autosave]',this).val(),
'val':contenu
});
}
}).removeClass('autosavechanged');
}
$(window)
.bind('unload',save_changed);
return this
.bind('keyup',function(){
$(this).addClass('autosavechanged');
})
.bind('change',function(){
$(this).addClass('autosavechanged');
save_changed();
})
.bind('submit',function(){
save_changed();
;
});
}
})(jQuery);


/* ../prive/javascript/jquery.placeholder-label.js */

(function($){
$.placeholderLabel={
placeholder_class:null,
add_placeholder:function(){
if($(this).val()==$(this).attr('placeholder')){
$(this).val('').removeClass($.placeholderLabel.placeholder_class);
}
},
remove_placeholder:function(){
if($(this).val()==''){
$(this).val($(this).attr('placeholder')).addClass($.placeholderLabel.placeholder_class);
}
},
disable_placeholder_fields:function(){
$(this).find("input[placeholder]").each(function(){
if($(this).val()==$(this).attr('placeholder')){
$(this).val('');
}
});
return true;
}
};
$.fn.placeholderLabel=function(options){
var dummy=document.createElement('input');
if(dummy.placeholder!=undefined){
return this;
}
var config={
placeholder_class:'placeholder'
};
if(options)$.extend(config,options);
$.placeholderLabel.placeholder_class=config.placeholder_class;
this.each(function(){
var input=$(this);
input.focus($.placeholderLabel.add_placeholder);
input.blur($.placeholderLabel.remove_placeholder);
input.triggerHandler('focus');
input.triggerHandler('blur');
$(this.form).submit($.placeholderLabel.disable_placeholder_fields);
});
return this;
}
})(jQuery);


/* ../prive/javascript/ajaxCallback.js */
jQuery.spip=jQuery.spip||{};
jQuery.spip.log=function(){
if(jQuery.spip.debug&&window.console&&window.console.log)
window.console.log.apply(this,arguments);
}
if(!jQuery.spip.load_handlers){
jQuery.spip.load_handlers=new Array();
function onAjaxLoad(f){
jQuery.spip.load_handlers.push(f);
};
jQuery.spip.triggerAjaxLoad=function(root){
jQuery.spip.log('triggerAjaxLoad');
jQuery.spip.log(root);
for(var i=0;i<jQuery.spip.load_handlers.length;i++)
jQuery.spip.load_handlers[i].apply(root);
};
jQuery.spip.intercepted={};
jQuery.spip.intercepted.load=jQuery.fn.load;
jQuery.fn.load=function(url,params,callback){
callback=callback||function(){};
if(params){
if(params.constructor==Function){
callback=params;
params=null;
}
}
var callback2=function(){jQuery.spip.log('jQuery.load');jQuery.spip.triggerAjaxLoad(this);callback.apply(this,arguments);};
return jQuery.spip.intercepted.load.apply(this,[url,params,callback2]);
};
jQuery.spip.intercepted.ajaxSubmit=jQuery.fn.ajaxSubmit;
jQuery.fn.ajaxSubmit=function(options){
options=options||{};
if(typeof options.onAjaxLoad=="undefined"||options.onAjaxLoad!=false){
var me=jQuery(this).parents('div.ajax');
if(me.length)
me=me.parent();
else
me=document;
if(typeof options=='function')
options={success:options};
var callback=options.success||function(){};
options.success=function(){callback.apply(this,arguments);jQuery.spip.log('jQuery.ajaxSubmit');jQuery.spip.triggerAjaxLoad(me);}
}
return jQuery.spip.intercepted.ajaxSubmit.apply(this,[options]);
}
jQuery.spip.intercepted.ajax=jQuery.ajax;
jQuery.ajax=function(type){
var s=jQuery.extend(true,{},jQuery.ajaxSettings,type);
var callbackContext=s.context||s;
try{
if(jQuery.ajax.caller==jQuery.spip.intercepted.load||jQuery.ajax.caller==jQuery.spip.intercepted.ajaxSubmit)
return jQuery.spip.intercepted.ajax(type);
}
catch(err){}
var orig_complete=s.complete||function(){};
type.complete=function(res,status){
var dataType=type.dataType;
var ct=(res&&(typeof res.getResponseHeader=='function'))
?res.getResponseHeader("content-type"):'';
var xml=!dataType&&ct&&ct.indexOf("xml")>=0;
orig_complete.call(callbackContext,res,status);
if(!dataType&&!xml||dataType=="html"){
jQuery.spip.log('jQuery.ajax');
if(typeof s.onAjaxLoad=="undefined"||s.onAjaxLoad!=false)
jQuery.spip.triggerAjaxLoad(s.ajaxTarget?s.ajaxTarget:document);
}
};
return jQuery.spip.intercepted.ajax(type);
};
}
jQuery.fn.positionner=function(force,setfocus){
var offset=jQuery(this).offset();
var hauteur=parseInt(jQuery(this).css('height'));
var scrolltop=self['pageYOffset']||
jQuery.boxModel&&document.documentElement['scrollTop']||
document.body['scrollTop'];
var h=jQuery(window).height();
var scroll=0;
if(force||(offset&&offset['top']-5<=scrolltop))
scroll=offset['top']-5;
else if(offset&&offset['top']+hauteur-h+5>scrolltop)
scroll=Math.min(offset['top']-5,offset['top']+hauteur-h+15);
if(scroll)
jQuery('html,body')
.animate({scrollTop:scroll},300);
if(setfocus!==false)
jQuery(jQuery('*',this).filter('input[type=text],textarea')[0]).focus();
return this;
}
jQuery.spip.virtualbuffer_id='spip_virtualbufferupdate';
jQuery.spip.initReaderBuffer=function(){
if(jQuery('#'+jQuery.spip.virtualbuffer_id).length)return;
jQuery('body').append('<p style="float:left;width:0;height:0;position:absolute;left:-5000;top:-5000;"><input type="hidden" name="'+jQuery.spip.virtualbuffer_id+'" id="'+jQuery.spip.virtualbuffer_id+'" value="0" /></p>');
}
jQuery.spip.updateReaderBuffer=function(){
var i=jQuery('#'+jQuery.spip.virtualbuffer_id);
if(!i.length)return;
i.attr('value',parseInt(i.attr('value'))+1);
}
jQuery.fn.formulaire_setARIA=function(){
if(!this.closest('.ariaformprop').length){
this.find('script').remove();
this.wrap('<div class="ariaformprop" aria-live="assertive" aria-atomic="true"></div>');
}
return this;
}
jQuery.fn.formulaire_dyn_ajax=function(target){
if(this.length)
jQuery.spip.initReaderBuffer();
return this.each(function(){
var scrollwhensubmit=!jQuery(this).is('.noscroll');
var cible=target||this;
jQuery(cible).formulaire_setARIA();
jQuery('form:not(.noajax):not(.bouton_action_post)',this).each(function(){
var leform=this;
var leclk,leclk_x,leclk_y;
jQuery(this).prepend("<input type='hidden' name='var_ajax' value='form' />")
.ajaxForm({
beforeSubmit:function(){
leclk=leform.clk;
if(leclk){
var n=leclk.name;
if(n&&!leclk.disabled&&leclk.type=="image"){
leclk_x=leform.clk_x;
leclk_y=leform.clk_y;
}
}
jQuery(cible).wrap('<div />');
cible=jQuery(cible).parent();
jQuery(cible).closest('.ariaformprop').animateLoading();
if(scrollwhensubmit)
jQuery(cible).positionner(false,false);
},
success:function(c){
if(c=='noajax'){
jQuery("input[name=var_ajax]",leform).remove();
if(leclk){
var n=leclk.name;
if(n&&!leclk.disabled){
jQuery(leform).prepend("<input type='hidden' name='"+n+"' value='"+leclk.value+"' />");
if(leclk.type=="image"){
jQuery(leform).prepend("<input type='hidden' name='"+n+".x' value='"+leform.clk_x+"' />");
jQuery(leform).prepend("<input type='hidden' name='"+n+".y' value='"+leform.clk_y+"' />");
}
}
}
jQuery(leform).ajaxFormUnbind().submit();
}
else{
var preloaded=jQuery.spip.preloaded_urls;
jQuery.spip.preloaded_urls={};
jQuery(cible).html(c);
var a=jQuery('a:first',cible).eq(0);
var d=jQuery('div.ajax',cible);
if(!d.length){
jQuery(cible).addClass('ajax');
if(!scrollwhensubmit)
jQuery(cible).addClass('noscroll');
}
else{
d.siblings('br.bugajaxie').remove();
cible=jQuery(":first",cible);
cible.unwrap();
}
if(a.length
&&a.is('a[name=ajax_ancre]')
&&jQuery(a.attr('href'),cible).length){
a=a.attr('href');
if(jQuery(a,cible).length)
setTimeout(function(){
jQuery(a,cible).positionner(false);
},10);
jQuery(cible).closest('.ariaformprop').endLoading(true);
}
else{
if(a.length&&a.is('a[name=ajax_redirect]')){
a=a.get(0).href;
setTimeout(function(){
var cur=window.location.href.split('#');
document.location.replace(a);
if(cur[0]==a.split('#')[0]){
window.location.reload();
}
},10);
jQuery(cible).closest('.ariaformprop').animateLoading();
}
else{
jQuery(cible).closest('.ariaformprop').endLoading(true);
}
}
if(!jQuery('.reponse_formulaire_ok',cible).length)
jQuery.spip.preloaded_urls=preloaded;
jQuery.spip.updateReaderBuffer();
}
},
iframe:jQuery.browser.msie
})
.addClass('noajax hasajax')
;
});
});
}
jQuery.fn.formulaire_verifier=function(callback,champ){
var erreurs={'message_erreur':'form non ajax'};
var me=this;
if(jQuery(me).closest('.ariaformprop').attr('aria-busy')!='true'){
if(jQuery(me).is('form.hasajax')){
jQuery(me).ajaxSubmit({
dataType:"json",
data:{formulaire_action_verifier_json:true},
success:function(errs){
var args=[errs,champ]
if(jQuery(me).closest('.ariaformprop').attr('aria-busy')!='true')
callback.apply(me,args);
}
});
}
else
callback.apply(me,[erreurs,champ]);
}
return this;
}
jQuery.fn.formulaire_activer_verif_auto=function(callback){
callback=callback||formulaire_actualiser_erreurs;
var me=jQuery(this).closest('.ariaformprop');
var check=function(){
var name=jQuery(this).attr('name');
setTimeout(function(){me.find('form').formulaire_verifier(callback,name);},50);
}
var activer=function(){
if(me.find('form').attr('data-verifjson')!='on'){
me
.find('form')
.attr('data-verifjson','on')
.find('input,select,textarea')
.bind('change',check);
}
}
jQuery(activer);
onAjaxLoad(function(){setTimeout(activer,150);});
}
function formulaire_actualiser_erreurs(erreurs){
var parent=jQuery(this).closest('.formulaire_spip');
if(!parent.length)return;
parent.find('.reponse_formulaire,.erreur_message').fadeOut().remove();
parent.find('.erreur').removeClass('erreur');
if(erreurs['message_ok'])
parent.find('form').before('<p class="reponse_formulaire reponse_formulaire_ok">'+erreurs['message_ok']+'</p>');
if(erreurs['message_erreur'])
parent.find('form').before('<p class="reponse_formulaire reponse_formulaire_erreur">'+erreurs['message_erreur']+'</p>');
for(var k in erreurs){
var saisie=parent.find('.editer_'+k);
if(saisie.length){
saisie.addClass('erreur');
saisie.find('label').after('<span class="erreur_message">'+erreurs[k]+'</span>');
}
}
}
var ajax_confirm=true;
var ajax_confirm_date=0;
var spip_confirm=window.confirm;
function _confirm(message){
ajax_confirm=spip_confirm(message);
if(!ajax_confirm){
var d=new Date();
ajax_confirm_date=d.getTime();
}
return ajax_confirm;
}
window.confirm=_confirm;
var ajaxbloc_selecteur;
jQuery.spip.preloaded_urls={};
jQuery.spip.on_ajax_loaded=function(blocfrag,c,href,history){
history=history||(history==null);
if(typeof href==undefined||href==null)
history=false;
if(history)
jQuery.spip.setHistoryState(blocfrag);
if(jQuery(blocfrag).attr('data-loaded-callback')){
var callback=eval(jQuery(blocfrag).attr('data-loaded-callback'));
callback.call(blocfrag,c,href,history);
}
else{
jQuery(blocfrag)
.html(c)
.endLoading();
}
if(typeof href!=undefined)
jQuery(blocfrag).attr('data-url',href);
if(history){
jQuery.spip.pushHistoryState(href);
jQuery.spip.setHistoryState(blocfrag);
}
var a=jQuery('a:first',jQuery(blocfrag)).eq(0);
if(a.length
&&a.is('a[name=ajax_ancre]')
&&jQuery(a.attr('href'),blocfrag).length){
a=a.attr('href');
jQuery(a,blocfrag).positionner(false);
}
jQuery.spip.log('on_ajax_loaded');
jQuery.spip.triggerAjaxLoad(blocfrag);
a=jQuery(blocfrag).parents('form.hasajax')
if(a.length)
a.eq(0).removeClass('noajax').parents('div.ajax').formulaire_dyn_ajax();
jQuery.spip.updateReaderBuffer();
}
jQuery.spip.stateId=0;
jQuery.spip.setHistoryState=function(blocfrag){
if(!window.history.replaceState)return;
if(!blocfrag.attr('id')){
while(jQuery('#ghsid'+jQuery.spip.stateId).length)
jQuery.spip.stateId++;
blocfrag.attr('id','ghsid'+jQuery.spip.stateId);
}
var href=blocfrag.attr('data-url')||blocfrag.attr('data-origin');
href=jQuery("<"+"a href='"+href+"'></a>").get(0).href;
var state={
id:blocfrag.attr('id'),
href:href
};
var ajaxid=blocfrag.attr('class').match(/\bajax-id-[\w-]+\b/);
if(ajaxid&&ajaxid.length)
state["ajaxid"]=ajaxid[0];
window.history.replaceState(state,window.document.title,window.document.location);
}
jQuery.spip.pushHistoryState=function(href,title){
if(!window.history.pushState)
return false;
window.history.pushState({},title,href);
}
window.onpopstate=function(popState){
if(popState.state&&popState.state.href){
var blocfrag=false;
if(popState.state.id){
blocfrag=jQuery('#'+popState.state.id);
}
if((!blocfrag||!blocfrag.length)&&popState.state.ajaxid){
blocfrag=jQuery('.ajaxbloc.'+popState.state.ajaxid);
}
if(blocfrag&&blocfrag.length==1){
jQuery.spip.ajaxClick(blocfrag,popState.state.href,{history:false});
return true;
}
else{
window.location.href=popState.state.href;
}
}
}
jQuery.spip.loadAjax=function(blocfrag,url,href,options){
var force=options.force||false;
if(jQuery(blocfrag).attr('data-loading-callback')){
var callback=eval(jQuery(blocfrag).attr('data-loading-callback'));
callback.call(blocfrag,url,href,options);
}
else{
jQuery(blocfrag).animateLoading();
}
if(jQuery.spip.preloaded_urls[url]&&!force){
if(jQuery.spip.preloaded_urls[url]=="<!--loading-->"){
setTimeout(function(){jQuery.spip.loadAjax(blocfrag,url,href,options);},100);
return;
}
jQuery.spip.on_ajax_loaded(blocfrag,jQuery.spip.preloaded_urls[url],href,options.history);
}else{
var d=new Date();
jQuery.spip.preloaded_urls[url]="<!--loading-->";
jQuery.ajax({
url:parametre_url(url,'var_t',d.getTime()),
onAjaxLoad:false,
success:function(c){
jQuery.spip.on_ajax_loaded(blocfrag,c,href,options.history);
jQuery.spip.preloaded_urls[url]=c;
if(options.callback&&typeof options.callback=="function")
options.callback.apply(blocfrag);
},
error:function(){
jQuery.spip.preloaded_urls[url]='';
}
});
}
}
jQuery.spip.makeAjaxUrl=function(href,ajax_env,origin){
var url=href.split('#');
url[0]=parametre_url(url[0],'var_ajax',1);
url[0]=parametre_url(url[0],'var_ajax_env',ajax_env);
if(origin){
var p=origin.indexOf('?');
if(p!==-1){
var args=origin.substring(p+1).split('&');
var val;
var arg;
for(var n=0;n<args.length;n++){
arg=args[n].split('=');
arg=arg[0];
p=arg.indexOf('[');
if(p!==-1)
arg=arg.substring(0,p);
val=parametre_url(href,arg);
if(typeof val=="undefined")
url[0]=url[0]+'&'+arg+'=';
}
}
}
if(url[1])
url[0]=parametre_url(url[0],'var_ajax_ancre',url[1]);
return url[0];
}
jQuery.spip.ajaxReload=function(blocfrag,options){
var ajax_env=blocfrag.attr('data-ajax-env');
if(!ajax_env||ajax_env==undefined)return;
var href=options.href||blocfrag.attr('data-url')||blocfrag.attr('data-origin');
if(href&&typeof href!=undefined){
options==options||{};
var callback=options.callback||null;
var history=options.history||false;
var args=options.args||{};
for(var key in args)
href=parametre_url(href,key,args[key]==undefined?'':args[key],'&',args[key]==undefined?false:true);
var url=jQuery.spip.makeAjaxUrl(href,ajax_env,blocfrag.attr('data-origin'));
jQuery.spip.loadAjax(blocfrag,url,href,{force:true,callback:callback,history:history});
return true;
}
}
jQuery.spip.ajaxClick=function(blocfrag,href,options){
var ajax_env=blocfrag.attr('data-ajax-env');
if(!ajax_env||ajax_env==undefined)return;
if(!ajax_confirm){
ajax_confirm=true;
var d=new Date();
if((d.getTime()-ajax_confirm_date)<=2)
return false;
}
var url=jQuery.spip.makeAjaxUrl(href,ajax_env,blocfrag.attr('data-origin'));
jQuery.spip.loadAjax(blocfrag,url,href,options);
return false;
}
jQuery.fn.ajaxbloc=function(){
if(this.length)
jQuery.spip.initReaderBuffer();
if(ajaxbloc_selecteur==undefined)
ajaxbloc_selecteur='.pagination a,a.ajax';
return this.each(function(){
jQuery('div.ajaxbloc',this).ajaxbloc();
var blocfrag=jQuery(this);
var ajax_env=blocfrag.attr('data-ajax-env');
if(!ajax_env||ajax_env==undefined)return;
blocfrag.not('.bind-ajaxReload').bind('ajaxReload',function(event,options){
if(jQuery.spip.ajaxReload(blocfrag,options))
event.stopPropagation();
}).addClass('bind-ajaxReload');
jQuery(ajaxbloc_selecteur,this).not('.noajax,.bind-ajax')
.click(function(){return jQuery.spip.ajaxClick(blocfrag,this.href,{force:jQuery(this).is('.nocache'),history:!(jQuery(this).is('.nohistory')||jQuery(this).closest('.box_modalbox').length)});})
.addClass('bind-ajax')
.filter('.preload').each(function(){
var href=this.href;
var url=jQuery.spip.makeAjaxUrl(href,ajax_env,blocfrag.attr('data-origin'));
if(!jQuery.spip.preloaded_urls[url]){
jQuery.spip.preloaded_urls[url]='<!--loading-->';
jQuery.ajax({url:url,onAjaxLoad:false,success:function(r){jQuery.spip.preloaded_urls[url]=r;},error:function(){jQuery.spip.preloaded_urls[url]='';}});
}
});
jQuery('form.bouton_action_post.ajax',this).not('.noajax,.bind-ajax').each(function(){
var leform=this;
var url=jQuery(this).attr('action').split('#');
jQuery(this)
.prepend("<input type='hidden' name='var_ajax' value='1' /><input type='hidden' name='var_ajax_env' value='"+(ajax_env)+"' />"+(url[1]?"<input type='hidden' name='var_ajax_ancre' value='"+url[1]+"' />":""))
.ajaxForm({
beforeSubmit:function(){
jQuery(blocfrag).animateLoading().positionner(false);
},
onAjaxLoad:false,
success:function(c){
jQuery.spip.on_ajax_loaded(blocfrag,c);
jQuery.spip.preloaded_urls={};
},
iframe:jQuery.browser.msie
})
.addClass('bind-ajax')
;
});
});
};
jQuery.fn.followLink=function(){
$(this).click();
if(!$(this).is('.bind-ajax'))
window.location.href=$(this).get(0).href;
return this;
}
function ajaxReload(ajaxid,options){
jQuery('div.ajaxbloc.ajax-id-'+ajaxid).ajaxReload(options);
}
jQuery.fn.ajaxReload=function(options){
options=options||{};
jQuery(this).trigger('ajaxReload',[options]);
return this;
}
jQuery.fn.animateLoading=function(){
this.attr('aria-busy','true').addClass('loading').children().css('opacity',0.5);
if(typeof ajax_image_searching!='undefined'){
var i=(this).find('.image_loading');
if(i.length)i.eq(0).html(ajax_image_searching);
else this.prepend('<span class="image_loading">'+ajax_image_searching+'</span>');
}
return this;
}
jQuery.fn.animeajax=jQuery.fn.animateLoading;
jQuery.fn.endLoading=function(hard){
hard=hard||false;
this.attr('aria-busy','false').removeClass('loading');
if(hard){
this.children().css('opacity','');
this.find('.image_loading').html('');
}
return this;
}
jQuery.fn.animateRemove=function(callback){
if(this.length){
var me=this;
var color=$("<div class='remove'></div>").css('background-color');
var sel=$(this);
if(sel.is('tr'))
sel=sel.add('>td',sel);
sel.addClass('remove').css({backgroundColor:color}).animate({opacity:"0.0"},'fast',function(){
sel.removeClass('remove').css({backgroundColor:''});
if(callback)
callback.apply(me);
});
}
return this;
}
jQuery.fn.animateAppend=function(callback){
if(this.length){
var me=this;
var color=$("<div class='append'></div>").css('background-color');
var origin=$(this).css('background-color')||'#ffffff';
if(origin=='transparent')origin='#ffffff';
var sel=$(this);
if(sel.is('tr'))
sel=sel.add('>td',sel);
sel.css('opacity','0.0').addClass('append').css({backgroundColor:color}).animate({opacity:"1.0"},1000,function(){
sel.animate({backgroundColor:origin},3000,function(){
sel.removeClass('append').css({backgroundColor:''});
if(callback)
callback.apply(me);
});
});
}
return this;
}
function parametre_url(url,c,v,sep,force_vide){
if(typeof(url)=='undefined'){
url='';
}
var p;
var ancre='';
var a='./';
var args=[];
p=url.indexOf('#');
if(p!=-1){
ancre=url.substring(p);
url=url.substring(0,p);
}
p=url.indexOf('?');
if(p!==-1){
if(p>0)a=url.substring(0,p);
args=url.substring(p+1).split('&');
}
else
a=url;
var regexp=new RegExp('^('+c.replace('[]','\\[\\]')+'\\[?\\]?)(=.*)?$');
var ajouts=[];
var u=(typeof(v)!=='object')?encodeURIComponent(v):v;
var na=[];
for(var n=0;n<args.length;n++){
var val=args[n];
try{
val=decodeURIComponent(val);
}catch(e){}
var r=val.match(regexp);
if(r&&r.length){
if(v==null){
return(r.length>2&&typeof r[2]!=='undefined')?r[2].substring(1):'';
}
else if(!v.length){
}
else if(r[1].substring(-2)!='[]'){
na.push(r[1]+'='+u);
ajouts.push(r[1]);
}
else na.push(args[n]);
}
else
na.push(args[n]);
}
if(v==null)return v;
if(v||v.length||force_vide){
ajouts="="+ajouts.join("=")+"=";
var all=c.split('|');
for(n=0;n<all.length;n++){
if(ajouts.search("="+all[n]+"=")==-1){
if(typeof(v)!=='object'){
na.push(all[n]+'='+u);
}
else{
var id=((all[n].substring(-2)=='[]')?all[n]:all[n]+"[]");
for(p=0;p<v.length;p++)
na.push(id+'='+encodeURIComponent(v[p]));
}
}
}
}
if(na.length){
if(!sep)sep='&';
a=a+"?"+na.join(sep);
}
return a+ancre;
}
if(!window.var_zajax_content)
window.var_zajax_content='contenu';
jQuery(function(){
jQuery('form:not(.bouton_action_post)').parents('div.ajax')
.formulaire_dyn_ajax();
jQuery('div.ajaxbloc').ajaxbloc();
jQuery("input[placeholder]:text").placeholderLabel();
jQuery('a.popin').click(function(){if(jQuery.modalbox)jQuery.modalbox(parametre_url(this.href,"var_zajax",jQuery(this).attr('data-var_zajax')?jQuery(this).attr('data-var_zajax'):var_zajax_content));return false;});
});
onAjaxLoad(function(){
if(jQuery){
jQuery('form:not(.bouton_action_post)',this).parents('div.ajax')
.formulaire_dyn_ajax();
if(jQuery(this).is('div.ajaxbloc'))
jQuery(this).ajaxbloc();
else if(jQuery(this).closest('div.ajaxbloc').length)
jQuery(this).closest('div.ajaxbloc').ajaxbloc();
else
jQuery('div.ajaxbloc',this).ajaxbloc();
jQuery("input[placeholder]:text",this).placeholderLabel();
jQuery('a.popin',this).click(function(){if(jQuery.modalbox)jQuery.modalbox(parametre_url(this.href,"var_zajax",jQuery(this).attr('data-var_zajax')?jQuery(this).attr('data-var_zajax'):var_zajax_content));return false;});
}
});


/* ../prive/javascript/jquery.colors.js */

(function(jQuery){
jQuery.each(['backgroundColor','borderBottomColor','borderLeftColor','borderRightColor','borderTopColor','color','outlineColor'],function(i,attr){
jQuery.fx.step[attr]=function(fx){
if(fx.state==0){
fx.start=getColor(fx.elem,attr);
fx.end=getRGB(fx.end);
}
fx.elem.style[attr]="rgb("+[
Math.max(Math.min(parseInt((fx.pos*(fx.end[0]-fx.start[0]))+fx.start[0]),255),0),
Math.max(Math.min(parseInt((fx.pos*(fx.end[1]-fx.start[1]))+fx.start[1]),255),0),
Math.max(Math.min(parseInt((fx.pos*(fx.end[2]-fx.start[2]))+fx.start[2]),255),0)
].join(",")+")";
}
});
function getRGB(color){
var result;
if(color&&color.constructor==Array&&color.length==3)
return color;
if(result=/rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(color))
return[parseInt(result[1]),parseInt(result[2]),parseInt(result[3])];
if(result=/rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(color))
return[parseFloat(result[1])*2.55,parseFloat(result[2])*2.55,parseFloat(result[3])*2.55];
if(result=/#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(color))
return[parseInt(result[1],16),parseInt(result[2],16),parseInt(result[3],16)];
if(result=/#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(color))
return[parseInt(result[1]+result[1],16),parseInt(result[2]+result[2],16),parseInt(result[3]+result[3],16)];
return colors[jQuery.trim(color).toLowerCase()];
}
function getColor(elem,attr){
var color;
do{
color=jQuery.curCSS(elem,attr);
if(color!=''&&color!='transparent'||jQuery.nodeName(elem,"body"))
break;
attr="backgroundColor";
}while(elem=elem.parentNode);
return getRGB(color);
};
var colors={
aqua:[0,255,255],
azure:[240,255,255],
beige:[245,245,220],
black:[0,0,0],
blue:[0,0,255],
brown:[165,42,42],
cyan:[0,255,255],
darkblue:[0,0,139],
darkcyan:[0,139,139],
darkgrey:[169,169,169],
darkgreen:[0,100,0],
darkkhaki:[189,183,107],
darkmagenta:[139,0,139],
darkolivegreen:[85,107,47],
darkorange:[255,140,0],
darkorchid:[153,50,204],
darkred:[139,0,0],
darksalmon:[233,150,122],
darkviolet:[148,0,211],
fuchsia:[255,0,255],
gold:[255,215,0],
green:[0,128,0],
indigo:[75,0,130],
khaki:[240,230,140],
lightblue:[173,216,230],
lightcyan:[224,255,255],
lightgreen:[144,238,144],
lightgrey:[211,211,211],
lightpink:[255,182,193],
lightyellow:[255,255,224],
lime:[0,255,0],
magenta:[255,0,255],
maroon:[128,0,0],
navy:[0,0,128],
olive:[128,128,0],
orange:[255,165,0],
pink:[255,192,203],
purple:[128,0,128],
violet:[128,0,128],
red:[255,0,0],
silver:[192,192,192],
white:[255,255,255],
yellow:[255,255,0]
};
})(jQuery);


/* ../prive/javascript/jquery.cookie.js */

jQuery.cookie=function(name,value,options){
if(typeof value!='undefined'){
options=options||{};
if(value===null){
value='';
options.expires=-1;
}
var expires='';
if(options.expires&&(typeof options.expires=='number'||options.expires.toUTCString)){
var date;
if(typeof options.expires=='number'){
date=new Date();
date.setTime(date.getTime()+(options.expires*24*60*60*1000));
}else{
date=options.expires;
}
expires='; expires='+date.toUTCString();
}
var path=options.path?'; path='+(options.path):'';
var domain=options.domain?'; domain='+(options.domain):'';
var secure=options.secure?'; secure':'';
document.cookie=[name,'=',encodeURIComponent(value),expires,path,domain,secure].join('');
}else{
var cookieValue=null;
if(document.cookie&&document.cookie!=''){
var cookies=document.cookie.split(';');
for(var i=0;i<cookies.length;i++){
var cookie=jQuery.trim(cookies[i]);
if(cookie.substring(0,name.length+1)==(name+'=')){
cookieValue=decodeURIComponent(cookie.substring(name.length+1));
break;
}
}
}
return cookieValue;
}
};


/* ../prive/javascript/spip_barre.js */

var theSelection=false;
var clientPC=navigator.userAgent.toLowerCase();
var clientVer=parseInt(navigator.appVersion);
var is_ie=((clientPC.indexOf("msie")!=-1)&&(clientPC.indexOf("opera")==-1));
var is_nav=((clientPC.indexOf('mozilla')!=-1)&&(clientPC.indexOf('spoofer')==-1)
&&(clientPC.indexOf('compatible')==-1)&&(clientPC.indexOf('opera')==-1)
&&(clientPC.indexOf('webtv')==-1)&&(clientPC.indexOf('hotjava')==-1));
var is_moz=0;
var is_win=((clientPC.indexOf("win")!=-1)||(clientPC.indexOf("16bit")!=-1));
var is_mac=(clientPC.indexOf("mac")!=-1);
function barre_inserer(text,champ){
var txtarea=champ;
if(document.selection){
txtarea.focus();
var r=document.selection.createRange();
if(r==null){
txtarea.selectionStart=txtarea.value.length;
txtarea.selectionEnd=txtarea.selectionStart;
}
else{
var re=txtarea.createTextRange();
var rc=re.duplicate();
re.moveToBookmark(r.getBookmark());
rc.setEndPoint('EndToStart',re);
txtarea.selectionStart=rc.text.length;
txtarea.selectionEnd=rc.text.length+r.text.length;
}
}
mozWrap(txtarea,'',text);
}
function helpline(help,champ){
champ.value=help;
}
function setCaretToEnd(input){
setSelectionRange(input,input.value.length,input.value.length);
}
function setSelectionRange(input,selectionStart,selectionEnd){
if(input.setSelectionRange){
input.focus();
input.setSelectionRange(selectionStart,selectionEnd);
}
else if(input.createTextRange){
var range=input.createTextRange();
range.collapse(true);
range.moveEnd('character',selectionEnd);
range.moveStart('character',selectionStart);
range.select();
}
}
function mozWrap(txtarea,open,close)
{
var selLength=txtarea.textLength;
var selStart=txtarea.selectionStart;
var selEnd=txtarea.selectionEnd;
if(selEnd==1||selEnd==2)
selEnd=selLength;
var selTop=txtarea.scrollTop;
if(selEnd-selStart>0&&(txtarea.value).substring(selEnd-1,selEnd)==' ')selEnd=selEnd-1;
var s1=(txtarea.value).substring(0,selStart);
var s2=(txtarea.value).substring(selStart,selEnd)
var s3=(txtarea.value).substring(selEnd,selLength);
if((txtarea.value).substring(selEnd,selEnd+1)=='}'&&close.substring(0,1)=="}")close=close+" ";
if((txtarea.value).substring(selEnd-1,selEnd)=='}'&&close.substring(0,1)=="}")close=" "+close;
if((txtarea.value).substring(selStart-1,selStart)=='{'&&open.substring(0,1)=="{")open=" "+open;
if((txtarea.value).substring(selStart,selStart+1)=='{'&&open.substring(0,1)=="{")open=open+" ";
txtarea.value=s1+open+s2+close+s3;
selDeb=selStart+open.length;
selFin=selEnd+close.length;
window.setSelectionRange(txtarea,selDeb,selFin);
txtarea.scrollTop=selTop;
txtarea.focus();
return;
}
function storeCaret(textEl){
if(textEl.createTextRange)
textEl.caretPos=document.selection.createRange().duplicate();
}


/* ../prive/javascript/layer.js */
var memo_obj=new Array();
var url_chargee=new Array();
var xhr_actifs={};
function findObj_test_forcer(n,forcer){
var p,i,x;
if(memo_obj[n]&&!forcer){
return memo_obj[n];
}
var d=document;
if((p=n.indexOf("?"))>0&&parent.frames.length){
d=parent.frames[n.substring(p+1)].document;
n=n.substring(0,p);
}
if(!(x=d[n])&&d.all){
x=d.all[n];
}
for(i=0;!x&&i<d.forms.length;i++){
x=d.forms[i][n];
}
for(i=0;!x&&d.layers&&i<d.layers.length;i++)x=findObj(n,d.layers[i].document);
if(!x&&document.getElementById)x=document.getElementById(n);
if(!forcer)memo_obj[n]=x;
return x;
}
function findObj(n){
return findObj_test_forcer(n,false);
}
function findObj_forcer(n){
return findObj_test_forcer(n,true);
}
function slide_horizontal(couche,slide,align,depart,etape){
var obj=findObj_forcer(couche);
if(!obj)return;
if(!etape){
if(align=='left')depart=obj.scrollLeft;
else depart=obj.firstChild.offsetWidth-obj.scrollLeft;
etape=0;
}
etape=Math.round(etape)+1;
pos=Math.round(depart)+Math.round(((slide-depart)/10)*etape);
if(align=='left')obj.scrollLeft=pos;
else obj.scrollLeft=obj.firstChild.offsetWidth-pos;
if(etape<10)setTimeout("slide_horizontal('"+couche+"', '"+slide+"', '"+align+"', '"+depart+"', '"+etape+"')",60);
}
function changerhighlight(couche){
jQuery(couche)
.addClass('on')
.siblings()
.not(couche)
.removeClass('on');
jQuery('.petite-racine.on').removeClass('on');
}
function aff_selection(arg,idom,url,event){
noeud=findObj_forcer(idom);
if(noeud){
noeud.style.display="none";
charger_node_url(url+arg,noeud,'','',event);
}
return false;
}
function aff_selection_titre(titre,id,idom,nid)
{
t=findObj_forcer('titreparent');
t.value=titre;
t=findObj_forcer(nid);
t.value=id;
jQuery(t).trigger('change');
t=findObj_forcer(idom);
t.style.display='none';
p=$(t).parents('form');
if(p.is('.submit_plongeur'))p.get(p.length-1).submit();
}
function aff_selection_provisoire(id,racine,url,col,sens,informer,event)
{
charger_id_url(url.href,
racine+'_col_'+(col+1),
function(){
slide_horizontal(racine+'_principal',((col-1)*150),sens);
aff_selection(id,racine+"_selection",informer);
},
event);
return false;
}
function onkey_rechercher(valeur,rac,url,img,nid,init){
var Field=findObj_forcer(rac);
if(!valeur.length){
init=findObj_forcer(init);
if(init&&init.href){charger_node_url(init.href,Field);}
}else{
charger_node_url(url+valeur,
Field,
function(){
var n=Field.childNodes.length-1;
if((n==1)){
noeud=Field.childNodes[n].firstChild;
if(noeud.title)
aff_selection_titre(noeud.firstChild.nodeValue,noeud.title,rac,nid);
}
},
img);
}
return false;
}
var verifForm_clicked=false;
function verifForm(racine){
verifForm_clicked=false;
if(!jQuery)return;
if(!jQuery.browser.msie)
jQuery('form:not(.bouton_action_post)',racine||document).not('.verifformok')
.keypress(function(e){
if(
((e.ctrlKey&&(
(((e.charCode||e.keyCode)==115)||((e.charCode||e.keyCode)==83))
||(e.charCode==19&&e.keyCode==19)
)
)
||(e.keyCode==19&&jQuery.browser.opera))
&&!verifForm_clicked
){
verifForm_clicked=true;
jQuery(this).find('input[type=submit]')
.click();
return false;
}
}).addClass('verifformok');
else
jQuery('form:not(.bouton_action_post)',racine||document).not('.verifformok')
.keydown(function(e){
if(!e.charCode&&e.keyCode==119&&!verifForm_clicked){
verifForm_clicked=true;
jQuery(this).find('input[type=submit]')
.click();
return false;
}
}).addClass('verifformok');
}
function AjaxSqueezeNode(trig,target,f,event)
{
var i,callback;
if(!f){
callback=function(){verifForm(this);}
}
else{
callback=function(res,status){
f.apply(this,[res,status]);
verifForm(this);
}
}
valid=false;
if(typeof(window['_OUTILS_DEVELOPPEURS'])!='undefined'){
if(!(navigator.userAgent.toLowerCase().indexOf("firefox/1.0")))
valid=(typeof event=='object')&&(event.altKey||event.metaKey);
}
if(typeof(trig)=='string'){
if(valid){
window.open(trig+'&transformer_xml=valider_xml');
}else{
jQuery(target).animeajax();
}
res=jQuery.ajax({
"url":trig,
"complete":function(r,s){
AjaxRet(r,s,target,callback);
}
});
return res;
}
if(valid){
var doc=window.open("","valider").document;
doc.open();
doc.close();
target=doc.body;
}
else{
jQuery(target).animeajax();
}
jQuery(trig).ajaxSubmit({
"target":target,
"success":function(res,status){
if(status=='error')return this.html('Erreur HTTP');
callback.apply(this,[res,status]);
},
"beforeSubmit":function(vars){
if(valid)
vars.push({"name":"transformer_xml","value":"valider_xml"});
return true;
}
});
return true;
}
function AjaxRet(res,status,target,callback){
if(res.aborted)return;
if(status=='error')return jQuery(target).html('HTTP Error');
jQuery(target)
.html(res.responseText)
.each(callback,[res.responseText,status]);
}
function charger_id_url(myUrl,myField,jjscript,event)
{
var Field=findObj_forcer(myField);
if(!Field)return true;
if(!myUrl){
jQuery(Field).empty();
retour_id_url(Field,jjscript);
return true;
}else return charger_node_url(myUrl,Field,jjscript,findObj_forcer('img_'+myField),event);
}
function charger_node_url(myUrl,Field,jjscript,img,event)
{
if(url_chargee[myUrl]){
var el=jQuery(Field).html(url_chargee[myUrl])[0];
retour_id_url(el,jjscript);
jQuery.spip.triggerAjaxLoad(el);
return false;
}
else{
if(img)img.style.visibility="visible";
if(xhr_actifs[Field]){xhr_actifs[Field].aborted=true;xhr_actifs[Field].abort();}
xhr_actifs[Field]=AjaxSqueezeNode(myUrl,
Field,
function(r){
xhr_actifs[Field]=undefined;
if(img)img.style.visibility="hidden";
url_chargee[myUrl]=r;
retour_id_url(Field,jjscript);
slide_horizontal($(Field).children().attr("id")+'_principal',$(Field).width(),$(Field).css("text-align"));
},
event);
return false;
}
}
function retour_id_url(Field,jjscript)
{
jQuery(Field).css({'visibility':'visible','display':'block'});
if(jjscript)jjscript();
}
function charger_node_url_si_vide(url,noeud,gifanime,jjscript,event){
if(noeud.style.display!='none'){
noeud.style.display='none';}
else{
if(noeud.innerHTML!=""){
noeud.style.visibility="visible";
noeud.style.display="block";
}else{
charger_node_url(url,noeud,'',gifanime,event);
}
}
return false;
}
jQuery(document).ready(function(){
verifForm();
onAjaxLoad(verifForm);
});


/* ../prive/javascript/presentation.js */

$.fn.hoverClass=function(c){
return this.each(function(){
$(this).hover(
function(){$(this).addClass(c);},
function(){$(this).removeClass(c);}
);
});
};
var accepter_change_statut=false;
function selec_statut(id,type,decal,puce,script){
node=$('.imgstatut'+type+id);
if(!accepter_change_statut)
accepter_change_statut=confirm(confirm_changer_statut);
if(!accepter_change_statut||!node.length)return;
$('.statutdecal'+type+id)
.css('margin-left',decal+'px')
.removeClass('on');
$.get(script,function(c){
if(!c)
node.attr('src',puce);
else{
r=window.open();
r.document.write(c);
r.document.close();
}
});
}
function prepare_selec_statut(node,nom,type,id,action)
{
$(node)
.hoverClass('on')
.addClass('on')
.load(action+'&type='+type+'&id='+id);
}
jQuery.fn.showother=function(cible){
var me=this;
if(me.is('.replie')){
me.addClass('deplie').removeClass('replie');
jQuery(cible)
.slideDown('fast',
function(){
jQuery(me)
.addClass('blocdeplie')
.removeClass('blocreplie')
.removeClass('togglewait');
}
).trigger('deplie');
}
return this;
}
jQuery.fn.hideother=function(cible){
var me=this;
if(!me.is('.replie')){
me.addClass('replie').removeClass('deplie');
jQuery(cible)
.slideUp('fast',
function(){
jQuery(me)
.addClass('blocreplie')
.removeClass('blocdeplie')
.removeClass('togglewait');
}
).trigger('replie');
}
return this;
}
jQuery.fn.toggleother=function(cible){
if(this.is('.deplie'))
return this.hideother(cible);
else
return this.showother(cible);
}
jQuery.fn.depliant=function(cible){
if(!this.is('.depliant')){
var time=400;
var me=this;
this
.addClass('depliant');
if(!me.is('.deplie')){
me.addClass('hover')
.addClass('togglewait');
var t=setTimeout(function(){
me.toggleother(cible);
t=null;
},time);
}
me
.hover(function(e){
me
.addClass('hover');
if(!me.is('.deplie')){
me.addClass('togglewait');
if(t){clearTimeout(t);t=null;}
t=setTimeout(function(){
me.toggleother(cible);
t=null;
},time);
}
}
,function(e){
if(t){clearTimeout(t);t=null;}
me
.removeClass('hover');
})
.end();
}
return this;
}
jQuery.fn.depliant_clicancre=function(cible){
var me=this.parent();
if(me.is('.togglewait'))return false;
me.toggleother(cible);
return false;
}
function reloadExecPage(exec,blocs){
if(window.jQuery){
jQuery(function(){
if(!blocs)
blocs="#navigation,#extra";
jQuery(blocs).find('>div').ajaxReload({args:{exec:exec}});
if(exec.match(/_edit$/))
jQuery('body').addClass('edition');
else
jQuery('body').removeClass('edition');
})
}
}


/* ../prive/javascript/gadgets.js */
function init_gadgets(url_menu_rubrique){
jQuery('#boutonbandeautoutsite').one('mouseover',function(){
jQuery(this).siblings('ul').find('li:first>a').animeajax();
jQuery.ajax({
url:url_menu_rubrique,
success:function(c){
jQuery('#boutonbandeautoutsite').siblings('ul').remove();
jQuery('#boutonbandeautoutsite')
.after(c)
.parent().find('li').menuFocus();
}
});
});
}
function focus_zone(selecteur){
jQuery(selecteur).eq(0).find('a,input:visible').get(0).focus();
return false;
}
jQuery(document).ready(function(){
init_gadgets(url_menu_rubrique);
var is_open=0;
jQuery.fn.menuItemOpen=function(){
jQuery(this)
.addClass('actif')
.parents('li').addClass('actif');
jQuery(this).siblings('li').removeClass('actif_tempo');
is_open=true;
return this;
}
jQuery.fn.menuItemClose=function(){
jQuery(this)
.removeClass('actif_tempo');
is_open=(jQuery(this).parents('ul').eq(-1).find('li.actif').length>0);
return this;
}
jQuery.fn.menuFocus=function(){
jQuery(this)
.hover(
function(){
if(this.timerout)
clearTimeout(this.timerout);
this.timerout=null;
this.timerin=null;
if(is_open)
jQuery(this).menuItemOpen();
else{
var me=jQuery(this);
this.timerin=setTimeout(function(){
me.menuItemOpen(null);
},200);
}
}
,
function(){
if(this.timerin)
clearTimeout(this.timerin);
this.timerin=null;
if(is_open){
var me=jQuery(this).removeClass('actif').addClass('actif_tempo');
this.timerout=setTimeout(function(){
me.menuItemClose();
},400);
}
}
)
.find('>a').focus(function(){
jQuery(this).parents('li').addClass('actif');
})
.blur(function(){
jQuery(this).parents('li').removeClass('actif');
});
return this;
}
jQuery('#bando_navigation').hover(function(){
hauteur=parseInt(jQuery('#bando_navigation .largeur').height())
+parseInt(jQuery('#bando_navigation').css("padding-top"))
+parseInt(jQuery('#bando_navigation').css("padding-bottom"));
jQuery('#bando_navigation ul li>ul').css({'top':hauteur});
});
jQuery('#bando_navigation li').menuFocus();
jQuery('#bando_outils ul.bandeau_rubriques li').menuFocus();
jQuery('#bandeau_haut #formRecherche input').hover(function(){
jQuery('#bandeau_haut ul.actif').trigger('mouseout');
});
jQuery('#bando_liens_rapides a')
.focus(function(){
jQuery('#bando_liens_rapides').addClass('actif');
})
.blur(function(){
jQuery('#bando_liens_rapides').removeClass('actif');
});
if(typeof window.test_accepte_ajax!="undefined")
test_accepte_ajax();
});


/* ../plugins-dist/mediabox/javascript/jquery.colorbox.js?1407942352 */

(function($,document,window){
var
defaults={
transition:"elastic",
speed:300,
width:false,
initialWidth:"600",
innerWidth:false,
maxWidth:false,
minWidth:false,
height:false,
initialHeight:"450",
innerHeight:false,
maxHeight:false,
minHeight:false,
scalePhotos:true,
scrolling:true,
inline:false,
html:false,
iframe:false,
fastIframe:true,
photo:false,
href:false,
title:false,
rel:false,
opacity:0.9,
preloading:true,
current:"image {current} of {total}",
previous:"previous",
next:"next",
close:"close",
xhrError:"This content failed to load.",
imgError:"This image failed to load.",
open:false,
returnFocus:true,
reposition:true,
loop:true,
slideshow:false,
slideshowAuto:true,
slideshowSpeed:2500,
slideshowStart:"start slideshow",
slideshowStop:"stop slideshow",
onOpen:false,
onLoad:false,
onComplete:false,
onCleanup:false,
onClosed:false,
overlayClose:true,
escKey:true,
arrowKey:true,
top:false,
bottom:false,
left:false,
right:false,
fixed:false,
data:undefined
},
colorbox='colorbox',
colorbox_class='box_mediabox box_modalbox',
prefix='cbox',
boxElement=prefix+'Element',
event_open=prefix+'_open',
event_load=prefix+'_load',
event_complete=prefix+'_complete',
event_cleanup=prefix+'_cleanup',
event_closed=prefix+'_closed',
event_purge=prefix+'_purge',
isIE=!$.support.opacity&&!$.support.style,
isIE6=isIE&&!window.XMLHttpRequest,
event_ie6=prefix+'_IE6',
$overlay,
$box,
$wrap,
$content,
$topBorder,
$leftBorder,
$rightBorder,
$bottomBorder,
$related,
$window,
$loaded,
$loadingBay,
$loadingOverlay,
$title,
$current,
$slideshow,
$next,
$prev,
$close,
$groupControls,
settings,
interfaceHeight,
interfaceWidth,
loadedHeight,
loadedWidth,
element,
index,
photo,
open,
active,
closing,
loadingTimer,
publicMethod,
div="div",
init;
function $tag(tag,id,css){
var element=document.createElement(tag);
if(id){
element.id=prefix+id;
}
if(css){
element.style.cssText=css;
}
return $(element);
}
function getIndex(increment){
var
max=$related.length,
newIndex=(index+increment)%max;
return(newIndex<0)?max+newIndex:newIndex;
}
function setSize(size,dimension){
return Math.round((/%/.test(size)?((dimension==='x'?winWidth():winHeight())/100):1)*parseInt(size,10));
}
function isImage(url){
return settings.photo||/\.(gif|png|jp(e|g|eg)|bmp|ico)((#|\?).*)?$/i.test(url);
}
function winWidth(){
return window.innerWidth||$window.width();
}
function winHeight(){
return window.innerHeight||$window.height();
}
function makeSettings(){
var i,
data=$.data(element,colorbox);
if(data==null){
settings=$.extend({},defaults);
if(console&&console.log){
console.log('Error: cboxElement missing settings object');
}
}else{
settings=$.extend({},data);
}
for(i in settings){
if($.isFunction(settings[i])&&i.slice(0,2)!=='on'){
settings[i]=settings[i].call(element);
}
}
settings.rel=settings.rel||element.rel||$(element).data('rel')||'nofollow';
settings.href=settings.href||$(element).attr('href');
settings.title=settings.title||element.title;
if(typeof settings.href==="string"){
settings.href=$.trim(settings.href);
}
}
function trigger(event,callback){
$.event.trigger(event);
if(callback){
callback.call(element);
}
}
function slideshow(){
var
timeOut,
className=prefix+"Slideshow_",
click="click."+prefix,
start,
stop,
clear;
if(settings.slideshow&&$related[1]){
start=function(){
$slideshow
.text(settings.slideshowStop)
.unbind(click)
.bind(event_complete,function(){
if(settings.loop||$related[index+1]){
timeOut=setTimeout(publicMethod.next,settings.slideshowSpeed);
}
})
.bind(event_load,function(){
clearTimeout(timeOut);
})
.one(click+' '+event_cleanup,stop);
$box.removeClass(className+"off").addClass(className+"on");
timeOut=setTimeout(publicMethod.next,settings.slideshowSpeed);
};
stop=function(){
clearTimeout(timeOut);
$slideshow
.text(settings.slideshowStart)
.unbind([event_complete,event_load,event_cleanup,click].join(' '))
.one(click,function(){
publicMethod.next();
start();
});
$box.removeClass(className+"on").addClass(className+"off");
};
if(settings.slideshowAuto){
start();
}else{
stop();
}
}else{
$box.removeClass(className+"off "+className+"on");
}
}
function launch(target){
if(!closing){
element=target;
makeSettings();
$related=$(element);
index=0;
if(settings.rel!=='nofollow'){
$related=$('.'+boxElement).filter(function(){
var data=$.data(this,colorbox),
relRelated;
if(data){
relRelated=$(this).data('rel')||data.rel||this.rel;
}
return(relRelated===settings.rel);
});
index=$related.index(element);
if(index===-1){
$related=$related.add(element);
index=$related.length-1;
}
}
if(!open){
open=active=true;
$box.show();
if(settings.returnFocus){
$(element).blur().one(event_closed,function(){
$(this).focus();
});
}
$overlay.css({"opacity":+settings.opacity,"cursor":settings.overlayClose?"pointer":"auto"}).show();
settings.w=setSize(settings.initialWidth,'x');
settings.h=setSize(settings.initialHeight,'y');
publicMethod.position();
if(isIE6){
$window.bind('resize.'+event_ie6+' scroll.'+event_ie6,function(){
$overlay.css({width:winWidth(),height:winHeight(),top:$window.scrollTop(),left:$window.scrollLeft()});
}).trigger('resize.'+event_ie6);
}
trigger(event_open,settings.onOpen);
$groupControls.add($title).hide();
$close.html(settings.close).show();
}
publicMethod.load(true);
}
}
function appendHTML(){
if(!$box&&document.body){
init=false;
$window=$(window);
$box=$tag(div).attr({id:colorbox,'class':(isIE?prefix+(isIE6?'IE6':'IE'):'')+colorbox_class}).hide();
$overlay=$tag(div,"Overlay",isIE6?'position:absolute':'').hide();
$loadingOverlay=$tag(div,"LoadingOverlay").add($tag(div,"LoadingGraphic"));
$wrap=$tag(div,"Wrapper");
$content=$tag(div,"Content").append(
$loaded=$tag(div,"LoadedContent",'width:0; height:0; overflow:hidden'),
$title=$tag(div,"Title"),
$current=$tag(div,"Current"),
$next=$tag(div,"Next"),
$prev=$tag(div,"Previous"),
$slideshow=$tag(div,"Slideshow").bind(event_open,slideshow),
$close=$tag(div,"Close")
);
$wrap.append(
$tag(div).append(
$tag(div,"TopLeft"),
$topBorder=$tag(div,"TopCenter"),
$tag(div,"TopRight")
),
$tag(div,false,'clear:left').append(
$leftBorder=$tag(div,"MiddleLeft"),
$content,
$rightBorder=$tag(div,"MiddleRight")
),
$tag(div,false,'clear:left').append(
$tag(div,"BottomLeft"),
$bottomBorder=$tag(div,"BottomCenter"),
$tag(div,"BottomRight")
)
).find('div div').css({'float':'left'});
$loadingBay=$tag(div,false,'position:absolute; width:9999px; visibility:hidden; display:none');
$groupControls=$next.add($prev).add($current).add($slideshow);
$(document.body).append($overlay,$box.append($wrap,$loadingBay));
}
}
function addBindings(){
if($box){
if(!init){
init=true;
interfaceHeight=$topBorder.height()+$bottomBorder.height()+$content.outerHeight(true)-$content.height();
interfaceWidth=$leftBorder.width()+$rightBorder.width()+$content.outerWidth(true)-$content.width();
loadedHeight=$loaded.outerHeight(true);
loadedWidth=$loaded.outerWidth(true);
$box.css({"padding-bottom":interfaceHeight,"padding-right":interfaceWidth});
$next.click(function(){
publicMethod.next();
});
$prev.click(function(){
publicMethod.prev();
});
$close.click(function(){
publicMethod.close();
});
$overlay.click(function(){
if(settings.overlayClose){
publicMethod.close();
}
});
$(document).bind('keydown.'+prefix,function(e){
var key=e.keyCode;
if(open&&settings.escKey&&key===27){
e.preventDefault();
publicMethod.close();
}
if(open&&settings.arrowKey&&$related[1]){
if(key===37){
e.preventDefault();
$prev.click();
}else if(key===39){
e.preventDefault();
$next.click();
}
}
});
$('.'+boxElement,document).live('click',function(e){
if(!(e.which>1||e.shiftKey||e.altKey||e.metaKey)){
e.preventDefault();
launch(this);
}
});
}
return true;
}
return false;
}
if($.colorbox){
return;
}
$(appendHTML);
publicMethod=$.fn[colorbox]=$[colorbox]=function(options,callback){
var $this=this;
options=options||{};
appendHTML();
if(addBindings()){
if(!$this[0]){
if($this.selector){
return $this;
}
$this=$('<a/>');
options.open=true;
}
if(callback){
options.onComplete=callback;
}
$this.each(function(){
$.data(this,colorbox,$.extend({},$.data(this,colorbox)||defaults,options));
var eltclass=$(this).attr('class');
if(eltclass){
if(eltclass.indexOf("boxWidth-")!==-1){
var w=eltclass.match(/boxWidth-([^\s'">]*)/);
w=w[1].replace(/pc/,'%');
$.data(this,colorbox,$.extend($.data(this,colorbox),{width:w}));
}
if(eltclass.indexOf("boxHeight-")!==-1){
var h=eltclass.match(/boxHeight-([^\s'">]*)/);
h=h[1].replace(/pc/,'%');
$.data(this,colorbox,$.extend($.data(this,colorbox),{height:h}));
}
if(eltclass.indexOf("boxIframe")!==-1){
$.data(this,colorbox,$.extend($.data(this,colorbox),{iframe:true}));
}
if(eltclass.indexOf("boxInline")!==-1){
$.data(this,colorbox,$.extend($.data(this,colorbox),{inline:true}));
}
if(eltclass.indexOf("boxSlideshow_off")!==-1){
$.data(this,colorbox,$.extend($.data(this,colorbox),{slideshow:false}));
}
}
}).addClass(boxElement);
if(($.isFunction(options.open)&&options.open.call($this))||options.open){
launch($this[0]);
}
}
return $this;
};
publicMethod.position=function(speed,loadedCallback){
var
css,
top=0,
left=0,
offset=$box.offset(),
scrollTop,
scrollLeft;
$window.unbind('resize.'+prefix);
$box.css({top:-9e4,left:-9e4});
scrollTop=$window.scrollTop();
scrollLeft=$window.scrollLeft();
if(settings.fixed&&!isIE6){
offset.top-=scrollTop;
offset.left-=scrollLeft;
$box.css({position:'fixed'});
}else{
top=scrollTop;
left=scrollLeft;
$box.css({position:'absolute'});
}
if(settings.right!==false){
left+=Math.max(winWidth()-settings.w-loadedWidth-interfaceWidth-setSize(settings.right,'x'),0);
}else if(settings.left!==false){
left+=setSize(settings.left,'x');
}else{
left+=Math.round(Math.max(winWidth()-settings.w-loadedWidth-interfaceWidth,0)/2);
}
if(settings.bottom!==false){
top+=Math.max(winHeight()-settings.h-loadedHeight-interfaceHeight-setSize(settings.bottom,'y'),0);
}else if(settings.top!==false){
top+=setSize(settings.top,'y');
}else{
top+=Math.round(Math.max(winHeight()-settings.h-loadedHeight-interfaceHeight,0)/2);
}
$box.css({top:offset.top,left:offset.left});
speed=($box.width()===settings.w+loadedWidth&&$box.height()===settings.h+loadedHeight)?0:speed||0;
$wrap[0].style.width=$wrap[0].style.height="9999px";
function modalDimensions(that){
$topBorder[0].style.width=$bottomBorder[0].style.width=$content[0].style.width=that.style.width;
$content[0].style.height=$leftBorder[0].style.height=$rightBorder[0].style.height=that.style.height;
}
css={width:settings.w+loadedWidth,height:settings.h+loadedHeight,top:top,left:left};
if(speed===0){
$box.css(css);
}
$box.dequeue().animate(css,{
duration:speed,
complete:function(){
modalDimensions(this);
active=false;
$wrap[0].style.width=(settings.w+loadedWidth+interfaceWidth)+"px";
$wrap[0].style.height=(settings.h+loadedHeight+interfaceHeight)+"px";
if(settings.reposition){
setTimeout(function(){
$window.bind('resize.'+prefix,publicMethod.position);
},1);
}
if(loadedCallback){
loadedCallback();
}
},
step:function(){
modalDimensions(this);
}
});
};
publicMethod.resize=function(options){
if(open){
options=options||{};
if(options.width){
settings.w=setSize(options.width,'x')-loadedWidth-interfaceWidth;
}
if(options.innerWidth){
settings.w=setSize(options.innerWidth,'x');
}
$loaded.css({width:settings.w});
if(options.height){
settings.h=setSize(options.height,'y')-loadedHeight-interfaceHeight;
}
if(options.innerHeight){
settings.h=setSize(options.innerHeight,'y');
}
if(!options.innerHeight&&!options.height){
$loaded.css({height:"auto"});
settings.h=$loaded.height();
}
$loaded.css({height:settings.h});
publicMethod.position(settings.transition==="none"?0:settings.speed);
}
};
publicMethod.prep=function(object){
if(!open){
return;
}
var callback,speed=settings.transition==="none"?0:settings.speed;
$loaded.remove();
$loaded=$tag(div,'LoadedContent').append(object);
function getWidth(){
settings.w=settings.w||$loaded.width();
settings.w=settings.minw&&settings.minw>settings.w?settings.minw:settings.w;
settings.w=settings.mw&&settings.mw<settings.w?settings.mw:settings.w;
return settings.w;
}
function getHeight(){
settings.h=settings.h||$loaded.height();
settings.h=settings.minh&&settings.minh>settings.h?settings.minh:settings.h;
settings.h=settings.mh&&settings.mh<settings.h?settings.mh:settings.h;
return settings.h;
}
$loaded.hide()
.appendTo($loadingBay.show())
.css({width:getWidth(),overflow:settings.scrolling?'auto':'hidden'})
.css({height:getHeight()})
.prependTo($content);
$loadingBay.hide();
$(photo).css({'float':'none'});
if(isIE6){
$('select').not($box.find('select')).filter(function(){
return this.style.visibility!=='hidden';
}).css({'visibility':'hidden'}).one(event_cleanup,function(){
this.style.visibility='inherit';
});
}
callback=function(){
var preload,
i,
total=$related.length,
iframe,
frameBorder='frameBorder',
allowTransparency='allowTransparency',
complete,
src,
img,
data;
if(!open){
return;
}
function removeFilter(){
if(isIE){
$box[0].style.removeAttribute('filter');
}
}
complete=function(){
clearTimeout(loadingTimer);
$loadingOverlay.detach().hide();
trigger(event_complete,settings.onComplete);
};
if(isIE){
if(photo){
$loaded.fadeIn(100);
}
}
$title.html(settings.title).add($loaded).show();
if(total>1){
if(typeof settings.current==="string"){
$current.html(settings.current.replace('{current}',index+1).replace('{total}',total)).show();
}
$next[(settings.loop||index<total-1)?"show":"hide"]().html(settings.next);
$prev[(settings.loop||index)?"show":"hide"]().html(settings.previous);
if(settings.slideshow){
$slideshow.show();
}
if(settings.preloading){
preload=[
getIndex(-1),
getIndex(1)
];
while(i=$related[preload.pop()]){
data=$.data(i,colorbox);
if(data&&data.href){
src=data.href;
if($.isFunction(src)){
src=src.call(i);
}
}else{
src=i.href;
}
if(isImage(src)){
img=new Image();
img.src=src;
}
}
}
}else{
$groupControls.hide();
}
if(settings.iframe){
iframe=$tag('iframe')[0];
if(frameBorder in iframe){
iframe[frameBorder]=0;
}
if(allowTransparency in iframe){
iframe[allowTransparency]="true";
}
iframe.name=prefix+(+new Date());
if(settings.fastIframe){
complete();
}else{
$(iframe).one('load',complete);
}
iframe.src=settings.href;
if(!settings.scrolling){
iframe.scrolling="no";
}
$(iframe).addClass(prefix+'Iframe').appendTo($loaded).one(event_purge,function(){
iframe.src="//about:blank";
});
}else{
complete();
}
if(settings.transition==='fade'){
$box.fadeTo(speed,1,removeFilter);
}else{
removeFilter();
}
};
if(settings.transition==='fade'){
$box.fadeTo(speed,0,function(){
publicMethod.position(0,callback);
});
}else{
publicMethod.position(speed,callback);
}
};
publicMethod.load=function(launched){
var href,setResize,prep=publicMethod.prep;
active=true;
photo=false;
element=$related[index];
if(!launched){
makeSettings();
}
trigger(event_purge);
trigger(event_load,settings.onLoad);
settings.h=settings.height?
setSize(settings.height,'y')-loadedHeight-interfaceHeight:
settings.innerHeight&&setSize(settings.innerHeight,'y');
settings.w=settings.width?
setSize(settings.width,'x')-loadedWidth-interfaceWidth:
settings.innerWidth&&setSize(settings.innerWidth,'x');
settings.mw=settings.w;
settings.mh=settings.h;
settings.minw=settings.w;
settings.minh=settings.h;
if(settings.maxWidth){
settings.mw=setSize(settings.maxWidth,'x')-loadedWidth-interfaceWidth;
settings.mw=settings.w&&settings.w<settings.mw?settings.w:settings.mw;
}
if(settings.minWidth){
settings.minw=setSize(settings.minWidth,'x')-loadedWidth-interfaceWidth;
settings.minw=settings.w&&settings.w>settings.minw?settings.w:settings.minw;
}
if(settings.maxHeight){
settings.mh=setSize(settings.maxHeight,'y')-loadedHeight-interfaceHeight;
settings.mh=settings.h&&settings.h<settings.mh?settings.h:settings.mh;
}
if(settings.minHeight){
settings.minh=setSize(settings.minHeight,'y')-loadedHeight-interfaceHeight;
settings.minh=settings.h&&settings.h>settings.minh?settings.h:settings.minh;
}
href=settings.href;
loadingTimer=setTimeout(function(){
$loadingOverlay.show().appendTo($content);
},100);
if(settings.inline){
$tag(div).hide().insertBefore($(href)[0]).one(event_purge,function(){
$(this).replaceWith($loaded.children());
});
prep($(href));
}else if(settings.iframe){
prep(" ");
}else if(settings.html){
prep(settings.html);
}else if(isImage(href)){
$(photo=new Image())
.addClass(prefix+'Photo')
.error(function(){
settings.title=false;
prep($tag(div,'Error').html(settings.imgError));
})
.load(function(){
var percent;
photo.onload=null;
if(settings.scalePhotos){
setResize=function(){
photo.height-=photo.height*percent;
photo.width-=photo.width*percent;
};
if(settings.mw&&photo.width>settings.mw){
percent=(photo.width-settings.mw)/photo.width;
setResize();
}
if(settings.mh&&photo.height>settings.mh){
percent=(photo.height-settings.mh)/photo.height;
setResize();
}
}
if(settings.h){
photo.style.marginTop=Math.max(settings.h-photo.height,0)/2+'px';
}
if($related[1]&&(settings.loop||$related[index+1])){
photo.style.cursor='pointer';
photo.onclick=function(){
publicMethod.next();
};
}
if(isIE){
photo.style.msInterpolationMode='bicubic';
}
setTimeout(function(){
prep(photo);
},1);
});
setTimeout(function(){
photo.src=href;
},1);
}else if(href){
$loadingBay.load(href,settings.data,function(data,status,xhr){
prep(status==='error'?$tag(div,'Error').html(settings.xhrError):$(this).contents());
});
}
};
publicMethod.next=function(){
if(!active&&$related[1]&&(settings.loop||$related[index+1])){
index=getIndex(1);
publicMethod.load();
}
};
publicMethod.prev=function(){
if(!active&&$related[1]&&(settings.loop||index)){
index=getIndex(-1);
publicMethod.load();
}
};
publicMethod.close=function(){
if(open&&!closing){
closing=true;
open=false;
trigger(event_cleanup,settings.onCleanup);
$window.unbind('.'+prefix+' .'+event_ie6);
$overlay.fadeTo(200,0);
$box.stop().fadeTo(300,0,function(){
$box.add($overlay).css({'opacity':1,cursor:'auto'}).hide();
trigger(event_purge);
$loaded.remove();
setTimeout(function(){
closing=false;
trigger(event_closed,settings.onClosed);
},1);
});
}
};
publicMethod.remove=function(){
$([]).add($box).add($overlay).remove();
$box=null;
$('.'+boxElement)
.removeData(colorbox)
.removeClass(boxElement)
.die();
};
publicMethod.element=function(){
return $(element);
};
publicMethod.settings=defaults;
}(jQuery,document,this));


/* ../plugins-dist/mediabox/javascript/spip.mediabox.js?1407942352 */

var mediaboxInit=function(){
var options={
transition:box_settings.trans,
speed:box_settings.speed,
maxWidth:box_settings.maxW,
maxHeight:box_settings.maxH,
minWidth:box_settings.minW,
minHeight:box_settings.minH,
opacity:box_settings.opa,
slideshowSpeed:box_settings.ssSpeed,
slideshowStart:box_settings.str_ssStart,
slideshowStop:box_settings.str_ssStop,
current:box_settings.str_cur,
previous:box_settings.str_prev,
next:box_settings.str_next,
close:box_settings.str_close,
splash_url:box_settings.splash_url
};
if(box_settings.sel_g){
jQuery(box_settings.sel_g,this).not('.hasbox,#colorbox')
.attr("onclick","")
.colorbox(jQuery.extend({},options,{rel:'galerieauto',slideshow:true,slideshowAuto:false}))
.addClass("hasbox");
}
if(box_settings.tt_img){
jQuery("a[type=\'image/jpeg\'],a[type=\'image/png\'],a[type=\'image/gif\']",this).not('.hasbox')
.attr("onclick","")
.colorbox(options)
.addClass("hasbox")
;
}
if(box_settings.sel_c){
jQuery(box_settings.sel_c).not('.hasbox')
.colorbox(jQuery.extend({},options,{slideshow:true,slideshowAuto:false}))
.addClass("hasbox")
;
}
};
if(typeof(box_settings)!='undefined')
(function($){if(typeof onAjaxLoad=="function")onAjaxLoad(mediaboxInit);$(mediaboxInit);})(jQuery);
;(function($){
$.fn.mediabox=function(options){
var cbox_options={
overlayClose:true,
iframe:false,
maxWidth:box_settings.maxW,
maxHeight:box_settings.maxH,
minWidth:box_settings.minW,
minHeight:box_settings.minH,
opacity:box_settings.opa,
slideshowStart:box_settings.str_ssStart,
slideshowStop:box_settings.str_ssStop,
current:box_settings.str_cur,
previous:box_settings.str_prev,
next:box_settings.str_next,
close:box_settings.str_close,
onOpen:(options&&options.onOpen)||null,
onComplete:(options&&options.onShow)||null,
onClosed:(options&&options.onClose)||null
};
return this.colorbox($.extend(cbox_options,options));
};
$.mediaboxClose=function(){$.fn.colorbox.close();};
$.modalbox=function(href,options){$.fn.mediabox($.extend({href:href,inline:href.match(/^#/),overlayClose:true},options));};
$.modalboxload=function(url,options){$.modalbox(url,options);};
$.modalboxclose=$.mediaboxClose;
})(jQuery);


/* ../plugins-dist/porte_plume/javascript/jquery.markitup_pour_spip.js */

;(function($){
$.fn.markItUp=function(settings,extraSettings){
var options,ctrlKey,shiftKey,altKey;
ctrlKey=shiftKey=altKey=false;
options={id:'',
nameSpace:'',
root:'',
lang:'',
previewInWindow:'',
previewAutoRefresh:true,
previewPosition:'after',
previewTemplatePath:'~/templates/preview.html',
previewParser:false,
previewParserPath:'',
previewParserVar:'data',
resizeHandle:true,
beforeInsert:'',
afterInsert:'',
onEnter:{},
onShiftEnter:{},
onCtrlEnter:{},
onTab:{},
markupSet:[{}]
};
$.extend(options,settings,extraSettings);
if(!options.root){
$('script').each(function(a,tag){
miuScript=$(tag).get(0).src.match(/(.*)jquery\.markitup(\.pack)?\.js$/);
if(miuScript!==null){
options.root=miuScript[1];
}
});
}
return this.each(function(){
var $$,textarea,levels,scrollPosition,caretPosition,
clicked,hash,header,footer,previewWindow,template,iFrame,abort,
before,after;
$$=$(this);
textarea=this;
levels=[];
abort=false;
scrollPosition=caretPosition=0;
caretOffset=-1;
options.previewParserPath=localize(options.previewParserPath);
options.previewTemplatePath=localize(options.previewTemplatePath);
function localize(data,inText){
if(inText){
return data.replace(/("|')~\//g,"$1"+options.root);
}
return data.replace(/^~\//,options.root);
}
function init(){
id='';nameSpace='';
if(options.id){
id='id="'+options.id+'"';
}else if($$.attr("id")){
id='id="markItUp'+($$.attr("id").substr(0,1).toUpperCase())+($$.attr("id").substr(1))+'"';
}
if(options.nameSpace){
nameSpace='class="'+options.nameSpace+'"';
}
currentScrollPosition=$$.scrollTop();
$$.wrap('<div '+nameSpace+'></div>');
$$.wrap('<div '+id+' class="markItUp"></div>');
$$.wrap('<div class="markItUpContainer"></div>');
$$.addClass("markItUpEditor");
$$.scrollTop(currentScrollPosition);
header=$('<div class="markItUpHeader"></div>').insertBefore($$);
$(dropMenus(options.markupSet)).appendTo(header);
$(header).find("li.markItUpDropMenu ul:empty").parent().remove();
footer=$('<div class="markItUpFooter"></div>').insertAfter($$);
if(options.resizeHandle===true&&$.browser.safari!==true){
resizeHandle=$('<div class="markItUpResizeHandle"></div>')
.insertAfter($$)
.bind("mousedown",function(e){
var h=$$.height(),y=e.clientY,mouseMove,mouseUp;
mouseMove=function(e){
$$.css("height",Math.max(20,e.clientY+h-y)+"px");
return false;
};
mouseUp=function(e){
$("html").unbind("mousemove",mouseMove).unbind("mouseup",mouseUp);
return false;
};
$("html").bind("mousemove",mouseMove).bind("mouseup",mouseUp);
});
footer.append(resizeHandle);
}
$$.keydown(keyPressed).keyup(keyPressed);
$$.bind("insertion",function(e,settings){
if(settings.target!==false){
get();
}
if(textarea===$.markItUp.focused){
markup(settings);
}
});
$$.focus(function(){
$.markItUp.focused=this;
});
}
function dropMenus(markupSet){
var ul=$('<ul></ul>'),i=0;
var lang=($$.attr('lang')||options.lang);
$('li:hover > ul',ul).css('display','block');
$.each(markupSet,function(){
var button=this,t='',title,li,j;
if((!lang||!button.lang||($.inArray(lang,button.lang)!=-1))
&&(!button.lang_not||($.inArray(lang,button.lang_not)==-1))){
title=(button.key)?(button.name||'')+' [Ctrl+'+button.key+']':(button.name||'');
key=(button.key)?'accesskey="'+button.key+'"':'';
if(button.separator){
li=$('<li class="markItUpSeparator">'+(button.separator||'')+'</li>').appendTo(ul);
}else{
i++;
for(j=levels.length-1;j>=0;j--){
t+=levels[j]+"-";
}
li=$('<li class="markItUpButton markItUpButton'+t+(i)+' '+(button.className||'')+'"><a href="" '+key+' title="'+title+'"><em>'+(button.name||'')+'</em></a></li>')
.bind("contextmenu",function(){
return false;
}).click(function(){
return false;
}).bind("focusin",function(){
$$.focus();
}).mouseup(function(){
if(button.call){
eval(button.call)();
}
setTimeout(function(){markup(button)},1);
return false;
}).hover(function(){
$('> ul',this).show();
$(document).one('click',function(){
$('ul ul',header).hide();
}
);
},function(){
$('> ul',this).hide();
}
).appendTo(ul);
if(button.dropMenu){
levels.push(i);
$(li).addClass('markItUpDropMenu').append(dropMenus(button.dropMenu));
}
}
}
});
levels.pop();
return ul;
}
function magicMarkups(string){
if(string){
string=string.toString();
string=string.replace(/\(\!\(([\s\S]*?)\)\!\)/g,
function(x,a){
var b=a.split('|!|');
if(altKey===true){
return(b[1]!==undefined)?b[1]:b[0];
}else{
return(b[1]===undefined)?"":b[0];
}
}
);
string=string.replace(/\[\!\[([\s\S]*?)\]\!\]/g,
function(x,a){
var b=a.split(':!:');
if(abort===true){
return false;
}
value=prompt(b[0],(b[1])?b[1]:'');
if(value===null){
abort=true;
}
return value;
}
);
return string;
}
return"";
}
function prepare(action){
if($.isFunction(action)){
action=action(hash);
}
return magicMarkups(action);
}
function build(string){
var openWith=prepare(clicked.openWith);
var placeHolder=prepare(clicked.placeHolder);
var replaceWith=prepare(clicked.replaceWith);
var closeWith=prepare(clicked.closeWith);
var openBlockWith=prepare(clicked.openBlockWith);
var closeBlockWith=prepare(clicked.closeBlockWith);
var multiline=clicked.multiline;
if(replaceWith!==""){
block=openWith+replaceWith+closeWith;
}else if(selection===''&&placeHolder!==''){
block=openWith+placeHolder+closeWith;
}else if(multiline===true){
string=string||selection;
var lines=selection.split(/\r?\n/),blocks=[];
for(var l=0;l<lines.length;l++){
line=lines[l];
var trailingSpaces;
if(trailingSpaces=line.match(/ *$/)){
blocks.push(openWith+line.replace(/ *$/g,'')+closeWith+trailingSpaces);
}else{
blocks.push(openWith+line+closeWith);
}
}
block=blocks.join("\n");
}else{
block=openWith+(string||selection)+closeWith;
}
block=openBlockWith+block+closeBlockWith;
return{block:block,
openWith:openWith,
replaceWith:replaceWith,
placeHolder:placeHolder,
closeWith:closeWith
};
}
function selectWord(){
selectionBeforeAfter(/\s|[.,;:!¡?¿()]/);
selectionSave();
}
function selectLine(){
selectionBeforeAfter(/\r?\n/);
selectionSave();
}
function selectionRemoveLast(pattern){
if(!pattern)pattern=/\s/;
last=selection[selection.length-1];
if(last&&last.match(pattern)){
set(caretPosition,selection.length-1);
get();
$.extend(hash,{caretPosition:caretPosition,scrollPosition:scrollPosition});
}
}
function selectionBeforeAfter(pattern){
if(!pattern)pattern=/\s/;
sautAvantIE=sautApresIE=0;
if($.browser.msie){
lenSelection=selection.length-fixIeBug(selection);
if(caretPosition){
set(caretPosition-1,2);
sautAvantIE=fixIeBug(document.selection.createRange().text);
}
set(caretPosition,2);
sautApresIE=fixIeBug(document.selection.createRange().text);
set(0,caretPosition);
before=document.selection.createRange().text;
set(caretPosition+lenSelection,textarea.value.length);
after=document.selection.createRange().text;
set(caretPosition,lenSelection);
selection=document.selection.createRange().text;
}else{
before=textarea.value.substring(0,caretPosition);
after=textarea.value.substring(caretPosition+selection.length-fixIeBug(selection));
}
before=before.split(pattern);
after=after.split(pattern);
if(sautAvantIE)before.push("");
if(sautApresIE)after.unshift("");
}
function selectionSave(){
nb_before=before?before[before.length-1].length:0;
nb_after=after?after[0].length:0;
nb=nb_before+selection.length+nb_after-fixIeBug(selection);
caretPosition=caretPosition-nb_before;
set(caretPosition,nb);
get();
$.extend(hash,{selection:selection,caretPosition:caretPosition,scrollPosition:scrollPosition});
}
function markup(button){
var len,j,n,i;
hash=clicked=button;
get();
$.extend(hash,{line:"",
root:options.root,
textarea:textarea,
selection:(selection||''),
caretPosition:caretPosition,
ctrlKey:ctrlKey,
shiftKey:shiftKey,
altKey:altKey
}
);
if(button.selectionType){
if(button.selectionType=="word"){
if(!selection){
selectWord();
}else{
selectionRemoveLast(/\s/);
}
}
if(button.selectionType=="line"){
selectLine();
}
if(button.selectionType=="return"){
if(!$.browser.msie){
selectionBeforeAfter(/\r?\n/);
before_last=before[before.length-1];
after='';
if(r=before_last.match(/^-([*#]+) ?(.*)$/)){
if(r[2]){
button.replaceWith="\n-"+r[1]+' ';
before_last='';
}else{
button.replaceWith="\n";
}
}else{
before_last='';
button.replaceWith="\n";
}
before[before.length-1]=before_last;
selectionSave();
}
}
}
prepare(options.beforeInsert);
prepare(clicked.beforeInsert);
if((ctrlKey===true&&shiftKey===true)||button.multiline===true){
prepare(clicked.beforeMultiInsert);
}
$.extend(hash,{line:1});
if((ctrlKey===true&&shiftKey===true)||button.forceMultiline===true){
lines=selection.split(/\r?\n/);
for(j=0,n=lines.length,i=0;i<n;i++){
if(n==1||$.trim(lines[i])!==''){
$.extend(hash,{line:++j,selection:lines[i]});
lines[i]=build(lines[i]).block;
}else{
lines[i]="";
}
}
string={block:lines.join('\n')};
start=caretPosition;
len=string.block.length+(($.browser.opera)?n-1:0);
}else if(ctrlKey===true){
string=build(selection);
start=caretPosition+string.openWith.length;
len=string.block.length-string.openWith.length-string.closeWith.length;
len=len-(string.block.match(/ $/)?1:0);
len-=fixIeBug(string.block);
}else if(shiftKey===true){
string=build(selection);
start=caretPosition;
len=string.block.length;
len-=fixIeBug(string.block);
}else{
string=build(selection);
start=caretPosition+string.block.length;
len=0;
start-=fixIeBug(string.block);
}
if((selection===''&&string.replaceWith==='')){
caretOffset+=fixOperaBug(string.block);
start=caretPosition+string.openWith.length;
len=string.block.length-string.openWith.length-string.closeWith.length;
caretOffset=$$.val().substring(caretPosition,$$.val().length).length;
caretOffset-=fixOperaBug($$.val().substring(0,caretPosition));
}
$.extend(hash,{caretPosition:caretPosition,scrollPosition:scrollPosition});
if(string.block!==selection&&abort===false){
insert(string.block);
set(start,len);
}else{
caretOffset=-1;
}
get();
$.extend(hash,{line:'',selection:selection});
if((ctrlKey===true&&shiftKey===true)||button.multiline===true){
prepare(clicked.afterMultiInsert);
}
prepare(clicked.afterInsert);
prepare(options.afterInsert);
if(previewWindow&&options.previewAutoRefresh){
refreshPreview();
}
shiftKey=altKey=ctrlKey=abort=false;
}
function fixOperaBug(string){
if($.browser.opera){
return string.length-string.replace(/\n*/g,'').length;
}
return 0;
}
function fixIeBug(string){
if($.browser.msie){
return string.length-string.replace(/\r*/g,'').length;
}
return 0;
}
function insert(block){
if(document.selection){
var newSelection=document.selection.createRange();
newSelection.text=block;
}else{
textarea.value=textarea.value.substring(0,caretPosition)+block+textarea.value.substring(caretPosition+selection.length,textarea.value.length);
}
}
function set(start,len){
if(textarea.createTextRange){
if($.browser.opera&&$.browser.version>=9.5&&len==0){
return false;
}
range=textarea.createTextRange();
range.collapse(true);
range.moveStart('character',start);
range.moveEnd('character',len);
range.select();
}else if(textarea.setSelectionRange){
textarea.setSelectionRange(start,start+len);
}
textarea.scrollTop=scrollPosition;
textarea.focus();
}
function get(){
textarea.focus();
scrollPosition=textarea.scrollTop;
if(document.selection){
selection=document.selection.createRange().text;
if($.browser.msie){
var range=document.selection.createRange(),rangeCopy=range.duplicate();
rangeCopy.moveToElementText(textarea);
caretPosition=-1;
while(rangeCopy.inRange(range)){
rangeCopy.moveStart('character');
caretPosition++;
}
}else{
caretPosition=textarea.selectionStart;
}
}else{
caretPosition=textarea.selectionStart;
selection=textarea.value.substring(caretPosition,textarea.selectionEnd);
}
return selection;
}
function preview(){
if(!previewWindow||previewWindow.closed){
if(options.previewInWindow){
previewWindow=window.open('','preview',options.previewInWindow);
$(window).unload(function(){
previewWindow.close();
});
}else{
iFrame=$('<iframe class="markItUpPreviewFrame"></iframe>');
if(options.previewPosition=='after'){
iFrame.insertAfter(footer);
}else{
iFrame.insertBefore(header);
}
previewWindow=iFrame[iFrame.length-1].contentWindow||frame[iFrame.length-1];
}
}else if(altKey===true){
if(iFrame){
iFrame.remove();
}else{
previewWindow.close();
}
previewWindow=iFrame=false;
}
if(!options.previewAutoRefresh){
refreshPreview();
}
if(options.previewInWindow){
previewWindow.focus();
}
}
function refreshPreview(){
renderPreview();
}
function renderPreview(){
var phtml;
if(options.previewParser&&typeof options.previewParser==='function'){
var data=options.previewParser($$.val());
writeInPreview(localize(data,1));
}else if(options.previewParserPath!==''){
$.ajax({
type:'POST',
dataType:'text',
global:false,
url:options.previewParserPath,
data:options.previewParserVar+'='+encodeURIComponent($$.val()),
success:function(data){
writeInPreview(localize(data,1));
}
});
}else{
if(!template){
$.ajax({
url:options.previewTemplatePath,
dataType:'text',
global:false,
success:function(data){
writeInPreview(localize(data,1).replace(/<!-- content -->/g,$$.val()));
}
});
}
}
return false;
}
function writeInPreview(data){
if(previewWindow.document){
try{
sp=previewWindow.document.documentElement.scrollTop
}catch(e){
sp=0;
}
previewWindow.document.open();
previewWindow.document.write(data);
previewWindow.document.close();
previewWindow.document.documentElement.scrollTop=sp;
}
}
function keyPressed(e){
shiftKey=e.shiftKey;
altKey=e.altKey;
ctrlKey=(!(e.altKey&&e.ctrlKey))?(e.ctrlKey||e.metaKey):false;
if(e.type==='keydown'){
if(ctrlKey===true){
li=$('a[accesskey="'+String.fromCharCode(e.keyCode)+'"]',header).parent('li');
if(li.length!==0){
ctrlKey=false;
setTimeout(function(){
li.triggerHandler('mouseup');
},1);
return false;
}
}
if(!$.browser.opera){
if(e.keyCode===13||e.keyCode===10){
if(ctrlKey===true){
ctrlKey=false;
markup(options.onCtrlEnter);
return options.onCtrlEnter.keepDefault;
}else if(shiftKey===true){
shiftKey=false;
markup(options.onShiftEnter);
return options.onShiftEnter.keepDefault;
}else{
markup(options.onEnter);
return options.onEnter.keepDefault;
}
}
if(e.keyCode===9){
if(shiftKey==true||ctrlKey==true||altKey==true){
return true;
}
if(caretOffset!==-1){
get();
caretOffset=$$.val().length-caretOffset;
set(caretOffset,0);
caretOffset=-1;
return false;
}else{
markup(options.onTab);
return options.onTab.keepDefault;
}
}
}
}
}
init();
});
};
$.fn.markItUpRemove=function(){
return this.each(function(){
var $$=$(this).unbind().removeClass('markItUpEditor');
$$.parent('div').parent('div.markItUp').parent('div').replaceWith($$);
}
);
};
$.markItUp=function(settings){
var options={target:false};
$.extend(options,settings);
if(options.target){
return $(options.target).each(function(){
$(this).focus();
$(this).trigger('insertion',[options]);
});
}else{
$('textarea').trigger('insertion',[options]);
}
};
})(jQuery);


/* ../plugins-dist/porte_plume/javascript/jquery.previsu_spip.js */
;(function($){
$.fn.previsu_spip=function(settings){
var options;
options={
previewParserPath:'',
previewParserVar:'data',
textEditer:'Editer',
textVoir:'Voir'
};
$.extend(options,settings);
return this.each(function(){
var $$,textarea,tabs,preview;
$$=$(this);
textarea=this;
function init(){
$$.addClass("pp_previsualisation");
tabs=$('<div class="markItUpTabs"></div>').prependTo($$.parent());
$(tabs).append(
'<a href="#previsuVoir" class="previsuVoir">'+options.textVoir+'</a>'+
'<a href="#previsuEditer" class="previsuEditer on">'+options.textEditer+'</a>'
);
preview=$('<div class="markItUpPreview"></div>').insertAfter(tabs);
preview.hide();
$('.previsuVoir').click(function(){
mark=$(this).parent().parent();
objet=mark.parents('.formulaire_spip')[0].className.match(/formulaire_editer_(\w+)/);
champ=mark.parents('li')[0].className.match(/editer_(\w+)/);
$(mark).find('.markItUpPreview').height(
$(mark).find('.markItUpHeader').height()
+$(mark).find('.markItUpEditor').height()
+$(mark).find('.markItUpFooter').height()
);
$(mark).find('.markItUpHeader').hide();
$(mark).find('.markItUpEditor').hide();
$(mark).find('.markItUpFooter').hide();
$(this).addClass('on').next().removeClass('on');
$(mark).find('.markItUpPreview').show()
.addClass('ajaxLoad')
.html(renderPreview(
$(mark).find('textarea.pp_previsualisation').val(),
champ[1].toUpperCase(),
(objet?objet[1]:''))
)
.removeClass('ajaxLoad');
$(".markItUpPreview a").attr("target","blank");
return false;
});
$('.previsuEditer').click(function(){
mark=$(this).parent().parent();
$(mark).find('.markItUpPreview').hide();
$(mark).find('.markItUpHeader').show();
$(mark).find('.markItUpEditor').show();
$(mark).find('.markItUpFooter').show();
$(this).addClass('on').prev().removeClass('on');
return false;
});
}
function renderPreview(val,champ,objet){
var phtml;
if(options.previewParserPath!==''){
$.ajax({
type:'POST',
async:false,
url:options.previewParserPath,
data:'champ='+champ
+'&objet='+objet
+'&'+options.previewParserVar+'='+encodeURIComponent(val),
success:function(data){
phtml=data;
}
});
}
return phtml;
}
init();
});
};
})(jQuery);


/* page=porte_plume_start.js(lang=fr) */
barre_outils_edition={"nameSpace":"edition","previewAutoRefresh":false,"onEnter":{"keepDefault":false,"selectionType":"return","replaceWith":"\n"}
,"onShiftEnter":{"keepDefault":false,"replaceWith":"\n_ "}
,"onCtrlEnter":{"keepDefault":false,"replaceWith":"\n\n"}
,"markupSet":[{"name":"Transformer en {{{intertitre}}}","key":"H","className":"outil_header1","openWith":"\n{{{","closeWith":"}}}\n","selectionType":"line"}
,{"name":"Mettre en {{gras}}","key":"B","className":"outil_bold","replaceWith":function(h){return espace_si_accolade(h,'{{','}}');},"selectionType":"word"}
,{"name":"Mettre en {italique}","key":"I","className":"outil_italic","replaceWith":function(h){return espace_si_accolade(h,'{','}');},"selectionType":"word"}
,{"name":"Mettre en liste","className":"outil_liste_ul separateur_avant","replaceWith":function(h){return outil_liste(h,'*');},"selectionType":"line","forceMultiline":true,"dropMenu":[{"id":"liste_ol","name":"Mettre en liste numérotée","className":"outil_liste_ol","replaceWith":function(h){return outil_liste(h,'#');},"display":true,"selectionType":"line","forceMultiline":true}
,{"id":"desindenter","name":"Désindenter une liste","className":"outil_desindenter","replaceWith":function(h){return outil_desindenter(h);},"display":true,"selectionType":"line","forceMultiline":true}
,{"id":"indenter","name":"Indenter une liste","className":"outil_indenter","replaceWith":function(h){return outil_indenter(h);},"display":true,"selectionType":"line","forceMultiline":true}
]
}
,{"name":"Transformer en [lien hypertexte->http://...]","key":"L","className":"outil_link separateur separateur_apres sepLink","openWith":"[","closeWith":"->[![Veuillez indiquer l’adresse de votre lien (vous pouvez indiquer une adresse Internet sous la forme http://www.monsite.com, une adresse courriel, ou simplement indiquer le numéro d’un article de ce site.]!]]"}
,{"name":"Transformer en [[Note de bas de page]]","className":"outil_notes separateur_avant","openWith":"[[","closeWith":"]]","selectionType":"word"}
,{"name":"<quote>Citer un message</quote>","key":"Q","className":"outil_quote separateur separateur_apres sepGuillemets","openWith":"\n<quote>","closeWith":"</quote>\n","selectionType":"word","dropMenu":[{"id":"barre_poesie","name":"Mettre en forme comme une <poesie>poésie</poesie>","className":"outil_poesie","openWith":"\n<poesie>","closeWith":"</poesie>\n","display":true,"selectionType":"line"}
]
}
,{"name":"Entourer de « guillemets »","className":"outil_guillemets","openWith":"«","closeWith":"»","lang":["fr","eo","cpf","ar","es"]
,"selectionType":"word","dropMenu":[{"id":"guillemets_simples","name":"Entourer de “guillemets de second niveau”","className":"outil_guillemets_simples","openWith":"“","closeWith":"”","display":true,"lang":["fr","eo","cpf","ar","es"]
,"selectionType":"word"}
]
}
,{"name":"Entourer de « guillemets »","className":"outil_guillemets_de","openWith":"„","closeWith":"“","lang":["bg","de","pl","hr","src"]
,"selectionType":"word","dropMenu":[{"id":"guillemets_de_simples","name":"Entourer de “guillemets de second niveau”","className":"outil_guillemets_de_simples","openWith":"&sbquo;","closeWith":"‘","display":true,"lang":["bg","de","pl","hr","src"]
,"selectionType":"word"}
]
}
,{"name":"Entourer de « guillemets »","className":"outil_guillemets_simples separateur_avant","openWith":"“","closeWith":"”","lang_not":["fr","eo","cpf","ar","es","bg","de","pl","hr","src"]
,"selectionType":"word","dropMenu":[{"id":"guillemets_autres_simples","name":"Entourer de “guillemets de second niveau”","className":"outil_guillemets_uniques","openWith":"‘","closeWith":"’","display":true,"lang_not":["fr","eo","cpf","ar","es","bg","de","pl","hr","src"]
,"selectionType":"word"}
]
}
,{"name":"Insérer des caractères spécifiques","className":"outil_caracteres separateur separateur_apres sepCaracteres separateur_avant","dropMenu":[{"id":"A_grave","name":"Insérer un À","className":"outil_a_maj_grave","replaceWith":"À","display":true,"lang":["fr","eo","cpf"]
}
,{"id":"E_aigu","name":"Insérer un É","className":"outil_e_maj_aigu","replaceWith":"É","display":true,"lang":["fr","eo","cpf"]
}
,{"id":"E_grave","name":"Insérer un È","className":"outil_e_maj_grave","replaceWith":"È","display":true,"lang":["fr","eo","cpf"]
}
,{"id":"aelig","name":"Insérer un æ","className":"outil_aelig","replaceWith":"æ","display":true,"lang":["fr","eo","cpf"]
}
,{"id":"AElig","name":"Insérer un Æ","className":"outil_aelig_maj","replaceWith":"Æ","display":true,"lang":["fr","eo","cpf"]
}
,{"id":"oe","name":"Insérer un œ","className":"outil_oe","replaceWith":"œ","display":true,"lang":["fr"]
}
,{"id":"OE","name":"Insérer un Œ","className":"outil_oe_maj","replaceWith":"Œ","display":true,"lang":["fr"]
}
,{"id":"Ccedil","name":"Insérer un Ç","className":"outil_ccedil_maj","replaceWith":"Ç","display":true,"lang":["fr","eo","cpf"]
}
,{"id":"uppercase","name":"Passer en majuscules","className":"outil_uppercase","replaceWith":function(markitup){return markitup.selection.toUpperCase()},"display":true,"lang":["fr","en"]
}
,{"id":"lowercase","name":"Passer en minuscules","className":"outil_lowercase","replaceWith":function(markitup){return markitup.selection.toLowerCase()},"display":true,"lang":["fr","en"]
}
]
}
,{"name":"Insérer un code informatique (code)","className":"outil_code separateur separateur_apres sepCode","openWith":"<code>","closeWith":"</code>","dropMenu":[{"id":"cadre","name":"Insérer un code préformaté (cadre)","className":"outil_cadre","openWith":"<cadre>\n","closeWith":"\n</cadre>","display":true}
]
}
]
}
function outil_liste(h,c){
if((s=h.selection)&&(r=s.match(/^-([*#]+) (.*)$/))){
r[1]=r[1].replace(/[#*]/g,c);
s='-'+r[1]+' '+r[2];
}else{
s='-'+c+' '+s;
}
return s;
}
function outil_indenter(h){
if(s=h.selection){
if(s.substr(0,2)=='-*'){
s='-**'+s.substr(2);
}else if(s.substr(0,2)=='-#'){
s='-##'+s.substr(2);
}else{
s='-* '+s;
}
}
return s;
}
function outil_desindenter(h){
if(s=h.selection){
if(s.substr(0,3)=='-**'){
s='-*'+s.substr(3);
}else if(s.substr(0,3)=='-* '){
s=s.substr(3);
}else if(s.substr(0,3)=='-##'){
s='-#'+s.substr(3);
}else if(s.substr(0,3)=='-# '){
s=s.substr(3);
}
}
return s;
}
function espace_si_accolade(h,openWith,closeWith){
if(s=h.selection){
if(s.charAt(0)=='{'){
return openWith+' '+s+' '+closeWith;
}
else if(c=h.textarea.selectionStart){
if(h.textarea.value.charAt(c-1)=='{'){
return' '+openWith+s+closeWith+' ';
}
}
}
return openWith+s+closeWith;
}
barre_outils_forum={"nameSpace":"forum","previewAutoRefresh":false,"onEnter":{"keepDefault":false,"selectionType":"return","replaceWith":"\n"}
,"onShiftEnter":{"keepDefault":false,"replaceWith":"\n_ "}
,"onCtrlEnter":{"keepDefault":false,"replaceWith":"\n\n"}
,"markupSet":[{"name":"Mettre en {{gras}}","key":"B","className":"outil_bold","replaceWith":function(h){return espace_si_accolade(h,'{{','}}');},"selectionType":"word"}
,{"name":"Mettre en {italique}","key":"I","className":"outil_italic separateur_avant","replaceWith":function(h){return espace_si_accolade(h,'{','}');},"selectionType":"word"}
,{"name":"Transformer en [lien hypertexte->http://...]","key":"L","className":"outil_link separateur separateur_apres sepLink separateur_avant","openWith":"[","closeWith":"->[![Veuillez indiquer l’adresse de votre lien (vous pouvez indiquer une adresse Internet sous la forme http://www.monsite.com, une adresse courriel, ou simplement indiquer le numéro d’un article de ce site.]!]]"}
,{"name":"<quote>Citer un message</quote>","key":"Q","className":"outil_quote separateur separateur_apres sepGuillemets","openWith":"\n<quote>","closeWith":"</quote>\n","selectionType":"word"}
,{"name":"Entourer de « guillemets »","className":"outil_guillemets","openWith":"«","closeWith":"»","lang":["fr","eo","cpf","ar","es"]
,"selectionType":"word","dropMenu":[{"id":"guillemets_simples","name":"Entourer de “guillemets de second niveau”","className":"outil_guillemets_simples","openWith":"“","closeWith":"”","display":true,"lang":["fr","eo","cpf","ar","es"]
,"selectionType":"word"}
]
}
,{"name":"Entourer de « guillemets »","className":"outil_guillemets_de","openWith":"„","closeWith":"“","lang":["bg","de","pl","hr","src"]
,"selectionType":"word","dropMenu":[{"id":"guillemets_de_simples","name":"Entourer de “guillemets de second niveau”","className":"outil_guillemets_de_simples","openWith":"&sbquo;","closeWith":"‘","display":true,"lang":["bg","de","pl","hr","src"]
,"selectionType":"word"}
]
}
,{"name":"Entourer de « guillemets »","className":"outil_guillemets_simples separateur_avant","openWith":"“","closeWith":"”","lang_not":["fr","eo","cpf","ar","es","bg","de","pl","hr","src"]
,"selectionType":"word","dropMenu":[{"id":"guillemets_autres_simples","name":"Entourer de “guillemets de second niveau”","className":"outil_guillemets_uniques","openWith":"‘","closeWith":"’","display":true,"lang_not":["fr","eo","cpf","ar","es","bg","de","pl","hr","src"]
,"selectionType":"word"}
]
}
]
}
function outil_liste(h,c){
if((s=h.selection)&&(r=s.match(/^-([*#]+) (.*)$/))){
r[1]=r[1].replace(/[#*]/g,c);
s='-'+r[1]+' '+r[2];
}else{
s='-'+c+' '+s;
}
return s;
}
function outil_indenter(h){
if(s=h.selection){
if(s.substr(0,2)=='-*'){
s='-**'+s.substr(2);
}else if(s.substr(0,2)=='-#'){
s='-##'+s.substr(2);
}else{
s='-* '+s;
}
}
return s;
}
function outil_desindenter(h){
if(s=h.selection){
if(s.substr(0,3)=='-**'){
s='-*'+s.substr(3);
}else if(s.substr(0,3)=='-* '){
s=s.substr(3);
}else if(s.substr(0,3)=='-##'){
s='-#'+s.substr(3);
}else if(s.substr(0,3)=='-# '){
s=s.substr(3);
}
}
return s;
}
function espace_si_accolade(h,openWith,closeWith){
if(s=h.selection){
if(s.charAt(0)=='{'){
return openWith+' '+s+' '+closeWith;
}
else if(c=h.textarea.selectionStart){
if(h.textarea.value.charAt(c-1)=='{'){
return' '+openWith+s+closeWith+' ';
}
}
}
return openWith+s+closeWith;
}
;(function($){
$.fn.barre_outils=function(nom,settings){
options={
lang:'fr'
};
$.extend(options,settings);
return $(this)
.not('.markItUpEditor, .no_barre')
.markItUp(eval('barre_outils_'+nom),{lang:options.lang})
.parent().find('.markItUpButton a').attr('tabindex',-1)
.end();
};
$.fn.barre_previsualisation=function(settings){
options={
previewParserPath:"index.php?action=porte_plume_previsu",
textEditer:"Éditer",
textVoir:"Voir"
};
$.extend(options,settings);
return $(this)
.not('.pp_previsualisation, .no_previsualisation')
.previsu_spip(options)
.parent().find('.markItUpTabs a').attr('tabindex',-1)
.end();
};
$(window).load(function(){
function barrebouilles(){
$('.formulaire_spip textarea.inserer_barre_forum').barre_outils('forum');
$('.formulaire_spip textarea.inserer_barre_edition').barre_outils('edition');
$('.formulaire_spip textarea.inserer_previsualisation').barre_previsualisation();
$('textarea.textarea_forum').barre_outils('forum');
$('.formulaire_forum textarea[name=texte]').barre_outils('forum');
$('.formulaire_spip textarea[name=texte]')
.barre_outils('edition').end()
.barre_previsualisation();
}
barrebouilles();
onAjaxLoad(barrebouilles);
});
})(jQuery);


/* ../plugins-dist/porte_plume/javascript/porte_plume_forcer_hauteur.js */
function barre_forcer_hauteur(){
jQuery(".markItUpEditor").each(function(){
var hauteur_min=jQuery(this).height();
var hauteur_max=parseInt(jQuery(window).height())-200;
var hauteur=hauteur_min;
var signes=jQuery(this).val().length;
if(signes){
var hauteur_signes=Math.round(signes/4)+50;
if(hauteur_signes>hauteur_min&&hauteur_signes<hauteur_max)
hauteur=hauteur_signes;
else
if(hauteur_signes>hauteur_max)
hauteur=hauteur_max;
jQuery(this).height(hauteur);
}
});
}
jQuery(window).bind("load",function(){
barre_forcer_hauteur();
});


