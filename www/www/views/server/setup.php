<?php $Main->privatePage(); ?>
<?php if ($Server->getServer($com, $speed) == TRUE): ?>
<div>
    <h1>Serial <small>Com server</small></h1>
    <div id="datas" class="row">
        <div class="box-center">
        <h2>Arduino says : </h2>
        <h3 id="target2"><small>Status is loading ...</small></h3>
        <button id="soff" class="btn btn-danger pull-left">Switch OFF</button>
        <button id="son" class="btn btn-primary center">Switch ON</button>
        <button id="reset" class="btn btn-success pull-right">RESET</button>
    </div>
    <div class="col-xs-12 col-lg-10 no-display">
        <span class="height"></span>
    </div>

        <div class="col-xs-12 col-lg-2 ">
            <div class="row">
                <h1>Console</h1>
                <p class="lead">Const : </p>

                <p id="target" onchange="fadeIn()">
                    Loading ...
                </p>
            </div>
        </div>
    </div>
</div>

                <script id="template2" type="x-tmpl-mustache">
                    <small> {{ status }} </small>
                </script>
                <script id="template" type="x-tmpl-mustache">
                    Temperature : {{ temp }} °C<br>
                    Light : {{ light }} %<br>
                    Voltage :  {{ voltage }} V<br>
                    Door : {{ door }} %<br>
                    Alarm status : {{ alarm }} <br>
                    Buzzer status : {{ buzzer }} <br>
                </script>
        </div>
    </body>
    <script type="text/javascript" src="/assets/js/jquery.js"></script>
    <script type="text/javascript" src="/assets/js/mustache.js"></script>
    <script type="text/javascript" src="/assets/js/app.js"></script>
    <script>
        function getSerial() {
            $.post('/class/EG_Julien/Ajax.php',{
                getData : 'true',
            }, function(data){
                var a = data.split('\n');

                if (a[4] == 1) {
                    var status = "BOARD 1 :: Alarm is currently ON";
                } else if (a[4] == 0) {
                    var status = "BOARD 1 :: iServer do nothing !";
                } else if (a[5] == 1) {
                    var status = "BOARD 1 :: Buzzer is currently ON";
                } else if (a[5] == 0) {
                    var status = "BOARD 1 :: iServer do nothing !";
                } else {
                    var status = "BOARD 1 :: An error has been detected !";
                }

                var template = $('#template').html();
                var template2 = $('#template2').html();
                Mustache.parse(template);
                Mustache.parse(template2);
                var rendered = Mustache.render(template, {temp: a[0] - 5, light: Math.round((a[1] / 5.00) * 100), voltage: a[3], door: Math.round((a[2] / 59) * 100), alarm: a[4], buzzer: a[5]});
                var rendered2 = Mustache.render(template2, {status: status});
                $("#target").html(rendered);
                $("#target2").html(rendered2);


            }, 'text');
        };

        $("#soff").click(function(e){
            e.preventDefault();
            $.post('/class/EG_Julien/Ajax.php', {
                sOff: true,
            });
        });
        $("#son").click(function(e){
            e.preventDefault();
            $.post('/class/EG_Julien/Ajax.php', {
                sOn: true,
            });
        });
        $("#reset").click(function(e){
            e.preventDefault();
            $.post('/class/EG_Julien/Ajax.php', {
                reset: true,
            });
        });
        window.setInterval(function(){getSerial()}, 1000);
        getSerial();
    </script>
</html>
<?php else: ?>

    <div class="box-center">
        <h1>Server is starting please wait !</h1>
    </div>

    <meta http-equiv="refresh" content="5">

<?php endif ?>