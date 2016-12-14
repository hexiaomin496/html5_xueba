$(function(){	
	
	var oPic = $('.bookcon').find('ul');
	var oImg = oPic.find('li');
	var oLen = oImg.length;
	var oLi = oImg.width();
	var prev = $(".buttonleft");
	var next = $(".buttonright");
//计算总长度
	oPic.width(oLen*110);
	var iNow = 0;
	var iTimer = null;
	prev.click(function(){	
		if(iNow>0){
			iNow--;
		}
		ClickScroll();
	})

	next.click(function(){
		if(iNow<oLen-6){	
			iNow++;
		}
		ClickScroll();
	})
	function ClickScroll(){	

		oPic.animate({left:-iNow*105});
	}
})