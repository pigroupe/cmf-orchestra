xtnv=document,xtsdi="http://logc259.at.pagesjaunes.fr",xtsd=(parseInt($(window).innerWidth())>720)?"http://log526427":"http://log526426",xtsite=(parseInt($(window).innerWidth())>720)?"526427":"526426",xtpage="",xtn2="",xt_cr="";!(function(){if(parseInt($(window).innerWidth())<=720){$("html").addClass("mobile").removeClass("desktop")}else{$("html").removeClass("mobile").addClass("desktop")}if(typeof String.prototype.trim!=="function"){String.prototype.trim=function(){return this.replace(/^\s+|\s+$/g,"")}}})();function mapTags(){xtpage="plan";xt_multc="&x8=&x9=&x10=&stc=";sendTags(xtpage,xtsdi,xt_multc)}function majBrowserTags(){xtpage="browser_update";sendTags(xtpage,xtsdi,xt_multc)}function error404Tags(){xtpage="error_404";sendTags(xtpage,xtsdi,xt_multc)}function error500Tags(){xtpage="error_500";sendTags(xtpage,xtsdi,xt_multc)}function sendTags(a,f,d,e){$("#tagLink").attr("href","http://www.xiti.com/xiti.asp?s="+xtsite);$("#tagLink").attr("href",f+"?s="+xtsite);if(e=="page"){window.Xt_param="xtsite="+xtsite+"&xtpage="+a+"&x1="+a+d;$("#tags").empty().append('<noscript>Mesure d\'audience ROI statistique webanalytics par <img width="1" height="1" src="'+f+"?s="+xtsite+"&xtpage="+a+"&x1="+a+d+'" alt="WebAnalytics"/></noscript>')}else{window.Xt_param="xtsite="+xtsite+d}Xt_i='<img width="0" height="0" border="0" alt="" src="'+f+"?"+Xt_param;$('<iframe id="tagFrame" src=""></iframe>').appendTo($("body"));var c=$("#tagFrame")[0];var b=c.contentWindow?c.contentWindow:c.contentDocument.defaultView;b.document.write(Xt_i+'" title="Internet Audience"/>');setTimeout(function(){$("#tagFrame").remove()},500);d=""};