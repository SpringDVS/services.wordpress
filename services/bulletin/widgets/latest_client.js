
var SdvsBulletinsLatestCli = {
    request: function(network, gateway) {
        uri = network+"/bulletin/";
        uri = uri.replace(/\./g, "%2E");
        var $j = jQuery.noConflict();
        //$j('#sdvs-bulletins-latest-uri').text('URI: spring://'+url+'/bulletins/');
        console.log("http://"+gateway+"/gateway/bulletin/?__req="+uri);
        $j.ajax({
            type: "GET",
            url: "http://"+gateway+"/gateway/bulletin/?__req="+uri,
            async: false,
            jsonpCallback: "recvBulletins",
            dataType: "jsonp",
            success: function(json) {
            },
            error: function(e) {
            }
            }
        );       
    },
    
    apply: function(bulletins) {
        
        var $j = jQuery.noConflict();
    
        for(var index in bulletins) {
            console.log(index);
            console.dir(bulletins[index]);
        }
    }
}

recvBulletins = function (data) {
    if(data.service == "error"){ console.log("Service Error"); return; }
    if(data.status != "ok"){ console.log("Service Error"); console.log(data.uri); return; }
    SdvsBulletinsLatestCli.apply(data.content);
}