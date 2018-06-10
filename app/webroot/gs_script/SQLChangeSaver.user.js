// ==UserScript==
// @name        SQLChangeSaver
// @namespace   http://localhost/adminer.php*
// @include     http://localhost/adminer.php*
// @version     1
// @grant       none
// ==/UserScript==
// a function that loads jQuery and calls a callback function when jQuery has finished loading
function addJQuery(callback) {
    var script = document.createElement("script");
    script.setAttribute("src", "//code.jquery.com/jquery-3.3.1.min.js");
    script.addEventListener('load', function() {
        var script = document.createElement("script");
        script.textContent = "window.jQ=jQuery.noConflict(true);(" + callback.toString() + ")();";
        document.body.appendChild(script);
    }, false);
    document.body.appendChild(script);
}

// the guts of this userscript
function main() {
    // Note, jQ replaces $ to avoid conflicts.
    var msg = jQ('div .message');
    if (msg.length || 1) {
        jQ('<a id="savetotracker-link" href="#">&nbsp;Save to SQL change tracker</a>').insertAfter( /*msg.first().children("a:last")*/ jQ('#breadcrumb'));
        jQ('#savetotracker-link').attr('href', msg.first().children("a:last").attr('href'));
        jQ('#savetotracker-link').click(function() {
            var sql = '';
            if (msg.first().children("div:first").children("pre").length != 0) {
                // alters outputs SQL after the message
                sql = msg.first().children("div:first").children("pre").text();
            } else {
                // raw SQL queries outouts before
                sql = msg.first().siblings("pre").text();
            }

            if (sql == '') {
                alert('Woot!! Unable to find sql query on the page! Report errors to the developers\nSave the current page DOM with Firebug for reporting! Thanks!');
            } else {
                var masterDatabase = "";
                if (jQ('#dbs').children('select').first().length)
                    masterDatabase = jQ('#dbs').children('select').first().val();
                else // sqlite database
                    masterDatabase = jQ('#dbs').children('input[name=db]').val();

                var postData = {
                    'SqlChange': {
                        'masterDatabase': masterDatabase,
                        'sql': sql
                    }
                };

                jQ.ajax({
                    type: "POST",
                    url: "http://localhost/sql_change_tracker/sql_changes/add_sql_change.json",
                    // The key needs to match your method's input parameter (case-sensitive).
                    data: JSON.stringify(postData),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function(data) {
                        if (data == "ok") {
                            alert('Sql change saved ok!');
                        } else {
                            alert('Sql change save failed: ' + data);
                        }
                    },
                    failure: function(errMsg) {
                        alert('Sql change save failed: ' + errMsg);
                    }
                });
            }
        });
    }
}

// load jQuery and execute the main function
addJQuery(main);
