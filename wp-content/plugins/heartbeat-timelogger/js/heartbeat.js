jQuery(document).ready( function($) {

    // Tab visibility. From https://developer.mozilla.org/en-US/docs/Web/API/Page_Visibility_API
    // Set the name of the hidden property and the change event for visibility
    var hidden, visibilityChange; 
    if (typeof document.hidden !== "undefined") { // Opera 12.10 and Firefox 18 and later support 
        hidden = "hidden";
        visibilityChange = "visibilitychange";
    } else if (typeof document.msHidden !== "undefined") {
        hidden = "msHidden";
        visibilityChange = "msvisibilitychange";
    } else if (typeof document.webkitHidden !== "undefined") {
        hidden = "webkitHidden";
        visibilityChange = "webkitvisibilitychange";
    }

    var can_send = true; // default to true...

    function handleVisibilityChange() {
        if (document[hidden]) {
            //console.log('Can send = false');
            can_send = false;
        } else {
            //console.log('Can send = true');
            can_send = true;
        }
    }

    if (typeof document.addEventListener === "undefined" || typeof document[hidden] === "undefined") {
        console.log("This requires a browser, such as Google Chrome or Firefox, that supports the Page Visibility API.");
        can_send = true; // si no soporta el api, entonces enviar datos siempre...
    } else {
        // Handle page visibility change   
        document.addEventListener(visibilityChange, handleVisibilityChange, false);
    }

    window.setInterval(function(){
        var user_id = Cookies.get('uid');
        var page_id = Cookies.get('page_id');

        console.log('PageID:',page_id, '  CAN SEND:', can_send);

        if ( can_send && page_id > 0 ) {
            jQuery.ajax({
                url : ajax_object.ajax_url,
                type : 'post',
                data : {
                    action : 'heartbeat_inc_time',
                    uid: user_id,
                    page_id : page_id
                },
                success : function( response ) {
                    //console.log('Data sent.');
                }
            });
        } // can send
    }, 60*1000);
})