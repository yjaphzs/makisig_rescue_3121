@extends('layouts.app')

@section('content')
    <div id="loading" class="tingle-modal"></div>
    <div class="row">
        <div class="ctrl-row clearfix">
            <h1>Messages</h1>
        </div>
        <form method="post" id="messageForm">
            {{ csrf_field() }}
            <div class="message">
                <div id="phone-input" class="input-group">
                    <span class="fa fa-address-book  icon"></span>
                    <input id="phone_number" name="phone_number" class="input" type="text" placeholder="Phone number" autocomplete="off" minlength="11" maxlength="11" required>
                    <label class="switch">
                      <input id="switch" type="checkbox">
                      <span class="slider round"></span>
                    </label>
                    <label class="label">
                        Specific number
                    </label>
                </div>
                <div id="message-input" class="input-group">
                    <span class="fa fa-comment-dots icon"></span>
                    <textarea placeholder="Message..." name="message" required></textarea>
                </div>
            </div>
            <div class="ctrl-row clearfix">
                <button type="submit" name="submit" id="send_message">Send Message</button>
        </div>
        </form>
    </div>

    <script src="https://www.gstatic.com/firebasejs/5.8.6/firebase.js"></script>
    <script>
        var config = {
            apiKey: "AIzaSyCYxz5sy1bNU7lBniHKd1HMaQnitdILkL4",
            authDomain: "makisigrescue3121.firebaseapp.com",
            databaseURL: "https://makisigrescue3121.firebaseio.com",
            projectId: "makisigrescue3121",
            storageBucket: "makisigrescue3121.appspot.com",
            messagingSenderId: "89496200536"
        };
        firebase.initializeApp(config);
    </script>

    <!--<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>-->
    <script>
         $(document).ready(function(){
            var rootRef = firebase.database().ref().child("Accounts");
            var phones = [];

            rootRef.once('value', snap => {
                snap.forEach(item => {
                    phones.push(item.child("Phone").val());
                });

                console.log(phones);
            });

            (function($) {
              $.fn.inputFilter = function(inputFilter) {
                return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
                  if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                  } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                  }
                });
              };
            }(jQuery));

            $("#phone_number").inputFilter(function(value) {
                return /^\d*$/.test(value);
            });

            $('#messageForm').on('submit', function(event){
                event.preventDefault();

                $('body').addClass("tingle-enabled");
                $('#loading').css({"visibility":"visible","opacity":"1"});
                $('#loading').html('<img src="{{ asset('images/common/loading.gif') }}" style="position: absolute; left: 0; right: 0; margin: 0 auto; top: 50%; transform: translateY(-50%); width: 60px;">');

                var form_data = $(this).serializeArray();
                $("#messageForm :input").prop("disabled", true);

                alertify
                    .alert("Sending message....", function(){

                }).set('closable', false);

                $(".ajs-header").html("SMS");
                $(".ajs-button").css("display", "none");

                if ($("#switch").is(':checked')){


                    form_data.push({ name: "phone", value: phones });


                    $.ajax({
                        url:"{{ route('messages.allsms') }}",
                        method: "GET",
                        data: form_data,
                        success:function(data){
                            document.getElementById("messageForm").reset();
                            alertify.message('<span class="fa fa-check-square  success-icon"></span>&nbsp&nbsp&nbsp&nbspMessage Sent!.');
                            $("#messageForm :input").prop("disabled", false);
                            $(".ajs-button").css("display", "inline-block");
                            $('#loading').css({"visibility":"hidden","opacity":"0"});
                                $('#loading').html('');

                            alertify.alert().destroy();
                        }
                    });

                }
                else{
                    $.ajax({
                        url:"{{ route('messages.sendsms') }}",
                        method: "POST",
                        data: form_data,
                        success:function(data){
                            document.getElementById("messageForm").reset();
                            alertify.message('<span class="fa fa-check-square  success-icon"></span>&nbsp&nbsp&nbsp&nbspMessage Sent!.');
                            $("#messageForm :input").prop("disabled", false);
                            $(".ajs-button").css("display", "inline-block");
                            $('#loading').css({"visibility":"hidden","opacity":"0"});
                                $('#loading').html('');

                            alertify.alert().destroy();
                        }
                    });
                }
            });

            if ($("#switch").is(':checked')){
                $('#phone_number').prop("disabled", true);
                $('#phone_number').val("All");
                $('.label').html("All mobile users");
            }
            else{
                $('#phone_number').prop("disabled", false);
                $('#phone_number').val("");
                $('.label').html("Specific number");
            }

            $('#switch').click(function(){

                if($(this).is(":checked")){
                    $('#phone_number').prop("disabled", true);
                    $('#phone_number').val("All");
                    $('.label').html("All mobile users");
                }

                else if($(this).is(":not(:checked)")){
                    $('#phone_number').prop("disabled", false);
                    $('#phone_number').val("");
                    $('.label').html("Specific number");
                }

            });
            /*
            $('#test').on('click', function(event){

                var rootRef = firebase.database().ref().child("Phones");
                const phones = [];

                rootRef.once('value', snap => {
                    snap.forEach(item => {
                        phones.push(item.child("Phone").val());
                    });
                });
                console.log(phones);
                /*
                $.ajax({
                    url:" route('messages.getphones') }}",
                    method: "GET",
                    success:function(data){
                        var json = JSON.parse(data);
                        console.log(json[0].slRP3pICR8SSirxoE1x4EqnKk5n1.Phone);
                    }
                });
            });*/
         });
    </script>
@endsection
