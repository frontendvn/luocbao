// JavaScript Document

function slide_d1(div){
	speed1=types1=links1=images1
	if (!document.images) return
	if(d1[4][images1] ==  url_cat)
	{
		if(d1[2][types1]=='I'){
			if(d1[1][images1].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+d1[3][links1]+'"><img src="'+urlimg+d1[1][images1]+'" border=0 ></a>'
			else document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+d1[3][links1]+'"><img src="'+d1[1][images1]+'" border=0 ></a>'
		}	
		if(d1[2][types1]=='F'){
			if(d1[1][images1].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+d1[3][links1]+'"><embed src="'+urlimg+d1[1][images1]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'
			else document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+d1[3][links1]+'"><embed src="'+d1[1][images1]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	
		}
	}
	if(d1[1].length>1)
	{
		if(d1[4][images1] ==  url_cat)
		{
				setTimeout("slide_d1('"+div+"')",d1[0][speed1])
		}else{
				setTimeout("slide_d1('"+div+"')",0)
		}
	}
	images1=(images1<d1[1].length)? images1+1 : 0	
		
}

function slide_d2(div){ 
	if (!document.images) return
	speed2=types2=links2=images2
	if(d2[4][images2] ==  url_cat)
	{
		if(d2[2][types2]=='I'){
			if(d2[1][images2].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+d2[3][links2]+'"><img src="'+urlimg+d2[1][images2]+'" border=0 ></a>';
			else document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+d2[3][links2]+'"><img src="'+d2[1][images2]+'" border=0 ></a>';
		}	
		if(d2[2][types2]=='F'){
			if(d2[1][images2].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+d2[3][links2]+'"><embed src="'+urlimg+d2[1][images2]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>';
			else document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+d2[3][links2]+'"><embed src="'+d2[1][images2]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	;
		} 
	}
	 if(d2[1].length>1)	
	 {
		if(d2[4][images2] ==  url_cat)
		{ 
			setTimeout("slide_d2('"+div+"')",d2[0][speed2])
		}else{
			setTimeout("slide_d2('"+div+"')",0)
		}
	}
	images2=(images2<d2[1].length)? images2+1 : 0
}
function slide_d3(div){ 
	if (!document.images) return
	speed3=types3=links3=images3
	if(d3[4][images3] ==  url_cat)
	{
		if(d3[2][types3]=='I'){
			if(d3[1][images3].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+d3[3][links3]+'"><img src="'+urlimg+d3[1][images3]+'" border=0 ></a>'
			else document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+d3[3][links3]+'"><img src="'+d3[1][images3]+'" border=0 ></a>'
		}	
		if(d3[2][types3]=='F'){
			if(d3[1][images3].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+d3[3][links3]+'"><embed src="'+urlimg+d3[1][images3]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'
			else document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+d3[3][links3]+'"><embed src="'+d3[1][images3]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	
		} 
	}
	if(d3[1].length>1)		
	{
		if(d3[4][images3] ==  url_cat)
		{
			setTimeout("slide_d3('"+div+"')",d3[0][speed3])
		}else{
			setTimeout("slide_d3('"+div+"')",0)
		}
	}
	images3=(images3<d3[1].length)? images3+1 : 0
}
function slide_d4(div){ 
	speed4=types4=links4=images4
	if (!document.images) return
	if(d4[4][images4] ==  url_cat)
	{
		if(d4[2][types4]=='I'){
			if(d4[1][images4].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+d4[3][links4]+'"><img src="'+urlimg+d4[1][images4]+'" border=0 ></a>'
			else document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+d4[3][links4]+'"><img src="'+d4[1][images4]+'" border=0 ></a>'
		}	
		if(d4[2][types4]=='F'){
			if(d4[1][images4].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+d4[3][links4]+'"><embed src="'+urlimg+d4[1][images4]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'
			else document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+d4[3][links4]+'"><embed src="'+d4[1][images4]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	
		} 
	}
	if(d4[1].length>1)
	{
		if(d4[4][images4] ==  url_cat)
		{
			setTimeout("slide_d4('"+div+"')",d4[0][speed4])
		}else{
			setTimeout("slide_d4('"+div+"')",0)
		}
	}
	images4=(images4<d4[1].length)? images4+1 : 0
}

function slide_d5(div){ 
	if (!document.images) return
	speed5=types5=links5=images5
	if(d5[4][images5] ==  url_cat)
	{
		if(d5[2][types5]=='I'){
			if(d5[1][images5].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+d5[3][links5]+'"><img src="'+urlimg+d5[1][images5]+'" border=0 ></a>';
			else document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+d5[3][links5]+'"><img src="'+d5[1][images5]+'" border=0 ></a>';
		}	
		if(d5[2][types5]=='F'){
			if(d5[1][images5].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+d5[3][links5]+'"><embed src="'+urlimg+d5[1][images5]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>';
			else document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+d5[3][links5]+'"><embed src="'+d5[1][images5]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	;
		} 
	}
	if(d5[1].length>1)	
	 {
		if(d5[4][images5] ==  url_cat)
		{
			setTimeout("slide_d5('"+div+"')",d5[0][speed5])
		}else{
			setTimeout("slide_d5('"+div+"')",0)
		}
	}
	images5=(images5<d5[1].length)? images5+1 : 0
}
function slide_d6(div){ 
	if (!document.images) return
	speed6=types6=links6=images6
	if(d6[4][images6] ==  url_cat)
	{
		if(d6[2][types6]=='I'){
			if(d6[1][images6].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+d6[3][links6]+'"><img src="'+urlimg+d6[1][images6]+'" border=0 ></a>'
			else document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+d6[3][links6]+'"><img src="'+d6[1][images6]+'" border=0 ></a>'
		}	
		if(d6[2][types6]=='F'){
			if(d6[1][images6].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+d6[3][links6]+'"><embed src="'+urlimg+d6[1][images6]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'
			else document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+d6[3][links6]+'"><embed src="'+d6[1][images6]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	
		} 
	}
	if(d6[1].length>1)	
	{
		if(d6[4][images6] ==  url_cat)
		{
			setTimeout("slide_d6('"+div+"')",d6[0][speed6])
		}else{
			setTimeout("slide_d6('"+div+"')",0)
		}
	}
	images6=(images6<d6[1].length)? images6+1 : 0
}
function slide_d7(div){ 
	speed7=types7=links7=images7
	if (!document.images) return
	if(d7[4][images7] ==  url_cat)
	{
		if(d7[2][types7]=='I'){
			if(d7[1][images7].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+d7[3][links7]+'"><img src="'+urlimg+d7[1][images7]+'" border=0 ></a>'
			else document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+d7[3][links7]+'"><img src="'+d7[1][images7]+'" border=0 ></a>'
		}	
		if(d7[2][types7]=='F'){
			if(d7[1][images7].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+d7[3][links7]+'"><embed src="'+urlimg+d7[1][images7]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'
			else document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+d7[3][links7]+'"><embed src="'+d7[1][images7]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	
		} 
	}
	if(d7[1].length>1)	setTimeout("slide_d7('"+div+"')",d7[0][speed7])
	{
		if(d7[4][images7] ==  url_cat)
		{
			setTimeout("slide_d7('"+div+"')",d7[0][speed7])
		}else{
			setTimeout("slide_d7('"+div+"')",0)
		}
	}
	images7=(images7<d7[1].length)? images7+1 : 0
}

function slide_d8(div){ 
	if (!document.images) return
	speed8=types8=links8=images8
	if(d8[4][images8] ==  url_cat)
	{
		if(d8[2][types8]=='I'){
			if(d8[1][images8].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+d8[3][links8]+'"><img src="'+urlimg+d8[1][images8]+'" border=0 ></a>';
			else document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+d8[3][links8]+'"><img src="'+d8[1][images8]+'" border=0 ></a>';
		}	
		if(d8[2][types8]=='F'){
			if(d8[1][images8].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+d8[3][links8]+'"><embed src="'+urlimg+d8[1][images8]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>';
			else document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+d8[3][links8]+'"><embed src="'+d8[1][images8]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	;
		} 
	}
	if(d8[1].length>1)	
	 {
		if(d8[4][images8] ==  url_cat)
		{
			setTimeout("slide_d8('"+div+"')",d8[0][speed8])
		}else{
			setTimeout("slide_d8('"+div+"')",0);
		}
	}
	images8=(images8<d8[1].length)? images8+1 : 0
}
function slide_d9(div){ 
	if (!document.images) return
	speed9=types9=links9=images9
	if(d9[4][images9] ==  url_cat)
	{
		if(d9[2][types9]=='I'){
			if(d9[1][images9].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+d9[3][links9]+'"><img src="'+urlimg+d9[1][images9]+'" border=0 ></a>'
			else document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+d9[3][links9]+'"><img src="'+d9[1][images9]+'" border=0 ></a>'
		}	
		if(d9[2][types9]=='F'){
			if(d9[1][images9].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+d9[3][links9]+'"><embed src="'+urlimg+d9[1][images9]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'
			else document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+d9[3][links9]+'"><embed src="'+d9[1][images9]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	
		} 
	}
	if(d9[1].length>1)	
	 {
		if(d9[4][images9] ==  url_cat)
		{
			setTimeout("slide_d9('"+div+"')",d9[0][speed9])
		}else{
			setTimeout("slide_d9('"+div+"')",0);
		}
	}
	images9=(images9<d9[1].length)? images9+1 : 0
}
function slide_d10(div){ 
	speed10=types10=links10=images10
	if (!document.images) return
	if(d10[4][images10] ==  url_cat)
	{
		if(d10[2][types10]=='I'){
			if(d10[1][images10].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+d10[3][links10]+'"><img src="'+urlimg+d10[1][images10]+'" border=0 ></a>'
			else document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+d10[3][links10]+'"><img src="'+d10[1][images10]+'" border=0 ></a>'
		}	
		if(d10[2][types10]=='F'){
			if(d10[1][images10].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+d10[3][links10]+'"><embed src="'+urlimg+d10[1][images10]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'
			else document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+d10[3][links10]+'"><embed src="'+d10[1][images10]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	
		} 
	}
	if(d10[1].length>1)	
	 {
		if(d10[4][images10] ==  url_cat)
		{
			setTimeout("slide_d10('"+div+"')",d10[0][speed10])
		}else{
			setTimeout("slide_d10('"+div+"')",0);
		}
	}
	images10=(images10<d10[1].length)? images10+1 : 0
}

function swapAd(idControl) {
 if (idControl == "d1" ) slide_d1("d1");
 if (idControl == "d2") slide_d2("d2");
 if (idControl == "d3") slide_d3("d3");
 if (idControl == "d4") slide_d4("d4");
 if (idControl == "d5") slide_d5("d5");
 if (idControl == "d6") slide_d6("d6");
 if (idControl == "d7") slide_d7("d7");
 if (idControl == "d8") slide_d8("d8");
 if (idControl == "d9") slide_d9("d9");
 if (idControl == "d10") slide_d1("d10");
} 