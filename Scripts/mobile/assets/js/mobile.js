(function($){

    var power = false;

    if (getCookie("username") != '') {
        var logged = true;
        var u = getCookie("username");
        var user = u.split(',');
    } else {
        var logged = false;
        var user = ["false", "false"];
    }


    function setCookie(name, value, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = name + "=" + value + "; " + expires;
    }

    function getCookie(name) {
        name = name + "=";
        var a = document.cookie.split(';');

        for (var i = 0; i < a.length; i++) {
            var cookie = a[i];

            while (cookie.charAt(0) == ' ') {
                cookie = cookie.substring(1);
            }

            if (cookie.indexOf(name) == 0) {
                return cookie.substring(name.length, cookie.length);
            }
        }
        return "";
    }

    function deleteCookie(name) {
        document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
    }

    function getSerial() {
        $.get('http://192.168.33.41:3000/get/json/all', function(data){
            var json_decoded = new Object();

            JSON.parse(data, function(k, v) {
                json_decoded[k] = v;
            });

            if (json_decoded['a_status'] == 1) {
                json_decoded['alarm'] = "OFF";
            } else {
                json_decoded['alarm'] = "ON";
            }

            var d = new Date();
            var mounth = d.getMonth() + 1;

            var time = d.getDate() + "/" + mounth + "/" + d.getFullYear() + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();

            if (json_decoded['green'] == 1) { green = "ON"; } else { green = "OFF"; }
            if (json_decoded['blue'] == 1) { blue = "ON"; } else { blue = "OFF"; }
            if (json_decoded['red'] == 1) { red = "ON"; } else { red = "OFF"; }
            if (json_decoded['white'] == 1) { white = "ON"; } else { white = "OFF"; }

            var template = $('#template').html();
            Mustache.parse(template);
            var rendered = Mustache.render(template, {temp: json_decoded['degrees'] - 5, light: Math.round((json_decoded['light'] / 5.00) * 100), voltage: json_decoded['tension'], door: Math.round((json_decoded['door'] / 59) * 100), alarm: json_decoded['a_status'], buzzer: json_decoded['b_status'], user : user[1], alarm_state : json_decoded['alarm'], blue : blue, white : white, green : green, red : red, time : time});
            $("#target2").html($('#template').html());
            $("#target2").html(rendered);

            if (json_decoded['b_status'] == 1) {
                $.get('http://192.168.33.41:3000/post/data/' + user[3] + '/adec::true$');
                $('#soff').hide();
                $('#son').hide();
            } else {
                $.get('http://192.168.33.41:3000/post/data/' + user[3] + '/adec::false$');
                $('#soff').hide();
                $('#son').show();
            }

            $("#soff").click(function(e){
                e.preventDefault();
                $.get('http://192.168.33.41:3000/post/data/' + user[3] + '/alarm::off$');
            });

            $("#son").click(function(e){
                e.preventDefault();
                $.get('http://192.168.33.41:3000/post/data/' + user[3] + '/alarm::on$');
            });

            $("#reset").click(function(e){
                e.preventDefault();
                $.get('http://192.168.33.41:3000/post/data/' + user[3] + '/reset$');
            });

            $("#blue").click(function(e){
                e.preventDefault();
                if (json_decoded['blue'] == 1) {
                    $.get('http://192.168.33.41:3000/post/data/' + user[3] + '/bleu::off$');
                } else {
                    $.get('http://192.168.33.41:3000/post/data/' + user[3] + '/bleu::on$');
                }
            });

            $("#green").click(function(e){
                e.preventDefault();
                if (json_decoded['green'] == 1) {
                    $.get('http://192.168.33.41:3000/post/data/' + user[3] + '/vert::off$');
                } else {
                    $.get('http://192.168.33.41:3000/post/data/' + user[3] + '/vert::on$');
                }
            });

            $("#red").click(function(e){
                e.preventDefault();
                if (json_decoded['red'] == 1) {
                    $.get('http://192.168.33.41:3000/post/data/' + user[3] + '/rouge::off$');
                } else {
                    $.get('http://192.168.33.41:3000/post/data/' + user[3] + '/rouge::on$');
                }
            });

            $("#white").click(function(e){
                e.preventDefault();
                if (json_decoded['white'] == 1) {
                    $.get('http://192.168.33.41:3000/post/data/' + user[3] + '/blanc::off$');
                } else {
                    $.get('http://192.168.33.41:3000/post/data/' + user[3] + '/blanc::on$');
                }
            });

            $("#logout").click(function(e){
                e.preventDefault();
                deleteCookie("username");
                deleteCookie("password");
                logged = false;

                location.reload();
            });
        }, 'text');
    };



    $("#target2").hide();


    if (logged != true) {
        $("#login").click(function(e){
        e.preventDefault();
        var password = $("#password").val();
        $.post('/class/EG_Julien/Ajax.php', {
            login: password
        }, function(result){
            var u = result.split('\n');
            if (u[0] == "false") {
                var template = $('#loading').html();
                Mustache.parse(template);
                var rendered = Mustache.render(template, {result: "Your password is not right !"});
                $('#target').html(rendered);
            } else {
                $('#log').remove();
                $("#target2").show();
                logged = true;
                user = u;
                getSerial();
                setCookie("username", user, "2");
            }
        });
        });
    } else {
        $('#log').remove();
        $("#target2").show();
        getSerial();
    }

    window.setInterval(function() { getSerial() }, 1000);

})(jQuery);