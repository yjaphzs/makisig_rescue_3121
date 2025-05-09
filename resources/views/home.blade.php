@extends('layouts.app')

@section('content')
    <div id="loading" class="tingle-modal" style="visibility: visible; opacity: 1;">
        <img src="{{ asset('images/common/loading.gif') }}" style="position: absolute; left: 0; right: 0; margin: 0 auto; top: 50%; transform: translateY(-50%); width: 60px;">
    </div>
    <div class="row">
        <div class="ctrl-row clearfix">
            <h1>Dashboard</h1>
        </div>
        <div class="data">
            <div class="data_created data-sets">
                <div class="data-sets_content">
                </div>
            </div>

            <div class="data_updated data-sets">
                <div class="data-sets_content">
                </div>
            </div>
        </div>
    </div>

    <!--<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>-->
    <script>
        $(document).ready(function(){
            
            $('#loading').css({"visibility":"hidden","opacity":"0"});
            $('#loading').html('');
                
                

            @if($data_c["total"] > 0){
                $('.data_created .data-sets_content').html('<b><span>Created Records in Last</span><br>24 hours</b><br><h1>{{ $data_c["total"] }}</h1><img src="{{ asset("images/common/line-up.png") }}">');
            }
            @else{
                $('.data_created .data-sets_content').html('<b><span>Created Records in Last</span><br>24 hours</b><br><h1>{{ $data_c["total"] }}</h1><img src="{{ asset("images/common/line-down.png") }}">');
            }
            @endif

            @if($data_c["total"] > 0){
                $('.data_updated .data-sets_content').html('<b><span>Updated Records in Last</span><br>24 hours</b><br><h1>{{ $data_u["total"] }}</h1><img src="{{ asset("images/common/line-up.png") }}">');
            }
            @else{
                $('.data_updated .data-sets_content').html('<b><span>Updated Records in Last</span><br>24 hours</b><br><h1>{{ $data_u["total"] }}</h1><img src="{{ asset("images/common/line-down.png") }}">');
            }
            @endif


        });
    </script>
@endsection
