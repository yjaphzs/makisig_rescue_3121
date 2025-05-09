<style>
    .content {
        display:block;
        text-align: center;
        padding: 30px 20px;
    }

    td {
        text-align: center;
    }
    table {
        margin: 0 auto;
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid #000;
        padding: 10px;
        text-align: center;
    }

    h2 {
        text-align: left;
        margin: 0;
    }
    small {
        display: block;
        text-align: left;
    }

    .title-container {
        display: -webkit-flex;
        display: flex;
    }

    .image-container {
        max-width: 60px;
        margin-right: 10px;
    }

    .image-container img {
        width: 100%;
    }

    .details-container {
        margin-left: 70px;
    }
</style>
<div class="content">
    <div class="title-container">
        <div class="image-container">
            <img src="{{ asset('images/common/logo.png') }}" alt="San Jose City Seal">
        </div>
        <div class="details-container">
            <h2>Makisig Rescue 3121</h2>
            <small>San Jose City<br>N.E. 09179329939</small>
        </div>
    </div>
    <h3>Citizens with Accidents in Year {{ $year }}</h3>
    <table>
        <thead>
            <tr>
                <th>Barangay</th>
                <th>Citizens</th>
            </tr>
        </thead>
        <tbody>
            <?php
                for($i = 0; $i < 38; $i++){
            ?>
                <tr>
                    <td>{{ $barangay[$i] }}</td>
                    <td>
                        <?php
                            for($o = 0; $o < count($citizens[$i]); $o++){
                                $data = json_encode($citizens[$i][$o][0]);
                                $data = (array)json_decode($data,true);

                                $middle_initial = "";
                                if($data["middle_initial"] != null){
                                    $middle_initial = $data["middle_initial"];
                                }
                        ?>
                            {{ $data["first_name"].' '.$middle_initial.' '.$data["last_name"] }}<br>
                        <?php
                        }
                        ?>
                    </td>
                </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</div>
