/**
 * Created by Sergii on 12.03.2016.
 */

function request(url, method, data, success)
{
    var params = {
        cache: false,
        method: method,
        dataType: 'json',
        contentType: "application/json"

    }
    if (data) {
        params.data = JSON.stringify(data);
    }

    $.ajax(url, params)
        .done( function(data) {
            if (success) {
                success(data);
            }
        }).fail(function( jqXHR, textStatus, errorThrown ) {
            console.log(textStatus+' '+errorThrown);
        })
}

function addDevice()
{
    var data = {
        "device": {
            "devicetype": $("#device_devicetype").val(),
            "name": $("#device_name").val(),
            "description": $("#device_description").val()
        }
    };
    return request("/api/v1/devices.json", 'POST', data, function(){
        location.href = "/listdevices"
    });
}
function removeDevice(id)
{
    return request("/api/v1/devices/"+id, "DELETE", null, function(){
        location.href = "/listdevices"
    })
}
function editDevice(id)
{
    var data = {
        "device": {
            "devicetype": $("#device_devicetype").val(),
            "name": $("#device_name").val(),
            "description": $("#device_description").val()
        }
    };
    return request("/api/v1/devices/"+id+"/modify", "PATCH", data, function(){
        location.href = "/listdevices"
    })
}

function addBrowserVersion()
{
    var data = {
        "browserversion": {
            "browser": $("#browserversion_browser").val(),
            "version": $("#browserversion_version").val()
        }
    };
    return request("/api/v1/browserversions", 'POST', data, function(){
        location.href = "/api/v1/browserversions/all.html"
    });
}

function editBrowserVersion(id )
{
    var data = {
        "browserversion": {
            "browser": $("#browserversion_browser").val(),
            "version": $("#browserversion_version").val()
        }
    };
    return request("/api/v1/browserversions/"+id+"/modify.json", 'PATCH', data, function(){
        location.href = "/api/v1/browserversions/all.html"
    });
}


function removeBrowserVersion(id)
{
    return request("/api/v1/browserversions/"+id, "DELETE", null, function(){
        location.href = "/api/v1/browserversions/all.html"
    })
}

function addDeviceBrowser()
{
    var data = {
        "device_browser": {
            "device": $("#device_browser_device").val(),
            "browserversion": $("#device_browser_browserversion").val()
        }
    };
    return request("/api/v1/devicebrowsers.json", 'POST', data, function(){
        location.href = "/api/v1/devicebrowsers/all.html"
    });
}
function removeDeviceBrowser(id)
{
    return request("/api/v1/devicebrowsers/"+id+".json", 'DELETE', null, function(){
        location.href = "/api/v1/devicebrowsers/all.html"
    });
}
function editDeviceBrowser(id)
{
    var data = {
        "device_browser": {
            "device": $("#device_browser_device").val(),
            "browserversion": $("#device_browser_browserversion").val()
        }
    };
    return request("/api/v1/devicebrowsers/"+id+"/modify.json", 'PATCH', data, function(){
        location.href = "/api/v1/devicebrowsers/all.html"
    });
}

function addBrowser()
{
    var data = {
        "browser": {
            "name": $("#browser_name").val()
        }
    };
    return request("/api/v1/browsers.json", 'POST', data, function(){
        location.href = "/api/v1/browsers/all.html"
    });
}

function editBrowser(id )
{
    var data = {
        "browser": {
            "name": $("#browser_name").val()
        }
    };
    return request("/api/v1/browsers/"+id+"/modify.json", 'PATCH', data, function(){
        location.href = "/api/v1/browsers/all.html"
    });
}
function removeBrowser(id)
{
    return request("/api/v1/browsers/"+id+".json", 'DELETE', null, function(){
        location.href = "/api/v1/browsers/all.html"
    });
}