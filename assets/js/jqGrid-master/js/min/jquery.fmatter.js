!function(e){"use strict";"function"==typeof define&&define.amd?define(["jquery","./grid.base"],function(t){return e(t)}):"object"==typeof module&&module.exports?module.exports=function(t,i){return t||(t=window),void 0===i&&(i="undefined"!=typeof window?require("jquery"):require("jquery")(t)),require("./grid.base"),e(i),i}:e(jQuery)}(function(e){"use strict";e.jgrid=e.jgrid||{};var t=e.jgrid,i=t.getMethod("getGridRes"),r=e.fn.jqGrid;e.fmatter=e.fmatter||{};var n=e.fmatter,o=function(e,t){var i=e.formatoptions||{};return i.hasOwnProperty(t)?i[t]:(e.editoptions||{})[t]},a=function(e){return String(e).replace(/\'/g,"&#39;")},l=function(e){var i,n,l=e.colModel||e.cm,s=!1!==l.title?" title='"+a(e.colName||l.name)+"'":"",c=function(e){return o(l,e)},u=c("checkedClass"),d=c("uncheckedClass"),f=c("value"),m="string"==typeof f?f.split(":")[0]||"Yes":"Yes",p="string"==typeof f?f.split(":")[1]||"No":"No",h=function(e){return"<i class='"+a(e)+"'"+s+"></i>"},g=c("disabled");return void 0===g&&(g=t.formatter.checkbox.disabled),!0===g&&r.isInCommonIconClass.call(this,"fa")?(i=h(u=u||"fa fa-check-square-o fa-lg"),n=h(d||"fa fa-square-o fa-lg")):!0===g&&r.isInCommonIconClass.call(this,"glyphicon")?(i=h(u=u||"glyphicon glyphicon-check"),n=h(d||"glyphicon glyphicon-unchecked")):(u="",i="<input type='checkbox' checked='checked'"+(s+=!0===g?" disabled='disabled'":"")+" />",n="<input type='checkbox'"+s+" />"),{checkedClasses:u,checked:i,unchecked:n,yes:m,no:p}},s={1:1,x:1,true:1,yes:1,y:1,on:1},c={0:1,false:1,no:1,n:1,off:1};e.extend(!0,t,{formatter:{date:{parseRe:/[#%\\\/:_;.,\t\s\-]/,masks:{ISO8601Long:"Y-m-d H:i:s",ISO8601Short:"Y-m-d",SortableDateTime:"Y-m-d\\TH:i:s",UniversalSortableDateTime:"Y-m-d H:i:sO"},reformatAfterEdit:!0,userLocalTime:!1},baseLinkUrl:"",showAction:"",target:"",checkbox:{disabled:!0,defaultValue:!1},idName:"id"},cmTemplate:{integerStr:{formatter:"integer",align:"right",sorttype:"integer",searchoptions:{sopt:["eq","ne","lt","le","gt","ge"]}},integer:{formatter:"integer",align:"right",sorttype:"integer",convertOnSave:function(e){var t=e.newValue;return isNaN(t)?t:parseInt(t,10)},searchoptions:{sopt:["eq","ne","lt","le","gt","ge"]}},numberStr:{formatter:"number",align:"right",sorttype:"number",searchoptions:{sopt:["eq","ne","lt","le","gt","ge"]}},number:{formatter:"number",align:"right",sorttype:"number",convertOnSave:function(e){var t=e.newValue;return isNaN(t)?t:parseFloat(t)},searchoptions:{sopt:["eq","ne","lt","le","gt","ge"]}},booleanCheckbox:{align:"center",formatter:"checkbox",sorttype:"boolean",edittype:"checkbox",editoptions:{value:"true:false",defaultValue:"false"},convertOnSave:function(e){var t=e.newValue,i=l.call(this,e),r=String(t).toLowerCase();return s[r]||r===i.yes.toLowerCase()?t=!0:(c[r]||r===i.no.toLowerCase())&&(t=!1),t},stype:"checkbox",searchoptions:{sopt:["eq"],value:"true:false"}},actions:function(){return{formatter:"actions",width:(null!=this.p&&(r.isInCommonIconClass.call(this,"fa")||r.isInCommonIconClass.call(this,"glyphicon"))?e(this).jqGrid("isBootstrapGuiStyle")?45:39:40)+(t.cellWidth()?5:0),align:"center",label:"",autoResizable:!1,frozen:!0,fixed:!0,hidedlg:!0,resizable:!1,sortable:!1,search:!1,editable:!1,viewable:!1}}}}),t.cmTemplate.booleanCheckboxFa=t.cmTemplate.booleanCheckbox,e.extend(n,{isObject:function(t){return t&&("object"==typeof t||e.isFunction(t))||!1},isNumber:function(e){return"number"==typeof e&&isFinite(e)},isValue:function(e){return this.isObject(e)||"string"==typeof e||this.isNumber(e)||"boolean"==typeof e},isEmpty:function(t){return("string"==typeof t||!this.isValue(t))&&(!this.isValue(t)||""===(t=e.trim(t).replace(/&nbsp;/gi,"").replace(/&#160;/gi,"")))},NumberFormat:function(e,t){var i=n.isNumber;if(i(e)||(e*=1),i(e)){var r,o=e<0,a=String(e),l=t.decimalSeparator||".";if(i(t.decimalPlaces)){var s=t.decimalPlaces,c=Math.pow(10,s);if(r=(a=String(Math.round(e*c)/c)).lastIndexOf("."),s>0)for(r<0?r=(a+=l).length-1:"."!==l&&(a=a.replace(".",l));a.length-1-r<s;)a+="0"}if(t.thousandsSeparator){var u=t.thousandsSeparator;r=(r=a.lastIndexOf(l))>-1?r:a.length;var d,f=void 0===t.decimalSeparator?"":a.substring(r),m=-1;for(d=r;d>0;d--)++m%3==0&&d!==r&&(!o||d>1)&&(f=u+f),f=a.charAt(d-1)+f;a=f}return a}return e}});var u=function(t,r,n,o,a){var l=r;n=e.extend({},i.call(e(this),"formatter"),n);try{l=e.fn.fmatter[t].call(this,r,n,o,a)}catch(e){}return l};e.fn.fmatter=u,u.getCellBuilder=function(t,r,n){var o=null!=e.fn.fmatter[t]?e.fn.fmatter[t].getCellBuilder:null;return e.isFunction(o)?o.call(this,e.extend({},i.call(e(this),"formatter"),r),n):null};var d=u.defaultFormat=function(e,t){return n.isValue(e)&&""!==e?e:t.defaultValue||"&#160;"},f=function(e,t,i){if(void 0===e||n.isEmpty(e)){var r=o(i,"defaultValue");void 0===r&&(r=t.no),e=r}return e=String(e).toLowerCase(),s[e]||e===t.yes.toLowerCase()?t.checked:t.unchecked};u.email=function(e,t){return n.isEmpty(e)?d(e,t):"<a href='mailto:"+a(e)+"'>"+e+"</a>"},(u.checkbox=function(e,t){var i=l.call(this,t);return f(e,i,t.colModel)}).getCellBuilder=function(e){var t,i=e.colModel;return e.colName=e.colName||this.p.colNames[e.pos],t=l.call(this,e),function(e){return f(e,t,i)}},u.checkbox.unformat=function(i,r,n){var o=l.call(this,r),a=e(n);return(o.checkedClasses?t.hasAllClasses(a.children("i"),o.checkedClasses):a.children("input").is(":checked"))?o.yes:o.no},(u.checkboxFontAwesome4=u.checkbox).getCellBuilder=u.checkbox.getCellBuilder,u.checkboxFontAwesome4.unformat=u.checkbox.unformat,u.link=function(t,i){var r=i.colModel,o="",l={target:i.target};return null!=r&&(l=e.extend({},l,r.formatoptions||{})),l.target&&(o="target="+l.target),n.isEmpty(t)?d(t,l):"<a "+o+" href='"+a(t)+"'>"+t+"</a>"},(u.showlink=function(t,i,r){var o,l,s,c=this,u=i.colModel,f={baseLinkUrl:i.baseLinkUrl,showAction:i.showAction,addParam:i.addParam||"",target:i.target,idName:i.idName,hrefDefaultValue:"#"},m="",p=function(n){return e.isFunction(n)?n.call(c,{cellValue:t,rowid:i.rowId,rowData:r,options:f}):n||""};return null!=u&&(f=e.extend({},f,u.formatoptions||{})),f.target&&(m="target="+p(f.target)),o=p(f.baseLinkUrl)+p(f.showAction),l=f.idName?encodeURIComponent(p(f.idName))+"="+encodeURIComponent(p(f.rowId)||i.rowId):"","object"==typeof(s=p(f.addParam))&&null!==s&&(s=(""!==l?"&":"")+e.param(s)),""===(o+=l||s?"?"+l+s:"")&&(o=p(f.hrefDefaultValue)),"string"==typeof t||n.isNumber(t)||e.isFunction(f.cellValue)?"<a "+m+" href='"+a(o)+"'>"+(e.isFunction(f.cellValue)?p(f.cellValue):t)+"</a>":d(t,f)}).getCellBuilder=function(t){var i={baseLinkUrl:t.baseLinkUrl,showAction:t.showAction,addParam:t.addParam||"",target:t.target,idName:t.idName,hrefDefaultValue:"#"},r=t.colModel;return null!=r&&(i=e.extend({},i,r.formatoptions||{})),function(t,r,o){var l,s,c,u=this,f=r.rowId,m="",p=function(r){return e.isFunction(r)?r.call(u,{cellValue:t,rowid:f,rowData:o,options:i}):r||""};return i.target&&(m="target="+p(i.target)),l=p(i.baseLinkUrl)+p(i.showAction),s=i.idName?encodeURIComponent(p(i.idName))+"="+encodeURIComponent(p(f)||r.rowId):"","object"==typeof(c=p(i.addParam))&&null!==c&&(c=(""!==s?"&":"")+e.param(c)),""===(l+=s||c?"?"+s+c:"")&&(l=p(i.hrefDefaultValue)),"string"==typeof t||n.isNumber(t)||e.isFunction(i.cellValue)?"<a "+m+" href='"+a(l)+"'>"+(e.isFunction(i.cellValue)?p(i.cellValue):t)+"</a>":d(t,i)}},u.showlink.pageFinalization=function(t){var i,r,n,o=e(this),a=this.p,l=a.colModel[t],s=a.autoResizing.wrapperClassName,c=this.rows,u=c.length,d=function(t){var i=e(this).closest("tr.jqgrow>td"),r=i.parent(),n=i[0].cellIndex,l=a.colModel[n];if(r.length>0)return l.formatoptions.onClick.call(o[0],{iCol:n,iRow:r[0].rowIndex,rowid:r.attr("id"),cm:l,cmName:l.name,cellValue:e(this).text(),a:this,event:t})};if(null!=l.formatoptions&&e.isFunction(l.formatoptions.onClick))for(i=0;i<u;i++)r=c[i],e(r).hasClass("jqgrow")&&(n=r.cells[t],l.autoResizable&&null!=n&&e(n.firstChild).hasClass(s)&&(n=n.firstChild),null!=n&&e(n.firstChild).on("click",d))};var m=function(e,t){return e=t.prefix?t.prefix+e:e,t.suffix?e+t.suffix:e},p=function(t,i,r){var o=i.colModel,a=e.extend({},i[r]);return null!=o&&(a=e.extend({},a,o.formatoptions||{})),n.isEmpty(t)?m(a.defaultValue,a):m(n.NumberFormat(t,a),a)};u.integer=function(e,t){return p(e,t,"integer")},u.number=function(e,t){return p(e,t,"number")},u.currency=function(e,t){return p(e,t,"currency")};var h=function(t,i){var r=t.colModel,o=e.extend({},t[i]);null!=r&&(o=e.extend({},o,r.formatoptions||{}));var a=n.NumberFormat,l=o.defaultValue?m(o.defaultValue,o):"";return function(e){return n.isEmpty(e)?l:m(a(e,o),o)}};u.integer.getCellBuilder=function(e){return h(e,"integer")},u.number.getCellBuilder=function(e){return h(e,"number")},u.currency.getCellBuilder=function(e){return h(e,"currency")},(u.date=function(i,r,o,a){var l=r.colModel,s=e.extend({},r.date);return null!=l&&(s=e.extend({},s,l.formatoptions||{})),s.reformatAfterEdit||"edit"!==a?n.isEmpty(i)?d(i,s):t.parseDate.call(this,s.srcformat,i,s.newformat,s):d(i,s)}).getCellBuilder=function(i,r){var o=e.extend({},i.date);null!=i.colModel&&(o=e.extend({},o,i.colModel.formatoptions||{}));var a=t.parseDate,l=o.srcformat,s=o.newformat;return o.reformatAfterEdit||"edit"!==r?function(e){return n.isEmpty(e)?d(e,o):a.call(this,l,e,s,o)}:function(e){return d(e,o)}},(u.select=function(t,i){var r,o=[],a=i.colModel,l=e.extend({},a.editoptions||{},a.formatoptions||{}),s="function"==typeof l.value?l.value():l.value,c=l.separator||":",u=l.delimiter||";";if(s){var f,m=!0===l.multiple,p=[],h=function(e,t){if(t>0)return e};if(m&&(p=e.map(String(t).split(","),function(t){return e.trim(t)})),"string"==typeof s){var g,v,b=s.split(u);for(g=0;g<b.length;g++)if((f=b[g].split(c)).length>2&&(f[1]=e.map(f,h).join(c)),v=e.trim(f[0]),l.defaultValue===v&&(r=f[1]),m)e.inArray(v,p)>-1&&o.push(f[1]);else if(v===e.trim(t)){o=[f[1]];break}}else n.isObject(s)&&(r=s[l.defaultValue],o=m?e.map(p,function(e){return s[e]}):[void 0===s[t]?"":s[t]])}return""!==(t=o.join(", "))?t:void 0!==l.defaultValue?r:d(t,l)}).getCellBuilder=function(t){var i,r,o,a,l=t.colModel,s=u.defaultFormat,c=e.extend({},l.editoptions||{},l.formatoptions||{}),d="function"==typeof c.value?c.value():c.value,f=c.separator||":",m=c.delimiter||";",p=void 0!==c.defaultValue,h=!0===c.multiple,g={},v=function(e,t){if(t>0)return e};if("string"==typeof d)for(a=(o=d.split(m)).length-1;a>=0;a--)(r=o[a].split(f)).length>2&&(r[1]=e.map(r,v).join(f)),g[e.trim(r[0])]=r[1];else{if(!n.isObject(d))return function(e){return e?String(e):s(e,c)};g=d}return p&&(i=g[c.defaultValue]),h?function(t){var r,n=[],o=e.map(String(t).split(","),function(t){return e.trim(t)});for(r=0;r<o.length;r++)t=o[r],g.hasOwnProperty(t)&&n.push(g[t]);return""!==(t=n.join(", "))?t:p?i:s(t,c)}:function(e){var t=g[String(e)];return""!==t&&void 0!==t?t:p?i:s(e,c)}},u.rowactions=function(i,r){var n,o,a,l,s=e(this).closest("tr.jqgrow>td"),c=s.parent(),u=c.attr("id"),d=e(this).closest("table.ui-jqgrid-btable").attr("id").replace(/_frozen([^_]*)$/,"$1"),f=e("#"+t.jqID(d)),m=f[0],p=m.p,h=t.getRelativeRect.call(m,c).top,g=p.colModel[s[0].cellIndex],v=e.extend(!0,{extraparam:{}},t.actionsNav||{},p.actionsNavOptions||{},g.formatoptions||{});switch(void 0!==p.editOptions&&(v.editOptions=e.extend(!0,v.editOptions||{},p.editOptions)),void 0!==p.delOptions&&(v.delOptions=p.delOptions),c.hasClass("jqgrid-new-row")&&(v.extraparam[p.prmNames.oper]=p.prmNames.addoper),l={keys:v.keys,oneditfunc:v.onEdit,successfunc:v.onSuccess,url:v.url,extraparam:v.extraparam,aftersavefunc:v.afterSave,errorfunc:v.onError,afterrestorefunc:v.afterRestore,restoreAfterError:v.restoreAfterError,mtype:v.mtype},!p.multiselect&&u!==p.selrow||p.multiselect&&e.inArray(u,p.selarrrow)<0?f.jqGrid("setSelection",u,!0,i):t.fullBoolFeedback.call(m,"onSelectRow","jqGridSelectRow",u,!0,i),r){case"edit":f.jqGrid("editRow",u,l);break;case"save":f.jqGrid("saveRow",u,l);break;case"cancel":f.jqGrid("restoreRow",u,v.afterRestore);break;case"del":v.delOptions=v.delOptions||{},void 0===v.delOptions.top&&(v.delOptions.top=h),f.jqGrid("delGridRow",u,v.delOptions);break;case"formedit":v.editOptions=v.editOptions||{},void 0===v.editOptions.top&&(v.editOptions.top=h,v.editOptions.recreateForm=!0),f.jqGrid("editGridRow",u,v.editOptions);break;default:if(null!=v.custom&&v.custom.length>0)for(o=v.custom.length,n=0;n<o;n++)(a=v.custom[n]).action===r&&e.isFunction(a.onClick)&&a.onClick.call(m,{rowid:u,event:i,action:r,options:a})}return i.stopPropagation&&i.stopPropagation(),!1},(u.actions=function(r,o,l,s){var c,u,d,f=o.rowId,m="",p=e(this),h={},g=i.call(p,"edit")||{},v=e.extend({editbutton:!0,delbutton:!0,editformbutton:!1,commonIconClass:"ui-icon",editicon:"ui-icon-pencil",delicon:"ui-icon-trash",saveicon:"ui-icon-disk",cancelicon:"ui-icon-cancel",savetitle:g.bSubmit||"",canceltitle:g.bCancel||""},i.call(p,"nav")||{},t.nav||{},this.p.navOptions||{},i.call(p,"actionsNav")||{},t.actionsNav||{},this.p.actionsNavOptions||{},(o.colModel||{}).formatoptions||{}),b=[{action:"edit",actionName:"formedit",display:v.editformbutton},{action:"edit",display:!v.editformbutton&&v.editbutton},{action:"del",idPrefix:"Delete",display:v.delbutton},{action:"save",display:v.editformbutton||v.editbutton,hidden:!0},{action:"cancel",display:v.editformbutton||v.editbutton,hidden:!0}],y=function(e){var i=e.action,r=e.actionName||i,n=void 0!==e.idPrefix?e.idPrefix:i.charAt(0).toUpperCase()+i.substring(1);return"<div title='"+a(v[i+"title"])+(e.hidden?"' style='display:none;":"")+"' class='"+a(p.jqGrid("getGuiStyles","actionsButton","ui-pg-div ui-inline-"+i))+"' "+(null!==n?"id='j"+a(n+"Button_"+f):"")+"' data-jqactionname=\""+r+'" '+(e.noHovering?"":'\' data-jqhovering="1" ')+"><span class='"+a((o=i,t.mergeCssClasses(v.commonIconClass,v[o+"icon"])))+"'></span></div>";var o},w=null!=v.custom?v.custom.length-1:-1;if(void 0===f||n.isEmpty(f))return"";if(e.isFunction(v.isDisplayButtons))try{h=v.isDisplayButtons.call(this,v,l,s)||{}}catch(e){}for(;w>=0;)b["first"===(d=v.custom[w--]).position?"unshift":"push"](d);for(c=0,w=b.length;c<w;c++)!1!==(u=e.extend({},b[c],h[b[c].action]||{})).display&&(m+=y(u));return"<div class='"+a(p.jqGrid("getGuiStyles","actionsDiv","ui-jqgrid-actions"))+"'>"+m+"</div>"}).pageFinalization=function(t){var i,r,n,o,a=e(this),l=this.p,s=l.colModel[t],c=l.autoResizing.wrapperClassName,d=a.jqGrid("getGuiStyles","states.hover"),f=this.rows,m=f.length,p=(o=s.name,function(t,i){var r,n,s=0,c=l.colModel,u=c.length,d=l.iColByName[o];for(n=0;n<u&&!0===c[n].frozen;n++)s=n;null!=i&&null!=i.cells&&(r=e(i.cells[d]).children(".ui-jqgrid-actions"),c[d].frozen&&l.frozenColumns&&d<=s&&(r=r.add(e(a[0].grid.fbRows[i.rowIndex].cells[d]).children(".ui-jqgrid-actions"))),t?(r.find(">.ui-inline-edit,>.ui-inline-del").show(),r.find(">.ui-inline-save,>.ui-inline-cancel").hide()):(r.find(">.ui-inline-edit,>.ui-inline-del").hide(),r.find(">.ui-inline-save,>.ui-inline-cancel").show()))}),h=function(e,t){var i=a.jqGrid("getGridRowById",t);return p(!0,i),!1},g=function(e,t){var i=a.jqGrid("getGridRowById",t);return p(!1,i),!1},v=function(t){1===e(t.target).closest("div.ui-pg-div").data("jqhovering")&&e(this).addClass(d)},b=function(t){1===e(t.target).closest("div.ui-pg-div").data("jqhovering")&&e(this).removeClass(d)},y=function(t){return u.rowactions.call(this,t,e(t.target).closest("div.ui-pg-div").data("jqactionname"))},w=function(t,i){i&&null!=t&&e(t.firstChild).hasClass(c)&&(t=t.firstChild),null!=t&&(e(t.firstChild).on("click",y),e(t.firstChild).children("div.ui-pg-div").on("mouseover",v).on("mouseout",b))},C=(n=s.name,function(e,t){var i=l.iColByName[n];w(t.tr.cells[i],l.colModel[i].autoResizable)});for(null!=s.formatoptions&&s.formatoptions.editformbutton||(a.off("jqGridInlineAfterRestoreRow.jqGridFormatter jqGridInlineAfterSaveRow.jqGridFormatter",h),a.on("jqGridInlineAfterRestoreRow.jqGridFormatter jqGridInlineAfterSaveRow.jqGridFormatter",h),a.off("jqGridInlineEditRow.jqGridFormatter",g),a.on("jqGridInlineEditRow.jqGridFormatter",g),a.off("jqGridAfterAddRow.jqGridFormatter",C),a.on("jqGridAfterAddRow.jqGridFormatter",C)),i=0;i<m;i++)r=f[i],e(r).hasClass("jqgrow")&&w(r.cells[t],s.autoResizable)},e.unformat=function(r,n,o,a){var l,s=n.colModel,c=s.formatter,d=this.p,f=s.formatoptions||{},m=s.unformat||u[c]&&u[c].unformat;if(r instanceof jQuery&&r.length>0&&(r=r[0]),d.treeGrid&&null!=r&&e(r.firstChild).hasClass("tree-wrap")&&(e(r.lastChild).hasClass("cell-wrapper")||e(r.lastChild).hasClass("cell-wrapperleaf"))&&(r=r.lastChild),s.autoResizable&&null!=r&&e(r.firstChild).hasClass(d.autoResizing.wrapperClassName)&&(r=r.firstChild),void 0!==m&&e.isFunction(m))l=m.call(this,e(r).text(),n,r);else if(void 0!==c&&"string"==typeof c){var p=e(this),h=function(e,t){return void 0!==f[t]?f[t]:i.call(p,"formatter."+e+"."+t)},g=function(e,t){var i=h(e,"thousandsSeparator").replace(/([\.\*\_\'\(\)\{\}\+\?\\])/g,"\\$1");return t.replace(new RegExp(i,"g"),"")};switch(c){case"integer":l=g("integer",e(r).text());break;case"number":l=g("number",e(r).text()).replace(h("number","decimalSeparator"),".");break;case"currency":l=e(r).text();var v=h("currency","prefix"),b=h("currency","suffix");v&&v.length&&(l=l.substr(v.length)),b&&b.length&&(l=l.substr(0,l.length-b.length)),l=g("number",l).replace(h("number","decimalSeparator"),".");break;case"checkbox":l=u.checkbox.unformat(r,n,r);break;case"select":l=e.unformat.select(r,n,o,a);break;case"actions":return"";default:l=e(r).text()}}return l=void 0!==l?l:!0===a?e(r).text():t.htmlDecode(e(r).html())},e.unformat.select=function(t,i,r,o){var a=[],l=e(t).text(),s=i.colModel;if(!0===o)return l;var c=e.extend({},s.editoptions||{},s.formatoptions||{}),u=void 0===c.separator?":":c.separator,d=void 0===c.delimiter?";":c.delimiter;if(c.value){var f,m="function"==typeof c.value?c.value():c.value,p=!0===c.multiple,h=[],g=function(e,t){if(t>0)return e};if(p&&(h=l.split(","),h=e.map(h,function(t){return e.trim(t)})),"string"==typeof m){var v,b=m.split(d),y=0;for(v=0;v<b.length;v++)if((f=b[v].split(u)).length>2&&(f[1]=e.map(f,g).join(u)),p)e.inArray(e.trim(f[1]),h)>-1&&(a[y]=f[0],y++);else if(e.trim(f[1])===e.trim(l)){a[0]=f[0];break}}else(n.isObject(m)||e.isArray(m))&&(p||(h[0]=l),a=e.map(h,function(t){var i;if(e.each(m,function(e,r){if(r===t)return i=e,!1}),void 0!==i)return i}));return a.join(", ")}return l||""},e.unformat.date=function(r,o){var a=e.extend(!0,{},i.call(e(this),"formatter.date"),t.formatter.date||{},o.formatoptions||{});return n.isEmpty(r)?"":t.parseDate.call(this,a.newformat,r,a.srcformat,a)}});
//# sourceMappingURL=jquery.fmatter.js.map