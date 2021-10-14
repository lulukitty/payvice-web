
var xmlHttp = createXmlHttpRequestObject(); // stores the reference to the XMLHttpRequest object
// retrieves the XMLHttpRequest object
function createXmlHttpRequestObject() {
  // will store the reference to the XMLHttpRequest object
  var xmlHttp;
  // if running Internet Explorer
  if (window.ActiveXObject) {
    try {
      xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (e) {
      xmlHttp = false;
    }
  } else {
    // if running Mozilla or other browsers
    try {
      xmlHttp = new XMLHttpRequest();
    } catch (e) {
      xmlHttp = false;
    }
  }
  // return the created object or display an error message
  if (!xmlHttp) alert("Error creating the XMLHttpRequest object.");
  else return xmlHttp;
}


function AutoRefresh(t) {
  setTimeout(function () {
    document.location.reload(false);
  }, t);
}

/**
 *
 * @param {formid} fid
 * @param {page (Url to submit to) } page
 * @param {spinnerText} spintext
 * @param {next (Next Popup Panel) } next
 * @param {response container} contid
 * @param {boolean - reload opt} reload
 * @param {call-back (not needed when reload is true)} cb
 * @param {data} xdata
 */
function submit_form(fid, page, spintext, contid, next, reload, xdata) {
    var form = document.getElementById(fid);
    var formData = new FormData(form);
    
    if (xdata) {
      for (var i = 0, len = xdata.length; i < len; i++) {
        formData.append("xdata[" + i + "]", xdata[i]);
      }
    }
    var container = $("#" + contid);
    container.html(
      '<h6 class="text-center" ><i class="fa fa-spin fa-spinner"></i> ' + spintext + '</h6>'
    );
    
    xmlHttp.open("POST", page);
    xmlHttp.onreadystatechange = function () {
      if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
          var response = xmlHttp.responseText;
          var jsonObj = JSON.parse(response);
          var status = jsonObj.status;
          var data = jsonObj.data;
          var message = jsonObj.message;
          container.html(data);
          if (status == true) {
              toastr["success"](data)
                if(next != false){
                  $('.'+fid).hide();
                  $('.showdisappear').fadeOut('fast');
                  $('#' + next).fadeIn('fast', function(){
                    $('#' + next).html(data);
                  });
                }
                if(reload == true){
                    AutoRefresh(1000);
                }
          } else {
            toastr["error"](data)
          }
      }
    };
    xmlHttp.send(formData);
  }

/**
 * This function handles ajax calls for files
 * @param {formid} fid
 * @param {page} page
 * @param {response container} contid
 * @param {boolean - reload opt} reload
 * @param {call-back (not needed when reload is true)} cb
 * @param {data} xdata
 */
function submit_form_with_file(fid, page, contid, reload, cb, xdata) {
  var form = document.getElementById(fid);
  var formData = new FormData(form);
  if (xdata) {
    for (var i = 0, len = xdata.length; i < len; i++) {
      formData.append("xdata[" + i + "]", xdata[i]);
    }
  }
  var container = $("#" + contid);
  container.html(
    '<h6 class="text-center" ><img src="/images/loading.gif" width="40px" /> <br/> Please Wait</h6>'
  );
  xmlHttp.open("POST", page);
  xmlHttp.onreadystatechange = function () {
    if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
      var response = xmlHttp.responseText;
        var data = response;
        container.html(data);
          //AutoRefresh(800);
    }
  };
  xmlHttp.send(formData);
}

function submit_multi_form(fclass, page, contid, reload) {
  var formData = new FormData();
  $('.application').each(function (i) {
    var data = new FormData(this);
    var formValues = data.entries()
    while (!(ent = formValues.next()).done) {
      formData.append(`${ent.value[0]}`, ent.value[1])
    }
  })
  var container = $("#" + contid);
  container.html(
    '<h6 class="text-center" ><img src="/images/loading.gif" width="40px" /> <br/> Please Wait</h6>'
  );
  xmlHttp.open("POST", page);
  xmlHttp.onreadystatechange = function () {
    if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
      var response = xmlHttp.responseText;
      if (reload === false) {
        if (cb) {
          var jsonObj = JSON.parse(response);
          return cb(jsonObj);
        } else {
          container.html(response);
        }
      } else {
        var jsonObj = JSON.parse(response);
        var status = jsonObj.status;
        var data = jsonObj.data;
        container.html(data);
        if (status == "success") {
          AutoRefresh(800);
        }
      }
    }
  };
  xmlHttp.send(formData);
}

function deletes(id, url) {
  formData = new FormData();
  formData.append("id", id);
  xmlHttp.open("POST", url);
  xmlHttp.onreadystatechange = function () {
    if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
      var response = xmlHttp.responseText;
      var jsonObj = JSON.parse(response);
      if (jsonObj.value) {
        swal("Deleted!", {
          icon: "success"
        });
        AutoRefresh(1300);
      } else {
        swal("Unable to delete!", {
          icon: "error"
        });
      }
    }
  };
  xmlHttp.send(formData);
}

function deleteField(id, url) {
  formData = new FormData();
  formData.append("id", id);
  xmlHttp.open("GET", url);
  xmlHttp.onreadystatechange = function () {
    if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
      var response = xmlHttp.responseText;
      var jsonObj = JSON.parse(response);
    }
  };
  xmlHttp.send(formData);
}

function updateField(url, id, data) {
  var formdata = new FormData();
  formdata.append("id", id);
  formdata.append("data", data);
  xmlHttp.open("POST", url);
  xmlHttp.onreadystatechange = function () {
    if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
      var response = xmlHttp.responseText;
      swal(response);
    }
  };+
  xmlHttp.send(formdata);
}

function updateDom(url, domId, spinnerText) {
  $("#" + domId).html(
    '<h6 class="text-center" ><i class="fa fa-spin fa-spinner"></i> ' + spinnerText + '</h6>'
  );
  xmlHttp.open("GET", url);
  xmlHttp.onreadystatechange = function () {
    if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
      $("#" + domId).html(xmlHttp.responseText);
    }
  };
  xmlHttp.send(null);
}

function makeRequest(url, domId, method, xData) {
  alert("i am here");
  $("#" + domId).html(
    '<h2 style="padding:50px;text-align:center; margin:30px; background:#fff;">Loading... <br> <img width="48"  src="/images/loading.gif" /> </h2>'
  );
  var formData = new FormData();
  var formValues = data.entries()
  while (!(ent = formValues.next()).done) {
    formData.append(`${ent.value[0]}`, ent.value[1])
  }

  xmlHttp.open(method, url);
  xmlHttp.onreadystatechange = function () {
    if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
      $("#" + domId).html(xmlHttp.responseText);
    }
  };
  xmlHttp.send(formData);
}

function inputImagePreview(input, imgId) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $("#" + imgId).attr("src", e.target.result);
    };
    reader.readAsDataURL(input.files[0]);
  }
}


/**
 * @param {formid} fid 
 * @param {page} page 
 * @param {response container} contid 
 * @param {boolean - reload opt} reload 
 * @param {call-back (not needed when reload is true)} cb 
 * @param {data} xdata 
 */
function submit_formdata(fid, page, contid, reload, cb, xdata) {
  var form = document.getElementById(fid);
  var formData = new FormData(form);
  if (xdata) {
    for (var i = 0, len = xdata.length; i < len; i++) {
      formData.append("xdata[" + i + "]", xdata[i]);
    }
  }
  var container = $("#" + contid);
  container.html(
    '<h6 class="text-center" ><i class="fa fa-spin fa-spinner"></i> Sending Details.. might take a while.. Relax </h6>'
  );
  xmlHttp.open("POST", page);
  xmlHttp.onreadystatechange = function () {
    if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
      var response = xmlHttp.responseText;
      if (reload == false) {
        if (cb) {
          var jsonObj = JSON.parse(response);
          return cb(jsonObj);
        } else {
          container.html(response);
        }
      } else {
        var jsonObj = JSON.parse(response);
        var status = jsonObj.status;
        var data = jsonObj.data;
        var message = jsonObj.message;
        container.html(data);
        if (status == "success") {
           //AutoRefresh(1000);
        }
      }
    }
  };
  xmlHttp.send(formData);
}