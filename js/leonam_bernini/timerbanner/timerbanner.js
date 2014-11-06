function saveTimerBannerClick(obj){
    var bannerId = obj.getAttribute('data-id');
    var data    = "id_banner=" + bannerId; 
    var xmlhttp;
    try{
        xmlhttp = new XMLHttpRequest();
    }catch (e){
        try{
            xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        }catch (e) {
            try{
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }catch (e){}
        }
    }      
    xmlhttp.open("POST", URL_TIMER_BANNER, true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");  
    xmlhttp.send(data);
 }