
var SdvsBulletinsLatestCli = {
    gateway: "",
    network: "",
    request: function(network, gateway, query) {
        SdvsBulletinsLatestCli.gateway = gateway;
        SdvsBulletinsLatestCli.network = network;
        uri = network+"/bulletin/";
        
        query = query == "" ? "" : "&"+query;
        uri = uri.replace(/\./g, "%2E");
        console.log(uri);
        var $j = jQuery.noConflict();
        $j('#spring-bulletin-loader').show();
        $j.ajax({
            type: "GET",
            url: "http://"+gateway+"/gateway/bulletin/?__req="+uri+query,
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
    
    rerequest: function(query) {
        tag = query == "" ? "none" : query;
        var $j = jQuery.noConflict();
        $j("#sdvs-bulletin-list-filter").text(tag);
        query = query == "" ? "" : "tags="+query;
        SdvsBulletinsLatestCli.request(
            SdvsBulletinsLatestCli.network,
            SdvsBulletinsLatestCli.gateway,
            query
        );
        
    },
    
    requestProfile: function(node) {
        uri = node+"/orgprofile/";
        uri = uri.replace(/\./g, "%2E");

        var $j = jQuery.noConflict();
        $j('#spring-bulletin-loader').show();
        $j.ajax({
            type: "GET",
            url: "http://"+SdvsBulletinsLatestCli.gateway+"/gateway/orgprofile/?__req="+uri,
            async: false,
            jsonpCallback: "recvProfile",
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
        html = "";
        for(index in bulletins) {
            for(node in  bulletins[index]) {
                list = bulletins[index][node];
                
                list_html = "";
                for(i in list) {
                    item = list[i];
                    
                    for(ti in item.tags) {
                        tag = item.tags[ti];
                        item.tags[ti] = "<a href='javascript:void(0)' onclick='SdvsBulletinsLatestCli.rerequest(`"+tag+"`)'>" + tag +"</a>"
                    }
                    
                    list_html += ([
                        "<tr>",
                        "<td><div>" + item.title +"</div><div style='font-size: 12px'>tags: "+item.tags.join(', ')+"</div></td>",
                        "</tr>",
                    ].join('\n'));
                }
                
                eid = node.replace(/\./g, "-");
                
                html += [
                    "<tr><td class='node-uri'>",
                    "<a href='javascript:void(0);' onclick='SdvsBulletinsLatestCli.requestProfile(`"+node+"`)'>"+node+"</a> &rsaquo;&rsaquo;",
                    "</td></tr>",
                    "<tr id='"+eid+"-profile'class='profile-view'><td>",
                    "</td></tr>",
                    "<tr><td><table class='inner'><tbody>"+list_html+"</tbody></table></td></tr>",

                ].join('\n');
                
                
            }
        }
        $j("#sdvs-bulletin-list-body").empty();
        $j("#sdvs-bulletin-list-body").html(html);
        $j('#spring-bulletin-loader').hide();
    },

    applyProfile: function(profile) {
        var $j = jQuery.noConflict();
        for(index in profile) {
            for(node in profile[index]) {
                eid = node.replace(/\./g, "-");
                
                item = profile[index][node];
                html = [
                    "<div class='profile-block'>",
                    "<h3>"+item.name+"</h3>",
                    "<a target='_blank' href='"+item.website+"'>"+item.website+"</a><br>",
                    "<a class='control' href='javascript:void(0);' onclick='SdvsBulletinsLatestCli.hideProfile(`"+node+"`)'>hide</a>",
                    "</div>"
                ].join('\n');
                element = $j("#"+eid+"-profile");
                element.html(html);
                element.show();
                
            }
        }
        $j('#spring-bulletin-loader').hide();
    },
    
    hideProfile: function(node) {
        var $j = jQuery.noConflict();
         eid = node.replace(/\./g, "-");
        element = $j("#"+eid+"-profile");
        element.hide();
    }
}

recvBulletins = function (data) {
    if(data.service == "error"){ console.log("Service Error"); return; }
    if(data.status != "ok"){ console.log("Service Error"); console.log(data.uri); return; }
    SdvsBulletinsLatestCli.apply(data.content);
}

recvProfile = function (data) {
    if(data.service == "error"){ console.log("Service Error"); return; }
    if(data.status != "ok"){ console.log("Service Error"); console.log(data.uri); return; }
    SdvsBulletinsLatestCli.applyProfile(data.content);
}