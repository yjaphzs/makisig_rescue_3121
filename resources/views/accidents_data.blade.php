            <table>
                <thead>
                    <tr>
                        <th>
                            <!-- <input id="bulk_checkbox" type="checkbox"> -->
                        </th>
                        <th>
                            <!-- <button id="bulk_delete"><span class="fa fa-trash"></span></button> -->
                        </th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                         <th style="overflow-x: inherit;">
                            <button class="dropdown">
                                <span class="fa fa-filter"></span>
                                <span class="fa fa-angle-down"></span>
                                <div class="drawer" style="bottom: -120px;">
                                    <a href="" value="date">Date</a>
                                    <a href="" value="time">Time</a>
                                    <a href="" value="place">Place</a>
                                    <a href="" value="accident">Accident</a>
                                </div>
                            </button>
                        </th>
                    </tr>
                    <tr>
                        <th></th>
                        <th>Date</th>
                        <th style="/*transform: translateX(-28px);*/">Time</th>
                        <th style="/*transform: translateX(-50px);*/">Place of Incident</th>
                        <th style="/*transform: translateX(-42px);*/">Type of Accident</th>
                        <th style="/*transform: translateX(-33px);*/">Person/s Involved</th>
                        <th style="/*transform: translateX(-25px);*/">Remarks</th>
                        <th style="/*transform: translateX(-20px);*/">Responders</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="content">
                    @foreach($data as $row)
                    <tr>
                        <td>
                           <input class="incidentCheckbox" name="citizen_checkbox[]" type="checkbox" value="{{ $row['id'] }}">
                        </td>
                        <td style="/*width: 80px;*/">{{ $row['date'] }}</td>
                        <td style="/*width: 85px;*/">{{ $row['time'] }}</td>
                        <?php  $place = explode(", -",$row['place']);
                            if($place[0] == null){
                                $place_f = $place[1];
                            }
                            else{
                                $place_f = $place[0].', '.$place[1];
                            }
                        ?>
                        <td>{{ $place_f }}</td>
                        <td>{{ $row['accident'] }}</td>
                        <?php
                            $name = "";
                            $ids = json_decode($row['involves']);
                            $counter = 0;
                            foreach($ids as $id){
                                foreach($data2 as $row2){
                                    if($id == $row2['id']){
                                        if( $counter == count( $ids ) - 1) {
                                            $name .= $row2['first_name'].' '.$row2['last_name'];
                                        }
                                        else{
                                            $name .= $row2['first_name'].' '.$row2['last_name'].', ';
                                        }
                                    }
                                }
                                $counter = $counter + 1;
                            }

                        ?>
                        <td>{{ $name }}</td>
                        <?php
                            $name = "";
                            $ids = json_decode($row['responders']);
                            $numItems = count($ids);
                            $counter = 0;
                            foreach($ids as $id){
                                foreach($data3 as $row3){
                                    if($id == $row3['id']){
                                        if( $counter == count( $ids ) - 1) {
                                            $name .= $row3['first_name'].' '.$row3['last_name'];
                                        }
                                        else{
                                            $name .= $row3['first_name'].' '.$row3['last_name'].', ';
                                        }
                                    }
                                }
                                $counter = $counter + 1;
                            }

                        ?>
                        <td>{{ $row['remarks'] }}</td>
                        <td>{{ $name }}</td>
                        <td>
                            <button id="{{ $row['id'] }}" class="viewButton tooltip"><span class="fa fa-eye"></span><span class="tooltiptext">View</span></button>
                            <button id="{{ $row['id'] }}" class="editButton tooltip"><span class="fa fa-edit"></span><span class="tooltiptext">Edit</span></button>
                            <!--
                                <button id="{{ $row['id'] }}" class="deleteButton"><span class="fa fa-trash-alt"></span></button>
                            -->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        {{ $data->onEachSide(1)->links() }}
