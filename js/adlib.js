// JavaScript Document

function slide_h1(div){ 
	speed1=types1=links1=images1
	if (!document.images) return
	if(h1[2][types1]=='I'){
		if(h1[1][images1].substr(0,7)=="uploads")
			document.getElementById(div).innerHTML ='<a href="'+urllink+h1[3][links1]+'" target="_blank"><img src="'+urlimg+h1[1][images1]+'" border=0 ></a>'
		else document.getElementById(div).innerHTML ='<a href="'+urllink+h1[3][links1]+'" target="_blank"><img src="'+h1[1][images1]+'" border=0 ></a>'
	}	
	if(h1[2][types1]=='F'){
		if(h1[1][images1].substr(0,7)=="uploads")
	 		document.getElementById(div).innerHTML = '<a href="'+urllink+h1[3][links1]+'" target="_blank"><embed src="'+urlimg+h1[1][images1]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'
		else document.getElementById(div).innerHTML = '<a href="'+urllink+h1[3][links1]+'" target="_blank"><embed src="'+h1[1][images1]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	
	} 
	images1=(images1<h1[1].length)? images1+1 : 0
	if(h1[1].length>1)	setTimeout("slide_h1('"+div+"')",h1[0][speed1])
}

function slide_h2(div){ 
	if (!document.images) return
	speed2=types2=links2=images2
	if(h2[2][types2]=='I'){
		if(h2[1][images2].substr(0,7)=="uploads")
			document.getElementById(div).innerHTML ='<a href="'+urllink+h2[3][links2]+'" target="_blank"><img src="'+urlimg+h2[1][images2]+'" border=0 ></a>';
		else document.getElementById(div).innerHTML ='<a href="'+urllink+h2[3][links2]+'" target="_blank"><img src="'+h2[1][images2]+'" border=0 ></a>';
	}	
	if(h2[2][types2]=='F'){
		if(h2[1][images2].substr(0,7)=="uploads")
	 		document.getElementById(div).innerHTML = '<a href="'+urllink+h2[3][links2]+'" target="_blank"><embed src="'+urlimg+h2[1][images2]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>';
		else document.getElementById(div).innerHTML = '<a href="'+urllink+h2[3][links2]+'" target="_blank"><embed src="'+h2[1][images2]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	;
	} 
	images2=(images2<h2[1].length)? images2+1 : 0;
	 if(h2[1].length>1)	setTimeout("slide_h2('"+div+"')",h2[0][speed2]);
}
function slide_h3(div){ 
	if (!h3) return false 
	if (!document.images) return
	speed3=types3=links3=images3
	
	if(h3[2][types3]=='I'){
		if(h3[1][images3].substr(0,7)=="uploads")
			document.getElementById(div).innerHTML ='<a href="'+urllink+h3[3][links3]+'" target="_blank"><img src="'+urlimg+h3[1][images3]+'" border=0 ></a>'
		else document.getElementById(div).innerHTML ='<a href="'+urllink+h3[3][links3]+'" target="_blank"><img src="'+h3[1][images3]+'" border=0 ></a>'
	}	
	if(h3[2][types3]=='F'){
		if(h3[1][images3].substr(0,7)=="uploads")
	 		document.getElementById(div).innerHTML = '<a href="'+urllink+h3[3][links3]+'" target="_blank"><embed src="'+urlimg+h3[1][images3]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'
		else document.getElementById(div).innerHTML = '<a href="'+urllink+h3[3][links3]+'" target="_blank"><embed src="'+h3[1][images3]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	
	} 
	
	images3=(images3<h3[1].length)? images3+1 : 0
	if(h3[1].length>1)		setTimeout("slide_h3('"+div+"')",h3[0][speed3])
}
function slide_h4(div){ 
	speed4=types4=links4=images4
	if (!document.images) return
	if(h4[2][types4]=='I'){
		if(h4[1][images4].substr(0,7)=="uploads")
			document.getElementById(div).innerHTML ='<a href="'+urllink+h4[3][links4]+'" target="_blank"><img src="'+urlimg+h4[1][images4]+'" border=0 ></a>'
		else document.getElementById(div).innerHTML ='<a href="'+urllink+h4[3][links4]+'" target="_blank"><img src="'+h4[1][images4]+'" border=0 ></a>'
	}	
	if(h4[2][types4]=='F'){
		if(h4[1][images4].substr(0,7)=="uploads")
	 		document.getElementById(div).innerHTML = '<a href="'+urllink+h4[3][links4]+'" target="_blank"><embed src="'+urlimg+h4[1][images4]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'
		else document.getElementById(div).innerHTML = '<a href="'+urllink+h4[3][links4]+'" target="_blank"><embed src="'+h4[1][images4]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	
	} 
	images4=(images4<h4[1].length)? images4+1 : 0
	if(h4[1].length>1)	setTimeout("slide_h4('"+div+"')",h4[0][speed4])
}

function slide_h5(div){ 
	if (!document.images) return
	speed5=types5=links5=images5
	if(h5[2][types5]=='I'){
		if(h5[1][images5].substr(0,7)=="uploads")
			document.getElementById(div).innerHTML ='<a href="'+urllink+h5[3][links5]+'" target="_blank"><img src="'+urlimg+h5[1][images5]+'" border=0 ></a>';
		else document.getElementById(div).innerHTML ='<a href="'+urllink+h5[3][links5]+'" target="_blank"><img src="'+h5[1][images5]+'" border=0 ></a>';
	}	
	if(h5[2][types5]=='F'){
		if(h5[1][images5].substr(0,7)=="uploads")
	 		document.getElementById(div).innerHTML = '<a href="'+urllink+h5[3][links5]+'" target="_blank"><embed src="'+urlimg+h5[1][images5]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>';
		else document.getElementById(div).innerHTML = '<a href="'+urllink+h5[3][links5]+'" target="_blank"><embed src="'+h5[1][images5]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	;
	} 
	images5=(images5<h5[1].length)? images5+1 : 0;
	 if(h5[1].length>1)	setTimeout("slide_h5('"+div+"')",h5[0][speed5]);
}
function slide_h6(div){ 
	if (!document.images) return
	speed6=types6=links6=images6
	
	if(h6[2][types6]=='I'){
		if(h6[1][images6].substr(0,7)=="uploads")
			document.getElementById(div).innerHTML ='<a href="'+urllink+h6[3][links6]+'" target="_blank"><img src="'+urlimg+h6[1][images6]+'" border=0 ></a>'
		else document.getElementById(div).innerHTML ='<a href="'+urllink+h6[3][links6]+'" target="_blank"><img src="'+h6[1][images6]+'" border=0 ></a>'
	}	
	if(h6[2][types6]=='F'){
		if(h6[1][images6].substr(0,7)=="uploads")
	 		document.getElementById(div).innerHTML = '<a href="'+urllink+h6[3][links6]+'" target="_blank"><embed src="'+urlimg+h6[1][images6]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'
		else document.getElementById(div).innerHTML = '<a href="'+urllink+h6[3][links6]+'" target="_blank"><embed src="'+h6[1][images6]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	
	} 
	
	images6=(images6<h6[1].length)? images6+1 : 0
	if(h6[1].length>1)	setTimeout("slide_h6('"+div+"')",h6[0][speed6])
}
function slide_h7(div){ 
	speed7=types7=links7=images7
	if (!document.images) return
	if(h7[2][types7]=='I'){
		if(h7[1][images7].substr(0,7)=="uploads")
			document.getElementById(div).innerHTML ='<a href="'+urllink+h7[3][links7]+'" target="_blank"><img src="'+urlimg+h7[1][images7]+'" border=0 ></a>'
		else document.getElementById(div).innerHTML ='<a href="'+urllink+h7[3][links7]+'" target="_blank"><img src="'+h7[1][images7]+'" border=0 ></a>'
	}	
	if(h7[2][types7]=='F'){
		if(h7[1][images7].substr(0,7)=="uploads")
	 		document.getElementById(div).innerHTML = '<a href="'+urllink+h7[3][links7]+'" target="_blank"><embed src="'+urlimg+h7[1][images7]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'
		else document.getElementById(div).innerHTML = '<a href="'+urllink+h7[3][links7]+'" target="_blank"><embed src="'+h7[1][images7]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	
	} 
	images7=(images7<h7[1].length)? images7+1 : 0
	if(h7[1].length>1)	setTimeout("slide_h7('"+div+"')",h7[0][speed7])
}

function slide_h8(div){ 
	if (!document.images) return
	speed8=types8=links8=images8
	if(h8[2][types8]=='I'){
		if(h8[1][images8].substr(0,7)=="uploads")
			document.getElementById(div).innerHTML ='<a href="'+urllink+h8[3][links8]+'" target="_blank"><img src="'+urlimg+h8[1][images8]+'" border=0 ></a>';
		else document.getElementById(div).innerHTML ='<a href="'+urllink+h8[3][links8]+'" target="_blank"><img src="'+h8[1][images8]+'" border=0 ></a>';
	}	
	if(h8[2][types8]=='F'){
		if(h8[1][images8].substr(0,7)=="uploads")
	 		document.getElementById(div).innerHTML = '<a href="'+urllink+h8[3][links8]+'" target="_blank"><embed src="'+urlimg+h8[1][images8]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>';
		else document.getElementById(div).innerHTML = '<a href="'+urllink+h8[3][links8]+'" target="_blank"><embed src="'+h8[1][images8]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	;
	} 
	images8=(images8<h8[1].length)? images8+1 : 0;
	 if(h8[1].length>1)	setTimeout("slide_h8('"+div+"')",h8[0][speed8]);
}
function slide_h9(div){ 
	if (!document.images) return
	speed9=types9=links9=images9
	
	if(h9[2][types9]=='I'){
		if(h9[1][images9].substr(0,7)=="uploads")
			document.getElementById(div).innerHTML ='<a href="'+urllink+h9[3][links9]+'" target="_blank"><img src="'+urlimg+h9[1][images9]+'" border=0 ></a>'
		else document.getElementById(div).innerHTML ='<a href="'+urllink+h9[3][links9]+'" target="_blank"><img src="'+h9[1][images9]+'" border=0 ></a>'
	}	
	if(h9[2][types9]=='F'){
		if(h9[1][images9].substr(0,7)=="uploads")
	 		document.getElementById(div).innerHTML = '<a href="'+urllink+h9[3][links9]+'" target="_blank"><embed src="'+urlimg+h9[1][images9]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'
		else document.getElementById(div).innerHTML = '<a href="'+urllink+h9[3][links9]+'" target="_blank"><embed src="'+h9[1][images9]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	
	} 
	
	images9=(images9<h9[1].length)? images9+1 : 0
	if(h9[1].length>1)	setTimeout("slide_h9('"+div+"')",h9[0][speed9])
}
function slide_h10(div){ 
	speed10=types10=links10=images10
	if (!document.images) return
	if(h10[2][types10]=='I'){
		if(h10[1][images10].substr(0,7)=="uploads")
			document.getElementById(div).innerHTML ='<a href="'+urllink+h10[3][links10]+'" target="_blank"><img src="'+urlimg+h10[1][images10]+'" border=0 ></a>'
		else document.getElementById(div).innerHTML ='<a href="'+urllink+h10[3][links10]+'" target="_blank"><img src="'+h10[1][images10]+'" border=0 ></a>'
	}	
	if(h10[2][types10]=='F'){
		if(h10[1][images10].substr(0,7)=="uploads")
	 		document.getElementById(div).innerHTML = '<a href="'+urllink+h10[3][links10]+'" target="_blank"><embed src="'+urlimg+h10[1][images10]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'
		else document.getElementById(div).innerHTML = '<a href="'+urllink+h10[3][links10]+'" target="_blank"><embed src="'+h10[1][images10]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	
	} 
	images10=(images10<h10[1].length)? images10+1 : 0
	if(h10[1].length>1)	setTimeout("slide_h10('"+div+"')",h10[0][speed10])
}

function slide_h11(div){ 
	if (!document.images) return
	speed11=types11=links11=images11
	if(h11[2][types11]=='I'){
		if(h11[1][images11].substr(0,7)=="uploads")
			document.getElementById(div).innerHTML ='<a href="'+urllink+h11[3][links11]+'" target="_blank"><img src="'+urlimg+h11[1][images11]+'" border=0 ></a>';
		else document.getElementById(div).innerHTML ='<a href="'+urllink+h11[3][links11]+'" target="_blank"><img src="'+h11[1][images11]+'" border=0 ></a>';
	}	
	if(h11[2][types11]=='F'){
		if(h11[1][images11].substr(0,7)=="uploads")
	 		document.getElementById(div).innerHTML = '<a href="'+urllink+h11[3][links11]+'" target="_blank"><embed src="'+urlimg+h11[1][images11]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>';
		else document.getElementById(div).innerHTML = '<a href="'+urllink+h11[3][links11]+'" target="_blank"><embed src="'+h11[1][images11]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	;
	} 
	images11=(images11<h11[1].length)? images11+1 : 0;
	 if(h11[1].length>1)	setTimeout("slide_h11('"+div+"')",h11[0][speed11]);
}
function slide_h12(div){ 
	if (!document.images) return
	speed12=types12=links12=images12
	
	if(h12[2][types12]=='I'){
		if(h12[1][images12].substr(0,7)=="uploads")
			document.getElementById(div).innerHTML ='<a href="'+urllink+h12[3][links12]+'" target="_blank"><img src="'+urlimg+h12[1][images12]+'" border=0 ></a>'
		else document.getElementById(div).innerHTML ='<a href="'+urllink+h12[3][links12]+'" target="_blank"><img src="'+h12[1][images12]+'" border=0 ></a>'
	}	
	if(h12[2][types12]=='F'){
		if(h12[1][images12].substr(0,7)=="uploads")
	 		document.getElementById(div).innerHTML = '<a href="'+urllink+h12[3][links12]+'" target="_blank"><embed src="'+urlimg+h12[1][images12]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'
		else document.getElementById(div).innerHTML = '<a href="'+urllink+h12[3][links12]+'" target="_blank"><embed src="'+h12[1][images12]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	
	} 
	
	images12=(images12<h12[1].length)? images12+1 : 0
	if(h12[1].length>1)	setTimeout("slide_h12('"+div+"')",h12[0][speed12])
}
function slide_h13(div){ 
	if (!document.images) return
	speed13=types13=links13=images13
	if(h13[2][types13]=='I'){
		if(h13[1][images13].substr(0,7)=="uploads")
			document.getElementById(div).innerHTML ='<a href="'+urllink+h13[3][links13]+'" target="_blank"><img src="'+urlimg+h13[1][images13]+'" border=0 ></a>';
		else document.getElementById(div).innerHTML ='<a href="'+urllink+h13[3][links13]+'" target="_blank"><img src="'+h13[1][images13]+'" border=0 ></a>';
	}	
	if(h13[2][types13]=='F'){
		if(h13[1][images13].substr(0,7)=="uploads")
	 		document.getElementById(div).innerHTML = '<a href="'+urllink+h13[3][links13]+'" target="_blank"><embed src="'+urlimg+h13[1][images13]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>';
		else document.getElementById(div).innerHTML = '<a href="'+urllink+h13[3][links13]+'" target="_blank"><embed src="'+h13[1][images13]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	;
	} 
	images13=(images13<h13[1].length)? images13+1 : 0;
	 if(h13[1].length>1)	setTimeout("slide_h13('"+div+"')",h13[0][speed13]);
}
function slide_h14(div){ 
	if (!document.images) return
	speed14=types14=links14=images14
	
	if(h14[2][types14]=='I'){
		if(h14[1][images14].substr(0,7)=="uploads")
			document.getElementById(div).innerHTML ='<a href="'+urllink+h14[3][links14]+'" target="_blank"><img src="'+urlimg+h14[1][images14]+'" border=0 ></a>'
		else document.getElementById(div).innerHTML ='<a href="'+urllink+h14[3][links14]+'" target="_blank"><img src="'+h14[1][images14]+'" border=0 ></a>'
	}	
	if(h14[2][types14]=='F'){
		if(h14[1][images14].substr(0,7)=="uploads")
	 		document.getElementById(div).innerHTML = '<a href="'+urllink+h14[3][links14]+'" target="_blank"><embed src="'+urlimg+h14[1][images14]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'
		else document.getElementById(div).innerHTML = '<a href="'+urllink+h14[3][links14]+'" target="_blank"><embed src="'+h14[1][images14]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	
	} 
	
	images14=(images14<h14[1].length)? images14+1 : 0
	if(h14[1].length>1)	setTimeout("slide_h14('"+div+"')",h14[0][speed14])
}
function swapAd(idControl) {
 if (idControl == "h1") slide_h1("h1");
 if (idControl == "h2") slide_h2("h2");
 if (idControl == "h3") slide_h3("h3");
 if (idControl == "h4") slide_h4("h4");
 if (idControl == "h5") slide_h5("h5");
 if (idControl == "h6") slide_h6("h6");
 if (idControl == "h7") slide_h7("h7");
 if (idControl == "h8") slide_h8("h8");
 if (idControl == "h9") slide_h9("h9");
 if (idControl == "h10") slide_h10("h10");
 if (idControl == "h11") slide_h11("h11");
 if (idControl == "h12") slide_h12("h12");
 if (idControl == "h13") slide_h13("h13");
 if (idControl == "h14") slide_h14("h14");
} 