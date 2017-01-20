(function($){

    var $server = '192.168.33.41:3000';

    function sha1 (str) {

        // original by: Webtoolkit.info (http://www.webtoolkit.info/)
        // improved by: Michael White (http://getsprink.com)
        // improved by: Kevin van Zonneveld (http://kvz.io)
        //   returns 1: '54916d2e62f65b3afa6e192e6a601cdbe5cb5897'

        var hash
        try {
            var crypto = require('crypto')
            var sha1sum = crypto.createHash('sha1')
            sha1sum.update(str)
            hash = sha1sum.digest('hex')
        } catch (e) {
            hash = undefined
        }

        if (hash !== undefined) {
            return hash
        }

        var _rotLeft = function (n, s) {
            var t4 = (n << s) | (n >>> (32 - s))
            return t4
        }

        var _cvtHex = function (val) {
            var str = ''
            var i
            var v

            for (i = 7; i >= 0; i--) {
                v = (val >>> (i * 4)) & 0x0f
                str += v.toString(16)
            }
            return str
        }

        var blockstart
        var i, j
        var W = new Array(80)
        var H0 = 0x67452301
        var H1 = 0xEFCDAB89
        var H2 = 0x98BADCFE
        var H3 = 0x10325476
        var H4 = 0xC3D2E1F0
        var A, B, C, D, E
        var temp

        // utf8_encode
        str = unescape(encodeURIComponent(str))
        var strLen = str.length

        var wordArray = []
        for (i = 0; i < strLen - 3; i += 4) {
            j = str.charCodeAt(i) << 24 |
                str.charCodeAt(i + 1) << 16 |
                str.charCodeAt(i + 2) << 8 |
                str.charCodeAt(i + 3)
            wordArray.push(j)
        }

        switch (strLen % 4) {
            case 0:
                i = 0x080000000
                break
            case 1:
                i = str.charCodeAt(strLen - 1) << 24 | 0x0800000
                break
            case 2:
                i = str.charCodeAt(strLen - 2) << 24 | str.charCodeAt(strLen - 1) << 16 | 0x08000
                break
            case 3:
                i = str.charCodeAt(strLen - 3) << 24 |
                    str.charCodeAt(strLen - 2) << 16 |
                    str.charCodeAt(strLen - 1) <<
                    8 | 0x80
                break
        }

        wordArray.push(i)

        while ((wordArray.length % 16) !== 14) {
            wordArray.push(0)
        }

        wordArray.push(strLen >>> 29)
        wordArray.push((strLen << 3) & 0x0ffffffff)

        for (blockstart = 0; blockstart < wordArray.length; blockstart += 16) {
            for (i = 0; i < 16; i++) {
                W[i] = wordArray[blockstart + i]
            }
            for (i = 16; i <= 79; i++) {
                W[i] = _rotLeft(W[i - 3] ^ W[i - 8] ^ W[i - 14] ^ W[i - 16], 1)
            }

            A = H0
            B = H1
            C = H2
            D = H3
            E = H4

            for (i = 0; i <= 19; i++) {
                temp = (_rotLeft(A, 5) + ((B & C) | (~B & D)) + E + W[i] + 0x5A827999) & 0x0ffffffff
                E = D
                D = C
                C = _rotLeft(B, 30)
                B = A
                A = temp
            }

            for (i = 20; i <= 39; i++) {
                temp = (_rotLeft(A, 5) + (B ^ C ^ D) + E + W[i] + 0x6ED9EBA1) & 0x0ffffffff
                E = D
                D = C
                C = _rotLeft(B, 30)
                B = A
                A = temp
            }

            for (i = 40; i <= 59; i++) {
                temp = (_rotLeft(A, 5) + ((B & C) | (B & D) | (C & D)) + E + W[i] + 0x8F1BBCDC) & 0x0ffffffff
                E = D
                D = C
                C = _rotLeft(B, 30)
                B = A
                A = temp
            }

            for (i = 60; i <= 79; i++) {
                temp = (_rotLeft(A, 5) + (B ^ C ^ D) + E + W[i] + 0xCA62C1D6) & 0x0ffffffff
                E = D
                D = C
                C = _rotLeft(B, 30)
                B = A
                A = temp
            }

            H0 = (H0 + A) & 0x0ffffffff
            H1 = (H1 + B) & 0x0ffffffff
            H2 = (H2 + C) & 0x0ffffffff
            H3 = (H3 + D) & 0x0ffffffff
            H4 = (H4 + E) & 0x0ffffffff
        }

        temp = _cvtHex(H0) + _cvtHex(H1) + _cvtHex(H2) + _cvtHex(H3) + _cvtHex(H4)
        return temp.toLowerCase()
    }

    var power = false;

    if (getCookie("username") != '') {
        var logged = true;
        var u = getCookie("username");
        $.get('http://' + $server + '/get/auth/' + u, function(result){
            var u = JSON.parse(result);
            if (u['id'] == undefined) {
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
            }
        });
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
        $.get('http://' + $server + '/get/json/all', function(data){
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
            var rendered = Mustache.render(template, {temp: json_decoded['degrees'] - 5, inttemp: json_decoded['intdegrees'], light: (json_decoded['light']), voltage: json_decoded['tension'], door: Math.round((json_decoded['door'] / 59) * 100), alarm: json_decoded['a_status'], buzzer: json_decoded['b_status'], user : user['login'], alarm_state : json_decoded['alarm'], blue : blue, white : white, green : green, red : red, time : time});
            $("#target2").html($('#template').html());
            $("#target2").html(rendered);

            if (json_decoded['b_status'] == 1) {
                $.get('http://' + $server + '/post/data/' + user['password'] + '/adec::true$');
                $('#soff').hide();
                $('#son').hide();
            } else {
                $.get('http://' + $server + '/post/data/' + user['password'] + '/adec::false$');
                $('#soff').hide();
                $('#son').show();
            }

            $("#soff").click(function(e){
                e.preventDefault();
                $.get('http://' + $server + '/post/data/' + user['password'] + '/alarm::off$');
            });

            $("#son").click(function(e){
                e.preventDefault();
                $.get('http://' + $server + '/post/data/' + user['password'] + '/alarm::on$');
            });

            $("#reset").click(function(e){
                e.preventDefault();
                $.get('http://' + $server + '/post/data/' + user['password'] + '/reset$');
            });

            $("#blue").click(function(e){
                e.preventDefault();
                if (json_decoded['blue'] == 1) {
                    $.get('http://' + $server + '/post/data/' + user['password'] + '/bleu::off$');
                } else {
                    $.get('http://' + $server + '/post/data/' + user['password'] + '/bleu::on$');
                }
            });

            $("#green").click(function(e){
                e.preventDefault();
                if (json_decoded['green'] == 1) {
                    $.get('http://' + $server + '/post/data/' + user['password'] + '/vert::off$');
                } else {
                    $.get('http://' + $server + '/post/data/' + user['password'] + '/vert::on$');
                }
            });

            $("#red").click(function(e){
                e.preventDefault();
                if (json_decoded['red'] == 1) {
                    $.get('http://' + $server + '/post/data/' + user['password'] + '/rouge::off$');
                } else {
                    $.get('http://' + $server + '/post/data/' + user['password'] + '/rouge::on$');
                }
            });

            $("#white").click(function(e){
                e.preventDefault();
                if (json_decoded['white'] == 1) {
                    $.get('http://' + $server + '/post/data/' + user['password'] + '/blanc::off$');
                } else {
                    $.get('http://' + $server + '/post/data/' + user['password'] + '/blanc::on$');
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
        $.get('http://' + $server + '/get/auth/' + sha1(password), function(result){
            var u = JSON.parse(result);
            if (u['login'] == undefined) {
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
                setCookie("username", user['password'], "2");
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