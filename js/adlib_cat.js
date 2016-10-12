// JavaScript Document

function slide_c1(div){
	speed1=types1=links1=images1
	if (!document.images) return
	if(c1[4][images1] ==  url_cat)
	{
		if(c1[2][types1]=='I'){
			if(c1[1][images1].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+c1[3][links1]+'"><img src="'+urlimg+c1[1][images1]+'" border=0 ></a>'
			else document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+c1[3][links1]+'"><img src="'+c1[1][images1]+'" border=0 ></a>'
		}	
		if(c1[2][types1]=='F'){
			if(c1[1][images1].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+c1[3][links1]+'"><embed src="'+urlimg+c1[1][images1]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'
			else document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+c1[3][links1]+'"><embed src="'+c1[1][images1]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	
		}
	}
	if(c1[1].length>1)
	{
		if(c1[4][images1] ==  url_cat)
		{
				setTimeout("slide_c1('"+div+"')",c1[0][speed1])
		}else{
				setTimeout("slide_c1('"+div+"')",0)
		}
	}
	images1=(images1<c1[1].length)? images1+1 : 0	
}

function slide_c2(div){ 
	if (!document.images) return
	speed2=types2=links2=images2
	
	if(c2[4][images2] ==  url_cat)
	{
		if(c2[2][types2]=='I'){
			if(c2[1][images2].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+c2[3][links2]+'"><img src="'+urlimg+c2[1][images2]+'" border=0 ></a>';
			else document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+c2[3][links2]+'"><img src="'+c2[1][images2]+'" border=0 ></a>';
		}	
		if(c2[2][types2]=='F'){
			if(c2[1][images2].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+c2[3][links2]+'"><embed src="'+urlimg+c2[1][images2]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>';
			else document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+c2[3][links2]+'"><embed src="'+c2[1][images2]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	;
		} 
	}
	
	 if(c2[1].length>1)	
	 {
		if(c2[4][images2] ==  url_cat)
		{ 
			setTimeout("slide_c2('"+div+"')",c2[0][speed2]);
		}else{
			setTimeout("slide_c2('"+div+"')",0);
		}
	}
	images2=(images2<c2[1].length)? images2+1 : 0;
}
function slide_c3(div){ 

	if (!document.images) return
	speed3=types3=links3=images3
	if(c3[4][images3] ==  url_cat)
	{
		if(c3[2][types3]=='I'){
			if(c3[1][images3].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+c3[3][links3]+'"><img src="'+urlimg+c3[1][images3]+'" border=0 ></a>'
			else document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+c3[3][links3]+'"><img src="'+c3[1][images3]+'" border=0 ></a>'
		}	
		if(c3[2][types3]=='F'){
			if(c3[1][images3].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+c3[3][links3]+'"><embed src="'+urlimg+c3[1][images3]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'
			else document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+c3[3][links3]+'"><embed src="'+c3[1][images3]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	
		} 
	}
	
	if(c3[1].length>1)		
	{
		if(c3[4][images3] ==  url_cat)
		{
			setTimeout("slide_c3('"+div+"')",c3[0][speed3])
		}else{
			setTimeout("slide_c3('"+div+"')",0)
		}
	}
	images3=(images3<c3[1].length)? images3+1 : 0
}

function slide_c4(div){ 
	speed4=types4=links4=images4
	if (!document.images) return
	
	if(c4[4][images4] ==  url_cat)
	{
		if(c4[2][types4]=='I'){
			if(c4[1][images4].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+c4[3][links4]+'"><img src="'+urlimg+c4[1][images4]+'" border=0 ></a>'
			else document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+c4[3][links4]+'"><img src="'+c4[1][images4]+'" border=0 ></a>'
		}	
		if(c4[2][types4]=='F'){
			if(c4[1][images4].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+c4[3][links4]+'"><embed src="'+urlimg+c4[1][images4]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'
			else document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+c4[3][links4]+'"><embed src="'+c4[1][images4]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	
		} 
	}
	
	if(c4[1].length>1)
	{
		if(c4[4][images4] ==  url_cat)
		{
			setTimeout("slide_c4('"+div+"')",c4[0][speed4])
		}else{
			setTimeout("slide_c4('"+div+"')",0)
		}
	}
	images4=(images4<c4[1].length)? images4+1 : 0
}
function slide_c5(div){ 
	if (!document.images) return
	speed5=types5=links5=images5
	if(c5[4][images5] ==  url_cat)
	{
		if(c5[2][types5]=='I'){
			if(c5[1][images5].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+c5[3][links5]+'"><img src="'+urlimg+c5[1][images5]+'" border=0 ></a>';
			else document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+c5[3][links5]+'"><img src="'+c5[1][images5]+'" border=0 ></a>';
		}	
		if(c5[2][types5]=='F'){
			if(c5[1][images5].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+c5[3][links5]+'"><embed src="'+urlimg+c5[1][images5]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>';
			else document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+c5[3][links5]+'"><embed src="'+c5[1][images5]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	;
		} 
	}
	
	 if(c5[1].length>1)	
	 {
		if(c5[4][images5] ==  url_cat)
		{
			setTimeout("slide_c5('"+div+"')",c5[0][speed5])
		}else{
			setTimeout("slide_c5('"+div+"')",0);
		}
	}
	images5=(images5<c5[1].length)? images5+1 : 0
}
function slide_c6(div){ 
	if (!document.images) return
	speed6=types6=links6=images6
	if(c6[4][images6] ==  url_cat)
	{
		if(c6[2][types6]=='I'){
			if(c6[1][images6].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+c6[3][links6]+'"><img src="'+urlimg+c6[1][images6]+'" border=0 ></a>'
			else document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+c6[3][links6]+'"><img src="'+c6[1][images6]+'" border=0 ></a>'
		}	
		if(c6[2][types6]=='F'){
			if(c6[1][images6].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+c6[3][links6]+'"><embed src="'+urlimg+c6[1][images6]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'
			else document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+c6[3][links6]+'"><embed src="'+c6[1][images6]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	
		} 
	}
	
	if(c6[1].length>1)	
	{
		if(c6[4][images6] ==  url_cat)
		{
			setTimeout("slide_c6('"+div+"')",c6[0][speed6])
		}else{
			setTimeout("slide_c6('"+div+"')",0)
		}
	}
	images6=(images6<c6[1].length)? images6+1 : 0
}
function slide_c7(div){ 
	speed7=types7=links7=images7
	if (!document.images) return
	if(c7[4][images7] ==  url_cat)
	{
		if(c7[2][types7]=='I'){
			if(c7[1][images7].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+c7[3][links7]+'"><img src="'+urlimg+c7[1][images7]+'" border=0 ></a>'
			else document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+c7[3][links7]+'"><img src="'+c7[1][images7]+'" border=0 ></a>'
		}	
		if(c7[2][types7]=='F'){
			if(c7[1][images7].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+c7[3][links7]+'"><embed src="'+urlimg+c7[1][images7]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'
			else document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+c7[3][links7]+'"><embed src="'+c7[1][images7]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	
		} 
	}
	
	if(c7[1].length>1)	setTimeout("slide_c7('"+div+"')",c7[0][speed7])
	{
		if(c7[4][images7] ==  url_cat)
		{
			setTimeout("slide_c7('"+div+"')",c7[0][speed7])
		}else{
			setTimeout("slide_c7('"+div+"')",0)
		}
	}
	images7=(images7<c7[1].length)? images7+1 : 0
}

function slide_c8(div){ 
	if (!document.images) return
	speed8=types8=links8=images8
	if(c8[4][images8] ==  url_cat)
	{
		if(c8[2][types8]=='I'){
			if(c8[1][images8].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+c8[3][links8]+'"><img src="'+urlimg+c8[1][images8]+'" border=0 ></a>';
			else document.getElementById(div).innerHTML ='<a target="_blank" href="'+urllink+c8[3][links8]+'"><img src="'+c8[1][images8]+'" border=0 ></a>';
		}	
		if(c8[2][types8]=='F'){
			if(c8[1][images8].substr(0,7)=="uploads")
				document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+c8[3][links8]+'"><embed src="'+urlimg+c8[1][images8]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>';
			else document.getElementById(div).innerHTML = '<a target="_blank" href="'+urllink+c8[3][links8]+'"><embed src="'+c8[1][images8]+'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent" ></embed></a>'	;
		} 
	}
	
	 if(c8[1].length>1)	
	 {
		if(c8[4][images8] ==  url_cat)
		{
			setTimeout("slide_c8('"+div+"')",c8[0][speed8])
		}else{
			setTimeout("slide_c8('"+div+"')",0);
		}
	}
	images8=(images8<c8[1].length)? images8+1 : 0
}

function swapAd(idControl) {
 if (idControl == "c1" ) slide_c1("c1");
 if (idControl == "c2") slide_c2("c2");
 if (idControl == "c3") slide_c3("c3");
 if (idControl == "c4") slide_c4("c4");
 if (idControl == "c5") slide_c5("c5");
 if (idControl == "c6") slide_c6("c6");
 if (idControl == "c7") slide_c7("c7");
 if (idControl == "c8") slide_c8("c8");

} 